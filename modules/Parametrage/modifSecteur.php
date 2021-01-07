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


require_once("classe/SecteurManager.php");
require_once("classe/Secteur.php");
$niv = new SecteurManager($dbh,'secteur_activite');

$colname_rq_salle_etab = "-1";
if (isset($_GET['ban'])) {
    $colname_rq_salle_etab = $lib->securite_xss(base64_decode($_GET['ban']));
}
try
{
    $query_rq_salle_etab = $dbh->query("SELECT IDSECTEUR, LIBELLE FROM secteur_activite WHERE IDSECTEUR = $colname_rq_salle_etab");
    $rs_banque = $query_rq_salle_etab->fetchObject();
}
catch (PDOException $e)
{
    echo -2;
}


if(isset($_POST) && $_POST !=null)
{
    $rowid = $lib->securite_xss($_POST['IDSECTEUR']);
    unset($_POST['IDSECTEUR']);
    $res = $niv->modifier($lib->securite_xss_array($_POST),'IDSECTEUR',  $rowid);
    if ($res==1)
    {
        $msg="Modification effectuée avec succès!";
    }
    else{
        $msg="Echec de la modification";
    }
    header("Location: secteur.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Secteur d'activité</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

                <form action="modifSecteur.php" method="POST" >

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>LIBELLE</label>
                                <div>
                                    <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control" value="<?php echo $rs_banque->LIBELLE; ?>"/>
                                </div>
                            </div>
                        </div>


                        <br><br>

                        <div class="col-lg-12">
                            <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier" /></div>
                        </div>

                    </div>

                    <input type="hidden" name="IDSECTEUR" value="<?php  echo $rs_banque->IDSECTEUR; ?>" />

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