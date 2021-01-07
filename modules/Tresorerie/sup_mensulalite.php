<?php

session_start();
//require_once("restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil'] != 1) 
$lib->Restreindre($lib->Est_autoriser(27,$_SESSION['profil']));


$colname_rq_ind = "-1";
if (isset($_GET['IDINDIVIDU'])) {
    $colname_rq_ind = $_GET['IDINDIVIDU'];
}

$res = $dbh->exec("delete from MENSUALITE WHERE IDMENSUALITE= ".$_GET['IDMENSUALITE']);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
echo "<meta http-equiv='refresh' content='0;URL=ficheMensualite.php?msg=$msg&res=$res'>";
?>