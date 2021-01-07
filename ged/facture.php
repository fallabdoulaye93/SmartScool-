<?php
session_start();
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(26, $_SESSION['profil']));


$colname_rq_mensualite = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_mensualite = $_SESSION['etab'];
}

$idIndividu = "-1";
if (isset($_GET['individu'])) {
    $idIndividu = $lib->securite_xss(base64_decode($_GET['individu'])) ;
}

$idAnnescolaire = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $idAnnescolaire = $_SESSION['ANNEESSCOLAIRE'];
}

$idInscription = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
    $idInscription = $lib->securite_xss(base64_decode($_GET['IDINSCRIPTION']));
}

$idFacture = $lib->securite_xss(base64_decode($_GET['facture']));

$req_fact = $dbh->query("SELECT * FROM `FACTURE` WHERE IDFACTURE=".$idFacture);
$res_fact = $req_fact->fetchObject();

$req_fact_transport = $dbh->query("SELECT * FROM `TRANSPORT_MENSUALITE` WHERE NUM_FACTURE='".$res_fact->NUMFACTURE."'");
$res_fact_transport = $req_fact_transport->fetchObject();

$query_rq_benificiaire = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, NIVEAU.LIBELLE AS NIVEAU, SERIE.LIBSERIE AS FILIERE FROM INDIVIDU, NIVEAU, SERIE WHERE SERIE.IDETABLISSEMENT=NIVEAU.IDETABLISSEMENT AND NIVEAU.IDETABLISSEMENT=INDIVIDU.IDETABLISSEMENT AND INDIVIDU.IDINDIVIDU=" . $idIndividu);
$row_rq_benificiaire = $query_rq_benificiaire->fetchObject();


$query_rq_niveau = $dbh->query("SELECT NIVEAU.LIBELLE FROM INSCRIPTION, NIVEAU WHERE INSCRIPTION.IDINSCRIPTION = " . $idInscription . "  AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU");
$row_rq_niveau = $query_rq_niveau->fetchObject();

$query_rq_filiere = $dbh->query("SELECT SERIE.LIBSERIE, INSCRIPTION.IDINSCRIPTION FROM SERIE, INSCRIPTION WHERE  INSCRIPTION.IDINSCRIPTION=" . $idInscription . " AND INSCRIPTION.IDSERIE=SERIE.IDSERIE");
$row_rq_filiere = $query_rq_filiere->fetchObject();

$query_rq_classe = $dbh->query("SELECT CLASSROOM.LIBELLE FROM AFFECTATION_ELEVE_CLASSE, CLASSROOM WHERE IDINDIVIDU = " . $idIndividu . " AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=CLASSROOM.IDCLASSROOM AND AFFECTATION_ELEVE_CLASSE.IDANNEESSCOLAIRE=" . $idAnnescolaire);
$row_rq_classe = $query_rq_classe->fetchObject();

$query_rq_classe = $dbh->query("SELECT CLASSROOM.LIBELLE FROM AFFECTATION_ELEVE_CLASSE, CLASSROOM WHERE IDINDIVIDU = " . $idIndividu . " AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=CLASSROOM.IDCLASSROOM AND AFFECTATION_ELEVE_CLASSE.IDANNEESSCOLAIRE=" . $idAnnescolaire);
$row_rq_classe = $query_rq_classe->fetchObject();

$query_rq_facture_nopayees = $dbh->query("SELECT * FROM FACTURE WHERE IDINSCRIPTION = " . $idInscription . " AND FACTURE.ETAT=0 AND FACTURE.IDFACTURE=" . $idFacture);
$query_rq_facture_impayees = $dbh->query("SELECT * FROM FACTURE WHERE IDINSCRIPTION = " . $idInscription . " AND FACTURE.ETAT=2 AND FACTURE.IDFACTURE=" . $idFacture);

$req_mensu = $dbh->query("SELECT MENSUALITE.id_type_paiment, libelle_paiement, NUM_CHEQUE FROM `MENSUALITE` INNER JOIN TYPE_PAIEMENT ON MENSUALITE.id_type_paiment = TYPE_PAIEMENT.id_type_paiment WHERE NUMFACT='".$res_fact->NUMFACTURE."'");
$res_mensu = $req_mensu->fetchObject();

