
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(8,$_SESSION['profil']));



$colname_rq_actu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_actu = $_SESSION['etab'];
}

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_annee = $_SESSION['ANNEESSCOLAIRE'];
}

$colname_classe=" ";
if(isset($_POST['IDCLASSROOM']) && $_POST['IDCLASSROOM']!=" " )
{
	$colname_classe="  AND ACTUALITES.IDCLASSROOM=".$_POST['IDCLASSROOM'];
}


$query_rq_actu = $dbh->query("SELECT * FROM ACTUALITES WHERE ACTUALITES.IDETABLISSEMENT = ".$colname_rq_actu.$colname_classe." AND ACTUALITES.IDANNEESSCOLAIRE = ".$colname_rq_annee);

$query_REQ_classe = $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = ".$colname_rq_actu);

$query_REQ_classe2 = $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = ".$colname_rq_actu);


?>


<?php include('header.php'); ?> 
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Journal de l'&eacute;cole</li>
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
                            <i class="fa fa-plus"></i> Nouvelle actualit&eacute;</button>
                            
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
                 
                 
                 <form id="form" name="form1" method="post" action="journalEcole.php" class="form-inline">
        <fieldset class="cadre"><legend> FILTRE</legend>
          
         
                    <div class="form-group col-lg-6">
                      <label for="exampleInputName2">Classe</label>
                     <select name="IDCLASSROOM" id="IDCLASSROOM" class="form-control selectpicker" data-live-search="true">
                     <option value="">--Selectionner--</option>
                          <?php foreach ($query_REQ_classe->fetchAll() as $class){ ?>
                              <option value="<?php echo $class['IDCLASSROOM']; ?>"  ><?php echo $class['LIBELLE']; ?></option>
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
                                     <th >DATE ACTUALITE</th>
                                     <th>TITRE ACTUALITE</th>
                                     <th>DESCRIPTION ACTUALITE</th>
                                     <th >Modifier</th>
                                     <th >Supprimer</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($query_rq_actu->fetchAll() as $actu){
                              
                                ?>
                            <tr>
        
                                <td ><?php echo $lib->date_fr($actu['DATE_ACTUALITE']); ?></td>
                                <td ><?php echo $actu['TITRE_ACTU']; ?></td>
                                <td ><?php echo $actu['DESCRIPTION_ACTU']; ?></td>
                                <td ><a href="modifActu.php?idActu=<?php echo $actu['IDACTUALITES']; ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                                <td ><a href="suppActu.php?idActu=<?php echo $actu['IDACTUALITES']; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
                                   </tr>
                            <?php }  ?>
           
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
        
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouvelle actualit&eacute; </h3> 
                </div>
                <form action="ajoutActu.php" method="POST">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >DATE ACTUALITE</label>
                                    <div>
                                        <input type="text" name="DATE_ACTUALITE" id="date_foo" required class="form-control"/>
                                    </div>
                                </div>
                            </div>


                            

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >TITRE ACTUALITE</label>
                                    <div>
                                        <input type="text" name="TITRE_ACTU" id="TITRE_ACTU" required class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-xs-12">
                                <div class="form-group">
                                    <label >DESCRIPTION ACTUALITE</label>
                                    <div>
                                        <textarea  name="DESCRIPTION_ACTU" id="mytextarea"  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-xs-12">
                                  <div class="form-group">
                                  <label>Classe</label>
                                 <div >
                                 <select name="IDCLASSROOM" id="IDCLASSROOM" class="form-control selectpicker" data-live-search="true">
                                 <option value="">--Selectionner--</option>
                                      <?php foreach ($query_REQ_classe2->fetchAll() as $class){ ?>
                                          <option value="<?php echo $class['IDCLASSROOM']; ?>"  ><?php echo $class['LIBELLE']; ?></option>
                                      <?php } ?>
                                  </select>
                            </div>
                            </div>
                            </div> 



                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $_SESSION['etab']; ?>" />
                        <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo $_SESSION['ANNEESSCOLAIRE']; ?>" />

                        
                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

       <?php include('footer.php');?>



