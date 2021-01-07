
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
$lib->Restreindre($lib->Est_autoriser(24,$_SESSION['profil']));


$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_classe = $_SESSION['etab'];
}


$query_rq_classe = $dbh->query("SELECT MOIS FROM FACTURE WHERE IDETABLISSEMENT = ".$colname_rq_classe." GROUP BY MOIS");



$cond="";
$titre="Les factures ";
if(isset($_POST['MOIS'])&& $_POST['MOIS']!='')
{
	$cond.=" AND FACTURE.MOIS='".$_POST['MOIS']."'";
	$titre.=" DU MOIS DE ".$lib->affiche_mois($_POST['MOIS']);
}

if(isset($_POST['MATRICULE'])&& $_POST['MATRICULE']!='')
{
	$cond.=" AND INDIVIDU.MATRICULE='".$_POST['MATRICULE']."'";
	$titre.=" DE MATRICULE  ".$_POST['MATRICULE'];
}
if(isset($_POST['DATE'])&& $_POST['DATE']!='')
{
	$cond.=" AND FACTURE.DATEREGLMT='".$_POST['DATE']."'";
	$titre.=" LA DATE DU  ".$lib->date_franc($_POST['DATE']);
}
if(isset($_POST['NOM'])&& $_POST['NOM']!='')
{
	$cond.=" AND INDIVIDU.NOM='".$_POST['NOM']."'";
	$titre.=" DONT LE NOM EST : ".$_POST['NOM'];
}
if(isset($_POST['PRENOMS'])&& $_POST['PRENOMS']!='')
{
	$cond.=" AND INDIVIDU.PRENOMS='".$_POST['PRENOMS']."'";
	$titre.=" DONT LE PRENOM EST : ".$_POST['PRENOMS'];
}
if(isset($_POST['ETAT'])&& $_POST['ETAT']!='')
{
	$cond.=" AND FACTURE.ETAT='".$_POST['ETAT']."'";
	$titre.="  NON PAYEES ";
	if($_POST['ETAT']==1)
	{
		$titre.="  PAYEES ";
	}
	
}


$colname_rq_liste_eveleve = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_liste_eveleve = $_SESSION['etab'];
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_liste_eveleve = $dbh->query("SELECT FACTURE.*, INSCRIPTION.*, INDIVIDU.* FROM INSCRIPTION, FACTURE, INDIVIDU WHERE FACTURE.IDETABLISSEMENT=".$colname_rq_liste_eveleve." AND FACTURE.IDINSCRIPTION= INSCRIPTION.IDINSCRIPTION AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU  AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_rq_anne." ".$cond." ORDER BY IDFACTURE DESC");





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
       <fieldset class="cadre"><legend> Filtre</legend>
     
        <div class="row">
        <div class="col-lg-12">
             <div class="col-lg-4">
                            
                                   <div class="col-lg-3"> <label class="control-label">MOIS</label></div>
                                    <div class="col-lg-9">
                                        <select  name="MOIS" id="MOIS"  class="form-control">
                                        <option value="">mois</option>
                                        <?php foreach($query_rq_classe->fetchAll() as $row){?>
                                        <option value="<?php echo $row['MOIS']; ?>" <?php //if($_POST['MOIS'] == $row['MOIS']) echo "selected"; ?>><?php echo $lib->affiche_mois($row['MOIS']); ?></option>
                                        <?php } ?>
                                       
                                        </select>
                                        
                                    </div>
                               
            </div>
            
             <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >DATE</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="DATE" id="date_foo"  class="form-control" value="<?php //echo $_POST['DATE']; ?>"/>
                                    </div>
                                </div>
            </div>
            <div class="col-lg-4">
                                <div class="form-group">
                                   <div class="col-lg-3"> <label >ETAT</label></div>
                                    <div class="col-lg-9">
                                        <select  name="ETAT" id="ETAT"  class="form-control">
                                        <option value="">ETAT DE PAYEMENT</option>
                                        <option value="1" <?php //if($_POST['ETAT'] == 1) echo "selected"; ?>>PAY&Eacute;E</option>
                                        <option value="0" <?php //if($_POST['ETAT'] == 0) echo "selected"; ?>>NON PAY&Eacute;E</option>
                                        </select>
                                    </div>
                                </div>
            </div>
          </div>
        </div><br>
        
        <div class="row">
         <div class="col-lg-12">
            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >MATRICULE</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="MATRICULE" id="MATRICULE"  class="form-control" value="<?php //echo $_POST['MATRICULE']; ?>"/>
                                    </div>
                                </div>
            </div>
            
             <div class="col-lg-4">
                                <div class="form-group">
                                   <div class="col-lg-3"> <label >PRENOMS</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="PRENOMS" id="PRENOMS"  class="form-control" value="<?php //echo $_POST['PRENOMS']; ?>"/>
                                    </div>
                                </div>
            </div>
            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="col-lg-3"><label >NOM</label></div>
                                    <div class="col-lg-9">
                                        <input type="text" name="NOM" id="NOM"  class="form-control" value="<?php //echo $_POST['NOM']; ?>"/>
                                    </div>
                                </div>
            </div>
        </div> 
        </div>
        
        <br>
               <div class="row">
            <div class="col-lg-offset-6 col-lg-1">
                                <div class="form-group">
                                    
                                    <div>
                                        <input type="submit" class="btn btn-success"  value="Envoyer"  />
                                    </div>
                                </div>
            </div>
            
             
        </div>
            
      </fieldset>
    </form>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                 <th>Matricule</th>
                                 <th>Pr&eacute;nom&amp;Nom </th>
                                 <th>Num&eacute;ro</th>
                                 <th>Mois</th>
                                 <th>Date facture</th>
                                 <th>Montant</th>
                                 <th>Montant vers&eacute;</th>
                                 <th>Montant restant</th>
                                 <th>Imprimer</th>
                                 <th>Payer</th>
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
      <td ><a href="../../ged/imprimer_facture.php?IDINDIVIDU=<?php echo $row_eleve['IDINDIVIDU'];?>&IDINSCRIPTION=<?php echo $row_eleve['IDINSCRIPTION'];?>&IDFACTURE=<?php echo $row_eleve['IDFACTURE'];?>"> <i class="glyphicon glyphicon-print"></i></a></td>
      <td ><?php if($row_eleve['ETAT']==0){ ?><a href="ficheMensualite.php?IDINDIVIDU=<?php echo $row_eleve['IDINDIVIDU'];?>&montant=<?php echo $row_eleve['MONTANT']?>&IDINSCRIPTION=<?php echo $row_eleve['IDINSCRIPTION'];?>&mois=<?php echo $row_eleve['MOIS']?>&IDFACTURE=<?php echo $row_eleve['IDFACTURE'];?>"><i class="glyphicon glyphicon-credit-card"></i></a>  <?php }?>
      <?php if($row_eleve['ETAT']==1){ ?>   <span style="color:#D3D3D3"><i class="glyphicon  glyphicon-credit-card"  ></i></span><?php }?></td>
      
                                    
  </tr>
  
 <!-- jula.php?montant1=<?php echo $row_eleve['MONTANT']?>&id=<?php echo $row_eleve['IDINDIVIDU']?>&mois=<?php echo $row_eleve['MOIS']?>&numfact=<?php echo $row_eleve['IDFACTURE'] ; ?>-->
                           <?php  } ?>
           
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