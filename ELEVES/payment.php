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
								
								
$colname_rq = "-1";
if (isset($_SESSION['id'])) {
   $colname_rq = $_SESSION['id'];
}
$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
   $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}


 $query_rq_liste_eveleve = $dbh->query("SELECT FACTURE.*, INSCRIPTION.*, INDIVIDU.* FROM INSCRIPTION, FACTURE, INDIVIDU WHERE FACTURE.IDINSCRIPTION= INSCRIPTION.IDINSCRIPTION AND INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_rq_anne." AND INSCRIPTION.IDINDIVIDU = ".$colname_rq."  ORDER BY FACTURE.IDFACTURE DESC");
	//var_dump($query_rq_liste_eveleve->fetchAll());
?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE / ETUDIANT </a></li>                    
                    <li class="active"> Paiement scolarit&eacute; </li>
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
                                 <th>Matricule</th>
                                 <th>Pr&eacute;nom&amp;Nom </th>
                                 <th>Num&eacute;ro facture</th>
                                 <th>Mois</th>
                                 <th>Date facture</th>
                                 <th>Montant</th>
                                 <th>Montant vers&eacute;</th>
                                 <th>Montant restant</th>
                                 <th>Imprimer</th>
                                 <th>Regler</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php  foreach($query_rq_liste_eveleve->fetchAll() as $row_eleve){
	
	  ?>
       
   <tr>    
      <td ><?php echo $row_eleve['MATRICULE'] ; ?></td>
      <td ><?php echo $row_eleve['PRENOMS']."  ".$row_eleve['NOM']; ?></td>
      <td ><?php echo $row_eleve['NUMFACTURE'] ; ?></td>
      <td ><?php echo $lib->affiche_mois($row_eleve['MOIS']) ; ?></td>
      <td ><?php echo $lib->date_franc($row_eleve['DATEREGLMT']) ; ?></td>
      <td ><?php echo $lib->nombre_form($row_eleve['MONTANT']) ; ?></td>
      <td ><?php echo $lib->nombre_form($row_eleve['MT_VERSE']) ; ?></td>
      <td ><?php echo $lib->nombre_form($row_eleve['MT_RELIQUAT']) ; ?></td>
      <td ><a href="../ged/imprimer_facture.php?IDINDIVIDU=<?php echo $row_eleve['IDINDIVIDU'];?>&IDINSCRIPTION=<?php echo $row_eleve['IDINSCRIPTION'];?>&IDFACTURE=<?php echo $row_eleve['IDFACTURE'];?>"> <i class="glyphicon glyphicon-print"></i></a></td>
     <td ><?php if($row_eleve['ETAT']==0){ ?><a href="jula.php?montant1=<?php echo $row_eleve['MONTANT']?>&id=<?php echo $row_eleve['IDINDIVIDU']?>&mois=<?php echo $row_eleve['MOIS']?>&numfact=<?php echo $row_eleve['IDFACTURE'] ; ?>" ><i class="glyphicon  glyphicon-credit-card"></i></a><?php }?>
      <?php if($row_eleve['ETAT']==1){ ?><span style="color:#D3D3D3"><i class="glyphicon  glyphicon-credit-card"  ></i></span><?php }?></td>                          
  </tr>
                           <?php  } ?>
           
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