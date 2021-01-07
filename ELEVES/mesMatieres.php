
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

$query_rq_classroom = $dbh->query("SELECT c.IDCLASSROOM, c.LIBELLE, c.IDNIVEAU, c.IDSERIE 
                                            FROM CLASSROOM c, AFFECTATION_ELEVE_CLASSE aff
                                            WHERE aff.IDCLASSROOM = c.IDCLASSROOM 
                                            AND  aff.IDINDIVIDU = ".$colname_rq_idindividu."  
                                            AND aff.IDANNEESSCOLAIRE = ".$colname_rq_annee." 
                                            AND aff.IDETABLISSEMENT = ".$colname_rq_etablissement);





?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active"> Matieres </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="panel panel-default">

                        <div class="panel-body">

                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1)
                        {?>
                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $_GET['msg']; ?></div>
                        <?php  }
                        if(isset($_GET['res']) && $_GET['res']!=1)
                        {?>
                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $_GET['msg']; ?></div>
                        <?php }
                        ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">

                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                  <th>SEMESTRES</th>
                                  <th>MATIERE</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                            
                           <?php


                           foreach( $query_rq_classroom->fetchAll() as $row_rq_classroom){
                                $count_rq_classroom = $query_rq_classroom->rowCount();

						   if ($count_rq_classroom >0){
							   $idNiveau = $row_rq_classroom['IDNIVEAU'];
							   $idSerie = $row_rq_classroom['IDSERIE'];

                               $query_rq_etablissement = $dbh->query("SELECT m.LIBELLE as libMat, p.NOM_PERIODE  
                                                                                FROM MATIERE m 
                                                                                INNER JOIN PERIODE p ON p.IDNIVEAU = m.IDNIVEAU
                                                                                WHERE m.IDNIVEAU = ".$idNiveau." 
                                                                                AND m.IDETABLISSEMENT = ".$colname_rq_etablissement);

                            foreach ($query_rq_etablissement->fetchAll() as $controle){ ?>
                            <tr>
                                <td><?php echo $controle['NOM_PERIODE']; ?></td>
                                <td><?php echo $controle['libMat']; ?></td>
                            </tr>
                            <?php } } }
                            ?>
           
    </tbody>     
    </table>

                    </div>
                    <!-- END WIDGETS -->                    
                        </div></div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
        
        

        <?php include('footer.php'); ?>