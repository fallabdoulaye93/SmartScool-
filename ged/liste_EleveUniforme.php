<?php
session_start(); 
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
?>
<?php

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}


$query_rq_etudiant = $dbh->query("SELECT INDIVIDU.*, INSCRIPTION.*, CLASSROOM.LIBELLE AS LIBELLECLASSE
                                            FROM INDIVIDU, INSCRIPTION, NIVEAU, SERIE, ANNEESSCOLAIRE, AFFECTATION_ELEVE_CLASSE, CLASSROOM
                                            WHERE INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            AND INDIVIDU.IDETABLISSEMENT = ".$colname_rq_classe." 
                                            AND INDIVIDU.IDTYPEINDIVIDU = 8 
                                            AND INSCRIPTION.UNIFORME>0 
                                            AND INSCRIPTION.IDNIVEAU = NIVEAU.IDNIVEAU 
                                            AND ANNEESSCOLAIRE.IDANNEESSCOLAIRE = INSCRIPTION.IDANNEESSCOLAIRE 
                                            AND ANNEESSCOLAIRE.ETAT = 0
                                            AND INSCRIPTION.ETAT = 1
                                            AND INSCRIPTION.IDSERIE = SERIE.IDSERIE 
                                            AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM
                                            AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                            ORDER BY CLASSROOM.LIBELLE, INDIVIDU.MATRICULE ASC
                                            ");

?>



<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table width="661" height="97" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr >
    <td height="19" colspan="6" class="Titre"><?php echo 'Liste des éléves qui ont des uniformes'; ?></td>
  </tr>
  <tr >
    <td height="3" colspan="6" bgcolor="#FF0000"></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="17" height="19">&nbsp;</td>
    <td width="95" align="left" valign="middle" class="titretablo">Matricule</td>
    <td width="168" align="left" valign="middle" class="titretablo">Prenom</td>
    <td width="101" align="left" valign="middle" class="titretablo">Nom</td>
    <td width="101" align="left" valign="middle" class="titretablo">Telephone</td>
    <td width="101" align="left" valign="middle" class="titretablo">Classe</td>
    <td width="101" align="left" valign="middle" class="titretablo">Montant</td>

  </tr>
  <?php 
	 
	 foreach ($query_rq_etudiant->fetchAll() as $row_rq_etudiant ) { 
	       
	  ?>
  <tr >
    <td height="20" align="center" valign="middle"></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['MATRICULE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['PRENOMS']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['NOM']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['TELMOBILE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['LIBELLECLASSE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->nombre_form($row_rq_etudiant['UNIFORME']); ?></td>
  </tr>
  <?php
		
		 }  ?>
</table>
</page>


