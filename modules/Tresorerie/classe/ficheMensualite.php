
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
$lib->Restreindre($lib->Est_autoriser(26,$_SESSION['profil']));


$colname_rq_mensualite = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_mensualite = $_SESSION['etab'];
}

$idIndividu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $idIndividu = $_GET['IDINDIVIDU'];
}

$montant = "-1";
if (isset($_GET['montant'])) {
  $montant = $_GET['montant'];
}

$lemois = "-1";
if (isset($_GET['mois'])) {
  $lemois = $_GET['mois'];
}

$colname_rq_inscription = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_inscription = $_GET['IDINSCRIPTION'];
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}


$query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = $idIndividu");
$rq_individu = $query_rq_individu->fetchObject();


$query_type_payement = $dbh->query("SELECT * FROM TYPE_PAIEMENT");

$query_rq_inscription = $dbh->query("SELECT INSCRIPTION.*, NIVEAU.LIBELLE, SERIE.LIBSERIE FROM INSCRIPTION, NIVEAU, SERIE WHERE INSCRIPTION.IDINSCRIPTION = ".$colname_rq_inscription." AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU AND INSCRIPTION.IDSERIE=SERIE.IDSERIE AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_rq_anne);

$row_rq_inscription = $query_rq_inscription->fetchObject();

//echo $query_rq_inscription;
//historique de la mensualite
$colname_rq_historique_mensulaite = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_historique_mensulaite = $_GET['IDINSCRIPTION'];
}

$query_rq_historique_mensulaite = $dbh->query("SELECT * FROM MENSUALITE WHERE IDINSCRIPTION = ".$colname_rq_historique_mensulaite." AND IDETABLISSEMENT = ".$colname_rq_mensualite." ORDER BY IDMENSUALITE ASC");




//echo $query_rq_historique_mensulaite;
// cout total de la formation
if($row_rq_inscription->IDSERIE!=NULL or  $row_rq_inscription->IDNIVEAU!=NULL)
{
$colname_rq_cout_formation = $row_rq_inscription->IDSERIE;

$query_rq_cout_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE NIVEAU_SERIE.IDSERIE = ".$colname_rq_cout_formation." AND NIVEAU_SERIE.IDNIVEAU=".$row_rq_inscription->IDNIVEAU);
//echo $query_rq_cout_formation;

$row_rq_cout_formation = $query_rq_cout_formation->fetchObject();

}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	 $montant = $lib->securite_xss($_GET['montant']);
       
         $etat=1;
         $requat=0;
		 $facture=$_GET['IDFACTURE'];
	
	 $query = sprintf("UPDATE FACTURE SET FACTURE.MT_VERSE =:MT_VERSE,FACTURE.ETAT=:ETAT ,FACTURE.MT_RELIQUAT=:MT_RELIQUAT 
		WHERE FACTURE.IDFACTURE=:fature");
								$result = $dbh->prepare($query);
								$result->bindParam("MT_VERSE",$montant);
								$result->bindParam("ETAT",$etat);
								$result->bindParam("MT_RELIQUAT",$requat);
								$result->bindParam("fature", $facture);
								$count = $result->execute();
								if($count==1){
									$msg="Facture payee avec succes";
									$res="1";
									
									}
								else{
									$msg="Paiement echouee";
									$res="-1";
									
									}
								 
								 
  //$mois=$lib->Le_mois($_POST['MOIS'])." / ".$_POST['anne'];
   $mois=$lib->Le_mois(substr($_POST['MOIS'],0,2))." / ".substr($_POST['MOIS'],3,4);
   $numtransaction= $lib->genererNumTransaction($_SESSION['PREFIXE']);
  

  $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE ( MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,id_type_paiment,numtransac) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:id_type_paiment,:numtransac)");
  $insertSQL->execute(array(
    "MOIS" => $mois,
    "MONTANT" => $_POST['MONTANT'],
    "DATEREGLMT" => $_POST['DATEREGLMT'],
	"IDINSCRIPTION" => $_POST['IDINSCRIPTION'],
    "IDETABLISSEMENT" => $_POST['IDETABLISSEMENT'],
    "MT_VERSE" => $_POST['MT_VERSE'],
	"MT_RELIQUAT" => $_POST['MT_RELIQUAT'],
    "id_type_paiment" => $_POST['id_type_paiment'],
	"numtransac"=>$numtransaction
));
  
  
  $colname_rq_max_mensualite = "-1";
