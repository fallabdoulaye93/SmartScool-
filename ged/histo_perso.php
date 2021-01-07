<?php require_once('../Connections/connexion.php');
 include('../restriction_page.php');  
require_once('chiffreEnLettre.php');
?>
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

$colname_rq_regle = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_regle = $_SESSION['ANNEESSCOLAIRE'];
}
$colname2_rq_regle = "-1";
if (isset($_GET['idreglement'])) {
  $colname2_rq_regle = $_GET['idreglement'];
}
$colname3_rq_regle = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname3_rq_regle = $_SESSION['ETABLISSEMENT'];
}
$colname4_rq_regle = "-1";
if (isset($_GET['idindividu'])) {
  $colname4_rq_regle = $_GET['idindividu'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_regle = sprintf("SELECT * FROM REGLEMENT_PERSO, INDIVIDU WHERE INDIVIDU.IDINDIVIDU=REGLEMENT_PERSO.INDIVIDU  AND REGLEMENT_PERSO.IDANNEESCOLAIRE=%s AND REGLEMENT_PERSO.IDREGLEMENT=%s AND INDIVIDU.IDETABLISSEMENT=%s  AND INDIVIDU.IDINDIVIDU=%s", GetSQLValueString($colname_rq_regle, "int"),GetSQLValueString($colname2_rq_regle, "int"),GetSQLValueString($colname3_rq_regle, "int"),GetSQLValueString($colname4_rq_regle, "int"));
$rq_regle = mysql_query($query_rq_regle, $connexion) or die(mysql_error());
$row_rq_regle = mysql_fetch_assoc($rq_regle);
$totalRows_rq_regle = mysql_num_rows($rq_regle);
?>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table border="0" align="center" >
  <tr>
    <td height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" width="150" height="94" /></td>
    <td height="20" colspan="3" align="center" valign="middle" class="Titre">RE&Ccedil;U DE PAIEMENT</td>
    <td width="94" height="20" align="left" valign="middle" class="Titre"><p>Le  <span class="Titre"><?php echo $row_rq_regle['DATE_REGLEMENT']; ?></span><br />
        <br />
        N° :       <span class="Titre"><?php echo $row_rq_regle['IDREGLEMENT']; ?></span><br />
    <br />
        <br />
    <br />
    </p></td>
  </tr>
  <tr>
    <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="742" height="1" /></td>
  </tr>
      <tr bgcolor="#F3F3F3">
        <td width="152" align="left" class="nomEntrepr">NOM:</td>
        <td width="130" class="textBrute"><?php echo $row_rq_regle['NOM']; ?></td>
        <td width="143" class="textBrute"><span class="nomEntrepr">PRENOM:</span></td>
        <td colspan="2" class="textBrute"><?php echo $row_rq_regle['PRENOMS']; ?></td>
        </tr>
      <tr bgcolor="#F3F3F3">
        <td width="152" align="left" valign="top" class="nomEntrepr">MATRICULE:</td>
        <td class="textBrute"><?php echo $row_rq_regle['MATRICULE']; ?></td>
        <td class="textBrute"><span class="nomEntrepr">TELEPHONE:</span></td>
        <td width="215" class="textBrute"><?php echo $row_rq_regle['TELMOBILE']; ?></td>
        <td class="textBrute">&nbsp;</td>
      </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="3" align="center" valign="middle" class="textBrute">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
          <td class="nomEntrepr">MOIS</td>
          <td class="textBrute"><span class="nomEntrepr">Montant</span></td>
          <td class="nomEntrepr">MOTIF</td>
          <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="middle" >
          <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><?php echo $row_rq_regle['DATE_REGLEMENT']; ?></td>
          <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $row_rq_regle['MOIS']; ?></td>
          <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $row_rq_regle['MONTANT']; ?></td>
          <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $row_rq_regle['MOTIF']; ?></td>
          <td class="textBrute">&nbsp;</td>
        </tr>
<tr valign="middle">
    <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td align="right" class="textBrute">&nbsp;</td>
          <td class="nomEntrepr">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
  </tr>
</table>
</page>