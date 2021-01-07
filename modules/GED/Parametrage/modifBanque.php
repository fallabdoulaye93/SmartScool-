
<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(51,$_SESSION['profil']));


require_once("classe/BanqueManager.php");
require_once("classe/Banque.php");
$niv = new BanqueManager($dbh,'BANQUE');


$colname_rq_salle_etab = "-1";
if (isset($_GET['ban'])) {
    $colname_rq_salle_etab = $lib->securite_xss(base64_decode($_GET['ban']));
}
try
{
    $query_rq_salle_etab = $dbh->query("SELECT ROWID, LABEL, TEL, ADRESSE, ETAT, IDETABLISSEMENT FROM BANQUE WHERE ROWID = $colname_rq_salle_etab");
    $rs_banque = $query_rq_salle_etab->fetchObject();
}
catch (PDOException $e)
{
    echo -2;
}


if(isset($_POST) && $_POST !=null) {

    $rowid = $lib->securite_xss($_POST['ROWID']);
    unset($_POST['ROWID']);
    $res = $niv->modifier($lib->securite_xss_array($_POST),'ROWID',  $rowid);
    if ($res==1)
    {
        $msg="Modification effectuée avec succès!";
    }
    else{
        $msg="Echec de la modification";
    }
    header("Location: banque.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Banque</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

                <form action="modifBanque.php" method="POST" >

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>LABEL</label>
                                <div>
                                    <input type="text" name="LABEL" id="LABEL" required class="form-control" value="<?php echo $rs_banque->LABEL; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>TEL</label>
                                <div>
                                    <input type="text" name="TEL" id="TEL" required class="form-control" value="<?php echo $rs_banque->TEL; ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>ADRESSE</label>
                                <div>
                                    <textarea name="ADRESSE" rows="5" class="form-control"><?php echo $rs_banque->ADRESSE; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="col-lg-12">
                            <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier" /></div>
                        </div>

                    </div>

                    <input type="hidden" name="ROWID" value="<?php  echo $rs_banque->ROWID; ?>" />
                    <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>" />

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