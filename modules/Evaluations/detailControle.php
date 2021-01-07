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
$lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));


$colname_rq_individu = "-1";
if (isset($_GET['IDCLASSROOM'])) {
  $colname_rq_individu = $lib->securite_xss(base64_decode($_GET['IDCLASSROOM']));
}
$colname_annee_rq_individu = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_annee_rq_individu = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_individu = $dbh->query("SELECT INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, INDIVIDU.IDINDIVIDU 
                                            FROM AFFECTATION_ELEVE_CLASSE, INDIVIDU 
                                            WHERE AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$colname_rq_individu." 
                                            AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            AND AFFECTATION_ELEVE_CLASSE.IDANNEESSCOLAIRE = ".$colname_annee_rq_individu);


$colname_rq_classe = "-1";
if (isset($_GET['IDCLASSROOM']))
{
  $colname_rq_classe = $lib->securite_xss(base64_decode($_GET['IDCLASSROOM']));
}

$query_rq_classe = $dbh->query("SELECT * FROM CLASSROOM WHERE IDCLASSROOM = ".$colname_rq_classe);
$row_rq_classe = $query_rq_classe->fetchObject();

$colname_rq_controle = "-1";
if (isset($_GET['IDCONTROLE']))
{
  $colname_rq_controle = $lib->securite_xss(base64_decode($_GET['IDCONTROLE']));
}

$query_rq_controle = $dbh->query("SELECT * FROM CONTROLE WHERE IDCONTROLE = ".$colname_rq_controle);
$row_rq_controle= $query_rq_controle->fetchObject();

?>

<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Evaluations</a></li>                    
                    <li>Gestion des controles</li>
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
                    
                    <?php if(isset($_GET['msg']) && $lib->securite_xss($_GET['msg'])!= ''){
				 
				  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])==1) { ?>

                              <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                                  <?php echo $_GET['msg']; ?>

                              </div>

						 <?php  } if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

						  <?php echo $lib->securite_xss($_GET['msg']); ?>

                          </div>

                          <?php } ?>
                 
			     <?php } ?>
                 
                 <div> <h4> Note du controle : <?php echo $row_rq_controle->LIBELLE_CONTROLE; ?> pour la classe : <?php echo $row_rq_classe->LIBELLE; ?></h4></div>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                  <th>MATRICULE</th>
                                  <th>PRENOMS</th>
                                   <th>NOM</th>
                                   <th>TEL</th>
                                  <th>NOTE</th>
                                  <th>ACTIONS</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                          <?php foreach($query_rq_individu->fetchAll() as $row_rq_individu)
                          {

							$colname_rq_note_etudiant = "-1";
							if (isset($_GET['IDCONTROLE'])) {
							  $colname_rq_note_etudiant = $lib->securite_xss(base64_decode($_GET['IDCONTROLE']));
							}
							
							$colname_individu_rq_note_etudiant = $row_rq_individu['IDINDIVIDU'];
							$query_rq_note_etudiant = $dbh->query("SELECT IDNOTE, NOTE FROM NOTE WHERE IDCONTROLE = ".$colname_rq_note_etudiant." AND NOTE.IDINDIVIDU=".$colname_individu_rq_note_etudiant);
							$row_rq_note_etudiant = $query_rq_note_etudiant->fetchObject();
							$note=$row_rq_note_etudiant->NOTE;
							$noteID=$row_rq_note_etudiant->IDNOTE;

							?>
     
        <tr >
          
          <td><?php echo $row_rq_individu['MATRICULE']; ?></td>
          <td ><?php echo $row_rq_individu['PRENOMS']; ?></td>
          <td ><?php echo $row_rq_individu['NOM']; ?></td>
          <td><?php echo $row_rq_individu['TELMOBILE']; ?></td>
          <td><?php echo $note == null ? 0 : $note; ?></td>
          <td>
              <button type="button" class="btn btn-primary btn-sm" data-id="<?php echo $noteID;?>" data-toggle="modal" data-target="#modifier"><i class="glyphicon glyphicon-pencil"></i>Modifier note</button>
          </td>

      
        </tr>
       
        <?php } ?>
           
    </tbody>     
    </table>
        <div class="btn-group col-lg-offset-5">
            <a href="gestionControle.php" class="btn btn-warning" role="button">RETOUR</a>
        </div>


    </div></div></div>
                    <!-- END WIDGETS -->

                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modifier" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center">Modification de la note du controle : <span id="label"></span> </h3>
                </div>
                <form action="misJourNote.php" method="POST" id="form" name="form" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prenoms" class="col-form-label">Prenoms:</label>
                                    <input type="text" class="form-control" id="prenoms" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom" class="col-form-label">Nom:</label>
                                    <input type="text" class="form-control" id="nom" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="note" class="col-form-label">Note:</label>
                                    <input type="number" class="form-control" id="note" name="" min="0" value="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="validControle" value="<?php echo base64_encode(1)?>">
                        <input type="hidden" id="idnote">
                        <input type="hidden" id="idIndiv" name="individu">
                        <input type="hidden" id="idcontrole" name="IDCONTROLE">
                        <input type="hidden" id="idclassroom" name="IDCLASSROOM">
                        <button type="submit" id="validerAj" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
<?php include('footer.php'); ?>

<script>
    $('#modifier').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var note = $('#note').attr("name")
        var ajaxResult = $.ajax({
            type: "POST",
            url: "request.php",
            data: {noteID: id}
        })
        ajaxResult.done(function (data) {
            var data = JSON.parse(data)

            $('#prenoms').val(data.PRENOMS)
            $('#nom').val(data.NOM)
            $('#note').val(data.NOTE)
            $('#label').text(data.LIBELLE_CONTROLE)
            $('#idnote').val(btoa(data.IDNOTE))
            $('#idIndiv').val(btoa(data.IDINDIVIDU))
            $('#idcontrole').val(btoa(data.IDCONTROLE))
            $('#idclassroom').val(btoa(data.IDCLASSROOM))
            $('#note').attr("name","note"+btoa(data.IDINDIVIDU))

        })

    })
</script>
