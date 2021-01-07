<?php
	/*****************************************************************************
	Auteur du script : NUMHERIT
	Société : NUMHERIT SARL
	Date : 24/12/2012
	Version : 1.0
	Description :	Définition de fonctions communes aux marchand et serveur.
	*****************************************************************************/

require_once "JulaConf.php";
require_once "JulaUtils.php";
require_once "JulaMarchandKey.php";
require_once "sha1lib.class.inc.php";

$DBG=0;



function generateRequestURL($trsdata){

	global $DBG, $JULA_SRV_URL,$POSTECASH_SRV_URL, $JULA_REQVAR, $JULA_MERCHANT_KEY ;

	$data="";
	$errno=0;
	$result=null;
	$JULAURL="";
	
	if ( count($trsdata) >= 1 ) {
		ksort($trsdata);
		reset($trsdata);
	}

	// Verifier ques les clés du tableau sont ceux définis dans $JULA_REQVAR
	$errno=checkRequestArray($trsdata);
	if ( $errno != 0 ) {
	 $result['Errno'] = $errno;
	 return $result;
	}

	// Recupere le nombre de variables à envoyer (nbre d'éléments du tableau + le checksum)
	$nbparams = count($JULA_REQVAR) + 1;

	// Calculer le checksum de toutes les variables; celles-ci sont concatenees par ordre alphabetique
	$merchantHash = computeHash($trsdata, $JULA_MERCHANT_KEY);
	
	// Appeler la fonction de génération des données codées
	$data = generateDataString($trsdata, $nbparams, $merchantHash);
		
	// Generer l'URL contenant les donnees codees
	if($trsdata['type']==1)
	$JULAURL = $JULA_SRV_URL . "?sid=" . urlencode($data);
	else
	$JULAURL = $POSTECASH_SRV_URL . "?sid=" . urlencode($data);
	// Ajouter l'Id Marchand pour obtenir l'URL finale
	$JULAURL .= "&IDMerchant=" . $trsdata['IDMerchant'];

	$result['Errno']=0;
	$result['RedirectURL']=$JULAURL;
	
	return $result;
}



// On suppose que les data ont deja eté url-decodee (urldecode) 
function parseResponse($sid) {
	
	global $DBG, $JULA_RESVAR, $JULA_GENERAL_ERRORS, $JULA_MERCHANT_KEY;
	
	if ($DBG) print "\n<br>Entering parseResponse<br>\n";


	// Trier le tableau de reference pour que les valeurs soient correctement copies
 	sort($JULA_RESVAR);
 	reset($JULA_RESVAR);
 	
 	$trsdata=null;
 	 	 	
 	// parser le sid 	
 	$trsdata = parseDataString($sid, $JULA_RESVAR); 	
 	if ( $trsdata['Errno'] != 0 ) {
 		return $trsdata;
 	}
 	
 	// Supprimer les clefs merchantHash et Errno de l'array retourné. merchantHash sera sauvegardé dans $merchantHash
 	$merchantHash = $trsdata['merchantHash'];
 	$newTrsData = $trsdata;
 	$trsdata=null;
 	foreach($newTrsData as $key=>$val) {
 		if ( strcmp($key, 'merchantHash') && strcmp($key, 'Errno') ) {
 			$trsdata[$key]=$val;
 		} 		
 	}
 	 	
 	// vérifier le hash
 	$errno = checkHash($trsdata, $JULA_MERCHANT_KEY, $merchantHash);
 	if($DBG){
 		print "parseResponse: checkHash returned $errno<br>\n";
 	}
 	
 	if ( $errno != 0) {
 		$trsdata=null;
 		$trsdata['Errno']=$errno;
 		return $trsdata;
 	}
 	
	// Every thing went ok.
	$trsdata['Errno'] = 0;
	return $trsdata;
}
?>