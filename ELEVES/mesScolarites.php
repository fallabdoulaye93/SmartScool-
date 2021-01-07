
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

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_annee = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_classroom = $dbh->query("SELECT INSCRIPTION.IDINSCRIPTION FROM INSCRIPTION, INDIVIDU WHERE INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU AND  INSCRIPTION.IDINDIVIDU = ".$colname_rq_idindividu."  AND INSCRIPTION.IDANNEESSCOLAIRE = ".$colname_rq_annee." AND INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_etablissement);
$row_rq_classroom = $query_rq_classroom->fetchObject();
$count_rq_classroom = $query_rq_classroom->rowCount();





?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active">Scolarites </li>
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
                            
                            	<!--IDMENSUALITE 	MOIS 	MONTANT 	DATEREGLMT 	IDINSCRIPTION 	IDETABLISSEMENT 	MT_VERSE 	MT_RELIQUAT 	id_type_paiment -->

								  <th>DATE REGLEMENT</th>
                                  <th>MOIS</th>
                                  <th>MONTANT</th>
                                  <th>Montant vers&eacute;</th>
                                  <th>Montant restant</th>
                                  <th>Type paiement</th>
                               
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                            
                           <?php
						   if ($count_rq_classroom >0){
							   $idInscription = $row_rq_classroom->IDINSCRIPTION;
							  


$query_rq_etablissement = $dbh->query("SELECT MENSUALITE.*, TYPE_PAIEMENT.*  FROM MENSUALITE, TYPE_PAIEMENT  WHERE TYPE_PAIEMENT.id_type_paiment = MENSUALITE.id_type_paiment AND  MENSUALITE.IDINSCRIPTION = ".$idInscription." AND MENSUALITE.IDETABLISSEMENT= ".$colname_rq_etablissement);
						   
                            foreach ($query_rq_etablissement->fetchAll() as $controle){
                                /*$even=new Evenement();*/
                                ?>
                            <tr>
        
                                <td ><?php echo $lib->date_fr($controle['DATEREGLMT']); ?></td>
                                <td ><?php echo $controle['MOIS']; ?></td>
                                <td ><?php echo $controle['MONTANT']; ?></td>
                                <td ><?php echo $controle['MT_VERSE']; ?></td>
                                <td ><?php echo $controle['MT_RELIQUAT']; ?></td>
                                <td ><?php echo $controle['libelle_paiement']; ?></td>
                              
                                  </tr>
                            <?php }
						   }?>
           
    </tbody>     
    </table>
      
                      
                    </div>
                        </div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
        
        

        <?php include('footer.php'); ?>