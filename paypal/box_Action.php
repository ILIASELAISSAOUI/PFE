<?php 

include "Includes/header.php";

$paypal= new paypalSubs(PAYPAL_USERNAME,PAYPAL_PASSWORD,PAYPAL_SIGNATURE,getOffers());
$stmt=$conn->prepare("SELECT * FROM subscriber WHERE id_subscriber=?");    
//$i=85;
$stmt->execute(array($_SESSION['id']));
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$end= new DateTime($dat['subscription_end']);

    if(isset($_POST['offer'])){
      $paypal->subscribe($_POST['offer']);

    }

?>