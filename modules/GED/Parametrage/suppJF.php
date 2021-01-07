<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(9,$_SESSION['profil']));


require_once("classe/JourFeriesManager.php");
require_once("classe/JourFeries.php");
$niv=new JourFeriesManager($dbh,'VACANCES');

$colname_rq_jf_etab = "-1";
if (isset($_GET['idJF'])) {
    $colname_rq_jf_etab = base64_decode($lib->securite_xss($_GET['idJF']));
}

$res = $niv->supprimer('IDJOUR_FERIES',$colname_rq_jf_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: joursFeries.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>