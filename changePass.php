<?php 
    include "Includes/header.php";
    include "Actions/connectDB.php";
    include "Actions/changePass_Action.php";
?>

<body class="forgot_body">
    <?php if(isset($_POST['submit'])){if(isset($err_password_length)){echo $err_password_length;}}?> 
    <div class="change_password">
        <div>
            <img src="Images/key-with-hole.png" width="70px" height="70px">
        </div>
        <h4>Reset password</h4>
        <form action="changePass.php?key=<?=$_SESSION['key2']?>" method="post">
            <input type="password" name="newpassword" placeholder="new password" <?php if(isset($_POST['submit'])){if(isset($err_password_length)){echo 'style="border-color:red"';}}?>>
            <input type="submit" name="submit" class="submit_input" value="Change"> 
        </form>
    </div>

<?php include "Includes/footer.php";?>