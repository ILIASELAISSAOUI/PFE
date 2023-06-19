<?php 
    include "Includes/header.php"; 
    include "Actions/connectDB.php";    
    include "Actions/stock_Action.php";
?>

<div class="stock">
    <div class="left-side">
        <?php if(isset($product_added)){echo $product_added;}?>
        <?php if(isset($product_deleted)){echo $product_deleted;}?>
        <?php if(isset($product_updated)){echo $product_updated;}?>
        <div class="first_search">
            <form action="admin_nav.php?x=stock" method="POST">
                <input type="text" name="motCle" class="search_input">
                <select name="filter" style="border-radius:0px;box-shadow:none;" selected="All categories">
                    <option value="allCategories">All categories</option>
                    <option value="name_fournisseur">Supplier name</option>
                    <option value="name_product">Product name</option>
                    <option value="prix_product">Price</option>
                    <option value="Quantity">Quantity</option>
                </select>
                <input class="search_submit" name="submit" type="submit">
                <img src="Images/search.svg" width="23px" height="23px">
            </form> 
        </div>
        <div class="config-supplier">
            <div class="title">
                <img src="Images/user2.png" width="22px" height="22px">
                <h4>Products</h4>
            </div>
            <form action="admin_nav.php?x=stock" method="POST">
                <div class="admin_image">
                    <img src="Images/profil.png" width="170px" height="170px">
                    <input type="file" name="product_image">
                </div>
                <div class="input phone">
                    <label for="">Supplier  name :</label>
                    <select name="fournisseur" selected="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $productWhere['name_fournisseur'];}?>">
                        <?php foreach($allSuppliers as $row): ?>
                            <option value="<?=$row['id_fournisseur']?>"><?=$row['name_fournisseur']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input adress">
                    <label for="">Product name :</label>
                    <input type="text" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $productWhere['name_product'];}?>" name="product_name">
                </div>
                <div class="input email">
                    <label for="">Price :</label>
                    <input type="text" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $productWhere['prix_product'];}?>" name="product_price">
                </div>
                <div class="input password">
                    <label for="">Quantity :</label>
                    <input type="text" value="<?php if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){echo $productWhere['Quantity'];}?>" name="product_quantity">
                </div>
                <div class="buttons">
                    <input type="submit" value="save" name="save">
                    <input type="submit" value="delete" name="delete">
                    <input type="submit" value="add" name="add"> 
                </div>                
            </form>
        </div>

        <div class="info_suppliers" >
            <table <?php if(isset($_POST['submit'])){echo 'style="display:none;"' ;}else{echo 'style="display:block;"';} ?>>
                <tr>
                    <th>Photo</th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Supplier name</th>
                    <th>config</th>
                </tr>
                <?php foreach($allproducts as $data): ?>
                    <tr class="ligne">
                            <td><img src="<?= $data['image_product']?>" width="50px" height="50px"></td>
                            <td><?= $data['name_product']?></td>
                            <td><?= $data['prix_product']?></td>
                            <td><?= $data['Quantity']?></td>
                            <td><?= $data['name_fournisseur']?></td>
                            <td>
                                <div class="config">
                                    <a href="?x=stock&choix=select&id=<?= $data['id_product'];?>" class="update">Select</a>
                                </div>
                            </td>
                        
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php 
            if(isset($_POST['submit'])){
                if(isset($_POST['motCle']) && isset($_POST['filter'])){
                    echo "<table>";
                        echo "<tr>";
                            echo "<th>Image</th>";
                            echo "<th>Product name</th>";
                            echo "<th>Price</th>";
                            echo "<th>Quantity</th>";
                            echo "<th>Supplier name</th>";
                            echo "<th>config</th>";
                        echo "</tr>";
                        foreach($data_filter as $row){
                            echo '<tr class="ligne">';
                                echo '<td><img src="'.$row['name_product'].'" width="50px" height="50px"></td>';
                                echo "<td>".$row['name_product']."</td>";
                                echo "<td>".$row['prix_product']."</td>";
                                echo "<td>".$row['Quantity']."</td>";
                                echo "<td>".$row['name_fournisseur']."</td>";
                                echo "<td>";
                                    echo '<div class="config">';
                                        echo '<a href="?x=stock&choix=select&id='.$row['id_product'].'" class="update">Select</a>';
                                    echo "</div>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                }
            }
            
            
            ?>
        </div>
    </div>

<?php include "Includes/footer.php"; ?>