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

$maxRows_rq_periode = 30;
$pageNum_rq_periode = 0;
if (isset($_GET['pageNum_rq_periode'])) {
  $pageNum_rq_periode = $_GET['pageNum_rq_periode'];
}
$startRow_rq_periode = $pageNum_rq_periode * $maxRows_rq_periode;

$colname_rq_periode = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_periode = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_periode = sprintf("SELECT * FROM PERIODE WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_periode, "int"));
$query_limit_rq_periode = sprintf("%s LIMIT %d, %d", $query_rq_periode, $startRow_rq_periode, $maxRows_rq_periode);
$rq_periode = mysql_query($query_limit_rq_periode, $connexion) or die(mysql_error());
$row_rq_periode = mysql_fetch_assoc($rq_periode);

if (isset($_GET['totalRows_rq_periode'])) {
  $totalRows_rq_periode = $_GET['totalRows_rq_periode'];
} else {
  $all_rq_periode = mysql_query($query_rq_periode);
  $totalRows_rq_periode = mysql_num_rows($all_rq_periode);
}
$totalPages_rq_periode = ceil($totalRows_rq_periode/$maxRows_rq_periode)-1;

$maxRows_rq_clas = 30;
$pageNum_rq_clas = 0;
if (isset($_GET['pageNum_rq_clas'])) {
  $pageNum_rq_clas = $_GET['pageNum_rq_clas'];
}
$startRow_rq_clas = $pageNum_rq_clas * $maxRows_rq_clas;

$colname_rq_clas = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_clas = $_SESSION['ETABLISSEMENT'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_clas = sprintf("SELECT CLASSROOM.IDCLASSROOM, CLASSROOM.LIBELLE as classe, NIVEAU.LIBELLE as niveau, SERIE.LIBSERIE FROM CLASSROOM, NIVEAU, SERIE WHERE SERIE.IDSERIE=CLASSROOM.IDSERIE AND CLASSROOM.IDNIVEAU =NIVEAU.IDNIVEAU AND CLASSROOM.IDETABLISSEMENT=%s", GetSQLValueString($colname_rq_clas, "int"));
$query_limit_rq_clas = sprintf("%s LIMIT %d, %d", $query_rq_clas, $startRow_rq_clas, $maxRows_rq_clas);
$rq_clas = mysql_query($query_limit_rq_clas, $connexion) or die(mysql_error());
$row_rq_clas = mysql_fetch_assoc($rq_clas);

if (isset($_GET['totalRows_rq_clas'])) {
  $totalRows_rq_clas = $_GET['totalRows_rq_clas'];
} else {
  $all_rq_clas = mysql_query($query_rq_clas);
  $totalRows_rq_clas = mysql_num_rows($all_rq_clas);
}
$totalPages_rq_clas = ceil($totalRows_rq_clas/$maxRows_rq_clas)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript">
function imprimer(idclasse)
{
	var idperiode= document.form1.IDPERIODE.value;
	var idetablissement= document.form1.idetablissement.value;
	window.location="releve_classe.php?idclasse="+idclasse+"&id_periode="+idperiode+"&idetablissement="+idetablissement;
}
</script>
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
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="4" cellpadding="0">
      <tr>
        <td colspan="2" align="left" valign="top" class="Titre">CHOISISSEZ UNE PERIODE ET UNE CLASSE</td>
      </tr>
      <tr>
        <td height="2" colspan="2" background="../images/im_lign.jpg"></td>
      </tr>
    
      <tr>
        <td height="64" colspan="2" align="left" valign="top"><fieldset>
          <legend></legend>
          <table width="98%" height="49" border="0" cellspacing="1">
          <tr>
        <td width="2%" align="right" valign="top" class="titretablo">&nbsp;</td>
        <td width="14%" align="left" valign="top"><label for="select2"><span class="titretablo">CHOISIR UNE PERIODE</span></label></td>
        <td width="45%" align="left" valign="top"><select name="IDPERIODE" class="textBrute" id="select2">
          <?php
do {  
?>
          <option value="<?php echo $row_rq_periode['IDPERIODE']?>"><?php echo $row_rq_periode['NOM_PERIODE']?></option>
          <?php
} while ($row_rq_periode = mysql_fetch_assoc($rq_periode));
  $rows = mysql_num_rows($rq_periode);
  if($rows > 0) {
      mysql_data_seek($rq_periode, 0);
	  $row_rq_periode = mysql_fetch_assoc($rq_periode);
  }
?>
        </select>
          <input type="hidden" name="idetablissement" id="idetablissement" value="<?php echo $_SESSION['ETABLISSEMENT']; ?>" /></td>
          </tr>
            <tr background="../images/titl_Entet_Tablo.jpg">
              <td width="2%">&nbsp;</td>
              <td colspan="2"><span class="titretablo"> CLASSE</span></td>
              <td width="17%" class="titretablo">NIVEAU</td>
              <td class="titretablo">FILIERE</td>
              <td class="titretablo">&nbsp;</td>
              </tr>
            <?php 
			$boucle=0;
			do {
				$couleur="#FFFFFF";
					$mod=$boucle % 2 ;
					if($mod!=0) 
					{
					$couleur="#F5F6F6";
					}  ?>
               <tr bgcolor="<?php echo $couleur;?>">
                <td><img src="../images/puce_tableau.png" width="16" height="16" /></td>
                <td colspan="2" class="textBrute"><?php echo $row_rq_clas['classe']; ?></td>
                <td class="textBrute"><?php echo $row_rq_clas['niveau']; ?></td>
                <td width="15%" class="textBrute"><?php echo $row_rq_clas['LIBSERIE']; ?></td>
                <td width="7%"><img src="../images/bt_imprimer.png" width="99" height="27" onclick="imprimer(<?php echo $row_rq_clas['IDCLASSROOM']; ?>)" /></td>
                </tr>
              <?php $boucle=$boucle+1;
			  } while ($row_rq_clas = mysql_fetch_assoc($rq_clas)); ?>
          </table>
        </fieldset></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($rq_periode);

mysql_free_result($rq_clas);
?>
