
<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("restriction.php");

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

require_once('classe/IndividuManager.php');
$ind = new IndividuManager($dbh,'INDIVIDU');

$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab']))
{
  $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_idindividu = "-1";
if (isset($_SESSION['id']))
{
  $colname_rq_idindividu = $lib->securite_xss($_SESSION['id']);
}

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
  $colname_rq_annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_classroom = $dbh->query("SELECT CLASSROOM.IDCLASSROOM, CLASSROOM.LIBELLE, CLASSROOM.IDNIVEAU, CLASSROOM.IDSERIE 
                                            FROM CLASSROOM, AFFECTATION_ELEVE_CLASSE 
                                            WHERE AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM 
                                            AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = ".$colname_rq_idindividu."  
                                            AND AFFECTATION_ELEVE_CLASSE.IDANNEESSCOLAIRE = ".$colname_rq_annee." 
                                            AND AFFECTATION_ELEVE_CLASSE.IDETABLISSEMENT = ".$colname_rq_etablissement);
                                            $row_rq_classroom = $query_rq_classroom->fetchObject();
                                            $count_rq_classroom = $query_rq_classroom->rowCount();


if ($count_rq_classroom >0){
   $idClasse = $row_rq_classroom->IDCLASSROOM;
}

$query_bulletin = $dbh->query("SELECT DISTINCT b.IDPERIODE, b.IDCLASSROOM, p.NOM_PERIODE 
                                         FROM BULLETIN b 
                                         INNER JOIN PERIODE p ON p.IDPERIODE = b.IDPERIODE 
                                         WHERE b.IDINDIVIDU = ".$colname_rq_idindividu." 
                                         AND b.IDANNEE = ".$colname_rq_annee);
$rs_bulletin = $query_bulletin->fetchAll(PDO::FETCH_ASSOC);

?>

        <?php require_once('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active"> Bulletins de note</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= '')
                    {
                        if(isset($_GET['res']) && $_GET['res']==1) { ?>

                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php } ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->

                        <!-- START WIDGETS -->
                        <div class="row">
                            <div class=" panel-default">
                                <div class="panel-body">
                                    <div class="panel row">

                        <table class="table">

                            <thead>
                            <tr>
                                <th>Périodes</th>
                                <th style="text-align: center !important;">Voir bulletion</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php foreach ($rs_bulletin as $row_bulletin) { ?>

                                <tr>

                                    <td>
                                        <?php echo $row_bulletin['NOM_PERIODE']; ?>
                                    </td>

                                    <td style="text-align: center !important;">
                                        <a target="_blank" href="../ged/imprimer_bulletin_individu.php?idIndividu=<?php echo base64_encode($colname_rq_idindividu); ?>&idclassroom=<?php echo base64_encode($row_bulletin['IDCLASSROOM']);?>&periode=<?php echo base64_encode($row_bulletin['IDPERIODE']); ?>">
                                            <i class="glyphicon glyphicon-print"></i>
                                        </a>
                                    </td>

                                </tr>

                            <?php } ?>

                            </tbody>
                        </table>

                    </div>
                    <!-- END WIDGETS -->
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>  <!-- END PAGE CONTAINER -->
        

        <?php require_once('footer.php'); ?>