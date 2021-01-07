<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(2, $lib->securite_xss($_SESSION['profil'])));

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


try
{
    $query_rq_user_etab = $dbh->query("SELECT `idUtilisateur`, `matriculeUtilisateur`, `codeUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `telephone`, `adresse`, `email`, `login`, `password`, `idEtablissement`, `idProfil`, `dateCreation`, `userCreation`, `dateModification`, `userModification` 
                                            FROM `UTILISATEURS` WHERE idUtilisateur = $colname_rq_user_etab");
    foreach ($query_rq_user_etab->fetchAll() as $row_rq_user_etab) {

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
catch (PDOException $e){
    return -1;
}



if (isset($_POST) && $_POST != null)
{
    $res = $niv->modifier($lib->securite_xss_array($_POST), 'idUtilisateur', $lib->securite_xss($_POST['idUtilisateur']));
    if ($res == 1) {
        $msg = "Modification effectuée avec succés";
    } else {
        $msg = "Modification effectuée avec echec";
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
                <form action="modifUser.php" method="POST">

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>MATRICULE</label>

                                <div>
                                    <input type="text" name="matriculeUtilisateur" id="matriculeUtilisateur" readonly class="form-control" value="<?php echo $matriculeUtilisateur; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>CODE</label>

                                <div>
                                    <input type="text" name="codeUtilisateur" id="codeUtilisateur" readonly class="form-control" value="<?php echo $codeUtilisateur; ?>"/>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>PRENOM</label>

                                <div>
                                    <input type="text" name="prenomUtilisateur" id="prenomUtilisateur" required class="form-control" value="<?php echo $prenomUtilisateur; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>NOM</label>

                                <div>
                                    <input type="text" name="nomUtilisateur" id="nomUtilisateur" required class="form-control" value="<?php echo $nomUtilisateur; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>TELEPHONE</label>

                                <div>
                                    <input type="number" name="telephone" id="telephone" required class="form-control" value="<?php echo $telephone; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>EMAIL</label>

                                <div>
                                    <input type="email" name="email" id="email" required class="form-control" value="<?php echo $email; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>ADRESSE</label>

                                <div>
                                    <input type="text" name="adresse" id="adresse" class="form-control" value="<?php echo $adresse; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>LOGIN</label>

                                <div>
                                    <input type="text" name="login" id="login" required class="form-control" value="<?php echo $login; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>PROFIL</label>

                                <div>
                                    <select name="idProfil" class="form-control selectpicker">
                                        <?php
                                        foreach ($profil as $profile) {

                                            ?>
                                            <option
                                                    value=" <?php echo $profile->getIdProfil(); ?>" <?php if ($idProfil == $profile->getIdProfil()) echo "selected" ?>><?php echo $profile->getProfil(); ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12"><br>

                            <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>

                        </div>


                    </div>

                    <input type="hidden" name="idUtilisateur" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->affichage_xss($_SESSION['etab']); ?>"/>
                    <input type="hidden" name="password" value="<?php echo $password; ?>"/>

                    <input type="hidden" name="userModification" value="<?php echo $lib->affichage_xss($_SESSION["id"]); ?>"/>

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