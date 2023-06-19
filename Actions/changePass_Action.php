<?php 

session_start();
if(!isset($_SESSION['email']) || $_SESSION['verified']==1){
    header("location:signIn.php");
}

    if(isset($_GET['key']) && $_GET['key']==$_SESSION['key2']){  
        if(isset($_POST['submit'])){
            if(isset($_POST['newpassword']) && !empty($_POST['newpassword'])){
                if(strlen($_POST["newpassword"])<8){
                    $err_password_length='<p class="alert alert-danger number1">password must contains more than 8 caracters</p>';
                }else{
                    $newpass=sha1($_POST["newpassword"]);
                    $update=$conn->prepare("UPDATE subscriber SET password=? WHERE email=?");
                    $update->execute(array($newpass,$_SESSION['email_modify_password']));
                    $_SESSION['confirmation_update']='<p class="alert alert-success number2">your password has been updated successfuly</p>';
                    $_SESSION['boucle_changePass']=0;
                    header("location:signIn.php");
                }
            }        
        } 
    }


?>