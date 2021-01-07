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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rq_typ_doc = 30;
$pageNum_rq_typ_doc = 0;
if (isset($_GET['pageNum_rq_typ_doc'])) {
  $pageNum_rq_typ_doc = $_GET['pageNum_rq_typ_doc'];
}
$startRow_rq_typ_doc = $pageNum_rq_typ_doc * $maxRows_rq_typ_doc;

$colname_rq_typ_doc = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_typ_doc = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_typ_doc = sprintf("SELECT * FROM TYPEDOCADMIN WHERE IDETABLISSEMENT = %s ORDER BY LIBELLE ASC", GetSQLValueString($colname_rq_typ_doc, "int"));
$query_limit_rq_typ_doc = sprintf("%s LIMIT %d, %d", $query_rq_typ_doc, $startRow_rq_typ_doc, $maxRows_rq_typ_doc);
$rq_typ_doc = mysql_query($query_limit_rq_typ_doc, $connexion) or die(mysql_error());
$row_rq_typ_doc = mysql_fetch_assoc($rq_typ_doc);

if (isset($_GET['totalRows_rq_typ_doc'])) {
  $totalRows_rq_typ_doc = $_GET['totalRows_rq_typ_doc'];
} else {
  $all_rq_typ_doc = mysql_query($query_rq_typ_doc);
  $totalRows_rq_typ_doc = mysql_num_rows($all_rq_typ_doc);
}
$totalPages_rq_typ_doc = ceil($totalRows_rq_typ_doc/$maxRows_rq_typ_doc)-1;

$queryString_rq_typ_doc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rq_typ_doc") == false && 
        stristr($param, "totalRows_rq_typ_doc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rq_typ_doc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rq_typ_doc = sprintf("&totalRows_rq_typ_doc=%d%s", $totalRows_rq_typ_doc, $queryString_rq_typ_doc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<script src="../src/fonctions.js" type="text/javascript"></script>
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
  <tr align="left" valign="top">
    <td width="90%" class="Titre">Les types de documents</td>
    <?php if(($_SESSION['TYPEINDIVIDU']==1) || est_autorise($database_connexion, $connexion,5,4,$_SESSION['TYPEINDIVIDU'],$_SESSION['ETABLISSEMENT'])==1){?>
    <td width="10%" class="Titre"><a href="fiche_new_typdoc.php"><img src="../images/bt_nouveau.png" width="102" height="27" border="0" /></a></td>
    <?php }?>
  </tr>
  <tr align="left" valign="top">
    <td height="2" colspan="2"  background="../images/im_lign.jpg"></td>
  </tr>
  <tr align="left" valign="top">
    <td colspan="2"><table width="99%" border="0" cellspacing="1">
        <tr background="../images/titl_Entet_Tablo.jpg">
          <td width="21">&nbsp;</td>
          <td width="884" align="left" valign="middle" class="titretablo">Type de document</td>
          <td width="102" align="left" valign="middle" class="titretablo">&nbsp;</td>
          <td width="98" align="left" valign="middle" class="titretablo">&nbsp;</td>
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
            <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_typ_doc['LIBELLE']; ?></td>
            <td>
            <?php if(($_SESSION['TYPEINDIVIDU']==1) || est_autorise($database_connexion, $connexion,5,2,$_SESSION['TYPEINDIVIDU'],$_SESSION['ETABLISSEMENT'])==1){?>
            <table width="71" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="16" align="center" valign="middle"><a href="../page.php?param=fiche_niveau&amp;idproduit=<?php echo $row_rq_niveau['IDNIVEAU']; ?>"><img src="../images/b_edit.png" alt="" width="16" height="16" border="0" /></a></td>
                <td width="46" align="left" valign="middle"><a href="modif_type_doc.php?IDTYPEDOC=<?php echo $row_rq_typ_doc['IDTYPEDOCADMIN']; ?>" target="mainFrame" class="textBrute">Modifier</a></td>
              </tr>
            </table>
            <?php }?></td>
            <td>
            <?php  if(($_SESSION['TYPEINDIVIDU']==1) || est_autorise($database_connexion, $connexion,5,3,$_SESSION['TYPEINDIVIDU'],$_SESSION['ETABLISSEMENT'])==1){?>
            <table width="90" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td width="18" align="center" valign="middle"><img src="../images/b_drop.png" alt="" width="16" height="16" /></td>
                <td width="90" align="left" valign="middle" class="textBrute"><a href="#" class="textBrute" onclick="ConfirmDeleteMessage('fiche_sup_typdoc.php?<?php echo $row_rq_typ_doc['IDTYPEDOCADMIN']; ?>='); return false;">Supprimer</a></td>
              </tr>
            </table>
            <?php }?></td>
          </tr>
          <?php 
		  $boucle=$boucle + 1;
		  } while ($row_rq_typ_doc = mysql_fetch_assoc($rq_typ_doc)); ?>
    </table></td>
  </tr>
  <tr align="center" valign="middle">
    <td height="38" colspan="2"><table width="482" border="0">
        <tr class="textBrute">
          <td class="textBrute"><?php if ($pageNum_rq_typ_doc > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rq_typ_doc=%d%s", $currentPage, 0, $queryString_rq_typ_doc); ?>" class="textBrute">&lt;&lt;Premier</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rq_typ_doc > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rq_typ_doc=%d%s", $currentPage, max(0, $pageNum_rq_typ_doc - 1), $queryString_rq_typ_doc); ?>" class="textBrute">&lt;Pr&eacute;c&eacute;dent</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rq_typ_doc < $totalPages_rq_typ_doc) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rq_typ_doc=%d%s", $currentPage, min($totalPages_rq_typ_doc, $pageNum_rq_typ_doc + 1), $queryString_rq_typ_doc); ?>" class="textBrute">Suivant&gt;</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_rq_typ_doc < $totalPages_rq_typ_doc) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rq_typ_doc=%d%s", $currentPage, $totalPages_rq_typ_doc, $queryString_rq_typ_doc); ?>" class="textBrute">Dernier&gt;&gt;</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

