<?php require_once('../Connections/connexion.php'); include('../restriction_page.php'); ?>
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

$colname_rq_type_doc = "-1";
if (isset($_GET['IDTYPEDOCADMIN'])) {
  $colname_rq_type_doc = $_GET['IDTYPEDOCADMIN'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_type_doc = sprintf("SELECT * FROM TYPEDOCADMIN WHERE IDTYPEDOCADMIN = %s", GetSQLValueString($colname_rq_type_doc, "int"));
$rq_type_doc = mysql_query($query_rq_type_doc, $connexion) or die(mysql_error());
$row_rq_type_doc = mysql_fetch_assoc($rq_type_doc);
$totalRows_rq_type_doc = mysql_num_rows($rq_type_doc);

$colname_req_etablissement = "-1";
if (isset($_GET['IDETABLISSEMENT'])) {
  $colname_req_etablissement = $_GET['IDETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_req_etablissement = sprintf("SELECT * FROM ETABLISSEMENT WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_req_etablissement, "int"));
$req_etablissement = mysql_query($query_req_etablissement, $connexion) or die(mysql_error());
$row_req_etablissement = mysql_fetch_assoc($req_etablissement);
$totalRows_req_etablissement = mysql_num_rows($req_etablissement);

$colname_rq_qutorite = "-1";
if (isset($_GET['id_autorite'])) {
  $colname_rq_qutorite = $_GET['id_autorite'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_qutorite = sprintf("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = %s", GetSQLValueString($colname_rq_qutorite, "int"));
$rq_qutorite = mysql_query($query_rq_qutorite, $connexion) or die(mysql_error());
$row_rq_qutorite = mysql_fetch_assoc($rq_qutorite);
$totalRows_rq_qutorite = mysql_num_rows($rq_qutorite);

$colname_rq_benificiaire = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_rq_benificiaire = $_GET['id_eleve'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_benificiaire = sprintf("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = %s", GetSQLValueString($colname_rq_benificiaire, "int"));
$rq_benificiaire = mysql_query($query_rq_benificiaire, $connexion) or die(mysql_error());
$row_rq_benificiaire = mysql_fetch_assoc($rq_benificiaire);
$totalRows_rq_benificiaire = mysql_num_rows($rq_benificiaire);

$colname_rq_classe = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_rq_classe = $_GET['id_eleve'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_classe = sprintf("SELECT CLASSROOM.LIBELLE FROM AFFECTATION_ELEVE_CLASSE, CLASSROOM WHERE IDINDIVIDU = %s AND CLASSROOM.IDCLASSROOM=AFFECTATION_ELEVE_CLASSE.IDCLASSROOM", GetSQLValueString($colname_rq_classe, "int"));
$rq_classe = mysql_query($query_rq_classe, $connexion) or die(mysql_error());
$row_rq_classe = mysql_fetch_assoc($rq_classe);
$totalRows_rq_classe = mysql_num_rows($rq_classe);

$colname_date_inscrit = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_date_inscrit = $_GET['id_eleve'];
}
mysql_select_db($database_connexion, $connexion);
$query_date_inscrit = sprintf("SELECT DATEINSCRIPT FROM INSCRIPTION WHERE IDINDIVIDU = %s ORDER BY DATEINSCRIPT DESC", GetSQLValueString($colname_date_inscrit, "int"));
$date_inscrit = mysql_query($query_date_inscrit, $connexion) or die(mysql_error());
$row_date_inscrit = mysql_fetch_assoc($date_inscrit);
$totalRows_date_inscrit = mysql_num_rows($date_inscrit);

$colname_rq_parent = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_rq_parent = $_GET['id_eleve'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_parent = sprintf("SELECT INDIVIDU.NOM, INDIVIDU.PRENOMS FROM PARENT, INDIVIDU WHERE PARENT.IDINDIVIDU = %s AND INDIVIDU.IDINDIVIDU=PARENT.ID_PARENT", GetSQLValueString($colname_rq_parent, "int"));
$rq_parent = mysql_query($query_rq_parent, $connexion) or die(mysql_error());
$row_rq_parent = mysql_fetch_assoc($rq_parent);
$totalRows_rq_parent = mysql_num_rows($rq_parent);
$contenu=$row_rq_type_doc['CONTENU'];
$contenu=str_replace("[IDENTITE_DIRECTEUR]",$row_rq_qutorite['PRENOMS']." ".$row_rq_qutorite['NOM'],$contenu);
$contenu=str_replace("[ETABLISSEMENT]",$row_req_etablissement['NOMETABLISSEMENT_'],$contenu);
$contenu=str_replace("[DATE_INSCRIPTION]",date_fr_2($row_date_inscrit['DATEINSCRIPT']),$contenu);
$contenu=str_replace("[CLASSE]",$row_rq_classe['LIBELLE'],$contenu);
$contenu=str_replace("[VILLE]",$row_req_etablissement['VILLE'],$contenu);
$contenu=str_replace("[DATE_AUJOURDHUI]",date_fr_2(date('Y-m-d')),$contenu);
$contenu=str_replace("[DATENAISSANCE]",$row_rq_benificiaire['DATNAISSANCE'],$contenu);
$contenu=str_replace("[IDENTITE_PARENT]",$row_rq_parent['PRENOMS']." ".$row_rq_parent['NOM'],$contenu);
$contenu=str_replace("[IDENTITE_ELEVE]",$row_rq_benificiaire['PRENOMS']." ".$row_rq_benificiaire['NOM'],$contenu);
?>
<link href="styles/styles2.css" rel="stylesheet" type="text/css" />
<page>
<table width="678" border="0" align="center">
  <tr>
    <td width="227" align="left" valign="top" class="textNormal"><?php echo $row_req_etablissement['NOMETABLISSEMENT_']; ?></td>
    <td align="right" valign="top">Fait &aacute; <?php echo $row_req_etablissement['VILLE']; ?>, le <?php echo date_fr_2(date('Y-m-d')); ?></td>
  </tr>
  <tr>
    <td height="20" align="left" valign="top"><img src="../<?php echo $row_req_etablissement['LOGO']; ?>" width="130" /></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="161" colspan="2" align="left" valign="top" class="textNormal"> <?php echo $contenu; ?></td>
  </tr>
</table>
</page>
<?php
mysql_free_result($rq_type_doc);
?>
