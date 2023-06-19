<?php 


if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){
    header("location:signIn.php");
} 
//---------Conditions if !isset-------------------
if(!isset($_SESSION['nbrclick'])){
    $_SESSION['nbrclick']=0;   
}

if(isset($__POST['profit'])){
    $_SESSION['profit']=$_POST['profit'];   
}
include "connectDB.php";
$errors=0;

//----------------------------------------------function to validate inputs--------------------------------------------------
 function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}


//-------------------------function validate price----------------
function validate($data){
$validate_data=test_input($data);
$regex_price = "/^[0-9]*$/";
//check if name contains only letters and whitespace
 if (!preg_match ($regex_price, $validate_data) || preg_match("/^[a-zA-z]*$/",$validate_data )|| $validate_data==0)  {  
    $Err_price = '<p class="alert alert-danger">the data is not valid</p>';  
    }
} 

if(isset($_POST['make'])){
    $errors=0;
    if(isset($_POST['profit']) && !empty($_POST['profit'])){
        $profit=$_POST['profit']; 
        $_SESSION['profit']=$profit;
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $profit) || preg_match("/^[a-zA-z]*$/",$profit)) {  
            $errors++;
        }
    }
    
    if(isset($_POST['nbrClients']) && !empty($_POST['nbrClients'])){
        $nbrClients=$_POST['nbrClients']; 
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $nbrClients) || preg_match("/^[a-zA-z]*$/",$nbrClients)) { 
            $errors++; 
        }
    }

    if(isset($_POST['packaging']) && !empty($_POST['packaging'])){
        $packaging=$_POST['packaging']; 
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $packaging) || preg_match("/^[a-zA-z]*$/",$packaging)) { 
            $errors++;
        }
    }
    
    if(isset($_POST['shipping']) && !empty($_POST['shipping'])){
        $shipping=$_POST['shipping']; 
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $shipping) || preg_match("/^[a-zA-z]*$/",$shipping)) { 
            $errors++;
        }
    }

    if($errors==0){
        header("location:admin_nav.php?x=admin_box&y=down");
    }else{
        $Err_price = '<p class="alert alert-danger">the data is not valid</p>'; 
    }
    
}

if(isset($_POST['shipping']) && isset($_POST['packaging'])){
    $_SESSION['price_box']=$_POST['packaging']+$_POST['shipping']+$_SESSION['cost'];
}


    
/*     $stmt = $conn->prepare("INSERT INTO box (prix_box) values (?)");
            $stmt->execute(array($price_box));
            $id_box=$conn->lastInsertId(); */


$stmt = $conn->prepare("SELECT id_product ,name_product, prix_product,quantity FROM product where quantity <> 0 ");
$stmt->execute();
$products = $stmt->fetchall(PDO::FETCH_ASSOC);

$nbreResult = $stmt->rowCount();

for($i=1;$i<100;$i++){
//-------------Plus--------------------
    if(isset($_POST['plus'.$i.''])){
    --$_SESSION['quantity'.$i.''];
     ++$_SESSION['click'.$i.''];
    $_SESSION['cost']+=$_SESSION['prix_product'.$i.''];
    }
//------------Moins---------------------
    if(isset($_POST['moins'.$i.''])){
        ++$_SESSION['quantity'.$i.''];
        --$_SESSION['click'.$i.''];
        $_SESSION['cost']-=$_SESSION['prix_product'.$i.''];
    }
        }
        $somme=0;
        for($i=1;$i<100;$i++){
        if(isset( $_SESSION['click'.$i.''])){
           $somme += $_SESSION['click'.$i.''];
        }
    }



//------------------SAVE IN BD---------------

if(isset($_GET['z']) && $_GET['z']=='save'){
    
    if($somme >5){
        echo"Vous avez depasse le nombre limite des produits";
    }else if($_SESSION['cost']<=0 || $somme<=0){
        echo "Vous n'avez rien choisi";
    }else{
        $value=array();
        for($i=1;$i<=$nbreResult+1;$i++){
        if(isset($_SESSION['click'.$i.'']) &&  $_SESSION['click'.$i.'']>1 && isset($_SESSION['id_product'.$i.''])){
        for($j=0;$j<=$_SESSION['click'.$i.'']+1;$j++)
        $value[$_SESSION['click'.$i.'']-$j]=$_SESSION['id_product'.$i.'']; 
    }else if(isset($_SESSION['click'.$i.'']) && $_SESSION['click'.$i.'']==1 && isset($_SESSION['id_product'.$i.''])){
        $value[$i]=$_SESSION['id_product'.$i.''];}
    }
        $matstring=implode("','",$value);
        $matstring="'".$matstring."'";
        $cost=$_SESSION['price_box'];
        $stmt = $conn->prepare("INSERT INTO box (id_product1,id_product2,id_product3,id_product4,id_product5,prix_box) VALUES ($matstring,$cost)");
        $stmt->execute();
    }
}

?>