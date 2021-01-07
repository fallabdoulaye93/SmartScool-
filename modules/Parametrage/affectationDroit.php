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

$colname_REQ_users = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_users = $lib->securite_xss($_SESSION['etab']);
}

try
{
    $rq_dictionnaire = $dbh->query("SELECT a.idAction, a.label, a.module, m.nomModule 
                                        FROM ACTION a 
                                        INNER JOIN MODULE m ON a.module = m.idModule
                                        WHERE a.idEtablissement = $colname_REQ_users 
                                        ORDER BY a.module DESC");
    $rs_dictionnaire = $rq_dictionnaire->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
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
            <div class="panel-heading">
                <span
                    style="color:#DD682B; font-size:18px">Droits &amp; permissions du profil : <?php echo $lib->securite_xss(base64_decode($_GET['profil'])) ?></span>

                <div class="btn-group pull-right">


                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                        if(isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                        <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>
                <form id="form_droit" name="form_droit" method="post" action="permissionTraite.php">
                    <table id="customers2" class="table datatable">

                        <thead>
                        <tr>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Droit</th>

                        </tr>
                        </thead>


                        <tbody>
                        <?php foreach ($rs_dictionnaire as $module) { ?>
                            <tr>

                                <td><input type="text" name="module[]" id="module" value="<?php echo $module['nomModule']; ?>" class="form-control" readonly></td>

                                <td><input type="text" name="action[]" id="action" value="<?php echo $module['label']; ?>" class="form-control" readonly></td>

                                <td>
                                    <?php $restreint = $lib->Est_autoriser($module['idAction'], base64_decode($lib->securite_xss($_GET['idProfil']))); ?>
                                    <input type="checkbox" name="valide[]" <?php if ($restreint == 1) { echo "checked"; } ?> value="<?php echo $module['idAction']; ?>" class="css-checkbox">
                                </td>
                            </tr>

                        <?php } ?>

                        </tbody>
                    </table>

                    <input type="hidden" name="profil" id="profil" value="<?php echo base64_decode($lib->securite_xss($_GET['idProfil'])); ?>"/>

                    <div class="col-lg-offset-5">
                        <input name="button" type="submit" id="valider" value="VALIDER" class="btn btn-success"/>
                    </div>
                </form>


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


<?php include('footer.php'); ?>



