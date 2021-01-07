<?php
if (!isset($_SESSION)) {
  session_start();
}


	/*****************************************************************************


	Description :	Programme d'envoi de la requ�te de paiement vers Neosurf.

		Ce programme r�cup�re les diff�rentes variables utiles au paiement 

		dans un tableau nomm� '$trsdata',	puis il redirige l'internaute vers

		l'interface de paiement de Neosurf.

	*****************************************************************************/

	

	//Appel des fichiers de l'API

	require_once "JulaMarchand.php";
	//include_once("../fonctions-panier.php");
	//include_once("../fonctions-panier.php");
/* D�but des variables � personnaliser pour chaque marchand (N=num�rique, A=alphanum�rique) */	



	

	// Votre identifiant Marchand aupr�s de Neosurf (Information fournie par Neosurf)

//	$IDMerchant = 1;// (N6)





	// L'URL compl�te de la page qui est charg�e d'enregistrer la confirmation du paiement.

	// Ex : http://www.MerchantSite.com/NeosurfMerchantReceive.php

	$urlretour =$_SESSION['redirection'];



	// Identifiant de transaction unique g�n�r� par le marchand. 

	// Attention : Chaque valeur du param�tre $IDTransaction DOIT ETRE UNIQUE et sera conserv�e � la fois par le marchand mais �galement par Neosurf.

	// C'est le r�f�rentiel pour chaque transaction entre Neosurf et le site marchand.  

	$IDTransaction = "sunuEcole".rand(0,999999);// (A255)
	$_SESSION['IDTransaction']=$IDTransaction;
	

	// Montant de la transaction en euros. De 0.01 � 9999.99 euros.

	$amount =$_SESSION['montant'];// (N7)



	// L'URL compl�te de la page o� se redirig� l'internaute � la fin du paiement.

	// Ex : http://www.MerchantSite.com/page_endTransaction.php
	$URLReturn = $URLConfirmation;
	//$URLReturn = "https://www.sunustore.com/comfirmPayment.php?mp=2";// (A255)


	$email=$_SESSION['email'];
	//$IDMerchant=1;
	$IDMerchant=20;


/* Fin des variables � personnaliser */

	

	

	// Enregistrement des donn�es dans le tableau $trsdata 

	$trsdata['IDMerchant'] = $IDMerchant;



	$trsdata['num_transaction'] = $IDTransaction;

	$trsdata['amount'] = $amount;

	$trsdata['email_acheteur'] = $email;  
	$trsdata['type'] = 2;
	$trsdata['URLReturn'] = $urlretour;



	// Appel de l'API pour g�n�rer l'URL cod�e

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