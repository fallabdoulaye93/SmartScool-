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
/*
if($_SESSION['profil']!=1)
$lib->Restreindre($lib->Est_autoriser(36,$lib->securite_xss($_SESSION['profil'])));*/

if(isset($_POST['filiere']) && $_POST['filiere'] != "" && isset($_POST['niveau']) && $_POST['niveau'] !=""){
    $filiere = intval($lib->securite_xss($_POST['filiere']));
    $niveau = intval($lib->securite_xss($_POST['niveau']));

    $query_rq_fi_etab = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE IDNIVEAU =".$niveau." AND IDSERIE=".$filiere);
    $res = $query_rq_fi_etab->fetchObject();

    if($res){
        echo json_encode($res);
    } else {
        echo -1;
    }

} else {
    echo -1;
}
?>