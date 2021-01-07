<?php

	/*****************************************************************************
	Auteur du script : Gilbert Soueidy.
	Commentaires et mise en forme : Frédéric Barbier.
	Société : Jula Cards SAS.
	Date : 27/10/2005
	Version : 1.1
	Description :	Après que l'internaute ait payé avec sa carte Jula, 
		ce programme sert à enregistrer la transaction chez le marchand et
		à envoyer une confirmation à Jula.
	*****************************************************************************/

	//Appel des fichiers de l'API
	require_once "julaMarchand.php";
	
	//Récupération de la chaîne cryptée envoyée en paramètre par socket
	$data=$_GET['rep'];
	
	//Test de l'option magic_quotes_gpc sur le serveur du marchand
	if (get_magic_quotes_gpc()) $data=stripslashes($data);

	//Récupération des données à partir de la chaîne $data
	$trsdata = parseResponse($data);
	
	//Est-ce que la chaîne reçue a pu être décryptée ?
	if ($trsdata['Errno'] != 0) {
		
		//Option : Enregistrez ici l'erreur en base de donnée
		//Utilisez pour cela le paramètre $trsdata['Errno']
		print 'KO';
		print "Erreur dans l'appel de parseResponse. Code erreur = " . $trsdata['Errno'];
		
	} else {

			//Est-ce que la transaction a pu avoir lieu sur le serveur de Jula ?
			if ($trsdata['ReponseJULA'] == 1) {
			
				//Le paiement a pu être effectué
				print 'transaction validé';
				//Validez définitivement la transaction du client 
				//Utilisez pour cela le paramètre $trsdata['IDTransaction']

			} else {
				//Option : Enregistrez ici l'erreur en base de donnée. Annulez la transaction.
				//Utilisez pour cela les paramètres $trsdata['IDTransaction'] et $trsdata['Errno'] 
			}
			
			//La requête a correctement été prise en compte
			print 'OK';
	}
?>