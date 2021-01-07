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
//var_dump($_GET);die();
$colname_rq_mensualite = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_mensualite = $_SESSION['etab'];
}

$idIndividu = "-1";
if (isset($_GET['individu'])) {
    $idIndividu = $lib->securite_xss(base64_decode($_GET['individu'])) ;
}

$colname_rq_inscription = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
    $colname_rq_inscription = $lib->securite_xss(base64_decode($_GET['IDINSCRIPTION'])) ;
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}
?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TIERS</a></li>
    <li>Impression</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <?php if (isset($_GET['msg']) && base64_decode($_GET['msg']) != '') {

                                if (isset($_GET['res']) && base64_decode($_GET['res']) == 1) {
                                    ?>
                                    <div class="alert alert-success">
                                        <p class="lead"><?php echo base64_decode($_GET['msg']); ?></p>
                                    </div>
                                    <hr class="my-4">
                                    <p class="lead">
                                        <a class="btn btn-primary btn-lg" href="../../ged/imprimer_paiement_bis.php?facture=<?php echo $_GET['facture']; ?>&individu=<?php echo $_GET['individu']; ?>&IDINSCRIPTION=<?php echo $_GET['IDINSCRIPTION']; ?>" role="button">IMPRIMER LE REÇU</a>
                                    </p>
                                <?php }
                                if (isset($_GET['res']) && base64_decode($_GET['res']) != 1) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <p class="lead"><?php echo base64_decode($_GET['msg']); ?></p>
                                    </div>
                                    <hr class="my-4">
                                    <p class="lead">
                                        <a class="btn btn-primary btn-lg" href="facturation.php" role="button">RETOUR</a>
                                    </p>
                                <?php }
                                ?>

                            <?php } ?>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                </div>
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
