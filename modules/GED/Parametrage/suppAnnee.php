<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(11, $lib->securite_xss($_SESSION['profil'])));


require_once("classe/AnneeScolaireManager.php");
require_once("classe/AnneeScolaire.php");
$niv=new AnneeScolaireManager($dbh,'ANNEESSCOLAIRE');

$colname_rq_annee_etab = "-1";
if (isset($_GET['idAnnee'])) {
    $colname_rq_annee_etab = base64_decode($lib->securite_xss($_GET['idAnnee']));
}

$res = $niv->supprimer('IDANNEESSCOLAIRE',$colname_rq_annee_etab);

if ($res==1) {
    $msg="suppression reussie";

}
else{
    $msg="suppression echouee";
}
header("Location: anneesScolaires.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>