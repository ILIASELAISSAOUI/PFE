<?php
    include "Includes/header.php";
    include "Actions/connectDB.php";
    include "Actions/Suppliers_Action.php";
    $_SESSION['commande']=0;
?>

<div class="suppliers">
    <div class="left-side">
        <?php if(isset($supplier_added)){echo $supplier_added;}?>
        <?php if(isset($supplier_deleted)){echo $supplier_deleted;}?>
        <?php if(isset($supplier_updated)){echo $supplier_updated;}?>
        <?php if(isset($exist_error)){echo $exist_error;}?>
        <div class="first_search">
            <form action="admin_nav.php?x=suppliers" method="POST">
                <input type="text" name="motCle" class="search_input">
                <select name="filter" style="border-radius:0px;box-shadow:none;" selected="All categories">
                    <option value="allCategories">All categories</option>
                    <option value="name_fournisseur">Name</option>
                    <option value="email_fournisseur">Email</option>
                </select>
                <input class="search_submit" name="submit" type="submit">
                <img src="Images/search.svg" width="23px" height="23px">
            </form> 
        </div>
        <div class="config-supplier">
            <div class="title">
                <img src="Images/user2.png" width="22px" height="22px">
                <h4>Suppliers</h4>
            </div>
            <form action="admin_nav.php?x=suppliers" method="POST">
                <div class="input name" <?php if(isset($_POST['add'])){if(isset($Err_firstname)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                    <img src="Images/firstName.svg"  width="26px" height="26px" >
                    <input type="text" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $fournisseurWhere['name_fournisseur'];}?>" name="full_name" placeholder="Full name">
                </div>
                <div class="input phone" <?php if(isset($_POST['add'])){if(isset($err_general)){echo 'value="'.$phone.'"';}} ?>>
                    <img src="Images/phone.svg" width="26px" height="26px">
                    <input type="text" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $fournisseurWhere['phone_fournisseur'];}?>" name="phone" placeholder="Phone">
                </div>
                <div class="input adress" <?php if(isset($_POST['add'])){if(isset($Err_adress)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                    <img src="Images/adress.svg" width="28px" height="28px">
                    <input type="text" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $fournisseurWhere['adress_fournisseur'];}?>" name="adress" placeholder="Adress">
                </div>
                <div class="input email" <?php if(isset($_POST['add'])){if(isset($Err_email)){echo 'style="border-color:red;margin-top:10px;"';}}?>>
                    <img src="Images/email.svg" width="28px" height="28px">
                    <input type="email" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $fournisseurWhere['email_fournisseur'];}?>" name="email" placeholder="Email">
                </div>
                <div class="buttons_suppliers">
                    <input type="submit" value="save" name="save" style="cursor:pointer;">
                    <input type="submit" value="delete" name="delete" style="cursor:pointer;">
                    <input type="submit" value="add" name="add" style="cursor:pointer;"> 
                </div>
            </form>
        </div>

        <div class="info_suppliers">
            <table <?php if(isset($_POST['motCle']) && isset($_POST['filter'])){echo 'style="display:none;"';}else{echo 'style="display:block;"';} ?>>
                <tr>
                    <th>Supplier name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Adress</th>
                    <th>Config</th>
                </tr>
                <?php foreach($fournisseurs as $row):?>
                <tr class="ligne">
                    <td><?= $row['name_fournisseur'];?></td>
                    <td><?= $row['phone_fournisseur'];?></td>
                    <td><?= $row['email_fournisseur'];?></td>
                    <td><?= $row['adress_fournisseur'];?></td>
                    <td>
                        <div class="config">
                            <a href="?x=suppliers&choix=products&id=<?= $row['id_fournisseur'];?>" class="products">Products</a>
                            <a href="?x=suppliers&choix=select&id=<?= $row['id_fournisseur'];?>" class="update">Select</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>
            
            <?php

            if(isset($_POST['motCle']) && isset($_POST['filter'])){
                echo "<table>";
                    echo "<tr>";
                        echo "<th>Supplier name</th>";
                        echo "<th>Phone</th>";
                        echo "<th>Email</th>";
                        echo "<th>Adress</th>";
                        echo "<th>Config</th>";
                    echo "</tr>";
                    foreach($data_filter as $row){
                        echo '<tr class="ligne">';
                            echo "<td>".$row['name_fournisseur']."</td>";
                            echo "<td>".$row['phone_fournisseur']."</td>";
                            echo "<td>".$row['email_fournisseur']."</td>";
                            echo "<td>".$row['adress_fournisseur']."</td>";
                            echo "<td>";
                                echo '<div class="config">';
                                    echo '<a href="?x=suppliers&choix=products&id='.$row['id_fournisseur'].'" class="products">Products</a>';
                                    echo '<a href="?x=suppliers&choix=select&id='.$row['id_fournisseur'].'" class="update">Select</a>';
                                echo "</div>";
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }
            
            ?>


        </div>
    </div>
    <div class="right-side" >
        <?php foreach($products as $donn): ?>
            <div class="product" <?php if(isset($_GET['choix']) && $_GET['choix']=="products" && isset($_GET['id'])){echo 'style="display:none;"';} ?>>
                <?php 
                    $_SESSION['commande']=$_SESSION['commande']+1; 
                    $string="produit".$_SESSION['commande'];
                ?>
                <img src="Images/produit.jpg" width="80px" height="70px">
                <div class="product-info">
                    <div class="product-title">
                        <p><?=$donn['name_product']?></p>
                        <p><?=$donn['Quantity']?>pcs</p>
                    </div>
                    <p class="product-price"><?=$donn['prix_product']?>Dhs</p>
                    <div class="commander" <?php if(isset($_GET['z']) && $_GET['z']==$string){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?>>
                        <form action="" method="post">
                            <label for="">Quantity:</label>
                            <input type="text" name="quantity" style="width:50px;" required>
                            <input type="submit" name="envoyer" value="Commander" class="envoyer">
                        </form>                   
                    </div>
                    <a href="?x=suppliers&z=<?= $string;?>&product=<?=$donn['id_product']?>" <?php if(isset($_GET['z']) && $_GET['z']==$string){echo 'style="display:none;"';} ?>><img src="Images/plus.png" width="25px" height="25px"></a>
                </div>
            </div>
        <?php endforeach; ?>
        <?php
            if(isset($_GET['choix']) && $_GET['choix']=="products" && isset($_GET['id'])){
                foreach($productsWhere as $pro){
                    $_SESSION['id_product']=$_GET['id'];
                    echo '<div class="product">';
                        $_SESSION['commande']=$_SESSION['commande']+1; 
                        $string="produit".$_SESSION['commande'];
                        echo '<img src="Images/produit.jpg" width="80px" height="70px">';
                        echo '<div class="product-info">';
                            echo '<div class="product-title">';
                                echo '<p>'.$pro['name_product'].'</p>';
                                echo '<p>'.$pro['Quantity'].'pcs</p>';
                            echo '</div>';
                            echo '<p class="product-price">'.$pro['prix_product'].'Dhs</p>';
                            if(isset($_GET['z']) && $_GET['z']==$string){
                                echo '<div class="commander" style="display:block;">';
                                    echo '<form action="" method="post">';
                                        echo '<label for="">Quantity:</label>';
                                        echo '<input type="text" name="quantity" required style="width:50px;">';
                                        echo '<input type="submit" name="envoyer" value="Commander" class="envoyer">';
                                    echo '</form>';            
                                echo '</div>';
                            }
                            else{
                                echo '<div class="commander" style="display:none;">';
                                    echo '<label for="">Quantity:</label>';
                                    echo '<input type="text" required style="width:50px;">';
                                    echo '<input type="submit" name="envoyer" value="Commander" class="envoyer">';                   
                                echo '</div>';
                            }
                            
                            if(!isset($_GET['z']) || $_GET['z']!=$string){
                                echo '<a href="?x=suppliers&choix=products&id='.$_SESSION['id_product'].'&z='.$string.'&product='.$pro['id_product'].'" style="display:block;">';
                                    echo '<img src="Images/plus.png" width="25px" height="25px">';
                                echo '</a>';
                            }
                        echo '</div>';
                    echo '</div>';
                }
            }   
        ?>
    </div>
</div>

<?php include "Includes/footer.php" ?>