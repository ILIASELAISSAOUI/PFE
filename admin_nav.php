<?php 
    Include "Includes/header.php";
    session_start();
    if(isset($_GET['x']) && $_GET['x']=="SignOut"){
        session_destroy();
        header("location:signIn.php");
    } 
?>

<div class="contenaire-admin">
    <nav class="admin_nav">
        <div class="admin_name">
            <p>Elaissaoui ilias</p>
        </div>
        <ul>
            <li <?php if(isset($_GET['x']) && $_GET['x']=="dashboard"){echo 'style="background-color:rgba(255, 255, 255, 0.08);border-radius:5px;padding-bottom:8px;"';}?>>
                <div >
                    <img src="Images/dashboard.png">
                    <a href="?x=dashboard"  class="icon_dashboard"<?php if(isset($_GET['x']) && $_GET['x']=="dashboard"){echo 'style="color:rgba(16, 185, 129, 1);"';}?>>Dashboard</a>
                </div>
            </li>
            <li <?php if(isset($_GET['x']) && $_GET['x']=="customers"){echo 'style="background-color:rgba(255, 255, 255, 0.08);border-radius:5px;padding-bottom:8px;"';}?>>
                <div>
                    <img src="Images/Customers.png" >
                    <a href="?x=customers" <?php if(isset($_GET['x']) && $_GET['x']=="customers"){echo 'style="color:rgba(16, 185, 129, 1);"';}?>>Customers</a>
                </div>
            </li>
            <li <?php if(isset($_GET['x']) && $_GET['x']=="suppliers"){echo 'style="background-color:rgba(255, 255, 255, 0.08);border-radius:5px;padding-bottom:8px;"';}?>>
                <div>
                    <img src="Images/Products.png" class="image">
                    <a href="?x=suppliers" <?php if(isset($_GET['x']) && $_GET['x']=="suppliers"){echo 'style="color:rgba(16, 185, 129, 1);"';}?>>Suppliers</a>
                </div>
            </li>
            <li <?php if(isset($_GET['x']) && $_GET['x']=="stock"){echo 'style="background-color:rgba(255, 255, 255, 0.08);border-radius:5px;padding-bottom:8px;"';}?>>
                <div>
                    <img src="Images/Account.png" class="image">
                    <a href="?x=stock" <?php if(isset($_GET['x']) && $_GET['x']=="stock"){echo 'style="color:rgba(16, 185, 129, 1);"';}?>>Stock</a>
                </div>
            </li>
            <li <?php if(isset($_GET['x']) && $_GET['x']=="admin_box"){echo 'style="background-color:rgba(255, 255, 255, 0.08);border-radius:5px;padding-bottom:8px;"';}?>> 
                <div>
                    <img src="Images/Settings.png" class="image">
                    <a href="?x=admin_box" <?php if(isset($_GET['x']) && $_GET['x']=="admin_box"){echo 'style="color:rgba(16, 185, 129, 1);"';}?>>Boxes</a>
                </div>
            </li>
            <li>
                <div>
                    <img src="Images/Login.png" class="image">
                    <a href="">Shipping</a>
                </div>
            </li>
            <li <?php if(isset($_GET['x']) && $_GET['x']=="admins"){echo 'style="background-color:rgba(255, 255, 255, 0.08);border-radius:5px;padding-bottom:8px;"';}?>>
                <div>
                    <img src="Images/Register.png" class="image">
                    <a href="?x=admins" <?php if(isset($_GET['x']) && $_GET['x']=="admins"){echo 'style="color:rgba(16, 185, 129, 1);"';}?>>Accounts</a>
                </div>
            </li>
            <li>
                <div>
                    <img src="Images/Error.png" class="image">
                    <a href="?x=SignOut">Sign Out</a>
                </div>
            </li>
        </ul>
    </nav>
    <div class="right-content">
        <?php 
            if(isset($_GET['x']) && $_GET['x']=="dashboard"){
                include "Dashboard.php";
            }elseif(isset($_GET['x']) && $_GET['x']=="customers"){
                include "Customers.php";
            }elseif(isset($_GET['x']) && $_GET['x']=="suppliers"){
                include "Suppliers.php";
            }elseif(isset($_GET['x']) && $_GET['x']=="admins"){
                include "Admins.php";
            }elseif(isset($_GET['x']) && $_GET['x']=="admin_box"){
                include "admin_box.php";
            }elseif(isset($_GET['x']) && $_GET['x']=="stock"){
                include "stock.php";
            }
        ?>
    </div>
</div>

<?php Include "Includes/footer.php" ?>