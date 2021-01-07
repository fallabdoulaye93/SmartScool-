
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
$lib->Restreindre($lib->Est_autoriser(36,$lib->securite_xss($_SESSION['profil'])));


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

// idInscription=1249&IDSERIE=49&IDNIVEAU=2&IDINDIVIDU=11096

$IDINDIVIDU="";
if(isset($_GET['IDINDIVIDU'])&& $_GET['IDINDIVIDU']!="")
{
$IDINDIVIDU= $lib->securite_xss(base64_decode($_GET['IDINDIVIDU']) );
}

$idInscription="";
if(isset($_GET['idInscription'])&& $_GET['idInscription']!="")
{
$idInscription= $lib->securite_xss(base64_decode($_GET['idInscription']) );
}

$IDSERIE="";
if(isset($_GET['IDSERIE'])&& $_GET['IDSERIE']!="")
{
$IDSERIE= $lib->securite_xss(base64_decode($_GET['IDSERIE']) );
}

$IDNIVEAU="";
if(isset($_GET['IDNIVEAU'])&& $_GET['IDNIVEAU']!="")
{
$IDNIVEAU= $lib->securite_xss(base64_decode($_GET['IDNIVEAU']) );
}


$query_rq_etudiant = $dbh->query("SELECT INDIVIDU.*, INSCRIPTION.*,AFFECTATION_ELEVE_CLASSE.* from INDIVIDU, INSCRIPTION, AFFECTATION_ELEVE_CLASSE WHERE INSCRIPTION.IDINSCRIPTION = $idInscription AND INDIVIDU.IDINDIVIDU = INSCRIPTION.IDINDIVIDU AND INDIVIDU.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU");
$row_rq_mtinscription= $query_rq_etudiant->fetchObject();

//var_dump($row_rq_mtinscription);die();

$query_rq_niveau = $dbh->query("SELECT * FROM NIVEAU WHERE IDETABLISSEMENT = $colname_rq_individu");



$query_rq_filiere = $dbh->query("SELECT * FROM SERIE WHERE IDETABLISSEMENT = $colname_rq_individu");

$query_rq_classe = $dbh->query("SELECT * FROM CLASSROOM WHERE IDNIVEAU = ".$IDNIVEAU." AND CLASSROOM.IDSERIE=".$IDSERIE);
 
 



