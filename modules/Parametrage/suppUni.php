<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(53, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/UniformeManager.php");
require_once("classe/Uniforme.php");
$uni = new UniformeManager($dbh,'UNIFORME');

$colname_rq_classe_etab = "-1";
if (isset($_GET['uni']))
{
    $colname_rq_classe_etab = base64_decode($lib->securite_xss($_GET['uni']));
}

$res = $uni->supprimer('ROWID',$colname_rq_classe_etab);
if ($res==1)
{
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: uniforme.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>