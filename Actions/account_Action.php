<?php

include "Actions/connectDB.php";


if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){
    header("location:signIn.php");
}  

//-----------------------------------------------select data from database ---------------------------------------
$info=$conn->prepare("SELECT first_name,last_name,city,id_phone,id_adresse FROM subscriber WHERE email=?");
$info->execute(array($_SESSION['email']));
$data1=$info->fetch();

$adress=$conn->prepare("SELECT adress FROM adresse WHERE id_adresse=?");
$adress->execute(array($data1['id_adresse']));
$data2=$adress->fetch();

$phone=$conn->prepare("SELECT phone FROM phone WHERE id_phone=?");
$phone->execute(array($data1['id_phone']));
$data3=$phone->fetch();

//put all informations in sessions
$_SESSION['firstName']=$data1['first_name'];
$_SESSION['lastName']=$data1['last_name'];
$_SESSION['adress']=$data2['adress'];
$_SESSION['phone']=$data3['phone'];

?>