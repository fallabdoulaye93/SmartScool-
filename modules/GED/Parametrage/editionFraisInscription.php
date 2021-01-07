
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(7, $lib->securite_xss($_SESSION['profil'])));

$colname_Rq_frais_inscription = "-1";
if (isset($_SESSION['etab'])) {
  $colname_Rq_frais_inscription = $lib->securite_xss($_SESSION['etab']);
}

$query_Rq_frais_inscription = $dbh->query("SELECT NIVEAU_SERIE.MT_MENSUALITE, NIVEAU_SERIE.FRAIS_INSCRIPTION, NIVEAU.IDNIVEAU, NIVEAU.LIBELLE, SERIE.LIBSERIE, 
                                                     NIVEAU_SERIE.dure, NIVEAU_SERIE.montant_total, NIVEAU_SERIE.ID_NIV_SER, NIVEAU_SERIE.FRAIS_DOSSIER, NIVEAU_SERIE.VACCINATION, 
                                                     NIVEAU_SERIE.UNIFORME, NIVEAU_SERIE.ASSURANCE, NIVEAU_SERIE.FRAIS_EXAMEN, NIVEAU_SERIE.FRAIS_SOUTENANCE 
                                                     FROM NIVEAU_SERIE, NIVEAU, SERIE 
                                                     WHERE NIVEAU_SERIE.IDETABLISSEMENT = ".$colname_Rq_frais_inscription." 
                                                     AND NIVEAU.IDNIVEAU = NIVEAU_SERIE.IDNIVEAU 
                                                     AND NIVEAU_SERIE.IDSERIE = SERIE.IDSERIE 
                                                     ORDER BY MT_MENSUALITE ASC");

?>


<?php include('../header.php'); ?>
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Parametrage</a></li>                    
                    <li>Frais inscription</li>
                </ul>
                <!-- END BREADCRUMB -->             
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                    
                     <div class="panel panel-default">

                    <div class="panel-heading">
                       <span  style="color:#DD682B; font-size:18px"> Les frais de scolarite et mensualites</span>

                        <div class="btn-group pull-right">
                        </div>

                    </div>

                    <div class="panel-body">

                        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
                          if(isset($_GET['res']) && $_GET['res']==1) { ?>

                                  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                  <?php echo $lib->securite_xss($_GET['msg']); ?>

                                  </div>

                                 <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                                  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                  <?php echo $lib->securite_xss($_GET['msg']); ?>

                                  </div>

                                  <?php } ?>

                         <?php } ?>
              
                    </div>


                     </div>

                    </div>
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
                    <h3 class="panel-title text-center"> Nouvelle filiere </h3>
                </div>
                <form action="ajouterProfil.php" method="POST">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                <label >PROFIL</label>
                                <div>
                                    <input type="text" name="profil" id="profil" required class="form-control"/>
                                </div>
                                </div>
                            </div>
                            
                            
                            

                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">Réinitialiser</button>
                        <input type="hidden" name="userCreation" value="<?php echo $_SESSION['idUser']; ?>" />
                        <input type="hidden" name="dateCreation" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                        <input type="hidden" name="userModification" value="0" />
                        <input type="hidden" name="dateModification" value="<?php echo  $_SESSION['idUser']; ?>" />
                        
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

       <?php include('footer.php');?>



