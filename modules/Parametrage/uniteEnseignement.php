<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($lib->securite_xss($_SESSION['profil']) != 1)
    $lib->Restreindre($lib->Est_autoriser(6, $lib->securite_xss($_SESSION['profil'])));

$colname_REQ_ue = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_ue = $lib->securite_xss($_SESSION['etab']);
}

require_once('classe/FiliereManager.php');
$series = new FiliereManager($dbh, 'SERIE');
$serie = $series->getFiliere('IDETABLISSEMENT', $lib->securite_xss($_SESSION['etab']));

require_once('classe/NiveauManager.php');
$niveaux = new NiveauManager($dbh, 'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT', $lib->securite_xss($_SESSION['etab']));

try{
    $periode = $dbh->query("SELECT IDPERIODE, NOM_PERIODE, DEBUT_PERIODE, FIN_FPERIODE, IDANNEESSCOLAIRE, IDETABLISSEMENT FROM PERIODE");
    $rs_periode = $periode->fetchAll();

    $query_REQ_ue = $dbh->query("SELECT UE.*, NIVEAU.LIBELLE AS LIBNIVEAU, SERIE.LIBSERIE 
                                        FROM UE, NIVEAU, SERIE 
                                        WHERE UE.IDETABLISSEMENT = " . $colname_REQ_ue . " 
                                        AND UE.IDSERIE=SERIE.IDSERIE 
                                        AND UE.IDNIVEAU=NIVEAU.IDNIVEAU 
                                        ORDER BY UE.LIBELLE ASC");
    $rs_UE = $query_REQ_ue->fetchAll();
}
catch (PDOException $e){
    echo  -2;
}


?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Unit&eacute; d'enseignement</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

                <div class="btn-group pull-right">
                    <button data-toggle="modal" data-target="#ajouter"
                            style="background-color:#DD682B" class='btn dropdown-toggle' , aria-hidden='true'>
                        <i class="fa fa-plus"></i> Nouvelle unit&eacute; d'enseignement
                    </button>

                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>UNITES D'ENSEIGNEMENTS</th>
                        <th>NIVEAU</th>
                        <th>FILI&Egrave;RE / S&Eacute;RIE</th>
                        <th>MODIFIER</th>

                        <th>SUPPRIMER</th>
                        <th>DETAILS</th>
                    </tr>
                    </thead>


                    <tbody>

                    <?php foreach ($rs_UE as $ue) {
                        $array = array(
                            "id" => $ue['IDUE']
                        );
                        $param=base64_encode(json_encode($array)); ?>

                        <tr>

                            <td><?php echo $ue['LIBELLE']; ?></td>
                            <td><?php echo $ue['LIBNIVEAU']; ?></td>
                            <td><?php echo $ue['LIBSERIE']; ?></td>

                            <td><a href="modifUE.php?idUE=<?php echo $param; ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>

                            <td>
                                <a href="suppUE.php?idUE=<?php echo $param; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </td>

                            <td><a href="detailsUE.php?idUE=<?php echo $param ; ?>"><i class=" glyphicon glyphicon-list"></i></a></td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <!-- END WIDGETS -->


</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter"
     data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouvelle unit&eacute; d'enseignement </h3>
                    <!-- IDUE LIBELLE IDNIVEAU IDSERIE SEMESTRES IDETABLISSEMENT -->
                </div>
                <form action="ajouterUE.php" method="POST" id="form">

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>LIBELLE</label>

                                    <div>
                                        <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>NIVEAU</label>

                                    <div>
                                        <select name="IDNIVEAU" class="form-control selectpicker" data-live-search="true" id="idNiveau" required>
                                            <option value="">-- S&eacute;lectionner le niveau--</option>
                                            <?php foreach ($niveau as $niv) { ?>

                                                <option value=" <?php echo $niv->getIDNIVEAU(); ?>"><?php echo $niv->getLIBELLE(); ?> </option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>FILIERE / SERIE</label>

                                    <div>
                                        <select name="IDSERIE" class="form-control selectpicker" data-live-search="true" required>
                                            <option value="">-- S&eacute;lectionner la fili&egrave;re / série--</option>

                                            <?php foreach ($serie as $ser) {?>

                                                <option value=" <?php echo $ser->getIDSERIE(); ?>"><?php echo $ser->getLIBSERIE(); ?> </option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>PERIODE</label>

                                    <div>
                                        <select name="SEMESTRES" class="form-control selectpicker" data-live-search="true" required>
                                            <option value="">-- S&eacute;lectionner le semestre--</option>

                                            <?php foreach ($rs_periode as $per) {?>

                                                <option value=" <?php echo $per['IDPERIODE']; ?>"><?php echo $per['NOM_PERIODE']; ?> </option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>

                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>



