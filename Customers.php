<?php 
include "Actions/connectDB.php";
include "Includes/header.php" ;
include "Actions/Customers_Action.php";
?>

<section class="customers">
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
    <div class="second_search">
        <div <?php if((isset($_GET['s']) && $_GET['s']=="total")){echo 'style=" background-color: rgb(238, 236, 236) ;"';}?> >
            <img src="Images/group.png" width="23px" height="23px">
            <a href="?x=customers&s=total">Total clients</a>
        </div>
        <div <?php if(isset($_GET['s']) && $_GET['s']=="active"){echo 'style=" background-color: rgb(238, 236, 236) ;"';}?>>
            <img src="Images/active_clients.svg" width="20px" height="20px">
            <a href="?x=customers&s=active">Active clients</a>
        </div>
        <a href="" style="color:black;"></a>
    </div>
    <div class="content">
        <table>
            <?php if(isset($_GET['s']) && $_GET['s']=="active"){ 
                        echo " <tr>
                            <th>Email</th>
                            <th>Full name</th>
                            <th>Date of birth</th>
                            <th>Adress</th> 
                            <th>Phone N°</th>
                            <th>City</th>
                            <th>Subscription date</th>
                            <th>type of Subsription</th>
                            <th> Number of Month</th> 
            
                        </tr>";
                foreach($table as $row){
                    echo "<tr>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["last_name"]." ".$row["first_name"]."</td>";
                    echo "<td>".$row["birthday"]."</td>";
                    echo "<td>".$row["adress"]."</td>";
                    echo "<td>".$row["phone"]."</td>";
                    echo "<td>".$row["city"]."</td>";
                    echo "<td>".$row["subscription_end"]."</td>";
                    echo "<td>".$row["type_abonnement"]."</td>";
                    echo "<td>".$row["activity"]."</td>";
                    echo "</tr> ";
                }
            }else if(isset($_GET['s']) && $_GET['s']=="total"){
                echo "  <tr>
                <th>Email</th>
                <th>Full name</th>
                <th>Date of birth</th>
                <th>Adress</th> 
                <th>Phone N°</th>
                <th>City</th>
                <th> Number of Month</th> 
            </tr>";
                foreach($total as $row){
                    echo "<tr>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["last_name"]." ".$row["first_name"]."</td>";
                    echo "<td>".$row["birthday"]."</td>";
                    echo "<td>".$row["adress"]."</td>";
                    echo "<td>".$row["phone"]."</td>";
                    echo "<td>".$row["city"]."</td>";
                    echo "<td>".$row["activity"]."</td>";
                    echo "</tr> ";
                }

            }
                ?>            
        </table>
    </div>
</section>

<?php include "Includes/footer.php" ?>