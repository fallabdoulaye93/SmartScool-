<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();


if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil'])));


require_once("classe/ProfileManager.php");
require_once("classe/Profile.php");
$niv = new ProfileManager($dbh, 'profil');


$colname_rq_niveau_etab = "-1";
if (isset($_GET['idProfil'])) {
    $colname_rq_niveau_etab = base64_decode($lib->securite_xss($_GET['idProfil']));
}

$query_rq_niveau_etab = $dbh->query("SELECT `idProfil`, `profil`, `idEtablissement` FROM profil WHERE idProfil = $colname_rq_niveau_etab");
foreach ($query_rq_niveau_etab->fetchAll() as $row_rq_niveau_etab) {
    $id = $row_rq_niveau_etab['idProfil'];
    $profile = $row_rq_niveau_etab['profil'];
}


if (isset($_POST) && $_POST != null) {


    $res = $niv->modifier($lib->securite_xss_array($_POST), 'idProfil', $lib->securite_xss($_POST['idProfil']));
    if ($res == 1)
    {
        $msg = "Modification effectuée avec succés";

    }
    else
    {
        $msg = "Modification effectuée avec echec";
    }
    header("Location: profile.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Profil</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-body">

                <form action="modifProfil.php" method="POST">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="col-lg-3"><label>PROFIL</label></div>
                                <div class="col-lg-9">
                                    <input type="text" name="profil" id="profil" required class="form-control"
                                           value="<?php echo $profile; ?>"/>
                                </div>
                            </div>
                        </div>
                        <br><br>


                        <div class="col-lg-12">
                            <div class="col-lg-offset-6"><input type="submit" class="btn btn-success" value="modifier"/></div>
                        </div>

                    </div>

                    <input type="hidden" name="idProfil" value="<?php echo $id; ?>"/>
                    <!--<input type="hidden" name="IDETABLISSEMENT" value="<?php //echo $_SESSION['etab']; ?>" />-->


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