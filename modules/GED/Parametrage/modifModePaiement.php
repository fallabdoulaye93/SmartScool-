<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib_ = new Librairie();


if ($_SESSION['profil'] != 1)
    $lib_->Restreindre($lib_->Est_autoriser(49, $lib_->securite_xss($_SESSION['profil'])));


require_once("classe/ModePaiementManager.php");
require_once("classe/ModePaiement.php");
$niv = new ModePaiementManager($dbh, 'MODE_PAIEMENT');


$colname_rq_niveau_etab = "-1";
if (isset($_GET['ROWID'])) {
    $colname_rq_niveau_etab = $lib_->securite_xss(base64_decode($_GET['ROWID']));
}

$query_rq_niveau_etab = $dbh->query("SELECT `ROWID`, `LIBELLE`, `NBRE_MOIS`, `ETAT`, `IDETABLISSEMENT` FROM `MODE_PAIEMENT` WHERE ROWID = $colname_rq_niveau_etab");
foreach ($query_rq_niveau_etab->fetchAll() as $row_rq_niveau_etab) {
    $libelle = $row_rq_niveau_etab['LIBELLE'];
    $id = $row_rq_niveau_etab['ROWID'];
    $nbre_mois = $row_rq_niveau_etab['NBRE_MOIS'];
}


if (isset($_POST) && $_POST != null) {

    $_POST['IDETABLISSEMENT'] = $lib_->securite_xss(base64_decode($_POST['IDETABLISSEMENT']));
    $idniveau = $lib_->securite_xss(base64_decode($_POST['ROWID']));
    unset($_POST['ROWID']);
    $res = $niv->modifier($lib_->securite_xss_array($_POST), 'ROWID', $idniveau);
    if ($res == 1) {
        $msg = "Modification effectuée avec succés";

    } else {
        $msg = "Votre mofication a échouée";
    }
    header("Location: modePaiement.php?msg=" . $lib_->securite_xss($msg) . "&res=" . $lib_->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Mode Paiement</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

        <form action="modifModePaiement.php" method="POST">

            <div class="row">

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>LIBELLE</label>

                        <div>
                            <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control"
                                   value="<?php echo $libelle; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>NOMBRE DE MOIS</label>

                        <div>
                            <input type="number" name="NBRE_MOIS" id="NBRE_MOIS" min="0" required class="form-control"
                                   value="<?php echo $nbre_mois; ?>"/>
                        </div>
                    </div>
                </div>
                <br><br>


                <div class="col-lg-12">
                    <br/>
                    <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>
                </div>

            </div>

            <input type="hidden" name="ROWID" value="<?php echo base64_encode($id); ?>"/>
            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo base64_encode($_SESSION['etab']); ?>"/>


        </form>

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