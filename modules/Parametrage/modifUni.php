<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($lib->securite_xss($_SESSION['profil']) != 1)
    $lib->Restreindre($lib->Est_autoriser(53, $lib->securite_xss($_SESSION['profil'])));

$colname_REQ_class = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_class = $lib->securite_xss($_SESSION['etab']);
}



require_once('classe/NiveauManager.php');
$niveaux = new NiveauManager($dbh, 'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT', $colname_REQ_class);

require_once("classe/UniformeManager.php");
require_once("classe/Uniforme.php");
$uni = new UniformeManager($dbh, 'UNIFORME');


$colname_rq_classe_etab = "-1";
if (isset($_GET['uni']))
{
    $colname_rq_classe_etab = base64_decode($lib->securite_xss($_GET['uni']));
}

$query_rq_classe_etab = $dbh->query("SELECT ROWID, LIBELLE, IDNIVEAU, MONTANT FROM UNIFORME WHERE ROWID = ".$colname_rq_classe_etab);
//var_dump($query_rq_classe_etab);exit;
foreach ($query_rq_classe_etab->fetchAll() as $row_rq_classe_etab)
{
    $id = $row_rq_classe_etab['ROWID'];
    $libelle = $row_rq_classe_etab['LIBELLE'];
    $idNiveau = $row_rq_classe_etab['IDNIVEAU'];
    $montant = $row_rq_classe_etab['MONTANT'];
}

if (isset($_POST) && $_POST != null)
{
    $iduni = $lib->securite_xss($_POST['ROWID']);
    unset($_POST['ROWID']);
    $res = $uni->modifier($lib->securite_xss_array($_POST), 'ROWID', $iduni);
    if($res == 1)
    {
        $msg = "Modification effectuée avec succés";
    }
    else {
        $msg = "Votre mofication a échouée";
    }
    header("Location: uniforme.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Niveaux</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="modifUni.php" method="POST">

            <div class="row">


                <div class="col-xs-12">
                    <div class="form-group">
                        <label>CYCLE</label>
                        <div>
                            <select name="IDNIVEAU" class="form-control selectpicker" data-live-search="true" id="selectNiv">
                                <option value="">--Selectionner le cylce--</option>
                                <?php foreach ($niveau as $niv) { ?>

                                    <option value=" <?php echo $niv->getIDNIVEAU(); ?>" <?php if ($idNiveau == $niv->getIDNIVEAU()) echo "selected" ?> ><?php echo $niv->getLIBELLE(); ?> </option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12">
                    <div class="form-group">
                        <label>LIBELLE</label>

                        <div>
                            <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control" value="<?php echo $libelle; ?>"/>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>MONTANT</label>

                        <div>
                            <input type="text" name="MONTANT" id="MONTANT" required class="form-control" value="<?php echo $montant; ?>"/>
                        </div>

                    </div>
                </div>

                <br><br>


                <div class="col-lg-12">
                <br/>
                    <div class="col-lg-offset-5" id="idvalider"><input type="submit" class="btn btn-success" value="Modifier"/></div>

                </div>

            </div>

            <input type="hidden" name="ROWID" value="<?php echo $id; ?>"/>

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

