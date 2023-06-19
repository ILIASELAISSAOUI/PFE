<?php 
include "Includes/header.php" ;
require "Actions/signUp_Action.php";
?>

<section class="SignUP_section">
    <img src="Images/logo.png" class="logo" width="250px" height="50px">
    <?php if(isset($_POST['send'])){if(isset($notification)){echo $notification;}}?> 
    <?php if(isset($_POST['send'])){if(isset($err_general)){echo $err_general;}}?> 
    <?php if(isset($_POST['send'])){if(isset($err_email_used)){echo $err_email_used;}}?> 
    <div class="contenaire">
        <h4>SIGN UP</h4>
        <form action="signUp.php" method="POST">
            <div class="div_firstName" <?php if(isset($_POST['send'])){if(isset($Err_firstname)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <img src="Images/firstName.svg">
                <input type="text" name="firstName" class="firstName" placeholder="First Name" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$firstname.'"';}} ?> required>
                <?php if(isset($_POST['send'])){if(isset($Err_firstname)){echo '<p>'.$Err_firstname.'.</p>';}}?>
            </div>
            <div class="div_lastName" <?php if(isset($_POST['send'])){if(isset($Err_lastname)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <input type="text" name="lastName" class="lastName" placeholder="Last Name" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$lastname.'"';}} ?> required>
                <?php if(isset($_POST['send'])){if(isset($Err_lastname)){echo '<p>'.$Err_lastname.'.</p>';}}?>
            </div>
            <div class="div_adress" <?php if(isset($_POST['send'])){if(isset($Err_adress)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <img src="Images/adress.svg">
                <input type="text" name="adress" class="adress" placeholder="Adress" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$adress.'"';}} ?> required>
                <?php if(isset($_POST['send'])){if(isset($Err_adress)){echo '<p>'.$Err_adress.'.</p>';}}?>
            </div>
            <div class="div_city">
                <select name="city" class="city" selected="Ouarzazate" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$city.'"';}} ?> required>
                    <option value="Ouarzazate">Ouarzazate</option>
                    <option value="Agadir">Agadir</option>
                    <option value="Marrakech">Marrakech</option>
                    <option value="Casablanca">Casablanca</option>
            </select>
            </div>
            <div class="div_date">
                <input type="date" name="birthday" class="date" placeholder="Date Of Birth" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$birthday.'"';}} ?> required>
            </div>
            <div class="div_phone" <?php if(isset($_POST['send'])){if(isset($Err_phone)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <img src="Images/phone.svg">
                <input type="text" name="phone" class="phone" placeholder="Phone Number" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$phone.'"';}} ?> required>
                <?php if(isset($_POST['send'])){if(isset($Err_phone)){echo '<p>'.$Err_phone.'.</p>';}}?> 
            </div>
            <div class="div_email" <?php if(isset($_POST['send'])){if(isset($Err_email)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <img src="Images/email.svg">
                <input type="Email" name="email" class="email" placeholder="Email" <?php if(isset($_POST['send'])){if(isset($err_general)){echo 'value="'.$email.'"';}} ?> required>
                <?php if(isset($_POST['send'])){if(isset($Err_email)){echo '<p>'.$Err_email.'.</p>';}}?> 
            </div>
            <div class="div_password" <?php if(isset($_POST['send'])){if(isset($err_password_length)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <img src="Images/password.svg">
                <input type="Password" name="password" class="password" placeholder="Password"  required>
                <?php if(isset($_POST['send'])){if(isset($err_password_length)){echo '<p>'.$err_password_length.'.</p>';}}?> 
            </div>
            <div class="div_password" <?php if(isset($_POST['send'])){if(isset($err_cpassword)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                <img src="Images/password.svg">
                <input type="Password" name="cpassword" class="password" placeholder="Confirm your password" required>
                <?php if(isset($_POST['send'])){if(isset($err_cpassword)){echo '<p>'.$err_cpassword.'.</p>';}}?> 
            </div>
            <input type="submit" name="send" value="Sign Up" class="envoyer">
        </form>
        <div class="down">
            <span>Already a user ? </span><a href="signIn.php">LOGIN</a>
        </div>
        
    </div>
</section>

<?php include "Includes/footer.php"?>