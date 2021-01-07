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
    $lib->Restreindre($lib->Est_autoriser(21, $_SESSION['profil']));


$colname_rq_periode = "-1";
if (isset($_SESSION['etab']))
{
    $colname_rq_periode = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_classe = "-1";
if (isset($_POST['IDCLASSE']))
{
    $colname_rq_classe = $lib->securite_xss($_POST['IDCLASSE']);
}

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $colname_rq_annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $query_rq_classe_eleve = $dbh->query("SELECT * FROM INDIVIDU,  AFFECTATION_ELEVE_CLASSE 
                                                    WHERE AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                                    AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = " . $colname_rq_classe);
    $rs_eleve = $query_rq_classe_eleve->fetchAll();

    $query_rq_classe = $dbh->query("SELECT NIVEAU.LIBELLE as lib, CLASSROOM.*  
                                              FROM CLASSROOM, NIVEAU 
                                              WHERE IDCLASSROOM = " . $colname_rq_classe . " 
                                              AND NIVEAU.IDNIVEAU = CLASSROOM.IDNIVEAU");

    $row_rq_classe = $query_rq_classe->fetchObject();
}
catch (PDOException $e)
{
    echo -2;
}



?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Evaluations</a></li>
    <li>Bulletin de notes individuel</li>
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

                    if (isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) {?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <div><h4 style="color:#E05D1F;"> Les eleves du niveau <?php echo $row_rq_classe->lib; ?>, de la
                        classe <?php echo $row_rq_classe->LIBELLE; ?></h4></div>


                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>MATRICULE</th>
                        <th>PRENOMS</th>
                        <th>NOM</th>
                        <th>TEL</th>
                        <th>IMPRIMER</th>

                    </tr>
                    </thead>


                    <tbody>
                    <?php foreach ($rs_eleve as $row_rq_classe_eleve) { ?>
                        <tr>
                            <td><img src="../../imgtiers/<?php echo $row_rq_classe_eleve['PHOTO_FACE']; ?>"
                                     width="31px"/></td>
                            <td><?php echo $row_rq_classe_eleve['MATRICULE']; ?></td>
                            <td><?php echo $row_rq_classe_eleve['PRENOMS']; ?></td>
                            <td><?php echo $row_rq_classe_eleve['NOM']; ?></td>
                            <td><?php echo $row_rq_classe_eleve['TELMOBILE']; ?></td>
                            <td>
                                <a href="#" onclick="imprimer2(<?php echo $row_rq_classe_eleve['IDINDIVIDU']; ?>)">
                                    <i class="glyphicon glyphicon-print"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <form id="form1" name="form1" method="post" action="" class="form-inline">

                    <input type="hidden" name="idetablissement" id="idetablissement" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>
                    <input type="hidden" name="IDPERIODE" id="IDPERIODE" value="<?php echo $lib->securite_xss($_POST['IDPERIODE']); ?>"/>
                    <input type="hidden" name="IDCLASSE" id="IDCLASSE" value="<?php echo $lib->securite_xss($_POST['IDCLASSE']); ?>"/>

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
