<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(41,$lib->securite_xss($_SESSION['profil'])));

$etablissement = "-1";
if (isset($_SESSION['etab'])) {
    $etablissement = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_professeur = $dbh->query("SELECT * FROM INDIVIDU WHERE IDETABLISSEMENT = ".$etablissement." AND INDIVIDU.IDTYPEINDIVIDU=7");

$query_rq_forfait = $dbh->query("SELECT `ROWID`, `LIBELLE`, `NBRE_JOUR`, `MONTANT`, `IDETABLISSEMENT` FROM `FORFAIT_PROFESSEUR` WHERE IDETABLISSEMENT=".$etablissement);

$colname_rq_classe_etab = "-1";
if (isset($_GET['IDRECRUTE_PROF']))
{
    $colname_rq_classe_etab = $lib->securite_xss(base64_decode($_GET['IDRECRUTE_PROF']));
}
elseif (isset($_POST['IDRECRUTE_PROF']))
{
    $colname_rq_classe_etab = $lib->securite_xss($_POST['IDRECRUTE_PROF']);
}

$query_rq_classe_etab = $dbh->query("SELECT DISTINCT RECRUTE_PROF.IDRECRUTE_PROF, TARIF_HORAIRE, VOLUME_HORAIRE, RECRUTE_PROF.IDETABLISSEMENT, IDINDIVIDU, IDANNEESSCOLAIRE, TYPES, 
                                            FK_FORFAIT, CLASSROOM.IDNIVEAU as niveau , CLASSROOM.IDCLASSROOM as IDCLASSROOM 
                                            FROM RECRUTE_PROF 
                                            INNER JOIN CLASSE_ENSEIGNE ON CLASSE_ENSEIGNE.IDRECRUTE_PROF = RECRUTE_PROF.IDRECRUTE_PROF 
                                            INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = CLASSE_ENSEIGNE.IDCLASSROM 
                                            WHERE RECRUTE_PROF.IDRECRUTE_PROF =" .$colname_rq_classe_etab);
foreach($query_rq_classe_etab->fetchAll() as $row_rq_classe_etab)
{
    $id=$row_rq_classe_etab['IDRECRUTE_PROF'];
    $TARIF_HORAIRE=$row_rq_classe_etab['TARIF_HORAIRE'];
    $VOLUME_HORAIRE=$row_rq_classe_etab['VOLUME_HORAIRE'];
	$IDINDIVIDU=$row_rq_classe_etab['IDINDIVIDU'];
	$TYPES=$row_rq_classe_etab['TYPES'];
	$FK_FORFAIT=$row_rq_classe_etab['FK_FORFAIT'];
	$NIVEAU=$row_rq_classe_etab['niveau'];
}

if($NIVEAU > 0)
{
    $query_rq_classroom = $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = " . $etablissement . " AND IDNIVEAU = " . $NIVEAU);

    $query_rq_module = $dbh->query("SELECT * FROM MATIERE WHERE IDETABLISSEMENT = ".$etablissement. " AND IDNIVEAU = " . $NIVEAU);
}
else
{
    $query_rq_classroom = $dbh->query("SELECT * FROM CLASSROOM WHERE IDETABLISSEMENT = " . $etablissement);

    $query_rq_module = $dbh->query("SELECT * FROM MATIERE WHERE IDETABLISSEMENT = ".$etablissement);

}

require_once("classe/RecrutManager.php");
require_once("classe/Recrut.php");
$niv=new RecrutManager($dbh,'RECRUTE_PROF');
if(isset($_POST) && $_POST !=null)
{
    $res = $niv->modifier($lib->securite_xss_array($_POST) ,'IDRECRUTE_PROF',$colname_rq_classe_etab);
    $query = $dbh->prepare("UPDATE RECRUTE_PROF SET TARIF_HORAIRE =:TARIF_HORAIRE, VOLUME_HORAIRE=:VOLUME_HORAIRE, FK_FORFAIT=:FK_FORFAIT  WHERE IDRECRUTE_PROF =:IDRECRUTE_PROF");
    $res = $query->execute(array("TARIF_HORAIRE"=>$lib->securite_xss($_POST['TARIF_HORAIRE']),"VOLUME_HORAIRE"=>$lib->securite_xss($_POST['VOLUME_HORAIRE']),"FK_FORFAIT"=>$lib->securite_xss($_POST['FK_FORFAIT']), "IDRECRUTE_PROF"=>$colname_rq_classe_etab));
    if ($res==1)
    {

        $tabMat = $_POST['IDMATIERE'];
        $tabClasse = $_POST['IDCLASSROOM'];
        $classe = count($_POST['IDMATIERE']);
        $matiere = count($_POST['IDCLASSROOM']);
        if($matiere>0 && $classe>0)
        {
                $query="DELETE FROM CLASSE_ENSEIGNE WHERE IDRECRUTE_PROF=:IDRECRUTE_PROF";
                $query1="DELETE FROM MATIERE_ENSEIGNE WHERE ID_INDIVIDU=:ID_INDIVIDU";
                try
                {
                    $classeEns = $dbh->prepare($query);
                    $classeEns->execute(array("IDRECRUTE_PROF"=>$colname_rq_classe_etab));
                    $classeEns->execute();

                    $matiereEns = $dbh->prepare($query1);
                    $matiereEns->execute(array("ID_INDIVIDU"=>$lib->securite_xss($_POST['IDINDIVIDU'])));
                    $matiereEns->execute();

                    $res1 = [];
                    $res2 = [];
                    foreach ($tabMat as $one){
                        $stmt = $dbh->prepare("INSERT INTO MATIERE_ENSEIGNE(ID_INDIVIDU, ID_MATIERE, IDETABLISSEMENT, IDANNESCOLAIRE)VALUES (?, ?, ?, ?)");
                        $res1[] = $stmt->execute(array($lib->securite_xss($_POST['IDINDIVIDU']), $one, $lib->securite_xss($_POST['IDETABLISSEMENT']), $lib->securite_xss($_POST['IDANNEESSCOLAIRE'])));

                    }

                    foreach ($tabClasse as $one){
                        $stmt1 = $dbh->prepare("INSERT INTO CLASSE_ENSEIGNE(IDRECRUTE_PROF, IDCLASSROM, IDANNESCOLAIRE, IDETABLISSEMENT)VALUES (?, ?, ?, ?)");
                        $res2[] = $stmt1->execute(array($colname_rq_classe_etab, $one, $lib->securite_xss($_POST['IDANNEESSCOLAIRE']), $lib->securite_xss($_POST['IDETABLISSEMENT'])));

                    }

                        if(count($res1) == count($tabMat) && count($res2) == count($tabClasse) && !in_array(false, $res1) && !in_array(false, $res2)){

                            $msg = 'Modification effectué avec succés';

                        } else{
                            $msg = 'Modification effectué avec echec';


                        }
                }
                catch(PDOException $e)
                {
                    $msg="Modification effectué avec echec ";
                }
        }
    }
    header("Location: listeProfesseurRecrutes.php?msg=".$msg."&res=".$res);
}

?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Professeurs recrut&eacute;s</li>
                </ul>
                <!-- END BREADCRUMB -->  
                <!-- PAGE CONTENT WRAPPER -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;
                <div class="btn-group pull-right">

                </div>

            </div>

            <div class="panel-body">
                <!-- START WIDGETS -->
                    <div class="row">

                        <form action="modifRecrut.php" method="POST" id="form" >

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                    <label >Professeur:</label>
                                    <div>
                                    <select name="IDINDIVIDU" class="form-control" data-live-search="true">
                                            <?php
                                            foreach ($query_rq_professeur->fetchAll() as $row_rq_professeur){

                                            ?>
                                        <option value=" <?php echo $row_rq_professeur['IDINDIVIDU']; ?>" <?php if($row_rq_professeur['IDINDIVIDU']==$IDINDIVIDU) echo "selected"; ?>><?php echo $row_rq_professeur['PRENOMS']; ?> <?php echo $row_rq_professeur['NOM']?> </option>
                                            <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                </div>
                                <div class="col-xs-12">
                                <div class="form-group">

                                    <fieldset class="cadre">
                                        <legend> Matiére (s):</legend>



                                    <div>

                                            <?php
                                            $mesMatieresEns= array();
                                            $query_rq_matiere = $dbh->query("SELECT ID_MATIERE FROM MATIERE_ENSEIGNE
                                             INNER JOIN RECRUTE_PROF ON RECRUTE_PROF.IDINDIVIDU=MATIERE_ENSEIGNE.ID_INDIVIDU
                                             WHERE RECRUTE_PROF.IDRECRUTE_PROF = " . $colname_rq_classe_etab. " AND MATIERE_ENSEIGNE.IDANNESCOLAIRE=".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
                                            $a = $query_rq_matiere->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($a as $t)
                                            {
                                                array_push($mesMatieresEns, $t['ID_MATIERE']);
                                            }

                                            foreach ($query_rq_module->fetchAll() as $row_rq_module) { ?>

                                                <div class="col-md-4" style="padding-bottom: 15px;">
                                                    <input type="checkbox" name="IDMATIERE[]" value="<?php echo $row_rq_module['IDMATIERE']; ?>" <?php if(in_array($row_rq_module['IDMATIERE'], $mesMatieresEns)) echo 'checked'; ?> > <?php echo $row_rq_module['LIBELLE'];?>
                                                </div>

                                            <?php } ?>

                                    </div>

                                    </fieldset>
                                </div>
                            </div>
                               <div class="col-xs-12">
                                <div class="form-group">
                                    <fieldset class="cadre">
                                        <legend> Classe (s):</legend>

                                         <div>

                                            <?php
                                            $mesClasseEns= array();

                                            $query_rq_clas = $dbh->query("SELECT CLASSE_ENSEIGNE.IDCLASSROM FROM CLASSROOM, CLASSE_ENSEIGNE 
                                                 WHERE CLASSE_ENSEIGNE.IDRECRUTE_PROF = " . $colname_rq_classe_etab . " 
                                                 AND CLASSE_ENSEIGNE.IDANNESCOLAIRE=".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE'])."
                                                 AND CLASSE_ENSEIGNE.IDCLASSROM=CLASSROOM.IDCLASSROOM");

                                                $a1 = $query_rq_clas->fetchAll(PDO::FETCH_ASSOC);

                                                foreach($a1 as $t1)
                                                {
                                                    array_push($mesClasseEns, $t1['IDCLASSROM']);
                                                }

                                            foreach ($query_rq_classroom->fetchAll() as $row_rq_classroom){
                                            ?>

                                                <div class="col-md-4" style="padding-bottom: 15px;">
                                                    <input type="checkbox" name="IDCLASSROOM[]" value="<?php echo $row_rq_classroom['IDCLASSROOM']; ?>" <?php if(in_array($row_rq_classroom['IDCLASSROOM'], $mesClasseEns)) echo 'checked'; ?> > <?php echo $row_rq_classroom['LIBELLE'];?>
                                                </div>

                                            <?php } ?>

                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <?php if($TYPES==1) { ?>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label >FORFAIT</label>
                                        <div>
                                            <select name="FK_FORFAIT" class="form-control" data-live-search="true">
                                                <?php
                                                foreach ($query_rq_forfait->fetchAll() as $row_rq_forfait){
                                                    ?>
                                                    <option value=" <?php echo $row_rq_forfait['ROWID']; ?>" <?php if($row_rq_forfait['ROWID']==$FK_FORFAIT) echo "selected"; ?>><?php echo $row_rq_forfait['LIBELLE']. " - " .number_format($row_rq_forfait['MONTANT'],0,""," "); ?>  </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-xs-12">
                                <div class="form-group">
                                    <label>TARIF HORAIRE</label>
                                    <div>
                                        <input type="text" name="TARIF_HORAIRE" id="TARIF_HORAIRE" required class="form-control" value="<?php echo $lib->nombre_form($TARIF_HORAIRE); ?>"/>
                                    </div>
                                </div>
                            </div>
                            
                                <div class="col-xs-12">
                                <div class="form-group">
                                    <label>VOLUME HORAIRE</label>
                                    <div>
                                        <input type="number" name="VOLUME_HORAIRE" id="VOLUME_HORAIRE" required class="form-control" value="<?php echo $VOLUME_HORAIRE; ?>"/>
                                    </div>
                                </div>
                            </div>

                            <?php  }?>
          
                            </div>

                                <br><br>

                                <div class="col-lg-6 pull-left">
                                    <input type="button"  class="btn btn-warning" value="Retour" onclick="history.back()"/>
                                </div>
                                <div class="col-lg-6 pull-right">
                                    <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier" /></div>
                                </div>

                            <input type="hidden" name="IDRECRUTE_PROF" value="<?php  if($_GET['IDRECRUTE_PROF']!='') echo $lib->securite_xss(base64_decode($_GET['IDRECRUTE_PROF'])); else  echo $id; ?>" />
                            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $_SESSION['etab']; ?>" />
                            <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php  echo $_SESSION['ANNEESSCOLAIRE'];?>" />


                        </form>

                    </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>