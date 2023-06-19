<?php 
include "Includes/header.php" ;
include "Actions/admin_box_Action.php";
include "Actions/connectDB.php";

?>

<div class="admins_box">
    <?php if(isset($Err_price)){echo $Err_price;} ?>
    <div class="top-side">
        <div class="config-boxes">
            <form action="" method="post">
                <div class="box_price">
                    <label for="">Profit :</label>
                    <input name="profit" type="text" required>
                </div>
                <div class="clients_number">
                    <label for="">Clients number :</label>
                    <input name="nbrClients" type="text" required>
                </div>
                <div class="packaging cost">
                    <label for="">Packaging cost :</label>
                    <input name="packaging" type="text" required>
                </div>
                <div class="shipping_cost">
                    <label for="">Shipping cost :</label>
                    <input name="shipping" type="text" required>
                </div>
                <input type="submit" name="make" class="make" value="Make" >                      
            </form>
        </div>
    </div>      
    <div class="down_side" <?php if(isset($_GET['y']) && $_GET['y']=="down" && !isset($Err_profit)){echo 'style="display:flex;"';}else{ echo 'style="display:none;"';} ?>>
        <div class="left-side">
            <div class="top">
                <div class="box_info">
                    <p>Final box cost :<span><?php echo $_SESSION['cost']+$_SESSION['profit']."Dhs";?></span></p>
                    <p>Initial box cost :<span><?php echo $_SESSION['cost']?>Dhs</span></p>
                </div>
                <a href="?x=admin_box&y=make_box&z=save">save</a>
            </div>
            <h4>Products in the box</h4>
            <?php 
            if(!isset($_SESSION['cost'])){
                $_SESSION['cost']=0;
            }
            for($i=1;$i<=$nbreResult;$i++){
            if($_SESSION['click'.$i.'']>=1){
                $quantite=$_SESSION['click'.$i.''];
                echo '<div class="product">';
                    echo '<img src="Images/produit.jpg" width="80px" height="70px">';
                    echo '<div class="product-info">';
                        echo '<div class="product-title">';
                            echo '<p>'.$_SESSION['name_product'.$i.''].'</p>';
                            echo '<p>'.$quantite.'pcs</p>';
                        echo '</div>';
                        echo '<p class="product-price">'.$_SESSION['prix_product'.$i.''].'dhs</p>';
                        echo '</div>';
                echo '</div>';
            }
        }
            ?>
            
        </div>
        <div class="right-side" >
            <!-- <div class="first_search">
                <input type="text" class="search_input">
                <select name="" class="search_select" selected="All categories">
                    <option value="All categories">All categories</option>
                    <option value="Name">Name</option>
                    <option value="Email">Email</option>
                </select>
                <img src="Images/search.svg" width="33px" height="33px">
            </div> -->

        <?php
    
            $i=0; 
            foreach($products as $row) {   
                require_once "Actions/quantity.php";
                if(!isset($_SESSION['quantity'.$i.''])){
                    $_SESSION['quantity'.$i.'']=$row['quantity']; 
                } 
                if(!isset($_SESSION['click'.$i.''])){
                    $_SESSION['click'.$i.'']=0;                
                }
                if(!isset($_SESSION['id_product'.$i.''])){
                    $_SESSION['id_product'.$i.'']=NULL;                
                } 
                $_SESSION['name_product'.$i.'']=$row['name_product'];                
                $_SESSION['prix_product'.$i.'']=$row['prix_product'];
                $_SESSION['id_product'.$i.'']=$row['id_product'];                                
                echo '<div class="product" >';
                    echo '<img src="Images/produit.jpg" width="80px" height="70px">';
                    echo '<div class="product-info">';
                        echo '<div class="product-title">';
                            echo '<p>'.$_SESSION['name_product'.$i.''].'</p>';
                            echo '<p>'.$_SESSION['quantity'.$i.''].'pcs</p>';
                        echo '</div>';
                        echo '<p class="product-price">'.$_SESSION['prix_product'.$i.''].'dhs</p>';
                        echo '<form class="moin_plus" action="" method="post">';
                            echo '<input type="submit" name="moins'.$i.'" class="moin" value="m">';
                            echo '<input type="submit" name="plus'.$i.'" class="plus" value="p" >';
                        echo '</form>';
                    echo '</div>';
                echo '</div>'; 
                 $i++;             

                } 
            ?>
    </div>
    

<?php include "Includes/footer.php" ?>