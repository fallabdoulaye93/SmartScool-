<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();


if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(9, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/JourFeriesManager.php");
require_once("classe/JourFeries.php");
$niv = new JourFeriesManager($dbh, 'VACANCES');


$colname_rq_jf_etab = "-1";
if (isset($_GET['idJF'])) {
    $colname_rq_jf_etab = base64_decode($lib->securite_xss($_GET['idJF']));
}

$query_rq_jf_etab = $dbh->query("SELECT IDJOUR_FERIES, LIB_VACANCES, DATE_DEBUT, DATE_FIN, IDETABLISSEMENT FROM VACANCES WHERE IDJOUR_FERIES = $colname_rq_jf_etab");
foreach ($query_rq_jf_etab->fetchAll() as $row_rq_jf_etab) {

    $id = $row_rq_jf_etab['IDJOUR_FERIES'];
    $libelle = $row_rq_jf_etab['LIB_VACANCES'];
    $debut = $row_rq_jf_etab['DATE_DEBUT'];
    $fin = $row_rq_jf_etab['DATE_FIN'];
}


if (isset($_POST) && $_POST != null)
{
    $res = $niv->modifier($lib->securite_xss_array($_POST), 'IDJOUR_FERIES', $lib->securite_xss($_POST['IDJOUR_FERIES']));
    if ($res == 1)
    {
        $msg = "Modification effectuée avec succès!";
    }
    else {
        $msg = "Votre modification a échoué";
    }
    header("Location: joursFeries.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Ann&eacute;es scolaires</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="modifJF.php" method="POST">

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">

                                <label>Libell&eacute;  jour f&eacute;ri&eacute;</label>

                                <div>
                                    <input type="text" name="LIB_VACANCES" id="LIB_VACANCES" required class="form-control" value="<?php echo $libelle; ?>"/>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Date d&eacute;but</label>
                                <div>
                                    <input type="text" id="date_foo" name="DATE_DEBUT" required class="form-control" value="<?php echo $debut; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Date fin</label>
                                <div>
                                    <input type="text" id="date_foo2" name="DATE_FIN" required class="form-control" value="<?php echo $fin; ?>"/>
                                </div>
                            </div>
                        </div>
                        <br><br>


                        <div class="col-lg-12">
                            <br/>
                            <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>

                        </div>

                    </div>

                    <input type="hidden" name="IDJOUR_FERIES" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>

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