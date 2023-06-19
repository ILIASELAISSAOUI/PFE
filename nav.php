<?php
include "Actions/nav_Action.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Assets/style.css">
    <title>Document</title>
</head>
<body>
<div class="all">
        <section class="navbarr">
            <a href="Home.php" >
                <img src="Images/logo.png" width="220px" height="50px" class="logo_nav">
            </a>
            <nav>
                <ul>
                    <li>
                        <div class="account"<?php if(isset($_GET['x']) && $_GET['x']=="Account"){echo 'style="background-color:#FFD6BE;border-left:5px solid #6C45BF;"';}else{echo "background-color:transparent;";} ?>;>
                            <img src="Images/Account White.png" width="20px" height="20px">
                            <a href="?x=Account">Account</a>
                        </div>
                        <div <?php if(isset($_GET['x']) && $_GET['x']=="Box"){echo 'style="background-color:#FFD6BE;border-left:5px solid #6C45BF;"';}else{echo "background-color:transparent;";}?>;>
                            <p class="top"></p>
                            <img src="Images/Box.png" width="22px" height="22px">
                            <a href="?x=Box">Box</a>
                        </div>
                        <div <?php if(isset($_GET['x']) && $_GET['x']=="Support"){echo 'style="background-color:#FFD6BE;border-left:5px solid #6C45BF;"';}else{echo "background-color:transparent;";}?>;>
                            <p class="top"></p>
                            <img src="Images/Support white.png" width="22px" height="22px">
                            <a href="?x=Support">Support</a>
                            <p class="down"></p>
                        </div>
                        <div  <?php if(isset($_GET['x']) && $_GET['x']=="SignOut"){echo 'style="background-color:#FFD6BE;border-left:5px solid #6C45BF;"';}else{echo "background-color:transparent;";}?>;>
                            <img src="Images/Log Out white.png" width="22px" height="22px">
                            <a href="?x=SignOut">SignOut</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </section>

    <section class="right_side">
        <img src="Images/background_image.png" width="80%" height="753px">
        <div class="content">
            <?php 
                if((isset($_GET['x'])) && (isset($_GET['y'])) && ($_GET['x']=="Account") && ($_GET['y']=="mod_info")){
                    include "modify_information.php";
                }
                elseif(isset($_GET['x']) && isset($_GET['y']) && $_GET['x']=="Account" && $_GET['y']=="mod_pass"){
                    include "modify_password.php";
                }  
                elseif(isset($_GET['x']) && $_GET['x']=="Account"){
                    include "Account.php";
                }
                elseif(isset($_GET['x']) && $_GET['x']=="Box"){
                    include "box.php";
                }
                elseif(isset($_GET['x']) && $_GET['x']=="Support"){
                    include "support.php";
                }
                elseif((isset($_GET['x'])) && (isset($_GET['y'])) && ($_GET['x']=="Account") && ($_GET['y']=="mod_info")){
                    include "modify_information.php";
                }           
            ?>
        </div>
    </section>
</div>

