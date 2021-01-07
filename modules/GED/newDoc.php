<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("../../restriction.php");


require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(17, $_SESSION['profil']));

$colname_rq_individu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
    $colname_rq_individu = $lib->securite_xss($_GET['IDINDIVIDU']);
}

$colname_etab = "-1";
if (isset($_SESSION['etab'])) {
    $colname_etab = $_SESSION['etab'];
}

try
{
    $query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = " . $colname_rq_individu);
    $row_rq_individu = $query_rq_individu->fetchObject();

    //$query_rq_doc = $dbh->query("SELECT * FROM DOCADMIN WHERE IDETABLISSEMENT = ".$colname_etab);


    $query_rq_typ_doc = $dbh->query("SELECT IDTYPEDOCADMIN, LIBELLE, CONTENU, IDETABLISSEMENT, IDMODELE_DOC, IDTYPEINDIVIDU 
                                               FROM TYPEDOCADMIN 
                                               WHERE IDETABLISSEMENT = ".$colname_etab);
    $rs_type_doc = $query_rq_typ_doc->fetchAll();

    //$query_rq_anneescolaire = $dbh->query("SELECT * FROM ANNEESSCOLAIRE WHERE IDETABLISSEMENT = ".$colname_etab);
}
catch(PDOException $e)
{
    echo -2;
}
?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">GED</a></li>
    <li>Nouveau document</li>
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
                </div>
            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <div class="row">
                    <div class="col-lg-5">
                        <fieldset class="cadre">
                            <legend> INFORMATIONS PERSONNELLES</legend>
                            <table width="100%" border="0" cellspacing="2">
                                <tr>
                                    <th>MATRICULE</th>
                                    <th>NOM</th>
                                    <th>PRENOM(S)</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row_rq_individu->MATRICULE; ?></td>
                                    <td><?php echo $row_rq_individu->NOM; ?></td>
                                    <td><?php echo $row_rq_individu->PRENOMS; ?></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div class="col-lg-7">
                        <form action="listeDocuments.php" method="post" name="form1" id="form1" enctype="multipart/form-data">
                            <fieldset class="cadre">
                                <legend>NOUVEAU DOCUMENT</legend>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>LIBELLE</label>
                                        <div>
                                            <input type="text" required name="LIBELLE" id="LIBELLE" class="form-control" >
                                            <p id="demo"></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>MOTIF</label>
                                        <div>
                                            <input type="text" name="MOTIF" id="MOTIF" class="form-control" required  />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>TYPE DOCUMENT</label>
                                        <div>
                                            <select required name="IDTYPEDOCADMIN" id="IDTYPEDOCADMIN" class="form-control">
                                                <option value="">--Selectionner--</option>

                                                <?php foreach ($rs_type_doc as $row_rq_typ_doc) { ?>

                                                    <option value="<?php echo $row_rq_typ_doc['IDTYPEDOCADMIN']; ?>"> <?php echo $row_rq_typ_doc['LIBELLE']; ?></option>

                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>DATE DELIVRANCE</label>
                                        <div>
                                            <input type="text" required name="DATEDELIVRANCE" id="date_foo" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>FICHIER A JOINDRE</label>
                                        <div>
                                            <input type="file" required name="FICHIER" id="FICHIER" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-offset-5 col-xs-1">
                                <br/>
                                    <input name="Envoyer" type="submit" value="Valider" class="btn btn-success" onclick="myFunction()"/>
                                </div>
                                <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']); ?>"/>
                                <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>"/>
                                <input type="hidden" name="IDINDIVIDU" value="<?php echo $lib->securite_xss($_GET['IDINDIVIDU']); ?>"/>
                                <input type="hidden" name="ID_AUTHORITE" value="0"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
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


<?php include('footer.php'); ?>

<script>
    function myFunction() {
        var inpObj = document.getElementById("LIBELLE");
        if (!inpObj.checkValidity()) {
            document.getElementById("demo").innerHTML = inpObj.validationMessage;
        }
    }


</script>
