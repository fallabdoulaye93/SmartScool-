
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(10, $lib->securite_xss($_SESSION['profil'])));



$colname_rq_reglement_int = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_reglement_int = $lib->securite_xss($_SESSION['etab']);
}


$query_rq_reglement_int = $dbh->query("SELECT IDETABLISSEMENT, REGLEMENTINTERIEUR FROM ETABLISSEMENT WHERE IDETABLISSEMENT = ".$colname_rq_reglement_int);


?>


<?php include('../header.php'); ?>

               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>R&eacute;glement int&eacute;rieur</li>
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
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                          <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                          <?php } ?>
                 
			     <?php } ?>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                    <th width="90%">REGLEMENT INTÉRIEUR</th>
                                    
                                    <th >Modifier</th>

                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($query_rq_reglement_int->fetchAll() as $RI){
                                /*$even=new Evenement();*/
                                ?>
                            <tr>
        
                                <td ><?php echo $RI['REGLEMENTINTERIEUR']; ?></td>
                                
                               
                                <td ><a href="modifRI.php?idEtablissement=<?php echo base64_encode($RI['IDETABLISSEMENT']); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                                

                                   </tr>
                            <?php }  ?>
           
    </tbody>     
    </table>
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        


       <?php include('footer.php');?>



