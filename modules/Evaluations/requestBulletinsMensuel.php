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

$etab = "-1";
if (isset($_SESSION['etab'])) {
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$anneescolaire = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $anneescolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$idClassroom = "-1";
if (isset($_POST['IDCLASSROOM']) && $_POST['IDCLASSROOM']!="") {
    $idClassroom = intval($lib->securite_xss(base64_decode($_POST['IDCLASSROOM'])));
}

$mois = "-1";
if (isset($_POST['MOIS']) && $_POST['MOIS'] !="" ) {
    $mois = intval($lib->securite_xss(base64_decode($_POST['MOIS'])));
}

$query_rq_classe = $dbh->query("SELECT ROWID FROM BULLETIN 
                                          WHERE IDCLASSROOM = ".$idClassroom." 
                                          AND MOIS = ".$mois."
                                          AND IDANNEE =".$anneescolaire." 
                                          AND IDETABLISSEMENT=".$etab);
$count = $query_rq_classe->rowCount();

$data = "";
if($count == 0) {
    $query_rq_controle =   $dbh->query("SELECT CONTROLE.IDCONTROLE
                                        FROM CONTROLE
                                        WHERE CONTROLE.VALIDER = 1
                                        AND  CONTROLE.IDCLASSROOM = ".$idClassroom."  
                                        AND (CONTROLE.IDTYP_CONTROL = 1)  
                                        AND MONTH(CONTROLE.DATEDEBUT) = '".$mois."'
                                        AND MONTH(CONTROLE.DATEFIN) = '".$mois."'
                                        AND CONTROLE.IDANNEE = '".$anneescolaire."' 
                                        AND CONTROLE.IDETABLISSEMENT = '".$etab."' ");
  //  var_dump($query_rq_controle);exit;
    $count1 = $query_rq_controle->rowCount();
    if($count1==0) $data = -2;else $data = 0;

}elseif ($count > 0) {
    $data = -1;
}
echo json_encode($data);

?>
