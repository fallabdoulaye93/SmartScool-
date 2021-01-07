<?php
require_once('header.php');
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

try
{
    $query_rq_etudiant = $dbh->query("SELECT i.MATRICULE, i.IDINDIVIDU, i.NOM, i.PRENOMS, e.IDETABLISSEMENT, 
                                  e.NOMETABLISSEMENT_ AS nometab, c.IDCLASSROOM as idclasse, c.LIBELLE as libclasse, c.IDNIVEAU
                                  FROM PARENT p
                                  INNER JOIN INDIVIDU i ON p.ideleve = i.IDINDIVIDU
                                  INNER JOIN AFFECTATION_ELEVE_CLASSE aff ON i.IDINDIVIDU = aff.IDINDIVIDU
                                  INNER JOIN CLASSROOM c ON aff.IDCLASSROOM = c.IDCLASSROOM
                                  INNER JOIN ETABLISSEMENT e ON c.IDETABLISSEMENT = e.IDETABLISSEMENT
                                  WHERE p.idParent = ".$lib->securite_xss($_SESSION['id']));

    $rs_etudiant = $query_rq_etudiant->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}


?>
    <!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#"> PARENT </a></li>
    <li class="active">Mes &eacute;tudiants </li>
</ul>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">

        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
		    if(isset($_GET['res']) && $_GET['res']==1) {?>
			    <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			        <?php echo $lib->securite_xss($_GET['msg']); ?>
			    </div>

		    <?php } if(isset($_GET['res']) && $_GET['res']!=1) {?>

			    <div class="alert alert-danger">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?php echo $lib->securite_xss($_GET['msg']); ?>
				</div>

		    <?php }
	    } ?>
    
        <table id="customers2" class="table datatable table-striped">
            <thead>
                <tr>
                    <th width="5%">Matricule</th>
                    <th width="12%">Pr&eacute;nom(s) & Nom</th>
                    <th width="10%">Classe</th>
                    <th style="text-align: center;" width="7%">D&eacute;tails</th>
                    <th style="text-align: center;" width="6%">Scolarit&eacute;</th>
                    <th style="text-align: center;" width="5%">Notes</th>
                    <th style="text-align: center;" width="8%">Emploi du temps</th>
                    <th style="text-align: center;" width="8%">Cahier Texte</th>
                    <th style="text-align: center;" width="12%">Bulletins</th>
                </tr>
            </thead>
            <tbody>
                <?php
				    foreach ($rs_etudiant as $controle) { ?>

                        <?php
                        $individu = $controle['IDINDIVIDU'];

                        $query_bulletin = $dbh->query("SELECT (f.IDINSCRIPTION)
                                  FROM FACTURE f
                                  INNER JOIN INSCRIPTION i ON i.IDINSCRIPTION = f.IDINSCRIPTION
                                  WHERE i.IDINDIVIDU = ".$individu." AND f.ETAT IN(0,2)");

                        $rs_bulletin = $query_bulletin->fetchAll();
                        $rs_rows = $query_bulletin->rowCount();
                        ?>


                        <tr>
                            <td><?= $controle['MATRICULE']; ?></td>
                            <td><?= $controle['PRENOMS']." ".$controle['NOM']; ?></td>
                            <td><?= $controle['libclasse']; ?></td>
                            <td style="text-align: center;">
                                <a href="details.php?IDETUDIANT=<?php echo base64_encode($controle['IDINDIVIDU']); ?>&IDCLASSROOM=<?php echo $controle['idclasse']; ?>&NOM=<?php echo str_replace(" ","-",$controle['PRENOMS']." ".$controle['NOM']); ?>">
                                    <i class="fa fa-2x fa-search"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="mensualite.php?IDETUDIANT=<?php echo  base64_encode($controle['IDINDIVIDU']); ?>&NOM=<?php echo str_replace(" ","-",$controle['PRENOMS']." ".$controle['NOM']); ?>">
                                    <i class="fa fa-2x fa-graduation-cap"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a onmouseover="$('#idEtudiant').removeAttr('class');$('#nomEtudiant').removeAttr('class');" onclick="$('#idEtudiant').addClass('<?php echo $controle['IDINDIVIDU']; ?>');$('#nomEtudiant').addClass('<?= str_replace(" ","-",$controle['PRENOMS']." ".$controle['NOM']); ?>');"
                                   data-toggle="modal" href="#choose-periode-note" >
                                    <i class="fa fa-2x fa-list-alt"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a onmouseover="$('#idclass').removeAttr('class');$('#nomclass').removeAttr('class');" onclick="$('#idclass').addClass('<?= $controle['idclasse']; ?>');$('#nomclass').addClass('<?= str_replace(" ","-",$controle['PRENOMS']." ".$controle['NOM']); ?>');"
                                data-toggle="modal"  href="#choose-periode-emp" data-id="<?php echo $controle['IDNIVEAU'] ;?> " >
                                    <i class="fa fa-2x fa-calendar"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <a href="cahierTexte.php?IDCLASSROOM=<?php echo $controle['idclasse']; ?>&IDETUDIANT=<?php echo $controle['IDINDIVIDU']; ?>&NOM=<?php echo str_replace(" ","-",$controle['PRENOMS']." ".$controle['NOM']); ?>">
                                    <i class="fa fa-2x fa-list"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <!--<a onmouseover="$('#idBultClass').removeAttr('class');$('#idBultEtu').removeAttr('class');$('#nomBult').removeAttr('class');" onclick="$('#idBultClass').addClass('<?/*= $controle['idclasse']; */?>') ; $('#idBultEtu').addClass('<?php /*echo $controle['IDINDIVIDU']; */?>') ; $('#nomBult').addClass('<?php /*echo str_replace(" ","-",$controle['PRENOMS']." ".$controle['NOM']);; */?>');"
                                data-toggle="modal" href="#choose-periode-bult" >
                                    <i class="fa fa-2x fa-print"></i>
                                </a>-->
                                <?php if ($rs_rows < 0) { ?>
                                <a data-toggle="modal" data-id="<?php echo $controle['IDINDIVIDU'];?>" href="#choose-periode-bult" >
                                    <i class="fa fa-2x fa-print"></i>
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
        <div class="modal fade" id="choose-periode-emp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2084c7;">
                        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">
                            <i style="color: white;" class="bold glyphicon glyphicon-remove"></i>
                        </button>
                        <h4 class="modal-title" style="color: white;">
                            <i style="margin-right: 5px;" class="fa fa-plus"></i>
                            Choisir periode
                        </h4>
                    </div>
                    <?php
                        $NIVEAU = intval($controle['IDNIVEAU']);
                        $periode = $dbh->query("SELECT `IDPERIODE`, `NOM_PERIODE` FROM `PERIODE` WHERE IDNIVEAU = " . $NIVEAU);
                    ?>
                    <div class="modal-body">
                        <div class="panel-body">
                            <i id="idclass"></i>
                            <i id="nomclass"></i>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <label>periode *</label>

                                <select onchange=" (this.value =='select') ? $('.alert').removeClass('hidden') : $('.alert').addClass('hidden');" id="periode" class="validate[required] form-control">
                                    <option value="0"> --Selectionner--</option>
                                    <?php foreach ($periode->fetchAll() as $row_rq_periode) { ?>
                                        <option
                                                value="<?php echo $row_rq_periode['IDPERIODE'] ?>"><?php echo $row_rq_periode['NOM_PERIODE'] ?></option>
                                    <?php } ?>
                                </select>



                            </div>
                            <input type="hidden" id="idclassroom" value="<?php echo $controle['idclasse']; ?>">
                            <div class="col-lg-2"></div>
                        </div>
                    </div>
                    <div class="alert alert-danger hidden"> Vous devez choisir une periode. </div>
                    <br/>
                    <div class="modal-footer" style="border-top-color: #2084c7;">
                        <a onclick="setHrefEmp(this)" class="btn btn-sm btn-success"
                           href="#">
                            Valider
                        </a>
                        <button class="btn btn-sm btn-default text-danger" type="button" data-dismiss="modal">
                            <b>Annuler</b>
                        </button>
                    </div>
                </div>
            </div>
            <script>
                function setHrefEmp(currentElem) {
                    var idClass = currentElem.parentNode.parentNode.children[1].children[0].children[0].className;
                    var nomClass = currentElem.parentNode.parentNode.children[1].children[0].children[1].className;
                    var idPeriod = $("#periode")[0].value;
                    var idclassroom = $("#idclassroom").value;
                    console.log(idclassroom);
                    if(idPeriod == "select") {
                        $('.alert').removeClass('hidden');
                        return false;
                    }else {
                        currentElem.href = "emploiDuTemps.php?IDCLASSROOM=<?php echo $controle['idclasse']; ?>&IDPERIODE="+idPeriod+"&NOM="+nomClass;
                    }
                }
            </script> 
        </div>
        <div class="modal fade" id="choose-periode-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2084c7;">
                        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">
                            <i style="color: white;" class="bold glyphicon glyphicon-remove"></i>
                        </button>
                        <h4 class="modal-title" style="color: white;">
                            <i style="margin-right: 5px;" class="fa fa-plus"></i>
                            Choisir periode
                        </h4>
                    </div>
                    <?php
                    $NIVEAU = intval($controle['IDNIVEAU']);
                    $periode = $dbh->query("SELECT `IDPERIODE`, `NOM_PERIODE` FROM `PERIODE` WHERE IDNIVEAU = " . $NIVEAU);
                    ?>
                    <div class="modal-body">
                        <div class="panel-body">
                            <i id="idEtudiant"></i>
                            <i id="nomEtudiant"></i>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <label>periode *</label>
                                <select onchange=" (this.value =='select') ? $('.alert').removeClass('hidden') : $('.alert').addClass('hidden');" id="periode-note" class="validate[required] form-control">
                                    <option value="select">--Selectionner--</option>
                                    <?php foreach ($periode->fetchAll() as $row_rq_periode) { ?>
                                        <option
                                                value="<?php echo $row_rq_periode['IDPERIODE'] ?>"><?php echo $row_rq_periode['NOM_PERIODE'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                    </div>
                    <div class="alert alert-danger hidden"> Vous devez choisir une periode. </div>
                    <br/>
                    <div class="modal-footer" style="border-top-color: #2084c7;">
                        <a onclick="setHrefNote(this)" class="btn btn-sm btn-success" href="#">
                            Valider
                        </a>
                        <button class="btn btn-sm btn-default text-danger" type="button" data-dismiss="modal">
                            <b>Annuler</b>
                        </button>
                    </div>
                </div>
            </div>
            <script>
                function setHrefNote(currentElem) {
                    var idEtudiant = currentElem.parentNode.parentNode.children[1].children[0].children[0].className;
                    var nomEtudiant = currentElem.parentNode.parentNode.children[1].children[0].children[1].className;
                    var idPeriod = $("#periode-note")[0].value;
                    if(idPeriod == "select") {
                        $('.alert').removeClass('hidden');
                        return false;
                    }else {
                        currentElem.href = "notes.php?IDETUDIANT="+idEtudiant+"&IDPERIODE="+idPeriod+"&NOM="+nomEtudiant;
                    }
                }
            </script>
        </div>
        <div class="modal fade" id="choose-periode-bult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2084c7;">
                        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">
                            <i style="color: white;" class="bold glyphicon glyphicon-remove"></i>
                        </button>
                        <h4 class="modal-title" style="color: white;">
                            <i style="margin-right: 5px;" class="fa fa-plus"></i>
                            Choisir periode
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="col-lg-2"></div>
                                <table class="table">

                                    <thead>
                                    <tr>
                                        <th>Périodes</th>
                                        <th style="text-align: center !important;">Voir bulletin</th>
                                    </tr>
                                    </thead>
                                    <tbody id="central"></tbody>
                                </table>
                            <div class="col-lg-2"></div>
                        </div>
                    </div>
<!--                    <div class="alert alert-danger hidden"> Vous devez choisir une periode. </div>-->
                    <br/>
                    <div class="modal-footer" style="border-top-color: #2084c7;">
                        <button class="btn btn-sm btn-default text-danger" type="button" data-dismiss="modal">
                            <b>Annuler</b>
                        </button>

                    </div>
                </div>
            </div>
            <script type="text/javascript">

                function printBulletin(currentElem,idetablissement,idannee) {

                    var idclasse = currentElem.parentNode.parentNode.children[1].children[0].children[0].className;
                    var ideleve = currentElem.parentNode.parentNode.children[1].children[0].children[1].className;
                    var nom = currentElem.parentNode.parentNode.children[1].children[0].children[2].className;
                    var idperiode = $("#periode-bult")[0].value;
                    if(idperiode == "select") {
                        $('.alert').removeClass('hidden');
                        return false;
                    }else {
                        nom = (idperiode == 1) ? "BPS_"+nom : "BSS_"+nom;
                        currentElem.parentNode.children[1].click();
                        window.location = "../ged/releve_classe_eleve.php?IDELEVE=" + ideleve + "&idclasse=" + idclasse + "&id_periode=" + idperiode + "&idetablissement=" + idetablissement + "&idannee=" + idannee+ "&nom=" + nom;
                    }
                }
            </script>
        </div>
    </div>
    </div>
</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<?php include('footer.php'); ?>
<script>
    $('#choose-periode-bult').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id')
        console.log(id)
        $.ajax({
            method: "POST",
            url: "requestSemester.php",
            data: {
                IDINDIVIDU: btoa(id)
            }
        }).done(function (data) {
            var data = JSON.parse(data)
            $('#central').empty()
            if(data != null) {
                for (var i = 0; i < data.length; i++){
                    var s = "<tr><td>"+data[i].NOM_PERIODE+"</td><td style='text-align: center !important;'><a target='_blank' href='../ged/imprimer_bulletin_individu.php?idIndividu="+btoa(id)+"&idclassroom="+btoa(data[i].IDCLASSROOM)+"&periode="+btoa(data[i].IDPERIODE)+"'><i class='glyphicon glyphicon-print'></i></a></td></tr>"
                    $('#central').append(s)
                }
            }else {
                console.log('nope')
            }
            })
        })

    /*$(document).on("click", "#choose-periode-bult", function () {
        var id = $(this).data('id');
        console.log(id)
    })*/
</script>
