<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(9, $lib->securite_xss($_SESSION['profil'])));


$colname_REQ_ferie = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_ferie = $lib->securite_xss($_SESSION['etab']);
}


$query_REQ_ferie = $dbh->query("SELECT `IDJOUR_FERIES`, `LIB_VACANCES`, `DATE_DEBUT`, `DATE_FIN`, `IDETABLISSEMENT` FROM `VACANCES` WHERE IDETABLISSEMENT = " . $colname_REQ_ferie . " ORDER BY LIB_VACANCES DESC");


?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Jours F&eacute;ri&eacute;s</li>
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
                    <button data-toggle="modal" data-target="#ajouter"
                            style="background-color:#DD682B" class='btn dropdown-toggle' , aria-hidden='true'>
                        <i class="fa fa-plus"></i> Nouveau jour f&eacute;ri&eacute;</button>

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

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>VACANCES</th>
                        <th>DEBUT</th>
                        <th>FIN</th>

                        <th>MODIFIER</th>
                        <th>SUPPRIMER</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?
                    foreach ($query_REQ_ferie->fetchAll() as $feries) {
                        /*$even=new Evenement();*/
                        ?>
                        <tr>

                            <td><?php echo $lib->securite_xss($feries['LIB_VACANCES']); ?></td>
                            <td><?php echo $lib->securite_xss($lib->date_time_fr($feries['DATE_DEBUT'])); ?></td>
                            <td><?php echo $lib->securite_xss($lib->date_time_fr($feries['DATE_FIN'])); ?></td>


                            <td><a href="modifJF.php?idJF=<?php echo base64_encode($lib->securite_xss($feries['IDJOUR_FERIES'])); ?>"><i
                                        class=" glyphicon glyphicon-edit"></i></a></td>

                            <td><a href="suppJF.php?idJF=<?php echo base64_encode($lib->securite_xss($feries['IDJOUR_FERIES'])); ?>"
                                   onclick="return(confirm('Etes-vous sûr de vouloir supprimer cet enregistrement'));"><i
                                        class="glyphicon glyphicon-remove"></i></a></td>
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
                    <h3 class="panel-title text-center"> Nouveau jour f&eacute;ri&eacute; </h3>
                    <!-- //IDJOUR_FERIES LIB_VACANCES DATE_DEBUT DATE_FIN IDETABLISSEMENT -->
                </div>
                <form action="ajouterJF.php" method="POST">

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>LIBELLE JOUR F&Eacute;RI&Eacute;</label>

                                    <div>
                                        <input type="text" name="LIB_VACANCES" id="LIB_VACANCES" required
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>DATE DEBUT</label>

                                    <div>
                                        <input type="text" id="date_foo" name="DATE_DEBUT" required
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>DATE FIN</label>

                                    <div>
                                        <input type="text" id="date_foo2" name="DATE_FIN" required
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>


                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>



