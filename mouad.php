<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="upgrade.php">Modification</a></li>
            <li><a href="connexion.php">Affichage</a></li>
            <li><a href="connexion.php">Recherche</a></li>
        </ul>
    </nav>
</body>
</html>



//connexion file 
<?php
    session_start();

    $servername="localhost";
    $dbname="money";
    $username="root";
    $password="";
    try{
        $conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $e){ 
        echo "connection failed". $e->getMessage() ."<br>";
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['send'])){ 
            $user=$_POST['nom'];
            $password=$_POST['password'];
            $stmt = $conn->prepare("SELECT * FROM CLIENT WHERE COMPTE=? AND MOTDEPASSE=?");
            $stmt->execute(array($user,$password));
            $count=$stmt->rowCount();
            if ($count>0) {
                # emailexiste.
                $pass=$conn->prepare("SELECT CIN FROM subscriber WHERE COMPTE=?");
                $pass->execute(array($user));
                $rslt=$pass->fetch(PDO::FETCH_ASSOC);
                $_SESSION['CIN']=$rslt['CIN'];
                //---------------------------------------------------------------------------------------------------------
?>


//upgrade file
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['ajouter']) || isset($_POST['supprimer'])){
            if(!empty($_POST['liste_deroulante']) && !empty($_POST['date_prob']) && !empty($_POST['code_transfer'])){
                $type_prob=$_POST['liste_deroulante'];
                $date_prob=$_POST['date_prob'];
                $code_transfer=$_POST['code_transfer'];
            }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="upgrade.php" method="post">
        <select name="liste_deroulante" required>
                <option valeur="pr_transfert_code">Probleme de code de transfert</option>
                <option valeur="pr_notification">Probleme de notification</option>
        </select>
        <input type="date" name="date_prob">
        <input type="text" name="code_transfer">
        <input type="button" name="ajouter" value="Ajouter">
        <input type="button" name="supprimer" value="Supprimer">
    </form>
</body>
</html>
