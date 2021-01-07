<?php
session_start();

require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once('classe/UtilisateurManager.php');
require_once('classe/Utilisateur.php');
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$profily = $lib->securite_xss($_SESSION['profil']);
if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(2, $profily));

require_once('classe/ProfileManager.php');
$profiles = new ProfileManager($dbh, 'profil');
$profil = $profiles->getProfiles();

try
{
    $query_rq_profil = $dbh->query("SELECT idProfil, profil FROM profil WHERE idProfil not in (7,8,9) AND etat = 1");
    $rs_profil = $query_rq_profil->fetchAll();

    $query_rq_profil2 = $dbh->query("SELECT idProfil, profil FROM profil WHERE idProfil not in (7,8,9) AND etat = 1");
    $rs_profil2 = $query_rq_profil2->fetchAll();
}
catch (PDOException $e){
    return -2;
}



$colname_REQ_users = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_users = $lib->securite_xss($_SESSION['etab']);
}

$colname_type = " ";
if (isset($_POST['idProfil']) && $_POST['idProfil'] != "") {
    $colname_type = "  AND idProfil =" . $lib->securite_xss($_POST['idProfil']);
}
else{
    $colname_type = " ";
}

try{
    $query_REQ_users = $dbh->query("SELECT * FROM UTILISATEURS WHERE idEtablissement = " . $colname_REQ_users . " " . $colname_type);
}
catch (PDOException $exception){
    echo -2;
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Parametrage</a></li>
    <li>Utilisateurs</li>
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
                    <button data-toggle="modal" data-target="#ajoutUser"
                            style="background-color:#DD682B" class='btn dropdown-toggle' , aria-hidden='true'>
                        <i class="fa fa-plus"></i> Nouvel utilisateur
                    </button>

                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <form id="form" name="form1" method="post" action="utilisateurs.php" class="form-inline">
                    <fieldset class="cadre">
                        <legend> FILTRE</legend>


                        <div class="form-group col-lg-6">
                            <div class="col-lg-1">
                                <label>Profil: </label></div>
                                <div class="col-lg-5">
                                    <select name="idProfil" id="idProfil" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="" selected>--Séléctionner un profil--</option>
                                        <?php foreach ($rs_profil as $prof) { ?>
                                            <option value="<?php echo $prof['idProfil']; ?>" <?php if ($prof['idProfil'] == $lib->securite_xss($_POST['idProfil'])) echo "selected"; ?>><?php echo $prof['profil']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        </div>


                        <div class="form-group col-lg-1">
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </div>

                    </fieldset>
                </form>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>MATRICULE</th>
                        <th>PRENOMS</th>
                        <th>NOM</th>
                        <th>EMAIL</th>
                        <th>TELEPHONE</th>
                        <th style="text-align: center !important;">ETAT</th>

                        <?php if ($profily == 1 || ($lib->Est_autoriser(2, $profily) == 1)) { ?>
                            <th style="width: 100px; text-align: center !important;">Modifier</th>
                        <?php } ?>
                        <?php if ($profily == 1 || ($lib->Est_autoriser(2, $profily) == 1)) { ?>
                            <th style="width: 100px; text-align: center !important;">Supprimer</th>
                        <?php } ?>
                        <?php if ($profily == 1 || ($lib->Est_autoriser(2, $profily) == 1)) { ?>
                            <th style="width: 200px;text-align: center !important;">Regénérer mot de passe</th>
                        <?php } ?>
                    </tr>
                    </thead>


                    <tbody>
                    <?php
                    foreach ($query_REQ_users->fetchAll() as $user) {

                        ?>
                        <tr>
                            <td><?php echo $user['matriculeUtilisateur']; ?></td>
                            <td><?php echo $user['prenomUtilisateur']; ?></td>
                            <td><?php echo $user['nomUtilisateur']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['telephone']; ?></td>
                            <td <?php  if($user['ETAT'] == 1) echo 'style="color: green !important;"'; else echo 'style="color: red !important;"'?> align="center">

                                <?php  if($user['ETAT'] == 1) echo 'Activé'; else echo 'Désactivé'?>

                            </td>

                            <?php if ($profily == 1 || ($lib->Est_autoriser(2, $profily) == 1)) { ?>

                                <td align="center">
                                    <a href="modifUser.php?idUtilisateur=<?php echo $lib->affichage_xss(base64_encode($user['idUtilisateur'])); ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                </td>

                            <?php } if ($profily == 1 || ($lib->Est_autoriser(2, $profily) == 1)) { ?>

                                <td style="text-align: center" valign="middle" align="center">

                                    <?php if($user['ETAT'] == 0) { ?>

                                    <a title="Activer utilisateur" href="suppUser.php?activer=<?php echo $lib->securite_xss(base64_encode($user['idUtilisateur']));?>&etat=1"
                                       onclick="return(confirm('Etes-vous s&ucirc;r de vouloir activer l\'utilisateur <?= $user['prenomUtilisateur']." ". $user['nomUtilisateur']; ?> ?'));">
                                        <i class=" glyphicon glyphicon-ok" style="color: green !important;"></i>
                                    </a>

                                    <?php }  if($user['ETAT'] == 1) { ?>

                                    <a title="Désactiver utilisateur" href="suppUser.php?desactiver=<?php echo $lib->securite_xss(base64_encode($user['idUtilisateur']));?>&etat=0"
                                       onclick="return(confirm('Etes-vous s&ucirc;r de vouloir désactiver l\'utilisateur <?= $user['prenomUtilisateur']." ". $user['nomUtilisateur']; ?> ?'));">
                                        <i class=" glyphicon glyphicon-remove" style="color: red !important;"></i>
                                    </a>

                                    <?php } ?>
                                </td>


                            <?php } if ($profily == 1 || ($lib->Est_autoriser(2, $profily) == 1)) { ?>

                                <td align="center"><a href="regenererMdpUser.php?idUser=<?php echo base64_encode($user['idUtilisateur']); ?>&email=<?php echo base64_encode($user['email']); ?>&prenom_nom=<?php echo base64_encode($user['prenomUtilisateur']." ". $user['nomUtilisateur']); ?>&login=<?php echo base64_encode($user['login']); ?>"
                                       onclick="return(confirm('Etes-vous s&ucirc;r de vouloir regénérer le mot de passe de <?= $user['prenomUtilisateur']." ". $user['nomUtilisateur']; ?> ?'));">
                                        <i class=" glyphicon glyphicon-refresh"></i></a></td>

                            <?php } ?>

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


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajoutUser"
     data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouvel utilisateur</h3>
                </div>
                <form action="ajouterUtilisateur.php" onsubmit="return validForm();" method="POST" id="form" name="form">
                    <div class="panel-body">
                        <div class="row">
                            <?php
                            $leCodebarre = $lib->generer_code_barre();
                            $leMatricule = $lib->securite_xss($_SESSION['PREFIXE']) . $lib->extraire_chaine($leCodebarre, 9, 4);
                            ?>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>MATRICULE</label>

                                    <div>
                                        <input type="text" name="matriculeUtilisateur" id="matriculeUtilisateur" class="form-control" value="<?php echo $leMatricule; ?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CODE BARRE</label>

                                    <div>
                                        <input type="text" name="codeUtilisateur" id="codeUtilisateur" class="form-control" value="<?php echo $leCodebarre; ?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>PRENOMS</label>

                                    <div>
                                        <input type="text" name="prenomUtilisateur" id="prenomUtilisateur" required="required" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>NOM</label>

                                    <div>
                                        <input type="text" name="nomUtilisateur" id="nomUtilisateur" required="required" class="test-input form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>TELEPHONE</label>

                                    <div>
                                        <input type="number" name="telephone" id="telephone" required="required" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>EMAIL</label>

                                    <div>
                                        <input onchange="validateMail();" type="email" name="email" id="email" required="required" class="test-input form-control"/>
                                    </div>
                                    <div class="hidden infoEmail" style="color: red;">Adresse électronique déjà utilisée !</div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>ADRESSE</label>

                                    <div>
                                        <input type="text" name="adresse" id="adresse" class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>LOGIN</label>

                                    <div>
                                        <input type="text" onchange="validateLogin();" name="login" id="login" required="required" class="test-input form-control"/>
                                    </div>
                                    <div class="hidden infoLogin" style="color: red;">Login déjà utilisé !</div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>PROFIL</label>

                                    <div>
                                        <select name="idProfil" class="form-control">
                                            <?php foreach ($rs_profil2 as $profile) { ?>
                                                <option
                                                    value=" <?php echo $profile['idProfil']; ?>"><?php echo $profile['profil']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="reset" onclick="btnReset();" class="btn btn-danger">R&eacute;initialiser</button>
                        <button type="submit" id="validerAj" onmouseover="validForm();" class="btn btn-primary pull-right">Valider</button>
                    </div>
                    <input type="hidden" name="idEtablissement" value="<?php echo $lib->securite_xss($_SESSION["etab"]); ?>"/>
                    <input type="hidden" name="password" value="<?php echo $lib->mot_de_passe(); ?>"/>
                    <input type="hidden" name="userCreation" value="<?php echo $lib->securite_xss($_SESSION["id"]); ?>"/>
                    <input type="hidden" name="dateCreation" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
                    <input type="hidden" name="userModification" value="<?php echo $lib->securite_xss($_SESSION["id"]); ?>"/>
                    <input type="hidden" name="dateModification" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
                </form>
            </div>

        </div>
    </div>
</div>
<style>
    .invalide {
        box-shadow: 0 0 1em red;
    }
</style>

<script>

    function validateMail() {
        var mailteste = $('#email');
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        if ((mailteste.val()).trim()!= "" && reg.test(mailteste.val())) {
            $.ajax({
                type: "POST",
                url: "testerEmail.php",
                data: "email=" + mailteste.val(),
                success: function (data) {
                    if (data == 1) {
                        //email existant
                        $(".infoEmail").removeClass("hidden");
                        mailteste.removeClass("ok");
                        mailteste.addClass("invalide ko");

                    } else {
                        $(".infoEmail").addClass("hidden");
                        mailteste.removeClass("invalide ko");
                        mailteste.addClass("ok");
                    }
                }
            });
        } else {
            mailteste.removeClass("ok");
            mailteste.addClass("invalide ko");
            alert("Veillez saisir un email valide")
        }
    }

    function validateLogin() {
        var logteste = $('#login');
        $.ajax({
            type: "POST",
            url: "testerEmail.php",
            data: "login=" + logteste.val(),
            success: function (data) {
                if (data == 1) {
                    //login existant
                    $(".infoLogin").removeClass("hidden");
                    logteste.removeClass("ok");
                    logteste.addClass("invalide ko");
                } else {
                    //login inexistant
                    $(".infoLogin").addClass("hidden");
                    logteste.removeClass("invalide ko");
                    logteste.addClass("ok");
                }
            }
        });
    }
    function btnReset() {
        $('#email').removeClass("invalide ko");
        $('#login').removeClass("invalide ko");
        $(".infoLogin").addClass("hidden");
        $(".infoEmail").addClass("hidden");
    }

    function validForm() {
        return ($('#login').hasClass("ok") && $('#email').hasClass("ok")) ? true : false;
    }
</script>
<?php include('footer.php'); ?>


