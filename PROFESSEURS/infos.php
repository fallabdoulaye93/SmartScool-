<?php
include('header.php');
require_once('../config/Librairie.php');
$lib = new Librairie();

if (isset($_SESSION['id'])) {
    $nom = $_SESSION["prenom"] . " " . $_SESSION["nom"];
    $adresse = $lib->securite_xss($_SESSION['adres']);
    $TELMOBILE = $lib->securite_xss($_SESSION['telmobile']);
    $TELDOM = $lib->securite_xss($_SESSION['teldom']);
    $COURRIEL = $lib->securite_xss($_SESSION['courriel']);
    $SIT_MATRIMONIAL = $lib->securite_xss($_SESSION['situ_matri']);
    $PHOTO_FACE = $lib->securite_xss($_SESSION['photo']);
}else{
    header("Location:index.php");
}


?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#"> PROFEESEUR </a></li>
    <li class="active">Mes infos</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

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

            <div class="col-lg-6  center-block">
                <fieldset class="cadre col-lg-6">
                    <legend class="libelle_champ">Informations g&eacute;n&eacute;rales</legend>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Pr&eacute;nom(s) &
                                Nom: </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?php echo $nom; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Adresse: </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?php echo $adresse; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3"
                               class="col-sm-2 form-control-label"><b>T&eacute;l&eacute;phone: </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?php echo $TELMOBILE; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Domicile: </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?php echo $TELDOM; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Email: </b></label>

                        <div class="col-sm-6" style="background-color: #E1E1E1">
                            <?php echo $COURRIEL; ?>
                        </div>
                    </div>

                    <div class="form-group row" align="center">
                        <div class="col-sm-12">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3 btn-primary " style="height:35px; align-content:center">
                                <a href="modifinfo.php" style="color:#FFFFFF; font-size:12px;text-align: center;vertical-align: middle;line-height: 35px;"> Modifier mes Infos</a>
                            </div>
                            <div class="col-sm-2">&nbsp;</div>
                            <div class="col-sm-3 btn-primary" style="height:35px; align-content:center">
                                <a href="modifpass.php" style="color:#FFFFFF ; font-size:12px;line-height: 35px;">Modifier mot de passe</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

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