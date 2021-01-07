<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(5, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/MatiereManager.php");
require_once("classe/Matiere.php");
$niv = new MatiereManager($dbh, 'MATIERE');

$colname_rq_mat_etab = "-1";
if (isset($_GET['idMatiere'])) {
    $colname_rq_mat_etab = $lib->securite_xss(base64_decode($_GET['idMatiere']));
}
try
{
    $query_rq_mat_etab = $dbh->query("SELECT MATIERE.IDMATIERE, MATIERE.LIBELLE, BASE_NOTES, MATIERE.IDNIVEAU, MATIERE.IDETABLISSEMENT,IDCOEFFICIENT,COEFFICIENT,COEFFICIENT.IDSERIE,LIBSERIE,NIVEAU.LIBELLE as cycle FROM MATIERE INNER JOIN COEFFICIENT ON MATIERE.IDMATIERE = COEFFICIENT.IDMATIERE INNER JOIN SERIE ON COEFFICIENT.IDSERIE = SERIE.IDSERIE INNER JOIN NIVEAU ON NIVEAU.IDNIVEAU = MATIERE.IDNIVEAU  WHERE MATIERE.IDMATIERE = $colname_rq_mat_etab");
    $rs_mat_etab = $query_rq_mat_etab->fetchAll();
    //var_dump($rs_mat_etab);die();
}
catch (PDOException $e){
    echo $e;
}


foreach ($rs_mat_etab as $row_rq_mat_etab)
{
    $id = $row_rq_mat_etab['IDMATIERE'];
    $libelle = $row_rq_mat_etab['LIBELLE'];
    $base_note = $row_rq_mat_etab['BASE_NOTES'];
    $cycle = $row_rq_mat_etab['cycle'];
    $cycle_id = $row_rq_mat_etab['IDNIVEAU'];
}

if(isset($_POST) && $_POST != null)
{

    $_POST['IDETABLISSEMENT'] = $lib->securite_xss(base64_decode($_POST['IDETABLISSEMENT']));
    $post_mat = $_POST;
    $idmatiere = $lib->securite_xss(base64_decode($_POST['IDMATIERE']));

    unset($post_mat['IDMATIERE']);
    unset($post_mat['LIBNIVEAU']);
    unset($post_mat['coef_']);
    unset($post_mat['idcoef_']);
    unset($post_mat['serie_']);

    $res = $niv->modifier($lib->securite_xss_array($post_mat), 'IDMATIERE', $idmatiere);
    if ($res == 1)
    {
        $post_coef = $_POST;
        unset($post_coef['LIBELLE']);
        unset($post_coef['BASE_NOTES']);
        unset($post_coef['LIBNIVEAU']);

        for($i=0; $i < sizeof($post_coef['coef_']);$i++){
            if($post_coef['coef_'][$i] != "0"){
                $stmt1 = $dbh->prepare("UPDATE COEFFICIENT SET COEFFICIENT=? WHERE IDCOEFFICIENT=".$post_coef['idcoef_'][$i]);
                $res1 = $stmt1->execute(array($post_coef['coef_'][$i]));
            }
            else {
                $dbh->exec("UPDATE COEFFICIENT SET COEFFICIENT=0 WHERE IDCOEFFICIENT=".$post_coef['idcoef_'][$i]);
            }
        }
        $msg = "Modification effectuée avec succés";
    }
    else {
        $msg = "Votre mofication a échouée";
    }
    header("Location: modules.php?msg=".$lib->securite_xss($msg) ."&res=". $lib->securite_xss($res));
}
?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Matiéres</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="modifMatiere.php" method="POST">

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>LIBELLE</label>
                                    <div>
                                        <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control" value="<?php echo $libelle; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NOTE DE BASE</label>
                                    <div>
                                        <input type="text" name="BASE_NOTES" id="BASE_NOTES" required class="form-control" value="<?php echo $base_note; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CYCLE</label>
                                    <div>
                                        <input type="text" name="LIBNIVEAU" id="LIBNIVEAU" readonly class="form-control" value="<?php echo $cycle; ?>"/>
                                        <input type="hidden" name="IDNIVEAU" id="IDNIVEAU" class="form-control" value="<?php echo $cycle_id; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 30px">
                            <fieldset class="cadre" id="mat">
                                <legend>COEFFICIENT PAR SÉRIE</legend>
                                <?php foreach ($rs_mat_etab as $row_rq_mat_etab) {?>
                                    <div class="col-md-6" style="margin-top: 5px">
                                        <div class="form-group">
                                            <label><?php echo $row_rq_mat_etab['LIBSERIE'] ;?></label>
                                            <div>
                                                <input type="number" name="coef_[]" id="COEFFICIENT_<?php echo $row_rq_mat_etab['IDCOEFFICIENT'];?>" class="form-control" value="<?php echo $row_rq_mat_etab['COEFFICIENT'];?>" min="0"/>
                                                <input type="hidden" name="idcoef_[]" value="<?php echo $row_rq_mat_etab['IDCOEFFICIENT'];?>"/>
                                                <input type="hidden" name="serie_[]" value="<?php echo $row_rq_mat_etab['IDSERIE'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </fieldset>
                        </div>

                        <br><br>


                        <div class="col-lg-12">
                            <div class="col-md-6">
                                <a class="btn btn-success" href="./modules.php" role="button">RETOUR</a>
                            </div>
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-success" value="Modifier"/>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="IDMATIERE" value="<?php echo base64_encode($id) ; ?>"/>
                    <input type="hidden" name="IDETABLISSEMENT" value="<?php echo base64_encode($lib->securite_xss($_SESSION['etab'])) ; ?>"/>


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