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
function readEtab($id){
$connection =  new Connexion();
$dbh = $connection->Connection();
 $query_rq_etab = $dbh->query("SELECT NOMETABLISSEMENT_ FROM ETABLISSEMENT WHERE  ETABLISSEMENT.IDETABLISSEMENT = $id");	
	                           
								$rs_etab= $query_rq_etab->fetchObject();
			                    return  $rs_etab->NOMETABLISSEMENT_;
}								
								
$colname_rq_annee = "-1";
if (isset($_SESSION['id'])) {
   $colname_rq = $_SESSION['id'];
}

$colname_rq_actu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_actu = $_SESSION['etab'];
}

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_annee = $_SESSION['ANNEESSCOLAIRE'];
}

$query_id_classe = $dbh->query("SELECT IDCLASSROOM   FROM AFFECTATION_ELEVE_CLASSE WHERE IDINDIVIDU in ( ".$colname_rq.")");
$row_classe = $query_id_classe->fetchObject();
$id_classe = $row_classe->IDCLASSROOM;


$query_rq_actu = $dbh->query("SELECT * FROM ACTUALITES, CLASSROOM WHERE  ACTUALITES.IDCLASSROOM = CLASSROOM.IDCLASSROOM AND ACTUALITES.IDETABLISSEMENT
IN (SELECT IDETABLISSEMENT FROM INDIVIDU WHERE IDINDIVIDU
IN (".$colname_rq ."))  AND ACTUALITES.IDANNEESSCOLAIRE = ".$colname_rq_annee." AND ACTUALITES.IDCLASSROOM in (".$id_classe.",0)");


?>
<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">  </a></li>                    
                    <li class="active"> </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
               
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        
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
    
                  
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                     <th >DATE ACTUALITE</th>
                                     <th>TITRE ACTUALITE</th>
                                     <th>DESCRIPTION ACTUALITE</th>
                                     
                                     <th >CLASSE</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($query_rq_actu->fetchAll() as $actu){
                              
                                ?>
                            <tr>
        
                                <td ><?php echo $lib->date_fr($actu['DATE_ACTUALITE']); ?></td>
                                <td ><?php echo $actu['TITRE_ACTU']; ?></td>
                                <td ><?php echo $actu['DESCRIPTION_ACTU']; ?></td>
                                 
                                 <?php if( strcmp($actu['LIBELLE'],0)  ){ ?>
                                  <td ><?php echo $actu['LIBELLE']; ?></td>
                                  <?php }else{ ?>
                                  <td ><?php echo "Toute l'ecole"; ?></td>
                                  <?php } ?>
                                   </tr>
                            <?php }  ?>
           
    </tbody>     
    </table>

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