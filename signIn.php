<?php
session_start();
include "Includes/header.php";
include "Actions/signIn_Action.php";
?>

<section class="SignIn_section">
    <a href="home.php"><img src="Images/logo.png" class="logo" width="250px" height="50px"></a>
    <?php 
        
        if(isset($_SESSION['confirmation']) && isset($_SESSION['boucle'])){
            if($_SESSION['boucle']==0){
                echo $_SESSION['confirmation'];
                $_SESSION['boucle']=1;
            }
        }
        if(isset($_SESSION['confirmation_update']) && isset($_SESSION['boucle_changePass'])){
            if($_SESSION['boucle_changePass']==0){
                echo $_SESSION['confirmation_update'];
                $_SESSION['boucle_changePass']=1;
            }
        }
    ?>
    <?php if(isset($_POST['send'])){if(isset($err_email)){echo $err_email;}}?> 
    <?php if(isset($_POST['send'])){if(isset($err_pass)){echo $err_pass;}}?> 
    <?php if(isset($_POST['send'])){if(isset($err_verification)){echo $err_verification;}}?> 
    <?php if(isset($_POST['send'])){if(isset($stopped)){echo $stopped;}}?> 
    <div class="contenaire">
        <div class="left-side">
            <img src="Images/signIn_image.svg">
        </div>
        <div class="right-side">
            <h5>Are you a My Moroccan Box member ?</h5>
            <form action="signIn.php" method="POST">
                <div class="div_email">
                    <img src="Images/email.svg">
                    <input type="Email" name="email" class="email" placeholder="Email" >
                </div>
                <div class="div_password">
                    <img src="Images/password.svg">
                    <input type="Password" name="password" class="password" placeholder="Password">
                </div>
                    <div class="down">
                    <input type="submit" name="send" value="Sign In" class="envoyer">
                    <a href="forgotPassword.php">Lost Your Password ?</a>
                </div>
            </form>
        </div>        
    </div>
</section>

<?php include "Includes/footer.php"?>