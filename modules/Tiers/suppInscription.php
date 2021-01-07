<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
require_once("classe/InscriptionManager.php");
require_once("classe/Inscription.php");
$ins=new InscriptionManager($dbh,'INSCRIPTION');

$colname_rq_ins_etab = "-1";
if (isset($_GET['idInscription'])) {
    $colname_rq_ins_etab = $lib->securite_xss(base64_decode($_GET['idInscription']));
}

$res = $ins->supprimer('IDINSCRIPTION',$colname_rq_ins_etab);

if ($res==1) {
    $IDINDIVIDU="";
    if(isset($_GET['IDINDIVIDU'])&& $_GET['IDINDIVIDU']!="")
    {
        $IDINDIVIDU= $lib->securite_xss(base64_decode($_GET['IDINDIVIDU']) );
    }
    $colanne_rq_annee = "-1";
    if (isset($_SESSION['ANNEESSCOLAIRE'])) {
        $colanne_rq_annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
    }
    $query_delete = $dbh->exec("DELETE FROM `AFFECTATION_ELEVE_CLASSE` WHERE `IDINDIVIDU`=".$IDINDIVIDU." AND `IDANNEESSCOLAIRE` =".$colanne_rq_annee);
    if ($query_delete){
        $msg="suppression reussie";
    }

}
else{
    $msg="suppression echouee";
}
header("Location: detailHistoInscription.php?msg=".$msg."&res=".$res);
?>