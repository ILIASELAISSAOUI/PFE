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

//search bar
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['motCle']) && !empty($_POST['motCle']) && isset($_POST['filter']) && !empty($_POST['filter'])){
        if($_POST['filter']=="allCategories"){
            $motCle=$_POST['motCle'];
            $search=$conn->prepare("SELECT  s.id_subscriber,first_name,last_name,email,phone,adress,email FROM subscriber s INNER JOIN phone p INNER JOIN adresse a ON a.id_adresse=s.id_adresse AND p.id_phone=s.id_phone WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ?  AND isadmin=?");
            $motCle2="%".$motCle."%";
            $search->execute(array($motCle2,$motCle2,$motCle2,1));
            $data_filter=$search->fetchAll();
            $_SESSION['search']=1;
        }else{
            $motCle=$_POST['motCle'];
            $filter=$_POST['filter'];
            $search=$conn->prepare("SELECT  s.id_subscriber,first_name,last_name,email,phone,adress,email FROM subscriber s INNER JOIN phone p INNER JOIN adresse a ON a.id_adresse=s.id_adresse AND p.id_phone=s.id_phone WHERE $filter LIKE ? AND isadmin=?");
            $motCle2="%".$motCle."%";
            $search->execute(array($motCle2,1));
            $data_filter=$search->fetchAll();
            $_SESSION['search']=1;
        }
        
    }
}

//select all admins
$select=$conn->prepare("SELECT  s.id_subscriber,first_name,last_name,email,phone,adress,email FROM subscriber s INNER JOIN phone p INNER JOIN adresse a ON a.id_adresse=s.id_adresse AND p.id_phone=s.id_phone WHERE isadmin=?");
$select->execute(array(1));
$allAdmins=$select->fetchAll();

//select a specific product
if(isset($_GET['choix']) && $_GET['choix']=="select" && isset($_GET['id'])){
    $selectWhere=$conn->prepare("SELECT first_name,last_name,email,phone,adress,email FROM subscriber s INNER JOIN phone p INNER JOIN adresse a ON a.id_adresse=s.id_adresse AND p.id_phone=s.id_phone WHERE s.id_subscriber=? AND isadmin=?");
    $selectWhere->execute(array($_GET['id'],1));
    $adminWhere=$selectWhere->fetch();
}

//validate data and insert a supplier
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $errors=0;
    //validate fullname
    if(isset($_POST['admin_firstname']) && !empty($_POST['admin_firstname'])){
        $first_name=test_input($_POST['admin_firstname']);
        $regex_fullname='/^[a-zA-z]*$/';
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_fullname,$first_name) ){  
            $Err_firstname = "<p>the last name is not valid</p>";
        }
    }
    else{
        $errors++;
    }

    //validate fullname
    if(isset($_POST['admin_lastname']) && !empty($_POST['admin_lastname'])){
        $last_name=test_input($_POST['admin_lastname']);
        $regex_fullname='/^[a-zA-z]*$/';
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_fullname,  $last_name) ){  
            $Err_lastname = "<p>the last name is not valid</p>";
        }
    }
    else{
        $errors++;
    }


    //validate phone
    if(isset($_POST['admin_phone']) && !empty($_POST['admin_phone'])){
        $phone=test_input($_POST['admin_phone']);
        $length = strlen ($phone); 
        $regex_phone = "/^[0-9]*$/";
        //check if name contains only letters and whitespace
        if (!preg_match ($regex_phone, $phone) || preg_match("/^[a-zA-z]*$/",$phone) || $length!=10 ) {  
            $Err_phone = "<p>phone number is not valid</p>";  
        }
    }
    else{
        $errors++;
    }


    //validate adress
    if(isset($_POST['admin_adress']) && !empty($_POST['admin_adress'])){
        $adress=test_input($_POST['admin_adress']);
        $regex_adress = "/[A-Za-z0-9\-\\,.]+/";
        //chec if name contains only letters and whitespace
        if (!preg_match ($regex_adress, $adress) ) {  
            $Err_adress = "<p>Adress is not valid</p>"; 
            $errors++;
        }
    }
    else{
        $errors++;
    }


    //validate email
    if (!empty($_POST["admin_email"])){        
        $email = test_input($_POST["admin_email"]);
        // check if e-mail address is well-formed
        $regex_email = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
        if (!preg_match ($regex_email, $email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){  
            $Err_email = "<p>Email is not valid</p>";
        }
    }
    else{
        $errors++;
    }


    //validate password
    if(!empty($_POST["admin_password"])){
        $password = test_input($_POST["admin_password"]);
        if(strlen($password)<8){
            $err_password_length="<p>password must contains more than 8 caracters</p>";
            $errors++;
        }else{
            $hashedpass=sha1($password);
        }
    }
    else{
        $errors++;
    }


    if(isset($_POST['add'])){
        $exist=$conn->prepare("SELECT * FROM subscriber WHERE email=?");
        $exist->execute(array($email));
        $count=$exist->rowCount();
        if($count>0){
            $exist_error='<p class="alert alert-danger">This email already exist</p>';
        }else{
            if($errors==0){
                //insert data in database
                $stmt=$conn->prepare("insert into subscriber(first_name,last_name,email,password,isadmin) values (?,?,?,?,?)");
                $stmt->execute(array($first_name,$last_name,$email,$hashedpass,1));
                $admin_added='<p class="alert alert-success">A new supplier has been added</p>';

                $sub_id=$conn->prepare("select id_subscriber from subscriber where email= ?");
                $sub_id->execute(array($email));
                $data =$sub_id->fetch(PDO::FETCH_ASSOC);
                //-----------------------------------------------------------------------
                $id=$data['id_subscriber'];
                $stmt=$conn->prepare("insert into phone(phone,phone_number,id_subscriber) values (?,?,?)");
                $stmt->execute(array($phone,1,$id));
                $id_admin_phone=$conn->lastInsertId();
                $stmt=$conn->prepare("insert into adresse(adress,adress_number,id_subscriber) values (?,?,?)");
                $stmt->execute(array($adress,1,$id));
                $id_admin_adress=$conn->lastInsertId();

                $stmt=$conn->prepare("UPDATE subscriber set id_phone=?,id_adresse=? WHERE email=?");
                $stmt->execute(array($id_admin_phone,$id_admin_adress,$email));
                $admin_added='<p class="alert alert-success">A new admin has been added</p>';
            }
        }
        
    }elseif(isset($_POST['stop'])){
        $delete=$conn->prepare("UPDATE subscriber SET is_active=? WHERE email=?");
        $delete->execute(array(0,$email));
        $admin_deleted='<p class="alert alert-success">This admin has been stopped</p>';
    }elseif(isset($_POST['save'])){
            /*$save=$conn->prepare("UPDATE fournisseur SET name_fournisseur=?,phone_fournisseur=?,adress_fournisseur=?,email_fournisseur=? WHERE email_fournisseur=?");
            $save->execute(array($fullname,$phone,$adress,$email,$email));
            $supplier_updated='<p class="alert alert-success">the supplier has been updated</p>';*/
    }
}

?>