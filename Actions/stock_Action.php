<?php


function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}


//search bar
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['motCle']) && !empty($_POST['motCle']) && isset($_POST['filter']) && !empty($_POST['filter'])){
        if($_POST['filter']=="allCategories"){
            $motCle=$_POST['motCle'];
            $search=$conn->prepare("SELECT id_product,name_product , prix_product ,Quantity,name_fournisseur FROM fournisseur f inner join product p on p.id_fournisseur=f.id_fournisseur WHERE name_product LIKE ? OR name_fournisseur LIKE ? OR prix_product LIKE ? OR Quantity LIKE ? ");
            $motCle2="%".$motCle."%";
            $search->execute(array($motCle2,$motCle2,$motCle2,$motCle2));
            $data_filter=$search->fetchAll();
            $_SESSION['search']=1;
        }else{
            $motCle=$_POST['motCle'];
            $filter=$_POST['filter'];
            $search=$conn->prepare("SELECT id_product,name_product , prix_product ,Quantity,name_fournisseur FROM fournisseur f inner join product p on p.id_fournisseur=f.id_fournisseur WHERE $filter LIKE ?");
            $motCle2="%".$motCle."%";
            $search->execute(array($motCle2));
            $data_filter=$search->fetchAll();
            $_SESSION['search']=1;
        }
    }
}

//select all suppliers
$suppliers=$conn->prepare("SELECT * FROM fournisseur");
$suppliers->execute();
$allSuppliers=$suppliers->fetchAll();

//select all products
$products=$conn->prepare("SELECT id_product,image_product,name_product, prix_product ,Quantity,name_fournisseur FROM fournisseur f inner join product p on p.id_fournisseur=f.id_fournisseur;");
$products->execute();
$allproducts=$products->fetchAll();

//select a specific product
if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){
    $selectWhere=$conn->prepare("SELECT name_product,image_product,prix_product ,Quantity,name_fournisseur FROM fournisseur f inner join product p on p.id_fournisseur=f.id_fournisseur WHERE id_product=?;");
    $selectWhere->execute(array($_GET['id']));
    $productWhere=$selectWhere->fetch();
}


//validate data and insert in database
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $errors=0;
    if(isset($_POST['fournisseur']) && !empty($_POST['fournisseur'])){
        $fournisseur_id=$_POST['fournisseur'];
    }
    
    if(isset($_POST['product_image']) && !empty($_POST['product_image'])){
        $product_image='Images/'.$_POST['product_image'];
    }
    

    //validate fullname
    if(isset($_POST['product_name']) && !empty($_POST['product_name'])){
        $product_name=test_input($_POST['product_name']);
        $regex_fullname='/^[a-zA-z]*$/';
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_fullname,  $product_name) ){  
            $Err_lastname = "<p>the last name is not valid</p>";
            $errors++;  
        }
    }

    //validate price
    if(isset($_POST['product_price']) && !empty($_POST['product_price'])){
        $product_price=test_input($_POST['product_price']);
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $product_price) || preg_match("/^[a-zA-z]*$/",$product_price)) {  
            $Err_phone = "<p>product's price number is not valid</p>";  
            $errors++;  
        }
    }

    //validate quantity
    if(isset($_POST['product_quantity']) && !empty($_POST['product_quantity'])){
        $product_quantity=test_input($_POST['product_quantity']);
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $product_quantity) || preg_match("/^[a-zA-z]*$/",$product_quantity)) {  
            $Err_phone = "<p>product's price number is not valid</p>";  
            $errors++;  
        }
    }

    if(isset($_POST['add'])){
        $exist=$conn->prepare("SELECT * FROM product WHERE name_product=?");
        $exist->execute(array($product_name));
        $count=$exist->rowCount();
        if($count>0){
            $exist_error="This product already exist";
        }else{
            //insert data in database
            $stmt=$conn->prepare("insert into product(name_product,prix_product,image_product,id_fournisseur,Quantity) values (?,?,?,?,?)");
            $stmt->execute(array($product_name,$product_price,$product_image,$fournisseur_id,$product_quantity,));
            $product_added='<p class="alert alert-success">A new product has been added</p>';
        }
        
    }elseif(isset($_POST['delete'])){
        $delete=$conn->prepare("DELETE FROM product WHERE name_product=?");
        $delete->execute(array($product_name));
        $product_deleted='<p class="alert alert-success">the product has been deleted</p>';
    }elseif(isset($_POST['save'])){
            $save=$conn->prepare("UPDATE product SET name_product=?,prix_product=?,Quantity=? WHERE name_product=?");
            $save->execute(array($product_name,$product_price,$product_quantity,$product_name));
            $product_updated='<p class="alert alert-success">the supplier has been updated</p>';
    }
}
?>