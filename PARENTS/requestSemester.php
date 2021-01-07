<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

/*if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));*/

$id_individu = "-1";
if (isset($_POST['IDINDIVIDU'])) {
    $id_individu = $lib->securite_xss(base64_decode($_POST['IDINDIVIDU']));
}

$colname_annee_rq_individu = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_annee_rq_individu = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$periodes = array();

$query_bulletin = $dbh->query("SELECT DISTINCT i.NOM, b.IDPERIODE, b.IDCLASSROOM, p.NOM_PERIODE, b.IDANNEE, b.IDETABLISSEMENT 
                                         FROM BULLETIN b 
                                         INNER JOIN PERIODE p ON p.IDPERIODE = b.IDPERIODE 
                                         INNER JOIN INDIVIDU i ON i.IDINDIVIDU = b.IDINDIVIDU
                                         WHERE b.IDINDIVIDU = ".$id_individu." 
                                         AND b.IDANNEE = ".$colname_annee_rq_individu);

while ($rs_bulletin = $query_bulletin->fetchObject()) {
    array_push($periodes,$rs_bulletin);
}

echo json_encode($periodes);

?>
