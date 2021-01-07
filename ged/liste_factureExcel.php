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
$colname_rq_liste_eveleve = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_liste_eveleve = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}
$titre="LISTE DES FACTURES";
if(isset($_GET['idMois']) && $_GET['idMois']!=''){
    $cond .= " AND f.MOIS='" . base64_decode( $lib->securite_xss($_GET['idMois'])) . "'";
    $titre .= " DU MOIS DE " . $lib->affiche_mois(base64_decode($_GET['idMois']));
}


try
{
    $query_rq_liste_eveleve = $dbh->query("SELECT f.IDFACTURE, f.NUMFACTURE, f.MOIS, f.MONTANT as MONTANT_F, f.DATEREGLMT, f.IDINSCRIPTION, f.IDETABLISSEMENT, f.MT_VERSE, f.MT_RELIQUAT, f.ETAT as FETAT,
                                                INSCRIPTION.*, INDIVIDU.* 
                                                FROM INSCRIPTION, FACTURE f, INDIVIDU 
                                                WHERE f.IDETABLISSEMENT = " . $colname_rq_liste_eveleve . " 
                                                AND f.IDINSCRIPTION = INSCRIPTION.IDINSCRIPTION 
                                                AND INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU  
                                                AND f.IDANNEESCOLAIRE = " . $colname_rq_anne . " " . $cond . " 
                                                ORDER BY f.IDFACTURE DESC");
}
catch (PDOException $e){
    echo -2;
}


?>


<page backtop="7mm" backbottom="7mm" backleft="0mm" backright="0mm" >
<table width="100%" height="97" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr >
    <td height="19" colspan="8" class="Titre"><?php echo $titre; ?></td>
  </tr>
  <tr >
    <td height="3" colspan="8" bgcolor="#FF0000"></td>
  </tr>
  <tr bgcolor="#CCCCCC">

    <td  align="left" valign="middle" class="titretablo">Matricule</td>
    <td  align="left" valign="middle" class="titretablo">Prenom(s) &amp; Nom</td>
    <td  align="left" valign="middle" class="titretablo">Numero</td>
    <td align="left" valign="middle" class="titretablo">Mois</td>
    <td align="left" valign="middle" class="titretablo">Date facture </td>
    <td align="left" valign="middle" class="titretablo">Montant </td>
    <td align="left" valign="middle" class="titretablo">Montant verse </td>
    <td align="left" valign="middle" class="titretablo">Montant restant </td>




  </tr>
  <?php 
	 
	 foreach ($query_rq_liste_eveleve->fetchAll() as $row_rq_etudiant ) {
	       
	  ?>
  <tr >
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['MATRICULE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['PRENOMS']. " " .$row_rq_etudiant['NOM']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['NUMFACTURE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->affiche_mois($row_rq_etudiant['MOIS']) ; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->date_franc($row_rq_etudiant['DATEREGLMT']) ; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->nombre_form($row_rq_etudiant['MONTANT_F']) ; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->nombre_form($row_rq_etudiant['MT_VERSE']) ; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $lib->nombre_form($row_rq_etudiant['MT_RELIQUAT']); ?></td>

  </tr>
  <?php
		
		 }  ?>
</table>
</page>


