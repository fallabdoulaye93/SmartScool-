<?php

session_start();
//require_once("restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
/******************************Veifier si la facture est deja generer*********************/
function si_facture_existe($mois,$inscription)
{

	
	$rq_result= $dbh->query(" SELECT IDFACTURE FROM FACTURE WHERE  MOIS=".$mois." AND IDINSCRIPTION=".$inscription);
	$row=$rq_result->fetchAll();
	$total_Rows=$rq_result->fetchColumn();
	if($total_Rows > 0 )
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
/******************************Fin*********************/
function code_identification() {
	// on declare une chaine de caractÃ¨res
$chaine = "0123456789";
//nombre de caractÃ¨res dans le mot de passe
$nb_caract = 6;
// on fait une variable contenant le futur pass
$pass = "";

//on fait une boucle
for($u = 1; $u <= $nb_caract; $u++) {
    
//on compte le nombre de caractÃ¨res prÃ©sents dans notre chaine
    $nb = strlen($chaine);
    
// on choisie un nombre au hasard entre 0 et le nombre de caractÃ¨res de la chaine
    $nb = mt_rand(0,($nb-1));
    
// on ajoute la lettre a la valeur de $pass
    $pass.=$chaine[$nb];
}

// on retourne le rÃ©sultat :

	return $pass;
}

function Generer_facture($mois,$montant,$inscription,$etablissement)
{
	
	
	if(si_facture_existe($mois,$inscription)==0)
	{
			$num_facture="FACT".code_identification().$etablissement;
			$INSERT= "INSERT INTO FACTURE(IDFACTURE, NUMFACTURE, MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, ETAT) ";
			 $INSERT.= " VALUES ('','".$num_facture."','".$mois."',$montant,'".date('Y-m-d')."',$inscription,$etablissement,0,$montant,0)";
			$rq_autorise = $dbh->query($INSERT) ;
	}
	 
}
//mis a jou r mon
/*function Maj_montant($IDFACTURE,$montant)
{
	global $database_connexion, $connexion;
	mysql_select_db($database_connexion, $connexion);
	$UPDATE= " UPDATE FACTURE SET MT_VERSE=MT_VERSE + $montant, MT_RELIQUAT=MT_RELIQUAT -$montant ";
	$UPDATE.= " WHERE IDFACTURE=$IDFACTURE";
	$result = @mysql_query($UPDATE, $connexion) ;
	 
}*/
//Mis a jour etat factur
//mis a jou r mon
/*function Maj_Etat($facture)
{
	global $database_connexion, $connexion;
	mysql_select_db($database_connexion, $connexion);
	$query=" SELECT MT_VERSE ,MONTANT FROM FACTURE WHERE IDFACTURE=$facture";
	$res=mysql_query($query,$connexion);
	$row=mysql_fetch_assoc($res);
	if($row['MT_VERSE']==$row['MONTANT'])
	{
		$update= " UPDATE FACTURE SET ETAT=1 ";
		$update.= " WHERE IDFACTURE=$facture ";
		$result = @mysql_query($update, $connexion) ;
	 
	}*/
	

?>