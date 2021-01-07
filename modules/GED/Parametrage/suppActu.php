<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
require_once("classe/ActualiteManager.php");
require_once("classe/Actualite.php");
$niv=new ActualiteManager($dbh,'ACTUALITES');

$colname_rq_actu = "-1";
if (isset($_GET['idActu'])) {
    $colname_rq_actu = $_GET['idActu'];
}

$res = $niv->supprimer('IDACTUALITES',$colname_rq_actu);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header ("Location: journalEcole.php?msg=$msg&res=$res");
?>