<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(14,$_SESSION['profil']));

require_once("classe/CategorieEquipementManager.php");
require_once("classe/CategorieEquipement.php");
$categ = new CategorieEquipementManager($dbh,'CATEGEQUIP');

$colname_rq_categ_etab = "-1";
if (isset($_GET['idCategEquipement'])) {
    $colname_rq_categ_etab = $lib->securite_xss($_GET['idCategEquipement']);
}

$res = $categ->supprimer('IDCATEGEQUIP', $colname_rq_categ_etab);

if ($res==1)
{
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: accueil.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>