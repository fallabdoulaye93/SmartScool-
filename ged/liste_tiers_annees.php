<?php
session_start(); 
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
?>
<?php


$colname_niveau_rq_individu = "-1";
if (isset($_GET['IDNIVEAU'])) {
    $colname_niveau_rq_individu = $lib->securite_xss(base64_decode($_GET['IDNIVEAU'])) ;
}
$colname_serie_rq_individu = "-1";
if (isset($_GET['IDSERIE'])) {
    $colname_serie_rq_individu = $lib->securite_xss(base64_decode($_GET['IDSERIE']));
}
$colanne_rq_annee = "-1";
if (isset($_GET['ANNEESSCOLAIRE']) && $_GET['ANNEESSCOLAIRE'] != null) {
    $colanne_rq_annee = $lib->securite_xss(base64_decode($_GET['ANNEESSCOLAIRE']));
}

$query_rq_individu = $dbh->query("SELECT INSCRIPTION.DATEINSCRIPT, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE,INDIVIDU.DATNAISSANCE, INDIVIDU.IDINDIVIDU, INDIVIDU.PHOTO_FACE, INSCRIPTION.IDINSCRIPTION, INSCRIPTION.ETAT,`CLASSROOM`.`LIBELLE` FROM INSCRIPTION, INDIVIDU,AFFECTATION_ELEVE_CLASSE,CLASSROOM WHERE INSCRIPTION.IDNIVEAU= ".$colname_niveau_rq_individu." AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU AND CLASSROOM.IDCLASSROOM = AFFECTATION_ELEVE_CLASSE.IDCLASSROOM AND INSCRIPTION.IDSERIE= ".$colname_serie_rq_individu." AND INSCRIPTION.IDANNEESSCOLAIRE = ".$colanne_rq_annee);

?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="9mm" >
<table width="661" height="97" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr >
    <td height="19" colspan="5" class="Titre"> CYCLE : <?php echo $lib->securite_xss(base64_decode($_GET['NIVEAU'])); ?></td>
    <td height="19" colspan="2" class="Titre"> FILIERE/SERIE : <?php echo $lib->securite_xss(base64_decode($_GET['LIBSERIE'])); ?></td>
  </tr>
  <tr >
    <td height="3" colspan="7" bgcolor="#FF0000"></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="17" height="19">&nbsp;</td>
    <td width="95" align="left" valign="middle" class="titretablo">MATRICULE</td>
    <td width="90" align="left" valign="middle" class="titretablo">PRENOMS</td>
    <td width="80" align="left" valign="middle" class="titretablo">NOM</td>
    <td width="100" align="left" valign="middle" class="titretablo">DATE DE NAISSANCE</td>
    <td width="80" align="left" valign="middle" class="titretablo">CLASSE</td>
    <td width="80" align="left" valign="middle" class="titretablo">ETAT INSCRIPTION</td>
  </tr>
  <?php 
	 
	 foreach ($query_rq_individu->fetchAll() as $row_rq_etudiant ) {
	       
	  ?>
  <tr >
    <td height="20" align="center" valign="middle"><img src="../images/icoindividu.png"/></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['MATRICULE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['PRENOMS']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['NOM']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->date_fr($row_rq_etudiant['DATNAISSANCE']); ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['LIBELLE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['ETAT'] == 1 ? "VALIDE" : "ANNULÉ"; ?></td>
  </tr>
  <?php
		
		 }  ?>
</table>
</page>


