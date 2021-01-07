<?php
if (!isset($_SESSION)) {
  session_start();
}


	/*****************************************************************************


	Description :	Programme d'envoi de la requête de paiement vers Neosurf.

		Ce programme récupère les différentes variables utiles au paiement 

		dans un tableau nommé '$trsdata',	puis il redirige l'internaute vers

		l'interface de paiement de Neosurf.

	*****************************************************************************/

	

	//Appel des fichiers de l'API

	require_once "JulaMarchand.php";
	//include_once("../fonctions-panier.php");
	//include_once("../fonctions-panier.php");
/* Début des variables à personnaliser pour chaque marchand (N=numérique, A=alphanumérique) */	



	

	// Votre identifiant Marchand auprès de Neosurf (Information fournie par Neosurf)

//	$IDMerchant = 1;// (N6)





	// L'URL complète de la page qui est chargée d'enregistrer la confirmation du paiement.

	// Ex : http://www.MerchantSite.com/NeosurfMerchantReceive.php

	$urlretour =$_SESSION['redirection'];



	// Identifiant de transaction unique généré par le marchand. 

	// Attention : Chaque valeur du paramètre $IDTransaction DOIT ETRE UNIQUE et sera conservée à la fois par le marchand mais également par Neosurf.

	// C'est le référentiel pour chaque transaction entre Neosurf et le site marchand.  

	$IDTransaction = "sunuEcole".rand(0,999999);// (A255)
	$_SESSION['IDTransaction']=$IDTransaction;
	

	// Montant de la transaction en euros. De 0.01 à 9999.99 euros.

	$amount =$_SESSION['montant'];// (N7)



	// L'URL complète de la page où se redirigé l'internaute à la fin du paiement.

	// Ex : http://www.MerchantSite.com/page_endTransaction.php
	$URLReturn = $URLConfirmation;
	//$URLReturn = "https://www.sunustore.com/comfirmPayment.php?mp=2";// (A255)


	$email=$_SESSION['email'];
	//$IDMerchant=1;
	$IDMerchant=20;


/* Fin des variables à personnaliser */

	

	

	// Enregistrement des données dans le tableau $trsdata 

	$trsdata['IDMerchant'] = $IDMerchant;



	$trsdata['num_transaction'] = $IDTransaction;

	$trsdata['amount'] = $amount;

	$trsdata['email_acheteur'] = $email;  
	$trsdata['type'] = 2;
	$trsdata['URLReturn'] = $urlretour;



	// Appel de l'API pour générer l'URL codée

	$result=generateRequestURL($trsdata);

	

	if ( $result['Errno'] != 0 ) {

		

		print "Erreur dans l'appel de generateRequestURL. Code erreur =" . $result['Errno'] . "<br>\n";

		

	} else {

		
		//Pas d'erreur : Redirection de l'internaute vers l'interface de paiement Neosurf
		//print $result['RedirectURL'];
		header("Location: " . $result['RedirectURL']);
		

		die;

	}

?>