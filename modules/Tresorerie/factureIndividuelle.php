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
    $lib->Restreindre($lib->Est_autoriser(25, $_SESSION['profil']));

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $_SESSION['etab'];
}


$colname_classe = $_POST['Classe'];


$classrom = $dbh->query("SELECT IDSERIE, IDNIVEAU,IDCLASSROOM,IDETABLISSEMENT FROM CLASSROOM WHERE IDCLASSROOM= " . $colname_classe . " AND IDETABLISSEMENT= " . $colname_rq_classe);
//$classe=$classrom->fetchAll();
//print_r($classe); die;
foreach ($classrom->fetchAll() as $classe) {
    $niveau = $classe['IDNIVEAU'];
    $serie = $classe['IDSERIE'];

}


$query_rq_eleve = $dbh->query("SELECT INSCRIPTION.*, INDIVIDU.* FROM INSCRIPTION, INDIVIDU WHERE INSCRIPTION.IDINDIVIDU= INDIVIDU.IDINDIVIDU AND INSCRIPTION.IDETABLISSEMENT = " . $colname_rq_classe . " AND  INSCRIPTION.IDSERIE=" . $serie . " AND INSCRIPTION.IDNIVEAU=" . $niveau . " AND INSCRIPTION.IDANNEESSCOLAIRE=" . $_SESSION['ANNEESSCOLAIRE']);

?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
        <li><a href="#">TRESORERIE</a></li>
    <li>Facture individuelle</li>
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
                <form id="form1" name="form1" method="post" action="facture_ok.php" onsubmit="if($('#ETUDIANT').val() == 'null'){$('button.selectpicker').css('border-color','#E04B4A');$('#ETUDIANT-error').removeClass('hidden'); return false;} ">
                    <fieldset class="cadre">
                        <legend> G&eacute;n&eacute;ration facture globale</legend>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-5">
                                    <div class="col-lg-3"><label class="control-label">ETUDIANT</label></div>
                                    <div class="col-lg-9">
                                        <select onchange="$('button.selectpicker').css('border-color','#95b75d');$('#ETUDIANT-error').addClass('hidden');" name="ETUDIANT" id="ETUDIANT" class="form-control selectpicker"
                                                data-live-search="true">
                                            <option value="null">--Selectionner--</option>
                                            <?php foreach ($query_rq_eleve->fetchAll() as $row_rq_eleve) { ?>
                                                <option
                                                    value="<?php echo $row_rq_eleve['IDINSCRIPTION']; ?>"><?php echo $row_rq_eleve['MATRICULE'] . "  " . $row_rq_eleve['PRENOMS'] . "  " . $row_rq_eleve['NOM']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="ETUDIANT-error" class="hidden">This field is required.</span>
                                        <style>
                                            #ETUDIANT-error {
                                                color: #E04B4A;
                                                margin: 3px 0 3px 0;
                                                font-size: 11px;
                                                font-weight: normal;
                                                width: 100%;
                                                display: inline-block;
                                            }
                                        </style>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="col-lg-3"><label class="control-label">MOIS</label></div>
                                    <div class="col-lg-9">
                                        <select name="MOIS" required id="MOIS" class="form-control">
                                            <option value="">Mois</option>
                                            <option value="01"><?php echo $lib->Le_mois("01"); ?></option>
                                            <option value="02"><?php echo $lib->Le_mois("02"); ?></option>
                                            <option value="03"><?php echo $lib->Le_mois("03"); ?></option>
                                            <option value="04"><?php echo $lib->Le_mois("04"); ?></option>
                                            <option value="05"><?php echo $lib->Le_mois("05"); ?></option>
                                            <option value="06"><?php echo $lib->Le_mois("06"); ?></option>
                                            <option value="07"><?php echo $lib->Le_mois("07"); ?></option>
                                            <option value="08"><?php echo $lib->Le_mois("08"); ?></option>
                                            <option value="09"><?php echo $lib->Le_mois("09"); ?></option>
                                            <option value="10"><?php echo $lib->Le_mois(10); ?></option>
                                            <option value="11"><?php echo $lib->Le_mois(11); ?></option>
                                            <option value="12"><?php echo $lib->Le_mois(12); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>ANNEE</label></div>
                                        <div class="col-lg-9">
                                            <select name="ANNEE" required id="ANNEE" class="form-control">
                                                <option value="">ANNEE</option>
                                                <option
                                                    value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                                <option
                                                    value="<?php echo date('Y', strtotime('-1 year')); ?>"><?php echo date('Y', strtotime('-1 year')); ?></option>
                                                <option
                                                    value="<?php echo date('Y', strtotime('-2 year')); ?>"><?php echo date('Y', strtotime('-2 year')); ?></option>


                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1">
                                    <div class="form-group">

                                        <div>
                                            <input type="submit" class="btn btn-success" name="envoyer2"
                                                   value="Valider"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </fieldset>
                </form>
                <br><br>


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