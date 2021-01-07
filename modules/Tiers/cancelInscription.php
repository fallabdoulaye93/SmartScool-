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

$idInscription = "-1";
if (isset($_POST['IDINSCRIPTION']) && $_POST['IDINSCRIPTION']!="") {
    $idInscription = intval($lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])));
}
if(isset($_POST['motif']) && $_POST['motif']!=""){
    $motif = $lib->securite_xss($lib->affichage_xss($_POST['motif']));
}
try{
    $querry = $dbh->exec("UPDATE INSCRIPTION SET ETAT='0', MOTIF_ANNULATION='".$motif ."' WHERE IDINSCRIPTION=".$idInscription);
    $msg = 'L\'nnulation de l\'inscription a été effectuée avec succés';
    $res = 1;
}
catch(PDOException $e){
    $msg = 'L\'action a échoué';
    $res = 0;
}

header("Location: detailHistoInscription.php?IDSERIE=".$_POST['IDSERIE']."&IDNIVEAU=".$_POST['IDNIVEAU']."&LIBSERIE=".$_POST['LIBSERIE']."&NIVEAU=".$_POST['NIVEAU']."&msg=" . $msg . "&res=" . $res);
?>
