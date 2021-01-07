<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(33, $lib->securite_xss($_SESSION['profil'])));

if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname2_rq_historique_paiement = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$colname_rq_historique_paiement = "-1";
if (isset($_GET['IDINDIVIDU'])) {
    $colname_rq_historique_paiement = $lib->securite_xss(base64_decode($_GET['IDINDIVIDU']));
}

try
{
    $query_rq_historique_paiement = $dbh->query("SELECT * FROM REGLEMENT_PERSO 
                                                        INNER JOIN TYPE_PAIEMENT ON TYPE_PAIEMENT.id_type_paiment=REGLEMENT_PERSO.IDTYPEPAIEMENT 
                                                        WHERE INDIVIDU = " . $colname_rq_historique_paiement . " 
                                                        AND REGLEMENT_PERSO.IDANNEESCOLAIRE =" . $colname2_rq_historique_paiement . " 
                                                        ORDER BY IDREGLEMENT DESC");

    $query_rq_individu = $dbh->query("SELECT * FROM UTILISATEURS WHERE idUtilisateur = " . $colname_rq_historique_paiement);
    $row_rq_individu = $query_rq_individu->fetchObject();

    $query_rq_tot_encaisse = $dbh->query("SELECT SUM(REGLEMENT_PERSO.MONTANT) as tot_encasisse 
                                                FROM REGLEMENT_PERSO 
                                                WHERE INDIVIDU =  " . $colname_rq_historique_paiement . " 
                                                AND REGLEMENT_PERSO.IDANNEESCOLAIRE =" . $colname2_rq_historique_paiement);
    $row_rq_tot_encaisse = $query_rq_tot_encaisse->fetchObject();

    $query_rq_paiement = $dbh->query("SELECT * FROM TYPE_PAIEMENT where id_type_paiment not in (4)");
    $rs_paiement = $query_rq_paiement->fetchAll();

    $query_type_banque = $dbh->query("SELECT ROWID,LABEL FROM BANQUE WHERE ETAT=1");
    $rs_banque = $query_type_banque->fetchAll();
}
catch (PDOException $e)
{
   echo -2;
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $mois = $lib->securite_xss($_POST['MOIS']);
    try {
        $insertSQL = sprintf("INSERT INTO REGLEMENT_PERSO  (IDREGLEMENT, DATE_REGLEMENT, MOIS, MONTANT, INDIVIDU, MOTIF, IDTYPEPAIEMENT, recu, IDANNEESCOLAIRE,NUM_CHEQUE,FK_BANQUE) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            $lib->GetSQLValueString($lib->securite_xss($_POST['IDREGLEMENT']), "int"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['DATE_REGLEMENT']), "date"),
            $lib->GetSQLValueString($mois, "text"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['MONTANT']), "int"),
            $lib->GetSQLValueString($lib->securite_xss(base64_decode($_POST['IDINDIVIDU'])), "int"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['MOTIF']), "text"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['paiement']), "text"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['recu']), "text"),
            $lib->GetSQLValueString($lib->securite_xss($_SESSION['ANNEESSCOLAIRE']), "int"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['numero']), "int"),
            $lib->GetSQLValueString($lib->securite_xss($_POST['id_type_banque']), "int")
        );

        $Result1 = $dbh->query($insertSQL);

        $insertGoTo = "fichePaiementPerso.php?IDINDIVIDU=" . $lib->securite_xss($_POST['IDINDIVIDU']);
    }
    catch (Exception $e) {
        echo -3;
    }
    header(sprintf("Location: %s", $insertGoTo));
}


