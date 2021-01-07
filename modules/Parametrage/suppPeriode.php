<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(12,$lib->securite_xss($_SESSION['profil'])));


require_once("classe/PeriodeScolaireManager.php");
require_once("classe/PeriodeScolaire.php");
$niv=new PeriodeScolaireManager($dbh,'PERIODE');

$colname_rq_periode_etab = "-1";
if (isset($_GET['idPeriode'])) {
    $colname_rq_periode_etab = base64_decode($lib->securite_xss($_GET['idPeriode']));
}

$res = $niv->supprimer('IDPERIODE',$colname_rq_periode_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: periodeScolaires.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>