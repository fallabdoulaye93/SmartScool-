<?php
include('header.php');

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

$query = "SELECT cl.IDCLASSROOM as idclass,cl.LIBELLE as libclass
          FROM CLASSROOM cl
          INNER JOIN CLASSE_ENSEIGNE ce ON cl.IDCLASSROOM = ce.IDCLASSROM
          INNER JOIN RECRUTE_PROF r on ce.IDRECRUTE_PROF = r.IDRECRUTE_PROF
          WHERE r.IDINDIVIDU = ".$_SESSION['id'] ;
$stmt = $dbh->prepare($query);
$stmt->execute();
$tabClass = $stmt->fetchAll(PDO::FETCH_OBJ);

$query = "SELECT document_prof.iddoc,document_prof.nomdoc,document_prof.libelle,document_prof.datedoc,document_prof.nom_fichier as nomfichier,affecter_doc.idaff,CLASSROOM.LIBELLE as libclass
          FROM document_prof
          INNER JOIN affecter_doc ON document_prof.iddoc = affecter_doc.iddoc
          INNER JOIN CLASSROOM ON affecter_doc.idclasse = CLASSROOM.IDCLASSROOM
          WHERE document_prof.idprof = ".$_SESSION['id'] ;
$stmt = $dbh->prepare($query);
$stmt->execute();
$tabMsgRecu = $stmt->fetchAll(PDO::FETCH_OBJ);
//echo "<pre>";var_dump($tabDoc);exit;
?>
    <style>
        .panel-body {
            background:#FFFFFF;}
    </style>
<ul class="breadcrumb">
    <li><a href="#"> PROFESSEUR </a></li>
    <li class="active"> Mes documents</li>
</ul>
<div class="row">
    <div class="col-lg-offset-10 col-lg-1">
        <button class="btn btn-success" data-toggle="modal" href="#modal-add-doc" value="modifier">
            Ajouter document
        </button>
    </div>
</div>
<div class="row">
    <div class="panel-body">
        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
		    if(isset($_GET['res']) && $_GET['res']==1)  {?>
			    <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?= $_GET['msg']; ?>
			    </div>
		    <?php  }
		    if(isset($_GET['res']) && $_GET['res']!=1)  {?>
			    <div class="alert alert-danger">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?= $_GET['msg']; ?>
			    </div>
		    <?php } ?>
	    <?php } ?>
	    <table id="customers2" class="table datatable table-striped">
            <thead>
            <tr>
                <th width="15%">Nom document</th>
                <th width="25%">Libellé</th>
                <th width="20%">Classe</th>
                <th width="20%">Date</th>
                <th width="20%" style="text-align: center;">Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if(isset($tabMsgRecu) && count($tabMsgRecu)>0){
                    foreach ($tabMsgRecu as $oneDoc){ ?>
                    <tr>
                        <td><?= $oneDoc->nomdoc; ?></td>
                        <td><?= $oneDoc->libelle; ?></td>
                        <td><?= $oneDoc->libclass; ?></td>
                        <td><?= $lib->date_time_fr($oneDoc->datedoc); ?></td>
                        <td style="text-align: center;">
                            <a href="#" class="mb-control" data-box="#sup-doc-<?= $oneDoc->idaff; ?>">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <!-- MESSAGE BOX-->
                    <div class="message-box animated fadeIn" data-sound="alert" id="sup-doc-<?= $oneDoc->idaff; ?>">
                        <div style="background-color: darkred;" class="mb-container">
                            <div class="mb-middle">
                                <div class="mb-title"><span class="fa fa-trash"></span><strong>Suppression</strong> ?</div>
                                <div class="mb-content">
                                    <p>Etes vous sur de vouloir supprimer ce document ?</p>
                                </div>
                                <div class="mb-footer">
                                    <div class="pull-right">
                                        <a href="supprimerDocument.php?idDoc=<?= $oneDoc->iddoc; ?>&idAff=<?= $oneDoc->idaff; ?>&nomFichier=<?= $oneDoc->nomfichier; ?>" class="btn btn-warning btn-lg">Oui</a>
                                        <button class="btn btn-default btn-lg mb-control-close">Non</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END MESSAGE BOX-->
                <?php }
                }
            ?>
            </tbody>
        </table>
    </div>
    <form class="form-modal" action="enregistrerDocuments.php?idProf=<?= $_SESSION['id']; ?>&idEtab=<?= $_SESSION["etab"]; ?>" enctype="multipart/form-data" method="post">
        <div class="modal fade" id="modal-add-doc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #1F85C7;">
                        <button type="button" class="close" onclick="uncheckFile();" aria-hidden="true" data-dismiss="modal">
                            <i style="color: white;" class="bold glyphicon glyphicon-remove"></i>
                        </button>
                        <h4 class="modal-title" style="color: white;"><i style="margin-right: 5px;" class="fa fa-plus"></i>
                            Nouveau document
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div style="color: #2b4f89;">
                                       <b>Nom document *</b>
                                </div>
                                <input class="col-lg-12" style="height: 28px;" type="text" name="nomdoc" required autocomplete="on"/>
                            </div>
                            <div style="margin-top: 17px;position: relative;left: 15px;" class="col-lg-4">
                                <button onclick="uploadFile('file-doc');" class="btn btn-sm btn-primary">
                                    Choisir document
                                </button>
                                <span id="file-check" style="position: relative;top : 6px;left: 15px;" class="fa fa-2x fa-file-archive-o text-success hidden"></span>
                            </div>
                        </div>
                        <div style="margin-top: 20px;" class="row">

                            <div class="row">
                                <div class="col-lg-8">
                                    <div style="color: #2b4f89;">
                                        <b>libellé *</b>
                                    </div>
                                    <input class="col-lg-12" style="height: 28px;" type="text" name="libelle" required autocomplete="on"/>
                                </div>
                                <div style="margin-top: -1px;" class="col-lg-4">
                                    <div class="bold" style="margin-left: 15px;color: #2b4f89;">
                                        <b>Classes *</b>
                                    </div>
                                    <select class="col-lg-12 selectpicker" id="done" name="idclass[]" required multiple data-done-button="true">
                                        <?php if(isset($tabClass) && count($tabClass)>0) {
                                            foreach ($tabClass as $oneClass) { ?>
                                                <option value="<?= $oneClass->idclass; ?>"><?= $oneClass->libclass; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="file" id="file-doc" onchange="checkFile();" class="hidden" name="document" required autocomplete="off"/>
                    </div>
                    <div class="modal-footer" style="border-top-color: #2b4f89;">
                        <button type="submit" class="btn btn-sm btn-success">Valider</button>
                        <button class="btn btn-sm btn-warning text-white" onclick="uncheckFile();" type="button" data-dismiss="modal"><b>Annuler</b>  </button>
                    </div>
                </div>
            </div>
        </div>
        <script>

            function uploadFile(idInput){
                $('#'+idInput).click()
            }

            function checkFile(){
                $('#file-check').removeClass("hidden");
            }

            function uncheckFile(){
                $('#file-check').addClass("hidden");
                $('#file-doc').val(null);
            }


        </script>
    </form>

</div>

</div>
</div>
</div>

<?php include('footer.php'); ?>