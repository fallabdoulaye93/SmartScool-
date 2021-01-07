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

$colname_rq_individu = " ";
if (isset($_GET['idClasse']) && $lib->securite_xss($_GET['idClasse'])!="")
{
    $colname_rq_individu.= " AND a.IDCLASSROOM ='".$lib->securite_xss($_GET['idClasse'])."'";

}

$query_rq_etudiant = $dbh->query("SELECT a.IDCLASSROOM, a.IDINDIVIDU, i.MATRICULE, i.NOM, 
                                            i.PRENOMS, i.TELMOBILE, i.IDINDIVIDU, i.PHOTO_FACE, c.LIBELLE AS LIBCLASSE 
                                            FROM AFFECTATION_ELEVE_CLASSE a
                                            INNER JOIN INDIVIDU i ON a.IDINDIVIDU = i.IDINDIVIDU
                                            INNER JOIN CLASSROOM c ON a.IDCLASSROOM = c.IDCLASSROOM
                                            INNER JOIN ANNEESSCOLAIRE an ON an.IDANNEESSCOLAIRE = a.IDANNEESSCOLAIRE
                                            INNER JOIN INSCRIPTION ins ON i.IDINDIVIDU = ins.IDINDIVIDU    
                                            WHERE an.ETAT = 0 
                                            AND ins.IDANNEESSCOLAIRE = ".$colname_anne."
                                            AND ins.ETAT = 1 ".$colname_rq_individu);
?>



<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table width="661" height="97" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr >
    <td height="19" colspan="6" class="Titre"><?php echo 'Liste des éléves par classe'; ?></td>
  </tr>
  <tr >
    <td height="3" colspan="6" bgcolor="#FF0000"></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="17" height="19">&nbsp;</td>
    <td width="95" align="left" valign="middle" class="titretablo">Matricule</td>
    <td width="168" align="left" valign="middle" class="titretablo">Prenom</td>
    <td width="101" align="left" valign="middle" class="titretablo">Nom</td>
    <td width="101" align="left" valign="middle" class="titretablo">Tel mobile</td>
    <td width="101" align="left" valign="middle" class="titretablo">Classe</td>

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
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['LIBCLASSE']; ?></td>
  </tr>
  <?php
		
		 }  ?>
</table>
</page>


