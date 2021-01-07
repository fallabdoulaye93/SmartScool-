<?php
if (!isset($_SESSION)) {
    session_start();
}
//var_dump($_GET);exit;


require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(37, $lib->securite_xss($_SESSION['profil'])));

require_once('../Parametrage/classe/ProfileManager.php');
$profiles = new ProfileManager($dbh, 'profil');
$profil = $profiles->getProfiles();


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $colname_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$colname_matricule = "";
if (isset($_POST['MATRICULE']) && $_POST['MATRICULE'] != "")
{
    $colname_matricule = " AND INDIVIDU.MATRICULE='" . $lib->securite_xss($_POST['MATRICULE']) . "'";
}
$colname_prenom = "";
if (isset($_POST['PRENOMS']) && $_POST['PRENOMS'] != "")
{
    $colname_prenom = " AND INDIVIDU.PRENOMS='" . $lib->securite_xss($_POST['PRENOMS']) . "'";
}
$colname_nom = "";
if (isset($_POST['NOM']) && $_POST['NOM'] != "")
{
    $colname_nom = " AND INDIVIDU.NOM='" . $lib->securite_xss($_POST['NOM']) . "'";
}
$colname_tel = "";
if (isset($_POST['TELMOBILE']) && $_POST['TELMOBILE'] != "")
{
    $colname_tel = " AND INDIVIDU.TELMOBILE='" . $lib->securite_xss($_POST['TELMOBILE']) . "'";
}

try
{
    $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE 
                                            FROM INDIVIDU 
                                            WHERE INDIVIDU.IDETABLISSEMENT = " . $colname_rq_individu . " 
                                            AND INDIVIDU.IDINDIVIDU 
                                            NOT IN (SELECT INDIVIDU.IDINDIVIDU FROM INDIVIDU,INSCRIPTION WHERE INDIVIDU.IDINDIVIDU = INSCRIPTION.IDINDIVIDU AND INSCRIPTION.IDANNEESSCOLAIRE=" . $colname_anne . " ) 
                                            AND INDIVIDU.IDTYPEINDIVIDU = 8 " . $colname_matricule . $colname_prenom . $colname_nom . $colname_tel . " 
                                            GROUP BY INDIVIDU.IDINDIVIDU DESC");

    $rs_etudiant = $query_rq_etudiant->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}


?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TIERS</a></li>
    <li>Inscription</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

                <div class="btn-group pull-right">


                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <form id="form" name="form1" method="post" action="inscription.php">
                    <fieldset class="cadre">
                        <legend> Filtre</legend>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>MATRICULE</label>

                                    <div>
                                        <input type="text" name="MATRICULE" id="MATRICULE" class="form-control"
                                               value="<?php echo $lib->affichage_xss($_POST['MATRICULE']); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>PRENOMS</label>

                                    <div>
                                        <input type="text" name="PRENOMS" id="PRENOMS" class="form-control"
                                               value="<?php echo $lib->affichage_xss($_POST['PRENOMS']); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>NOM</label>

                                    <div>
                                        <input type="text" name="NOM" id="NOM" class="form-control"
                                               value="<?php echo $lib->affichage_xss($_POST['NOM']); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>TEL MOBILE</label>

                                    <div>
                                        <input type="text" name="TELMOBILE" id="TELMOBILE" class="form-control"
                                               value="<?php echo $lib->affichage_xss($_POST['TELMOBILE']); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-offset-6 col-xs-1">
                                <div class="form-group">

                                    <div>
                                        <input type="submit" class="btn btn-success" value="Rechercher"/>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </fieldset>
                </form>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>

                        <th>MATRICULE</th>
                        <th>PRENOMS</th>
                        <th>NOM</th>
                        <th>TEL MOBILE</th>
                        <th>S'INSCRIRE</th>


                    </tr>
                    </thead>


                    <tbody>
                    <?php foreach ($rs_etudiant as $individu) { ?>
                        <tr>

                            <td><?php echo $individu['MATRICULE']; ?></td>
                            <td><?php echo $individu['PRENOMS']; ?></td>
                            <td><?php echo $individu['NOM']; ?></td>
                            <td><?php echo $individu['TELMOBILE']; ?></td>


                            <td>
                                <a href="ficheInscriptionEtape1.php?IDINDIVIDU=<?php echo   base64_encode($individu['IDINDIVIDU']); ?>">
                                    <i class=" glyphicon glyphicon-edit"></i>
                                </a>
                            </td>


                        </tr>
                    <?php } ?>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <!-- END WIDGETS -->


</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<?php if (isset($_GET['idetablissement']) && isset($_GET['idinscription'])) { ?>
    <form action="../../ged/inscription.php" method="get">
        <input type="hidden" name="idetablissement" value="<?php print $lib->securite_xss($_GET['idetablissement']); ?>">
        <input type="hidden" name="idinscription" value="<?php print $lib->securite_xss($_GET['idinscription']); ?>">
        <input type="hidden" name="IDINDIVIDU" value="<?php print $lib->securite_xss($_GET['IDINDIVIDU']); ?>">
        <?php if (isset($_GET['nbremois'])){ ?>
            <input type="hidden" name="nbremois" value="<?php print $lib->securite_xss($_GET['nbremois']); ?>">
        <?php } ?>
        <input type="submit" class="hidden" id="valider" name="createPDF" value="<?php print $lib->securite_xss($_GET['IDINDIVIDU']); ?>">
    </form>
<?php } ?>


<?php include('footer.php'); ?>