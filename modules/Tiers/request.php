<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

//if($_SESSION['profil']!=1)
    ///$lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));
$colname_rq_individu = "-1";

$action = "-1";
if (isset($_POST['ACTION']) && $_POST['ACTION']!="") {
    $action = intval($lib->securite_xss(base64_decode($_POST['ACTION'])));
}
$idIndividu = "-1";
if (isset($_POST['IDINDIVIDU']) && $_POST['IDINDIVIDU']!="") {
    $idIndividu = intval($lib->securite_xss(base64_decode($_POST['IDINDIVIDU'])));
}
$query_rq_individu = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, PRENOMS, NOM FROM INDIVIDU INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU  WHERE INDIVIDU.IDINDIVIDU=".$idIndividu);

$result= $query_rq_individu->fetchObject();

echo json_encode($result);

?>
