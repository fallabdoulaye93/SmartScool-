
<?php 
if (!isset($_SESSION)){
    session_start();
}

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


$colname_rq_benificiaire = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_benificiaire = $lib->securite_xss($_GET['IDINDIVIDU']);
}

$query_rq_benificiaire = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, NIVEAU.LIBELLE AS NIVEAU, SERIE.LIBSERIE AS FILIERE 
                                                FROM INDIVIDU, NIVEAU, SERIE 
                                                WHERE SERIE.IDETABLISSEMENT=NIVEAU.IDETABLISSEMENT 
                                                AND NIVEAU.IDETABLISSEMENT=INDIVIDU.IDETABLISSEMENT 
                                                AND INDIVIDU.IDINDIVIDU=".$colname_rq_benificiaire);
$row_rq_benificiaire = $query_rq_benificiaire->fetchObject();


$colname_rq_mensualite = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_mensualite = $lib->securite_xss($_GET['IDINSCRIPTION']);
}

$query_rq_mensualite = $dbh->query("SELECT MENSUALITE.MT_VERSE, MENSUALITE.MT_RELIQUAT, MENSUALITE.DATEREGLMT, MENSUALITE.MONTANT, MENSUALITE.MOIS, MENSUALITE.IDINSCRIPTION 
                                              FROM MENSUALITE 
                                              WHERE MENSUALITE.IDINSCRIPTION=".$colname_rq_mensualite);
$row_rq_mensualite = $query_rq_mensualite->fetchObject();


//historique de la mensualite
$colname_rq_historique_mensulaite=$row_rq_mensualite->IDINSCRIPTION;
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_historique_mensulaite = $lib->securite_xss($_GET['IDINSCRIPTION']);
}

$query_rq_historique_mensulaite = $dbh->query("SELECT * FROM MENSUALITE WHERE IDINSCRIPTION = ".$colname_rq_historique_mensulaite." ORDER BY IDMENSUALITE ASC");
$rs_mensualite = $query_rq_historique_mensulaite->fetchAll();



$colname_rq_niveau =$row_rq_mensualite->IDINSCRIPTION;

$query_rq_niveau = $dbh->query("SELECT NIVEAU.LIBELLE FROM INSCRIPTION, NIVEAU WHERE IDINSCRIPTION = ".$colname_rq_niveau."  AND INSCRIPTION.IDNIVEAU = NIVEAU.IDNIVEAU");

$row_rq_niveau = $query_rq_niveau->fetchObject();
$tot=0;
?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table border="0" align="center" >
  <tr>
    <td height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" width="150" height="94" /></td>
    <td height="20" colspan="3" align="center" valign="middle" class="Titre">RE&Ccedil;U DE PAIEMENT</td>
    <td width="116" height="20" align="left" valign="middle" class="Titre"><p>Le <?php echo $lib->date_franc($row_rq_mensualite->DATEREGLMT); ?> <br />
        <br />
        N° : <?php echo  $lib->securite_xss($_GET['IDINSCRIPTION']); ?>       <br />
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
        <td width="139" class="textBrute"><?php echo $row_rq_benificiaire->NOM; ?></td>
        <td width="220" class="textBrute"><span class="nomEntrepr">PRENOM:</span></td>
        <td colspan="2" class="textBrute"><?php echo $row_rq_benificiaire->PRENOMS; ?></td>
        </tr>
      <tr bgcolor="#F3F3F3">
        <td width="152" align="left" valign="top" class="nomEntrepr">MATRICULE:</td>
        <td class="textBrute"><?php echo $row_rq_benificiaire->MATRICULE; ?></td>
        <td class="textBrute"><span class="nomEntrepr">NIVEAU:</span></td>
        <td width="107" class="textBrute" colspan="2"><?php echo $row_rq_niveau->LIBELLE; ?></td>
      </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
          <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE REGLEMENTS </span></td>
          <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
          <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
          <td class="nomEntrepr">MOIS</td>
          <td class="textBrute"><span class="nomEntrepr">MONTANT</span></td>
          <td class="textBrute"><span class="nomEntrepr">RELIQUAT</span></td>
          <td class="textBrute">&nbsp;</td>
        </tr>

        <?php foreach($rs_mensualite as $row_rq_historique_mensulaite ) { ?>

          <tr valign="middle">
            <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span class="textBrute"><?php echo $lib->date_franc($row_rq_historique_mensulaite['DATEREGLMT']); ?></span></td>
            <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $row_rq_historique_mensulaite['MOIS']; ?></td>
            <td align="right" bgcolor="#F3F3F3" class="textBrute"><?php $tot=$tot+$row_rq_historique_mensulaite['MT_VERSE']; echo $lib->nombre_form($row_rq_historique_mensulaite['MT_VERSE']); ?></td>
            <td align="right" bgcolor="#F3F3F3" class="textBrute"><?php echo $lib->nombre_form($row_rq_historique_mensulaite['MT_RELIQUAT']); ?></td>
            <td class="textBrute">&nbsp;</td>
          </tr>

          <?php }  ?>

        <tr valign="middle">
          <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">TOTAL:</td>
          <td align="right" class="textBrute"><?php echo $lib->nombre_form($tot); ?></td>
          <td class="nomEntrepr">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
          <td class="textBrute">&nbsp;</td>
  </tr>
</table>
</page>

