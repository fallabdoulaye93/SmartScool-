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
    $lib->Restreindre($lib->Est_autoriser(13, $_SESSION['profil']));

$colname_rq_sanction = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_sanction = $lib->securite_xss($_SESSION['etab']);
}

try
{
    $query_rq_sanction = $dbh->query("SELECT s.IDSANCTION, s.DATE, s.MOTIF, s.DATEDEBUT, s.DATEFIN, s.IDINDIVIDU, i.MATRICULE, i.PRENOMS, i.NOM, t.LIBELLE
                                                FROM SANCTION s 
                                                INNER JOIN TYPE_SANCTION t ON s.IDTYPE_SANCTION = t.ID
                                                INNER JOIN INDIVIDU i ON s.IDINDIVIDU = i.IDINDIVIDU
                                                WHERE s.IDETABLISSEMENT = " . $colname_rq_sanction);

    $rs_sanction = $query_rq_sanction->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Sanctions</a></li>
    <li>Historique des sanctions</li>
</ul>
<!-- END BREADCRUMB -->
<style>
    .btn{
        background-color: #1f85c7;
        color: #ffffff;
    }
    .btn:hover{
        color: #F6F6F6;
        text-decoration: none;
    }

</style>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

                <div class="btn-group pull-right">
                    <a href="nouvelleSanction.php">
                        <button
                            style="background-color:#DD682B" class='btn dropdown-toggle' aria-hidden='true'>
                            <i class="fa fa-plus"></i> Nouvelle sanction
                        </button>
                    </a>

                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) {?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>


                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>DATE</th>
                        <th>TYPE SANCTION</th>
                        <th>MOTIF</th>
                        <th>DATE DEBUT</th>
                        <th>DATE FIN</th>
                        <th>ÉTUDIANT/ÉLÈVE</th>
                        <th>SUPPRIMER</th>
                    </tr>
                    </thead>


                    <tbody>

                        <?php foreach ($rs_sanction as $row_rq_sanction) { ?>

                        <tr>

                            <td><?php echo $lib->date_fr($row_rq_sanction['DATE']); ?></td>
                            <td><?php echo $row_rq_sanction['LIBELLE']; ?></td>
                            <td><?php echo $row_rq_sanction['MOTIF']; ?></td>
                            <td><?php echo $lib->date_time_fr($row_rq_sanction['DATEDEBUT']); ?></td>
                            <td><?php echo $lib->date_time_fr($row_rq_sanction['DATEFIN']); ?></td>
                            <td><?php echo $row_rq_sanction['PRENOMS'] . "  " . $row_rq_sanction['NOM'] . "  "; ?>
                                (<?php echo $row_rq_sanction['MATRICULE']; ?>)
                            </td>
                            <td>
                                <a href="suppSanction.php?IDSANCTION=<?php echo $row_rq_sanction['IDSANCTION']; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));">
                                    <i class="glyphicon glyphicon-remove"></i>
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

<?php include('footer.php'); ?>