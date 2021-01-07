<?php

	/*****************************************************************************
	Auteur du script : Gilbert Soueidy.
	Commentaires et mise en forme : Fr�d�ric Barbier.
	Soci�t� : Jula Cards SAS.
	Date : 27/10/2005
	Version : 1.1
	Description :	Apr�s que l'internaute ait pay� avec sa carte Jula, 
		ce programme sert � enregistrer la transaction chez le marchand et
		� envoyer une confirmation � Jula.
	*****************************************************************************/

	//Appel des fichiers de l'API
	require_once "julaMarchand.php";
	
	//R�cup�ration de la cha�ne crypt�e envoy�e en param�tre par socket
	$data=$_GET['rep'];
	
	//Test de l'option magic_quotes_gpc sur le serveur du marchand
	if (get_magic_quotes_gpc()) $data=stripslashes($data);

	//R�cup�ration des donn�es � partir de la cha�ne $data
	$trsdata = parseResponse($data);
	
	//Est-ce que la cha�ne re�ue a pu �tre d�crypt�e ?
	if ($trsdata['Errno'] != 0) {
		
		//Option : Enregistrez ici l'erreur en base de donn�e
		//Utilisez pour cela le param�tre $trsdata['Errno']
		print 'KO';
		print "Erreur dans l'appel de parseResponse. Code erreur = " . $trsdata['Errno'];
		
	} else {

			//Est-ce que la transaction a pu avoir lieu sur le serveur de Jula ?
			if ($trsdata['ReponseJULA'] == 1) {
			
				//Le paiement a pu �tre effectu�
				print 'transaction valid�';
				//Validez d�finitivement la transaction du client 
				//Utilisez pour cela le param�tre $trsdata['IDTransaction']

			} else {
				//Option : Enregistrez ici l'erreur en base de donn�e. Annulez la transaction.
				//Utilisez pour cela les param�tres $trsdata['IDTransaction'] et $trsdata['Errno'] 
			}
			
			//La requ�te a correctement �t� prise en compte
			print 'OK';
	}
?>