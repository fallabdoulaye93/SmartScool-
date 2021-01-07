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

if (isset($_GET['montant1'])) {
    $_SESSION['montant'] = $_GET['montant1'];
}
if (isset($_GET['id'])) {
    $_SESSION['etudiant'] = $_GET['id'];
}
if (isset($_GET['mois'])) {
    $_SESSION['mois'] = $_GET['mois'];
}
if (isset($_GET['numfact'])) {
    $_SESSION['numfact'] = $_GET['numfact'];
}
$_SESSION['redirection'] = "http://www.numherit-labs.com/sunuecole/PARENTS/payment_ok.php";
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

        <div class="col-lg-12">
            <fieldset>
                <legend class="libelle_champ">Paiement Scolarit&eacute;</legend>

                <?php if ($_GET['mes'] != 'OK' || $_GET['mes'] == '') { ?>

                    <div>
                        <iframe src="jula/JulaMarchandSend.php" width="100%" height="500" frameborder="YES"
                                style="border:0;overflow:auto;" allowfullscreen></iframe>
                    </div>
                    <a href="payment.php"><input type="button" value="Retour" class="btn btn-success" id="retour"/></a>
                <?php } else { ?>

                    <table width="74%" height="132" border="0" cellpadding="0" cellspacing="5">
                        <tr>
                            <td height="52" align="center" valign="middle"
                                class="Titreactu2"><?php if ($_GET['mes'] == 'OK') { ?>
                                    <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert"
                                                                         aria-label="close">&times;</a> Votre paiement
                                    d’un montant de <?php echo $lib->nombre_form($_GET['montant']) ?> F.CFA a &eacute;t&eacute;
                                    effectu&eacute; avec succ&eacute;s </div><?php } ?>
                                <?php if ($_GET['mes'] == non) { ?>
                                    <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                                                       aria-label="close">&times;</a>Transaction
                                        Invalide
                                    </div><?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle" class="Titreactu2 "><a href="payment.php"><input
                                        class="btn-num_blue" type="button" value="Retour" class="bouton" id="retour"
                                        width="100px"/>
                                        </a></td>
                        </tr>
                    </table> <?php } ?>
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