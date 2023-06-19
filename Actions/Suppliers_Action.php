<?php

if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){
    header("location:signIn.php");
} 

function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

//commander
if(isset($_POST['envoyer'])){
    //validate quantity
    if(isset($_POST['quantity']) && !empty($_POST['quantity'])){
            $quantity=test_input($_POST['quantity']);
            $regex_phone = "/^[0-9]*$/";
            if (!preg_match ($regex_phone, $quantity) || preg_match("/^[a-zA-z]*$/",$quantity)) {  
                $Err_quantity_input = "<p>quantity is not valid</p>";  
            }
            else{
                if(isset($_GET['product'])){
                    $set=$conn->prepare("UPDATE product SET Quantity=Quantity+? WHERE id_product=?");
                    $set->execute(array($quantity,$_GET['product']));
                }
            }
    }
    
}


//show a specific supplier's products
if(isset($_GET['choix']) && $_GET['choix']=="products" && isset($_GET['id'])){
    $show_productsWhere=$conn->prepare("SELECT * FROM product WHERE id_fournisseur=?");
    $show_productsWhere->execute(array($_GET['id']));
    $productsWhere=$show_productsWhere->fetchAll();
}

//show all products
    $show_products=$conn->prepare("SELECT * FROM product");
    $show_products->execute();
    $products=$show_products->fetchAll();


//search bar
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['motCle']) && !empty($_POST['motCle']) && isset($_POST['filter']) && !empty($_POST['filter'])){
        if($_POST['filter']=="allCategories"){
            $motCle=$_POST['motCle'];
            $search=$conn->prepare("SELECT * FROM fournisseur WHERE name_fournisseur LIKE ? OR email_fournisseur LIKE ?");
            $motCle2="%".$motCle."%";
            $search->execute(array($motCle2,$motCle2));
            $data_filter=$search->fetchAll();
            $_SESSION['search']=1;
        }else{
            $motCle=$_POST['motCle'];
            $filter=$_POST['filter'];
            $search=$conn->prepare("SELECT * FROM fournisseur WHERE $filter LIKE ?");
            $motCle2="%".$motCle."%";
            $search->execute(array($motCle2));
            $data_filter=$search->fetchAll();
            $_SESSION['search']=1;
        }
    }
}

//select a specific fournisseur
if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){
    $selectWhere=$conn->prepare("SELECT * FROM fournisseur WHERE id_fournisseur=?");
    $selectWhere->execute(array($_GET['id']));
    $fournisseurWhere=$selectWhere->fetch();
}

//select all suppliers from database
    $select=$conn->prepare("SELECT * FROM fournisseur");
    $select->execute();
    $fournisseurs=$select->fetchAll();

//validate data and insert a supplier
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $errors=0;
        //validate fullname
        if(isset($_POST['full_name']) && !empty($_POST['full_name'])){
            $fullname=test_input($_POST['full_name']);
            $regex_fullname='/^[a-zA-z]*$/';
            //check if name contains only letters and whitespace
            if (!preg_match ($regex_fullname,  $fullname) ){  
                $Err_lastname = "<p>the last name is not valid</p>";
                $errors++;  
            }
        }
    
        //validate adress
        if(isset($_POST['adress']) && !empty($_POST['adress'])){
            $adress=test_input($_POST['adress']);
            $regex_adress = "/[A-Za-z0-9\-\\,.]+/";
            //chec if name contains only letters and whitespace
            if (!preg_match ($regex_adress, $adress) ) {  
                $Err_adress = "<p>Adress is not valid</p>"; 
                $errors++;
            }
        }
    
         //validate phone
        if(isset($_POST['phone']) && !empty($_POST['phone'])){
            $phone=test_input($_POST['phone']);
            $length = strlen ($phone); 
            $regex_phone = "/^[0-9]*$/";
            //check if name contains only letters and whitespace
            if (!preg_match ($regex_phone, $phone) || preg_match("/^[a-zA-z]*$/",$phone) || $length!=10 ) {  
                $Err_phone = "<p>phone number is not valid</p>";  
                $errors++;  
            }
        }
        //validate email
        if (!empty($_POST["email"])){        
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            $regex_email = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
            if (!preg_match ($regex_email, $email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){  
                $Err_email = "<p>Email is not valid</p>";
                $errors++; 
            }
        }
        if(isset($_POST['add'])){
            $exist=$conn->prepare("SELECT * FROM fournisseur WHERE email_fournisseur=?");
            $exist->execute(array($email));
            $count=$exist->rowCount();
            if($count>0){
                $exist_error='<p class="alert alert-danger">This email already exist</p>';
            }else{
                //insert data in database
                $stmt=$conn->prepare("insert into fournisseur(name_fournisseur,email_fournisseur,adress_fournisseur,phone_fournisseur) values (?,?,?,?)");
                $stmt->execute(array($fullname,$email,$adress,$phone));
                $supplier_added='<p class="alert alert-success">A new supplier has been added</p>';
            }
            
        }elseif(isset($_POST['delete'])){
            $delete=$conn->prepare("DELETE FROM fournisseur WHERE email_fournisseur=?");
            $delete->execute(array($email));
            $supplier_deleted='<p class="alert alert-success">the supplier has been deleted</p>';
        }elseif(isset($_POST['save'])){
                $save=$conn->prepare("UPDATE fournisseur SET name_fournisseur=?,phone_fournisseur=?,adress_fournisseur=?,email_fournisseur=? WHERE email_fournisseur=?");
                $save->execute(array($fullname,$phone,$adress,$email,$email));
                $supplier_updated='<p class="alert alert-success">the supplier has been updated</p>';
        }
}


?>