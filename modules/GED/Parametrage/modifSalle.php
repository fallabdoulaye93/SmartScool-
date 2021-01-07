<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(8, $_SESSION['profil']));


require_once('classe/TypeSalleManager.php');
$types = new TypeSalleManager($dbh, 'TYPE_SALLE');
$type = $types->getTypeSalles();

require_once("classe/SalleManager.php");
require_once("classe/Salle.php");
$niv = new SalleManager($dbh, 'SALL_DE_CLASSE');


$colname_rq_salle_etab = "-1";
if (isset($_GET['idSalle'])) {
    $colname_rq_salle_etab = $lib->securite_xss(base64_decode($_GET['idSalle']));
}

$query_rq_salle_etab = $dbh->query("SELECT IDSALL_DE_CLASSE, NOM_SALLE, IDTYPE_SALLE, IDETABLISSEMENT, NBR_PLACES FROM SALL_DE_CLASSE WHERE IDSALL_DE_CLASSE = $colname_rq_salle_etab");
foreach ($query_rq_salle_etab->fetchAll() as $row_rq_salle_etab) {

    $id = $row_rq_salle_etab['IDSALL_DE_CLASSE'];
    $nomSalle = $row_rq_salle_etab['NOM_SALLE'];
    $typeSalle = $row_rq_salle_etab['IDTYPE_SALLE'];
    $nbre = $row_rq_salle_etab['NBR_PLACES'];
}


if (isset($_POST) && $_POST != null) {

    $res = $niv->modifier($lib->securite_xss_array($_POST), 'IDSALL_DE_CLASSE', $lib->securite_xss($_POST['IDSALL_DE_CLASSE']));
    if ($res == 1) {
        $msg = "Modification effectuée avec succès!";

    } else {
        $msg = "Votre modification a échoué";
    }
    header("Location: salle.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Annees scolaires</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="modifSalle.php" method="POST">

                    <div class="row">

                <div class="col-xs-12">
                    <div class="form-group">
                        <label>NOM SALLE</label>

                        <div>
                            <input type="text" name="NOM_SALLE" id="NOM_SALLE" required class="form-control"
                                   value="<?php echo $nomSalle; ?>"/>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="form-group">
                        <label>Type salle</label>

                        <div>
                            <select name="IDTYPE_SALLE" class="form-control selectpicker" data-live-search="true">
                                <?php
                                foreach ($type as $typ) {

                                    ?>
                                    <option
                                        value=" <?php echo $typ->getIDTYPE_SALLE(); ?>" <?php if ($typeSalle == $typ->getIDTYPE_SALLE()) echo "selected" ?> ><?php echo $typ->getTYPE_SALLE(); ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="form-group">
                        <label>NOMBRE DE PLACES</label>

                        <div>
                            <input type="number" name="NBR_PLACES" id="NBR_PLACES" required class="form-control"
                                   value="<?php echo $nbre; ?>"/>
                        </div>
                    </div>
                </div>

                <br><br>


                <div class="col-lg-12">
                <br/>
                    <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>

                </div>

            </div>

                    <input type="hidden" name="IDSALL_DE_CLASSE" value="<?php echo $id; ?>"/>
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