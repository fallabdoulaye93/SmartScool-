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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO DOCADMIN (IDDOCADMIN, LIBELLE, MOTIF, DATEDELIVRANCE, IDTYPEDOCADMIN, IDETABLISSEMENT, IDINDIVIDU, IDANNEESSCOLAIRE, ID_AUTHORITE) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDDOCADMIN'], "int"),
                       GetSQLValueString($_POST['LIBELLE'], "text"),
                       GetSQLValueString($_POST['MOTIF'], "text"),
                       GetSQLValueString($_POST['DATEDELIVRANCE'], "date"),
                       GetSQLValueString($_POST['IDTYPEDOCADMIN'], "int"),
                       GetSQLValueString($_POST['IDETABLISSEMENT'], "int"),
                       GetSQLValueString($_POST['IDINDIVIDU'], "int"),
                       GetSQLValueString($_POST['IDANNEESSCOLAIRE'], "int"),
                       GetSQLValueString($_POST['ID_AUTHORITE'], "int"));

  mysql_select_db($database_connexion, $connexion);
  $Result1 = mysql_query($insertSQL, $connexion) or die(mysql_error());
	// impression document

  $insertGoTo = "type_doc_pdf.php?IDTYPEDOCADMIN=".$_POST['IDTYPEDOCADMIN']."&IDETABLISSEMENT=".$_POST['IDETABLISSEMENT']."&id_eleve=".$_POST['IDINDIVIDU'];
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rq_doc = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_doc = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_doc = sprintf("SELECT * FROM DOCADMIN WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_doc, "int"));
$rq_doc = mysql_query($query_rq_doc, $connexion) or die(mysql_error());
$row_rq_doc = mysql_fetch_assoc($rq_doc);
$totalRows_rq_doc = mysql_num_rows($rq_doc);

$colname_rq_typ_doc = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_typ_doc = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_typ_doc = sprintf("SELECT * FROM TYPEDOCADMIN WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_typ_doc, "int"));
$rq_typ_doc = mysql_query($query_rq_typ_doc, $connexion) or die(mysql_error());
$row_rq_typ_doc = mysql_fetch_assoc($rq_typ_doc);
$totalRows_rq_typ_doc = mysql_num_rows($rq_typ_doc);

$colname_rq_anneescolaire = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_anneescolaire = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_anneescolaire = sprintf("SELECT * FROM ANNEESSCOLAIRE WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_anneescolaire, "int"));
$rq_anneescolaire = mysql_query($query_rq_anneescolaire, $connexion) or die(mysql_error());
$row_rq_anneescolaire = mysql_fetch_assoc($rq_anneescolaire);
$totalRows_rq_anneescolaire = mysql_num_rows($rq_anneescolaire);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <fieldset>
    <legend class="Titre">CREATION DU DOCUMENT</legend>
    <table width="99%" align="center">
      <tr valign="baseline">
        <td width="23%" align="right" nowrap="nowrap" class="titretablo">LIBELLE:</td>
        <td width="77%"><span id="sprytextfield1">
          <input name="LIBELLE" type="text" class="textBrute" value="" size="100" />
        <span class="textfieldRequiredMsg">Une valeur est requise.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" class="titretablo">MOTIF:</td>
        <td><span id="sprytextfield2">
          <input name="MOTIF" type="text" class="textBrute" value="" size="100" />
        <span class="textfieldRequiredMsg">Une valeur est requise.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" class="titretablo">type document:</td>
        <td><label for="IDTYPEDOCADMIN"></label>
          <select name="IDTYPEDOCADMIN" size="1" class="textBrute" id="IDTYPEDOCADMIN">
            <?php
do {  
?>
            <option value="<?php echo $row_rq_typ_doc['IDTYPEDOCADMIN']?>"><?php echo $row_rq_typ_doc['LIBELLE']?></option>
            <?php
} while ($row_rq_typ_doc = mysql_fetch_assoc($rq_typ_doc));
  $rows = mysql_num_rows($rq_typ_doc);
  if($rows > 0) {
      mysql_data_seek($rq_typ_doc, 0);
	  $row_rq_typ_doc = mysql_fetch_assoc($rq_typ_doc);
  }
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" class="titretablo">DATEDELIVRANCE:</td>
        <td><input name="DATEDELIVRANCE" type="text" class="textBrute" value="<?php echo date("Y-m-d")?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" class="titretablo">ANNEE SCOLAIRE</td>
        <td><label for="IDANNEESSCOLAIRE"></label>
          <select name="IDANNEESSCOLAIRE" id="IDANNEESSCOLAIRE">
            <?php
do {  
?>
            <option value="<?php echo $row_rq_anneescolaire['IDANNEESSCOLAIRE']?>"><?php echo $row_rq_anneescolaire['LIBELLE_ANNEESSOCLAIRE']?></option>
            <?php
} while ($row_rq_anneescolaire = mysql_fetch_assoc($rq_anneescolaire));
  $rows = mysql_num_rows($rq_anneescolaire);
  if($rows > 0) {
      mysql_data_seek($rq_anneescolaire, 0);
	  $row_rq_anneescolaire = mysql_fetch_assoc($rq_anneescolaire);
  }
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input name="button" type="image" id="button" value="Envoyer" src="../images/bt_creer.png" /></td>
      </tr>
    </table>
  </fieldset>
  <input type="hidden" name="IDDOCADMIN" value="" />
  <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $_SESSION['ETABLISSEMENT']; ?>" />
  <input type="hidden" name="IDINDIVIDU" value="<?php echo $_GET['IDINDIVIDU']; ?>" />
  <input type="hidden" name="ID_AUTHORITE" value="<?php echo $_GET['ID_AUTHORITE']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>

