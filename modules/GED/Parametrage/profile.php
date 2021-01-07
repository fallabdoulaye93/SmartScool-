<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once("classe/ProfileManager.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil']));


$profiles = new ProfileManager($dbh, 'profil');
$profils = $profiles->getProfiles();


$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

$rq_typeindivu = $dbh->query("SELECT idProfil, profil, idEtablissement, dateCreation, userCreation, dateModification, userModification, etat 
                                        FROM profil order by idProfil DESC");
?>

<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Paramétrage</a></li>
    <li>Profil</li>
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
                    <button data-toggle="modal" data-target="#ajouter" style="background-color:#E05D1F" class='btn dropdown-toggle'  aria-hidden='true'>
                        <i class="fa fa-plus"></i> Nouveau profil
                    </button>
                </div>
            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) {?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>

                        <th width="82%">Profil</th>
                        <th>Modifier</th>
                        <th>Détail profil</th>
                        <th>Etat</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?
                    foreach ($profils as $profile) {
                        if ($profile->getEtat() == 1) {
                            $action = "0";
                            $classe = "<span style='color: green;' class='glyphicon glyphicon-ok-circle'></span>";
                        } else {
                            $action = "1";
                            $classe = "<span style='color: darkred;' class='glyphicon glyphicon-ban-circle'></span>";
                        }
                        ?>
                        <tr>
                            <td><?php echo $profile->getProfil(); ?></td>

                            <td>

                                <a href="modifProfil.php?idProfil=<?php echo base64_encode($profile->getIdProfil()); ?>">

                                    <i class=" glyphicon glyphicon-edit"></i>

                                </a>

                            </td>

                            <td>

                                <a href="Detailprofil.php?idProfil=<?php echo base64_encode($profile->getIdProfil()); ?>">

                                    <i class=" glyphicon glyphicon-list"></i>

                                </a>

                            </td>
                            <td>

                                <a href="modifEtat.php?idProfil=<?php echo base64_encode($profile->getIdProfil()); ?>&amp;etat=<?php echo base64_encode($action); ?>"
                                   title="<?php if($profile->getEtat() == 1) echo "Désactiver"; else echo "Activer"; ?>">

                                    <?php echo $classe; ?></span>

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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter"
     data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouveau profil </h3>
                </div>
                <form action="ajouterProfil.php" method="post">

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>PROFIL</label>

                                    <div>
                                        <input type="text" name="profil" id="profil" required class="form-control"/>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>

                        <input type="hidden" name="userCreation" value="<?php echo $lib->affichage_xss($_SESSION["id"]); ?>"/>
                        <input type="hidden" name="dateCreation" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
                        <input type="hidden" name="userModification" value="<?php echo $lib->affichage_xss($_SESSION["id"]); ?>"/>
                        <input type="hidden" name="dateModification" value="<?php echo date('Y-m-d H:i:s'); ?>"/>

                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>
