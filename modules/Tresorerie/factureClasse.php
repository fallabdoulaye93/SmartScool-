<?php
session_start();
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();


$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $_SESSION['etab'];
}
$colname_matricule.="";
if($matricule != "" && $matricule>0)
{
    $colname_matricule.=" AND INDIVIDU.MATRICULE ='".$matricule."' ";
}

$query_fact=$dbh->query("SELECT IDFACTURE, NUMFACTURE, FACTURE.MOIS, FACTURE.MONTANT, DATEREGLMT, FACTURE.IDINSCRIPTION, FACTURE.IDETABLISSEMENT, 
                                    MT_VERSE, MT_RELIQUAT, FACTURE.ETAT, FACTURE.AVANCE, INDIVIDU.IDINDIVIDU, INDIVIDU.NOM,
                                    INDIVIDU.MATRICULE, INDIVIDU.PRENOMS, NIVEAU.LIBELLE AS LIBNIV, CLASSROOM.LIBELLE AS LIBCLASS, INSCRIPTION.FK_SECTION AS SECTION 
                                    FROM FACTURE
                                    INNER JOIN INSCRIPTION ON INSCRIPTION.IDINSCRIPTION=FACTURE.IDINSCRIPTION 
                                    INNER JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INSCRIPTION.IDINDIVIDU 
                                    INNER JOIN INDIVIDU ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                    INNER JOIN NIVEAU ON INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU 
                                    INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM=AFFECTATION_ELEVE_CLASSE.IDCLASSROOM
                                    WHERE FACTURE.MOIS='".$mois."' 
                                    AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$classe . $colname_matricule."
                                    AND INSCRIPTION.IDETABLISSEMENT = " . $colname_rq_classe . " 
                                    AND INSCRIPTION.IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));

