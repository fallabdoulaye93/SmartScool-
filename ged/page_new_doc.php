<?php require_once('../Connections/connexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php require_once('../Connections/connexion.php'); 
include('../restriction_page.php');?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$colname_rq_doc = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_doc = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_doc = sprintf("SELECT * FROM DOCADMIN WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_doc, "int"));
$rq_doc = mysql_query($query_rq_doc, $connexion) or die(mysql_error());
$row_rq_doc = mysql_fetch_assoc($rq_doc);
$totalRows_rq_doc = mysql_num_rows($rq_doc);
$colname_matricule="";
if(isset($_POST['MATRICULE'])&& $_POST['MATRICULE']!="")
{
$colname_matricule=" AND INDIVIDU.MATRICULE like '%".$_POST['MATRICULE']."%' ";
}
$colname_prenom="";
if(isset($_POST['PRENOMS'])&& $_POST['PRENOMS']!="")
{
$colname_prenom=" AND INDIVIDU.PRENOMS like '%".$_POST['PRENOMS']."%' ";
}
$colname_nom="";
if(isset($_POST['NOM'])&& $_POST['NOM']!="")
{
$colname_nom=" AND INDIVIDU.NOM like '%".$_POST['NOM']."%' ";
}
$colname_tel="";
if(isset($_POST['TELMOBILE'])&& $_POST['TELMOBILE']!="")
{
$colname_tel=" AND INDIVIDU.TELMOBILE like '%".$_POST['TELMOBILE']."%' ";
}

$maxRows_rq_etudiant = 30;
$pageNum_rq_etudiant = 0;
if (isset($_GET['pageNum_rq_etudiant'])) {
  $pageNum_rq_etudiant = $_GET['pageNum_rq_etudiant'];
}
$startRow_rq_etudiant = $pageNum_rq_etudiant * $maxRows_rq_etudiant;

$colname_rq_etudiant = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_etudiant = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_etudiant = sprintf("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE FROM INDIVIDU WHERE INDIVIDU.IDETABLISSEMENT = %s AND INDIVIDU.IDINDIVIDU  IN(SELECT   INDIVIDU.IDINDIVIDU FROM INDIVIDU,INSCRIPTION WHERE INDIVIDU.IDINDIVIDU = INSCRIPTION.IDINDIVIDU ) AND INDIVIDU.IDTYPEINDIVIDU=3 ".$colname_matricule.$colname_prenom.$colname_nom.$colname_tel, GetSQLValueString($colname_rq_etudiant, "int"));
$query_limit_rq_etudiant = sprintf("%s LIMIT %d, %d", $query_rq_etudiant, $startRow_rq_etudiant, $maxRows_rq_etudiant);
$rq_etudiant = mysql_query($query_limit_rq_etudiant, $connexion) or die(mysql_error());
$row_rq_etudiant = mysql_fetch_assoc($rq_etudiant);
//echo $query_rq_etudiant ;
if (isset($_GET['totalRows_rq_etudiant'])) {
  $totalRows_rq_etudiant = $_GET['totalRows_rq_etudiant'];
} else {
  $all_rq_etudiant = mysql_query($query_rq_etudiant);
  $totalRows_rq_etudiant = mysql_num_rows($all_rq_etudiant);
}
$totalPages_rq_etudiant = ceil($totalRows_rq_etudiant/$maxRows_rq_etudiant)-1;

$queryString_rq_etudiant = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rq_etudiant") == false && 
        stristr($param, "totalRows_rq_etudiant") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rq_etudiant = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rq_etudiant = sprintf("&totalRows_rq_etudiant=%d%s", $totalRows_rq_etudiant, $queryString_rq_etudiant);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Document sans titre</title>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />
<link href="../styles/styles_page_model.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="100%" height="215" border="0" cellpadding="0" cellspacing="4">
  <tr>
    <td height="32" align="left" valign="middle" class="Titre"><table id="A29" width="100%">
      <tbody>
        <tr>
          <td height="21" valign="top"><div>
            <div>
              <table width="448">
                <tbody>
                  <tr>
                    <td id="tzA30" valign="top">Les etudiants</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div></td>
        </tr>
        <tr>
          <td height="21" valign="top" bgcolor="#F3F3F3"><form id="form1" name="form1" method="post" action="../tiers/Liste_etudiant_trouve.php">
      <fieldset>
        <table width="99%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td width="162" align="right" valign="middle" class="nomEntrepr">Matricule:</td>
            <td width="268" align="left" valign="middle"><label for="matricule"></label>
              <input name="MATRICULE" type="text" class="form3" id="matricule" /></td>
            <td width="155" align="right" valign="middle" class="nomEntrepr">Tel:</td>
            <td width="265"><label for="TELMOBILE"></label>
              <input name="TELMOBILE" type="text" class="form3" id="tel" /></td>
            <td width="312" rowspan="2" align="right" valign="middle"><input name="button" type="image" id="button" value="Envoyer" src="../images/btn_rechercher.png" /></td>
            </tr>
          <tr>
            <td align="right" valign="middle" class="nomEntrepr">Nom:</td>
            <td align="left" valign="middle"><label for="nom"></label>
              <input name="NOM" type="text" class="form3" id="NOM" /></td>
            <td align="right" valign="middle" class="nomEntrepr">Prenom:</td>
            <td><label for="PRENOMS"></label>
              <input name="PRENOMS" type="text" class="form3" id="prenom" /></td>
            </tr>
        </table>
      </fieldset>
    </form></td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td height="3" align="left" valign="middle" background="../images/im_lign.jpg"></td>
  </tr>
  <tr>
    <td height="52" align="left" valign="top"><div id="contenu">
      <?php if ($totalRows_rq_etudiant > 0) { // Show if recordset not empty ?>
  <table width="100%" height="45" border="0" cellpadding="0" cellspacing="1">
    <tr background="../images/titl_Entet_Tablo.jpg">
      <td width="20" height="19">&nbsp;</td>
      <td width="80" align="left" valign="middle" class="titretablo">Matricule</td>
      <td width="418" align="left" valign="middle" class="titretablo">Prénom</td>
      <td width="190" align="left" valign="middle" class="titretablo">Nom</td>
      <td width="239" align="left" valign="middle" class="titretablo">Tel</td>
      <td width="108" align="left" valign="middle" class="libelle_champ">&nbsp;</td>
      </tr>
    <?php 
	 $boucle=0;
	  do { 
	       $couleur="#FFFFFF";
					$mod=$boucle % 2 ;
					if($mod!=0) 
					{
					$couleur="#F5F6F6";
					}
	  ?>
    <tr bgcolor="<?php echo $couleur;?>">
      <td height="20" align="center" valign="middle"><img src="../images/icoindividu.png" width="16" height="16" /></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['MATRICULE']; ?></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['PRENOMS']; ?></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['NOM']; ?></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['TELMOBILE']; ?></td>
      <td align="left" valign="middle" ><a href="fiche_new_doc.php?IDINDIVIDU=<?php echo $row_rq_etudiant['IDINDIVIDU']; ?>"><img src="../images/bt_creer.png" width="94" height="27" border="0" /></a></td>
      </tr>
    <?php
		 $boucle=$boucle + 1;
		 } while ($row_rq_etudiant = mysql_fetch_assoc($rq_etudiant)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
    </div></td>
  </tr>
  <tr>
    <td height="34" align="center" valign="middle" class="Titre"><?php if ($totalRows_rq_etudiant == 0) { // Show if recordset empty ?>
        Pas de documents
  <?php } // Show if recordset empty ?></td>
  </tr>
  <tr>
    <td height="34" align="left" valign="top">
      <table width="581" border="0" align="center">
        <tr>
          <td><?php if ($pageNum_rq_etudiant > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rq_etudiant=%d%s", $currentPage, 0, $queryString_rq_etudiant); ?>" class="textBrute">&lt;&lt;Premier</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rq_etudiant > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rq_etudiant=%d%s", $currentPage, max(0, $pageNum_rq_etudiant - 1), $queryString_rq_etudiant); ?>" class="textBrute">&lt;Pr&eacute;c&eacute;dent</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rq_etudiant < $totalPages_rq_etudiant) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rq_etudiant=%d%s", $currentPage, min($totalPages_rq_etudiant, $pageNum_rq_etudiant + 1), $queryString_rq_etudiant); ?>" class="textBrute">Suivant&gt;</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_rq_etudiant < $totalPages_rq_etudiant) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rq_etudiant=%d%s", $currentPage, $totalPages_rq_etudiant, $queryString_rq_etudiant); ?>" class="textBrute">Dernier&gt;&gt;</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
