
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
$lib->Restreindre($lib->Est_autoriser(37,$lib->securite_xss($_SESSION['profil'])));

require_once('classe/ProfileManager.php');
$profiles=new ProfileManager($dbh,'profil');
$profil = $profiles->getProfiles();


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname_niveau_rq_individu = "-1";
if (isset($_GET['IDNIVEAU'])) {
  $colname_niveau_rq_individu = $lib->securite_xss(base64_decode($_GET['IDNIVEAU'])) ;
}
$colname_serie_rq_individu = "-1";
if (isset($_GET['IDSERIE'])) {
  $colname_serie_rq_individu = $lib->securite_xss(base64_decode($_GET['IDSERIE']));
}
$colanne_rq_annee = "-1";
if (isset($_GET['ANNEESSCOLAIRE']) && $_GET['ANNEESSCOLAIRE'] != null) {
  $colanne_rq_annee = $lib->securite_xss(base64_decode($_GET['ANNEESSCOLAIRE']));
}

$query_rq_individu = $dbh->query("SELECT INSCRIPTION.DATEINSCRIPT, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, INDIVIDU.DATNAISSANCE, 
                                            INDIVIDU.IDINDIVIDU, INDIVIDU.PHOTO_FACE, INSCRIPTION.IDINSCRIPTION, INSCRIPTION.ETAT, CLASSROOM.LIBELLE 
                                            FROM INSCRIPTION, INDIVIDU, AFFECTATION_ELEVE_CLASSE, CLASSROOM 
                                            WHERE INSCRIPTION.IDNIVEAU = ".$colname_niveau_rq_individu." 
                                            AND INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            AND CLASSROOM.IDCLASSROOM = AFFECTATION_ELEVE_CLASSE.IDCLASSROOM 
                                            AND INSCRIPTION.IDSERIE = ".$colname_serie_rq_individu." 
                                            AND INSCRIPTION.IDANNEESSCOLAIRE = ".$colanne_rq_annee);

?>


<?php include('../header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">PARAMETRAGES</a></li>
                    <li>Historique inscription</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                    
                     <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 style="color:#DD682B"> Les etudiants inscrits en cycle <?php echo $lib->securite_xss(base64_decode($_GET['NIVEAU'])); ?>  </h3>

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
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>

                                <th>MATRICULE</th>
                                <th>PRENOMS</th>
                                 <th>NOM</th>
                                 <th>DATE DE NAISSANCE</th>
                                <th>CLASSE</th>
                                 <th>ETAT INSCRIPTION</th>

                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                               <?php foreach ($query_rq_individu->fetchAll() as $individu){ ?>
                                <tr>

                                    <td ><?php echo $individu['MATRICULE']; ?></td>
                                    <td ><?php echo $individu['PRENOMS']; ?></td>
                                    <td ><?php echo $individu['NOM']; ?></td>
                                    <td ><?php echo $lib->date_fr($individu['DATNAISSANCE']); ?></td>
                                    <td ><?php echo $individu['LIBELLE']; ?></td>
                                    <td>

                                        <?php if ($individu['ETAT'] == 1) {
                                            echo "<span class='badge badge-success'>VALIDE</span>";
                                        }
                                        else {
                                            echo "<span class='badge badge-danger'>ANNULÉ</span>";
                                        }
                                        ?>

                                    </td>

                                </tr>
                                <?php }  ?>
                            </tbody>
                     </table>
                        <div class="row">
                            <div class="col-md-10">
                                <a role="button" href="detailsAnnee.php?idAnnee=<?php echo $lib->securite_xss($_GET['ANNEESSCOLAIRE']); ?>" class="btn btn-primary">RETOUR</a>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="annulation" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center">ANNULATION DE L'INSCRIPTION:</h3>
                </div>
                <form action="cancelInscription.php" method="POST" id="form" name="form" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="matricule" class="col-form-label">Matricule:</label>
                                    <input type="text" class="form-control" id="matricule" readonly>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="prenoms" class="col-form-label">Prenoms:</label>
                                    <input type="text" class="form-control" id="prenoms" readonly>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="nom" class="col-form-label">Nom:</label>
                                    <input type="text" class="form-control" id="nom" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="motif" class="col-form-label">Motif:</label>
                                    <textarea name="motif" id="MOTIF" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" id="idInscription" name="IDINSCRIPTION">
                        <input type="hidden" id="idSerie" name="IDSERIE" value="<?php echo $lib->securite_xss($_GET['IDSERIE']);?>">
                        <input type="hidden" id="idNiveau" name="IDNIVEAU" value="<?php echo $lib->securite_xss($_GET['IDNIVEAU']);?>">
                        <input type="hidden" id="idLibSerie" name="LIBSERIE" value="<?php echo $lib->securite_xss($_GET['LIBSERIE']);?>">
                        <input type="hidden" id="idLibelle" name="NIVEAU" value="<?php echo $lib->securite_xss($_GET['NIVEAU']);?>">
                        <button type="submit" id="validBtn" class="btn btn-primary pull-right">VALIDER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>

<script>
    $('#annulation').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget)
        var id = link.data('id')
        var ajaxResult = $.ajax({
            type: "POST",
            url: "requestCancelInscription.php",
            data: {
                IDINSCRIPTION: btoa(id)
            }
        })
        ajaxResult.done(function (data) {
            var data = JSON.parse(data)
            $('#matricule').val((data.MATRICULE).toString())
            $('#prenoms').val(data.PRENOMS)
            $('#nom').val(data.NOM)
            $('#idInscription').val(btoa(data.IDINSCRIPTION))
        })
    })
</script>
