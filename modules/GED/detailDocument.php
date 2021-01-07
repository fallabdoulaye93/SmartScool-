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

if(isset($_SESSION['etab']) && isset($_SESSION['ANNEESSCOLAIRE']))
{
    $etab = $lib->securite_xss($_SESSION['etab']);
    $anne = $lib->securite_xss($_SESSION["ANNEESSCOLAIRE"]);
}

$id_docadmin = "-1";
if(isset($_GET['IDINDIVIDU']))
{
    $indiv = $lib->securite_xss(base64_decode($_GET['IDINDIVIDU']));
}


try
{
    $query_rq_individu = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, MATRICULE, NOM, PRENOMS, DATNAISSANCE, ADRES, TELMOBILE, TELDOM, COURRIEL, PHOTO_FACE, CLASSROOM.LIBELLE as classe, NIVEAU.LIBELLE as niveau
                                                FROM INDIVIDU 
                                                INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                                INNER JOIN NIVEAU ON INSCRIPTION.IDNIVEAU = NIVEAU.IDNIVEAU 
                                                INNER JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                                INNER JOIN CLASSROOM ON AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM
                                                WHERE INDIVIDU.IDINDIVIDU = ".$indiv);
                                                $row_rq_individu = $query_rq_individu->fetchObject();

    $query_rq_individu1 = $dbh->query("SELECT DOCADMIN.IDDOCADMIN, DOCADMIN.LIBELLE, DOCADMIN.NOM, TYPEDOCADMIN.LIBELLE as typeDoc
                                                FROM DOCADMIN 
                                                INNER JOIN TYPEDOCADMIN ON TYPEDOCADMIN.IDTYPEDOCADMIN = DOCADMIN.IDTYPEDOCADMIN
                                                WHERE DOCADMIN.IDINDIVIDU =".$indiv."  
                                                AND DOCADMIN.IDANNEESSCOLAIRE=".$anne." 
                                                AND  DOCADMIN.IDETABLISSEMENT=".$etab);
                                                $row_rq_individu1 = $query_rq_individu1->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}

 include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">GED</a></li>
    <li>Liste Documents</li>
    <li>Details</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class=" panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 col-xs-12 ">

                        <div class="panel" style="padding: 20px;">
                            <div class="user-btm-box">
                                <!-- .row    -->
                                <div class="col-sm-12" align="center">
                                    <img class="img-circle" width="200" alt="<?php echo $row_rq_individu->PHOTO_FACE; ?>"
                                         src="../../imgtiers/<?php echo $row_rq_individu->PHOTO_FACE; ?>" style="padding-bottom: 20px;">
                                </div>

                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>PRENOM</strong>
                                        <p><?php echo $row_rq_individu->PRENOMS; ?></p>
                                    </div>
                                    <div class="col-md-6"><strong>NOM</strong>
                                        <p><?php echo  $row_rq_individu->NOM; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <!-- .row -->
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>ADRESSE</strong>
                                        <p><?php echo  $row_rq_individu->ADRES; ?></p>
                                    </div>
                                    <div class="col-md-6"><strong>TELEPHONE MOBILE</strong>
                                        <p><?php echo $row_rq_individu->TELMOBILE; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>
                                <div class="row text-center m-t-10">
                                    <div class="col-md-6 b-r"><strong>CYCLE</strong>
                                        <p><?php echo $row_rq_individu->niveau; ?></p>
                                    </div>
                                    <div class="col-md-6"><strong>CLASSE</strong>
                                        <p><?php echo $row_rq_individu->classe; ?></p>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <hr>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-xs-12">
                        <div class="panel" style="padding: 20px;">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="true">
                                        <span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Pièces jointes</span>
                                    </a>
                                </li>

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content" style="margin-top: 30px;">

                                <div role="tabpanel" class="tab-pane active" id="profile">

                                        <table id="customers2" class="table datatable">
                                            <thead>
                                            <tr>
                                                <th>LIBELLE</th>
                                                <th>TYPE DE FICHIER</th>
                                                <th>TELECHARGER</th>


                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($row_rq_individu1 as $document) { ?>

                                                <tr>
                                                    <td><?php echo $document['LIBELLE']; ?></td>
                                                    <td><?php echo $document['typeDoc']; ?></td>
                                                    <td>
                                                        <a href="../../document/<?php echo $document['NOM']; ?>" target="_blank" title="Télécharger">
                                                            <i class=" glyphicon glyphicon-download " style="font-size: 21px"></i>

                                                        </a>

                                                    </td>

                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>

<script>
    $(function () {
        $('#myTab li:first-child a').tab('show')
    })
</script>

