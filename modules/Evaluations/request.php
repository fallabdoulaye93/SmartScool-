<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));
$colname_rq_individu = "-1";

if (isset($_GET['IDCLASSROOM']))
{
    $colname_rq_individu = $lib->securite_xss(base64_decode($_GET['IDCLASSROOM']));
}

$colname_annee_rq_individu = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $colname_annee_rq_individu = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$idNote = "-1";
if (isset($_POST['noteID']) && $_POST['noteID']!="") {
    $idNote = $lib->securite_xss($_POST['noteID']);
}

$query_rq_individu = $dbh->query("SELECT IDNOTE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.IDINDIVIDU, CONTROLE.LIBELLE_CONTROLE, 
                                            NOTE.NOTE, CONTROLE.IDCONTROLE, CONTROLE.IDCLASSROOM 
                                            FROM NOTE 
                                            INNER JOIN INDIVIDU ON NOTE.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            INNER JOIN CONTROLE ON CONTROLE.IDCONTROLE = NOTE.IDCONTROLE 
                                            WHERE IDNOTE = ".$idNote);

$result= $query_rq_individu->fetchObject();

echo json_encode($result);

?>
