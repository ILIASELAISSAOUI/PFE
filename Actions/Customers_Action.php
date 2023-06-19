<?php  

if(!isset($_SESSION['email']) || $_SESSION['verified']!=1){
    header("location:signIn.php");
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

//---------------Active------------------------
$stmts=$conn->prepare("SELECT distinct activity,email,last_name,first_name,phone,subscription_end,birthday,city,type_abonnement,adress FROM subscriber s inner join phone p inner join adresse a inner join orders o inner join abonnement ab where p.id_phone=s.id_phone and isadmin=0 and activity>=1 && a.id_adresse=s.id_adresse&& o.id_abonnement=ab.id_abonnement  && o.id_subscriber=s.id_subscriber;");    
$stmts->execute();
$table =$stmts->fetchall(PDO::FETCH_ASSOC);

//---------------Total CLIENTS ------------------------
$stmts=$conn->prepare("SELECT  email,last_name,first_name,phone,birthday,city,adress,activity FROM subscriber s inner join phone p inner join adresse a where p.id_phone=s.id_phone and isadmin=0 && a.id_adresse=s.id_adresse and activity>=1 ;");    
$stmts->execute();
$total =$stmts->fetchall(PDO::FETCH_ASSOC);

//--------------Search----------------------------

?>