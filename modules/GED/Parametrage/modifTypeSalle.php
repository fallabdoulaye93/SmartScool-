
<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(8,$_SESSION['profil']));


require_once("classe/TypeSalleManager.php");
require_once("classe/TypeSalle.php");
$niv=new TypeSalleManager($dbh,'TYPE_SALLE');


$colname_rq_salle_etab = "-1";
if (isset($_GET['idSalle'])) {
    $colname_rq_salle_etab = $lib->securite_xss(base64_decode($_GET['idSalle']));
}

$query_rq_salle_etab = $dbh->query("SELECT `IDTYPE_SALLE`, `TYPE_SALLE`, `IDETABLISSEMENT` FROM `TYPE_SALLE` WHERE IDTYPE_SALLE = $colname_rq_salle_etab");
foreach($query_rq_salle_etab->fetchAll() as $row_rq_salle_etab){

    $id=$row_rq_salle_etab['IDTYPE_SALLE'];
    $typeSalle=$row_rq_salle_etab['TYPE_SALLE'];

}


if(isset($_POST) && $_POST !=null) {

    $res = $niv->modifier($lib->securite_xss_array($_POST),'IDTYPE_SALLE',$lib->securite_xss($_POST['IDTYPE_SALLE']));
    if ($res==1) {
        $msg="Modification effectuée avec succès!";

    }
    else{
        $msg="Echec de la modification";
    }
    header("Location: typeSalle.php?msg=".$msg."&res=".$res);
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Type salle</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

                <form action="modifTypeSalle.php" method="POST" >

            <div class="row">

                <div class="col-xs-12">
                    <div class="form-group">
                        <label >TYPE SALLE</label>
                        <div>
                            <input type="text" name="TYPE_SALLE" id="TYPE_SALLE" required class="form-control" value="<?php echo $typeSalle; ?>"/>
                        </div>
                    </div>
                </div>

                <br><br>



                <div class="col-lg-12">
                    <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier" /></div>

                </div>

            </div>

            <input type="hidden" name="IDTYPE_SALLE" value="<?php  echo $id; ?>" />
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