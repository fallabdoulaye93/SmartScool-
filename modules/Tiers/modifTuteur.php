<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(35, $lib->securite_xss($_SESSION['profil'])));



if (isset($_POST) && $_POST != null) {
    require_once("classe/IndividuManager.php");
    require_once("classe/Individu.php");
    $ind = new IndividuManager($dbh, 'INDIVIDU');

    $res = $ind->modifier($lib->securite_xss_array($_POST), 'IDINDIVIDU', $lib->securite_xss($_POST['IDINDIVIDU']));
    if ($res == 1) {
        $msg = "Modification effectuée avec succès";
    } else {
        $msg = "Votre modification a échoué";
    }
    header("Location: listeTuteurs.php?msg=" . $msg . "&res=" . $res);
}else{
    require_once('../Parametrage/classe/ProfileManager.php');
    $profiles = new ProfileManager($dbh, 'profil');
    $profil = $profiles->getProfiles();

    $colname_rq_individu = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
    }
    $query_rq_individu = $dbh->query("SELECT `IDINDIVIDU`, `MATRICULE`, `NOM`, `PRENOMS`, `DATNAISSANCE`, `ADRES`, `TELMOBILE`, `TELDOM`, `COURRIEL`, `LOGIN`, `MP`, `CODE`, `BIOGRAPHIE`, `PHOTO_FACE`, `IDETABLISSEMENT`,
                                                  `IDTYPEINDIVIDU`, `SEXE`, `IDTUTEUR`, `LIEN_PARENTE`, `ANNEEBAC`, `NATIONNALITE`, `SIT_MATRIMONIAL`, `NUMID`, `IDSECTEUR`, `LIEU_TRAVAIL`, `PATHOLOGIE`, `ALLERGIE`, `MEDECIN_TRAITANT`
                                                FROM `INDIVIDU`
                                                WHERE IDINDIVIDU = " . base64_decode($lib->securite_xss($_GET['idIndividu'])));
    /* IDINDIVIDU MATRICULE NOM PRENOMS DATNAISSANCE ADRES TELMOBILE TELDOM COURRIEL LOGIN MP CODE BIOGRAPHIE PHOTO_FACE IDETABLISSEMENT IDTYPEINDIVIDU SEXE IDPERE IDMERE IDTUTEUR ANNEEBAC NATIONNALITE SIT_MATRIMONIAL NUMID  */
    foreach ($query_rq_individu->fetchAll() as $row_rq_individu) {

        $id = $row_rq_individu['IDINDIVIDU'];
        $idprofil = $row_rq_individu['IDTYPEINDIVIDU'];
        $MATRICULE = $row_rq_individu['MATRICULE'];
        $CODE = $row_rq_individu['CODE'];
        $NOMINDIVIDU = $row_rq_individu['NOM'];
        $PRENOMS = $row_rq_individu['PRENOMS'];
        $DATNAISSANCE = $row_rq_individu['DATNAISSANCE'];
        $ADRES = $row_rq_individu['ADRES'];
        $TELMOBILE = $row_rq_individu['TELMOBILE'];
        $TELDOM = $row_rq_individu['TELDOM'];
        $COURRIEL = $row_rq_individu['COURRIEL'];
        $BIOGRAPHIE = $row_rq_individu['BIOGRAPHIE'];
        $SIT_MATRIMONIAL = $row_rq_individu['SIT_MATRIMONIAL'];
        $NUMID = $row_rq_individu['NUMID'];
        $ANNEEBAC = $row_rq_individu['ANNEEBAC'];
        $NATIONNALITE = $row_rq_individu['NATIONNALITE'];
        $SEXE = $row_rq_individu['SEXE'];
        $PHOTO_FACE = $row_rq_individu['PHOTO_FACE'];

    }
//    echo "<pre>";var_dump($profil[0]->getIdProfil());exit;
}
?>


