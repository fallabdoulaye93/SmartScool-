<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(20, $lib->securite_xss($_SESSION['profil'])));

$annee_scolaire = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $annee_scolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$etabblissement = "-1";
if (isset($_SESSION['etab']))
{
    $etabblissement = $lib->securite_xss($_SESSION['etab']);
}

$individu = "-1";
if (isset($_POST['IDINDIVIDU'])) {
    $individu = $lib->securite_xss(base64_decode($_POST['IDINDIVIDU']));
}

try
{
    $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT 
                                       FROM NIVEAU 
                                       WHERE IDETABLISSEMENT = " . $etabblissement);
    $rs_niv = $query_rq_niv->fetchAll();

    $query_rq_typecontrole = $dbh->query("SELECT IDTYP_CONTROL, LIB_TYPCONTROL, POIDS, IDETABLISSEMENT, COULEUR FROM TYP_CONTROL");
    $rs_controle = $query_rq_typecontrole->fetchAll();

    $query_rq_classe = $dbh->query("SELECT RECRUTE_PROF.IDRECRUTE_PROF, CLASSE_ENSEIGNE.IDCLASSROM, CLASSROOM.LIBELLE 
                                              FROM RECRUTE_PROF, CLASSROOM, CLASSE_ENSEIGNE
                                              WHERE RECRUTE_PROF.IDINDIVIDU = ".$individu." 
                                              AND RECRUTE_PROF.IDANNEESSCOLAIRE = ".$annee_scolaire." 
                                              AND RECRUTE_PROF.IDRECRUTE_PROF = CLASSE_ENSEIGNE.IDRECRUTE_PROF 
                                              AND CLASSE_ENSEIGNE.IDCLASSROM = CLASSROOM.IDCLASSROOM 
                                              GROUP BY CLASSROOM.IDCLASSROOM");
    $rs_classe = $query_rq_classe->fetchAll();

    $query_rq_matiere = $dbh->query("SELECT MATIERE.LIBELLE, MATIERE.IDMATIERE 
                                               FROM MATIERE, MATIERE_ENSEIGNE
                                               WHERE MATIERE_ENSEIGNE.ID_MATIERE = MATIERE.IDMATIERE 
                                               AND MATIERE_ENSEIGNE.ID_INDIVIDU = " . $individu . "  
                                               AND MATIERE_ENSEIGNE.IDANNESCOLAIRE = " . $annee_scolaire);
    $rs_matiere = $query_rq_matiere->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
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

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <fieldset class="cadre">
                    <legend>NOUVEAU CONTRÔLE</legend>


                    <form action="validerControle.php" method="post" name="form1" id="form1">

                        <div class="form-group col-lg-12">
                            <label>Matiére : </label>
                            <select name="IDMATIERE" id="IDMATIERE" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" required onchange="controlButton();">
                                <option value="">--Selectionner--</option>
                                <?php foreach ($rs_matiere as $row_rq_matiere) { ?>
                                    <option value="<?php echo $row_rq_matiere['IDMATIERE']; ?>"><?php echo $row_rq_matiere['LIBELLE']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Type contrôle : </label>
                            <select name="IDTYP_CONTROL" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" id="IDTYP_CONTROL" required onchange="controlButton();">
                                <option value="">--Selectionner--</option>
                                <?php foreach ($rs_controle as $row_rq_typecontrole) { ?>
                                    <option value="<?php echo $row_rq_typecontrole['IDTYP_CONTROL']; ?>"><?php echo $row_rq_typecontrole['LIB_TYPCONTROL']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Libelle : </label>
                            <input name="LIBELLE_CONTROLE" type="text" class="form-control" required/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Cycle : </label>
                            <select  id="selectNiv" class="form-control selectpicker" data-live-search="true"  onchange="choixClasse(); choixNivClasse();"  style="width: 100%;!important;">
                                <option value="">--Selectionner--</option>
                                <?php  foreach ($rs_niv as $row_rq_niv) { ?>
                                    <option value="<?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-lg-6">
                            <label>Période : </label>
                            <select name="IDPERIODE" id="classe" class="form-control" required  style="width: 100%;!important;"  onchange="buttonControl();" >
                                <option value="">--Selectionner--</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Niveau : </label>
                            <select  id="nivclass" name="nivclass" class="form-control" style="width: 100%;!important;" onchange="getClasse();">
                                <option value="">--Selectionner--</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Classe : </label>
                            <select  id="IDCLASSROOM" name="IDCLASSROOM" class="form-control" style="width: 100%;!important;" onchange="controlButton();">
                                <option value="">--Selectionner--</option>
                            </select>
                            <div class="alert alert-danger hidden">
                                Pas d'eleve dans cette classe! Veuillez choisir une autre classe.
                            </div>

                        </div>

                        <div class="form-group col-lg-6">
                            <label>Date début : </label>
                            <input name="DATEDEBUT" id="date_foo" type="text" class="form-control" required/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Date fin : </label>
                            <input name="DATEFIN" id="date_foo2" type="text" class="form-control" required/>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-md-11"><a class="btn btn-warning" href="nouveauControle.php" role="button">Retour</a></div>
                            <div class="col-md-1"><input type="submit" id="idvalider" value="Valider" class="btn btn-success" style="display: none"/></div>
                        </div>


                        <input type="hidden" id="individu" name="IDINDIVIDU" value="<?php echo $individu; ?>"/>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo base64_encode($etabblissement); ?>"/>
                        <input type="hidden" name="NOTER" value=""/>
                        <input type="hidden" name="VALIDER" value="0"/>
                        <input type="hidden" name="modif" value="<?php echo base64_encode(0); ?>"/>

                    </form>

                </fieldset>



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

<?php include('footer.php'); ?>

<script>
    function controlButton() {
        var selectedIDTYP = $("#IDTYP_CONTROL").find("option:selected").val()
        var selectedIDPE = $("#IDPERIODE").find("option:selected").val()
        var selectedIDC = $("#IDCLASSROOM").find("option:selected").val()
        var selectedIDM = $("#IDMATIERE").find("option:selected").val()


        if(selectedIDTYP != "" && selectedIDPE != "" && selectedIDC != "" && selectedIDM != "" )
        {
            $('#idvalider').css("display","block")
        }
        else
        {
            $('#idvalider').css("display","none")
        }
    }

    function choixClasse() {
        var valSel = $("#selectNiv").val();
        $.ajax({
            type: "POST",
            url: "getPeriode.php",
            data: "NIVEAU=" + valSel,
            success: function (data) {
                data = JSON.parse(data);
                $("#classe").html('<option selected="selected" value="">--Selectionner--</option>');
                $.each(data, function (cle, valeur) {
                    $("#classe").append('<option value="' + valeur.IDPERIODE + '">' + valeur.NOM_PERIODE + '</option>');
                });
            }
        });
    }

    function choixNivClasse() {
        var valSel = $("#selectNiv").val();
        $.ajax({
            type: "POST",
            url: "getNiveClasse.php",
            data: "NIVEAU=" + valSel,
            success: function (data) {
                data = JSON.parse(data);
                $("#nivclass").html('<option selected="selected" value="">--Selectionner--</option>');
                $.each(data, function (cle, valeur) {
                    $("#nivclass").append('<option value="' + valeur.ID + '">' + valeur.LIBELLE + '</option>');
                });
            }
        });
    }


    function getClasse() {
        var valSel = $("#nivclass").val();
        var prof = $("#individu").val();
        $.ajax({
            type: "POST",
            url: "getClasse.php",
            data: "NIVEAU=" + valSel+"&PROF="+prof,
            success: function (data) {
                data = JSON.parse(data);
                if(data==-2){
                    $(".alert").removeClass("hidden");
                }else{
                    $(".alert").addClass("hidden");
                    $("#IDCLASSROOM").html('<option selected="selected" value="">--Selectionner--</option>');
                    $.each(data, function (cle, valeur) {
                        $("#IDCLASSROOM").append('<option value="' + valeur.IDCLASSROOM + '">' + valeur.LIBELLE + '</option>');
                    })

                }
            }
        });
    }


</script>
