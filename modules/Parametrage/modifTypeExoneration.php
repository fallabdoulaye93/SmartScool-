
<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(50,$_SESSION['profil']));


require_once("classe/TypeExonerationManager.php");
require_once("classe/TypeExoneration.php");
$niv=new TypeExonerationManager($dbh,'TYPE_EXONERATION');


$colname_rq_salle_etab = "-1";
if (isset($_GET['idSalle'])) {
    $colname_rq_salle_etab = $lib->securite_xss(base64_decode($_GET['idSalle']));
}

$query_rq_salle_etab = $dbh->query("SELECT ROWID, LABEL, ETAT FROM TYPE_EXONERATION WHERE ROWID = $colname_rq_salle_etab");
foreach($query_rq_salle_etab->fetchAll() as $row_rq_salle_etab){

    $id=$row_rq_salle_etab['ROWID'];
    $typeSalle=$row_rq_salle_etab['LABEL'];

}


if(isset($_POST) && $_POST !=null) {

    $res = $niv->modifier($lib->securite_xss_array($_POST),'ROWID',$lib->securite_xss($_POST['ROWID']));
    if ($res==1) {
        $msg="Modification effectuée avec succès!";

    }
    else{
        $msg="Echec de la modification";
    }
    header("Location: typeExoneration.php?msg=".$msg."&res=".$res);
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Type Exonération</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

                <form action="modifTypeExoneration.php" method="POST" >

            <div class="row">

                <div class="col-xs-12">
                    <div class="form-group">
                        <label >LABEL</label>
                        <div>
                            <input type="text" name="LABEL" id="LABEL" required class="form-control" value="<?php echo $typeSalle; ?>"/>
                        </div>
                    </div>
                </div>

                <br><br>



                <div class="col-lg-12">
                    <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier" /></div>

                </div>

            </div>

            <input type="hidden" name="ROWID" value="<?php  echo $id; ?>" />


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