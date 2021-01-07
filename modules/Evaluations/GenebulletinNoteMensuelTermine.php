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
    $lib->Restreindre($lib->Est_autoriser(25, $lib->securite_xss($_SESSION['profil'])));

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $lib->securite_xss($_SESSION['etab']);
}
?>
<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Evaluations</a></li>
    <li>Generation Bulletin de Note Meensuel</li>
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

                                if (isset($_GET['res']) && base64_decode($_GET['res']) == 1) { ?>

                                    <div class="alert alert-success">
                                        <p class="lead"><?php echo base64_decode($lib->securite_xss($_GET['msg'])); ?></p>
                                    </div>
                                    <hr class="my-4">
                                    <p class="lead">
                                        <a class="btn btn-primary btn-lg" href="../../ged/imprimer_bulletin_mensuel.php?idperiode=<?php echo $lib->securite_xss($_GET['idperiode']); ?>&idclassroom=<?php echo $lib->securite_xss($_GET['idclassroom']); ?>&idannee=<?php echo $lib->securite_xss($_GET['idannee']); ?>&ideatb=<?php echo $lib->securite_xss($_GET['ideatb']); ?>&idniveau=<?php echo $lib->securite_xss($_GET['idniveau'])?>" role="button">IMPRIMER</a>
                                    </p>

                                <?php } if (isset($_GET['res']) && base64_decode($_GET['res']) != 1) { ?>

                                    <div class="alert alert-danger">
                                        <p class="lead"><?php echo base64_decode($lib->securite_xss($_GET['msg'])); ?></p>
                                    </div>
                                    <hr class="my-4">
                                    <p class="lead">
                                        <a class="btn btn-primary btn-lg" href="facturation.php" role="button">RETOUR</a>
                                    </p>

                                <?php } ?>

                            <?php } ?>

                        </div>
                        <div class="col-sm-4"></div>
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


