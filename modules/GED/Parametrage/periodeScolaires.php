<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(12, $lib->securite_xss($_SESSION['profil'])));

$colname_REQ_periode = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_periode = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try{
    $an_scolaire = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, IDETABLISSEMENT 
    FROM ANNEESSCOLAIRE 
    WHERE ETAT = 0 
    AND IDETABLISSEMENT = " . $colname_REQ_periode);
    $rs_an = $an_scolaire->fetchObject();

    
    $annee_scolaire = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, IDETABLISSEMENT 
    FROM ANNEESSCOLAIRE 
    WHERE ETAT = 0 
    AND IDETABLISSEMENT = " . $colname_REQ_periode);
    $rs_anne = $annee_scolaire->fetchAll(PDO::FETCH_ASSOC);

    $query_REQ_periode = $dbh->query("SELECT P.IDPERIODE, P.NOM_PERIODE, P.DEBUT_PERIODE, P.FIN_FPERIODE, P.IDANNEESSCOLAIRE, P.IDETABLISSEMENT, N.LIBELLE 
                                                FROM PERIODE P INNER JOIN NIVEAU N ON P.IDNIVEAU = N.IDNIVEAU
                                                WHERE P.IDANNEESSCOLAIRE = ".$rs_an->IDANNEESSCOLAIRE." 
                                                AND P.IDETABLISSEMENT = " . $colname_REQ_periode);
    $rs_periode = $query_REQ_periode->fetchAll(PDO::FETCH_ASSOC);


    $cycle = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $colname_REQ_periode);
    $rs_cycle = $cycle->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOException $e){
    echo -2;
}
?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>P&eacute;riodes scolaires</li>
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
                        <i class="fa fa-plus"></i> Nouvelle p&eacute;riode scolaire
                    </button>

                </div>

            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if(isset($_GET['res']) && $_GET['res'] != 1) {?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>P&Eacute;RIODE</th>
                        <th>DEBUT</th>
                        <th>FIN</th>
                        <th>CYCLE</th>

                        <th style="text-align: center !important;">Modifier</th>
                        <th style="text-align: center !important;">Supprimer</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php foreach ($rs_periode as $periode) { ?>

                        <tr>

                            <td><?php echo $periode['NOM_PERIODE']; ?></td>
                            <td><?php echo $lib->affiche_periode($periode['DEBUT_PERIODE']); ?></td>
                            <td><?php echo $lib->affiche_periode($periode['FIN_FPERIODE']); ?></td>
                            <td><?php echo $periode['LIBELLE']; ?></td>

                            <td style="text-align: center !important;"><a href="modifPeriode.php?idPeriode=<?php echo base64_encode($periode['IDPERIODE']) ; ?>"><i
                                        class=" glyphicon glyphicon-edit"></i></a></td>

                            <td style="text-align: center !important;"><a href="suppPeriode.php?idPeriode=<?php echo base64_encode($periode['IDPERIODE']); ?>"
                                   onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i
                                        class="glyphicon glyphicon-remove"></i></a></td>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouvelle p&eacute;riode scolaire </h3>
                    <!--IDPERIODE NOM_PERIODE DEBUT_PERIODE FIN_FPERIODE IDANNEESSCOLAIRE IDETABLISSEMENT-->
                </div>
                <form action="ajouterPeriode.php" method="POST">

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>NOM P&Eacute;RIODE</label>

                                    <div>
                                        <input type="text" name="NOM_PERIODE" id="NOM_PERIODE" required
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>DEBUT P&Eacute;RIODE</label>

                                    <div>
                                        <input type="text" id="date_foo" value="" name="DEBUT_PERIODE" required
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>FIN P&Eacute;RIODE</label>

                                    <div>
                                        <input type="text" id="date_foo2" name="FIN_FPERIODE" required
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CYCLE</label>
                                    <div>
                                        <select name="IDNIVEAU" class="form-control" required>
                                            <option value="">-- Séléctionner cycle --</option>
                                            <?php foreach ($rs_cycle as $cyc) { ?>

                                                <option value=" <?php echo $cyc['IDNIVEAU']; ?>"><?php echo $cyc['LIBELLE']; ?> </option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>ANNEE SCOLAIRE</label>
                                    <div>
                                        <select name="IDANNEESSCOLAIRE" class="form-control" required>
                                            <option value="">-- Séléctionner année scolaire --</option>
                                            <?php foreach ($rs_anne as $an) { ?>

                                                <option value=" <?php echo $an['IDANNEESSCOLAIRE']; ?>"><?php echo $an['LIBELLE_ANNEESSOCLAIRE']; ?> </option>

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



