<?php
session_start();
include "Actions/connectDB.php";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 //Load Composer's autoloader
require 'PHPMailer/vendor/autoload.php';

//----------------------------------------------function to validate inputs--------------------------------------------------
function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

//----------------------------------------------start collect data--------------------------------------------------
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['send'])){ 
        $errors=0;
        //validate firstname
        if(isset($_POST['firstName']) && !empty($_POST['firstName'])){
            $firstname=test_input($_POST['firstName']);
            $regex_firstname="/^[a-zA-z]*$/";
            //check if name contains only letters and whitespace
            if(!preg_match ($regex_firstname, $firstname) ) {  
                $Err_firstname = "<p>the first name is not valid<p>"; 
                $errors++;
            } 
        }

        //validate lastname
        if(isset($_POST['lastName']) && !empty($_POST['lastName'])){
            $lastname=test_input($_POST['lastName']);
            $regex_lastname='/^[a-zA-z]*$/';
            //check if name contains only letters and whitespace
            if (!preg_match ($regex_lastname, $lastname) ){  
                $Err_lastname = "<p>the last name is not valid</p>";
                $errors++;  
            }
        }

        //validate adress
        if(isset($_POST['adress']) && !empty($_POST['adress'])){
            $adress=test_input($_POST['adress']);
            $regex_adress = "/[A-Za-z0-9\-\\,.]+/";
            //chec if name contains only letters and whitespace
            if (!preg_match ($regex_adress, $adress) ) {  
                $Err_adress = "<p>Adress is not valid</p>"; 
                $errors++;
            }
        }

        //validate birthday
        if(isset($_POST['birthday']) && !empty($_POST['birthday'])){
            $birthday=$_POST['birthday'];
        }

        //validate city
        if(isset($_POST['city']) && !empty($_POST['city'])){
            $city=$_POST['city'];
        }

        //validate phone
        if(isset($_POST['phone']) && !empty($_POST['phone'])){
            $phone=test_input($_POST['phone']);
            $length = strlen ($phone); 
            $regex_phone = "/^[0-9]*$/";
            //check if name contains only letters and whitespace
            if (!preg_match ($regex_phone, $phone) || preg_match("/^[a-zA-z]*$/",$phone) || $length!=10 ) {  
                $Err_phone = "<p>phone number is not valid</p>";  
                $errors++;  
            }
        }
        //validate email
        if (!empty($_POST["email"])){        
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            $regex_email = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
            if (!preg_match ($regex_email, $email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){  
                $Err_email = "<p>Email is not valid</p>";
                $errors++; 
            }
        }
        //validate password
        if(!empty($_POST["password"])){
            $password = test_input($_POST["password"]);
            $hashedpass=sha1($password);
            if(strlen($_POST["password"])<8){
                $err_password_length="<p>password must contains more than 8 caracters</p>";
                $errors++;
            }
            if(($_POST["password"] != $_POST["cpassword"])){
                $err_cpassword="the password and the confirm password do not match";
                $errors++;
            }         
        }
        //check if all inputs are valid
        if($errors>0){
            $err_general='<p class="alert alert-danger">enter the informations correctly</p>';
        }
        else{
            //check if these infos already exist
            $stmt = $conn->prepare("SELECT email FROM subscriber WHERE email=?");
            $stmt->execute(array($email));
            $count=$stmt->rowCount();
            if($count>0){
                $err_email_used ='<p class="alert alert-danger">this email has been already used</p>';
            }else{
                //insert subscriber's information in database
                $key=rand(100000,999999);
                $_SESSION['key']=$key;
                
                //-------------------------------------------start "PhpMailer"-------------------------------------------------
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'nouriou02@gmail.com';                     //SMTP username
                    $mail->Password   = 'Nour1234@';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('iliasaissa20@gmail.com','ilias el aissaoui');
                    $mail->addAddress($email);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Here is the subject';
                    $mail->Body    = '<b>Here is the verification link</b> <a href="http://localhost/PFE3/signIn.php?key='.$key.'"> http://localhost/PFE3/signUp.php?key='.$key.'</a>';

                    $mail->send();
                    $notification='<p class="alert alert-success">check your boite email to complete your inscription<p>';
                    //----- -------------------------------------------INSERT DATA----------------------------------------------------
                    $stmt=$conn->prepare("insert into subscriber(first_name,last_name,email,city,password,vrfkey) values (?,?,?,?,?,?)");
                    $stmt->execute(array($firstname,$lastname,$email,$city,$hashedpass,$key));
                    $_SESSION['city']=$city;
                    //---------------------------------------------------------------------------------------------------------------- 

                    $sub_id=$conn->prepare("select id_subscriber from subscriber where email= ?");
                    $sub_id->execute(array($email));
                    $data =$sub_id->fetch(PDO::FETCH_ASSOC);
                    //-----------------------------------------------------------------------
                    $id=$data['id_subscriber'];
                    $stmt=$conn->prepare("insert into adresse(adress,adress_number,id_subscriber) values (?,?,?)");
                    $stmt->execute(array($adress,1,$id));
                    //----------------------------------------------------------------------
                    $adr_id=$conn->prepare("select id_adresse from adresse where id_subscriber=?");
                    $adr_id->execute(array($id));
                    $idadres =$adr_id->fetch(PDO::FETCH_ASSOC);
                    //--------------------------------------------------------------------------
                    $id_adre=$idadres['id_adresse'];
                    $stmt=$conn->prepare("update subscriber set id_adresse=? where id_subscriber=?");
                    $stmt->execute(array($id_adre,$id));
                    //--------------------------------------------------------------------------
                    $stmt=$conn->prepare("insert into phone(phone,phone_number,id_subscriber) values (?,?,?)");
                    $stmt->execute(array($phone,1,$id)); 
                    //----------------------------------------------------------------------
                    $pho_id=$conn->prepare("select id_phone from phone where id_subscriber=?");
                    $pho_id->execute(array($id));
                    $idphon =$pho_id->fetch(PDO::FETCH_ASSOC);
                    //--------------------------------------------------------------------------
                    $id_phon=$idphon['id_phone'];
                    $stmt=$conn->prepare("update subscriber set id_phone=? where id_subscriber=?");
                    $stmt->execute(array($id_phon,$id));
                } 
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        
            //-------------------------------------------end "PhpMailer"---------------------------------------------------

        }
    }
}
?>