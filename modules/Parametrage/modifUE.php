<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(6, $_SESSION['profil']));


require_once("classe/UEManager.php");
require_once("classe/UE.php");
$niv = new UEManager($dbh, 'UE');

require_once('classe/FiliereManager.php');
$series = new FiliereManager($dbh, 'SERIE');
$serie = $series->getFiliere('IDETABLISSEMENT', $lib->securite_xss($_SESSION['etab']));

require_once('classe/NiveauManager.php');
$niveaux = new NiveauManager($dbh, 'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT', $lib->securite_xss($_SESSION['etab']));

$colname_rq_ue_etab = "-1";
if (isset($_GET['idUE']))
{
    $param = json_decode(base64_decode($lib->securite_xss($_GET['idUE'])));
    $colname_rq_ue_etab = $param->id;
}

try
{
    $periode = $dbh->query("SELECT IDPERIODE, NOM_PERIODE, DEBUT_PERIODE, FIN_FPERIODE, IDANNEESSCOLAIRE, IDETABLISSEMENT FROM PERIODE");
    $rs_periode = $periode->fetchAll();

    $query_rq_ue_etab = $dbh->query("SELECT IDUE, LIBELLE, IDNIVEAU, IDSERIE, SEMESTRES, IDETABLISSEMENT FROM UE WHERE IDUE = $colname_rq_ue_etab");
    $rs_ue_eta = $query_rq_ue_etab->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}


foreach ($rs_ue_eta as $row_rq_ue_etab)
{
    $id = $row_rq_ue_etab['IDUE'];
    $libelle = $row_rq_ue_etab['LIBELLE'];
    $idNiveau = $row_rq_ue_etab['IDNIVEAU'];
    $idSerie = $row_rq_ue_etab['IDSERIE'];
    $semestre = $row_rq_ue_etab['SEMESTRES'];
}

if (isset($_POST) && $_POST != null)
{
    $res = $niv->modifier($lib->securite_xss_array($_POST), 'IDUE', $lib->securite_xss($_POST['IDUE']));
    if ($res == 1) {
        $msg = "Modification effectuée avec succés";

    } else {
        $msg = "Modification effectuée avec echec";
    }
    header("Location: uniteEnseignement.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}
?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Unit&eacute; d'enseignement</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">


        <div class="panel panel-default">
            <div class="panel-body">

                <form action="modifUE.php" method="POST">

            <div class="row">

                <div class="col-xs-12">
                    <div class="form-group">
                        <label>LIBELLE</label>

                        <div>
                            <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control"
                                   value="<?php echo $libelle; ?>"/>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="form-group">
                        <label>NIVEAU</label>

                        <div>
                            <select name="IDNIVEAU" class="form-control selectpicker" data-live-search="true">
                                <?php
                                foreach ($niveau as $nive) {

                                    ?>
                                    <option
                                        value=" <?php echo $nive->getIDNIVEAU(); ?>" <?php if ($idNiveau == $nive->getIDNIVEAU()) echo "selected" ?>><?php echo $nive->getLIBELLE(); ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="form-group">
                        <label>FILIERE / SERIE</label>

                        <div>
                            <select name="IDSERIE" class="form-control selectpicker" data-live-search="true">
                                <?php
                                foreach ($serie as $ser) {

                                    ?>
                                    <option
                                        value=" <?php echo $ser->getIDSERIE(); ?>" <?php if ($idSerie == $ser->getIDSERIE()) echo "selected" ?>><?php echo $ser->getLIBSERIE(); ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="form-group">
                        <label>PERIODE</label>
                        <div>
                            <select name="SEMESTRES" class="form-control selectpicker" data-live-search="true">

                                <?php foreach ($rs_periode as $per) { ?>

                                    <option value=" <?php echo $per['IDPERIODE']; ?>" <?php if ($semestre == $per['IDPERIODE']) echo "selected" ?>>
                                        <?php echo $per['NOM_PERIODE']; ?>
                                    </option>

                                <?php } ?>

                            </select>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="col-lg-12">

                    <br/>
                    <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>

                </div>

            </div>

            <input type="hidden" name="IDUE" value="<?php echo $id; ?>"/>
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