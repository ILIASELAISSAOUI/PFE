<?php 
    include "Includes/header.php";
    include "Actions/forgotPassword_Action.php";
?>

<body class="forgot_body">
    <?php if(isset($_POST['submit'])){if(isset($not_exist)){echo $not_exist;}}?> 
    <?php if(isset($_POST['submit'])){if(isset($exist)){echo $exist;}}?>
    <div class="forgot_password">
        <h5>Reset password</h5>
        <p class="separateur"></p>
        <p class="info">enter your email adress and we will email you insctructions on how to reset your password</p>
        <form action="forgotPassword.php" method="post">
            <input type="email" name="email" placeholder="Email">
            <input type="submit" name="submit" class="submit_input"> 
        </form>
        
    </div>
<?php include "Includes/footer.php";?>