?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TRESORERIE</a></li>
    <li>Paiement Personnel</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

                <div class="btn-group pull-right">
                    <button data-toggle="modal" data-target="#ajouter"
                            style="background-color:#DD682B" class='btn dropdown-toggle' aria-hidden='true'>
                        <i class="fa fa-plus"></i> Nouveau paiement
                    </button>


                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $lib->securite_xss($_GET['msg']) != '') {

                    if (isset($_GET['res']) && $lib->securite_xss($_GET['res']) == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    if (isset($_GET['res']) && $lib->securite_xss($_GET['res']) != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <form id="form1" name="form1" method="post" action="">
                    <fieldset class="cadre">
                        <legend> Informations personnelles</legend>

                        <div class="row">
                            <div class="col-lg-3">

                                <div class="col-lg-3"><label>MATRICULE: </label></div>
                                <div class="col-lg-9"><?php echo $row_rq_individu->matriculeUtilisateur; ?></div>

                            </div>

                            <div class="col-lg-3">

                                <div class="col-lg-3"><label>PRENOMS: </label></div>
                                <div class="col-lg-9"><?php echo $row_rq_individu->prenomUtilisateur; ?></div>

                            </div>

                            <div class="col-lg-3">

                                <div class="col-lg-3"><label>NOM: </label></div>
                                <div class="col-lg-9"><?php echo $row_rq_individu->nomUtilisateur; ?></div>

                            </div>

                            <div class="col-lg-3">

                                <div class="col-lg-3"><label>TELMOBILE: </label></div>
                                <div class="col-lg-9"><?php echo $row_rq_individu->telephone; ?></div>

                            </div>

                        </div>

                        <br>


                    </fieldset>
                </form>
                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mois</th>
                        <th>Montant</th>
                        <th>Motif</th>
                        <th>Type Paiement</th>
                        <th>Numero</th>


                    </tr>
                    </thead>


                    <tbody>
                    <?php $total_encaisee = 0;
                    foreach ($query_rq_historique_paiement->fetchAll() as $row_rq_historique_paiement) {

                        ?>
                        <tr>

                            <td><?php echo $lib->date_fr($row_rq_historique_paiement['DATE_REGLEMENT']); ?></td>
                            <td><?php echo $row_rq_historique_paiement['MOIS']; ?></td>
                            <td><?php echo $lib->nombre_form($row_rq_historique_paiement['MONTANT']); ?></td>
                            <td><?php echo $row_rq_historique_paiement['MOTIF']; ?></td>
                            <td><?php echo $row_rq_historique_paiement['libelle_paiement']; ?></td>
                            <td><?php echo $row_rq_historique_paiement['NUM_CHEQUE']; ?></td>


                        </tr>
                        <?php
                        $total_encaisee += $row_rq_historique_paiement['MONTANT'];

                    } ?>


                    </tbody>
                </table>
                <br>

                <table class="table table-striped table-responsive" style="width:29%">
                    <tr>
                        <td>TOTAL ENCAISSE:</td>
                        <td><?php echo $lib->nombre_form($total_encaisee); ?></td>
                    </tr>

                </table>


            </div>
        </div>
    </div>
    <!-- END WIDGETS -->


</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter"
     data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouveau paiement </h3>
                </div>
                <form action="fichePaiementPerso.php" method="POST" id="form1" name="form1">

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">DATE</label>

                                    <div>
                                        <input type="text" name="DATE_REGLEMENT" id="date_foo" required
                                               class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MOIS</label>

                                    <div>
                                        <select name="MOIS" class="form-control" required>
                                            <option value="">-- Sélectionner mois --</option>
                                            <option
                                                value="<?php echo "JANVIER / " . date('Y'); ?>"><?php echo "JANVIER / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "FEVRIER / " . date('Y'); ?>"><?php echo "FEVRIER / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "MARS / " . date('Y'); ?>"><?php echo "MARS / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "AVRIL / " . date('Y'); ?>"><?php echo "AVRIL / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "MAI / " . date('Y'); ?>"><?php echo "MAI / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "JUIN / " . date('Y'); ?>"><?php echo "JUIN / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "JUILLET / " . date('Y'); ?>"><?php echo "JUILLET / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "AOUT / " . date('Y'); ?>"><?php echo "AOUT / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "SEPTEMBRE / " . date('Y'); ?>"><?php echo "SEPTEMBRE / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "OCTOBRE / " . date('Y'); ?>"><?php echo "OCTOBRE / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "NOVEMBRE / " . date('Y'); ?>"><?php echo "NOVEMBRE / " . date('Y'); ?></option>
                                            <option
                                                value="<?php echo "DECEMBRE / " . date('Y'); ?>"><?php echo "DECEMBRE / " . date('Y'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">ANNEE</label>
                                    <div>
                                        <input type="text" name="anne" id="anne" readonly class="form-control" value="<?php //echo date('Y');?>" />
                                    </div>
                                </div>
                            </div>-->

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MONTANT</label>

                                    <div>
                                        <input type="number" name="MONTANT" id="MONTANT" required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MOTIF</label>

                                    <div>
                                        <input type="text" name="MOTIF" id="MOTIF" required class="form-control"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12" style="margin-top: 3px;">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="">TYPE PAIEMENT</label>
                                        <select name="paiement" required id="paiement" style="width: 100%;" class="form-control">
                                            <option value="" selected="selected" disabled="disabled">--Selectionnez--
                                            </option>
                                            <?php foreach ($rs_paiement as $row_rq_paiement) { ?>
                                                <option
                                                        value="<?php echo $row_rq_paiement['id_type_paiment']; ?>"><?php echo $row_rq_paiement['libelle_paiement']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="lotTypePayement" style="display: none">
                                    <div class="col-lg-4">
                                        <label class="control-label" id="titre_id_type_banque"></label>
                                        <input type="text" class="form-control" name="numero" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="id_type_banque" class="control-label">BANQUE</label>
                                        <select name="id_type_banque" id="id_type_banque" required class="form-control">
                                            <option value="" disabled="disabled" selected="selected">choisir la banque</option>
                                            <?php foreach ($rs_banque as $row_type_banque) { ?>
                                                <option value="<?php echo $row_type_banque['ROWID']; ?>"><?php echo $row_type_banque['LABEL']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDREGLEMENT" value=""/>
                        <input type="hidden" name="IDINDIVIDU" value="<?php echo $lib->securite_xss($_GET['IDINDIVIDU']); ?>"/>
                        <input type="hidden" name="MM_insert" value="form1"/>
                        <input type="submit" class="btn btn-primary pull-right" value="Valider"/>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<?php include('footer.php'); ?>
<script>
    $("#paiement").on('change', function () {
        var selectedPay = $("#paiement").find("option:selected").val()
        if(selectedPay != 2){
            if(selectedPay == 1){
                $('#titre_id_type_banque').text("NUMERO CHEQUE")
            }else{
                $('#titre_id_type_banque').text("NUMERO VIREMENT")
            }
            $('#lotTypePayement').css('display', 'block')
        }else {
            $('#lotTypePayement').css('display', 'none')
            $('#id_type_banque').prop('selectedIndex',0);
            //$('#id_type_banque').children('option:not(:first)').remove()
        }
    })
</script>
