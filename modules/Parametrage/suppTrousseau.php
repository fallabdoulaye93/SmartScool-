<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(53,$lib->securite_xss($_SESSION['profil'])));


require_once("classe/TrousseauManager.php");
require_once("classe/Trousseau.php");
$trou=new TrousseauManager($dbh,'TROUSSEAU');

$colname_rq_niveau_etab = "-1";
if (isset($_GET['Trou'])) {
    $colname_rq_niveau_etab = $lib->securite_xss(base64_decode($_GET['Trou']));
}

$res = $trou->supprimer('ROWID',$colname_rq_niveau_etab);

if ($res==1) {
    $rs1=$dbh->exec("DELETE FROM ELEMENT_TROUSSEAU WHERE FK_TROUSSEAU=".$colname_rq_niveau_etab);
    //var_dump($rs1);exit;
    if ($rs1>=1) {
         $msg="suppression reussie";

    }
    else{
        $msg="suppression echouee";
    }
}
header("Location: trousseau.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>