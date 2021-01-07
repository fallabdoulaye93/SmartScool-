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
    $lib->Restreindre($lib->Est_autoriser(20, $lib->securite_xss($_SESSION['profil'])));

$anne_scolaire = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $anne_scolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}
$etablissement = "-1";
if (isset($_SESSION['etab'])) {
    $etablissement = $lib->securite_xss($_SESSION['etab']);
}



if(isset($_GET['IDCONTROLE'])){
    $colname_rq_controle = $lib->securite_xss(base64_decode($_GET['IDCONTROLE']));
}

try
{
    $query_rq_periode = $dbh->query("SELECT PERIODE.NOM_PERIODE, PERIODE.IDPERIODE 
                                               FROM PERIODE 
                                               WHERE PERIODE.IDANNEESSCOLAIRE = " . $anne_scolaire . " 
                                               AND PERIODE.IDETABLISSEMENT = " . $etablissement);


    $query_rq_niveauClasse = $dbh->query("SELECT ID, LIBELLE
                                               FROM NIV_CLASSE 
                                               WHERE IDETABLISSEMENT = " . $etablissement);


    $query_rq_typecontrole = $dbh->query("SELECT * FROM TYP_CONTROL");


    $query_rq_individu_type = $dbh->query("SELECT * FROM INDIVIDU WHERE IDETABLISSEMENT = " . $etablissement . " AND IDTYPEINDIVIDU = 7");

    $query_rq_controle = $dbh->query("SELECT IDCONTROLE, LIBELLE_CONTROLE, DATEDEBUT, DATEFIN, IDCLASSROOM, IDMATIERE, IDINDIVIDU, IDTYP_CONTROL, IDPERIODE, FK_NIVEAU
                                                FROM CONTROLE WHERE IDCONTROLE = ".$colname_rq_controle);
    $result = $query_rq_controle->fetchObject();
    $individu = "-1";
    if ($result!= null)
    {
        $individu = $result->IDINDIVIDU;
    }

//var_dump($result);exit;
    $query_rq_classe = $dbh->query("SELECT RECRUTE_PROF.IDRECRUTE_PROF, CLASSROOM.IDCLASSROOM, CLASSROOM.LIBELLE 
                                              FROM RECRUTE_PROF, CLASSROOM, CLASSE_ENSEIGNE
                                              WHERE RECRUTE_PROF.IDRECRUTE_PROF = CLASSE_ENSEIGNE.IDRECRUTE_PROF 
                                              AND CLASSE_ENSEIGNE.IDCLASSROM = CLASSROOM.IDCLASSROOM
                                              AND RECRUTE_PROF.IDINDIVIDU = ".$individu." 
                                              AND RECRUTE_PROF.IDANNEESSCOLAIRE = ".$anne_scolaire." 
                                              GROUP BY CLASSROOM.IDCLASSROOM");
    $rs_classe = $query_rq_classe->fetchAll();

    $query_rq_matiere = $dbh->query("SELECT RECRUTE_PROF.IDRECRUTE_PROF, MATIERE.LIBELLE, MATIERE.IDMATIERE 
                                               FROM RECRUTE_PROF, MATIERE, MATIERE_ENSEIGNE
                                               WHERE RECRUTE_PROF.IDINDIVIDU = MATIERE_ENSEIGNE.ID_INDIVIDU 
                                               AND MATIERE_ENSEIGNE.ID_MATIERE = MATIERE.IDMATIERE 
                                               AND RECRUTE_PROF.IDINDIVIDU = ".$individu."  
                                               AND RECRUTE_PROF.IDANNEESSCOLAIRE = ".$anne_scolaire);
   // var_dump($query_rq_matiere);exit;

    $rs_matiere = $query_rq_matiere->fetchAll();

    $query_rq_prof = $dbh->query("SELECT RECRUTE_PROF.IDRECRUTE_PROF, RECRUTE_PROF.TARIF_HORAIRE, RECRUTE_PROF.VOLUME_HORAIRE, INDIVIDU.MATRICULE, INDIVIDU.NOM, 
                                            INDIVIDU.PRENOMS, MATIERE.LIBELLE as matiere, CLASSROOM.LIBELLE as classe, INDIVIDU.PHOTO_FACE, INDIVIDU.IDINDIVIDU 
                                            FROM RECRUTE_PROF, INDIVIDU, MATIERE, CLASSROOM, MATIERE_ENSEIGNE, CLASSE_ENSEIGNE
                                            WHERE RECRUTE_PROF.IDETABLISSEMENT= ".$etablissement."
                                            AND RECRUTE_PROF.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                            AND RECRUTE_PROF.IDINDIVIDU = MATIERE_ENSEIGNE.ID_INDIVIDU 
                                            AND MATIERE_ENSEIGNE.ID_MATIERE = MATIERE.IDMATIERE 
                                            AND RECRUTE_PROF.IDRECRUTE_PROF = CLASSE_ENSEIGNE.IDRECRUTE_PROF 
                                            AND CLASSE_ENSEIGNE.IDCLASSROM = CLASSROOM.IDCLASSROOM 
                                            AND RECRUTE_PROF.IDANNEESSCOLAIRE = ".$anne_scolaire."
                                            GROUP BY INDIVIDU.IDINDIVIDU ");
    $rs_prof = $query_rq_prof->fetchAll();
}
catch(PDOException $e)
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

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>

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
                    <legend>
                        <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "DETAIL DU CONTROLE" : "MODIFICATION DU CONTROLE" ;?>
                    </legend>
                    <form action="validerControle.php" method="post" name="form1" id="form1">
                        <div class="form-group col-lg-6">
                            <label>Professeur :</label>
                            <select name="IDINDIVIDU" id="IDINDIVIDU" class="form-control selectpicker" data-live-search="true" onchange="controlButton();" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>>
                                <option value="">--Selectionner--</option>
                                <?php foreach ($rs_prof as $row_rq_prof) { ?>
                                    <option value="<?php echo base64_encode($row_rq_prof['IDINDIVIDU']) ?>"<?php echo $result->IDINDIVIDU == $row_rq_prof['IDINDIVIDU'] ? "selected": " ";?> ><?php echo $row_rq_prof['PRENOMS']."  "; ?><?php echo $row_rq_prof['NOM'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Type controle :</label>
                            <select name="IDTYP_CONTROL" class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" id="IDTYP_CONTROL" required onchange="controlButton();" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>>
                                <option value="">--Selectionner--</option>

                                <?php foreach ($query_rq_typecontrole->fetchAll() as $row_rq_typecontrole) { ?>

                                    <option value="<?php echo $row_rq_typecontrole['IDTYP_CONTROL']; ?>" <?php echo $result->IDTYP_CONTROL == $row_rq_typecontrole['IDTYP_CONTROL'] ? "selected": " ";?> ><?php echo $row_rq_typecontrole['LIB_TYPCONTROL']; ?></option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-12">
                            <label>LIBELLE :</label>
                            <input name="LIBELLE_CONTROLE" type="text" class="form-control" value="<?php echo $result->LIBELLE_CONTROLE;?>" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?> required/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Niveau :</label>
                            <select name="nivclass" class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" id="nivclass" required onchange="controlButton();" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>>
                                <option value="">--Selectionner--</option>

                                <?php foreach ($query_rq_niveauClasse->fetchAll() as $row_rq_nivClasse) { ?>

                                    <option value="<?php echo $row_rq_nivClasse['ID']; ?>" <?php echo $result->FK_NIVEAU == $row_rq_nivClasse['ID'] ? "selected": " ";?> ><?php echo $row_rq_nivClasse['LIBELLE']; ?></option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Periode</label>
                            <select name="IDPERIODE" id="IDPERIODE" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"
                                    required onchange="controlButton();" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>>
                                <option value="">--Selectionner--</option>

                                <?php foreach ($query_rq_periode->fetchAll() as $row_rq_periode) { ?>

                                    <option value="<?php echo $row_rq_periode['IDPERIODE']; ?>" <?php echo $result->IDPERIODE == $row_rq_periode['IDPERIODE'] ? "selected": " ";?>><?php echo $row_rq_periode['NOM_PERIODE']; ?></option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Classe :</label>
                            <select name="IDCLASSROOM" id="IDCLASSROOM" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"
                                    required onchange="controlButton()" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>>
                                <option value="">--Selectionner--</option>

                                <?php foreach ($rs_classe as $row_rq_classe) { ?>

                                    <option value="<?php echo $row_rq_classe['IDCLASSROOM']; ?>" <?php echo $result->IDCLASSROOM == $row_rq_classe['IDCLASSROOM'] ? "selected": " ";?>><?php echo $row_rq_classe['LIBELLE']; ?></option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Matiere :</label>

                            <select name="IDMATIERE" id="IDMATIERE" class="form-control selectpicker" data-show-subtext="true" data-live-search="true"
                                    required onchange="controlButton();" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>>
                                <option value="">--Selectionner--</option>

                                <?php foreach ($rs_matiere as $row_rq_matiere) { ?>

                                    <option value="<?php echo $row_rq_matiere['IDMATIERE']; ?>"<?php echo $result->IDMATIERE == $row_rq_matiere['IDMATIERE'] ? "selected": " ";?> ><?php echo $row_rq_matiere['LIBELLE']; ?></option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Date debut :</label>
                            <input name="DATEDEBUT" id="date_foo" type="text" class="form-control" value="<?php echo $result->DATEDEBUT;?>" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "readonly" : "" ;?> required/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Date fin :</label>
                            <input name="DATEFIN" id="date_foo2" type="text" class="form-control" value="<?php echo $result->DATEFIN;?>" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "readonly" : "" ;?> required/>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-md-11"><a class="btn btn-warning" href="gestionControle.php" role="button">Retour</a></div>
                            <div class="col-md-1"><input type="submit" id="idvalider" value="MODIFIER" class="btn btn-success" <?php echo $lib->securite_xss(base64_decode($_GET['detail'])) == 1 ? "disabled" : "" ;?>/></div>
                        </div>


                        <input type="hidden" name="IDINDIVIDU" value="<?php echo $result->IDINDIVIDU; ?>"/>
                        <input type="hidden" name="IDCONTROLE" value="<?php echo base64_encode($result->IDCONTROLE); ?>"/>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo base64_encode($_SESSION['etab']); ?>"/>
                        <input type="hidden" name="NOTER" value=""/>
                        <input type="hidden" name="VALIDER" value="0"/>
                        <input type="hidden" name="modif" value="<?php echo base64_encode(1); ?>"/>

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
        var selectedINDIV = $("#IDINDIVIDU").find("option:selected").val()
        var selectedIDTYP = $("#IDTYP_CONTROL").find("option:selected").val()
        var selectedIDPE = $("#IDPERIODE").find("option:selected").val()
        var selectedIDC = $("#IDCLASSROOM").find("option:selected").val()
        var selectedIDM = $("#IDMATIERE").find("option:selected").val()


        if(selectedINDIV != "" && selectedIDTYP != "" && selectedIDPE != "" && selectedIDC != "" && selectedIDM != "" ) {
            $('#idvalider').css("display","block")
        }else{
            $('#idvalider').css("display","none")
        }
    }
</script>