<?php include('header.php'); ?>
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Param&eacute;trage</a></li>
        <li>Liste individus</li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <!-- START WIDGETS -->
        <div class="row">

            <form action="modifTuteur.php" method="POST" enctype="multipart/form-data" id="form">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Type individu:</label>
                            <div>
                                <select name="IDTYPEINDIVIDU" class="form-control" data-live-search="true">
                                    <?php
                                    foreach ($profil as $profile) {

                                        ?>
                                        <option
                                                value="<?php echo $profile->getIdProfil(); ?>" <?php if ($idprofil == $profile->getIdProfil()) echo "selected"; ?>><?php echo $profile->getProfil(); ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <fieldset class="cadre">

                        <legend>INFORMATIONS GENERALES</legend>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>MATRICULE</label>

                                <div>
                                    <input type="text" name="MATRICULE" id="MATRICULE" required class="form-control"
                                           value="<?php echo $MATRICULE; ?>" readonly/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>CODE BARRE</label>

                                <div>
                                    <input type="text" name="CODE" id="CODE" required class="form-control"
                                           value="<?php echo $CODE; ?>" readonly/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>PRENOMS</label>

                                <div>
                                    <input type="text" name="PRENOMS" id="PRENOMS" required class="form-control"
                                           value="<?php echo $PRENOMS; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>NOM</label>

                                <div>
                                    <input type="text" name="NOM" id="NOM" required class="form-control"
                                           value="<?php echo $NOMINDIVIDU; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>DATE DE NAISSANCE</label>

                                <div>
                                    <input type="text" name="DATNAISSANCE" id="date_foo" required class="form-control"
                                           value="<?php echo $DATNAISSANCE; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>ADRESSE</label>

                                <div>
                                    <input type="text" name="ADRES" id="ADRES" required class="form-control"
                                           value="<?php echo $ADRES; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>TELEPHONE MOBILE</label>

                                <div>
                                    <input type="tel" name="TELMOBILE" id="TELMOBILE" required class="form-control"
                                           value="<?php echo $TELMOBILE; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>SEXE</label>

                                <div>
                                    <input type="radio" name="SEXE" value="1" <?php if ($SEXE == 1) echo "checked"; ?>/>&nbsp;Masculin
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="SEXE" type="radio" value="0" <?php if ($SEXE == 0) echo "checked"; ?> />&nbsp;Feminin
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>TELEPHONE DOMICILE</label>

                                <div>
                                    <input type="tel" name="TELDOM" id="TELDOM" class="form-control"
                                           value="<?php echo $TELDOM; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>COURRIEL</label>

                                <div>
                                    <input type="email" onchange="validateMail();" name="COURRIEL" id="COURRIEL" required class="form-control"
                                           value="<?php echo $COURRIEL; ?>"/>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>BIOGRAPHIE</label>

                                <div>
                                <textarea name="BIOGRAPHIE" id="mytextarea"
                                          class="form-control"><?php echo $BIOGRAPHIE; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>ANNEE BAC</label>

                                <div>
                                    <input type="number" name="ANNEEBAC" id="ANNEEBAC" required class="form-control"
                                           value="<?php echo $ANNEEBAC; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>NATIONALITE</label>

                                <div>
                                    <select name="NATIONNALITE" id="NATIONNALITE" data-live-search="true">
                                        <option value="22">SENEGAL</option>

                                        <?php
                                        $requete = $dbh->query("select ROWID, LIBELLE from PAYS");
                                        foreach ($requete->fetchAll() as $row_rq_pays) {
                                            ?>
                                            <option
                                                    value="<?php echo $row_rq_pays['ROWID'] ?>" <?php if ($NATIONNALITE == $row_rq_pays['ROWID']) echo "selected"; ?>><?php echo $row_rq_pays['LIBELLE'] ?></option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>SITUATION MATRIMONIALE</label>

                                <div>
                                    <select name="SIT_MATRIMONIAL" id="SIT_MATRIMONIAL">
                                        <option
                                                value="Celibataire sans enfant" <?php if ($SIT_MATRIMONIAL == "Celibataire sans enfant") echo "selected"; ?>>
                                            Celibataire sans enfant
                                        </option>
                                        <option
                                                value="celibataire avec enfant" <?php if ($SIT_MATRIMONIAL == "celibataire avec enfant") echo "selected"; ?>>
                                            celibataire avec enfant
                                        </option>
                                        <option
                                                value="Marié(e) sans enfant" <?php if ($SIT_MATRIMONIAL == "Marié(e) sans enfant") echo "selected"; ?>>
                                            Marié(e) sans enfant
                                        </option>
                                        <option
                                                value="Marié(e) avec enfant" <?php if ($SIT_MATRIMONIAL == "Marié(e) avec enfant") echo "selected"; ?>>
                                            Marié(e) avec enfant
                                        </option>
                                        <option
                                                value="Veuf(ve) sans enfant" <?php if ($SIT_MATRIMONIAL == "Veuf(ve) sans enfant") echo "selected"; ?>>
                                            Veuf(ve) sans enfant
                                        </option>
                                        <option
                                                value="Veuf(ve) avec enfant" <?php if ($SIT_MATRIMONIAL == "Veuf(ve) avec enfant") echo "selected"; ?>>
                                            Veuf(ve) avec enfant
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>NUMERO IDENTIFICATION</label>

                                <div>
                                    <input type="text" name="NUMID" id="NUMID" required class="form-control"
                                           value="<?php echo $NUMID; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>PHOTO</label>

                                <div>
                                    <input type="file" name="PHOTO_FACE" id="PHOTO_FACE" class="form-control" value=""/>
                                    <img src="../../imgtiers/<?php echo $PHOTO_FACE; ?>" alt="" width="41px" height="41px"/>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                    <!--   <fieldset class="cadre"> <legend >INFORMATION TUTEURS</legend>

                                      <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >NOM TUTEUR</label>
                                                <div>
                                                    <input type="text" name="NOMTUTEUR" id="NOMTUTEUR" required class="form-control"/>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >PRENOMS TUTEUR</label>
                                                <div>
                                                    <input type="text" name="PRENOMSTUTEUR" id="PRENOMSTUTEUR" required class="form-control"/>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >TEL MOBILE TUTEUR</label>
                                                <div>
                                                    <input type="text" name="TELMOBILETUTEUR" id="TELMOBILETUTEUR" required class="form-control"/>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >COURRIEL TUTEUR</label>
                                                <div>
                                                    <input type="text" name="COURRIELTUTEUR" id="COURRIELTUTEUR" required class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                        </fieldset>-->

                </div>

                <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>
                <input type="hidden" name="IDINDIVIDU" value="<?php echo $id; ?>"/>

                <button type="submit" id="validerAj" class="btn btn-primary center-block">Modifier</button>
                <div style="height: 50px;"></div>
            </form>

            <script>
                //        var test = false;
                function validateMail()
                {
                    var mailteste = $('#COURRIEL').val();
                    var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
                    if(reg.test(mailteste)){
                        $('#validerAj').removeClass("disabled");
//                test = true;
                    }else{
                        $('#validerAj').addClass("disabled");
//                test = false;
                        alert("Veuillez saisir un courriel valide")
                    }
                }

                //        function validateType()
                //        {
                //            var valSel = $('#form').find('select[name=choix-select]').val();
                //            if(valSel != "non-sel"){
                //                $('#validerAj').removeClass("disabled");
                //            }else{
                //                test = false;
                //                alert("Veillez choisir un type d'individu valide");
                //            }
                //        }

                //        function validateFormOver()
                //        {
                //            var valSel = $('#form').find('select[name=choix-select]').val()
                //            if(valSel == "non-sel" && test){
                //                $('#validerAj').addClass("disabled");
                //                alert("Veillez choisir un type d'individu valide");
                //            }else if(valSel != "non-sel" && !test){
                //                $('#validerAj').addClass("disabled");
                //                alert("Veillez saisir un courriel valide")
                //            }else if(valSel == "non-sel" && !test) {
                //                $('#validerAj').addClass("disabled");
                //                alert("Veillez choisir un type d'individu et saisir un courriel valide")
                //            }
                //        }

                //        function myEfface()
                //        {
                //            (!$('#mceu_29').hasClass("hidden")) ? $('#mceu_29').addClass("hidden") : null ;
                //        }
            </script>

            <!-- END WIDGETS -->


        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>