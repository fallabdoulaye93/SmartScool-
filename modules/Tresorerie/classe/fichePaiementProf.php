
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
$lib->Restreindre($lib->Est_autoriser(29,$_SESSION['profil']));


$colname_rq_module = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_module = $_GET['IDINDIVIDU'];
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_module = $dbh->query("SELECT RECRUTE_PROF.IDINDIVIDU, RECRUTE_PROF.IDMATIERE, RECRUTE_PROF.VOLUME_HORAIRE, RECRUTE_PROF.TARIF_HORAIRE, MATIERE.LIBELLE, RECRUTE_PROF.IDMATIERE, RECRUTE_PROF.IDCLASSROOM, CLASSROOM.LIBELLE as classe FROM RECRUTE_PROF, MATIERE, CLASSROOM WHERE RECRUTE_PROF.IDINDIVIDU = ".$colname_rq_module." AND RECRUTE_PROF.IDANNEESSCOLAIRE = ".$colname_rq_anne."  AND MATIERE.IDMATIERE=RECRUTE_PROF.IDMATIERE AND CLASSROOM.IDCLASSROOM=RECRUTE_PROF.IDCLASSROOM");


// historique des reglement d
$colname_rq_historique_paiement = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_historique_paiement = $_GET['IDINDIVIDU'];
}

//$query_rq_historique_paiement = $dbh->query("SELECT * FROM REGLEMENT_PROF WHERE INDIVIDU = ".$colname_rq_historique_paiement." ORDER BY IDREGLEMENT DESC");

$query_rq_historique_paiement = $dbh->query("SELECT * FROM REGLEMENT_PROF, TYPE_PAIEMENT WHERE INDIVIDU = ".$colname_rq_historique_paiement." AND TYPE_PAIEMENT.id_type_paiment=REGLEMENT_PROF.IDTYPEPAIEMENT AND REGLEMENT_PROF.IDANNEESCOLAIRE =".$colname_rq_anne." ORDER BY IDREGLEMENT DESC");


//
//echo $query_rq_historique_paiement ;
$colname_rq_individu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_individu = $_GET['IDINDIVIDU'];
}

$query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = ".$colname_rq_individu);

$row_rq_individu = $query_rq_individu->fetchObject();

// tot encaisse
$colname_rq_tot_encaisse = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_tot_encaisse = $_GET['IDINDIVIDU'];
}

$query_rq_tot_encaisse = $dbh->query("SELECT SUM(REGLEMENT_PROF.MONTANT) as tot_encasisse FROM REGLEMENT_PROF WHERE INDIVIDU = ".$colname_rq_tot_encaisse);

$row_rq_tot_encaisse = $query_rq_tot_encaisse->fetchObject();

$query_rq_paiement = $dbh->query("SELECT * FROM TYPE_PAIEMENT  where id_type_paiment not in (4)");


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$mois=$_POST['MOIS'];
  $insertSQL = sprintf("INSERT INTO REGLEMENT_PROF (IDREGLEMENT, DATE_REGLEMENT, MOIS, MONTANT, INDIVIDU, MOTIF, IDTYPEPAIEMENT,recu, IDANNEESCOLAIRE) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                        $lib->GetSQLValueString($_POST['IDREGLEMENT'], "int"),
                        $lib->GetSQLValueString($_POST['DATE_REGLEMENT'], "date"),
                        $lib->GetSQLValueString($mois, "text"),
                        $lib->GetSQLValueString($_POST['MONTANT'], "int"),
                        $lib->GetSQLValueString($_POST['IDINDIVIDU'], "int"),
                        $lib->GetSQLValueString($_POST['MOTIF'], "text"),
					   $lib->GetSQLValueString($_POST['paiement'], "text"),
					   $lib->GetSQLValueString($_POST['recu'], "text"),
					   $lib->GetSQLValueString($_SESSION['ANNEESSCOLAIRE'], "int"));


  $Result1 = $dbh->query($insertSQL);

  $insertGoTo = "fichePaiementProf.php?IDINDIVIDU=".$_POST['IDINDIVIDU'];

  header(sprintf("Location: %s", $insertGoTo));
}

