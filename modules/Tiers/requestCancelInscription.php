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

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));
$colname_rq_individu = "-1";

$idInscription = "-1";
if (isset($_POST['IDINSCRIPTION']) && $_POST['IDINSCRIPTION']!="") {
    $idInscription = intval($lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])));
}
$query_rq_Inscription = $dbh->query("SELECT INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, IDINSCRIPTION FROM INDIVIDU INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU  WHERE IDINSCRIPTION=".$idInscription);

$result= $query_rq_Inscription->fetchObject();

echo json_encode($result);

?>
