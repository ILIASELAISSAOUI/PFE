<?php 
session_start();
 include 'paypalclass.php';
 include '../Actions/connectDB.php';

file_put_contents('post.json',json_encode($_POST));
$data=json_decode(file_get_contents('post.json'));
if( $data->payer_status === 'verified' ||  $data->initial_payment_status === 'Completed'){ 
$paypal= new paypalSubs(PAYPAL_USERNAME,PAYPAL_PASSWORD,PAYPAL_SIGNATURE,getOffers());
if($paypal->verifyIPN($data)){
$payer_id=$data->payer_id;
$stmt=$conn->prepare("select profile_id ,id_subscriber from subscriber where payer_id= ?;");
$stmt->execute(array($payer_id));
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$profile_id=$dat['profile_id'];
$details=$paypal->getProfileDetail($profile_id);
$subscription_end=new DateTime($details['NEXTBILLINGDATE']);
$timezone =new DateTimeZone(date_default_timezone_get());
$subscription_end->setTimezone($timezone);
$stmt=$conn->prepare("Update subscriber set subscription_end =? where id_subscriber = ?;");
$stmt->execute(array($subscription_end->format('Y-m-d H:i:s'),$dat['id_subscriber']));
//Activity 
$stmt=$conn->prepare("select MAX(activity) as maxi FROM subscriber where id_subscriber= ?");
            $stmt->execute(array($dat['id_subscriber'])); 
            $rslt=$stmt->fetch(PDO::FETCH_ASSOC);
            $nbr=$rslt['maxi'] +1;
$stmt=$conn->prepare("Update subscriber set activity =? where id_subscriber = ?");
$stmt->execute(array($nbr,$dat['id_subscriber']));
//Orders-----------------------------------------
$price=$data->amount;
$type=$data->payment_cycle;
$date=date("Y-m-d");
$stmt=$conn->prepare("SELECT id_abonnement from abonnement where type_abonnement=?");
$stmt->execute(array($type));
$rslt=$stmt->fetch(PDO::FETCH_ASSOC);
$type=$rslt['id_abonnement'];
$stmt=$conn->prepare("INSERT INTO orders (id_subscriber,date_order,total_order,id_abonnement) values(?,?,?,?)");
$stmt->execute(array($dat['id_subscriber'],$date,$price,$type));
}
} 
?>