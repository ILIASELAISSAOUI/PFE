<?php 
    include "Includes/header.php";
    Include "Actions/modify_information_Action.php"
?>
<?php if(isset($_POST['save_changes'])){if(isset($notification)){echo $notification;}}?> 
<section class="modify_info">
    <div class="contenaire">
        <div class="title">
            <img src="Images/user.png" width="20px" height="20px">
            <h4>Informations</h4>
        </div>
        <form action="" method="POST">
            <div class="mod_firstName">
                <img src="Images/firstName.svg" width="25px" height="25px">
                <input type="text" name="newfirstName" class="firstName" value="<?=$_SESSION['firstName']?>" >
            </div>
            <div class="mod_lastName">
                <input type="text" name="newlastName" class="lastName" value="<?=$_SESSION['lastName']?>" >
            </div>
            <div class="mod_adress">
                <img src="Images/adress.svg" width="25px" height="25px">
                <input type="text" name="newadress" class="adress" value="<?=$_SESSION['adress']?>" >
            </div>
            <div class="mod_city">
                <img src="Images/paysage-urbain.png" width="22px" height="22px"> 
                <select name="city" class="newcity" selected="<?=$_SESSION['city']?>">
                    <option value="Ouarzazate">Ouarzazate</option>
                    <option value="Agadir">Agadir</option>
                </select>
            </div>
            <div class="mod_date">
                <input type="date" name="newbirthday" class="date" placeholder="Date Of Birth" >
            </div>
            <div class="mod_phone">
                <img src="Images/phone.svg" width="25px" height="25px">
                <input type="text" name="newphone" class="phone" value="<?=$_SESSION['phone']?>">
            </div>
            <input type="submit" name="save_changes" value="Save changes" class="envoyer">
        </form>
</section>

<?php include "Includes/footer.php";?>