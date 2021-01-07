<?php
session_start();

require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
require_once("classe/IndividuManager.php");
require_once("classe/Individu.php");
$ind = new IndividuManager($dbh,'INDIVIDU');

$colname_rq_ind = "-1";

if(isset($_GET['idIndividu']))
{
    $param = base64_decode($lib->securite_xss($_GET['idIndividu']));
}

$res = $ind->supprimer('IDINDIVIDU', $param);
if($res == 1)
{
    $msg="suppression reussie";
}
else{
    $msg="suppression echouee";
}
header("Location: listeTuteurs.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
//echo "<meta http-equiv='refresh' content='0;URL=accueil.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res)."'>";
?>