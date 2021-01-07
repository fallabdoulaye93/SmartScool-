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
    $lib->Restreindre($lib->Est_autoriser(25, $lib->securite_xss($_SESSION['profil'])));

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_an = $dbh->query("SELECT IDANNEESSCOLAIRE, DATE_DEBUT, DATE_FIN
                                      FROM ANNEESSCOLAIRE 
                                      WHERE  IDETABLISSEMENT = " . $colname_rq_classe ." 
                                      AND IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
$row_rq_an = $query_rq_an->fetchObject();
$date_debut = $row_rq_an->DATE_DEBUT;
$date_fin = date('Y-m-d');

$date = new DateTime($date_fin);
$date->modify("-1 month");
$date = $date->format("Y-m-d");


$query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $colname_rq_classe);
$rs_niv = $query_rq_niv->fetchAll();
?>
<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Evaluations</a></li>
    <li>Generation bulletin de notes</li>
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
                <div id="warning" style="display: none">
                    <div class="alert alert-danger">
                        LA GENERATION DES BULLETINS DE NOTES POUR CE MOIS A ÉTÉ DÉJA EFFECTUÉE !!
                    </div>
                </div>

                <div id="warning1" style="display: none">
                    <div class="alert alert-danger">
                        ON NE PEUT GENERER DE BULLETIN PUISQU'IL Y'A PAS DE CONTROLE POUR CE MOIS !!
                    </div>
                </div>

                <form id="form1" name="form1" method="post" action="bulletinClasseMensuel.php">
                    <fieldset class="cadre">
                        <legend> G&eacute;n&eacute;ration bulletin mensuel par classe</legend>


                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                            <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" data-live-search="true"  onchange="controlButton();"  style="width: 100%;!important;">
                                                <option value="">--Selectionner--</option>
                                                <?php  foreach ($rs_niv as $row_rq_niv) { ?>
                                                    <option value="<?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label>CLASSE</label>
                                            <select  name="Classe" id="Classe" class="form-control" onchange="controlButton_C();" data-live-search="true">
                                                <option value="">--Selectionner--</option>
                                            </select>
                                            <label id="Classe-error" class="error hidden" for="Classe" style="display: inline-block;">This field is required.</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>MOIS : </label>

                                        <?php
                                        function debug($var){
                                            return $var;
                                        }?>


                                        <select name="MOIS" id="MOIS" class="form-control" onchange="controlButton_C();">

                                            <option value="">Choisir Mois</option>
                                            <?php
                                            $date1 = new DateTime($date_debut);
                                            $date2 = new DateTime($date);
                                            $mois = array();
                                            $mois[] =  $date1->format('m-Y');
                                            while($date1 <= $date2)
                                            {
                                                $date1->add(new DateInterval("P1M"));
                                                $mois[] = $date1->format('m-Y');
                                            }

                                            foreach (debug($mois) as $row) { ?>

                                                <option value="<?php echo $row; ?>"><?php echo $lib->affiche_mois($row); ?></option>

                                            <?php }  ?>

                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row" id="valid" style="display: none;padding-top: 20px">

                                <div class="col-lg-4"></div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="button" class="btn btn-success" name="envoyer" value="Valider" id="validerAj" />
                                    </div>
                                </div>

                                <div class="col-lg-4"></div>

                            </div>

                    </fieldset>
                </form>
                <br><br>

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
            $('#valid').css("display","none")
            $.ajax({
                method: "POST",
                url: "requestCycle.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }

            }).done(function (data) {
                var data = $.parseJSON(data)
                var classes = data.classes
                var periodes = data.periodes

                $('#Classe').children('option:not(:first)').remove()
                $('#Classe').selectpicker('refresh')
                for (i = 0, len = classes.length; i < len; i++){
                    $('#Classe').append(new Option(classes[i].LIBELLE, classes[i].IDCLASSROOM))
                    $('#Classe').selectpicker('refresh')
                }
                $('#periode').children('option:not(:first)').remove()
                $('#periode').selectpicker('refresh')
                for (i = 0, len = periodes.length; i < len; i++){
                    $('#periode').append(new Option(periodes[i].NOM_PERIODE, periodes[i].IDPERIODE))
                    $('#periode').selectpicker('refresh')
                }
            })
        }
    }
    $("#selectNiv").on('change', function () {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv == "") {
            $('#Classe').children('option:not(:first)').remove()
            $('#Classe').selectpicker('refresh')
            $('#periode').children('option:not(:first)').remove()
            $('#periode').selectpicker('refresh')
            $('#valid').css("display","none")
        }
    })
    function controlButton_C() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        var selectedC = $("#Classe").find("option:selected").val()
        var mois = $("#MOIS").find("option:selected").val()


        if(selectedNiv == "" || selectedC == "" ||  mois == "") {
            $('#valid').css("display","none")
        }else {
            $('#valid').css("display","block")
        }
    }


    $('#validerAj').on('click',function () {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        var selectedC = $("#Classe").find("option:selected").val()
        var mois = $("#MOIS").find("option:selected").val()



        if(selectedNiv != "" && selectedC != "" && mois != "" ) {
            $.ajax({
                method: "POST",
                url: "requestBulletinsMensuel.php",
                data: {
                    IDCLASSROOM: btoa(selectedC),
                    MOIS: btoa(mois)
                }

            }).done(function (data) {
                var data = $.parseJSON(data)
                if(data == 0) {
                    $('#warning').css('display','none')
                    $("#form1").submit()
                }else if(data == -1){
                    $('#warning').css('display','block')
                    $('#warning1').css('display','none')
                }else if(data == -2){
                    $('#warning1').css('display','block')
                    $('#warning').css('display','none')
                    }

            })
        }
    })
</script>


