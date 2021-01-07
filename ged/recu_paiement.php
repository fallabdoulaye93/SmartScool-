<?php
if (session_status() == 1) {
    session_start();
}
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
$colname_rq_benificiaire = "-1";
if (isset($_GET['IDINDIVIDU'])) {
    $colname_rq_benificiaire = $_GET['IDINDIVIDU'];
}
$query_rq_benificiaire = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, NIVEAU.LIBELLE AS NIVEAU, SERIE.LIBSERIE AS FILIERE FROM INDIVIDU, NIVEAU, SERIE WHERE SERIE.IDETABLISSEMENT=NIVEAU.IDETABLISSEMENT AND NIVEAU.IDETABLISSEMENT=INDIVIDU.IDETABLISSEMENT AND INDIVIDU.IDINDIVIDU=" . $colname_rq_benificiaire);
$row_rq_benificiaire = $query_rq_benificiaire->fetchObject();
//niveau
$colname_rq_mensualite = "-1";
if (isset($_GET['IDMENSUALITE'])) {
    $colname_rq_mensualite = $_GET['IDMENSUALITE'];
}
$query_rq_mensualite = $dbh->query("SELECT MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, MT_VERSE, MT_RELIQUAT,MENSUALITE. id_type_paiment,TYPE_PAIEMENT.libelle_paiement FROM MENSUALITE, TYPE_PAIEMENT WHERE IDMENSUALITE = " . $colname_rq_mensualite . "  AND TYPE_PAIEMENT.id_type_paiment = MENSUALITE.id_type_paiment");
$row_rq_mensualite = $query_rq_mensualite->fetchObject();
//historique de la mensualite
$colname_rq_historique_mensulaite = $row_rq_mensualite->IDINSCRIPTION;
if (isset($_GET['IDINSCRIPTION'])) {
    $colname_rq_historique_mensulaite = $_GET['IDINSCRIPTION'];
}
$query_rq_historique_mensulaite = $dbh->query("SELECT * FROM MENSUALITE WHERE IDINSCRIPTION = " . $colname_rq_historique_mensulaite . " ORDER BY IDMENSUALITE ASC");
$colname_rq_niveau = $row_rq_mensualite->IDINSCRIPTION;
$query_rq_niveau = $dbh->query("SELECT NIVEAU.LIBELLE FROM INSCRIPTION, NIVEAU WHERE IDINSCRIPTION = " . $colname_rq_niveau . "  AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU");
$row_rq_niveau = $query_rq_niveau->fetchObject();
$tot = 0;
?>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css"/>
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">

    <table border="0" width="100%"  >

        <tr>
            <td align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
            <td colspan="3" align="center" valign="middle">

            </td>
            <td colspan="3" align="center" style="font-size: 10px !important; text-align: center !important">
                <strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                <?php echo $_SESSION['nomEtablissement']; ?><br/>
                <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?><br/>
            </td>
            <br>
        </tr>

    </table>

    <table border="0" align="center">



        <tr>
            <td height="20" align="left" valign="top" class="Titre"></td>
            <td height="20" colspan="3" align="center" valign="middle" class="Titre"><strong>RE&Ccedil;U DE PAIEMENT</strong></td>
            <td width="116" height="20" align="left" valign="middle" class="Titre"><p> <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                </p></td>
        </tr>

        <tr>
            <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="742" height="1"/></td>

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
            <td width="103" class="textBrute"><?php echo $row_rq_niveau->LIBELLE; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" align="left" valign="top" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td height="16" colspan="3" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr">Reglement
                mensualit&Eacute;</td>
            <td height="16" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td width="152" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Mois</td>
            <td colspan="4" align="left" valign="top" class="textBrute"><?php echo $lib->affiche_mois($row_rq_mensualite->MOIS); ?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Montant vers&eacute;:</td>
            <td colspan="4"><span class="textBrute"
                                  id="sprytextfield3"><?php echo $lib->nombre_form($row_rq_mensualite->MT_VERSE); ?></span>
            </td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Reliquat:</td>
            <td colspan="4" class="textBrute"><?php echo $lib->nombre_form($row_rq_mensualite->MT_RELIQUAT); ?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">type de paiement:</td>
            <td colspan="4" class="textBrute"><?php echo $row_rq_mensualite->libelle_paiement; ?></td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE Reglements </span>
            </td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
            <td class="nomEntrepr">MOIS</td>
            <td class="textBrute"><span class="nomEntrepr">Montant</span></td>
            <td class="textBrute"><span class="nomEntrepr">type du paiement</span></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <?php foreach ($query_rq_historique_mensulaite->fetchAll() as $row_rq_historique_mensulaite) { ?>
            <tr valign="middle">
                <td height="20" align="left" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr">
                    <span class="textBrute"><?php echo $lib->date_franc($row_rq_historique_mensulaite['DATEREGLMT']); ?></span>
                </td>
                <td align="left" bgcolor="#F3F3F3"
                    class="textBrute"><?php echo $row_rq_historique_mensulaite['MOIS']; ?></td>
                <td align="left" bgcolor="#F3F3F3"
                    class="textBrute"><?php $tot = $tot + $row_rq_historique_mensulaite['MT_VERSE'];
                    echo $lib->nombre_form($row_rq_historique_mensulaite['MT_VERSE']); ?></td>
                <td align="left" bgcolor="#F3F3F3"
                    class="textBrute"><?php if ($row_rq_historique_mensulaite['id_type_paiment'] == 1) {

                        echo "CHEQUE";
                    }
                    if ($row_rq_historique_mensulaite['id_type_paiment'] == 2) {

                        echo "ESPECE";
                    }
                    if ($row_rq_historique_mensulaite['id_type_paiment'] == 3) {

                        echo "VIREMENT";
                    } ?>
                </td>
                <td class="textBrute">&nbsp;</td>
            </tr>
        <?php } ?>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">TOTAL:</td>
            <td align="right" class="textBrute"><?php echo $lib->nombre_form($tot); ?></td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>
</page>
