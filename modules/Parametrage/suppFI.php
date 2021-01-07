<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(7,$lib->securite_xss($_SESSION['profil'])));


require_once("classe/FraisInscriptionManager.php");
require_once("classe/FraisInscription.php");
$niv=new FraisInscriptionManager($dbh,'NIVEAU_SERIE');

$colname_rq_fi_etab = "-1";
if (isset($_GET['id'])) {
    $param=json_decode(base64_decode($_GET['id']));
    $colname_rq_fi_etab=$param->id;
}

$res = $niv->supprimer('ID_NIV_SER',$colname_rq_fi_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: fraisInscription.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>