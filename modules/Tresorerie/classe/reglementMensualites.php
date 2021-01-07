
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
$lib->Restreindre($lib->Est_autoriser(28,$_SESSION['profil']));


$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_classe = $_SESSION['etab'];
}


$query_rq_classe = $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = ".$colname_rq_classe." ORDER BY LIBELLE ASC");



$cond_class=" ";
if(isset($_GET['classe']) && $_GET['classe']!="")
{
$cond_class="  AND CLASSROOM.IDCLASSROOM=".$_GET['classe'];
}
$colname_rq_liste_eveleve = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_liste_eveleve = $_SESSION['etab'];
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_liste_eveleve = $dbh->query("SELECT CLASSROOM.IDCLASSROOM, AFFECTATION_ELEVE_CLASSE.IDCLASSROOM, AFFECTATION_ELEVE_CLASSE.IDINDIVIDU, INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, INDIVIDU.PHOTO_FACE, INSCRIPTION.* FROM CLASSROOM, AFFECTATION_ELEVE_CLASSE, INDIVIDU, INSCRIPTION WHERE AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=CLASSROOM.IDCLASSROOM AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU  AND INDIVIDU.IDETABLISSEMENT=".$colname_rq_liste_eveleve." AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU ".$cond_class." AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_rq_anne);





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
                 
                 <form id="form" name="form1" method="get" action="" class="form-inline">
      <fieldset class="cadre"><legend> FILTRE</legend>
        
       
                  <div class="form-group col-lg-6">
                    <label for="exampleInputName2">Classe</label>
                   <select name="classe" id="classe" class="form-control" data-live-search="true">
                   <option value="">Choisir une classe </option>
                        <?php foreach ($query_rq_classe->fetchAll() as $row_rq_classe){ ?>
							<option value="<?php echo $row_rq_classe['IDCLASSROOM']; ?>"  <?php if($row_rq_classe['IDCLASSROOM']==$_GET['classe']) echo "selected"; ?>><?php echo $row_rq_classe['LIBELLE']; ?></option>
						<?php } ?>
                    </select>
                  </div> 
                  
                  
                   <div class="form-group col-lg-offset-1 col-lg-1">
                 
                  <button type="submit" class="btn btn-primary">Rechercher</button>
                  </div>
            
        </fieldset>
    </form>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>

                                <th>MATRICULE</th>
                                <th>PRENOMS</th>
                                 <th>NOM</th>
                                 <th>Montant total versé</th>
                                 <th>Total de la formation</th>
                                 <th>Reliquat total</th>
                                 <th>IMPRIMER</th>
                                 <th>Reglement</th>
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php 
	
	  foreach($query_rq_liste_eveleve->fetchAll() as $row_rq_liste_eveleve) { ?>
       <?php 
				  //echo $query_rq_inscription;
			//historique de la mensualite
			
$colname_rq_historique_mensulaite =$row_rq_liste_eveleve['IDINSCRIPTION'];
	
$query_rq_historique_mensulaite = $dbh->query("SELECT SUM(MENSUALITE.MT_VERSE) as somme FROM MENSUALITE WHERE IDINSCRIPTION =  ".$colname_rq_historique_mensulaite);

$row_rq_historique_mensulaite = $query_rq_historique_mensulaite->fetchObject();

			
		//	echo $query_rq_historique_mensulaite;
			// cout total de la formation
			//$colname_rq_cout_formation = $row_rq_liste_eveleve['IDSERIE'];
			
			//$idserie=$row_rq_liste_eveleve['IDNIVEAU'];
			
		
			$query_rq_cout_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE IDSERIE = ".$row_rq_liste_eveleve['IDSERIE']." AND NIVEAU_SERIE.IDNIVEAU=".$row_rq_liste_eveleve['IDNIVEAU']);
			
$row_rq_cout_formation = $query_rq_cout_formation->fetchObject();

$somme_frais=$row_rq_liste_eveleve['FRAIS_DOSSIER'] +$row_rq_liste_eveleve['FRAIS_EXAMEN']+$row_rq_liste_eveleve['UNIFORME']+$row_rq_liste_eveleve['VACCINATION']+ $row_rq_liste_eveleve['ASSURANCE']+ $row_rq_liste_eveleve['FRAIS_INSCRIPTION'] + $row_rq_liste_eveleve['FRAIS_SOUTENANCE'] ;
//
$total_formation=($row_rq_cout_formation->dure * $row_rq_liste_eveleve['ACCORD_MENSUELITE'] ) + $somme_frais;
//
$total_verse=$row_rq_liste_eveleve['ACCOMPTE_VERSE']+$row_rq_liste_eveleve['MONTANT_DOSSIER']+$row_rq_liste_eveleve['MONTANT_EXAMEN']+$row_rq_liste_eveleve['MONTANT_UNIFORME']+$row_rq_liste_eveleve['MONTANT_VACCINATION']+ $row_rq_liste_eveleve['MONTANT_ASSURANCE']+$row_rq_liste_eveleve['MONTANT_SOUTENANCE'] ;
//
//
//$total_formation=($row_rq_cout_formation->dure * $row_rq_liste_eveleve['ACCORD_MENSUELITE'] ) + $somme_frais;
$restant_formation= $total_formation - ($row_rq_historique_mensulaite->somme + $total_verse);
	  ?>
                            <tr>
        
      <td ><?php echo $row_rq_liste_eveleve['MATRICULE']; ?></td>
      <td ><?php echo $row_rq_liste_eveleve['PRENOMS']; ?></td>
      <td ><?php echo $row_rq_liste_eveleve['NOM']; ?></td>
      <td ><?php echo $lib->nombre_form($row_rq_historique_mensulaite->somme + $total_verse); ?></td>
      <td ><?php echo  $lib->nombre_form($total_formation);?></td>
      <td ><?php echo  $lib->nombre_form($restant_formation);?></td>
      <td ><a href="../../ged/imprimer_histo.php?IDINDIVIDU=<?php echo $row_rq_liste_eveleve['IDINDIVIDU']; ?>&amp;IDINSCRIPTION=<?php echo $row_rq_liste_eveleve['IDINSCRIPTION']; ?>"><i class="glyphicon glyphicon-print"></i></a></td>
       
      <td ><a href="ficheMensualite.php?IDINDIVIDU=<?php echo $row_rq_liste_eveleve['IDINDIVIDU']; ?>&amp;IDINSCRIPTION=<?php echo $row_rq_liste_eveleve['IDINSCRIPTION']; ?>"><i class="glyphicon glyphicon-list"></i></a></td>
                                    
                                  </tr>
                           <?php
		
		 }  ?>
           
    </tbody>     
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