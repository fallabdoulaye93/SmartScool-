
<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../restriction.php");


require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(47,$_SESSION['profil']));


$colname_rq_totat_eleve = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_totat_eleve = $_SESSION['etab'];
}

$query_rq_totat_eleve = $dbh->query("SELECT count(IDINDIVIDU) as tot_eleve FROM INDIVIDU WHERE IDETABLISSEMENT = ".$colname_rq_totat_eleve." AND IDTYPEINDIVIDU=8");
$row_rq_totat_eleve = $query_rq_totat_eleve->fetchObject();




?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">EVALUATIONS</a></li>                    
                    <li>Reporting</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
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
                    
                    <div class="col-lg-6">
                    <fieldset class="cadre"><legend>REPORTING</legend>
                    <div class="col-lg-6" >
                    
                    </div>
                    <div class="col-lg-6" >
                         <div id="container2" style=" height: 200px;"> </div>
                   </div>
                    
                    </fieldset>
                    </div>
                    
                    
                    
                    <div class="col-lg-6">
                    
                    <fieldset class="cadre"><legend>  REPORTING    </legend>
                     <div class="col-lg-6" >
                    
                    </div>
                    <div class="col-lg-6" >
                         <div id="container2" style=" height: 200px;"> </div>
                   </div>
                   </fieldset>
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
		
        