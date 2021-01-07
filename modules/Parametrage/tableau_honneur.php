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
    $lib->Restreindre($lib->Est_autoriser(3, $lib->securite_xss($_SESSION['profil'])));

$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

try
{
    $query_rq_etablissement = $dbh->query("SELECT MOYENNE FROM TABLEAU_DHONNEUR WHERE IDETABLISSEMENT = ".$colname_rq_etablissement);
    $row_rq_etablissement = $query_rq_etablissement->fetchObject();
    $totalRows_rq_etablissement = $query_rq_etablissement->rowCount();
}
catch (PDOException $e)
{
    echo -2;
}

if(isset($_POST['form1']) && $_POST['form1']=='M_form1' && isset($_POST['MOYENNE']))
{
    try
    {

    }
    catch (PDOException $e)
    {

    }
}
?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Moyenne tableau d'honneur</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

        if (isset($_GET['res']) && $_GET['res'] == 1) {
            ?>
            <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                aria-label="close">&times;</a>
                <?php echo $lib->securite_xss($_GET['msg']); ?></div>
        <?php }
        if (isset($_GET['res']) && $_GET['res'] != 1) {
            ?>
            <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $lib->securite_xss($_GET['msg']); ?></div>
        <?php }
        ?>

    <?php } ?>


    <div class="panel panel-default">

        <div class="panel-body">

            <!-- START WIDGETS -->
            <div class="row">

                <h3>Tableau d'honneur</h3>


                <form method="post" name="form1" action="tableau_honneur.php" value="M_form1">

                <fieldset class="cadre">
                    <legend class="libelle_champ">Moyenne paramétrée</legend>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label">Moyenne: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="MOYENNE" name="MOYENNE" value="<?php echo $row_rq_etablissement->MOYENNE; ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                </fieldset>

                <?php if (($lib->securite_xss($_SESSION['profil']) == 1) || ($lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil'])) == 1)) { ?>

                    <div class="row">
                            <div class="col-lg-offset-5 col-lg-1">
                                <button type="submit" class="btn btn-success" value="modifier">Modifier</button>
                            </div>
                    </div>

                    <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $colname_rq_etablissement; ?>">

                </form>

                <?php } ?>

            </div>
            <!-- END WIDGETS -->

        </div>

    </div>








</div>
<!-- END PAGE CONTENT WRAPPER -->

</div>
</div>
<!-- END PAGE CONTAINER -->

<?php include('footer.php'); ?>