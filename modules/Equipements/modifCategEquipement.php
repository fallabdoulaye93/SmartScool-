<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(14, $_SESSION['profil']));


require_once("classe/CategorieEquipementManager.php");
require_once("classe/CategorieEquipement.php");
$categ = new CategorieEquipementManager($dbh, 'CATEGEQUIP');


$colname_rq_categ_etab = "-1";
if (isset($_GET['idCategEquipement'])) {
    $colname_rq_categ_etab = $_GET['idCategEquipement'];
}
// <!--IDMATIERE LIBELLE IDETABLISSEMENT-->

$query_rq_categ_etab = $dbh->query("SELECT * FROM CATEGEQUIP WHERE IDCATEGEQUIP = $colname_rq_categ_etab");
foreach ($query_rq_categ_etab->fetchAll() as $row_rq_categ_etab) {

    $id = $row_rq_categ_etab['IDCATEGEQUIP'];
    $libelle = $row_rq_categ_etab['LIBELLE'];

}


if (isset($_POST) && $_POST != null) {

    $res = $categ->modifier($lib->securite_xss_array($_POST), 'IDCATEGEQUIP', $lib->securite_xss($_POST['IDCATEGEQUIP']));
    if ($res == 1) {
        $msg = "modification reussie";

    } else {
        $msg = "modification echouee";
    }
    header("Location: accueil.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Parametrage</a></li>
    <li>Categorie Equipement</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <form action="modifCategEquipement.php" method="POST">

            <div class="row">

                <div class="col-xs-12">
                    <div class="form-group">
                        <label>CATEGORIE EQUIPEMENT</label>

                        <div>
                            <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control"
                                   value="<?php echo $libelle; ?>"/>
                        </div>
                    </div>
                </div>

                <br><br>


                <div class="col-lg-12">
                <br/>
                    <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>
                </div>

            </div>

            <input type="hidden" name="IDCATEGEQUIP" value="<?php echo $id; ?>"/>
            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>


        </form>


        <!-- END WIDGETS -->

    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>