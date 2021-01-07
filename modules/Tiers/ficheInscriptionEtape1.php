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

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(36, $lib->securite_xss($_SESSION['profil'])));

require_once('../Parametrage/classe/ProfileManager.php');
$profiles = new ProfileManager($dbh, 'profil');
$profil = $profiles->getProfiles();


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$idIndividu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
    $idIndividu = $lib->securite_xss(base64_decode($_GET['IDINDIVIDU']));
}


try
{
    $query_rq_individu = $dbh->query("SELECT MATRICULE,PRENOMS,NOM,TELMOBILE FROM INDIVIDU WHERE IDINDIVIDU = $idIndividu");
    $rq_individu = $query_rq_individu->fetchObject();

    $query_rq_niveau = $dbh->query("SELECT IDNIVEAU,LIBELLE FROM NIVEAU WHERE IDETABLISSEMENT = $colname_rq_individu");
    $rs_nivau = $query_rq_niveau->fetchAll();

    $query_rq_filiere = $dbh->query("SELECT IDSERIE,LIBSERIE FROM SERIE WHERE IDETABLISSEMENT = $colname_rq_individu");
    $rs_filiere = $query_rq_filiere->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
?>

<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TIERS</a></li>
    <li>Inscription</li>
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

                    if (isset($_GET['res']) && $_GET['res'] == 1) {?>

                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) {?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>
<!--                        <div class="form-group col-lg-6">
                            <label>MATRICULE: </label>&nbsp;&nbsp;
                            <?php /*echo $rq_individu->MATRICULE; */?>
                        </div>-->
                    <?php } ?>

                <?php } ?>


                <fieldset class="cadre">
                    <legend>INFORMATION PERSONNEL</legend>

                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>PRENOMS: </label>&nbsp;&nbsp;
                            <?php echo $rq_individu->PRENOMS; ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>NOM: </label>&nbsp;&nbsp;
                            <?php echo $rq_individu->NOM; ?>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>TELEPHONE MOBILE: </label>&nbsp;&nbsp;
                            <?php echo $rq_individu->TELMOBILE; ?>
                        </div>

                    </div>

                </fieldset>

                <form action="ficheInscription.php" method="POST" id="form" class="form-inline" data-toggle="validator" role="form" data-disable="false">

                    <fieldset class="cadre">
                        <div class="form-group col-lg-5">
                            <label for="exampleInputEmail2">CYCLE</label>
                            <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" data-live-search="true"  title="VEUILLEZ CHOISIR UN CYCLE" onchange="controlButton();">
                                <option value="">VEUILLEZ CHOISIR UN CYCLE</option>
                                <?php foreach ($rs_nivau as $niveau) { ?>
                                    <option
                                            value="<?php echo $niveau['IDNIVEAU']; ?>"><?php echo $niveau['LIBELLE']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <legend> FILIERE/SERIE</legend>
                        <div class="form-group col-lg-5">
                            <label for="exampleInputName2">FILIERE / SERIE</label>
                            <select name="IDSERIE" id="selectSerie" class="form-control selectpicker" data-live-search="true"  title="VEUILLEZ CHOISIR UNE FILIERE" onchange="controlButton_();">
                                <option value="">VEUILLEZ CHOISIR UNE FILIERE / SERIE</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-offset-1 col-lg-1">
                            <input type="hidden" name="IDINDIVIDU" value="<?php echo base64_encode($idIndividu); ?>"/>
                            <button type="submit" style="display: none" id="idsuivant"  class="btn btn-primary">Suivant</button>
                        </div>

                    </fieldset>

                </form>


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
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv != "") {
            $('#idsuivant').css("display","none")
            $.ajax({
                method: "POST",
                url: "requestCycle.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }

            }).done(function (data) {
                var data = $.parseJSON(data)
                $('#selectSerie').children('option:not(:first)').remove()
                $('#selectSerie').selectpicker('refresh')
                for (i = 0, len = data.length; i < len; i++){
                    $('#selectSerie').append(new Option(data[i].LIBSERIE, data[i].IDSERIE))
                    $('#selectSerie').selectpicker('refresh')
                }
            })
        }
    }

    $("#selectNiv").on('change', function () {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv == "") {
            $('#selectSerie').children('option:not(:first)').remove()
            $('#selectSerie').selectpicker('refresh')
            $('#idsuivant').css("display","none")
        }
    })
    /*
    selectedNiv == "-- Selectionner le niveau--" || selectedSer == "-- Selectionner la filière--"*/
    function controlButton_() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        var selectedSer = $("#selectSerie").find("option:selected").val()

        if(selectedNiv == "" || selectedSer == "") {
            $('#idsuivant').css("display","none")
        }else{
            $('#idsuivant').css("display","block")
        }
    }


    /*function verification () {
        var idsuivant = document.getElementById("idsuivant");
        var niveau = document.getElementById("IDNIVEAU").value;
        var serie = document.getElementById("IDSERIE").value;
        if (niveau=="" && serie =="" ) {
            alert("VEUILLEZ CHOISIR UNE FILIERE OU UN NIVEAU ");
            idsuivant.style.display = "none";
        }
        else {
            idsuivant.style.display = "block";
        }
    }*/
</script>
