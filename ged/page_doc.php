<?php require_once('../Connections/connexion.php');
include('../restriction_page.php'); ?>
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

$maxRows_rq_doc = 10;
$pageNum_rq_doc = 0;
if (isset($_GET['pageNum_rq_doc'])) {
  $pageNum_rq_doc = $_GET['pageNum_rq_doc'];
}
$startRow_rq_doc = $pageNum_rq_doc * $maxRows_rq_doc;

$colname_rq_doc = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_doc = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_doc = sprintf("SELECT COUNT(DOCADMIN.IDDOCADMIN) as nb , TYPEDOCADMIN.LIBELLE, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS FROM DOCADMIN, TYPEDOCADMIN, INDIVIDU WHERE DOCADMIN.IDETABLISSEMENT = %s AND DOCADMIN.IDTYPEDOCADMIN=TYPEDOCADMIN.IDTYPEDOCADMIN AND INDIVIDU.IDINDIVIDU=DOCADMIN.IDINDIVIDU GROUP BY INDIVIDU.IDINDIVIDU, TYPEDOCADMIN.IDTYPEDOCADMIN", GetSQLValueString($colname_rq_doc, "int"));
$query_limit_rq_doc = sprintf("%s LIMIT %d, %d", $query_rq_doc, $startRow_rq_doc, $maxRows_rq_doc);
$rq_doc = mysql_query($query_limit_rq_doc, $connexion) or die(mysql_error());
$row_rq_doc = mysql_fetch_assoc($rq_doc);

if (isset($_GET['totalRows_rq_doc'])) {
  $totalRows_rq_doc = $_GET['totalRows_rq_doc'];
} else {
  $all_rq_doc = mysql_query($query_rq_doc);
  $totalRows_rq_doc = mysql_num_rows($all_rq_doc);
}
$totalPages_rq_doc = ceil($totalRows_rq_doc/$maxRows_rq_doc)-1;

$currentPage = $_SERVER["PHP_SELF"];

$queryString_rq_doc_etud = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rq_doc_etud") == false && 
        stristr($param, "totalRows_rq_doc_etud") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rq_doc_etud = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rq_doc_etud = sprintf("&totalRows_rq_doc_etud=%d%s", $totalRows_rq_doc_etud, $queryString_rq_doc_etud);

$queryString_rq_doc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rq_doc") == false && 
        stristr($param, "totalRows_rq_doc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rq_doc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rq_doc = sprintf("&totalRows_rq_doc=%d%s", $totalRows_rq_doc, $queryString_rq_doc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<script type="text/javascript" language="javascript">
function ConfirmDeleteMessage(URL)
{
   if (confirm("Confirmez-vous la suppression ?"))
   {
       window.location = URL;
   }
}
</script>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />
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
<table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr align="left" valign="middle">
    <td width="91%" class="Titre">liste des documents</td>
    <td width="9%" class="Titre">&nbsp;</td>
  </tr>
  <tr align="left" valign="middle">
    <td colspan="2" background="../images/im_lign.jpg"></td>
  </tr>
  <tr align="left" valign="middle">
    <td colspan="2"><?php if ($totalRows_rq_doc > 0) { // Show if recordset not empty ?>
  <table width="99%" border="0" cellspacing="1">
    <tr background="../images/titl_Entet_Tablo.jpg">
      <td width="20">&nbsp;</td>
      <td width="93" class="titretablo">matricule</td>
      <td width="137" class="titretablo">NOM</td>
      <td width="278" class="titretablo">PRENOMS</td>
      <td width="348" class="titretablo">TYPE  DOCUMENT</td>
      <td width="212" class="titretablo">Nombre de document</td>
      </tr>
    <?php 
		$boucle=0;
		do { 
		$couleur="#FFFFFF";
					$mod=$boucle % 2 ;
					if($mod!=0) 
					{
					$couleur="#F5F6F6";
					} ?>
    <tr bgcolor="<?php echo $couleur;?>">
      <td><img src="../images/puce_tableau.png" width="16" height="16" /></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_doc['MATRICULE']; ?></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_doc['NOM']; ?></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_doc['PRENOMS']; ?></td>
      <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_doc['LIBELLE']; ?></td>
      <td align="left" valign="middle" bgcolor="<?php echo $couleur;?>" class="textBrute"><?php echo $row_rq_doc['nb']; ?></td>
      </tr>
    <?php 
		  $boucle=$boucle + 1;
		  } while ($row_rq_doc = mysql_fetch_assoc($rq_doc)); ?>
  </table>
  <?php } // Show if recordset not empty ?></td>
  </tr>
  <tr align="left" valign="middle">
    <td  colspan="2" align="center" class="Titre"><?php if ($totalRows_rq_doc == 0) { // Show if recordset empty ?>
        PAS DE DOCUMENT
  <?php } // Show if recordset empty ?></td>
  </tr>
  <tr align="left" valign="middle">
    <td  colspan="2" align="center"><table border="0">
        <tr>
          <td><?php if ($pageNum_rq_doc > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rq_doc=%d%s", $currentPage, 0, $queryString_rq_doc); ?>" class="textBrute">Premier</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rq_doc > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rq_doc=%d%s", $currentPage, max(0, $pageNum_rq_doc - 1), $queryString_rq_doc); ?>" class="textBrute">Pr&eacute;c&eacute;dent</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rq_doc < $totalPages_rq_doc) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rq_doc=%d%s", $currentPage, min($totalPages_rq_doc, $pageNum_rq_doc + 1), $queryString_rq_doc); ?>" class="textBrute">Suivant</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_rq_doc < $totalPages_rq_doc) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rq_doc=%d%s", $currentPage, $totalPages_rq_doc, $queryString_rq_doc); ?>" class="textBrute">Dernier</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>