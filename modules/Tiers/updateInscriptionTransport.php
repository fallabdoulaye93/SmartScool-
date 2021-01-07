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

$action = "-1";
if (isset($_POST['ACTION']) && $_POST['ACTION']!="") {
    $action = intval($lib->securite_xss(base64_decode($_POST['ACTION'])));
}
$idIndividu = "-1";
if (isset($_POST['IDINDIVIDU']) && $_POST['IDINDIVIDU']!="") {
    $idIndividu = intval($lib->securite_xss(base64_decode($_POST['IDINDIVIDU'])));
}

if($action!= null || $action == "") {
    $date = date("Y-m-d H:i:s");
    if($action == 0 && $idIndividu!= null){
        $querry = $dbh->prepare("UPDATE INSCRIPTION SET TRANSPORT='0', MONTANT_TRANSPORT='0', FK_SECTION='0', DATE_DESAB_TRANSPORT='".$date."' WHERE IDINDIVIDU=".$idIndividu);
        $res = $querry->execute();
        if ($res != 0){
            $msg = 'Désabonnement a été effectué avec succés';
        }else{
            $msg = 'Le Désabonnement a échoué';
        }
        header("Location: listeEtudiant.php?msg=" . $msg . "&res=" . $res);
    }
    if($action == 1 && $idIndividu!= null) {

        $section = $lib->securite_xss(base64_decode($_POST['selectSection']));

        $query_REQ_transport = $dbh->query("SELECT ID_SECTION,LIBELLE,MONTANT FROM SECTION_TRANSPORT WHERE ID_SECTION=".$section);

        $re=$query_REQ_transport->fetchObject();

        $querry = $dbh->prepare("UPDATE INSCRIPTION SET TRANSPORT='1', MONTANT_TRANSPORT='".$re->MONTANT."', FK_SECTION='".$re->ID_SECTION."', DATE_AB_TRANSPORT='".$date."' WHERE IDINDIVIDU=".$idIndividu);
        $res = $querry->execute();
        if ($res != 0){
            $msg = 'Abonnement effectué avec succés';
        }else{
            $msg = 'L\'abonnement a échoué';
        }
        header("Location: listeEtudiant.php?msg=" . $msg . "&res=" . $res);
    }
}
?>
