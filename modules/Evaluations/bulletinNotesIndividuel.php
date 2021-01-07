
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
$lib->Restreindre($lib->Est_autoriser(21,$_SESSION['profil']));


$colname_rq_periode = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_periode = $_SESSION['etab'];
}

$query_rq_periode = $dbh->query("SELECT * FROM PERIODE WHERE IDETABLISSEMENT = ".$colname_rq_periode);


$colname_rq_clas = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_clas = $_SESSION['etab'];
}

$query_rq_clas = $dbh->query("SELECT CLASSROOM.IDCLASSROOM, CLASSROOM.LIBELLE as classe, NIVEAU.LIBELLE as niveau, SERIE.LIBSERIE 
                                        FROM CLASSROOM, NIVEAU, SERIE 
                                        WHERE SERIE.IDSERIE = CLASSROOM.IDSERIE 
                                        AND CLASSROOM.IDNIVEAU = NIVEAU.IDNIVEAU 
                                        AND CLASSROOM.IDETABLISSEMENT = ".$colname_rq_clas);
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
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) 
                  {?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                          <?php } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                              <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						        <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						  <?php } ?>
                 
			     <?php } ?>
                 
                 
             <form id="form1" name="form1" method="post" action="genererBI.php" class="form-inline">
             <fieldset class="cadre"> <legend>Filtre </legend>
                <div class="col-lg-5">
                  <div class="col-lg-3">
                   <label >CHOISIR UNE PERIODE: </label>
                   </div>
                   <div class="col-lg-9"> <select name="IDPERIODE" id="select2">
                  <?php foreach($query_rq_periode->fetchAll() as $row_rq_periode) {  ?>
                  <option value="<?php echo $row_rq_periode['IDPERIODE']?>"><?php echo $row_rq_periode['NOM_PERIODE']?></option>
                  <?php }?>
                 </select></div>
                 </div>
                 
                 <div class="col-lg-5">
                   <div class="col-lg-3"> <label >CHOISIR UNE CLASSE: </label></div>
                    <div class="col-lg-9"><select name="IDCLASSE"  class="form-control selectpicker" data-live-search="true">
                  <?php foreach($query_rq_clas->fetchAll() as $row_rq_clas) {  ?>
                  <option value="<?php echo $row_rq_clas['IDCLASSROOM']?>"><?php echo $row_rq_clas['classe']?></option>
                  <?php }?>
                 </select></div>
                 </div>
                 
                 <div class="col-lg-1">
                    <input type="submit" name="valider" id="valider" value="Valider" class="btn btn-success" />
                 </div>
                 
           </fieldset>
         
                    
    </form>
    
              
                    </div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>