if (isset($_POST['IDINSCRIPTION'])) {
  $colname_rq_max_mensualite = $_POST['IDINSCRIPTION'];
}

$query_rq_max_mensualite = $dbh->query("SELECT MAX(MENSUALITE.IDMENSUALITE) as nb FROM MENSUALITE WHERE MENSUALITE.IDINSCRIPTION=".$colname_rq_max_mensualite);

$row_rq_max_mensualite = $query_rq_max_mensualite->fetchObject();



$query_rq_paiement = $dbh->query("SELECT * FROM TYPE_PAIEMENT");

$row_rq_paiement = $query_rq_paiement->fetchObject();


    //$insertGoTo = "../../ged/imprimer_recu.php?IDINDIVIDU=".$_POST['IDINDIVIDU']."&IDMENSUALITE=".$row_rq_max_mensualite->nb;

 
 header("Location: facturation.php?msg=$msg&res=$res");
}

$somme_frais= $row_rq_inscription->FRAIS_INSCRIPTION+$row_rq_inscription->FRAIS_DOSSIER+$row_rq_inscription->FRAIS_EXAMEN+$row_rq_inscription->UNIFORME+ $row_rq_inscription->VACCINATION+ $row_rq_inscription->ASSURANCE+$row_rq_inscription->FRAIS_SOUTENANCE ;
$cout_total_formation=($row_rq_inscription->ACCORD_MENSUELITE * $row_rq_cout_formation->dure) + $somme_frais;

$total_verse=$row_rq_inscription->ACCOMPTE_VERSE+$row_rq_inscription->MONTANT_DOSSIER+$row_rq_inscription->MONTANT_EXAMEN+$row_rq_inscription->MONTANT_UNIFORME+$row_rq_inscription->MONTANT_VACCINATION+ $row_rq_inscription->MONTANT_ASSURANCE+$row_rq_inscription->MONTANT_SOUTENANCE ;


