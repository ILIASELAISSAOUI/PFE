<?php 
    include "Includes/header.php";
    include "Actions/connectDB.php";
    include "Actions/account_Action.php";


    //-----------------------------------------------select data from database ---------------------------------------
    $info=$conn->prepare("SELECT first_name,last_name,city,id_phone,id_adresse FROM subscriber WHERE email=?");
    $info->execute(array($_SESSION['email']));
    $data1=$info->fetch();

    $adress=$conn->prepare("SELECT adress FROM adresse WHERE id_adresse=?");
    $adress->execute(array($data1['id_adresse']));
    $data2=$adress->fetch();

    $phone=$conn->prepare("SELECT phone FROM phone WHERE id_phone=?");
    $phone->execute(array($data1['id_phone']));
    $data3=$phone->fetch();

?>

<section class="information">
    <div class="contenaire">
        <div class="partOne">
            <img src="Images/user.png" width="16px" height="16px">
            <h4>Informations</h4>
        </div>
        <div class="sous_contenaire">
                <div class="part">
                    <h5>Display Name</h5>
                    <?php echo '<p>'.$data1['first_name']." ".$data1['last_name'].'</p>'; ?>
                </div>
                <div class="part">
                    <h5>Phone Number</h5>
                    <?php echo '<p>'.$data3['phone'].'</p>'; ?>
                </div>
                <div class="part down1">
                    <h5>City</h5>
                    <?php echo '<p>'.$data1['city'].'</p>'; ?>
                </div>
                <div class="part down2">
                    <h5>Adress</h5>
                    <?php echo '<p>'.$data2['adress'].'</p>'; ?>
                </div>       
        </div>
        <div class="button_edit">
            <a href="?x=Account&y=mod_info" class="edit">Edit</a>
        </div>       
        <p class="separator"></p>
        <div class="security">
                <div class="parttwo">
                    <img src="Images/lock.png" width="16px" height="16px">
                    <h4>Security</h4>
                </div>
                <div class="part email">
                    <h5>Email</h5>
                    <?php echo '<p>'.$_SESSION['email'].'</p>'; ?>
                </div>
                <div class="part password">
                    <h5>Password</h5>
                    <p>************</p>
                </div>
                <div class="button_edit">
                    <a href="?x=Account&y=mod_pass" class="edit">Edit</a>
                </div>        
        </div>
    </div>
</section>
</div>

<?php include "Includes/footer.php"?>




