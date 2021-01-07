
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
$lib->Restreindre($lib->Est_autoriser(30,$_SESSION['profil']));

$colname_rq_scolarite = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_scolarite =$_SESSION['ANNEESSCOLAIRE'];
}
//

$ETAB = $_SESSION['etab'];


$query_rq_scolarite = $dbh->query("SELECT SUM(INSCRIPTION.ACCORD_MENSUELITE)  as somme_scolarite FROM INSCRIPTION WHERE INSCRIPTION.IDANNEESSCOLAIRE=".$colname_rq_scolarite." AND  IDETABLISSEMENT=$ETAB");

$row_rq_scolarite = $query_rq_scolarite->fetchObject();


$colname_rq_reliquat = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_reliquat = $_SESSION['etab'];
}

$query_rq_reliquat = $dbh->query("SELECT SUM(FACTURE.MONTANT) AS MONTANT, SUM(FACTURE.MT_VERSE) AS VERSE, SUM(FACTURE.MT_RELIQUAT) AS RELIQUAT FROM FACTURE, INSCRIPTION WHERE FACTURE.IDINSCRIPTION = INSCRIPTION.IDINSCRIPTION AND INSCRIPTION.IDANNEESSCOLAIRE=". $colname_rq_scolarite." AND FACTURE.IDETABLISSEMENT =".$colname_rq_reliquat);

$row_rq_reliquat = $query_rq_reliquat->fetchObject();


$colname_rq_paiement = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_paiement = $_SESSION['etab'];
}
$colname1_rq_paiement = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname1_rq_paiement = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_paiement = $dbh->query("SELECT RECRUTE_PROF.TARIF_HORAIRE , RECRUTE_PROF.VOLUME_HORAIRE  FROM RECRUTE_PROF WHERE RECRUTE_PROF.IDETABLISSEMENT=".$colname_rq_paiement." AND RECRUTE_PROF.IDANNEESSCOLAIRE= ".$colname1_rq_paiement);

$somme_pa_prof=0;
foreach($query_rq_paiement->fetchAll() as $row_rq_paiement)
{
$somme_pa_prof+=($row_rq_paiement['TARIF_HORAIRE'] *$row_rq_paiement['VOLUME_HORAIRE']);
}



?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li class="active">Pr&eacute;vision Budgetaire</li>
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
                    
                    <table width="70%" height="81" border="0" cellpadding="0" cellspacing="7" class="table table-responsive table-striped table-bordered">
  
      <tr>
        <th >SCOLARITE</th>
        <th >LES RETARDS DE PAIEMENT</th>
        <th >PAIEMENT DES PROFESSEURS</th>
        
      </tr>
      <tr>
        <td ><?php echo $lib->nombre_form($row_rq_reliquat->MONTANT); ?> FRS</td>
        <td ><?php echo $lib->nombre_form($row_rq_reliquat->RELIQUAT); ?> FRS</td> 
        <td ><?php echo $lib->nombre_form($somme_pa_prof); ?> FRS</td>
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