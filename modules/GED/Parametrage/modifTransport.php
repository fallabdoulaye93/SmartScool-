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


require_once("classe/TransportManager.php");
require_once("classe/Transport.php");
$niv = new TransportManager($dbh, 'SECTION_TRANSPORT');


$colname_rq_niveau_etab = "-1";
if (isset($_GET['ID_SECTION'])) {
    $colname_rq_niveau_etab = $lib_->securite_xss(base64_decode($_GET['ID_SECTION']));
}

$query_rq_niveau_etab = $dbh->query("SELECT ID_SECTION, LIBELLE, MONTANT FROM SECTION_TRANSPORT WHERE ID_SECTION = $colname_rq_niveau_etab");
foreach ($query_rq_niveau_etab->fetchAll() as $row_rq_niveau_etab) {
    $libelle = $row_rq_niveau_etab['LIBELLE'];
    $montant = $row_rq_niveau_etab['MONTANT'];
    $id = $row_rq_niveau_etab['ID_SECTION'];
}


if (isset($_POST) && $_POST != null) {
    //var_dump($_POST);
    $idSection=$lib_->securite_xss(intval(base64_decode($_POST['ID_SECTION'])));
    $_POST['MONTANT'] = intval($lib_->securite_xss($_POST['MONTANT']));
    unset($_POST['ID_SECTION']);
    $res = $niv->modifier($lib_->securite_xss_array($_POST), 'ID_SECTION', $idSection);
    if ($res == 1) {
        $msg = "Modification effectuée avec succés";

    } else {
        $msg = "Votre mofication a échouée";
    }
    header("Location: sectionTransport.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Transports</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="modifTransport.php" method="POST">

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
                                <label>MONTANT</label>

                                <div>
                                    <input type="number" name="MONTANT" id="montant" required class="form-control"
                                           value="<?php echo $montant; ?>"/>
                                </div>
                            </div>
                        </div>
                        <br><br>


                        <div class="col-lg-12">
                            <br/>
                            <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>
                        </div>

                    </div>

                    <input type="hidden" name="ID_SECTION" value="<?php echo base64_encode($id); ?>"/>
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