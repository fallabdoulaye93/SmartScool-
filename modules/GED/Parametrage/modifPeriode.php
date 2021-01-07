
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(12,$lib->securite_xss($_SESSION['profil'])));

require_once("classe/PeriodeScolaireManager.php");
require_once("classe/PeriodeScolaire.php");
$niv=new PeriodeScolaireManager($dbh,'PERIODE');


$colname_rq_periode_etab = "-1";
if (isset($_GET['idPeriode'])) {
    $colname_rq_periode_etab = base64_decode($lib->securite_xss($_GET['idPeriode']));
}
$colname_REQ_periode = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_periode = $lib->securite_xss($_SESSION['etab']);
}
try{
    $query_rq_periode_etab = $dbh->query("SELECT IDPERIODE, NOM_PERIODE, DEBUT_PERIODE, FIN_FPERIODE, IDANNEESSCOLAIRE, IDETABLISSEMENT, IDNIVEAU 
                                                FROM PERIODE 
                                                WHERE IDPERIODE = $colname_rq_periode_etab");
    foreach($query_rq_periode_etab->fetchAll() as $row_rq_periode_etab)
    {
        $id = $row_rq_periode_etab['IDPERIODE'];
        $periode = $row_rq_periode_etab['NOM_PERIODE'];
        $debut = $row_rq_periode_etab['DEBUT_PERIODE'];
        $fin = $row_rq_periode_etab['FIN_FPERIODE'];
        $idNiveau = $row_rq_periode_etab['IDNIVEAU'];
        $idAnnee = $row_rq_periode_etab['IDANNEESSCOLAIRE'];
    }

    $cycle = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $colname_REQ_periode);
    $rs_cycle = $cycle->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
    echo -2;
}

if(isset($_POST) && $_POST !=null)
{
    $res = $niv->modifier(($lib->securite_xss_array($_POST)),'IDPERIODE',$lib->securite_xss($_POST['IDPERIODE']));
    if ($res==1)
    {
        $msg = "Modification effectuée avec succés";
    }
    else
    {
        $msg = "Modification effectuée avec echec";
    }
    header("Location: periodeScolaires.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Periodes scolaires</li>
                </ul>
                <!-- END BREADCRUMB -->  
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="panel panel-default">

                            <div class="panel-body">

                        <form action="modifPeriode.php" method="POST" >

                            <div class="row">

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label >NOM PERIODE</label>
                                        <div>
                                            <input type="text" name="NOM_PERIODE" id="NOM_PERIODE" required class="form-control" value="<?php echo $periode; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label >DEBUT PERIODE</label>
                                        <div>
                                            <input type="text" id="date_foo" name="DEBUT_PERIODE"  required class="form-control" value="<?php echo $debut; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label >FIN FPERIODE</label>
                                        <div>
                                            <input type="text" id="date_foo2" name="FIN_FPERIODE"  required class="form-control" value="<?php echo $fin; ?>"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>CYCLE</label>
                                        <div>
                                            <select name="IDNIVEAU" class="form-control selectpicker">

                                                <?php foreach ($rs_cycle as $cycl) { ?>

                                                    <option value=" <?php echo $cycl['IDNIVEAU']; ?>" <?php if( $idNiveau == $cycl['IDNIVEAU']) echo"selected" ?>><?php echo $cycl['LIBELLE']; ?> </option>

                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br><br>

                                <div class="col-lg-12">
                                    <div class="col-lg-offset-10"><input type="submit"  class="btn btn-success" value="Modifier"/></div>
                                </div>

                            </div>

                            <input type="hidden" name="IDPERIODE" value="<?php  echo $id; ?>" />
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