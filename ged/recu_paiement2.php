<?php require_once('../Connections/connexion.php'); ?>
<?php require_once('../Connections/connexion.php'); ?>
<?php require_once('../Connections/connexion.php'); include('../restriction_page.php');  
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

$colname_rq_benificiaire = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_benificiaire = $_GET['IDINDIVIDU'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_benificiaire = sprintf("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, NIVEAU.LIBELLE AS NIVEAU, SERIE.LIBSERIE AS FILIERE FROM INDIVIDU, NIVEAU, SERIE WHERE SERIE.IDETABLISSEMENT=NIVEAU.IDETABLISSEMENT AND NIVEAU.IDETABLISSEMENT=INDIVIDU.IDETABLISSEMENT AND INDIVIDU.IDINDIVIDU=%s", GetSQLValueString($colname_rq_benificiaire, "int"));
$rq_benificiaire = mysql_query($query_rq_benificiaire, $connexion) or die(mysql_error());
$row_rq_benificiaire = mysql_fetch_assoc($rq_benificiaire);
$totalRows_rq_benificiaire = mysql_num_rows($rq_benificiaire);

$colname_rq_mensualite = "-1";
if (isset($_GET['IDMENSUALITE'])) {
  $colname_rq_mensualite = $_GET['IDMENSUALITE'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_mensualite = sprintf("SELECT MENSUALITE.MT_VERSE, MENSUALITE.MT_RELIQUAT, MENSUALITE.DATEREGLMT, MENSUALITE.MONTANT, MENSUALITE.MOIS, MENSUALITE.IDINSCRIPTION FROM MENSUALITE WHERE MENSUALITE.IDMENSUALITE=%s", GetSQLValueString($colname_rq_mensualite, "int"));
$rq_mensualite = mysql_query($query_rq_mensualite, $connexion) or die(mysql_error());
$row_rq_mensualite = mysql_fetch_assoc($rq_mensualite);
$totalRows_rq_mensualite = mysql_num_rows($rq_mensualite);

//historique de la mensualite
$colname_rq_historique_mensulaite=$row_rq_mensualite['IDINSCRIPTION'];
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_historique_mensulaite = $_GET['IDINSCRIPTION'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_historique_mensulaite = sprintf("SELECT * FROM MENSUALITE WHERE IDINSCRIPTION = %s ORDER BY IDMENSUALITE ASC", GetSQLValueString($colname_rq_historique_mensulaite, "int"));
$rq_historique_mensulaite = mysql_query($query_rq_historique_mensulaite, $connexion) or die(mysql_error());
$row_rq_historique_mensulaite = mysql_fetch_assoc($rq_historique_mensulaite);
$totalRows_rq_historique_mensulaite = mysql_num_rows($rq_historique_mensulaite);

$colname_rq_etablissement = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_etablissement = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_etablissement = sprintf("SELECT * FROM ETABLISSEMENT WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_etablissement, "int"));
$rq_etablissement = mysql_query($query_rq_etablissement, $connexion) or die(mysql_error());
$row_rq_etablissement = mysql_fetch_assoc($rq_etablissement);
$totalRows_rq_etablissement = mysql_num_rows($rq_etablissement);

$tot=0;
?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table border="0" align="center" >
  <tr>
    <td height="20" colspan="5" align="center" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" width="150" height="94" /></td>
  </tr>
  <tr>
    <td height="20" colspan="5" align="center" valign="top" class="Titre">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="5" align="center" valign="top" class="libelle_champ">Etablissement d&rsquo;Enseignement Supérieur Privé&nbsp;- Agrément N° 00129/MESUCURRS/DGES/DFS<br />
      RC: <?php echo $row_rq_etablissement['RC']; ?> - NINEA: <?php echo $row_rq_etablissement['NINEA']; ?></td>
  </tr>
  <tr>
    <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="742" height="1" /></td>
  </tr>
      <tr bgcolor="#F3F3F3">
        <td colspan="3" rowspan="2" align="left" class="lienstablo2">RE&Ccedil;U PAIEMENT:</td>
        <td colspan="2" class="textBrute">Num: <?php echo date('YMdHis'); ?>/2012-2013</td>
        </tr>
      <tr bgcolor="#F3F3F3">
        <td colspan="2" class="textBrute">&nbsp;</td>
      </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="4" align="left" valign="top" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
          <td width="152" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Etudiant(E)</td>
          <td colspan="4" align="left" valign="top" class="textBrute"><?php echo $row_rq_benificiaire['PRENOMS']; ?> <?php echo $row_rq_benificiaire['NOM']; ?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">NUM MATRICULE:</td>
          <td><span class="textBrute"><?php echo $row_rq_benificiaire['MATRICULE']; ?></span></td>
          <td align="right" valign="middle" class="nomEntrepr">NIVEAU:</td>
          <td><span class="textBrute"><?php echo $row_rq_benificiaire['NIVEAU']; ?></span></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Description </td>
          <td>&nbsp;</td>
          <td align="right" valign="middle" class="nomEntrepr">&nbsp;</td>
          <td class="nomEntrepr">MONTANT</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
          <td height="16" colspan="3" align="left" valign="top" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="2" align="right" valign="middle" class="nomEntrepr"><span class="textBrute"><?php echo nombre_form($row_rq_mensualite['MT_VERSE']); ?></span></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
          <td height="16" colspan="3" align="right" valign="top" nowrap="nowrap" class="nomEntrepr">TOTAL</td>
          <td colspan="2" align="right" valign="middle" class="nomEntrepr"><span class="textBrute"><?php echo nombre_form($row_rq_mensualite['MT_VERSE']); ?></span></td>
  </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE ReglementS </span></td>
          <td width="116" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
          <td width="139" class="nomEntrepr">MOIS</td>
          <td width="119" class="textBrute"><span class="nomEntrepr">Montant</span></td>
          <td width="208" class="textBrute"><span class="nomEntrepr">Reliquat</span></td>
          <td class="textBrute">&nbsp;</td>
        </tr>
        <?php do { ?>
          <tr valign="middle" >
            <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span class="textBrute"><?php echo date_fr2($row_rq_mensualite['DATEREGLMT']); ?></span></td>
            <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $row_rq_mensualite['MOIS']; ?></td>
            <td align="right" bgcolor="#F3F3F3" class="textBrute"><?php $tot=$tot+$row_rq_historique_mensulaite['MT_VERSE']; echo nombre_form($row_rq_historique_mensulaite['MT_VERSE']); ?></td>
            <td align="right" bgcolor="#F3F3F3" class="textBrute"><?php echo nombre_form($row_rq_historique_mensulaite['MT_RELIQUAT']); ?></td>
            <td class="textBrute">&nbsp;</td>
          </tr>
          <?php } while ($row_rq_historique_mensulaite = mysql_fetch_assoc($rq_historique_mensulaite)); ?>
        <tr valign="middle">
          <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">TOTAL:</td>
          <td align="right" class="textBrute"><?php echo nombre_form($tot); ?></td>
          <td class="nomEntrepr">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
  </tr>
</table>
</page>