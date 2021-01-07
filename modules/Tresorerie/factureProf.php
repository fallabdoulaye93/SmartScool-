<?php
session_start();
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = intval($_SESSION['etab']);
}
try
{
    $query_rq_benificiaire = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE
                                                    FROM INDIVIDU WHERE IDINDIVIDU=".$prof);
    $row_rq_benificiaire = $query_rq_benificiaire->fetchObject();

    $query_rq_regle = $dbh->query("SELECT IDREGLEMENT, DATE_REGLEMENT, MOIS, MONTANT, INDIVIDU, MOTIF, IDTYPEPAIEMENT, recu, REGLEMENT_PROF.IDANNEESCOLAIRE, MONTANT_VERSE, NUM_CHEQUE, 
                                             FK_BANQUE, REGLEMENT_PROF.IDETABLISSEMENT
                                             FROM REGLEMENT_PROF 
                                             WHERE INDIVIDU = ".$prof." 
                                             AND MOIS = '".$mois."' 
                                             AND IDETABLISSEMENT = " . $colname_rq_classe . " 
                                             AND IDANNEESCOLAIRE = " . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
    $rs_regle = $query_rq_regle->fetchAll();

    $query_rq_regle2 = $dbh->query("SELECT IDREGLEMENT, DATE_REGLEMENT, MOIS, MONTANT, INDIVIDU, MOTIF, IDTYPEPAIEMENT, recu, REGLEMENT_PROF.IDANNEESCOLAIRE, MONTANT_VERSE, NUM_CHEQUE, FK_BANQUE, REGLEMENT_PROF.IDETABLISSEMENT
                                              FROM REGLEMENT_PROF 
                                              WHERE INDIVIDU = ".$prof." 
                                              AND MOIS = '".$mois."' 
                                              AND IDETABLISSEMENT = " . $colname_rq_classe . " 
                                              AND IDANNEESCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
    $rs_regle2 = $query_rq_regle2->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
?>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
    <table border="0" align="center" >

        <tr>
            <td height="20" align="left" valign="top" class="Titre"><img src="../../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
            <td height="20" colspan="4" align="center" valign="middle" style="font-size: 10px !important; text-align: center !important"><strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                <?php echo $_SESSION['nomEtablissement']; ?><br/>
                <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?>
            </td>
        </tr>

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
            <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../../assets/images/im_lign.jpg" width="742" height="1" /></td>
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
            <td class="textBrute"><span class="nomEntrepr">TELEPHONE:</span></td>
            <td width="107" class="textBrute"><?php echo $row_rq_benificiaire->TELMOBILE; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr"></span></td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline">
            <td height="16" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE</td>
            <td class="nomEntrepr" align="center">MOIS</td>
            <td class="textBrute" align="center"><span class="nomEntrepr">Montant</span></td>

            <td class="textBrute">&nbsp;</td>
        </tr>
        <?php foreach($rs_regle as $row_rq_historique_mensulaite ) { ?>
            <tr valign="middle" >
                <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span class="textBrute"><?php echo $lib->date_franc($row_rq_historique_mensulaite['DATE_REGLEMENT']); ?></span></td>
                <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $lib->affiche_mois($row_rq_historique_mensulaite['MOIS']); ?></td>
                <td align="right" bgcolor="#F3F3F3" class="textBrute"><?php $tot=$tot+$row_rq_historique_mensulaite['MONTANT_VERSE']; echo $lib->nombre_form($row_rq_historique_mensulaite['MONTANT_VERSE']); ?></td>
                <td class="textBrute">&nbsp;</td>
            </tr>
        <?php }  ?>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" nowrap="nowrap" class="nomEntrepr">TOTAL:</td>
            <td align="right" class="textBrute">&nbsp;<?php echo $lib->nombre_form($tot); ?></td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr>
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="textBrute" align="right"><br><br><br>
                <strong>Le Comptable</strong></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>
<table><tr><td >

            <br/>
            <br/>
            <br/>
        ____________________________________________________________________________________________________________________


            <br/>
            <br/>
            <br/>
            <br/>
        </td> </tr></table>

    <table border="0" align="center" >
        <tr>
            <td height="20" align="left" valign="top" class="Titre"><img src="../../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
            <td height="20" colspan="4" align="center" valign="middle" style="font-size: 10px !important; text-align: center !important"><strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                <?php echo $_SESSION['nomEtablissement']; ?><br/>
                <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?>
            </td>
        </tr>
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
            <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../../assets/images/im_lign.jpg" width="742" height="1" /></td>
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
            <td class="textBrute"><span class="nomEntrepr">TELEPHONE:</span></td>
            <td width="107" class="textBrute"><?php echo $row_rq_benificiaire->TELMOBILE; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr"></span></td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline">
            <td height="16" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE</td>
            <td class="nomEntrepr" align="center">MOIS</td>
            <td class="textBrute" align="center"><span class="nomEntrepr">Montant</span></td>

            <td class="textBrute">&nbsp;</td>
        </tr>
        <?php foreach($rs_regle2 as $row_rq_historique_mensulaite ) { ?>
            <tr valign="middle" >
                <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span class="textBrute"><?php echo $lib->date_franc($row_rq_historique_mensulaite['DATE_REGLEMENT']); ?></span></td>
                <td align="center" bgcolor="#F3F3F3" class="textBrute"><?php echo $lib->affiche_mois($row_rq_historique_mensulaite['MOIS']); ?></td>
                <td align="right" bgcolor="#F3F3F3" class="textBrute"><?php $tot2=$tot2+$row_rq_historique_mensulaite['MONTANT_VERSE']; echo $lib->nombre_form($row_rq_historique_mensulaite['MONTANT_VERSE']); ?></td>
                <td class="textBrute">&nbsp;</td>
            </tr>
        <?php }  ?>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" nowrap="nowrap" class="nomEntrepr">TOTAL:</td>
            <td align="right" class="textBrute">&nbsp;<?php echo $lib->nombre_form($tot2); ?></td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr>
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="textBrute" align="right"><br><br><br>
                <strong>Le Comptable</strong></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>
</page>

