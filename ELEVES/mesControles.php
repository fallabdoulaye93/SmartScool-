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
$ind=new IndividuManager($dbh,'INDIVIDU');

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


$query_rq_classroom = $dbh->query("SELECT c.IDCLASSROOM, c.LIBELLE, c.IDNIVEAU, c.IDSERIE 
                                            FROM CLASSROOM c 
                                            INNER JOIN AFFECTATION_ELEVE_CLASSE a ON a.IDCLASSROOM = c.IDCLASSROOM
                                            WHERE a.IDINDIVIDU = ".$colname_rq_idindividu."  
                                            AND a.IDANNEESSCOLAIRE = ".$colname_rq_annee." 
                                            AND a.IDETABLISSEMENT = ".$colname_rq_etablissement);
                                            $row_rq_classroom = $query_rq_classroom->fetchObject();
                                            $count_rq_classroom = $query_rq_classroom->rowCount();

?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active">Controles </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">


                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1)
                        {?>
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                        <?php } ?>

                    <?php } ?>

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <!-- START WIDGETS -->
                            <div class="row">

                            <table id="customers2" class="table datatable">

                                 <thead>
                                    <tr>

                                          <th>Controle</th>
                                          <th>Date Debut</th>
                                          <th>Date Fin</th>
                                          <th>CLASSE</th>
                                          <th>MATIERE</th>
                                          <th>PROFESSEUR</th>
                                          <th>NOTE</th>

                                    </tr>
                                    </thead>


                                    <tbody>

                                   <?php
                                   if ($count_rq_classroom >0){
                                       $idClasse = $row_rq_classroom->IDCLASSROOM;

                                        try
                                        {
                                            $query_rq_etablissement = $dbh->query("SELECT CONTROLE.*,NOTE.*, CLASSROOM.LIBELLE as LIBCLASS, MATIERE.LIBELLE as LIBMAT, INDIVIDU.MATRICULE, INDIVIDU.PRENOMS, INDIVIDU.NOM 
                                                                                             FROM CONTROLE, CLASSROOM, MATIERE, INDIVIDU,NOTE  
                                                                                             WHERE  CONTROLE.IDCLASSROOM = CLASSROOM.idCLASSROOM 
                                                                                             AND CONTROLE.IDMATIERE = MATIERE.IDMATIERE 
                                                                                             AND CONTROLE.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                                                                             AND NOTE.IDCONTROLE = CONTROLE.IDCONTROLE 
                                                                                             AND NOTE.IDINDIVIDU = ".$colname_rq_idindividu." 
                                                                                             AND  CONTROLE.IDCLASSROOM = ".$idClasse." 
                                                                                             AND CONTROLE.IDETABLISSEMENT= ".$colname_rq_etablissement);
                                            $rs_etabblissemzent = $query_rq_etablissement->fetchAll();
                                            //var_dump($rs_etabblissemzent);die();

                                        }
                                        catch (PDOException $e){
                                            echo -2;
                                        }


                                    foreach ($rs_etabblissemzent as $controle){ ?>
                                    <tr>

                                        <td><?php echo $controle['LIBELLE_CONTROLE']; ?></td>
                                        <td><?php echo $lib->date_time_fr($controle['DATEDEBUT']); ?></td>
                                        <td><?php echo $lib->date_time_fr($controle['DATEFIN']); ?></td>
                                        <td><?php echo $controle['LIBCLASS']; ?></td>
                                        <td><?php echo $controle['LIBMAT']; ?></td>
                                        <td><?php echo $controle['PRENOMS']."  ".$controle['NOM']; ?></td>
                                        <td><?php echo $controle['NOTE']; ?></td>

                                          </tr>
                                    <?php }
                                   }?>

                                    </tbody>
                            </table>


                            </div>
                            <!-- END WIDGETS -->
                    
                        </div>
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
        
        

        <?php include('footer.php'); ?>