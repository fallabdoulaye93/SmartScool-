<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(19, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/TypeControleManager.php");
require_once("classe/TypeControle.php");
$type = new TypeControleManager($dbh, 'TYP_CONTROL');


$colname_rq_annee_etab = "-1";
if (isset($_GET['IDTYP_CONTROL'])) {
    $colname_rq_annee_etab = $lib->securite_xss(base64_decode($_GET['IDTYP_CONTROL']));
}

$query_rq_annee_etab = $dbh->query("SELECT IDTYP_CONTROL, LIB_TYPCONTROL, POIDS FROM TYP_CONTROL WHERE IDTYP_CONTROL = $colname_rq_annee_etab");
foreach ($query_rq_annee_etab->fetchAll() as $row_rq_annee_etab)
{
    $id = $row_rq_annee_etab['IDTYP_CONTROL'];
    $libelle = $row_rq_annee_etab['LIB_TYPCONTROL'];
    $POIDS = $row_rq_annee_etab['POIDS'];
}


if (isset($_POST) && $_POST != null) {
    $type_controle =$lib->securite_xss(base64_decode($_POST['IDTYP_CONTROL']));
    unset($_POST['IDETABLISSEMENT']);
    unset($_POST['IDTYP_CONTROL']);
    $res = $type->modifier($lib->securite_xss_array($_POST), 'IDTYP_CONTROL', $type_controle);
    if ($res == 1) {
        $msg = "Modification effectuee avec succes";

    } else {
        $msg = "Votre modification a echouee";
    }
    header("Location: accueil.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Evaluation</a></li>
    <li>Type de controle</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="" method="POST">

                    <div class="row">
                        <!--  	IDTYP_CONTROL LIB_TYPCONTROL POIDS IDETABLISSEMENT COULEUR -->
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>LIBELLE</label>

                                <div>
                                    <input type="text" name="LIB_TYPCONTROL" id="LIB_TYPCONTROL" required class="form-control"
                                           value="<?php echo $libelle; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>COEFFICIENT</label>

                                <div>
                                    <input type="number" id="POIDS" name="POIDS" required class="form-control"
                                           value="<?php echo $POIDS; ?>"/>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-lg-12">
                            <br>
                            <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="modifier"/></div>
                        </div>
                    </div>

                    <input type="hidden" name="IDTYP_CONTROL" value="<?php echo base64_encode($id); ?>"/>

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