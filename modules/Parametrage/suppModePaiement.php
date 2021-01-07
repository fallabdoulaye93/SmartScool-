<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(49,$lib->securite_xss($_SESSION['profil'])));


require_once("classe/ModePaiementManager.php");
require_once("classe/ModePaiement.php");
$niv=new ModePaiementManager($dbh,'MODE_PAIEMENT');

$colname_rq_niveau_etab = "-1";
if (isset($_GET['ROWID'])) {
    $colname_rq_niveau_etab = $lib->securite_xss(base64_decode($_GET['ROWID']));
}

$res = $niv->supprimer('ROWID',$colname_rq_niveau_etab);

if ($res==1) {
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: modePaiement.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>