<?php 
    include "Includes/header.php"; 
    include "Actions/connectDB.php";
    include "Actions/admins_Action.php";
?>

<div class="admins">
    <div class="left-side">
        <?php if(isset($admin_added)){echo $admin_added;}?>
        <?php if(isset($admin_deleted)){echo $admin_deleted;}?>
        <?php if(isset($exist_error)){echo $exist_error;}?>
        <div class="first_search">
            <form action="admin_nav.php?x=admins" method="POST">
                <input type="text" name="motCle" class="search_input">
                <select name="filter" style="border-radius:0px;box-shadow:none;" selected="All categories">
                    <option value="allCategories">All categories</option>
                    <option value="first_name">Name</option>
                    <option value="email">Email</option>
                </select>
                <input class="search_submit" name="submit" type="submit">
                <img src="Images/search.svg" width="23px" height="23px">
            </form> 
        </div>
        <div class="config-supplier">
            <div class="title">
                <img src="Images/user2.png" width="22px" height="22px">
                <h4>Admin</h4>
            </div>
            <form action="" method="POST">
                <div class="admin_image">
                    <img src="Images/profil.png" width="170px" height="170px">
                    <input type="file" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $productWhere['prix_product'];}?>">
                </div>
                <div class="input firstname">
                    <img src="Images/firstName.svg"  width="26px" height="26px" >
                    <input type="text" name="admin_firstname"  placeholder="First name" required value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $adminWhere['first_name'];}?>">
                </div>
                <div class="input lastname">
                    <input type="text" name="admin_lastname"  placeholder="Last name" required value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $adminWhere['last_name'];}?>">
                </div>
                <div class="input phone">
                    <img src="Images/phone.svg" width="26px" height="26px">
                    <input type="text" name="admin_phone" placeholder="Phone" required value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $adminWhere['phone'];}?>">
                </div>
                <div class="input adress">
                    <img src="Images/adress.svg" width="28px" height="28px">
                    <input type="text" name="admin_adress" placeholder="Adress" required value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $adminWhere['adress'];}?>">
                </div>
                <div class="input email">
                    <img src="Images/email.svg" width="28px" height="28px">
                    <input type="email" name="admin_email" placeholder="Email" required value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $adminWhere['email'];}?>">
                </div>
                <div class="input password">
                    <img src="Images/password.svg" width="28px" height="28px">
                    <input type="password" name="admin_password" placeholder="Password" required value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo "disabled";}?>">
                </div>
                <div class="buttons">
                    <input type="submit" value="save" name="save">
                    <input type="submit" value="stop" name="stop">
                    <input type="submit" value="add" name="add"> 
                </div>                
            </form>
        </div>

        <div class="info_suppliers">
            <table <?php if(isset($_POST['submit'])){echo 'style="display:none;"' ;}else{echo 'style="display:block;"';} ?>>
                <tr>
                    <th>Photo</th>
                    <th>Admin name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Adress</th>
                    <th>config</th>
                </tr>
                <?php foreach($allAdmins as $data): ?>
                    <tr class="ligne">
                            <td><img src="" width="50px" height="50px"></td>
                            <td><?= $data['first_name']." ".$data['last_name']?></td>
                            <td><?= $data['phone']?></td>
                            <td><?= $data['email']?></td>
                            <td><?= $data['adress']?></td>
                            <td>
                                <div class="config">
                                    <a href="?x=admins&choix=select&id=<?= $data['id_subscriber'];?>" class="update">Select</a>
                                </div>
                            </td>
                        
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php

            if(isset($_POST['motCle']) && isset($_POST['filter'])){
                echo "<table>";
                    echo "<tr>";
                        echo "<th>admin name</th>";
                        echo "<th>Phone</th>";
                        echo "<th>Email</th>";
                        echo "<th>Adress</th>";
                        echo "<th>Config</th>";
                    echo "</tr>";
                    foreach($data_filter as $row){
                        echo '<tr class="ligne">';
                            echo "<td>". $row['first_name']." ".$row['last_name']."</td>";
                            echo "<td>".$row['phone']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['adress']."</td>";
                            echo "<td>";
                                echo '<div class="config">';
                                    echo '<a href="?x=admins&choix=select&id='.$row['id_subscriber'].'" class="update">Select</a>';
                                echo "</div>";
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }
            ?>
        </div>
    </div>

<?php include "Includes/footer.php"; ?>