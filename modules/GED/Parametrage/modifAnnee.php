
<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(11,$lib->securite_xss($_SESSION['profil'])));


require_once("classe/AnneeScolaireManager.php");
require_once("classe/AnneeScolaire.php");
$niv=new AnneeScolaireManager($dbh,'ANNEESSCOLAIRE');


$colname_rq_annee_etab = "-1";
if (isset($_GET['idAnnee'])) {
    $colname_rq_annee_etab = base64_decode($lib->securite_xss($_GET['idAnnee']));
}

$query_rq_annee_etab = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, IDETABLISSEMENT 
                                              FROM ANNEESSCOLAIRE WHERE IDANNEESSCOLAIRE = $colname_rq_annee_etab");
foreach($query_rq_annee_etab->fetchAll() as $row_rq_annee_etab){

    $id=$row_rq_annee_etab['IDANNEESSCOLAIRE'];
    $libelle=$row_rq_annee_etab['LIBELLE_ANNEESSOCLAIRE'];
    $debut=$row_rq_annee_etab['DATE_DEBUT'];
    $fin=$row_rq_annee_etab['DATE_FIN'];
}


if(isset($_POST) && $_POST !=null) {


    $res = $niv->modifier($lib->securite_xss_array($_POST),'IDANNEESSCOLAIRE',$lib->securite_xss($_POST['IDANNEESSCOLAIRE']));
    if ($res==1) {
        $msg="Modification effectuée avec succés";

    }
    else{
        $msg="Modification effectuée avec echec";
    }
    header("Location: anneesScolaires.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Ann&eacute;es scolaires</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

                <form action="modifAnnee.php" method="POST" >

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label >LIBELLE</label>
                                <div>
                                    <input type="text" name="LIBELLE_ANNEESSOCLAIRE" id="LIBELLE_ANNEESSOCLAIRE" required class="form-control" value="<?php  echo $libelle;  ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label >DATE DEBUT</label>
                                <div>
                                    <input type="text" id="date_foo" name="DATE_DEBUT"  required class="form-control" value="<?php  echo $debut;  ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label >DATE FIN</label>
                                <div>
                                    <input type="text" id="date_foo2" name="DATE_FIN"  required class="form-control" value="<?php  echo $fin;  ?>"/>
                                </div>
                            </div>
                        </div>
                        <br><br>



                        <div class="col-lg-12">

                            <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier" /></div>

                        </div>

                    </div>

                    <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php  echo $id; ?>" />
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