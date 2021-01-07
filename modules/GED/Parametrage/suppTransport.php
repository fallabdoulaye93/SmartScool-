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


require_once("classe/TransportManager.php");
require_once("classe/Transport.php");
$niv=new TransportManager($dbh,'SECTION_TRANSPORT');

$colname_rq_niveau_etab = "-1";
if (isset($_GET['ID_SECTION'])) {
    $colname_rq_niveau_etab = $lib->securite_xss(base64_decode($_GET['ID_SECTION']));
}

$res = $niv->supprimer('ID_SECTION',$colname_rq_niveau_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: sectionTransport.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>