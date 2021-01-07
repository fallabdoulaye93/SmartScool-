<?php 

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

$colname_rq_type_doc = "-1";
if (isset($_GET['IDTYPEDOCADMIN'])) {
  $colname_rq_type_doc = $_GET['IDTYPEDOCADMIN'];
}

$query_rq_type_doc = $dbh->query("SELECT * FROM TYPEDOCADMIN WHERE IDTYPEDOCADMIN = ".$colname_rq_type_doc);

$row_rq_type_doc = $query_rq_type_doc->fetchObject();


$colname_req_etablissement = "-1";
if (isset($_GET['IDETABLISSEMENT'])) {
  $colname_req_etablissement = $_GET['IDETABLISSEMENT'];
}

$query_req_etablissement = $dbh->query("SELECT * FROM ETABLISSEMENT WHERE IDETABLISSEMENT = ".$colname_req_etablissement);

$row_req_etablissement = $query_req_etablissement->fetchObject();


$colname_rq_qutorite = "-1";
if (isset($_GET['id_autorite'])) {
  $colname_rq_qutorite = $_GET['id_autorite'];
}

$query_rq_qutorite = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = ".$colname_rq_qutorite);

$row_rq_qutorite = $query_rq_qutorite->fetchObject();


$colname_rq_benificiaire = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_rq_benificiaire = $_GET['id_eleve'];
}

$query_rq_benificiaire = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = ".$colname_rq_benificiaire);

$row_rq_benificiaire = $query_rq_benificiaire->fetchObject();


$colname_rq_classe = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_rq_classe = $_GET['id_eleve'];
}

$query_rq_classe = $dbh->query("SELECT CLASSROOM.LIBELLE FROM AFFECTATION_ELEVE_CLASSE, CLASSROOM WHERE IDINDIVIDU = ".$colname_rq_classe." AND CLASSROOM.IDCLASSROOM=AFFECTATION_ELEVE_CLASSE.IDCLASSROOM");

$row_rq_classe = $query_rq_classe->fetchObject();


$colname_date_inscrit = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_date_inscrit = $_GET['id_eleve'];
}

$query_date_inscrit = $dbh->query("SELECT DATEINSCRIPT FROM INSCRIPTION WHERE IDINDIVIDU = ".$colname_date_inscrit." ORDER BY DATEINSCRIPT DESC");

$row_date_inscrit = $query_date_inscrit ->fetchObject();


$colname_rq_parent = "-1";
if (isset($_GET['id_eleve'])) {
  $colname_rq_parent = $_GET['id_eleve'];
}

$query_rq_parent = $dbh->query("SELECT INDIVIDU.NOM, INDIVIDU.PRENOMS FROM  PARENT, INDIVIDU WHERE PARENT.ideleve = ".$colname_rq_parent." AND INDIVIDU.IDTUTEUR=PARENT.idParent");

$row_rq_parent = $query_rq_parent->fetchObject();

$contenu=$row_rq_type_doc->CONTENU;
$contenu=str_replace("[IDENTITE_DIRECTEUR]",$row_rq_qutorite->PRENOMS." ".$row_rq_qutorite->NOM,$contenu);
$contenu=str_replace("[ETABLISSEMENT]",$row_req_etablissement->NOMETABLISSEMENT_,$contenu);
$contenu=str_replace("[DATE_INSCRIPTION]",$lib->date_franc($row_date_inscrit->DATEINSCRIPT),$contenu);
$contenu=str_replace("[CLASSE]",$row_rq_classe->LIBELLE,$contenu);
$contenu=str_replace("[VILLE]",$row_req_etablissement->VILLE,$contenu);
$contenu=str_replace("[DATE_AUJOURDHUI]",$lib->date_franc(date('Y-m-d')),$contenu);
$contenu=str_replace("[DATENAISSANCE]",$row_rq_benificiaire->DATNAISSANCE,$contenu);
$contenu=str_replace("[IDENTITE_PARENT]",$row_rq_parent->PRENOMS." ".$row_rq_parent->NOM,$contenu);
$contenu=str_replace("[IDENTITE_ELEVE]",$row_rq_benificiaire->PRENOMS." ".$row_rq_benificiaire->NOM,$contenu);
$contenu=utf8_encode($contenu);
?>
<link href="styles/styles2.css" rel="stylesheet" type="text/css" />
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table width="678" border="0" align="center" >
  <tr>
    <td width="227" align="left" valign="top" class="textNormal"><?php echo $row_req_etablissement->NOMETABLISSEMENT_; ?></td>
    <td align="right" valign="top">Fait &aacute; <?php echo $row_req_etablissement->VILLE; ?>, le <?php echo $lib->date_franc(date('Y-m-d')); ?></td>
  </tr>
  <tr>
    <td height="20" align="left" valign="top"></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="161" colspan="2" align="left" valign="top" class="textNormal"> <?php echo $contenu; ?></td>
  </tr>
</table>
</page>