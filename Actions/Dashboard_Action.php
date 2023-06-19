<?php 

if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){
    header("location:signIn.php");
} 
//---------------Active customers------------------
$stmt=$conn->prepare("SELECT count(id_subscriber) as total_activity FROM subscriber WHERE activity>=1 and isadmin=0");    
$stmt->execute();
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$stmt=$conn->prepare("SELECT count(id_subscriber) as total FROM subscriber where isadmin=0");    
$stmt->execute();
$rslt =$stmt->fetch(PDO::FETCH_ASSOC);
$total_activity=$dat["total_activity"];
$total1 =$rslt["total"];
$prcn=$total_activity*100 / $total1;
//----------------Total Profit-------------------------
$stmt=$conn->prepare("SELECT sum(b.prix_box) as total_box, sum(o.total_order) as total FROM orders o INNER JOIN box b ON o.id_box = b.id_box;");    
$stmt->execute();
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$total_box=$dat['total_box'];
$total=$dat['total'];
$profit=$total - $total_box;
//--------------Bugget------------------------------------------
$bdjt=$dat['total_box'];
//----------------------Diagramme cercle ----------------
$stmt=$conn->prepare("SELECT count(*) as agadir FROM subscriber WHERE activity>=1 and city='Agadir'and isadmin=0");    
$stmt->execute();
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$agadir = $dat['agadir'];

$stmt=$conn->prepare("SELECT count(*) as ouarzazate FROM subscriber WHERE activity>=1 and city='Ouarzazate' and isadmin=0");    
$stmt->execute();
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$ouarzazate = $dat['ouarzazate'];

$stmt=$conn->prepare("SELECT count(*) as marrakech FROM subscriber WHERE activity>=1 and city='Marrakech'and isadmin=0");    
$stmt->execute();
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$marrakech = $dat['marrakech'];

$stmt=$conn->prepare("SELECT count(*) as casablanca FROM subscriber WHERE activity>=1 and city='Casablanca'and isadmin=0");    
$stmt->execute();
$dat =$stmt->fetch(PDO::FETCH_ASSOC);
$casablanca = $dat['casablanca'];

//--------------------Diagramme 3wad----------------------------

//-------------------Table active --------------------------------
$stmts=$conn->prepare("SELECT email,last_name , first_name , subscription_end,phone,s.id_phone,birthday,city FROM subscriber s inner join phone p where p.id_phone=s.id_phone and activity>=1 and isadmin=0;");    
$stmts->execute();
$table =$stmts->fetchall(PDO::FETCH_ASSOC);

?>