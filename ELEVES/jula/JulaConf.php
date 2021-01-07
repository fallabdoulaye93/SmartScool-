<?php
	/*****************************************************************************
	Auteur du script : Bocar SY.
	Société : NUMHERIT.
	Description : Fichier de configuration nécessaire aux APIs 
	*****************************************************************************/
	
	//$JULA_SRV_URL = "http://www.jula.com/api/verif.php";
	//$POSTECASH_SRV_URL = "https://www.postecash.sn/ApiNumHerit/main.php";
	$JULA_SRV_URL = "http://www.numherit-labs.com/jula/api/verif.php";
	$POSTECASH_SRV_URL = "http://www.numherit-labs.com/postecash/ApiNumHerit/main.php";

	

	$JULA_GENERAL_ERRORS = array(
		'InvalidRequestKey' => 1000, // Erreur quand l'input array du marchand contient une mauvaise clé
		'InvalidResponseKey' => 2000, // Erreur quand l'input array du serveur contient une mauvaise clé
		'HashError' => 500, // Erreur quand le hash de la requête n'est pas correct
		'InvalidDataFormat' => 1001, // Erreur quand le nb de variables envoyés par le marchand est < 2 ou quand l'URL a un mauvais format
		'RequestMechantIdError' => 1002 // Erreur quand l'Id du marchand contenu dans l'URL a été modifié
	);

	/*
	 * PARAMETRES DE LA REQUETE DE PAIEMENT
	 */
	 
	// L'array contenant le nom des variables utilisée dans la requête de paiement
	$JULA_REQVAR = array ( 'IDMerchant', 'num_transaction','amount','email_acheteur','type', 'URLReturn');


	// le tableau contenant la taille max des champs de la requête
	$JULA_MAXLEN_REQVAR = array(
		'IDMerchant' => 6 ,
		'num_transaction' => 45 ,
		'amount' => 7,
		'email_acheteur' => 45,
		'type' => 2,
		'URLReturn' => 255
	);
	// Les erreurs retournés quand un champ est trop long 
	$JULA_MAXLEN_REQVAR_ERRNO = array(
		'IDMerchant' => 1020,
		'num_transaction' => 1021,
		'amount' => 1022,
		'email_acheteur' => 1023,
		'type' => 1024,
		'URLReturn' => 1025
	);

	// The maximum length of transaction fields
	$JULA_TYPES_REQVAR = array(
		'IDMerchant' => 'N' ,
		'num_transaction' => 'A' ,
		'amount' => 'N',
		'email_acheteur' => 'A',
		'type' => 'N',
		'URLReturn' => 'A'
	);


	// Les erreurs retournés quand un champ a un mauvais type
	$JULA_TYPES_REQVAR_ERRNO = array(
		'IDMerchant' => 1040,
		'num_transaction' => 1041,
		'amount' => 1042,
		'email_acheteur' => 1043,
		'type' => 1044,
		'URLReturn' => 1045
	);

	// Les erreurs retournes quand un champ manque
	$JULA_MISSING_REQVAR_ERRNO = array(
		'IDMerchant' => 1060,
		'num_transaction' => 1061,
		'amount' => 1062,
		'email_acheteur' => 1063,
		'type' => 1064,
		'URLReturn' => 1065
	);
?>