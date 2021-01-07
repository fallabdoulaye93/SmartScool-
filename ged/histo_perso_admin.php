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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rq_individu = 30;
$pageNum_rq_individu = 0;
if (isset($_GET['pageNum_rq_individu'])) {
  $pageNum_rq_individu = $_GET['pageNum_rq_individu'];
}
$startRow_rq_individu = $pageNum_rq_individu * $maxRows_rq_individu;

$colname_rq_individu = "-1";
if (isset($_SESSION['ETABLISSEMENT'])) {
  $colname_rq_individu = $_SESSION['ETABLISSEMENT'];
}


mysql_select_db($database_connexion, $connexion);
$query_rq_individu = sprintf("SELECT * FROM INDIVIDU WHERE IDETABLISSEMENT = %s AND INDIVIDU.IDTYPEINDIVIDU=1 ", GetSQLValueString($colname_rq_individu, "int"));
$query_limit_rq_individu = sprintf("%s LIMIT %d, %d", $query_rq_individu, $startRow_rq_individu, $maxRows_rq_individu);
$rq_individu = mysql_query($query_limit_rq_individu, $connexion) or die(mysql_error());
$row_rq_individu = mysql_fetch_assoc($rq_individu);

if (isset($_GET['totalRows_rq_individu'])) {
  $totalRows_rq_individu = $_GET['totalRows_rq_individu'];
} else {
  $all_rq_individu = mysql_query($query_rq_individu);
  $totalRows_rq_individu = mysql_num_rows($all_rq_individu);
}
$totalPages_rq_individu = ceil($totalRows_rq_individu/$maxRows_rq_individu)-1;

$queryString_rq_individu = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rq_individu") == false && 
        stristr($param, "totalRows_rq_individu") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rq_individu = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rq_individu = sprintf("&totalRows_rq_individu=%d%s", $totalRows_rq_individu, $queryString_rq_individu);

?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table border="0" align="center" >
  <tr>
    <td width="170" height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" width="150" height="94" /></td>
    <td height="20" colspan="3" align="center" valign="middle" class="Titre"> Liste dU PERSONNEL ADMINISTRATIF<br />
    <?php echo date("j-m-y"); ?></td>
   
  
  
  </tr>
  <tr>
    <td height="6" colspan="7" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="730" height="1" /></td>
  </tr>
  <tr valign="middle" >
    <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr">Matricule</td>
    <td width="89" align="center" bgcolor="#F3F3F3" class="textBrute"><span class="nomEntrepr">Nom </span></td>
    <td width="96" align="center" bgcolor="#F3F3F3" class="textBrute"><span class="nomEntrepr">PRENOM</span></td>
    <td width="126" align="center" bgcolor="#F3F3F3" class="nomEntrepr">telephone</td>



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
      <td height="20" align="center" nowrap="nowrap" class="textBrute"><?php echo $row_rq_individu['MATRICULE']; ?></td>
      <td align="center" class="textBrute"><?php echo $row_rq_individu['NOM']; ?></td>
      <td align="center" class="textBrute"><?php echo $row_rq_individu['PRENOMS']; ?></td>
      <td align="center" class="textBrute"><?php echo $row_rq_individu['TELMOBILE']; ?></td>
      
      
    </tr>
    <?php } while ($row_rq_individu = mysql_fetch_assoc($rq_individu)); ?>

</table>
</page>