$res_mensu_id = $res_mensu->id_type_paiment;
$res_mensu_libelle = $res_mensu->libelle_paiement;
$res_mensu_num = $res_mensu->NUM_CHEQUE;

//var_dump($query_rq_facture_nopayees->fetchObject());die();

$tot = 0;
$tot_ = 0;
?>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css"/>
<page backtop="7mm" backbottom="7mm" backleft="5mm" backright="1000mm">
    <table border="0" align="center">
        <tr>
            <td height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>

            <td height="20" colspan="4" align="center" valign="middle">
                <table align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center"><strong><?php echo $_SESSION['SIGLE']; ?></strong></td>
                    </tr>
                    <tr>
                        <td align="center"><?php echo $_SESSION['nomEtablissement']; ?></td>
                    </tr>
                    <tr>
                        <td align="center"><strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?></td>
                    </tr>
                </table>
            </td>

        </tr>
        <tr>
            <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="742" height="1"/></td>
        </tr>
        <tr>
            <td height="20" align="center" valign="top" class="Titre" colspan="3">RECU DE PAIEMENT</td>
            <td height="20"  colspan="2" valign="middle" class="textBrute" align="center">
                Le <?php echo $lib->date_franc($res_fact->DATEREGLMT); ?></td>
        </tr>

        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" class="nomEntrepr">NOM:</td>
            <td width="143" class="textBrute"><?php echo $row_rq_benificiaire->NOM; ?></td>
            <td width="147" class="textBrute"><span class="nomEntrepr">PRENOM:</span></td>
            <td colspan="2" class="textBrute"><?php echo $row_rq_benificiaire->PRENOMS; ?></td>
        </tr>
        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" valign="top" class="nomEntrepr">MATRICULE:</td>
            <td class="textBrute"><?php echo $row_rq_benificiaire->MATRICULE; ?></td>
            <td class="nomEntrepr">Classe:</td>
            <td class="textBrute"><?php echo $row_rq_classe->LIBELLE; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Type de payement: </td>
            <td width="143" align="left" class="textBrute"><?php echo strtoupper($res_mensu_libelle) ;?> </td>
            <?php if($res_mensu_id == "1" || $res_mensu_id == "3") {?>
                <td width="147" class="textBrute"><span class="nomEntrepr">NUMERO:</span></td>
                <td colspan="2" class="textBrute"><?php echo $res_mensu_num;?> </td>
            <?php };?>
        </tr>
        <tr valign="baseline">

            <td colspan="2" align="left" nowrap="nowrap">
                <!--<fieldset class="cadre">-->
                <table align="center" width="100%">


                    <tr bgcolor="#F3F3F3">
                        <td colspan="2" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr"><span>SCOLARITE</span></td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td width="159" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Mois</td>
                        <td  align="right" valign="top"
                             class="textBrute"><?php echo $lib->affiche_mois($res_fact->MOIS); ?>
                        </td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">MONTANT:</td>
                        <td align="right" valign="middle"
                            class="textBrute"><?php echo $lib->nombre_form($res_fact->MONTANT); ?></td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Montant verse:</td>
                        <td class="textBrute" align="right"><?php echo $lib->nombre_form($res_fact->MT_VERSE); $tot+=$res_fact->MT_VERSE; ?></td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Reliquat:</td>
                        <td align="right" class="textBrute"><?php echo $lib->nombre_form($res_fact->MT_RELIQUAT); ?></td>
                    </tr>

                </table>
                <!--</fieldset>-->
            </td>

            <?php if($res_fact_transport) {?>

                <td colspan="3" align="right" nowrap="nowrap">
                    <!--<fieldset class="cadre">-->

                    <table align="center" width="100%">

                        <tr bgcolor="#F3F3F3">
                            <td colspan="2" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr"><span>TRANSPORT</span></td>
                        </tr>


                        <tr valign="baseline" bgcolor="#F3F3F3">
                            <?php if($res_fact_transport) {?>
                                <td width="159" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Mois</td>
                                <td align="right" valign="top"
                                    class="textBrute"><?php echo $lib->affiche_mois($res_fact->MOIS); ?>
                                </td>
                            <?php }?>
                        </tr>

                        <tr valign="baseline" bgcolor="#F3F3F3">
                            <?php if($res_fact_transport) {?>
                                <td align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">MONTANT:</td>
                                <td align="right" valign="middle" class="textBrute"><?php echo $lib->nombre_form($res_fact_transport->MONTANT); ?></td>
                            <?php }?>
                        </tr>

                        <tr valign="baseline" bgcolor="#F3F3F3">

                            <?php if($res_fact_transport) {?>
                                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Montant verse:</td>
                                <td colspan="3" class="textBrute" align="right"><?php echo $lib->nombre_form($res_fact_transport->MT_VERSE); $tot+=$res_fact_transport->MT_VERSE;?></td>
                            <?php }?>
                        </tr>

                        <tr valign="baseline" bgcolor="#F3F3F3">
                            <?php if($res_fact_transport) {?>
                                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Reliquat:</td>
                                <td colspan="3" align="right" class="textBrute"><?php echo $lib->nombre_form($res_fact_transport->MT_RELIQUAT); ?></td>
                            <?php }?>
                        </tr>
                    </table>
                    <!--</fieldset>-->
                </td>

            <?php }?>

        </tr>

        <?php if ($query_rq_facture_nopayees->rowCount() > 0) { ?>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
                <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE DES FACTURES NON PAYEES</span>
                </td>
                <td class="textBrute">&nbsp;</td>
            </tr>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
                <td class="nomEntrepr">MOIS</td>
                <td class="textBrute"><span class="nomEntrepr">Montant</span></td>
                <td class="nomEntrepr">MONTANT VERSE</td>
                <td class="nomEntrepr">RELIQUAT</td>
            </tr>
            <?php foreach ($query_rq_facture_nopayees->fetchAll() as $row_rq_facture_nopayees) {
                //$tot += $row_rq_facture_nopayees['MT_RELIQUAT'];
                ?>
                <tr valign="middle">
                    <td height="20" align="left" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span
                                class="textBrute"><?php echo $lib->date_franc($row_rq_facture_nopayees['DATEREGLMT']); ?></span>
                    </td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->affiche_mois($row_rq_facture_nopayees['MOIS']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_nopayees['MONTANT']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_nopayees['MT_VERSE']); ?>
                    </td>
                    <td bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_nopayees['MT_RELIQUAT']); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        <?php if ($query_rq_facture_impayees->rowCount() > 0) { ?>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
                <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE DES FACTURES IMPAYEES</span>
                </td>
                <td class="textBrute">&nbsp;</td>
            </tr>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
                <td class="nomEntrepr">MOIS</td>
                <td class="textBrute"><span class="nomEntrepr">Montant</span></td>
                <td class="nomEntrepr">MONTANT VERSE</td>
                <td class="nomEntrepr">RELIQUAT</td>
            </tr>
            <?php foreach ($query_rq_facture_impayees->fetchAll() as $row_rq_facture_impayees) {
                //$tot += $row_rq_facture_impayees['MT_RELIQUAT'];
                ?>
                <tr valign="middle">
                    <td height="20" align="left" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span
                                class="textBrute"><?php echo $lib->date_franc($row_rq_facture_impayees['DATEREGLMT']); ?></span>
                    </td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->affiche_mois($row_rq_facture_impayees['MOIS']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_impayees['MONTANT']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_impayees['MT_VERSE']); ?>
                    </td>
                    <td bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_impayees['MT_RELIQUAT']); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">TOTAL VERSEMENT :</td>
            <td align="right" class="textBrute">&nbsp;<?php echo $lib->nombre_form($tot); ?> F CFA</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute"></td>
        </tr>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td align="right" class="nomEntrepr">Le comptable</td>
        </tr>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>
    <br>
    _________________________________________________________________________________________________________________________________________________________________________
    <br>
    <br>
    <?php
    $tot = 0;
    $tot_ = 0;
    ;?>
    <table border="0" align="center">
        <tr>
            <td height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
            <td height="20" colspan="4" align="center" valign="middle">
                <table align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center"><strong><?php echo $_SESSION['SIGLE']; ?></strong></td>
                    </tr>
                    <tr>
                        <td align="center"><?php echo $_SESSION['nomEtablissement']; ?></td>
                    </tr>

                    <tr>
                        <td align="center"><strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?></td>
                    </tr>
                </table>
            </td>

        </tr>
        <tr>
            <td height="6" colspan="5" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="742" height="1"/></td>
        </tr>
        <tr>
            <td height="20" align="center" valign="top" class="Titre" colspan="3">RECU DE PAIEMENT</td>
            <td height="20"  colspan="2" valign="middle" class="textBrute" align="center">
                Le <?php echo $lib->date_franc($res_fact->DATEREGLMT); ?></td>
        </tr>

        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" class="nomEntrepr">NOM:</td>
            <td width="143" class="textBrute"><?php echo $row_rq_benificiaire->NOM; ?></td>
            <td width="147" class="textBrute"><span class="nomEntrepr">PRENOM:</span></td>
            <td colspan="2" class="textBrute"><?php echo $row_rq_benificiaire->PRENOMS; ?></td>
        </tr>
        <tr bgcolor="#F3F3F3">
            <td width="159" align="left" valign="top" class="nomEntrepr">MATRICULE:</td>
            <td class="textBrute"><?php echo $row_rq_benificiaire->MATRICULE; ?></td>
            <td class="nomEntrepr">Classe:</td>
            <td class="textBrute"><?php echo $row_rq_classe->LIBELLE; ?></td>
            <td class="textBrute">&nbsp;</td>
        </tr>

        <tr valign="baseline" bgcolor="#F3F3F3">
            <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Type de payement: </td>
            <td width="143" align="left" class="textBrute"><?php echo strtoupper($res_mensu_libelle) ;?> </td>
            <?php if($res_mensu_id == "1" || $res_mensu_id == "3") {?>
                <td width="147" class="textBrute"><span class="nomEntrepr">NUMERO:</span></td>
                <td colspan="2" class="textBrute"><?php echo $res_mensu_num;?> </td>
            <?php };?>
        </tr>
        <tr valign="baseline">

            <td colspan="2" align="left" nowrap="nowrap">
                <!--<fieldset class="cadre">-->
                <table align="center" width="100%">


                    <tr bgcolor="#F3F3F3">
                        <td colspan="2" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr"><span>SCOLARITE</span></td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td width="159" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Mois</td>
                        <td  align="right" valign="top"
                             class="textBrute"><?php echo $lib->affiche_mois($res_fact->MOIS); ?>
                        </td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">MONTANT:</td>
                        <td align="right" valign="middle"
                            class="textBrute"><?php echo $lib->nombre_form($res_fact->MONTANT); ?></td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Montant verse:</td>
                        <td class="textBrute" align="right"><?php echo $lib->nombre_form($res_fact->MT_VERSE); $tot+=$res_fact->MT_VERSE; ?></td>
                    </tr>

                    <tr valign="baseline" bgcolor="#F3F3F3">
                        <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Reliquat:</td>
                        <td align="right" class="textBrute"><?php echo $lib->nombre_form($res_fact->MT_RELIQUAT); ?></td>
                    </tr>

                </table>
                <!--</fieldset>-->
            </td>

            <?php if($res_fact_transport) {?>

                <td colspan="3" align="right" nowrap="nowrap">
                    <!--<fieldset class="cadre">-->

                    <table align="center" width="100%">

                        <tr bgcolor="#F3F3F3">
                            <td colspan="2" align="center" valign="middle" nowrap="nowrap" class="nomEntrepr"><span>TRANSPORT</span></td>
                        </tr>


                        <tr valign="baseline" bgcolor="#F3F3F3">
                            <?php if($res_fact_transport) {?>
                                <td width="159" height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Mois</td>
                                <td align="right" valign="top"
                                    class="textBrute"><?php echo $lib->affiche_mois($res_fact->MOIS); ?>
                                </td>
                            <?php }?>
                        </tr>

                        <tr valign="baseline" bgcolor="#F3F3F3">
                            <?php if($res_fact_transport) {?>
                                <td align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">MONTANT:</td>
                                <td align="right" valign="middle" class="textBrute"><?php echo $lib->nombre_form($res_fact_transport->MONTANT); ?></td>
                            <?php }?>
                        </tr>

                        <tr valign="baseline" bgcolor="#F3F3F3">

                            <?php if($res_fact_transport) {?>
                                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Montant verse:</td>
                                <td colspan="3" class="textBrute" align="right"><?php echo $lib->nombre_form($res_fact_transport->MT_VERSE); $tot+=$res_fact_transport->MT_VERSE;?></td>
                            <?php }?>
                        </tr>

                        <tr valign="baseline" bgcolor="#F3F3F3">
                            <?php if($res_fact_transport) {?>
                                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">Reliquat:</td>
                                <td colspan="3" align="right" class="textBrute"><?php echo $lib->nombre_form($res_fact_transport->MT_RELIQUAT); ?></td>
                            <?php }?>
                        </tr>
                    </table>
                    <!--</fieldset>-->
                </td>

            <?php }?>

        </tr>

        <?php if ($query_rq_facture_nopayees->rowCount() > 0) { ?>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
                <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE DES FACTURES NON PAYEES</span>
                </td>
                <td class="textBrute">&nbsp;</td>
            </tr>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
                <td class="nomEntrepr">MOIS</td>
                <td class="textBrute"><span class="nomEntrepr">Montant</span></td>
                <td class="nomEntrepr">MONTANT VERSE</td>
                <td class="nomEntrepr">RELIQUAT</td>
            </tr>
            <?php foreach ($query_rq_facture_nopayees->fetchAll() as $row_rq_facture_nopayees) {
                //$tot += $row_rq_facture_nopayees['MT_RELIQUAT'];
                ?>
                <tr valign="middle">
                    <td height="20" align="left" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span
                                class="textBrute"><?php echo $lib->date_franc($row_rq_facture_nopayees['DATEREGLMT']); ?></span>
                    </td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->affiche_mois($row_rq_facture_nopayees['MOIS']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_nopayees['MONTANT']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_nopayees['MT_VERSE']); ?>
                    </td>
                    <td bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_nopayees['MT_RELIQUAT']); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        <?php if ($query_rq_facture_impayees->rowCount() > 0) { ?>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
                <td colspan="3" align="center" valign="middle" class="textBrute"><span class="nomEntrepr">HISTORIQUE DES FACTURES IMPAYEES</span>
                </td>
                <td class="textBrute">&nbsp;</td>
            </tr>
            <tr valign="baseline">
                <td height="16" align="left" valign="middle" nowrap="nowrap" class="nomEntrepr">DATE:</td>
                <td class="nomEntrepr">MOIS</td>
                <td class="textBrute"><span class="nomEntrepr">Montant</span></td>
                <td class="nomEntrepr">MONTANT VERSE</td>
                <td class="nomEntrepr">RELIQUAT</td>
            </tr>
            <?php foreach ($query_rq_facture_impayees->fetchAll() as $row_rq_facture_impayees) {
                //$tot += $row_rq_facture_impayees['MT_RELIQUAT'];
                ?>
                <tr valign="middle">
                    <td height="20" align="left" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr"><span
                                class="textBrute"><?php echo $lib->date_franc($row_rq_facture_impayees['DATEREGLMT']); ?></span>
                    </td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->affiche_mois($row_rq_facture_impayees['MOIS']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_impayees['MONTANT']); ?></td>
                    <td align="left" bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_impayees['MT_VERSE']); ?>
                    </td>
                    <td bgcolor="#F3F3F3"
                        class="textBrute"><?php echo $lib->nombre_form($row_rq_facture_impayees['MT_RELIQUAT']); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">TOTAL VERSEMENT :</td>
            <td align="right" class="textBrute">&nbsp;<?php echo $lib->nombre_form($tot); ?> F CFA</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute"></td>
        </tr>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td align="right" class="nomEntrepr">Le comptable</td>
        </tr>

        <tr valign="middle">
            <td height="20" align="right" nowrap="nowrap" class="nomEntrepr">&nbsp;</td>
            <td align="right" class="textBrute">&nbsp;</td>
            <td class="nomEntrepr">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
            <td class="textBrute">&nbsp;</td>
        </tr>
    </table>
</page>