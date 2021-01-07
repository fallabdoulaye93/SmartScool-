
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(10, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/EtablissementManager.php");
require_once("classe/Etablissement.php");
$etab=new EtablissementManager($dbh,'ETABLISSEMENT');

$colname_rq_reglement_int = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_reglement_int = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_reglement_int = $dbh->query("SELECT IDETABLISSEMENT, REGLEMENTINTERIEUR FROM ETABLISSEMENT WHERE IDETABLISSEMENT = $colname_rq_reglement_int");
foreach($query_rq_reglement_int->fetchAll() as $row_rq_reglement_int){
    $ri= $row_rq_reglement_int['REGLEMENTINTERIEUR'];
    $id=$row_rq_reglement_int['IDETABLISSEMENT'];
}

if(isset($_POST) && $_POST !=null) {

    $res = $etab->modifier($_POST,'IDETABLISSEMENT', $lib->securite_xss($_POST['IDETABLISSEMENT']));
    if ($res==1) {
        $msg="Modification effectuée avec succès !";

    }
    else{
        $msg="Echec de la modification";
    }
    header("Location: reglementInterieur.php?msg=".$msg."&res=".$res);
}

?>


<?php include('../header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>R&eacute;glement int&eacute;rieur</li>
                </ul>
                <!-- END BREADCRUMB -->  
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <!-- START WIDGETS -->                    
                    <div class="row">

                        <form  method="POST" action="modifRI.php">
                           <textarea name="REGLEMENTINTERIEUR" cols="150" rows="15" class="form-control" id="mytextarea" class="textbrute2"> <?php echo $ri; ?>
                           </textarea>

                            <input type="hidden" name="IDETABLISSEMENT"  id="IDETABLISSEMENT" value="<?php

                                echo $id;
                            ?>" /><br>
                            <div class="col-lg-offset-9 col-lg-1"> <input type="submit"  class="btn btn-success" value="Modifer le réglement" /></div>

                        </form>



                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>