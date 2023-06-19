<?php
include "connectDB.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['save_changes'])){
        if(isset($_POST['newfirstName']) && !empty($_POST['newfirstName'])){
            $newfirstName=$_POST['newfirstName'];
            $update=$conn->prepare("UPDATE subscriber SET first_name=? WHERE id_subscriber=?");
            $update->execute(array($newfirstName,$_SESSION['id']));
        }
        if(isset($_POST['newlastName']) && !empty($_POST['newlastName'])){
            $newlastName=$_POST['newlastName'];
            $update=$conn->prepare("UPDATE subscriber SET last_name=? WHERE id_subscriber=?");
            $update->execute(array($newlastName,$_SESSION['id']));
        }
        if(isset($_POST['newadress']) && !empty($_POST['newadress'])){
            $newadress=$_POST['newadress'];
            $stmt0=$conn->prepare("select MAX(adress_number) as maxi FROM adresse where id_subscriber= ?");
            $stmt0->execute(array($_SESSION['id'])); 
            $rslt=$stmt0->fetch(PDO::FETCH_ASSOC);
            $nbr=$rslt['maxi'] +1;
            $stmt1=$conn->prepare("insert into adresse(adress,adress_number,id_subscriber) values (?,?,?);");
            $stmt1->execute(array($newadress,$nbr,$_SESSION['id'])); 
            $rslt1=$stmt1->fetch(PDO::FETCH_ASSOC);
            $id_adress=$conn->lastInsertId();
            $stmt=$conn->prepare("update subscriber set id_adresse=? where id_subscriber=?");
            $stmt->execute(array($id_adress,$_SESSION['id']));
        }
        if(isset($_POST['newcity']) && !empty($_POST['newcity'])){
            $newcity=$_POST['newcity'];
            $update=$conn->prepare("UPDATE subscriber SET city=? WHERE id_subscriber=?");
            $update->execute(array($newcity,$_SESSION['id']));
        }
        if(isset($_POST['newphone']) && !empty($_POST['newphone'])){
            $stmt0=$conn->prepare("select MAX(phone_number) as maxi FROM phone where id_subscriber= ?");
            $stmt0->execute(array($_SESSION['id'])); 
            $rslt=$stmt0->fetch(PDO::FETCH_ASSOC);
            $nbr=$rslt['maxi'] +1;
            $newphone=$_POST['newphone'];
            $stmt1=$conn->prepare("insert into phone(phone,phone_number,id_subscriber) values (?,?,?);");
            $stmt1->execute(array($newphone,$nbr,$_SESSION['id'])); 
            $rslt1=$stmt1->fetch(PDO::FETCH_ASSOC);
            $id_phone=$conn->lastInsertId();
            $stmt=$conn->prepare("update subscriber set id_phone=? where id_subscriber=?");
            $stmt->execute(array($id_phone,$_SESSION['id']));
        }
    }
    $notification='<p class="alert alert-success">Your informations has been modified succesfuly<p>';

}
?>