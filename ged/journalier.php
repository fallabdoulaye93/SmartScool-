<?php 
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}



$colname_rq_histo_paiement = "-1";
if (isset($_SESSION["etab"])) {
  $colname_rq_histo_paiement = $lib->securite_xss($_SESSION["etab"]);
}
$colname2_rq_histo_paiement = "-1";
if (isset($_GET['DATE'])) {
  $colname2_rq_histo_paiement = $lib->securite_xss($_GET['DATE']);
}

$query_rq_histo_paiement = $dbh->query("SELECT * FROM MENSUALITE, INSCRIPTION, INDIVIDU WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_histo_paiement." AND MENSUALITE.IDINSCRIPTION =INSCRIPTION.IDINSCRIPTION AND INSCRIPTION.IDINDIVIDU =INDIVIDU.IDINDIVIDU AND MENSUALITE.DATEREGLMT = '".$colname2_rq_histo_paiement."'");



?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table border="0" align="center" >
  <tr>
    <td width="170" height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" width="150" height="94" /></td>
    <td height="20" colspan="3" align="center" valign="middle" class="Titre"> Liste des PAIEMENTS EFFECTUES LE  <?php echo $lib->date_fr($colname2_rq_histo_paiement); ?></td>
   
  
  
  </tr>
  <tr>
    <td height="6" colspan="7" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="730" height="1" /></td>
  </tr>
  <tr valign="middle" >
    <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr">MATRICULE</td>
    <td width="96" align="center" bgcolor="#F3F3F3" class="textBrute"><span class="nomEntrepr">PRENOM</span></td>
     <td width="89" align="center" bgcolor="#F3F3F3" class="textBrute"><span class="nomEntrepr">NOM</span></td>
    <td width="126" align="center" bgcolor="#F3F3F3" class="nomEntrepr"><span class="textBrute">MONTANT VERSE</span></td>



  </tr>
  <?php foreach($query_rq_histo_paiement->fetchAll() as $row_rq_histo_paiement ) { ?>
    <tr valign="middle">
      <td height="20" align="center" nowrap="nowrap" class="textBrute"><?php echo $row_rq_histo_paiement['MATRICULE']; ?></td>
      <td align="center" class="textBrute"><?php echo $row_rq_histo_paiement['PRENOMS']; ?></td>
      <td align="center" class="textBrute"><?php echo $row_rq_histo_paiement['NOM']; ?></td>
      <td align="center" class="textBrute"><?php echo $lib->nombre_form($row_rq_histo_paiement['MT_VERSE']); ?></td>
      

    </tr>
    <?php }  ?>
</table>
</page>

