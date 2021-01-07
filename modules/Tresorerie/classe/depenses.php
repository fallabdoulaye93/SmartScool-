
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
$lib->Restreindre($lib->Est_autoriser(34,$_SESSION['profil']));


if ((isset($_POST["envoyer"])) && ($_POST["envoyer"] !="" ) && ($_POST["DATE"]!="") && ($_POST["MONTANT"]!="")) {
  

 
$req = $dbh->prepare("INSERT INTO DEPENSE  ( DATE_REGLEMENT,  MONTANT, MOTIF, IDTYPEPAIEMENT, IDETABLISSEMENT, IDANNEESCOLAIRE) VALUES (:DATE_REGLEMENT,  :MONTANT, :MOTIF, :IDTYPEPAIEMENT, :IDETABLISSEMENT, :IDANNEESCOLAIRE)");
    $req->bindParam(':DATE_REGLEMENT', $_POST['DATE'], PDO::PARAM_STR);
	 $req->bindParam(':MONTANT', $_POST['MONTANT'], PDO::PARAM_STR);
	  $req->bindParam(':MOTIF', $_POST['MOTIF'], PDO::PARAM_STR);
	   $req->bindParam(':IDTYPEPAIEMENT', $_POST['typePayement'], PDO::PARAM_STR);
	    $req->bindParam(':IDETABLISSEMENT', $_SESSION['etab'], PDO::PARAM_STR);
		 $req->bindParam(':IDANNEESCOLAIRE', $_SESSION['ANNEESSCOLAIRE'], PDO::PARAM_STR);
    $res=$req->execute();
	if($res==1){
		$mes="Enregistrement reussie";
		}
	else{
		$mes="enregistrement echouee";
		}


  header("Location: depenses?res=".$res."&msg=".$mes);
}


$colname_rq_depense = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_depense = $_SESSION['etab'];
}
$colname2_rq_depense = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname2_rq_depense = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_depense = $dbh->query("SELECT * FROM DEPENSE, TYPE_PAIEMENT WHERE TYPE_PAIEMENT.id_type_paiment=DEPENSE.IDTYPEPAIEMENT  AND DEPENSE.IDETABLISSEMENT=".$colname_rq_depense." AND DEPENSE.IDANNEESCOLAIRE=".$colname2_rq_depense);




$colname_rq_mnt = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_mnt = $_SESSION['etab'];
}
$colname2_rq_mnt = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname2_rq_mnt = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_mnt = $dbh->query("SELECT sum(DEPENSE.MONTANT) as montant FROM DEPENSE WHERE DEPENSE.IDETABLISSEMENT = ".$colname_rq_mnt." AND DEPENSE.IDANNEESCOLAIRE = ".$colname2_rq_mnt);

$row_rq_mnt = $query_rq_mnt->fetchObject();



?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li class="active">Mensualit&eacute;s</li>
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
       <fieldset class="cadre"><legend> Nouvelle d&eacute;pense</legend>
     
        <div class="row">
        <div class="col-lg-12">
            
             <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >DATE</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="DATE" id="date_foo" required class="form-control" value="<?php echo $_POST['DATE']; ?>"/>
                                    </div>
                                </div>
            </div>
            <div class="col-lg-4">
                                <div class="form-group">
                                   <div class="col-lg-3"> <label >MONTANT</label></div>
                                    <div class="col-lg-9">
                                        <input type="number" name="MONTANT" id="MONTANT"  required class="form-control" value="<?php echo $_POST['MONTANT']; ?>"/>
                                    </div>
                                </div>
            </div>
            <div class="col-lg-4">
                                <div class="form-group">
                                   <div class="col-lg-3"> <label >MOTIF</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="MOTIF" id="MOTIF"  class="form-control" value="<?php echo $_POST['MOTIF']; ?>"/>
                                    </div>
                                </div>
            </div>
          </div>
        </div><br>
        
        <div class="row">
         <div class="col-lg-12">
            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >Type de payement</label></div>
                                    <div class="col-lg-9">
                                        <select name="typePayement" id="typePayement"  class="form-control" >
                                        <option value="">Selectionner</option>
                                       
                                        <option value="1">Ch&eacute;que</option>
                                        <option value="2">Esp&egrave;ce</option>
                                        <option value="3">Virement</option>
                                        </select>
                                    </div>
                                </div>
            </div>
            
             <div class="col-lg-1">
                                <div class="form-group">
                                    
                                    <div>
                                        <input type="submit" class="btn btn-success"  name="envoyer" value="Envoyer"  />
                                    </div>
                                </div>
            </div>
            
        </div> 
        </div>
        
       
            
      </fieldset>
    </form>
    
  
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>

                                <th>DATE</th>
                                <th>MONTANT</th>
                                 <th>MOTIF</th>
                                 <th>Type Payement</th>
                                
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php foreach($query_rq_depense->fetchAll() as $row_rq_depense){
                            
                                ?>
                            <tr>
        
                                <td ><?php echo $lib->date_fr($row_rq_depense['DATE_REGLEMENT']); ?></td>
                                <td ><?php echo $lib->nombre_form($row_rq_depense['MONTANT']); ?></td>
                                <td ><?php echo $row_rq_depense['MOTIF']; ?></td>
                                <td ><?php echo $row_rq_depense['libelle_paiement']; ?></td>
                                
                                    
                                  </tr>
                            <?php  } ?>
           
    </tbody>     
    </table>
  


<div> <br/>
<br/><table class="table table-bordered table-responsive table-striped" style="width:28%">
          <tr>
              
              <th width="271">MONTANT TOTAL DES DEPENSES:</th>
              <td ><?php echo $lib->nombre_form($row_rq_mnt->montant); ?></td>
            </tr>
</table></div> 
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>