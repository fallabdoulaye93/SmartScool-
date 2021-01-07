<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(7, $lib->securite_xss($_SESSION['profil'])));

$colname_Rq_frais_inscription = "-1";
if (isset($_SESSION['etab'])) {
    $colname_Rq_frais_inscription = $lib->securite_xss($_SESSION['etab']);
}

require_once('classe/NiveauManager.php');
$niveaux = new NiveauManager($dbh, 'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT', $lib->securite_xss($_SESSION['etab']));

$colname_rq_fi_etab = "-1";
if (isset($_GET['id'])) {
    $param=json_decode(base64_decode($lib->securite_xss($_GET['id'])));
    $colname_rq_fi_etab = $param->id;
}

$query_rq_fi_etab = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE ID_NIV_SER = $colname_rq_fi_etab");
foreach ($query_rq_fi_etab->fetchAll() as $row_rq_fi_etab)
{
    $id = $row_rq_fi_etab['ID_NIV_SER'];
    $IDSERIE = $row_rq_fi_etab['IDSERIE'];
    $idNiveau = $row_rq_fi_etab['IDNIVEAU'];
    $MENSUALITE = $row_rq_fi_etab['MT_MENSUALITE'];
    $FRAIS_INSCRIPTION = $row_rq_fi_etab['FRAIS_INSCRIPTION'];
    $FRAIS_DOSSIER = $row_rq_fi_etab['FRAIS_DOSSIER'];
    $VACCINATION = $row_rq_fi_etab['VACCINATION'];
    $UNIFORME = $row_rq_fi_etab['UNIFORME'];
    $ASSURANCE = $row_rq_fi_etab['ASSURANCE'];
    $FRAIS_EXAMEN = $row_rq_fi_etab['FRAIS_EXAMEN'];
    $FRAIS_SOUTENANCE = $row_rq_fi_etab['FRAIS_SOUTENANCE'];
    $FOURNITURE = $row_rq_fi_etab['FOURNITURE'];
    $dure = $row_rq_fi_etab['dure'];
}

require_once("classe/FraisInscriptionManager.php");
require_once("classe/FraisInscription.php");
$fi = new FraisInscriptionManager($dbh, 'NIVEAU_SERIE');

