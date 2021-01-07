<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(49, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/NivManager.php");
require_once("classe/Niv.php");
$niv = new NivManager($dbh,'NIV_CLASSE');

$colname_rq_classe_etab = "-1";
if (isset($_GET['niv']))
{
    $colname_rq_classe_etab = base64_decode($lib->securite_xss($_GET['niv']));
}

$res = $niv->supprimer('ID',$colname_rq_classe_etab);
if ($res==1)
{
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: niv.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>