<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once('classe/NiveauManager.php');
require_once('classe/FiliereManager.php');

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$colname_Rq_frais_inscription = "-1";
if (isset($_SESSION['etab'])) {
    $colname_Rq_frais_inscription = $lib->securite_xss($_SESSION['etab']);
}

$series = new FiliereManager($dbh, 'SERIE');
$serie = $series->getFiliere('IDETABLISSEMENT', $colname_Rq_frais_inscription);

$niveaux = new NiveauManager($dbh, 'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT', $colname_Rq_frais_inscription);

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(7, $lib->securite_xss($_SESSION['profil'])));

try
{
    $query_Rq_frais_inscription = $dbh->query("SELECT NIVEAU_SERIE.MT_MENSUALITE, NIVEAU_SERIE.FRAIS_INSCRIPTION, NIVEAU.IDNIVEAU, NIVEAU.LIBELLE, 
                                                      NIVEAU_SERIE.dure, NIVEAU_SERIE.montant_total, NIVEAU_SERIE.ID_NIV_SER, NIVEAU_SERIE.FRAIS_DOSSIER, NIVEAU_SERIE.VACCINATION, 
                                                      NIVEAU_SERIE.UNIFORME, NIVEAU_SERIE.ASSURANCE, NIVEAU_SERIE.FRAIS_EXAMEN, NIVEAU_SERIE.FRAIS_SOUTENANCE 
                                                      FROM NIVEAU_SERIE, NIVEAU 
                                                      WHERE NIVEAU_SERIE.IDETABLISSEMENT = " . $colname_Rq_frais_inscription . " 
                                                      AND NIVEAU.IDNIVEAU = NIVEAU_SERIE.IDNIVEAU 
                                                      ORDER BY MT_MENSUALITE ASC");
    $rs_frais_Inscri = $query_Rq_frais_inscription->fetchAll();

    $query_month = $dbh->query("SELECT TIMESTAMPDIFF(MONTH , DATE_DEBUT, DATE_FIN) as nb 
                                          FROM ANNEESSCOLAIRE 
                                          WHERE ETAT = 0 
                                          AND IDETABLISSEMENT = ".$colname_Rq_frais_inscription);
    $rs__month = $query_month->fetchObject();
    $nb_mois = $rs__month->nb;
}
catch (PDOException $e)
{
    echo -2;
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
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

                <div class="btn-group pull-right">
                    <button data-toggle="modal" data-target="#ajouter"
                            style="background-color:#DD682B" class='btn dropdown-toggle' , aria-hidden='true'>
                        <i class="fa fa-plus"></i> Nouveau frais d'inscription
                    </button>

                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $lib->securite_xss($_GET['msg']) != '') {

                    if (isset($_GET['res']) && $lib->securite_xss($_GET['res']) == 1) {?>

                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $lib->securite_xss($_GET['res']) != 1) {?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>Cycles</th>
                        <th style="text-align: right !important;">Mensualit&eacute;s(FCFA)</th>
                        <th style="text-align: right !important;">Frais d'inscription(FCFA)</th>
                        <th style="text-align: center !important;">Dur&eacute;es(Mois)</th>
                        <th style="text-align: right !important;">Totaux(FCFA)</th>
                        <th style="text-align: center !important;">Modifier</th>
                        <th style="text-align: center !important;">Supprimer</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php
                    foreach ($rs_frais_Inscri as $frais) {
                        $array = array(
                            "id" => $frais['ID_NIV_SER']
                        );
                        $param=base64_encode(json_encode($array));
                        ?>
                        <tr>

                            <td><?php echo $frais['LIBELLE']; ?></td>
                            <td align="right"><?php echo $lib->nombre_form($frais['MT_MENSUALITE']); ?></td>
                            <td align="right"><?php echo $lib->nombre_form($frais['FRAIS_INSCRIPTION']); ?></td>
                            <td style="text-align: center !important;"><?php echo $frais['dure']; ?></td>
                            <td align="right"><?php echo $lib->nombre_form($frais['montant_total']); ?></td>

                            <td style="text-align: center !important;"><a href="modifFI.php?id=<?php echo $param ; ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>

                            <td style="text-align: center !important;"><a href="suppFI.php?id=<?php echo $param ; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>


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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter"
     data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouveau frais d'inscription </h3>
                </div>
                <form action="ajouterFI.php" method="POST" id="addForm">

                    <div class="panel-body">
                        <div class="row">


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CYCLE</label>

                                    <div>
                                        <select name="IDNIVEAU" class="form-control selectpicker"
                                                data-live-search="true" required id="selectNiv" onchange="controlButton();controlButton_();">
                                            <option value="">-- Selectionner le cycle--</option>

                                            <?php foreach ($niveau as $nive) {?>

                                                <option value=" <?php echo $nive->getIDNIVEAU(); ?>"><?php echo $nive->getLIBELLE(); ?> </option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>S&Eacute;RIE</label>

                                    <div>
                                        <select name="IDSERIE" class="form-control selectpicker"
                                                data-live-search="true" required id="selectSerie" onchange="controlButton_();">
                                            <option value="">-- Selectionner la série--</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>MENSUALIT&Eacute;</label>

                                    <div>
                                        <input type="number" name="MT_MENSUALITE" id="MT_MENSUALITE" required
                                               class="form-control" value="0"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>FRAIS INSCRIPTION</label>

                                    <div>
                                        <input type="number" name="FRAIS_INSCRIPTION" id="FRAIS_INSCRIPTION" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>FRAIS DOSSIER</label>

                                    <div>
                                        <input type="number" name="FRAIS_DOSSIER" id="FRAIS_DOSSIER" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>VACCINATION</label>

                                    <div>
                                        <input type="number" name="VACCINATION" id="VACCINATION" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>UNIFORME</label>

                                    <div>
                                        <input type="number" name="UNIFORME" id="UNIFORME" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>ASSURANCE</label>

                                    <div>
                                        <input type="number" name="ASSURANCE" id="ASSURANCE" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>FRAIS SOUTENANCE</label>

                                    <div>
                                        <input type="number" name="FRAIS_SOUTENANCE" id="FRAIS_SOUTENANCE" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>FOURNITURE</label>

                                    <div>
                                        <input type="number" name="FOURNITURE" id="FOURNITURE" required
                                               class="form-control" value="0" min="0"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>DUREE FORMATION (en MOIS)</label>
                                    <div>
                                        <input type="number" name="dure" id="dure" required class="form-control" readonly value="<?php if($nb_mois >0 ) echo $nb_mois; else echo 0; ?>"/>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>
                        <input type="hidden" name="montant_total" value="0"/>


                        <button type="submit" class="btn btn-primary pull-right" id="idvalider" style="display: none">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
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

        if(selectedNiv == "") {
            $('#idvalider').css("display","none")
        }else{
            $('#idvalider').css("display","block")
        }
    }
</script>



