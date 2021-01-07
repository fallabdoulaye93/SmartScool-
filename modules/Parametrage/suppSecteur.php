<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(51,$_SESSION['profil']));

require_once("classe/SecteurManager.php");
require_once("classe/Secteur.php");
$niv=new SecteurManager($dbh,'secteur_activite');

$colname_rq_type_etab = "-1";
if (isset($_GET['ban']))
{
    $colname_rq_type_etab = $lib->securite_xss(base64_decode($_GET['ban']));
}

$res = $niv->supprimer('IDSECTEUR', $colname_rq_type_etab);

if ($res==1)
{
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: secteur.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>