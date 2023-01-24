<?php
include('header.php');

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();


$colname_id = "-1";
if (isset($_SESSION['id'])) {
    $colname_id = $_SESSION['id'];
}

if (isset($_GET['montant'])) {
    $_SESSION['montant'] = $lib->securite_xss($_GET['montant']);
}
if (isset($_GET['id'])) {
    $_SESSION['etudiant'] = $lib->securite_xss($_GET['id']);
}
if (isset($_GET['nom'])) {
    $_SESSION['nomEtu'] = $lib->securite_xss($_GET['nom']);
}
if (isset($_GET['mois'])) {
    $_SESSION['mois'] = $lib->securite_xss($_GET['mois']);
}
if (isset($_GET['numfact'])) {
    $_SESSION['numfact'] = $lib->securite_xss($_GET['numfact']);
}
$_SESSION['redirection'] = "http://www.samaecole-labs.com/sunuecole/PARENTS/payment_ok.php";
?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">ELEVE / ETUDIANT </a></li>
    <li class="active"> Payement scolarit&eacute;</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->

<!-- START WIDGETS -->
<div class="row">

    <div class="panel-body">

        <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

            if (isset($_GET['res']) && $_GET['res'] == 1) { ?>
                
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $lib->securite_xss($_GET['msg']); ?>
                </div>

            <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $lib->securite_xss($_GET['msg']); ?>
                </div>

            <?php } ?>

        <?php } ?>

        <div class="col-lg-12">
            <fieldset>
                <legend class="libelle_champ">Paiement Scolarit&eacute;</legend>
                    <div>
                        <iframe src="jula/JulaMarchandSend.php" width="100%" height="450" frameborder="YES"
                                style="border:0;overflow:auto;" allowfullscreen>
                        </iframe>
                    </div>
                    <a href="mes_etudiant.php"><input type="button" value="Retour" class="btn btn-success" id="retour"/></a>
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
