
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

if($_SESSION['profil'] != 1) 
$lib->Restreindre($lib->Est_autoriser(25,$_SESSION['profil']));

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_classe = $_SESSION['etab'];
}

$query_rq_classe= $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = ".$colname_rq_classe);


if(isset($_POST['envoyer']) && $_POST['envoyer']!="" && $_POST['MOIS']!="" && $_POST['ANNEE']!=""){
	$res="-1";
	$msg="Generation des factures du mois  echouee";
	
	$colname_rq_inscription = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_inscription = $_SESSION['etab'];
}

$query_rq_inscription = $dbh->query("SELECT * FROM INSCRIPTION WHERE IDETABLISSEMENT = ".$colname_rq_inscription." AND IDANNEESSCOLAIRE=".$_SESSION['ANNEESSCOLAIRE']);



$mois=$_POST['MOIS']."-".$_POST['ANNEE'];

	if($query_rq_inscription->fetchColumn() > 0 )
	{
		foreach($query_rq_inscription->fetchAll() as $row_rq_inscription)
		{
		$lib->Generer_facture($mois,$row_rq_inscription['ACCORD_MENSUELITE'],$row_rq_inscription['IDINSCRIPTION'],$_SESSION['etab']);
		}
		$res=1;
		$msg="Vos factures du mois ont été generées avec succès";
	}
	
	header('Location: generationFacture.php?res='.$res.'&msg='.$msg);
}





?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li class="active">Facture</li>
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
						  <?php echo $_GET['msg']; ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $_GET['res']!=1) 
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $_GET['msg']; ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                 
    <form id="form1" name="form1" method="post" action="" >
       <fieldset class="cadre"><legend> G&eacute;n&eacute;ration facture globale</legend>
     
        <div class="row">
        <div class="col-lg-12">
             <div class="col-lg-4">
                            
                                   <div class="col-lg-3"> <label class="control-label">MOIS</label></div>
                                    <div class="col-lg-9">
                                        <select  name="MOIS" id="MOIS"  class="form-control">
                                        <option value="">Mois</option>
                                        <option value="01"><?php echo  $lib->Le_mois("01");?></option>
                                        <option value="02"><?php echo  $lib->Le_mois("02");?></option>
                                        <option value="03"><?php echo  $lib->Le_mois("03");?></option>
                                        <option value="04"><?php echo  $lib->Le_mois("04");?></option>
                                        <option value="05"><?php echo  $lib->Le_mois("05");?></option>
                                        <option value="06"><?php echo  $lib->Le_mois("06");?></option>
                                        <option value="07"><?php echo  $lib->Le_mois("07");?></option>
                                        <option value="08"><?php echo  $lib->Le_mois("08");?></option>
                                        <option value="09"><?php echo  $lib->Le_mois("09");?></option>
                                        <option value="10"><?php echo  $lib->Le_mois(10);?></option>
                                        <option value="11"><?php echo  $lib->Le_mois(11);?></option>
                                        <option value="12"><?php echo  $lib->Le_mois(12);?></option>
                                        
                                       
                                        </select>
                                        
                                    </div>
                               
            </div>
            
             <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >ANN&Eacute;E</label></div>
                                    <div class="col-lg-9">
                                        <select  name="ANNEE" id="ANNEE"  class="form-control">
                                        <option value="">ANN&Eacute;E</option>
                                         <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                         <option value="<?php echo date('Y', strtotime('-1 year')); ?>"><?php echo date('Y', strtotime('-1 year')); ?></option>
                                         <option value="<?php echo date('Y', strtotime('-2 year')); ?>"><?php echo date('Y', strtotime('-2 year')); ?></option>
                                        
                                       
                                        </select>
                                    </div>
                                </div>
            </div>
            
            <div class="col-lg-4">
                                <div class="form-group">
                                    
                                    <div>
                                        <input type="submit" class="btn btn-success" name="envoyer" value="Envoyer"  />
                                    </div>
                                </div>
            </div>
            
          </div>
        </div>
            
      </fieldset>
    </form>
    <br><br>
    
    <form id="form" name="form" method="post" action="factureIndividuelle.php" >
       <fieldset class="cadre"><legend> G&eacute;n&eacute;ration facture individuelle</legend>
     
     <div class="row">
        <div class="col-lg-12">
             <div class="col-lg-6">
                            
                                   <div class="col-lg-3"> <label class="control-label">Classe</label></div>
                                    <div class="col-lg-9">
                                        <select  name="Classe" id="Classe"  class="form-control selectpicker " data-live-search="true">
                                     
                                       <option value="">--S&eacute;lectionner--</option>
                                       <?php foreach($query_rq_classe->fetchAll() as $row_rq_classe){ ?>
                                       <option value="<?php echo $row_rq_classe['IDCLASSROOM']; ?>"><?php echo $row_rq_classe['LIBELLE'];?></option>
                                       <?php } ?>
                
                                        
                                       
                                        </select>
                                        
                                    </div>
                               
            </div>
            
             
                            
                                   
            
            <div class="col-lg-1">
                                <div class="form-group">
                                    
                                    <div>
                                        <input type="submit" class="btn btn-success" name="envoyer" value="Envoyer"  />
                                    </div>
                                </div>
            </div>
            
          </div>
        </div>
            
      </fieldset>
    </form>
    
    
                    
                    
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>