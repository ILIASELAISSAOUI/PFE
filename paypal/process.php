<?php 
 include 'paypalclass.php';
 include '../Actions/connectDB.php';
 session_start();
 
$paypal= new paypalSubs(PAYPAL_USERNAME,PAYPAL_PASSWORD,PAYPAL_SIGNATURE,getOffers());
$paypal->getCheckoutDetail($_GET['token']);
$paypal->doSubscribe($_GET['token'],$_SESSION['id'],$conn);
header("location: ../nav.php?x=Box");
?>