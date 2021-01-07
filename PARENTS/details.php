<?php
include('header.php');

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$nomEtudiant = str_replace("-"," ", $lib->securite_xss($_GET['NOM']));
$idEtudiant = str_replace("-"," ", base64_decode($lib->securite_xss($_GET['IDETUDIANT'])));
//var_dump($idEtudiant);die();

$etab = $lib->securite_xss($_SESSION['etab']);
$annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);

try
{
    $query_exo_etudiant = $dbh->prepare("SELECT e.IDEXERCICE as idexo, e.LIBELLE as libexo, e.DATEEXO as dateexo, e.DATERETOUR as retourexo, m.LIBELLE as matiere
                                               FROM EXERCICE e
                                               INNER JOIN MATIERE m ON e.IDMATIERE = m.IDMATIERE
                                               WHERE e.IDETABLISSEMENT = ".$lib->securite_xss($_SESSION['etab'])." 
                                               AND e.IDANNEE = ".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE'])." 
                                               AND e.IDCLASSROOM = ".$lib->securite_xss($_GET['IDCLASSROOM'])."
                                               ORDER BY e.DATEEXO ASC ");
    $query_exo_etudiant->execute();
    $query_exo_etudiant = $query_exo_etudiant->fetchAll(PDO::FETCH_OBJ);

    $query_sanc_etudiant = $dbh->prepare("SELECT s.MOTIF as motif, s.DATEDEBUT as datedebut, s.DATEFIN as datefin
                                              FROM SANCTION s
                                              WHERE s.IDETABLISSEMENT = ".$etab." 
                                              AND s.IDANNEE = ". $annee." 
                                              AND s.IDINDIVIDU = ".$idEtudiant."
                                              ORDER BY s.DATEDEBUT ASC ");
    $query_sanc_etudiant->execute();
    $query_sanc_etudiant = $query_sanc_etudiant->fetchAll(PDO::FETCH_OBJ);

    $query_fer_etudiant = $dbh->prepare("SELECT v.LIB_VACANCES as libelle, v.DATE_DEBUT as datedebut, v.DATE_FIN as datefin
                                             FROM VACANCES v
                                             WHERE v.IDETABLISSEMENT = ".$lib->securite_xss($_SESSION['etab'])."
                                             ORDER BY v.DATE_DEBUT ASC ");
    $query_fer_etudiant->execute();
    $query_fer_etudiant = $query_fer_etudiant->fetchAll(PDO::FETCH_OBJ);
}
catch (PDOException $e)
{
    echo -2;
}

?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">PARENT</a></li>
    <li class="active">Mensualité</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">
        <div>
            <p><h4 style="color:#E05D1F;margin-left: 15px;">Suivi de l'éléve : <b><?= $nomEtudiant; ?></b></h4></p>
        </div>
        <div class="panel panel-default">
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

                <div class="row">
                    <fieldset class="cadre">
                        <legend> Exercices assignées à l'éléve</legend>
                        <table id="customers2" class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th width="25%">Libelle exercice</th>
                                    <th width="25%">Date exercie</th>
                                    <th width="25%">Date de retour</th>
                                    <th width="25%">Matiére</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($query_exo_etudiant)>0){
                                    foreach ($query_exo_etudiant as $oneExo) {  ?>
                                    <tr>
                                        <td><?= $oneExo->libexo; ?></td>
                                        <td><?= $lib->date_fr($oneExo->dateexo); ?></td>
                                        <td><?= $lib->date_fr($oneExo->retourexo); ?></td>
                                        <td><?= $oneExo->matiere; ?></td>
                                    </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <fieldset class="cadre">
                            <legend> Sanctions de l'éléve </legend>

                            <table id="customers2" class="table datatable table-striped">
                                <thead>
                                    <tr>
                                        <th width="25%">Motif sanction</th>
                                        <th width="25%">Date de debut</th>
                                        <th width="25%">Date de fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($query_sanc_etudiant)>0){
                                        foreach ($query_sanc_etudiant as $oneSanc) {  ?>
                                        <tr>
                                            <td><?= $oneSanc->motif; ?></td>
                                            <td><?= $lib->date_fr($oneSanc->datedebut); ?></td>
                                            <td><?= $lib->date_fr($oneSanc->datefin); ?></td>
                                        </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                    <div class="col-lg-6">
                        <fieldset class="cadre">
                            <legend> Jours fériés</legend>
                            <table id="customers2" class="table datatable table-striped">
                                <thead>
                                    <tr>
                                        <th width="25%">Libelle</th>
                                        <th width="25%">Date de debut</th>
                                        <th width="25%">Date de fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if(count($query_fer_etudiant)>0){
                                        foreach ($query_fer_etudiant as $oneFerie) {  ?>
                                        <tr>
                                            <td><?= $oneFerie->libelle; ?></td>
                                            <td><?= $lib->date_fr($oneFerie->datedebut); ?></td>
                                            <td><?= $lib->date_fr($oneFerie->datefin); ?></td>
                                        </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row" >
        <div class="col-sm-5"></div>
        <div class="col-sm-5"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-1 btn-primary" style="width: 60px;" >
            <a href="mes_etudiant.php" style="color:#FFFFFF; font-size:14px;vertical-align: middle;line-height: 35px;"> Retour</a>
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