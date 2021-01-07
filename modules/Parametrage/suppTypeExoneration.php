<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(50,$_SESSION['profil']));

require_once("classe/TypeExonerationManager.php");
require_once("classe/TypeExoneration.php");
$niv=new TypeExonerationManager($dbh,'TYPE_EXONERATION');

$colname_rq_type_etab = "-1";
if (isset($_GET['idSalle'])) {
    $colname_rq_type_etab = $lib->securite_xss(base64_decode($_GET['idSalle']));
}

$res = $niv->supprimer('ROWID',$colname_rq_type_etab);

if ($res==1) {
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: typeExoneration.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>