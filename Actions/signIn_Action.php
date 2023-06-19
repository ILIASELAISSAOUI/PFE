<?php
include "Actions/connectDB.php";

//----------------------------------------------confirmation of subscriber's inscription--------------------------------- 
if(isset($_GET['key']) && $_GET['key']==$_SESSION['key']){
    $update=$conn->prepare("UPDATE subscriber SET verified=? WHERE vrfkey=?");
    $update->execute(array(1,$_SESSION['key']));
    $_SESSION['confirmation']='<p class="alert alert-success number2">your account has been created successfuly</p>';
    $_SESSION['boucle']=0;
}
//-----------------------------------------------------------------------------------------------------------------------
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['send'])){ 
        $email=$_POST['email'];
        $password=$_POST['password'];
        $stmt = $conn->prepare("SELECT email FROM subscriber WHERE email=?");
        $stmt->execute(array($email));
        $count=$stmt->rowCount();
        if ($count>0) {
            # emailexiste.
            $pass=$conn->prepare("SELECT id_subscriber,verified,password,is_active,isadmin FROM subscriber WHERE email=?");
            $pass->execute(array($email));
            $rslt=$pass->fetch(PDO::FETCH_ASSOC);
            //-------------------------------------------------------------------------------------------------------------
            $passw=$rslt['password'];
            $id=$rslt['id_subscriber'];
            $hashedpass=sha1($password);            
            if($passw==$hashedpass){
                #mot de pass correct
                $_SESSION['id']=$id;
                $_SESSION['email']=$email;
                $vrfd=$rslt['verified'];
                $_SESSION['verified']=$vrfd;
                if ($vrfd==1) {
                    $isadmin=$rslt['isadmin'];
                    $is_active=$rslt['is_active'];
                    if($isadmin==0){
                        header("location: nav.php?x=Account");
                    }elseif($isadmin==1 && $is_active==1){
                        header("location: admin_nav.php?x=dashboard");
                    }
                    else{
                        $stopped='<p class="alert alert-danger number2">this account is blocked</p>';
                    }
                } else {
                    $err_verification='<p class="alert alert-danger number2">your account is not verified</p>';
                }
            }else{
                #mot de pass incorrect
                $err_pass='<p class="alert alert-danger number2">It seems that your password is incorrect</p>';

            }

        } else {
            # email n'existeas 
            $err_email='<p class="alert alert-danger number2">no account with  this email</p>';
        }
    }
}
?>