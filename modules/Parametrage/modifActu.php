
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
require_once("classe/ActualiteManager.php");
require_once("classe/Actualite.php");
$niv=new ActualiteManager($dbh,'ACTUALITES');

require_once('classe/ClasseManager.php');
$classes=new ClasseManager($dbh,'CLASSROOM');
$classe = $classes->getClasse("IDETABLISSEMENT",$_SESSION['etab']);

$colname_rq_actu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_actu = $_SESSION['etab'];
}

$query_REQ_classe2 = $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = ".$colname_rq_actu);


$colname_rq_actu = "-1";
if (isset($_GET['idActu'])) {
    $colname_rq_actu = $_GET['idActu'];
}
// IDACTUALITES 	DATE_ACTUALITE 	TITRE_ACTU 	DESCRIPTION_ACTU 	IDCLASSROOM 	IDETABLISSEMENT IDANNEESSCOLAIRE

$query_rq_user_etab = $dbh->query("SELECT * FROM ACTUALITES WHERE IDACTUALITES = $colname_rq_actu");
foreach($query_rq_user_etab->fetchAll() as $row_rq_user_etab){

    $id=$row_rq_user_etab['IDACTUALITES'];
    $DATE_ACTUALITE=$row_rq_user_etab['DATE_ACTUALITE'];
    $TITRE_ACTU=$row_rq_user_etab['TITRE_ACTU'];
    $DESCRIPTION_ACTU=$row_rq_user_etab['DESCRIPTION_ACTU'];
    $IDCLASSROOM=$row_rq_user_etab['IDCLASSROOM'];
    $IDETABLISSEMENT=$row_rq_user_etab['IDETABLISSEMENT'];
    $IDANNEESSCOLAIRE=$row_rq_user_etab['IDANNEESSCOLAIRE'];

}


if(isset($_POST) && $_POST !=null) {


    $res = $niv->modifier($_POST,'IDACTUALITES',$_POST['IDACTUALITES']);
    if ($res==1) {
        
        $msg="Modification effectuée avec succés";

    }
    else{
        $msg="Modification effectuée avec echec";
    }
   header("Location: journalEcole.php?msg=$msg&res=$res");
}

?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Journal de l'&eacute;cole</li>
                </ul>
                <!-- END BREADCRUMB -->  
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <!-- START WIDGETS -->                    
                    <div class="row">

                        <form action="modifActu.php" method="POST" >

                            <div class="row">

                                <!--IDACTUALITES 	DATE_ACTUALITE 	TITRE_ACTU 	DESCRIPTION_ACTU 	IDCLASSROOM 	IDETABLISSEMENT IDANNEESSCOLAIRE-->
                                 <div class="col-xs-12">
                                <div class="form-group">
                                    <label >DATE ACTUALITE</label>
                                    <div>
                                        <input type="text" name="DATE_ACTUALITE" id="date_foo" required class="form-control" value="<?php echo $DATE_ACTUALITE; ?>"/>
                                    </div>
                                </div>
                            </div>


                            

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >TITRE ACTUALITE</label>
                                    <div>
                                        <input type="text" name="TITRE_ACTU" id="TITRE_ACTU" required class="form-control" value="<?php echo $TITRE_ACTU; ?>"/>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-xs-12">
                                <div class="form-group">
                                    <label >DESCRIPTION ACTUALITE</label>
                                    <div>
                                        <textarea  name="DESCRIPTION_ACTU" id="mytextarea"  class="form-control"> <?php echo $DESCRIPTION_ACTU; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-xs-12">
                                  <div class="form-group">
                                  <label>Classe</label>
                                 <div >
                                 <select name="IDCLASSROOM" id="IDCLASSROOM" class="form-control selectpicker" data-live-search="true">
                                 <option value="">--Selectionner--</option>
                                      <?php foreach ($query_REQ_classe2->fetchAll() as $class){ ?>
                                          <option value="<?php echo $class['IDCLASSROOM']; ?>"   <?php if($class['IDCLASSROOM'] == $IDCLASSROOM) echo "selected" ?>><?php echo $class['LIBELLE']; ?></option>
                                      <?php } ?>
                                  </select>
                            </div>
                            </div>
                            </div> 


                                <div class="col-lg-12"><br>

                                    <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier"/></div>

                                </div>


                            </div>

                            
                            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $_SESSION['etab']; ?>" />

                            <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo $_SESSION["ANNEESSCOLAIRE"]; ?>" />
                            <input type="hidden" name="IDACTUALITES" value="<?php echo $id; ?>" />
                           



                        </form>



                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>