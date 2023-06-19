<?php

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

//-------------------------------------------start "PhpMailer"-------------------------------------------------
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['send'])){
            if(isset($_POST['username']) && !empty($_POST['username'])){
                $username=$_POST['username'];
            }
            if(isset($_POST['email']) && !empty($_POST['email'])){
                $email=$_POST['email'];
            }
            if(isset($_POST['subject']) && !empty($_POST['subject'])){
                $subject=$_POST['subject'];
            }
            if(isset($_POST['body']) && !empty($_POST['body'])){
                $body=$_POST['body'];
            }
             //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try{
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
                $mail->setFrom($email,$_POST['username']);
                $mail->addAddress('iliasaissa20@gmail.com');     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = "ilias";

                $mail->send();
                echo "email has been send";
            }
            catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
        
?>