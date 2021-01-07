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
if (isset($_POST['IDINDIVIDU'])) {
    $idIndividu = $lib->securite_xss(base64_decode($_POST['IDINDIVIDU']));
}

$query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = $idIndividu");
$rq_individu = $query_rq_individu->fetchObject();

$colname_niveau_rq_mtinscription = "-1";
if (isset($_POST['IDNIVEAU'])) {
    $colname_niveau_rq_mtinscription = $lib->securite_xss($_POST['IDNIVEAU']);
}
$colname_serie_rq_mtinscription = "-1";
if (isset($_POST['IDSERIE'])) {
    $colname_serie_rq_mtinscription = $lib->securite_xss($_POST['IDSERIE']);
}
$colname_rq_matricule = "-1";
if (isset($_POST['MATRICULE'])) {
    $colname_rq_matricule = $lib->securite_xss($_POST['MATRICULE']);

}

try
{

    $query_rq_an = $dbh->query("SELECT DATE_DEBUT, DATE_FIN 
                                          FROM ANNEESSCOLAIRE
                                          WHERE IDETABLISSEMENT = " . $colname_rq_individu ." 
                                          AND IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE'])."
                                          AND ETAT = 0"

    );
    $row_rq_an = $query_rq_an->fetchObject();
    $date_debut = $row_rq_an->DATE_DEBUT;
    $date_fin = $row_rq_an->DATE_FIN;

    $d1 = new DateTime($date_debut);
    $d2 = new DateTime($date_fin);
    $difference = $d1->diff($d2)->m - 2;



    $query_rq_mtinscription = $dbh->query("SELECT ID_NIV_SER, IDSERIE, IDNIVEAU, MT_MENSUALITE, FRAIS_INSCRIPTION, FRAIS_DOSSIER, VACCINATION, UNIFORME, ASSURANCE, FRAIS_EXAMEN, FRAIS_SOUTENANCE, dure, montant_total, IDETABLISSEMENT 
                                                     FROM NIVEAU_SERIE 
                                                     WHERE NIVEAU_SERIE.IDNIVEAU = ".$colname_niveau_rq_mtinscription);
    $row_rq_mtinscription = $query_rq_mtinscription->fetchObject();

    $query_rq_classe = $dbh->query("SELECT IDCLASSROOM, LIBELLE, IDNIVEAU, IDETABLISSEMENT, IDSERIE, NBRE_ELEVE, EXAMEN, IDNIV 
                                              FROM CLASSROOM 
                                              WHERE IDNIVEAU = ". $colname_niveau_rq_mtinscription);
    $rs_classe = $query_rq_classe->fetchAll();

    $query_rq_transport = $dbh->query("SELECT ID_SECTION, LIBELLE, MONTANT FROM SECTION_TRANSPORT");
    $rs_section = $query_rq_transport->fetchAll();


    $query_rq_moyenp = $dbh->query("SELECT IDMOYEN_PAIEMENT,LIB_MOYEN_PAIEMENT FROM MOYEN_PAIEMENT");
    $rs_moyenp = $query_rq_moyenp->fetchAll();
   // var_dump($rs_moyenp);exit;

    $row_REQ_class = $dbh->query("SELECT T.ROWID, T.LIBELLE, T.MONTANT, n.LIBELLE as LIBCYCLE, T.CYCLE, T.SEXE 
                                            FROM TROUSSEAU T
                                            INNER JOIN NIVEAU n ON n.IDNIVEAU = T.FK_NIVEAU
                                            WHERE T.IDETABLISSEMENT = ".$colname_rq_individu." ORDER BY T.ROWID ASC");
    $rs=$row_REQ_class->fetchAll();


        $query_rq_uniforme = $dbh->query("SELECT ROWID, IDNIVEAU, LIBELLE, MONTANT FROM UNIFORME WHERE IDNIVEAU = " . $colname_niveau_rq_mtinscription);
        $rs_uniforme = $query_rq_uniforme->fetchAll();




    $query_rq_banque = $dbh->query("SELECT ROWID, LABEL FROM BANQUE WHERE ETAT = 1");
    $rs_banque = $query_rq_banque->fetchAll();


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

                <?php if(isset($_GET['msg']) && $_GET['msg'] != '') {

                    if(isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <fieldset class="cadre">
                    <legend> Informations personnels</legend>

                    <div class="row">
                       <!-- <div class="form-group col-lg-6">
                            <label>MATRICULE: </label>&nbsp;&nbsp;
                            <?php /*echo $rq_individu->MATRICULE; */?>
                        </div>-->
                        <div class="form-group col-lg-6">
                            <label>PRENOMS: </label>&nbsp;&nbsp;
                            <?php echo $rq_individu->PRENOMS; ?>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>NOM: </label>&nbsp;&nbsp;
                            <?php echo $rq_individu->NOM; ?>
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>TELEPHONE MOBILE: </label>&nbsp;&nbsp;
                            <?php echo $rq_individu->TELMOBILE; ?>
                        </div>
                        <div class="form-group col-lg-6">
                        </div>
                    </div>
                </fieldset>

                <form action="ficheInscriptionFin.php" method="POST" id="form" class="form-horizontal">
                    <fieldset class="cadre">
                        <legend> Informations d'inscription</legend>
                        <div class="row">

                            <!--<div class="col-lg-12">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>DATE D'INSCRIPTION</label></div>

                                    <div class="col-lg-10"><input type="hidden" name="DATEINSCRIPT" id="date_foo"
                                                                  class="form-control"
                                                                  value="<?php /*echo date("Y-m-d") */?>" readonly/>
                                    </div>
                                </div>

                                <input type="hidden" name="DATEINSCRIPT" id="date_foo"
                                       class="form-control"
                                       value="<?php /*echo date("Y-m-d") */?>" readonly/>
                            </div>
                            <br><br>-->

                            <input type="hidden" name="DATEINSCRIPT" class="form-control" value="<?php echo date("Y-m-d") ?>" readonly/>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>MONTANT DE LA MENSUALITE : </label></div>
                                    <div class="col-lg-10">
                                        <input type="text" name="MONTANT" id="MONTANT" class="form-control" value="<?php echo $row_rq_mtinscription->MT_MENSUALITE; ?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>FRAIS INSCRIPTION : </label></div>

                                    <div class="col-lg-10"><input type="text" name="FRAIS_INSCRIPTION" id="FRAIS_INSCRIPTION" class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_INSCRIPTION; ?>" readonly/>
                                    </div>

                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>PREMIER & DERNIER MOIS : </label></div>
                                    <?php $premdermois= ($row_rq_mtinscription->MT_MENSUALITE * 2) ?>
                                    <div class="col-lg-10"><input type="text" name="premier_derniermois" id="premier_derniermois" class="form-control" value="<?php echo $premdermois; ?>" readonly/>
                                    </div>

                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>ACOMPTE VERSE : </label></div>
                                    <div class="col-lg-10">
                                        <input type="text" name="ACCOMPTE_VERSE" id="ACCOMPTE_VERSE" class="form-control" value="0" required/>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>ACCORD MENSUALITE : </label></div>
                                    <div class="col-lg-10">
                                        <input type="text" name="ACCORD_MENSUELITE" id="ACCORD_MENSUELITE" class="form-control" value="<?php echo $row_rq_mtinscription->MT_MENSUALITE; ?>" required/>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>DERNIER ETABLISSEMENT FREQUENTE : </label></div>
                                    <div class="col-lg-10">
                                        <input type="text" name="DERNIER_ETAB" id="DERNIER_ETAB" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <br><br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>FRAIS DOSSIER : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="FRAIS_DOSSIER" id="FRAIS_DOSSIER" class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_DOSSIER; ?>"/>
                                    </div>

                                    <div class="col-lg-2"><label>ACOMPTE : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="MONTANT_DOSSIER" id="MONTANT_DOSSIER" value="0" class="form-control" required/>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>VACCINATION : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="VACCINATION" id="VACCINATION" class="form-control" value="<?php echo $row_rq_mtinscription->VACCINATION; ?>"readonly/>
                                    </div>

                                    <div class="col-lg-2"><label>ACOMPTE : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="MONTANT_VACCINATION" id="MONTANT_VACCINATION" value="0" class="form-control" required/>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-2"><label>ASSURANCE : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="ASSURANCE" id="ASSURANCE" class="form-control"
                                               value="<?php echo $row_rq_mtinscription->ASSURANCE; ?>"readonly/>
                                    </div>

                                    <div class="col-lg-2"><label>ACOMPTE : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="MONTANT_ASSURANCE" id="MONTANT_ASSURANCE" value="0" class="form-control" required/>
                                    </div>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">

                                <div class="form-group">

                                    <div class="col-lg-2"><label>TRANSPORT : </label></div>
                                    <div class="col-lg-4">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optTransport" value="1"> OUI
                                            </label>
                                            &nbsp;
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optTransport" value="0" checked> NON
                                            </label>
                                        </div>
                                    </div>

                                    <div id="selection" style="display: none;">
                                        <div class="col-lg-2"><label>SECTION : </label></div>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="selectSection" name="selectSection" required>
                                                <option value="">Selectionner une section</option>
                                                <?php
                                                foreach ($rs_section as $rq_section) {?>
                                                    <option value="<?php echo $rq_section['ID_SECTION'] ?>"><?php echo $rq_section['LIBELLE'].' -----> '.$lib->nombre_form($rq_section['MONTANT']).' F CFA';  ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <br><br>

                            <div class="col-lg-12">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>CLASSE : </label></div>
                                    <div class="col-lg-10">
                                        <select id="classe" name="classe" class="form-control" data-live-search="true" required onchange="ClassePleine(); ClasseExamen();getTrousseau();">
                                            <option value="" selected> --Séléctionner une classe-- </option>
                                            <?php foreach ($rs_classe as $rq_classe) { ?>
                                                <option value="<?php echo $rq_classe['IDCLASSROOM'] ?>"><?php echo $rq_classe['LIBELLE'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <br><br>
                            <div class="col-lg-12">

                                <div class="form-group">

                                    <div class="col-lg-2"><label>MOYEN DE PAIEMENT :</label></div>
                                    <div class="col-lg-3">
                                        <div class="col-lg-10">
                                            <select id="FK_MOYENPAIEMENT" name="FK_MOYENPAIEMENT" class="form-control" data-live-search="true" required onchange="getMoyenPaie();">
                                                <option value="" selected> --Séléctionner moyen de paiement-- </option>
                                                <?php foreach ($rs_moyenp as $rq_moyenp) { ?>
                                                    <option value="<?php echo $rq_moyenp['IDMOYEN_PAIEMENT'] ?>"><?php echo $rq_moyenp['LIB_MOYEN_PAIEMENT'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="moyenpaie" style="display: none;">

                                        <div class="col-lg-1"><label>N° CHEQUE : </label></div>
                                        <div class="col-lg-2">
                                            <input type="text" name="NUM_CHEQUE" id="NUM_CHEQUE" class="form-control" required/>
                                        </div>

                                        <div class="col-lg-1"><label>BANQUE :</label></div>
                                        <div class="col-lg-3">
                                            <div class="col-lg-10">
                                                <select id="FK_BANQUE" name="FK_BANQUE" class="form-control" data-live-search="true">
                                                    <option value="" selected> --Séléctionner une banque-- </option>
                                                    <?php foreach ($rs_banque as $row_bq) { ?>
                                                        <option value="<?php echo $row_bq['ROWID']; ?>"><?php echo $row_bq['LABEL']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>






                                    </div>

                                </div>
                            </div>

                            <br><br>

                            <div class="col-lg-12">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>TROUSSEAU : </label></div>
                                    <div class="col-lg-4">
                                        <div class="form-check-inline">

                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optTrousseau" id="pas" value="0" onchange="showTrousseau();" required> Pas de trousseau
                                            </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optTrousseau" id="complet" value="1" onchange="showTrousseau();"> Complet
                                            </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optTrousseau" id="ncomplet" value="2" onchange="showTrousseau();"> Non complet
                                            </label>

                                        </div>
                                    </div>

                                    <div id="trousseau" style="display: none;">
                                        <div class="col-lg-2"><label>CHOISIR TROUSSEAU : </label></div>

                                        <div class="col-lg-4">
                                            <select name="UNIFORME" id="selectSerie" class="form-control" data-live-search="true" required>
                                                <option value="">VEUILLEZ CHOISIR UN TROUSSEAU</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-12" id="Acompte_trousseau" style="display: none;margin-bottom: 10px">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>ACOMPTE TROUSSEAU : </label></div>
                                    <div class="col-lg-4">
                                        <input type="number" name="MONTANT_UNIFORME" id="MONTANT_UNIFORME" value="0" class="form-control" required/>
                                    </div>

                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-4">
                                    </div>
                                </div>

                            </div>

                            <br><br>

                            <div class="col-lg-12">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>AVANCE MENSUALITE : </label></div>
                                    <div class="col-lg-4">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optAvance" id="non" value="0" onchange="showAvance();" checked> NON
                                            </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optAvance" id="oui" value="1" onchange="showAvance();"> OUI
                                            </label>
                                        </div>
                                    </div>
                                    <div id="avance" style="display: none;">
                                        <div class="col-lg-2"><label>Nombre de mois : </label></div>
                                        <div class="col-lg-4">
                                            <input type="number" name="nombremois" id="nombremois" value="0" max="<?php echo $difference?>" class="form-control" required/>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <br><br>

                            <div class="col-lg-12" id="f_exam" style="display: none;">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>FRAIS EXAMEN : </label></div>
                                    <div class="col-lg-4">
                                        <input type="number" name="FRAIS_EXAMEN" id="FRAIS_EXAMEN" class="form-control" required/>
                                    </div>

                                    <div class="col-lg-2"><label>ACOMPTE : </label></div>
                                    <div class="col-lg-4">
                                        <input type="text" name="MONTANT_EXAMEN" id="MONTANT_EXAMEN" value="0" class="form-control" required/>
                                    </div>
                                </div>

                            </div>
                            <br><br>


                            <input type="hidden" name="STATUT" value=""/>
                            <input type="hidden" name="IDINDIVIDU" id="IDINDIVIDU" value="<?php echo $lib->securite_xss($_POST['IDINDIVIDU']); ?>"/>
                            <input type="hidden" name="MATRICULE" id="MATRICULE" value="<?php if($colname_rq_matricule!="-1") echo $colname_rq_matricule; ?>"/>
                            <input type="hidden" name="IDSERIE" value="<?php echo $lib->securite_xss(base64_encode($_POST['IDSERIE'])); ?>"/>
                            <input type="hidden" name="IDNIVEAU"  value="<?php echo $lib->securite_xss(base64_encode($_POST['IDNIVEAU'])); ?>"/>
                            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss(base64_encode($_SESSION['etab'])); ?>"/>
                            <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo $lib->securite_xss(base64_encode($_SESSION['ANNEESSCOLAIRE'])); ?>"/>
                            <input type="hidden" name="VALIDETUDE" value=""/>
                            <input type="hidden" name="RESULTAT_ANNUEL" value=""/>

                            <input type="hidden" id="cycle" value="<?php echo $lib->securite_xss($_POST['IDNIVEAU']); ?>"/>
                            <input type="hidden" id="genre" value="<?php echo $rq_individu->SEXE; ?>"/>

                            <input type="hidden" name="montantT" id="montantT" class="form-control"  />

                            <div class="col-lg-offset-5 col-lg-1">
                                <input name="" type="submit" value="Valider inscription" id="inscrire" class="btn btn-success" />
                            </div>

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


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="alertModal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 60%">
    <div class="modal-content">
        <div class="panel panel-default">
            <!--<div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>-->

            <form id="form2" name="form2" method="post" action="ajouterTrousseau.php">

                <fieldset class="cadre">
                    <legend> INFORMATIONS TROUSSEAU</legend>

                    <div class="row" style="padding-bottom: 10px!important;">
                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="nom" class="col-lg-4 col-sm-4 control-label">UNIFORMES</label>
                            <label for="nom" class="col-lg-4 col-sm-4 control-label">NOMBRES</label>
                            <label for="nom" class="col-lg-4 col-sm-4 control-label">MONTANTS</label>
                        </div>

                    </div>
                    <hr style="font-weight: bold;color: #00a8c6"/>

                    <?php
                    $i=0;
                    foreach ($rs_uniforme as $rs_rq_uniforme) {?>

                        <div class="row" style="padding-bottom: 10px!important;">
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="nom" class="col-lg-3 col-sm-3 control-label"><?php echo $rs_rq_uniforme['LIBELLE'];?> : </label>

                                <div class="col-lg-5 col-sm-5">
                                    <input type="hidden" name="FK_uniform[]" id="FK_uniforme<?php echo $rs_rq_uniforme['ROWID']?>" class="form-control" value="<?php echo $rs_rq_uniforme['ROWID']?>" />
                                    <input type="number" name="nombre[]" id="nombre<?php echo$i;?>" class="form-control" min="0" placeholder="Nombre" value="0" required disabled onchange="valider();"/>
                                </div>

                                <div class="col-lg-3 col-sm-3">
                                    <input type="text" name="montant[]" id="montant<?php echo$i;?>" class="form-control" value="<?php echo $rs_rq_uniforme['MONTANT']?>" readonly />
                                </div>

                                <div class="col-lg-1 col-sm-1">
                                    <input type="checkbox" id="choix<?php echo$i; ?>" name="choix" value="<?php echo $i; ?>" onclick="valider()"/>
                                </div>

                            </div>
                        </div>

                        <?php $i=$i+1;
                    }  ?>


                    <div class="row">
                        <div class="col-xs-offset-6 col-xs-1">
                            <div class="form-group">
                                <input type="hidden" name="nbreligne" id="nbreligne" class="form-control" value="<?php echo$i; ?>"  />
                                <input type="button" class="btn btn-success" data-dismiss="modal" id="terminer" value="Terminer" />
                            </div>
                        </div>
                    </div>

                </fieldset>

            </form>

        </div>

    </div>
</div>
</div>



<?php include('footer.php');?>

<script>

    $("input").on('click', function () {
        if($("input:checked").val() == "1"){
            $("#selection").css('display','block')
        }else{
            $("#selection").css('display','none');
            $('#selectSection').val("");
        }
    });

    function valider()
    {
        var nbre = $("#nbreligne").val();
        var i = 0;
        var tot = 0;
        var caltot = 0;
        for(i=0; i < nbre; i++)
        {
            var nombre = $("#nombre"+i).val();
            var mnt = $("#montant"+i).val();

            if(document.getElementById('choix'+i).checked == true)
            {
                    $('#nombre'+i).removeAttr('disabled');
                    caltot= nombre*mnt ;
                    tot=tot+caltot;
            }
            else
            {
                $('#nombre'+i).attr('disabled','disabled');
            }
        }
        document.getElementById("montantT").value = tot;
    }

    function showTrousseau()
    {
        var valBtRadio = $('input[name=optTrousseau]:checked').val()
        if(valBtRadio == "1")
        {
            $("#trousseau").css('display','block');
            $("#Acompte_trousseau").css('display','block');
        }
        else if(valBtRadio == "2")
        {
            $("#trousseau").css('display','none');
            $("#Acompte_trousseau").css('display','none');
            $('#selectSerie').val("");
            $('#alertModal').modal('show');
        }
        else
        {
            $("#trousseau").css('display','none');
            $("#Acompte_trousseau").css('display','none');
            $('#selectSerie').val("");
        }
    }

    function ClassePleine()
    {
        var valSel = $("#classe").val();
        if(valSel !=''){
            $.ajax({
                type: "POST",
                url: "getNombrePlace.php",
                data: "idclasse=" + valSel,
                success: function (data) {
                    data = JSON.parse(data);
                   if(data==1){
                       alert("Cette classe est pleine veuillez choisir un autre!!!");
                       $('#inscrire').css("display","none");
                   }else{
                       $('#inscrire').css("display","block");
                   }
                }
            });
        }
    }

    function ClasseExamen()
    {
        var valSel = $("#classe").val();
        if(valSel !=''){
            $.ajax({
                type: "POST",
                url: "getClasseExam.php",
                data: "idclasse=" + valSel,
                success: function (data) {
                    data = JSON.parse(data);
                   if(data==1){
                       $('#f_exam').css("display","block");
                   }else{
                       $('#f_exam').css("display","none");
                   }
                }
            });
        }
    }

    function getTrousseau()
    {
        var selectedClasse = $("#classe").find("option:selected").val()
        var cycle = $("#cycle").val();
        var genre = $("#genre").val();

        if(selectedClasse != "") {
            $.ajax({
                method: "POST",
                url: "requestTrousseau.php",
                data: {
                    classe: selectedClasse,
                    IDNIVEAU: cycle,
                    sexe: genre
                }
            }).done(function (data) {
                var data = $.parseJSON(data)
                $('#selectSerie').children('option:not(:first)').remove()
                $('#selectSerie').selectpicker('refresh')
                for (i = 0, len = data.length; i < len; i++){
                    $('#selectSerie').append(new Option(data[i].LIBELLE+' -- '+data[i].MONTANT, data[i].MONTANT))
                    $('#selectSerie').selectpicker('refresh')
                }
            })
        }
    }

    function getMoyenPaie() {
        var moyen = $("#FK_MOYENPAIEMENT").val();
        if (moyen==2){
            $('#moyenpaie').css("display","block");
        }else{
            $('#moyenpaie').css("display","none");
        }
    }

    function showAvance()
    {
        var valBtRadio = $('input[name=optAvance]:checked').val();
        if(valBtRadio == "1")
        {
            $("#avance").css('display','block')
        }
        else
        {
            $("#avance").css('display','none');
            $('#selectSerie').val("");
        }
    }


</script>