?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li class="active">Paiement Professeur</li>
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
                       
						<button data-toggle="modal" data-target="#ajouter"  
                            style="background-color:#DD682B" class='btn dropdown-toggle', aria-hidden='true' >
                            <i class="fa fa-plus"></i> Nouveau paiement</button>	
                            
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
                    
                    
       <fieldset class="cadre"><legend> Info personnel</legend>
     
        <div class="row">
            <div class="col-lg-3">
                  <div class="col-lg-3"><label class="control-label">MATRICULE: </label></div>
                  <div class="col-lg-9"><?php echo $row_rq_individu->MATRICULE; ?></div>
            </div>
            
             <div class="col-lg-3">
                    <div class="col-lg-3"> <label class="control-label">PRENOMS: </label></div>
                     <div class="col-lg-9"><?php echo $row_rq_individu->PRENOMS; ?></div>
            </div>
            
             <div class="col-lg-3">
                      <div class="col-lg-3"><label class="control-label">NOM: </label></div>
                     <div class="col-lg-9"> <?php echo $row_rq_individu->NOM; ?></div>
            </div>
            
             <div class="col-lg-3">
                      <div class="col-lg-3"><label class="control-label">TELMOBILE: </label></div>
                     <div class="col-lg-9"> <?php echo $row_rq_individu->TELMOBILE; ?></div>
            </div>
        </div>
        
        <br>
              
            
      </fieldset>

                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                        
                                <th>Module</th>
                                <th>Classe</th>
                                 <th>Nb.heures totales</th>
                                 <th>Nb.heures</th>
                                 <th>Total</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                             
      
                           <?php  
	  $total_payer= 0;
	  
	  foreach( $query_rq_module->fetchAll() as $row_rq_module) { 
	   
	
	  // Calcul de temps
				  
			$colindividu_rq_montant =  $row_rq_individu->IDINDIVIDU;
			$colmatiere_rq_montant = $row_rq_module['IDMATIERE'];
			
			$query_rq_montant = $dbh->query("SELECT DISPENSER_COURS.DATEDEBUTCOURS, DISPENSER_COURS.DATEFINCOURS FROM DISPENSER_COURS WHERE    DISPENSER_COURS.IDINDIVIDU=".$colindividu_rq_montant."  AND DISPENSER_COURS.IDMATIERE=".$colmatiere_rq_montant);
			
			
          //  ECHO $query_rq_montant;
			$temp_heure=0;
			foreach($query_rq_montant->fetchAll() as $row_rq_montant)
			{
				
			$diffe=round(((strtotime(substr($row_rq_montant['DATEFINCOURS'],11,5))- strtotime(substr($row_rq_montant['DATEDEBUTCOURS'],11,5)))/3600),2);
			//echo strtotime($row_rq_montant['HEUREFIN']);
			$temp_heure=$temp_heure + $diffe;
				
			}
	  //
	  //$montant=($temp_heure * $row_rq_module['TARIF_HORAIRE'])*95/100;
	  $montant=($temp_heure * $row_rq_module['TARIF_HORAIRE']);
	  $montant_brute+=$temp_heure * $row_rq_module['TARIF_HORAIRE'];
	  ?>
                            
                               
                            <tr>
  
                                <td ><?php echo $row_rq_module['LIBELLE']; ?></td>
                                <td ><?php echo $row_rq_module['classe']; ?></td>
                                <td ><?php echo $row_rq_module['VOLUME_HORAIRE']; ?></td>
                                <td ><?php echo $temp_heure ;?></td>
                                <td ><?php echo $lib->nombre_form($montant) ;?></td>
                                
                                
                                  </tr>
                            <?php  
							$total_payer=  $total_payer + $montant;
							}  ?>
                            
                            </tbody>     
    </table>
    <br><br>
    
    
    <div class="row">
    
    <div class="col-lg-4">
    
    <table width="100%" class="table table-bordered">
                            
      <tr>
        <th >Montant brute</th>
        <th>Tva</th>
        <th >NET A PAYER</th>
      </tr>
      <tr>
       <td ><?php echo $montant_brute; ?></td>
        <td >5%</td>
        <td ><?php echo $lib->nombre_form(($montant_brute * 95)/100) ; $total_payer=(($montant_brute * 95)/100);?></td>
      </tr>
     
      
 </table></div>
 
 <div class="col-lg-8">
 
  <?php if($query_rq_historique_paiement->rowCount() >0) { ?>
 <fieldset class="cadre">
      <legend class="nomEntrepr">PAIEMENTS</legend>
      
      
            <table width="100%" class="table table-striped table-responsive">
              
                <th >Date</th>
                <th >Mois</th>
                <th >Montant</th>
                <th >Motif</th>
                <th>Type Paiement</th>
                <th >Numero</th>
                </tr>
              <?php 
			  $total_encaisee=0;
			 
	 foreach($query_rq_historique_paiement->fetchAll() as $row_rq_historique_paiement) { 
	        ?>
              <tr>
                
                <td><?php echo $lib->date_fr($row_rq_historique_paiement['DATE_REGLEMENT']); ?></td>
                <td><?php echo $row_rq_historique_paiement['MOIS']; ?></td>
                <td><?php echo $lib->nombre_form($row_rq_historique_paiement['MONTANT']); ?></td>
                <td><?php echo $row_rq_historique_paiement['MOTIF']; ?></td>
                <td><?php echo $row_rq_historique_paiement['libelle_paiement']; ?></td>
                <td><?php echo $row_rq_historique_paiement['recu']; ?></td>
                </tr>
              <?php 
				 $total_encaisee+=$row_rq_historique_paiement['MONTANT'];
				
				}  ?>
                <tr><td colspan="4"></td></tr>
              <tr>
              
                 <th>TOTAL ENCAISSE:</th>
                 <td>&nbsp;</td>
                 <td><?php echo $lib->nombre_form($total_encaisee); ?></td>
                 <td>&nbsp;</td>
                </tr>
              <tr>
             
                 <th>MONTANT RESTANT:</th>
                 <td>&nbsp;</td>
                 <td><?php echo $lib->nombre_form($total_payer-$total_encaisee);?></td>
                 <td>&nbsp;</td>
              </tr>
           
    </table> </fieldset><?php } ?>
 </div>
 
 
 </div>
  
 
    
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
         <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouveau paiement </h3> 
                </div>
                <form action="" method="POST" id="form1" name="form1" >
         
                    <div class="panel-body">
                        <div class="row">
                          
                             <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">DATE</label>
                                    <div>
                                        <input type="text" name="DATE_REGLEMENT" id="date_foo" required class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label  class="">MOIS</label>
                                    <div>
                                        <select name="MOIS" class="form-control">
                                          <option value="<?php  echo "JANVIER / ".date('Y');?>"><?php  echo "JANVIER / ".date('Y');?></option>
                                          <option value="<?php  echo "FEVRIER / ".date('Y');?>"><?php  echo "FEVRIER / ".date('Y');?></option>
                                          <option value="<?php  echo "MARS / ".date('Y');?>"><?php  echo "MARS / ".date('Y');?></option>
                                          <option value="<?php  echo "AVRIL / ".date('Y');?>"><?php  echo "AVRIL / ".date('Y');?></option>
                                          <option value="<?php  echo "MAI / ".date('Y');?>"><?php  echo "MAI / ".date('Y');?></option>
                                          <option value="<?php  echo "JUIN / ".date('Y');?>"><?php  echo "JUIN / ".date('Y');?></option>
                                          <option value="<?php  echo "JUILLET / ".date('Y');?>"><?php  echo "JUILLET / ".date('Y');?></option>
                                          <option value="<?php  echo "AOUT / ".date('Y');?>"><?php  echo "AOUT / ".date('Y');?></option>
                                          <option value="<?php  echo "SEPTEMBRE / ".date('Y');?>"><?php  echo "SEPTEMBRE / ".date('Y');?></option>
                                          <option value="<?php  echo "OCTOBRE / ".date('Y');?>"><?php  echo "OCTOBRE / ".date('Y');?></option>
                                          <option value="<?php  echo "NOVEMBRE / ".date('Y');?>"><?php  echo "NOVEMBRE / ".date('Y');?></option>
                                          <option value="<?php  echo "DECEMBRE / ".date('Y');?>"><?php  echo "DECEMBRE / ".date('Y');?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!--<div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">ANNEE</label>
                                    <div>
                                        <input type="text" name="anne" id="anne" readonly class="form-control" value="<?php  //echo date('Y');?>" />
                                    </div>
                                </div>
                            </div>-->
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MONTANT</label>
                                    <div>
                                        <input type="number" name="MONTANT" id="MONTANT" required class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MOTIF</label>
                                    <div>
                                        <input type="text" name="MOTIF" id="MOTIF" required class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">TYPE PAIEMENT</label>
                                    <div>
                                    <select name="paiement" id="paiement">
                                        <option value="" selected="selected" disabled="disabled">--Selectionnez-- </option>
                                          <?php foreach($query_rq_paiement->fetchAll() as $row_rq_paiement ){  ?>
                                          <option value="<?php echo $row_rq_paiement['id_type_paiment']?>"><?php echo $row_rq_paiement['libelle_paiement']?></option>
                                          <?php }?>
           				           </select>
                             </div>
                              </div>
                               </div>
                               
                               <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">Num. Re&ccedil;u/Num. ch&egrave;que/Num. virement</label>
                                    <div>
                                        <input type="text" name="recu" id="recu"  class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            
                            
                            
  
                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        
                         <input type="hidden" name="IDREGLEMENT" value="" />
                          <input type="hidden" name="IDINDIVIDU" value="<?php echo $_GET['IDINDIVIDU']; ?>" />
                          <input type="hidden" name="MM_insert" value="form1" />
                      
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                </form>
                
            </div>

        </div>
    </div>
</div>


<?php include('footer.php'); ?>