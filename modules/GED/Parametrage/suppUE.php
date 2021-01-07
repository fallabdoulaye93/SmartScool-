<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(6,$lib->securite_xss($_SESSION['profil'])));

require_once("classe/UEManager.php");
require_once("classe/UE.php");
$niv=new UEManager($dbh,'UE');

$colname_rq_ue_etab = "-1";
if (isset($_GET['idUE'])) {
    $param=json_decode(base64_decode($lib->securite_xss($_GET['idUE'])));
    $colname_rq_ue_etab=$param->id;
}

$res = $niv->supprimer('IDUE',$colname_rq_ue_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: uniteEnseignement.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>