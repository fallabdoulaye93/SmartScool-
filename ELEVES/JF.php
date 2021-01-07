
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
if (isset($_SESSION['etab'])) {
  $colname_rq_etablissement = $_SESSION['etab'];
}

$colname_rq_idindividu = "-1";
if (isset($_SESSION['id'])) {
  $colname_rq_idindividu = $_SESSION['id'];
}

//$_SESSION["id"]


$query_rq_etablissement = $dbh->query("SELECT * FROM VACANCES  WHERE IDETABLISSEMENT = ".$colname_rq_etablissement." ORDER BY LIB_VACANCES DESC");






?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active"> Jours Feries</li>
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
                                     <th>VACANCES</th>
                                    <th>DEBUT</th>
                                    <th>FIN</th> 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($query_rq_etablissement->fetchAll() as $feries){
                                /*$even=new Evenement();*/
                                ?>
                            <tr>
        
                                <td ><?php echo $feries['LIB_VACANCES']; ?></td>
                                <td ><?php echo $lib->date_fr($feries['DATE_DEBUT']); ?></td>
                                <td ><?php echo $lib->date_fr($feries['DATE_FIN']); ?></td>
                              
                                   </tr>
                            <?php }  ?>
           
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