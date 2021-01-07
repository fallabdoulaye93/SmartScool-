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
    $lib->Restreindre($lib->Est_autoriser(26, $_SESSION['profil']));


$colname_rq_mensualite = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_mensualite = $_SESSION['etab'];
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_mensualite = $dbh->query("SELECT MENSUALITE.MONTANT, MENSUALITE.MOIS, MENSUALITE.IDINSCRIPTION as IDINS, INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE,INSCRIPTION.*, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, MENSUALITE.IDMENSUALITE 
                                              FROM MENSUALITE, INSCRIPTION, INDIVIDU 
                                              WHERE MENSUALITE.IDINSCRIPTION=INSCRIPTION.IDINSCRIPTION 
                                              AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                              AND INSCRIPTION.IDETABLISSEMENT=" . $colname_rq_mensualite . " 
                                              AND INSCRIPTION.IDANNEESSCOLAIRE=" . $colname_rq_anne . " 
                                              GROUP BY INDIVIDU.IDINDIVIDU 
                                              ORDER BY INDIVIDU.IDINDIVIDU DESC");
$rs_mensualite = $query_rq_mensualite->fetchAll();


?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TRESORERIE</a></li>
    <li>Mensualit&eacute;s</li>
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


                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {?>

                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>

                        <th>MATRICULE</th>
                        <th>PRENOMS</th>
                        <th>NOM</th>
                        <th>Montant total vers&eacute;</th>
                        <th>Total de la formation</th>
                        <th>Reliquat total</th>
                        <th>IMPRIMER</th>
                        <!--<th>R&eacute;glement</th>-->

                    </tr>
                    </thead>


                    <tbody>
                    <?php
                    foreach ($rs_mensualite as $row_rq_mensualite) {

                        $query_rq_historique_mensulaite = $dbh->query("SELECT SUM(MENSUALITE.MT_VERSE) as somme FROM MENSUALITE WHERE IDINSCRIPTION =  " . $row_rq_mensualite['IDINS']);

                        $row_rq_historique_mensulaite = $query_rq_historique_mensulaite->fetchObject();


                        // cout total de la formation
                        $colname_rq_cout_formation = $row_rq_mensualite['IDSERIE'];

                        $query_rq_cout_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE IDSERIE = " . $colname_rq_cout_formation . " AND NIVEAU_SERIE.IDNIVEAU=" . $row_rq_mensualite['IDNIVEAU']);

                        $row_rq_cout_formation = $query_rq_cout_formation->fetchObject();

                        $somme_frais = $row_rq_mensualite['FRAIS_DOSSIER'] + $row_rq_mensualite['FRAIS_EXAMEN'] + $row_rq_mensualite['UNIFORME'] + $row_rq_mensualite['VACCINATION'] + $row_rq_mensualite['ASSURANCE'] + $row_rq_mensualite['FRAIS_SOUTENANCE'] + $row_rq_mensualite['FRAIS_INSCRIPTION'];
                        $total_formation = ($row_rq_cout_formation->dure * $row_rq_mensualite['ACCORD_MENSUELITE']) + $somme_frais;
                        //
                        $total_verse = $row_rq_mensualite['ACCOMPTE_VERSE'] + $row_rq_mensualite['MONTANT_DOSSIER'] + $row_rq_mensualite['MONTANT_EXAMEN'] + $row_rq_mensualite['MONTANT_UNIFORME'] + $row_rq_mensualite['MONTANT_VACCINATION'] + $row_rq_mensualite['MONTANT_ASSURANCE'] + $row_rq_mensualite['MONTANT_SOUTENANCE'];
                        //

                        $restant_formation = $total_formation - ($row_rq_historique_mensulaite->somme + $total_verse);
                        ?>
                        <tr>

                            <td><?php echo $row_rq_mensualite['MATRICULE']; ?></td>
                            <td><?php echo $row_rq_mensualite['PRENOMS']; ?></td>
                            <td><?php echo $row_rq_mensualite['NOM']; ?></td>
                            <td><?php echo $lib->nombre_form($row_rq_historique_mensulaite->somme + $total_verse); ?></td>
                            <td><?php echo $lib->nombre_form($total_formation); ?></td>
                            <td><?php echo $lib->nombre_form($restant_formation); ?></td>


                            <td>
                                <a href="../../ged/imprimer_histo.php?IDINDIVIDU=<?php echo $row_rq_mensualite['IDINDIVIDU']; ?>&amp;IDINSCRIPTION=<?php echo $row_rq_mensualite['IDINSCRIPTION']; ?>"><i
                                        class=" glyphicon glyphicon-print"></i></a></td>

                            <!--<td ><a href="ficheMensualite.php?IDINSCRIPTION=<?php echo $row_rq_mensualite['IDINSCRIPTION']; ?>&amp;IDINDIVIDU=<?php echo $row_rq_mensualite['IDINDIVIDU']; ?>" ><i class="glyphicon glyphicon-list"></i></a></td>-->

                        </tr>
                    <?php } ?>

                    </tbody>
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

<?php include('footer.php'); ?>