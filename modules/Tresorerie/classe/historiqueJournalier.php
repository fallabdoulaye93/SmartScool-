
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
$lib->Restreindre($lib->Est_autoriser(32,$_SESSION['profil']));



$colname_rq_histo_paiement = "-1";
if (isset($_SESSION["etab"])) {
  $colname_rq_histo_paiement = $_SESSION["etab"];
}

$colname_rq_annee = "-1";
if (isset($_SESSION["ANNEESSCOLAIRE"])) {
  $colname_rq_annee = $_SESSION["ANNEESSCOLAIRE"];
}

$colname2_rq_histo_paiement = date('Y-m-d');
if (isset($_POST['DATEREGLMT'])) {
  $colname2_rq_histo_paiement = $_POST['DATEREGLMT'];
}


$cond = "";
if (isset($_POST['DATEREGLMT']) && $_POST['DATEREGLMT']!='') {
  //$colname2_rq_histo_paiement = $_POST['DATEREGLMT'];
  $cond.=" AND MENSUALITE.DATEREGLMT='".$_POST['DATEREGLMT']."'";
}
else{
	$cond.= "  AND MENSUALITE.DATEREGLMT = '".date('Y-m-d')."'";
	}

$query_rq_histo_paiement = $dbh->query("SELECT * FROM MENSUALITE, INSCRIPTION, INDIVIDU WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_histo_paiement." AND MENSUALITE.IDINSCRIPTION =INSCRIPTION.IDINSCRIPTION AND INSCRIPTION.IDINDIVIDU =INDIVIDU.IDINDIVIDU  AND INSCRIPTION.IDANNEESSCOLAIRE = ". $colname_rq_annee." ".$cond);
//echo $query_rq_histo_paiement;

//SELECT * FROM MENSUALITE, INSCRIPTION, INDIVIDU, ETABLISSEMENT WHERE ETABLISSEMENT.IDETABLISSEMENT = %s AND MENSUALITE.IDINSCRIPTION =INSCRIPTION.IDINSCRIPTION AND INSCRIPTION.IDINDIVIDU =INDIVIDU.IDINDIVIDU AND MENSUALITE.DATEREGLMT = %s





?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li class="active">Historique journalier</li>
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
                        
                       <a href="../../ged/imprimer_histo_journalier.php?DATE=<?php echo $colname2_rq_histo_paiement; ?>"><img src="../../images/bt_imprimer.png" width="99" height="27" /></a>
							
                            
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
       <fieldset class="cadre"><legend> Filtre</legend>
     
       
        
        <div class="row">
         <div class="col-lg-12">
            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >Date</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="DATEREGLMT" id="date_foo3"  class="form-control"  value="<?php echo date('Y-m-d');?>"/>
                                        
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
    </form><br><br>
    <div> <center> <h4> Historique journalier des reglements du  <?php echo $lib->date_fr($colname2_rq_histo_paiement);?> </h4></center></div>
    
    <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                <th>MATRICULE</th>
                                <th>NOM</th>
                                <th>PRENOMS</th>
                                <th>DATE DE NAISSANCE</th>
                                <th>ADRESSE</th>
                                <th>MONTANT VERSE</th>
                                
                                 
                            </tr>
                         </thead>
                         
                         <tbody>
                         <?php foreach($query_rq_histo_paiement->fetchAll() as $row_rq_histo_paiement){
							 $total+=$row_rq_histo_paiement['MONTANT'];
							 ?>
                         <tr>
                                <td><?php echo $row_rq_histo_paiement['MATRICULE']; ?></td>
                                <td><?php echo $row_rq_histo_paiement['NOM']; ?></td>
                                <td><?php echo $row_rq_histo_paiement['PRENOMS']; ?></td>
                                <td><?php echo $row_rq_histo_paiement['DATNAISSANCE']; ?></td>
                                <td><?php echo $row_rq_histo_paiement['ADRES']; ?></td>
                                <td><?php echo $lib->nombre_form($row_rq_histo_paiement['MT_VERSE']); ?></td>
                               
                                 
                            </tr>
                            <?php } ?>
                         </tbody>
    </table>
    <table width="50%" border="0">
    <tr>
              <th>Total:</th>
             
              <td><?php echo $lib->nombre_form($total);?></td>
            </tr>
    </table>
                    
                     
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>