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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE DOCADMIN SET LIBELLE=%s, MOTIF=%s, DATEDELIVRANCE=%s, IDTYPEDOCADMIN=%s, IDETABLISSEMENT=%s, IDINDIVIDU=%s, IDANNEESSCOLAIRE=%s, ID_AUTHORITE=%s WHERE IDDOCADMIN=%s",
                       GetSQLValueString($_POST['LIBELLE'], "text"),
                       GetSQLValueString($_POST['MOTIF'], "text"),
                       GetSQLValueString($_POST['DATEDELIVRANCE'], "date"),
                       GetSQLValueString($_POST['IDTYPEDOCADMIN'], "int"),
                       GetSQLValueString($_POST['IDETABLISSEMENT'], "int"),
                       GetSQLValueString($_POST['IDINDIVIDU'], "int"),
                       GetSQLValueString($_POST['IDANNEESSCOLAIRE'], "int"),
                       GetSQLValueString($_POST['ID_AUTHORITE'], "int"),
                       GetSQLValueString($_POST['IDDOCADMIN'], "int"));

  mysql_select_db($database_connexion, $connexion);
  $Result1 = mysql_query($updateSQL, $connexion) or die(mysql_error());

  $updateGoTo = "page_type_doc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" align="center">
    <tr align="right" valign="baseline">
      <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="Titre">MODIFICATION DOCUMENT</td>
    </tr>
    <tr align="left" valign="baseline">
      <td colspan="2" valign="middle" nowrap="nowrap" class="nomEntrepr"><img src="../images/im_lign.jpg" width="950" height="2" /></td>
    </tr>
    <tr align="right" valign="baseline">
      <td width="38%" valign="middle" nowrap="nowrap" class="nomEntrepr">LIBELLE:</td>
      <td width="62%" align="left"><span id="sprytextfield1">
        <input name="LIBELLE" type="text" class="textBrute" value="<?php echo htmlentities($row_rq_doc['LIBELLE'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Une valeur est requise.</span></span></td>
    </tr>
    <tr align="right" valign="baseline">
      <td valign="middle" nowrap="nowrap" class="nomEntrepr">MOTIF:</td>
      <td align="left"><span id="sprytextfield2">
        <input name="MOTIF" type="text" class="textBrute" value="<?php echo htmlentities($row_rq_doc['MOTIF'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">Une valeur est requise.</span></span></td>
    </tr>
    <tr align="right" valign="baseline">
      <td valign="middle" nowrap="nowrap" class="nomEntrepr">DATEDELIVRANCE:</td>
      <td align="left"><input name="DATEDELIVRANCE" type="text" class="textBrute" value="<?php echo date("Y-m-d")?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" valign="middle" nowrap="nowrap"><a href="page_doc.php?IDDOCADMIN=<?php echo $row_rq_doc['IDDOCADMIN']; ?>"><img src="../images/bt_modifier.png" alt="" width="94" height="27" /></a></td>
    </tr>
  </table>
  <a href="mailto:"></a>
  <table width="100%" align="center">
    <tr valign="baseline"> </tr>
  </table>
  <input type="hidden" name="IDTYPEDOCADMIN" value="<?php echo htmlentities($row_rq_doc['IDTYPEDOCADMIN'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="IDETABLISSEMENT" value="<?php echo htmlentities($row_rq_doc['IDETABLISSEMENT'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="IDINDIVIDU" value="<?php echo htmlentities($row_rq_doc['IDINDIVIDU'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo htmlentities($row_rq_doc['IDANNEESSCOLAIRE'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="ID_AUTHORITE" value="<?php echo $row_rq_doc['ID_AUTHORITE']; ?>" />
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="IDDOCADMIN" value="<?php echo $row_rq_doc['IDDOCADMIN']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($rq_doc);
?>
