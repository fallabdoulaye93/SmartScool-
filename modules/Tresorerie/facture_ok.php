<?php

require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil'] != 1) 
$lib->Restreindre($lib->Est_autoriser(40,$_SESSION['profil']));


$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_classe = $_SESSION['etab'];
}


if(isset($_POST['envoyer2']) && $_POST['envoyer2']!="" && $_POST['MOIS']!="" && $_POST['ANNEE']!=""){
	$res="-1";
	$msg="Generation de facture echouee";
	
$colname_rq_inscription = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_inscription = $_SESSION['etab'];
}

$query_rq_inscription = $dbh->query("SELECT * FROM INSCRIPTION WHERE IDETABLISSEMENT = ".$colname_rq_inscription." AND INSCRIPTION.IDINSCRIPTION=".$_POST['ETUDIANT']." AND IDANNEESSCOLAIRE=".$_SESSION['ANNEESSCOLAIRE']);
$row_rq_inscription= $query_rq_inscription->fetchObject();



$mois=$_POST['MOIS']."-".$_POST['ANNEE'];

	if($query_rq_inscription->rowCount() > 0 )
	{
		$lib->Generer_facture($mois,$row_rq_inscription->ACCORD_MENSUELITE,$row_rq_inscription->IDINSCRIPTION,$_SESSION['etab']);
		$res=1;
		$msg="Factures du candidat generee avec succès";
	}
	
	header('Location: generationFacture.php?res='.$res.'&msg='.$msg);
}
?>
