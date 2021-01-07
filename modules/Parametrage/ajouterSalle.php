<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/SalleManager.php");
require_once("classe/Salle.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(8, $lib->securite_xss($_SESSION['profil'])));

$salle=new SalleManager($dbh,'SALL_DE_CLASSE');


if(isset($_POST) && $_POST !=null)
{
    $res=$salle->insert($lib->securite_xss_array($_POST));
    $urlredirect="";
    if($res==1)
    {
        $msg = 'Ajout effectué avec succés';
    }
    else{
        $msg = 'Ajout effectué avec echec';
    }
    header("Location: salle.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>