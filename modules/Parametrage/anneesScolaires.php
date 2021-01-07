
<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(11,$lib->securite_xss($_SESSION['profil'])));

$colname_REQ_annee_scolaire = "-1";
if (isset($_SESSION['etab'])) {
  $colname_REQ_annee_scolaire = $lib->securite_xss($_SESSION['etab']);
}

$query_REQ_annee_scolaire = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, IDETABLISSEMENT, ETAT 
                                                  FROM ANNEESSCOLAIRE 
                                                  WHERE IDETABLISSEMENT = ".$colname_REQ_annee_scolaire);

?>


<?php include('../header.php'); ?>
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Ann&eacute;es scolaires</li>
                </ul>
                <!-- END BREADCRUMB -->             
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                    
                     <div class="panel panel-default">
                    <div class="panel-heading">
                        &nbsp;&nbsp;&nbsp;

                        <?php if(1 == 2){ ?>
                        <div class="btn-group pull-right">
							<button data-toggle="modal" data-target="#ajouter"  
                            style="background-color:#DD682B" class='btn dropdown-toggle', aria-hidden='true' >
                            <i class="fa fa-plus"></i> Nouvelle ann&eacute;e scolaire</button>
                            
                        </div>

                        <?php } ?>
                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						 <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						  <?php } ?>
                 
			     <?php } ?>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                    <th>ANN&Eacute;E SOCLAIRE</th>
                                    <th>DEBUT</th>
                                    <th>FIN</th>
                                    <th >Etat</th>
                                    <th >Modifier</th>
                                    <th >Details</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php
                            foreach ($query_REQ_annee_scolaire->fetchAll() as $annee){?>
                            <tr>
        
                                <td ><?php echo $annee['LIBELLE_ANNEESSOCLAIRE']; ?></td>
                                <td ><?php echo $lib->date_fr($annee['DATE_DEBUT']); ?></td>
                                <td ><?php echo $lib->date_fr($annee['DATE_FIN']); ?></td>
                                <td>
                                    <?php
                                    if($annee['ETAT'] !=0) {
                                        echo '<span class="badge badge-danger">CLOTRURÉE</span>';
                                    }else {
                                        echo '<span class="badge badge-success">EN COURS</span>';
                                    }
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    if($annee['ETAT'] !=0) {
                                        echo "<i class=\" glyphicon glyphicon-remove\" style='color:red;cursor: pointer'></i>";
                                    }else {
                                        echo '<a href="modifAnnee.php?idAnnee='.base64_encode($annee["IDANNEESSCOLAIRE"]).'"><i class=" glyphicon glyphicon-edit"></i></a>';
                                    }
                                    ;?>
                                </td>

                                <td ><a href="detailsAnnee.php?idAnnee=<?php echo base64_encode($annee['IDANNEESSCOLAIRE']) ; ?>"><i class="glyphicon glyphicon-list"></i></a></td>
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
                    <h3 class="panel-title text-center"> Nouvelle ann&eacute;e scolaire </h3> 
                    <!-- IDANNEESSCOLAIRE LIBELLE_ANNEESSOCLAIRE DATE_DEBUT DATE_FIN IDETABLISSEMENT -->
                </div>
                <form action="ajouterAnneeScolaire.php" method="POST">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                <label >LIBELLE</label>
                                <div>
                                    <input type="text" name="LIBELLE_ANNEESSOCLAIRE" id="LIBELLE_ANNEESSOCLAIRE" required class="form-control"/>
                                </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >DATE DEBUT</label>
                                    <div>
                                        <input type="text" id="date_foo" name="DATE_DEBUT"  required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >DATE FIN</label>
                                    <div>
                                        <input type="text" id="date_foo2" name="DATE_FIN"  required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>" />

                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
 <?php include('footer.php');?>



