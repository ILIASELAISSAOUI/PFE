<?php include "Includes/header.php";?>

<section class="modify_password">
    <div class="contenaire">
        <div class="title">
            <img src="Images/lock.png" width="20px" height="20px">
            <h4>Change Your Password</h4>
        </div>
        <form action="" method="POST">
            <input type="text" name="currentPassword" placeholder="Your Current Password*" >
            <input type="text" name="newPassword"  placeholder="Your New Password*" >
            <input type="text" name="cnewPassword"  placeholder="Your New Password*" >
            <input type="submit" name="send" value="Save changes" class="envoyer">
        </form>
</section>

<?php include "Includes/footer.php";?>