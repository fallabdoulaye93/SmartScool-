<?php
//session_start();
if (!isset($_SESSION)){
  session_start();
}

	 
	function VerificationTimer($dureeDeVie = 0) {
	
	// Si la var n'existe pas, on l'initialise au moment actuel
	if(!isset($_SESSION['MonTimer'])) $_SESSION['MonTimer'] = time();
	
	// time() renvoyant le format timestamp.
	
	// Ensuite on vérifie
	if($dureeDeVie) {
		
		// Si le dernier temps inscrit + la durée de vie imposée
		// est inférieur à l'instant, le temps imparti est écoulé
		// On détruit la session.
		if(($_SESSION['MonTimer'] + $dureeDeVie) < time()) {
			// ici tu n'es pas obligé de tout détruire, seulement 
			// les vars sensibles.
			unset($_SESSION);
			session_destroy();
			}
		}
	
	// On initialise à chaque rafraichissement le timer
	$_SESSION['MonTimer'] = time();
	}
	VerificationTimer(1440); 
// *** Restrict Access To Page: Grant or deny access to this page
if (!function_exists("isAuthorized")) {
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 
    
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
}
$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['id'])) && (isAuthorized("","", $_SESSION['id'], $_SESSION['profil'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
  //echo "<meta http-equiv='refresh' content='0;URL=$MM_restrictGoTo'>";
}

?>