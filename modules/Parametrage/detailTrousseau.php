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
    $lib->Restreindre($lib->Est_autoriser(53, $lib->securite_xss($_SESSION['profil'])));



$etab = "-1";
if (isset($_SESSION['etab'])) {
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_trou_etab = "-1";
if (isset($_GET['Trou'])) {
    $colname_rq_trou_etab = $lib->securite_xss(base64_decode($_GET['Trou']));
}
$colname_rq_idniv_etab = "-1";
if (isset($_GET['idniv'])) {
    $colname_rq_idniv_etab = $lib->securite_xss(base64_decode($_GET['idniv']));
}
try
{
    $row_REQ_class = $dbh->query("SELECT T.ROWID, T.LIBELLE, T.MONTANT, T.CYCLE,n.LIBELLE as LIBCYCLE, T.SEXE, T.FK_NIVEAU FROM TROUSSEAU T
                                        INNER JOIN NIVEAU n ON n.IDNIVEAU = T.FK_NIVEAU
                                        WHERE T.IDETABLISSEMENT = ".$etab." AND T.ROWID = " .$colname_rq_trou_etab);
    $rs=$row_REQ_class->fetchObject();

    $query_rq_uniforme = $dbh->query("SELECT UNIFORME.ROWID AS ROWID, UNIFORME.IDNIVEAU, UNIFORME.LIBELLE, UNIFORME.MONTANT, ELEMENT_TROUSSEAU.NOMBRE 
                                            FROM UNIFORME 
                                            INNER JOIN ELEMENT_TROUSSEAU ON ELEMENT_TROUSSEAU.FK_UNIFORME = UNIFORME.ROWID  
                                            WHERE ELEMENT_TROUSSEAU.FK_TROUSSEAU = " . $colname_rq_trou_etab." 
                                            AND  UNIFORME.IDNIVEAU =".$colname_rq_idniv_etab);
    $rs_uniforme = $query_rq_uniforme->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
?>
<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Trousseau</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">
                <fieldset class="cadre">
                    <legend> Detail Trousseau</legend>

                        <div class="row">
                            <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label for="nom" class="col-lg-3 col-sm-4 control-label"><b>Cycle</b> </label>
                                <div class="col-lg-9 col-sm-8">
                                    <?php echo $rs->LIBCYCLE; ?>

                                </div>
                            </div>

                        </div>
                            <br>
                            <?php
                            $i=0;
                            foreach ($rs_uniforme as $rs_rq_uniforme) {?>
                                <div class="row" style="padding-bottom: 10px!important;">
                                    <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label"><b><?php echo $rs_rq_uniforme['LIBELLE'];?> </b></label>
                                        <div class="col-lg-9 col-sm-8">
                                            <?php echo $rs_rq_uniforme['NOMBRE']?>
                                        </div>

                                    </div>
                                </div>
                                <?php $i=$i+1;
                            }  ?>

                            <div class="row">
                                <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><b>Montant</b> </label>
                                    <div class="col-lg-9 col-sm-8">
                                        <?php echo  $rs->MONTANT; ?>
                                    </div>
                                </div>

                            </div>
                            <br>
                                            <div class="row">
                                                <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><b>Sexe</b></label>
                                                    <div class="col-lg-9 col-sm-8">
                                                            <?php if($rs->SEXE==1) echo "Garçon"; else echo "Fille" ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if ($rs->FK_NIVEAU==3) { ?>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <label for="nom" class="col-lg-3 col-sm-4 control-label"><b>Niveau</b></label>
                                                        <div class="col-lg-9 col-sm-8">
                                                                <?php if($rs->CYCLE==1) echo "Premier Cycle"; else echo "Second Cycle"; ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                </fieldset>
            </div>




            </div>
        </div>
        <!-- END WIDGETS -->


    </div>
    <!-- END PAGE CONTENT WRAPPER -->

<!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>