?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Historique inscription</li>
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
                 
                 <form id="form1" name="form1" method="post" action="updateInscription.php" >
                 
                <?php  
				//print_r($resultat);
				?>
               
                  
                   <div class="row">
                   
                   <div class="col-lg-12">
             <div class="form-group">
                 <div class="col-lg-2"> <label >FILIERE</label></div>
                  <div class="col-lg-4">
                  <select name="IDSERIE" id="IDSERIE" class="form-control" readonly>
                        <?php foreach ( $query_rq_filiere->fetchAll() as $filiere){ ?>
							<option value="<?php echo $filiere['IDSERIE']; ?>" <?php if($filiere['IDSERIE']==$IDSERIE) echo "selected";?>><?php echo $filiere['LIBSERIE']; ?></option>
						<?php } ?>
                    </select>
                  </div>
                  
                  <div class="col-lg-2"><label >NIVEAU</label></div>
                  <div class="col-lg-4">
                  <select name="IDNIVEAU" id="IDNIVEAU" class="form-control" readonly>
                         <?php foreach ( $query_rq_niveau->fetchAll() as $niveau){ ?>
							<option value="<?php echo $niveau['IDNIVEAU']; ?>" <?php if($niveau['IDNIVEAU']==$IDNIVEAU) echo "selected";?>><?php echo $niveau['LIBELLE']; ?></option>
						 <?php } ?>
                     </select>
                  </div>
             </div>
       </div><br><br>
       
       
        
        <div class="col-lg-12">
             <div class="form-group">
                   <div class="col-lg-2"><label >DATE D'INSCRIPTION</label></div>
                 
                  <div class="col-lg-10"> <input type="text" name="DATEINSCRIPT" id="date_foo"  class="form-control" value="<?php echo date("Y-m-d")?>"/>
                 </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                   <div class="col-lg-2"><label >MONTANT DE LA MENSUALITE</label></div>
                   <div class="col-lg-10">
                  <input type="text" name="MONTANT" id="MONTANT"  class="form-control" value="<?php echo $row_rq_mtinscription->MONTANT; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >FRAIS INSCRIPTION</label></div>
                 
                 <div class="col-lg-10"> <input type="text" name="FRAIS_INSCRIPTION" id="FRAIS_INSCRIPTION"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_INSCRIPTION; ?>"/>
                 </div>
                
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >ACCOMPTE VERSE</label></div>
                  <div class="col-lg-10">
                  <input type="text" name="ACCOMPTE_VERSE" id="ACCOMPTE_VERSE"  class="form-control" value="<?php echo $row_rq_mtinscription->ACCOMPTE_VERSE; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >ACCORD MENSUALITE</label></div>
                  <div class="col-lg-10">
                  <input type="text" name="ACCORD_MENSUELITE" id="ACCORD_MENSUELITE"  class="form-control" value="<?php echo $row_rq_mtinscription->ACCORD_MENSUELITE; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >DERNIER ETABLISSEMENT FREQUENTEE</label></div>
                  <div class="col-lg-10">
                  <input type="text" name="DERNIER_ETAB" id="DERNIER_ETAB"  class="form-control" value="<?php echo $row_rq_mtinscription->DERNIER_ETAB; ?>"/>
                  </div>
             </div>
       </div><br><br>
       <div class="col-lg-12">
           <div class="form-group">
               <div class="col-lg-2"><label >UNIFORME</label></div>
               <div class="col-lg-4">
                   <input type="text" name="UNIFORME" id="UNIFORME"  class="form-control" value="<?php echo $row_rq_mtinscription->UNIFORME; ?>" />
               </div>

               <div class="col-lg-2"><label >MONTANT VERSE</label></div>
               <div class="col-lg-4">
                   <input type="text" name="MONTANT_UNIFORME" id="MONTANT_UNIFORME"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_UNIFORME; ?>"/>
               </div>

           </div>
       </div><br><br>

       <div class="col-lg-12">
           <div class="form-group">
               <div class="col-lg-2"><label >TRANSPORT</label></div>
               <div class="col-lg-4">
                   <input type="text" name="TRANSPORT" id="TRANSPORT"  class="form-control" value="<?php echo $row_rq_mtinscription->TRANSPORT; ?>" />
               </div>

               <div class="col-lg-2"><label >MONTANT VERSE</label></div>
               <div class="col-lg-4">
                   <input type="text" name="MONTANT_TRANSPORT" id="MONTANT_TRANSPORT"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_TRANSPORT; ?>"/>
               </div>

           </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >FRAIS DOSSIER</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="FRAIS_DOSSIER" id="FRAIS_DOSSIER"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_DOSSIER; ?>" />
                  </div>
                  
                  <div class="col-lg-2"><label >MONTANT VERSE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_DOSSIER" id="MONTANT_DOSSIER"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_DOSSIER; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
       <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >FRAIS EXAMEN</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="FRAIS_EXAMEN" id="FRAIS_EXAMEN"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_EXAMEN; ?>" />
                  </div>
                  
                  <div class="col-lg-2"><label >MONTANT VERSE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_EXAMEN" id="MONTANT_EXAMEN"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_EXAMEN; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
      
       <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >VACCINATION</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="VACCINATION" id="VACCINATION"  class="form-control" value="<?php echo $row_rq_mtinscription->VACCINATION; ?>"/>
                  </div>
                  
                  <div class="col-lg-2"><label >MONTANT VERSE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_VACCINATION" id="MONTANT_VACCINATION"  class="form-control" value="<?php echo $row_rq_mtinscription->MONTANT_VACCINATION; ?>" />
                  </div>
             </div>
       </div><br><br>
       
       <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >ASSURANCE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="ASSURANCE" id="ASSURANCE"  class="form-control" value="<?php echo $row_rq_mtinscription->ASSURANCE; ?>"/>
                  </div>
                  
                  <div class="col-lg-2"><label >MONTANT VERSE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_ASSURANCE" id="MONTANT_ASSURANCE"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_ASSURANCE; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
       <div class="col-lg-12">
             <div class="form-group">
                 <div class="col-lg-2"> <label >FRAIS SOUTENANCE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="FRAIS_SOUTENANCE" id="FRAIS_SOUTENANCE"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_SOUTENANCE; ?>"/>
                  </div>
                  
                  <div class="col-lg-2"><label >MONTANT VERSE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_SOUTENANCE" id="MONTANT_SOUTENANCE"  class="form-control" value="<?php echo $row_rq_mtinscription->MONTANT_SOUTENANCE; ?>" />
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >CLASSE</label></div>
                  <div class="col-lg-10">
                  <select  id="classe" name="classe" class="form-control">
                  <?php
             foreach($query_rq_classe->fetchAll() as  $rq_classe  ) {  ?>
                  <option value="<?php echo $rq_classe['IDCLASSROOM']?>" <?php if($row_rq_mtinscription->IDCLASSROOM==$rq_classe['IDCLASSROOM']) echo "selected"; ?>><?php echo $rq_classe['LIBELLE']?></option>
                  <?php } ?>
                </select>
                  </div>
             </div>
       </div><br><br>
       
      
        
        <input type="hidden" name="STATUT" value="" />
        <input type="hidden" name="IDINDIVIDU" value="<?php echo $_GET['IDINDIVIDU']; ?>" />
        <input type="hidden" name="IDINSCRIPTION" value="<?php echo $_GET['idInscription']; ?>" />
        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo base64_encode($_SESSION['etab']) ;?>" />
        <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo base64_encode($_SESSION['ANNEESSCOLAIRE']) ;?>" />
         <input type="hidden" name="IDAFFECTATION" value="<?php echo base64_encode($row_rq_mtinscription->IDAFFECTATTION_ELEVE_CLASSE) ;?>" />
        <input type="hidden" name="VALIDETUDE" value="" />
        <input type="hidden" name="RESULTAT_ANNUEL" value="" />
        <div class="col-lg-offset-9 col-lg-1"> <input name="" type="submit" value="S'inscrire" class="btn btn-success"/> </div>
        
      </div> 
     
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