if ($query_fact->rowCount() > 0) {

foreach ($query_fact->fetchAll() as $query_fact) {
    $mnt_section=0;
if ($query_fact['SECTION']!=0){
    $query_section=$dbh->query("SELECT `ID_SECTION`, `LIBELLE`, `MONTANT` FROM `SECTION_TRANSPORT` WHERE ID_SECTION=".$query_fact['SECTION']);
    $row_query_section=$query_section->fetchObject();
    $mnt_section=$row_query_section->MONTANT;
}
    $query_insc=$dbh->query("SELECT `NBRE_EXONORE`, MOIS_EXONORE.MOIS as moisexo 
                                       FROM `INSCRIPTION`  
                                       INNER  JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INSCRIPTION.IDINDIVIDU 
                                       LEFT  JOIN MOIS_EXONORE ON MOIS_EXONORE.IDINSCRIPTION=INSCRIPTION.IDINSCRIPTION 
                                       where MOIS_EXONORE.MOIS='".$mois."' 
                                       AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$classe." 
                                       AND INSCRIPTION.IDETABLISSEMENT = " . $colname_rq_classe . " 
                                       AND INSCRIPTION.IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE'])." 
                                       AND INSCRIPTION.IDINDIVIDU=".$query_fact['IDINDIVIDU']);
 $row_query_insc=$query_insc->fetchObject();
?>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css"/>
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <table border="0" align="center">

        <tr>
            <td height="20" align="left" valign="top" class="Titre"><img src="../../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
            <td height="20" colspan="4" align="center" valign="middle" style="font-size: 10px !important; text-align: center !important" >
                <strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                <?php echo $_SESSION['nomEtablissement']; ?><br/>
                <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?><br/>
            </td>
        </tr>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr>
            <td height="20" align="left" valign="top" class="Titre"></td>
            <td height="20" colspan="3" align="left" valign="middle" class="Titre">
                <table width="100%" border="0" cellspacing="3" cellpadding="0">
                    <tr>
                        <td width="37%" align="right" valign="middle" class="nomEntrepr"><strong> N° : </strong></td>
                        <td width="63%" align="left" valign="middle"><span
                                class="textBrute"><strong> <?php echo $query_fact['NUMFACTURE']; ?></strong></span></td>
                    </tr>
                </table>
            </td>
            <td width="131" height="20" align="left" valign="middle" class="textBrute">
                Le <?php echo $lib->date_franc($query_fact['DATEREGLMT']); ?></td>
        </tr>
        <tr>
            <td height="6" colspan="5" align="left" valign="top" class="Titre"></td>
    </tr>
        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" class="nomEntrepr"><strong>NOM:</strong></td>
            <td width="143" class="textBrute"><?php echo $query_fact['NOM']; ?></td>
            <td width="147" class="textBrute"><span class="nomEntrepr"><strong>PRENOM:</strong> </span></td>
            <td colspan="2" class="textBrute"><?php echo $query_fact['PRENOMS']; ?></td>
        </tr>
        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" valign="top" class="nomEntrepr"><strong>MATRICULE:</strong> </td>
            <td class="textBrute"><?php echo $query_fact['MATRICULE']; ?></td>
            <td class="textBrute"><span class="nomEntrepr"><strong>NIVEAU:</strong></span></td>
            <td width="138" class="textBrute"><?php echo $query_fact['LIBNIV']; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr bgcolor="#F3F3F3">

            <td class="nomEntrepr"><strong>CLASSE:</strong></td>
            <td class="textBrute"><?php echo $query_fact['LIBCLASS']; ?></td>
            <td class="textBrute" style="color: red;"><?php if($row_query_insc->moisexo==$mois) echo 'MOIS EXONORE'; ?> </td>
            <td align="left" valign="top" class="nomEntrepr"></td>
            <td class="textBrute"></td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" align="left" valign="top" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td height="16" colspan="3" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>DETAILS
                    FACTURE</strong>
            </td>
            <td height="16" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td width="159" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>MOIS:</strong></td>
            <td colspan="4" align="left" valign="top"
                class="textBrute"><?php echo $lib->affiche_mois($query_fact['MOIS']); ?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>MONTANT SCOLARITE:</strong> </td>
            <td colspan="4" align="left" valign="middle"
                class="textBrute"><?php echo $lib->nombre_form($query_fact['MONTANT']); ?></td>
        </tr>
        <?php if($mnt_section>0) {?>
            <tr valign="baseline" bgcolor="#F3F3F3">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>TRANSPORT:</strong></td>
                <td colspan="4" class="textBrute"><?php echo $lib->nombre_form($mnt_section); ?></td>
            </tr>

        <?php } else {?>
            <tr valign="baseline" bgcolor="#F3F3F3">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>TRANSPORT:</strong></td>
                <td colspan="4" class="textBrute"><?php echo 0; ?></td>
            </tr>
        <?php } ?>


        <!--<tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>MONTANT VERSE:</strong></td>
            <td colspan="4" class="textBrute"><?php /*echo $lib->nombre_form($query_fact['MT_VERSE']); */?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>RELIQUAT:</strong></td>
            <td colspan="4" class="textBrute"><?php /*echo $lib->nombre_form($query_fact['MT_RELIQUAT']); */?></td>
        </tr>-->
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>TOTAL NET A PAYER:</strong></td>
            <td colspan="4" class="textBrute"><?php echo $lib->nombre_form($query_fact['MONTANT'] + $mnt_section); ?></td>
        </tr>
        <?php if($query_fact['AVANCE']==1) {?>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><span style="color: red;">FACTURE PAYER</span>&nbsp;</td>
                <td colspan="4" class="textBrute">&nbsp;</td>
            </tr>
        <?php } ?>

        <tr valign="middle">
            <td height="48"  nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute" align="right"><strong>Le Comptable</strong></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>

    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle">-------------------------------------------------------------------------------------------------------------------</td>
        </tr>
    </table>
    <table border="0" align="center">

        <tr>
            <td height="20" align="left" valign="top" class="Titre"><img src="../../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
            <td height="20" colspan="4" align="center" valign="middle" style="font-size: 10px !important; text-align: center !important" >
                <strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                <?php echo $_SESSION['nomEtablissement']; ?><br/>
                <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?><br/>
            </td>
        </tr>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr>
            <td height="20" align="left" valign="top" class="Titre"></td>
            <td height="20" colspan="3" align="left" valign="middle" class="Titre">
                <table width="100%" border="0" cellspacing="3" cellpadding="0">
                    <tr>
                        <td width="37%" align="right" valign="middle" class="nomEntrepr"><strong>N ° :</strong> </td>
                        <td width="63%" align="left" valign="middle"><span
                                    class="textBrute"> <strong><?php echo $query_fact['NUMFACTURE']; ?></strong></span></td>
                    </tr>
                </table>
            </td>
            <td width="131" height="20" align="left" valign="middle" class="textBrute">
                Le <?php echo $lib->date_franc($query_fact['DATEREGLMT']); ?></td>
        </tr>
        <tr>
            <td height="6" colspan="5" align="left" valign="top" class="Titre"></td>
        </tr>
        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" class="nomEntrepr"><strong>NOM:</strong></td>
            <td width="143" class="textBrute"><?php echo $query_fact['NOM']; ?></td>
            <td width="147" class="textBrute"><span class="nomEntrepr"><strong>PRENOM:</strong> </span></td>
            <td colspan="2" class="textBrute"><?php echo $query_fact['PRENOMS']; ?></td>
        </tr>
        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" valign="top" class="nomEntrepr"><strong>MATRICULE:</strong> </td>
            <td class="textBrute"><?php echo $query_fact['MATRICULE']; ?></td>
            <td class="textBrute"><span class="nomEntrepr"><strong>NIVEAU:</strong></span></td>
            <td width="138" class="textBrute"><?php echo $query_fact['LIBNIV']; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
        <tr bgcolor="#F3F3F3">

            <td class="nomEntrepr"><strong>CLASSE:</strong></td>
            <td class="textBrute"><?php echo $query_fact['LIBCLASS']; ?></td>
            <td class="textBrute" style="color: red;"><?php if($row_query_insc->moisexo==$mois) echo 'MOIS EXONORE'; ?> </td>
            <td align="left" valign="top" class="nomEntrepr"></td>
            <td class="textBrute"></td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" align="left" valign="top" class="textBrute">&nbsp;</td>
        </tr>
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td height="16" colspan="3" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>DETAILS
                    FACTURE</strong>
            </td>
            <td height="16" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td width="159" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>MOIS:</strong></td>
            <td colspan="4" align="left" valign="top"
                class="textBrute"><?php echo $lib->affiche_mois($query_fact['MOIS']); ?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>MONTANT:</strong> </td>
            <td colspan="4" align="left" valign="middle"
                class="textBrute"><?php echo $lib->nombre_form($query_fact['MONTANT']); ?></td>
        </tr>
        <?php if($mnt_section>0) {?>
            <tr valign="baseline" bgcolor="#F3F3F3">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>TRANSPORT:</strong></td>
                <td colspan="4" class="textBrute"><?php echo $lib->nombre_form($mnt_section); ?></td>
            </tr>

        <?php } else {?>
            <tr valign="baseline" bgcolor="#F3F3F3">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>TRANSPORT:</strong></td>
                <td colspan="4" class="textBrute"><?php echo 0; ?></td>
            </tr>
        <?php } ?>
       <!-- <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>MONTANT VERSE:</strong></td>
            <td colspan="4" class="textBrute"><?php /*echo $lib->nombre_form($query_fact['MT_VERSE']); */?></td>
        </tr>
        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>RELIQUAT:</strong></td>
            <td colspan="4" class="textBrute"><?php /*echo $lib->nombre_form($query_fact['MT_RELIQUAT']); */?></td>
        </tr>-->
        <tr valign="baseline">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td colspan="4" class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><strong>TOTAL NET A PAYER:</strong></td>
            <td colspan="4" class="textBrute"><?php echo $lib->nombre_form($query_fact['MONTANT'] + $mnt_section); ?></td>
        </tr>

        <?php if($query_fact['AVANCE']==1) {?>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr"><span style="color: red;">FACTURE PAYER</span>&nbsp;</td>
                <td colspan="4" class="textBrute">&nbsp;</td>
            </tr>
        <?php } ?>
        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="middle">
            <td height="48" align="right" nowrap="nowrap" class="nomEntrepr"></td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute" align="right"><strong>Le Comptable</strong></td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>


</page>
<?php } } ?>