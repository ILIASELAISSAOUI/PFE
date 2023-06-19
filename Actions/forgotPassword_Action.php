<?php

include "Actions/connectDB.php";
if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){
    header("location:signIn.php");
}
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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['submit'])){
        if (isset($_POST["email"]) && !empty($_POST["email"])){        
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            $regex_email = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
            if (!preg_match ($regex_email, $email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){  
                $Err_email = "<p>Email is not valid</p>";
            }
            else{
                $stmt = $conn->prepare("SELECT email FROM subscriber WHERE email=?");
                $stmt->execute(array($email));
                $count=$stmt->rowCount();
                if($count>0){
                    $_SESSION['email_modify_password']=$email;
                     //-------------------------------------------start "PhpMailer"-------------------------------------------------
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        $key=rand(100000,999999);
                        $_SESSION['key2']=$key;
                        
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;              //Enable verbose debug output
                        $mail->isSMTP();                                       //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                  //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                              //Enable SMTP authentication
                        $mail->Username   = 'nouriou02@gmail.com';             //SMTP username
                        $mail->Password   = 'Nour1234@';                       //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       //Enable implicit TLS encryption
                        $mail->Port       = 465;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('nouriou02@gmail.com','ilias el aissaoui');
                        $mail->addAddress($email);     //Add a recipient

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Here is the subject';
                        $mail->Body    = '<b>Here is the verification link</b> <a href="http://localhost/PFE/changePass.php?key='.$key.'"> http://localhost/PFE/changePass.php?key='.$key.'</a>';

                        $mail->send();
                        $exist='<p class="alert alert-success alert_email">Check your boite email</p>';
                    }
                    catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        $not_exist='<p class="alert alert-danger alert_email">Email not found</p>';
                    }
                }
            }
        }
    }
}

?>