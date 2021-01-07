<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();


if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(4, $lib->securite_xss($_SESSION['profil'])));


require_once("classe/FiliereManager.php");
require_once("classe/Filiere.php");
$niv = new FiliereManager($dbh, 'SERIE');


$colname_rq_serie_etab = "-1";
if (isset($_GET['idSerie'])) {
    $colname_rq_serie_etab = $lib->securite_xss(base64_decode($_GET['idSerie']));
}
// <!-- IDSERIE LIBSERIE IDETABLISSEMENT -->

$query_rq_serie_etab = $dbh->query("SELECT s.IDSERIE, s.LIBSERIE, s.IDNIVEAU, s.IDETABLISSEMENT 
                                              FROM SERIE s INNER JOIN NIVEAU n 
                                              ON s.IDNIVEAU = n.IDNIVEAU 
                                              WHERE s.IDSERIE = $colname_rq_serie_etab");

foreach ($query_rq_serie_etab->fetchAll() as $row_rq_serie_etab)
{
    $id = $row_rq_serie_etab['IDSERIE'];
    $LIBSERIE = $row_rq_serie_etab['LIBSERIE'];
    $IDNIVEAU = $row_rq_serie_etab['IDNIVEAU'];
}
$query_rq_cycle = $dbh->query("SELECT IDNIVEAU, LIBELLE FROM NIVEAU");

if (isset($_POST) && $_POST != null)
{
    $_POST['IDETABLISSEMENT'] = $lib->securite_xss(base64_decode($_POST['IDETABLISSEMENT']));
    $idserie = $lib->securite_xss(base64_decode($_POST['IDSERIE']));
    unset($_POST['IDSERIE']);
    $res = $niv->modifier($lib->securite_xss_array($_POST), 'IDSERIE', $idserie);
    if ($res == 1) {
        $msg = "Modification effectuée avec succès";

    } else {
        $msg = "Echec de la modification";
    }
    header("Location: filieres.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
    <!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Filieres</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">


        <div class="panel panel-default">
            <div class="panel-body">
                <form action="modifFiliere.php" method="POST">

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>CYCLE</label>
                                <select class="form-control" id="selectCycle" name="IDNIVEAU" required>
                                    <option value="">Selectionner un cycle</option>
                                    <?php
                                    foreach ($query_rq_cycle->fetchAll() as $rq_cycle) {?>
                                        <option value="<?php echo $rq_cycle['IDNIVEAU'] ?>"<?php if($rq_cycle['IDNIVEAU']==$IDNIVEAU) echo "selected";?>><?php echo $rq_cycle['LIBELLE'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>SERIE</label>
                                <div>
                                    <input type="text" name="LIBSERIE" id="LIBSERIE" required class="form-control" value="<?php echo $LIBSERIE; ?>"/>
                                </div>
                            </div>
                        </div>

                        <br><br>


                        <div class="col-lg-12">
                            <br/>
                            <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>
                        </div>

                    </div>

                    <input type="hidden" name="IDSERIE" value="<?php echo base64_encode($id); ?>"/>
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