$visibe=" ";



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
                 
                 <fieldset class="cadre"><legend> Infos personnelles</legend>
     
        <div class="row">
            <div class="form-group col-lg-4">
                   <label >MATRICULE: </label>&nbsp;&nbsp;
                     <?php echo $rq_individu->MATRICULE; ?>
            </div>
             <div class="form-group col-lg-4">
                   <label >PRENOMS: </label>&nbsp;&nbsp;
                     <?php echo $rq_individu->PRENOMS; ?>
              </div>
            
            <div class="form-group col-lg-4">
                  <label >NOM: </label>&nbsp;&nbsp;
                   <?php echo $rq_individu->NOM; ?>
              </div> 
        </div>
        
        <div class="row">
             <div class="form-group col-lg-4">
                  <label >FILIERE: </label>&nbsp;&nbsp;
                  
                    <?php echo $row_rq_inscription->LIBSERIE; ?>
              </div>  
              <div class="form-group col-lg-4">
                  <label >NIVEAU: </label>&nbsp;&nbsp;
                  <?php echo $row_rq_inscription->LIBELLE; ?>
              </div> 
               <div class="form-group col-lg-4">
                    <label >TELMOBILE: </label>&nbsp;&nbsp;
                    <?php echo $rq_individu->TELMOBILE; ?>
                </div>
            
        </div>
            
      </fieldset>
      
      <div class="row">
      <div class="col-lg-6">
      
      <fieldset class="cadre"><legend > HISTORIQUE DES PAYEMENTS</legend>
       
  <table  class="table table-bordered table-striped table-responsive">
    <tr >
     
      <th>Date </th>
      <th>Mois</th>
      <th>Montant</th>
      <th>Reliquat</th>
      <th>Modifier</th>
      <th>Supprimer</th>
      <th>Imprimer</th>
      </tr>
    <?php
          
		  // $cout_verse_formation=0;
		   $monatnt_paye=0;
	  foreach(  $query_rq_historique_mensulaite->fetchAll() as $row_rq_historique_mensulaite) { 
	      $monatnt_paye=$monatnt_paye +  $row_rq_historique_mensulaite['MT_VERSE'];
	       
	  ?>
    <tr >
    
      <td><?php echo $lib->date_franc($row_rq_historique_mensulaite['DATEREGLMT']); ?></td>
      <td><?php echo $row_rq_historique_mensulaite['MOIS']; ?></td>
      <td><?php echo $lib->nombre_form($row_rq_historique_mensulaite['MT_VERSE']); ?></td>
      <td><?php echo $lib->nombre_form($row_rq_historique_mensulaite['MT_RELIQUAT']); ?></td>
      <td><a href="modif_mensulalite.php?IDINDIVIDU=<?php echo $rq_individu->IDINDIVIDU; ?>&amp;IDMENSUALITE=<?php echo $row_rq_historique_mensulaite['IDMENSUALITE']; ?>&amp;IDINSCRIPTION=<?php echo $row_rq_historique_mensulaite['IDINSCRIPTION']; ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
      <td><a href="sup_mensulalite.php?IDINDIVIDU=<?php echo $rq_individu->IDINDIVIDU; ?>&amp;IDMENSUALITE=<?php echo $row_rq_historique_mensulaite['IDMENSUALITE']; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
      <td><a href="../../ged/imprimer_recu.php?IDINDIVIDU=<?php echo $rq_individu->IDINDIVIDU; ?>&amp;IDMENSUALITE=<?php echo $row_rq_historique_mensulaite['IDMENSUALITE']; ?>"><i class=" glyphicon glyphicon-print"></i></a></td>
      </tr>
       <?php } ?>
   </table> 
    
 <table width="100%" height="41" border="0" cellpadding="2" cellspacing="2">
 <tr >
      <th>cout total </th>
      <th>Total vers&eacute;</th>
      <th>Restant total</th>
      </tr>
            
                <tr>
                  <td><?php echo $lib->nombre_form($cout_total_formation);?></td>
                  
                  <td><?php echo $lib->nombre_form($total_verse + $monatnt_paye);?></td>
                 
                  <td ><?php echo $lib->nombre_form($cout_total_formation - ($total_verse + $monatnt_paye))?></td>
                  </tr>
                
          </table>
        </fieldset>
        </div>
        
        <div class="col-lg-6">
        
          <form action="" method="post" name="form1" id="form1">
                    
        <fieldset class="cadre"><legend > EMETTRE UN REGLEMENT</legend>
        <div class="row">
        <div class="col-lg-4">
         <label for="MOIS" class="control-label">MOIS</label>
         <input type="text" name="MOIS" id="MOIS" readonly value="<?php  echo $lemois;?>" class="form-control"/>
        </div>
        <div class="col-lg-4">
           <label for="DATEREGLMT" class="control-label">DATE REGLEMENT</label>
           <input name="DATEREGLMT" type="text" class="form-control" id="date_foo" value="<?php echo date('Y-m-d');?>"   />
                </div>
              
              
         </div>
                
             <div class="row">
            <div class="col-lg-4">
               <label for="MONTANT" class="control-label">MONTANT</label>
                <input name="MONTANT" id="MONTANT" type="text" class="form-control" value="<?php echo $montant; ?>"  />
            </div>
              
              <div class="col-lg-4">
               <label for="MT_VERSE" class="control-label">MONTANT VERSE</label>
              <input name="MT_VERSE" id="MT_VERSE" type="number" min="0" max="<?php echo $montant; ?>" class="form-control"  onBlur="mont_reliquat();"/>
              </div>
              
              <div class="col-lg-4">
              
             <label for="MT_RELIQUAT">MONTANT RELIQUAT</label>  
            <input name="MT_RELIQUAT" type="number" id="MT_RELIQUAT" class="form-control"  onclick="mont_reliquat();"  onchange="mont_reliquat();"/>
            </div>
            </div>
            
            <div class="row">
            <div class="col-lg-4">
            <label for="id_type_paiment" class="control-label">MODE PAYEMENT</label>  
                <select name="id_type_paiment" class="form-control">
                  <option value="" disabled="disabled" selected="selected">choisir</option>
                  <?php foreach($query_type_payement->fetchAll() as $row_type_payement) {?>
                  <option value="<?php echo $row_type_payement['id_type_paiment'];?>"><?php echo $row_type_payement['libelle_paiement'];?></option>
                 
                  <?php }?>
                </select>
                </div>
                <div class="col-lg-4">
               <br>
             <input  type="submit"  class="btn btn-success" value="Payer la mensualit&eacute;"  />
             </div></div>
        </fieldset>
        <input type="hidden" name="IDMENSUALITE" value="" />
        <input type="hidden" name="IDINSCRIPTION" value="<?php echo $_GET['IDINSCRIPTION'];?>" />
         <input type="hidden" name="IDINDIVIDU" value="<?php echo $_GET['IDINDIVIDU'];?>" />
        <input type="hidden" name="IDETABLISSEMENT" value="<?php  echo $_SESSION['etab'];?>" />
        
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
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


        <?php include('footer.php'); ?>