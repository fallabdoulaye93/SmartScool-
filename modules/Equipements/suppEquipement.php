<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(15,$_SESSION['profil']));


require_once("classe/EquipementManager.php");
require_once("classe/Equipement.php");
$niv=new EquipementManager($dbh,'EQUIPEMENT');

$colname_rq_ue_etab = "-1";
if (isset($_GET['idEquipement'])) {
    $colname_rq_ue_etab = $lib->securite_xss($_GET['idEquipement']);
}

$res = $niv->supprimer('IDEQUIPEMENT',$colname_rq_ue_etab);

if ($res==1) {
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: inventaireEquipement.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>