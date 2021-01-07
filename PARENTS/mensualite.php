<?php
include('header.php');

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$nomEtudiant = str_replace("-"," ",$lib->securite_xss($_GET['NOM']));
$idEtudiant = str_replace("-"," ",base64_decode($lib->securite_xss($_GET['IDETUDIANT'])));
$annee =$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);


$query_mens_etudiant = $dbh->prepare("SELECT INSCRIPTION.IDINSCRIPTION as idins,INSCRIPTION.DATEINSCRIPT as dateins,INSCRIPTION.ACCORD_MENSUELITE as mensualite,NIVEAU.LIBELLE as niveau,SERIE.LIBSERIE as filiere,FACTURE.IDFACTURE as idfact,
                                           FACTURE.NUMFACTURE as numfact,FACTURE.MOIS as moisfact,FACTURE.MONTANT as montantfact,FACTURE.MT_VERSE as verserfact,FACTURE.MT_RELIQUAT as reliquatfact,MENSUALITE.IDMENSUALITE as idmens,MENSUALITE.DATEREGLMT as dateregle
                                    FROM INSCRIPTION
                                        INNER JOIN FACTURE ON INSCRIPTION.IDINSCRIPTION = FACTURE.IDINSCRIPTION
                                        INNER JOIN NIVEAU ON INSCRIPTION.IDNIVEAU = NIVEAU.IDNIVEAU
                                        INNER JOIN SERIE ON INSCRIPTION.IDSERIE = SERIE.IDSERIE
                                        LEFT JOIN MENSUALITE ON FACTURE.NUMFACTURE = MENSUALITE.NUMFACT
                                    WHERE INSCRIPTION.IDANNEESSCOLAIRE = ? AND INSCRIPTION.IDINDIVIDU = ?
                                    ORDER BY FACTURE.MOIS DESC");
$query_mens_etudiant->execute(array($annee,$idEtudiant));
$query_mens_etudiant = $query_mens_etudiant->fetchAll(PDO::FETCH_OBJ);
//                                  echo "<pre>";var_dump($query_mens_etudiant);exit;

?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">PARENT</a></li>
    <li class="active">Mensualité</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">
        <div>
            <p><h4 style="color:#E05D1F;margin-left: 15px;">L'historique de paiement de l'étudiant : <b><?= $nomEtudiant; ?></b></h4></p>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {
                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    ?>
                <?php } ?>

                <fieldset class="cadre">
                    <legend> Information sur l'inscription</legend>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label">
                            <b>Date inscription </b>
                        </label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?= (count($query_mens_etudiant)>0) ? $lib->date_fr($query_mens_etudiant[0]->dateins) : "" ; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Niveau </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?= (count($query_mens_etudiant)>0) ? $query_mens_etudiant[0]->niveau : "" ; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3"
                               class="col-sm-2 form-control-label"><b>Fili&eacute;re </b></label>
                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?= (count($query_mens_etudiant)>0) ? $query_mens_etudiant[0]->filiere : "" ; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Mensualit&eacute; </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?= (count($query_mens_etudiant)>0) ? $lib->nombre_form($query_mens_etudiant[0]->mensualite)." FCFA" : "" ; ?>
                        </div>
                    </div>
                </fieldset>

                <table id="customers2" class="table datatable table-striped">
                    <thead>
                    <tr>
                        <th width="10%">Numero</th>
                        <th width="8%">Mois</th>
                        <th width="15%">Montant</th>
                        <th width="15%">Verser</th>
                        <th width="15%">Restant</th>
                        <th width="15%">Date réglement</th>
                        <th width="11%">Etat</th>
                        <th width="11%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? if(count($query_mens_etudiant)>0){
                    foreach ($query_mens_etudiant as $oneFact) {
                        $oneFact->moisfact = $lib->affiche_mois($oneFact->moisfact);
                        $oneFact->dateregle = (!is_null($oneFact->dateregle)) ? $lib->date_fr($oneFact->dateregle) : "00 / 00 / 0000" ;
                        $action = "<a href='Paiement.php?montant=".$oneFact->reliquatfact."&id=".$idEtudiant."&nom=".$_GET['NOM']."&mois=". $oneFact->moisfact."&numfact=". $oneFact->numfact."'>";
                        if($oneFact->reliquatfact == $oneFact->montantfact){ $etat = "<i style='color: #ff3f43;font-size: 12px;'><b>A PAYER</b></i>";$action .= "<i class='fa fa-2x fa-money'></i>";}
                        elseif($oneFact->reliquatfact > 0 && $oneFact->reliquatfact < $oneFact->montantfact ){ $etat = "<i style='color: #ffba31;font-size: 12px;'><b>A COMPLETER</b></i>";$action .= "<i class='fa fa-2x fa-money'></i>"; }
                        else{ $etat = "<i style='color: #04953c;font-size: 12px;'><b>PAYER</b></i>";$action = "<a href='../ged/imprimer_recu.php?nomfich=".$oneFact->moisfact."&IDINDIVIDU=".$idEtudiant."&IDMENSUALITE=".$oneFact->idmens."&IDINSCRIPTION=". $oneFact->idins."'><i class='fa fa-2x fa-print'></i>";}
                        $action.= "</a>";
                        ?>
                        <tr>
                            <td><?= $oneFact->numfact; ?></td>
                            <td><?= $oneFact->moisfact; ?></td>
                            <td><?= $lib->nombre_form($oneFact->montantfact); ?> FCFA</td>
                            <td><?= $lib->nombre_form($oneFact->verserfact); ?> FCFA</td>
                            <td><?= $lib->nombre_form($oneFact->reliquatfact); ?> FCFA</td>
                            <td><?= $oneFact->dateregle; ?></td>
                            <td><?= $etat; ?></td>
                            <td><?= $action; ?></td>
                        </tr>
                    <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="choose-periode-bult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2b4f89;">
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
                            <i id="idBultClass"></i>
                            <i id="idBultEtu"></i>
                            <i id="nomBult"></i>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <label>periode *</label>
                                <select onchange=" (this.value =='select') ? $('.alert').removeClass('hidden') : $('.alert').addClass('hidden');" id="periode-bult" class="validate[required] form-control">
                                    <option value="select">--Selectionner--</option>
                                    <option value="1">PREMIER SEMESTRE</option>
                                    <option value="2">SECOND SEMESTRE</option>
                                </select>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                    </div>
                    <div class="alert alert-danger hidden"> Vous devez choisir une periode. </div>
                    <br/>
                    <div class="modal-footer" style="border-top-color: #2b4f89;">
                        <a onclick="printBulletin(this,'<?= $_SESSION["etab"]; ?>','<?= $_SESSION['ANNEESSCOLAIRE']; ?>');" class="btn btn-sm btn-success" href="#">
                            Valider
                        </a>
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

    <div class="form-group row" >
        <div class="col-sm-5"></div>
        <div class="col-sm-5"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-1 btn-primary" style="width: 60px;" >
            <a href="mes_etudiant.php" style="color:#FFFFFF; font-size:14px;vertical-align: middle;line-height: 35px;"> Retour</a>
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