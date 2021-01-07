<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();



if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(4,$lib->securite_xss($_SESSION['profil'])));


require_once("classe/FiliereManager.php");
require_once("classe/Filiere.php");
$niv=new FiliereManager($dbh,'SERIE');

$colname_rq_serie_etab = "-1";
if (isset($_GET['idSerie'])) {
    $colname_rq_serie_etab = $lib->securite_xss(base64_decode($_GET['idSerie']));
}

$res = $niv->supprimer('IDSERIE',$colname_rq_serie_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: filieres.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>