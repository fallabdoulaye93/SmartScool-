<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
require_once("classe/RecrutManager.php");
require_once("classe/Recrut.php");
$niv=new RecrutManager($dbh,'RECRUTE_PROF');

$colname_rq_classe_etab = "-1";
if (isset($_GET['IDRECRUTE_PROF'])) {
    $colname_rq_classe_etab = $lib->securite_xss(base64_decode($_GET['IDRECRUTE_PROF'])) ;
}

$res = $niv->supprimer('IDRECRUTE_PROF',$colname_rq_classe_etab);

if ($res==1) {
    $msg="Suppression effectuée avec succes";

}
else{
    $msg="Votre suppression a echouée";
}
header("Location: listeProfesseurRecrutes.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
?>