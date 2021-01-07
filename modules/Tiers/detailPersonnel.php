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
        $msg = "Modification effectuée avec succés";
    } else {
        $msg = "Votre modification a échouée";
    }
    header("Location: listePersonnelAdministratif.php?msg=" . $msg . "&res=" . $res);
}else{
    require_once('../Parametrage/classe/ProfileManager.php');
    $profiles = new ProfileManager($dbh, 'profil');
    $profil = $profiles->getProfiles();

    $colname_rq_individu = "-1";
    if (isset($_SESSION['etab'])) {
    $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
    }
    $query_rq_individu = $dbh->query("SELECT u.idUtilisateur, u.matriculeUtilisateur, u.codeUtilisateur, u.nomUtilisateur, u.prenomUtilisateur, u.adresse, u.telephone, u.email, p.profil from UTILISATEURS u, profil p  
                                                 WHERE p.idProfil=u.idProfil  AND idUtilisateur = " . $lib->securite_xss(base64_decode($_GET['idIndividu'])));

    foreach ($query_rq_individu->fetchAll() as $row_rq_individu) {

        $id = $row_rq_individu['idUtilisateur'];
        $libelle_profil = $row_rq_individu['profil'];
        $MATRICULE = $row_rq_individu['matriculeUtilisateur'];
        $CODE = $row_rq_individu['codeUtilisateur'];
        $NOMINDIVIDU = $row_rq_individu['nomUtilisateur'];
        $PRENOMS = $row_rq_individu['prenomUtilisateur'];
        $ADRES = $row_rq_individu['adresse'];
        $TELMOBILE = $row_rq_individu['telephone'];
        $COURRIEL = $row_rq_individu['email'];


    }
//    echo "<pre>";var_dump($profil[0]->getIdProfil());exit;
}
?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Détail individus</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <fieldset class="cadre">

                    <legend>INFORMATIONS GENERALES</legend>

            <div class="row text-center m-t-10">
                <div class="col-md-4 b-r"><strong>MATRICULE</strong>
                    <p><?php echo $MATRICULE; ?></p>
                </div>
                <div class="col-md-4 b-r"><strong>CODE</strong>
                    <p><?php echo $CODE; ?></p>
                </div>
                <div class="col-md-4 b-r"><strong>PROFIL</strong>
                    <p><?php echo $libelle_profil; ?></p>
                </div>
            </div>
            <hr>


                <div class="row text-center m-t-10">
                    <div class="col-md-4 b-r"><strong>PRENOMS</strong>
                        <p><?php echo $PRENOMS; ?></p>
                    </div>
                    <div class="col-md-4 b-r"><strong>NOM</strong>
                        <p><?php echo $NOMINDIVIDU; ?></p>
                    </div>

                    <div class="col-md-4 b-r"><strong>ADRESSE</strong>
                        <p><?php echo $ADRES; ?></p>
                    </div>
                </div>
             <hr>
            <div class="row text-center m-t-10">
                    <div class="col-md-4 b-r"><strong>TELEPHONE MOBILE</strong>
                        <p><?php echo $TELMOBILE; ?></p>
                    </div>
                    <div class="col-md-4 b-r"><strong>COURRIEL</strong>
                        <p><?php echo $COURRIEL; ?></p>
                    </div>


                </div>
             <hr>



            <div class="form-group">
                <div class="pull-right">
                    <a href="listePersonnelAdministratif.php">
                        <button type="button" class="btn btn-success">RETOUR</button>
                    </a>
                </div>

            </div>
     </fieldset>




    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>