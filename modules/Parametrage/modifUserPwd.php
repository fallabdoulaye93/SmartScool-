<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$id=$lib->securite_xss($_SESSION["id"]);

//if ($_SESSION['profil'] != 1)
   // $lib->Restreindre($lib->Est_autoriser(2, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/UtilisateurManager.php");
require_once("classe/Utilisateur.php");
$niv = new UtilisateurManager($dbh, 'UTILISATEURS');

require_once('classe/ProfileManager.php');
$profiles = new ProfileManager($dbh, 'profil');
$profil = $profiles->getProfiles();


$colname_rq_user_etab = "-1";
if (isset($_GET['idUtilisateur'])) {
    $colname_rq_user_etab = $lib->securite_xss(base64_decode($_GET['idUtilisateur']));
}


if ((isset($_POST["Pwd_update"])) && ($_POST["Pwd_update"] == "changer")) {

    $mdp = md5($lib->securite_xss($_POST['newpassword']));
    $idUser = $lib->securite_xss($_POST['idUtilisateur']);
    $query ="UPDATE UTILISATEURS SET password='".$mdp."' WHERE idUtilisateur=$idUser" ;
    $requete=$dbh->prepare($query);
    $requete->execute();
    $totalRows=$requete->rowCount();
    $urlredirectsucces = "menu.php?msg=Operation effectuee avec succes";
    $urlredirectError = "modifUserPwd.php?msg=erreur operation non effectuee";
    if($totalRows==1) {

        // On démarre la session
        session_start ();

        // On détruit les variables de notre session
        session_unset ();

        // On détruit notre session
        session_destroy ();

        // On redirige le visiteur vers la page d'accueil
        header ('location: index.php');;
    }
    else {
         header("Location:$urlredirectError");
    }

};


try
{
    $query_rq_user_etab = $dbh->query("SELECT idUtilisateur, matriculeUtilisateur, codeUtilisateur, prenomUtilisateur, nomUtilisateur, telephone, adresse, 
                                                 email, login, password, idEtablissement, idProfil, dateCreation, userCreation, dateModification, userModification 
                                                 FROM UTILISATEURS WHERE idUtilisateur = $colname_rq_user_etab");
    foreach ($query_rq_user_etab->fetchAll() as $row_rq_user_etab)
    {
        $id = $row_rq_user_etab['idUtilisateur'];
        $matriculeUtilisateur = $row_rq_user_etab['matriculeUtilisateur'];
        $codeUtilisateur = $row_rq_user_etab['codeUtilisateur'];
        $prenomUtilisateur = $row_rq_user_etab['prenomUtilisateur'];
        $nomUtilisateur = $row_rq_user_etab['nomUtilisateur'];
        $telephone = $row_rq_user_etab['telephone'];
        $adresse = $row_rq_user_etab['adresse'];
        $email = $row_rq_user_etab['email'];
        $login = $row_rq_user_etab['login'];
        $password = $row_rq_user_etab['password'];
        $idProfil = $row_rq_user_etab['idProfil'];

    }
}
catch (PDOException $e)
{
    return -1;
}



if(isset($_POST) && $_POST != null)
{
    $res = $niv->modifier($lib->securite_xss_array($_POST), 'idUtilisateur', $lib->securite_xss($_POST['idUtilisateur']));
    if ($res == 1)
    {
        $msg = "Modification effectuée avec succès";
    }
    else
    {
        $msg = "Echec de la modification";
    }
    header("Location: utilisateurs.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
} ?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Utilisateurs</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">

            <div class="panel-body">
                <form action="modifUserPwd.php" method="POST">

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>ANCIEN MOT DE PASSE</label>

                                <div>
                                    <input type="password" name="password" id="password" required class="form-control" value="" onchange="ancienPwd(this.value);" />
                                    <span id="msg2"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>NOUVEAU MOT  DE PASSE</label>

                                <div>
                                    <input type="password" name="newpassword" id="newpassword" required class="form-control" value=""/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>CONFIRMER MOT DE PASSE</label>

                                <div>
                                    <input type="password" name="confirmpassword" id="confirmpassword" required class="form-control" value="" onchange="confirmPassword();"  />
                                    <span id="msg3"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12"><br>

                            <div class="col-lg-offset-5"><input type="submit" id="button" class="btn btn-success" value="Changer mon mot de passe"/></div>

                        </div>


                    </div>

                    <input type="hidden" name="idUtilisateur" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="Pwd_update" value="changer"/>

                    <input type="hidden" name="dateModification" value="<?php echo date('Y-m-d H:i:s'); ?>"/>


                </form>
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

<script type="text/javascript">
    function ancienPwd(ancien) {

        $.get("verifpwd.php?id=<?= $id ?>&pass="+ancien , function (data) {
             console.log(data);

            if (data==1) {

                $('#msg2').html("<p style='color:green;display: inline;border: 1px solid green'>mot de passe correct.</p>");

            }
            else {
                $('#button').css('display', 'none');
                $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>Veuillez entrer le bon mot de passe</p>");

            }
        },'JSON');

    }
</script>
<script>
    function confirmPassword() {
        var nouveau=$('#newpassword').val();
        var confirmation=$('#confirmpassword').val();

        if(nouveau==confirmation){
            $('#msg3').html("<p style='color:green;display: inline;border: 1px solid green'>Confirmation effectuée avec succés</p>");
            $('#button').css('display', 'block');
        }
        else{
            $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>Les deux mots de passe ne correspondent pas.</p>");
            $('#button').css('display', 'none');
        }


    }
</script>