if (isset($_POST) && $_POST != null)
{
    $_POST['montant_total'] = (intval($_POST['MT_MENSUALITE']) * intval($_POST['dure'])) + intval($_POST['FRAIS_INSCRIPTION']) + intval($_POST['FRAIS_DOSSIER']) + intval($_POST['VACCINATION']) + intval($_POST['UNIFORME']) + intval($_POST['ASSURANCE']) + intval($_POST['FRAIS_EXAMEN']) + intval($_POST['FRAIS_SOUTENANCE']) + intval($_POST['FOURNITURE']);
    $res = $fi->modifier($lib->securite_xss_array($_POST), 'ID_NIV_SER', $lib->securite_xss($_POST['ID_NIV_SER']));
    if ($res == 1)
    {
        $msg = "Modification effectuée avec succés";
    } else {
        $msg = "Modification effectuée avec echec";
    }
    header("Location: fraisInscription.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Frais inscription</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="modifFI.php" method="POST">

                            <div class="row">

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>CYCLE</label>

                                        <div>
                                            <select name="IDNIVEAU" class="form-control selectpicker" data-live-search="true" onchange="controlButton();controlButton_();" id="selectNiv">
                                                <option value="">-- Selectionner le cylce--</option>
                                                <?php
                                                foreach ($niveau as $nive) {

                                                    ?>
                                                    <option
                                                            value=" <?php echo $nive->getIDNIVEAU(); ?>" <?php if ($idNiveau == $nive->getIDNIVEAU()) echo "selected" ?> ><?php echo $nive->getLIBELLE(); ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>SERIE / FILIERE</label>

                                        <div>

                                            <select name="IDSERIE" class="form-control selectpicker" data-live-search="true" id="selectSerie" onchange="controlButton_()">

                                                <option value="">-- Selectionner la filiere / série --</option>

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>MENSUALITE</label>

                                        <div>
                                            <input type="number" name="MT_MENSUALITE" id="MT_MENSUALITE" required class="form-control" value="<?php echo $MENSUALITE; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>FRAIS INSCRIPTION</label>

                                        <div>
                                            <input type="number" name="FRAIS_INSCRIPTION" id="FRAIS_INSCRIPTION" required class="form-control" value="<?php echo $FRAIS_INSCRIPTION; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>FRAIS DOSSIER</label>

                                        <div>
                                            <input type="number" name="FRAIS_DOSSIER" id="FRAIS_DOSSIER" required class="form-control" value="<?php echo $FRAIS_DOSSIER; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>VACCINATION</label>

                                        <div>
                                            <input type="number" name="VACCINATION" id="VACCINATION" required class="form-control" value="<?php echo $VACCINATION; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>UNIFORME</label>

                                        <div>
                                            <input type="number" name="UNIFORME" id="UNIFORME" required class="form-control" value="<?php echo $UNIFORME; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>ASSURANCE</label>

                                        <div>
                                            <input type="number" name="ASSURANCE" id="ASSURANCE" required class="form-control" value="<?php echo $ASSURANCE; ?>"/>
                                        </div>
                                    </div>
                                </div>

                               <!-- <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>FRAIS EXAMEN</label>

                                        <div>
                                            <input type="number" name="FRAIS_EXAMEN" id="FRAIS_EXAMEN" required class="form-control" value="<?php /*echo $FRAIS_EXAMEN; */?>"/>
                                        </div>
                                    </div>
                                </div>-->

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>FRAIS SOUTENANCE</label>

                                        <div>
                                            <input type="number" name="FRAIS_SOUTENANCE" id="FRAIS_SOUTENANCE" required class="form-control" value="<?php echo $FRAIS_SOUTENANCE; ?>"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>FOURNITURE</label>

                                        <div>
                                            <input type="number" name="FOURNITURE" id="FOURNITURE" required class="form-control" value="<?php echo $FOURNITURE; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>DUREE FORMATION</label>
                                        <div>
                                            <input type="number" name="dure" id="dure" required class="form-control" value="<?php echo $dure; ?>" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <br><br>


                                <div class="col-lg-12">
                                    <br/>
                                    <div class="col-lg-offset-5" id="idvalider"><input type="submit" class="btn btn-success" value="Modifier"/></div>

                                </div>

                            </div>

                            <input type="hidden" name="ID_NIV_SER" value="<?php echo $id; ?>"/>
                            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>
                            <input type="hidden" name="montant_total" value="0"/>

                        </form>
                    </div>
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
    $(function() {
        $.ajax({
            method: "POST",
            url: "request.php",
            data: {
                IDNIVEAU: btoa(<?php echo $idNiveau; ?>)
            }
        }).done(function (data) {
            var data = $.parseJSON(data)
            $('#selectSerie').children('option:not(:first)').remove()
            $('#selectSerie').selectpicker('refresh')
            for (i = 0, len = data.length; i < len; i++){
                $('#selectSerie').append(new Option(data[i].LIBSERIE, data[i].IDSERIE))
                $('#selectSerie').selectpicker('refresh')
            }
            $("#selectSerie option").each(function(){
                if ($(this).val() == "<?php echo $IDSERIE ;?>")
                    $(this).attr("selected","selected");
            })
            $('#selectSerie').selectpicker('refresh')
        })
    });
    function controlButton() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv != "") {
            $('#idvalider').css("display","none")
            $.ajax({
                method: "POST",
                url: "request.php",
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
            $('#idvalider').css("display","none")
        }
    })

    function controlButton_() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        //var selectedSer = $("#selectSerie").find("option:selected").val()

        //if(selectedNiv == "" || selectedSer == "") {
        if(selectedNiv == "") {
            $('#idvalider').css("display","none")
        }else{
            $('#idvalider').css("display","block")
        }
    }
</script>
