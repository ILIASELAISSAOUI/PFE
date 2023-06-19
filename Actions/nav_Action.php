<?php
session_start();
include "paypal/paypalclass.php";
include "Actions/connectDB.php";
 if(isset($_GET['x']) && $_GET['x']=="SignOut"){
    session_destroy();
    header("location:signIn.php");
} 

$paypal= new paypalSubs(PAYPAL_USERNAME,PAYPAL_PASSWORD,PAYPAL_SIGNATURE,getOffers());
$stmt=$conn->prepare("SELECT * FROM subscriber WHERE id_subscriber=?");    
//$i=85;
$stmt->execute(array($_SESSION['id']));
$dat =$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['cancel'])){
    $stmt = $conn->prepare("DELETE o from orders o inner join subscriber s left join (SELECT max(date_order) as maxiu FROM orders) as maxi   on o.id_subscriber=s.id_subscriber where date_order=maxi.maxiu and o.id_subscriber=?;");
    $stmt->execute(array($_SESSION['id']));
    $paypal->unsubscribe($dat['profile_id'],$conn);
    $stmt=$conn->prepare("UPDATE subscriber SET profile_id=NULL  WHERE id_subscriber=?");    
    $stmt->execute(array($_SESSION['id']));
        header("location: nav.php?x=Box");
  }

?>