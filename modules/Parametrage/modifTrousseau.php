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
//var_dump($colname_rq_trou_etab);
$row_REQ_class = $dbh->query("SELECT T.ROWID, T.LIBELLE, T.MONTANT, T.CYCLE,n.LIBELLE as LIBCYCLE, T.SEXE, T.FK_NIVEAU FROM TROUSSEAU T
                                        INNER JOIN NIVEAU n ON n.IDNIVEAU = T.FK_NIVEAU
                                        WHERE T.IDETABLISSEMENT = ".$etab." AND T.ROWID = " .$colname_rq_trou_etab);
                                        $rs=$row_REQ_class->fetchObject();
                                        //var_dump($rs);exit;

$query_rq_uniforme = $dbh->query("SELECT UNIFORME.ROWID AS ROWID, UNIFORME.IDNIVEAU, UNIFORME.LIBELLE, UNIFORME.MONTANT, ELEMENT_TROUSSEAU.NOMBRE FROM UNIFORME 
        INNER JOIN ELEMENT_TROUSSEAU ON ELEMENT_TROUSSEAU.FK_UNIFORME = UNIFORME.ROWID  WHERE ELEMENT_TROUSSEAU.FK_TROUSSEAU = " . $colname_rq_trou_etab." AND  UNIFORME.IDNIVEAU =".$colname_rq_idniv_etab);
        $rs_uniforme = $query_rq_uniforme->fetchAll();


if (isset($_POST) && $_POST != null) {

    $nbre = count($_POST['nombre']);

    if($nbre>0){
        try
        {
            $query = $dbh->prepare("UPDATE TROUSSEAU SET MONTANT =:MONTANT WHERE ROWID =:ROWID");
            $res2 = $query->execute(array("MONTANT"=>$lib->securite_xss($_POST['montant']), "ROWID"=>$lib->securite_xss($_POST['rowid'])));
            if($res2==1){
                for($i=0; $i< $nbre;$i++){
                    //var_dump($_POST['FK_uniforme'][$i]);exit;
                    $query1 = $dbh->prepare("UPDATE ELEMENT_TROUSSEAU SET NOMBRE =:NOMBRE WHERE FK_TROUSSEAU =:FK_TROUSSEAU AND FK_UNIFORME =:FK_UNIFORME");
                    $res3 = $query1->execute(array("NOMBRE"=>$_POST['nombre'][$i], "FK_TROUSSEAU"=>$lib->securite_xss($_POST['rowid']), "FK_UNIFORME"=>$_POST['FK_uniforme'][$i]));
                    //var_dump($res3);exit;
                    if ($res3 == 1) {
                        $msg = "Modification effectuée avec succés";

                    } else {
                        $msg = "Votre mofication a échouée";
                    }
                }

            }
        }
        catch(PDOException $e)
        {
            $msg="Votre mofication a échouée";

        }
    }

    header("Location: trousseau.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res3));
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

        <form action="modifTrousseau.php" method="POST">


                        <div class="row">
                            <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                <div class="col-lg-9 col-sm-8">
                                    <input type="text" name="FK_NIVEAU" id="FK_NIVEAU" class="form-control"  value="<?php echo $rs->LIBCYCLE; ?>" readonly/>

                                </div>
                            </div>

                        </div>
            <br>
            <?php
            $i=0;
            foreach ($rs_uniforme as $rs_rq_uniforme) {?>
                <div class="row" style="padding-bottom: 10px!important;">
                    <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $rs_rq_uniforme['LIBELLE'];?> </label>
                        <div class="col-lg-9 col-sm-8">
                            <input type="hidden" name="FK_uniforme[]" id="FK_uniforme<?php echo $rs_rq_uniforme['ROWID']?>" class="form-control" value="<?php echo $rs_rq_uniforme['ROWID']?>" />
                            <input type="number" name="nombre[]" id="nombre<?php echo$i; ?>" class="form-control" min="0" value="<?php echo $rs_rq_uniforme['NOMBRE']?>" />
                        </div>

                    </div>
                </div>
                <?php $i=$i+1;
            }  ?>

            <div class="row">
                <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <label for="nom" class="col-lg-3 col-sm-4 control-label">MONTANT </label>
                    <div class="col-lg-9 col-sm-8">
                        <input type="text" name="montant" id="montant" class="form-control"  value="<?php echo  $rs->MONTANT; ?>"/>

                    </div>
                </div>

            </div><br>
                            <div class="row">
                                <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label">SEXE</label>
                                    <div class="col-lg-9 col-sm-8">
                                        <label class="form-check-label col-xs-4">
                                            <input type="radio" class="form-check-input" name="sexe" value="1" <?php if($rs->SEXE==1) echo "checked=checked";?> disabled> Garçon
                                            <input type="hidden" name="nbreligne" id="nbreligne" class="form-control" value="<?php echo$i; ?>"  />
                                        </label>&nbsp;
                                        <label class="form-check-label col-xs-4">
                                            <input type="radio" class="form-check-input" name="sexe" value="0" <?php if($rs->SEXE==0) echo "checked=checked";?> disabled> Fille
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php if ($rs->FK_NIVEAU==3) { ?>
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">NIVEAU</label>
                                        <div class="col-lg-9 col-sm-8">
                                            <label class="form-check-label col-xs-4">
                                                <input type="radio" class="form-check-input" name="niveau" value="1" <?php if($rs->CYCLE==1) echo "checked=checked";?> disabled> Premier Cycle
                                            </label>
                                            <label class="form-check-label col-xs-4">
                                                <input type="radio" class="form-check-input" name="niveau" value="2"  <?php if($rs->CYCLE==2) echo "checked=checked";?> disabled> Second Cycle
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                <br><br>
                <div class="col-lg-12">
                    <br/>
                    <input type="hidden" name="rowid" id="rowid" class="form-control" value="<?php echo $colname_rq_trou_etab; ?>"  />
                    <div class="col-lg-offset-5"><input type="submit" class="btn btn-success" value="Modifier"/></div>
                </div>

            </div>


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