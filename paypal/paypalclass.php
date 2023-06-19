<?php 
define('PAYPAL_USERNAME','sb-fi3q613466513_api1.business.example.com');
define('PAYPAL_PASSWORD','ADUFMMVM9VCHZDHT');
define('PAYPAL_SIGNATURE','AKwVSAdKHfS2rPeRpMTEQpMZppwVApiJumiBAIFqbhX8e7zvG9ru-rNd');

class paypalSubs{
    private $username;
    private $password;
    private $signature;
    private $offers;
    private $endpoint;
    private $sandbox;

    public function __construct($username,$password,$signature,$offers,$sandbox=true){

        $this->username= $username;
        $this->password= $password;
        $this->signature= $signature;
        $this->offers= $offers;
        $this->endpoint="https://api-3t.".($sandbox ? "sandbox." : "")."paypal.com/nvp";
        $this->sandbox= $sandbox;
       // echo PAYPAL_USERNAME;

    }

    public function nvp($options= []){
        $curl= curl_init();
        $data =[
            'USER' => $this->username,
            'PWD' => $this->password,
            'SIGNATURE' => $this->signature,
            'METHOD' => 'SetExpressCheckout',
            'VERSION' => 86,
        ];

        $data=array_merge($data, $options);
        
        curl_setopt_array($curl,[
            CURLOPT_URL =>$this->endpoint,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($data)

        ]);
        
        $response =curl_exec($curl);
        $responseArray=[];
        parse_str($response, $responseArray);
        return $responseArray ;

    }
    public function subscribe($offer_id){
        if(!isset($this->offers[$offer_id])){
            throw new Exception ('Cette offre nexiste pas');
        }

        $offer2 = $this->offers[$offer_id];
        $data =[
            'METHOD' => 'SetExpressCheckout',
            'PAYMENTREQUEST_0_AMT' => $offer2['price'],
            'PAYMENTREQUEST_0_ITEAMT' => $offer2['price'],
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
            'PAYMENTREQUEST_0_CUSTOM' => $offer_id,
            'L_BILLINGTYPE0' => 'RecurringPayments',
            'L_BILLINGAGREEMENTDESCRIPTION0'=> $offer2['name'], 
            'cancelUrl' => 'http://localhost/PFE3/box.php',
            'returnUrl' => 'http://localhost/PFE3/paypal/process.php',

        ];
        

        $response= $this->nvp($data);
        if(!isset($response['TOKEN'])){ 
            throw new Exception($response['L_LONGMESSAE0']);
        }
        $token = $response['TOKEN'];
        $url= "https://www.".($this->sandbox ? "sandbox." : "")."paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=$token";
        header('Location:'.$url);
    }

    public function getCheckoutDetail($token){
        $data =[
            'METHOD' => 'GetExpressCheckoutDetails',
            'TOKEN' => $token,
        ];
        return $this->nvp($data);

    }

    public function doSubscribe($token,$user_id,$conn){
        $detail= $this->getCheckoutDetail($token);
        $offer_id=$detail['PAYMENTREQUEST_0_CUSTOM'];
        if(!isset($this->offers[$offer_id])){
            throw new Exception ('Cette offre nexiste pas');
        }
        $offer=$this->offers[$offer_id];
        $period=  $offer['period']==='Month'?new DateInterval('P1M') : new DateInterval('P1Y');
        $start= (new DateTime() )-> add($period)->getTimestamp();

        $response=$this->nvp([
            'METHOD'=> 'CreateRecurringPaymentsProfile',
            'TOKEN' => $token,
            'PAYERID' => $detail['PAYERID'],
            'DESC' => $offer['name'],
            'AMT' => $offer['price'],
            'BILLINGPERIOD' =>  $offer['period'],
            'BILLINGFREQUENCY' => 1,
            'CURRENCYCODE' => 'EUR',
            'COUNTRYCODE' => 'FR',
            'MAXFAILEDPAYMENTS' => 3, 
            'PROFILESTARTDATE' => gmdate("Y-m-d\TH:i:s\Z",$start),
            'INITAMT'=> $offer['price']
        ]);
        
        if($response['ACK'] === 'Success'){
            $idpayer=$detail['PAYERID'];
            $profileid=$response['PROFILEID'];
            $stmt = $conn->prepare("UPDATE subscriber SET payer_id=? ,profile_id=?  WHERE id_subscriber=?;");
            //$q="UPDATE subscriber SET payer_id='$idpayer',profile_id='$profileid'  WHERE id_subscriber='$user_id';";
            //$conn->exec($q);
            $stmt->execute(array($idpayer,$profileid,$user_id));


           //var_dump($response,$this->getProfileDetail($response['PROFILEID']),$detail,$offer);

        }else {
            throw new Exception($response['L_LONGMESSAGE0']);
        }

    }

    public function getProfileDetail($profile_id){
       return  $this-> nvp([
            'METHOD' => 'GetRecurringPaymentsProfileDetails',
            'PROFILEID' => $profile_id
       ]);
    }


    public function verifyIPN($data){
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL =>"https://www.sandbox.paypal.com/cgi-bin-/webscr?cmd=_notify-validate&".http_build_query($data),
            CURLOPT_RETURNTRANSFER => 1,
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'))
        ]);
        $response= curl_exec($curl);
        return $response === 'VERIFIED';
    }

    public function unsubscribe($profile_id){
        $response=$this->nvp([
            'METHOD' => 'ManageRecurringPaymentsProfileStatus',
            'PROFILEID' => $profile_id,
            'ACTION' => 'Cancel'
        ]);

        if($response['ACK'] === 'Success'){
            return true ;
        }
        throw new Exception ($response['L_LONGMESSAGE0']);
    }
} 

function getOffers(){
 
    return [
      [
        'name' => 'Monthly',
        'price' => 20,
        'price_text'=> '200 ',
        'period' => 'Month'
      ],
      [
        'name' => 'Annual ',
        'price' => 200,
        'price_text'=> '2000 ',
        'period' => 'Year'
      ]
      ];
    }
?>
