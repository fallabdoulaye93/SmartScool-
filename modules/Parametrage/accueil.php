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
    $lib->Restreindre($lib->Est_autoriser(3, $lib->securite_xss($_SESSION['profil'])));


$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

try
{
    $query_rq_etablissement = $dbh->query("SELECT IDETABLISSEMENT, NOMETABLISSEMENT_, SIGLE, ADRESSE, TELEPHONE, REGLEMENTINTERIEUR, VILLE, PAYS, DEVISE, FAX, 
                                                      MAIL, SITEWEB, LOGO, CAPITAL, FORM_JURIDIQUE, RC, NINEA, NUM_TV, PREFIXE, BP, TABLEAUHONNEUR
                                                      FROM ETABLISSEMENT 
                                                      WHERE IDETABLISSEMENT = " . $colname_rq_etablissement);
    $row_rq_etablissement = $query_rq_etablissement->fetchObject();
    $totalRows_rq_etablissement = $query_rq_etablissement->rowCount();


    $query_rq_pays = $dbh->query("SELECT ROWID, CODE, CODE_ISO, LIBELLE, ACTIVE FROM PAYS");
    $row_rq_pays = $query_rq_pays->fetchObject();
    $totalRows_rq_pays = $query_rq_pays->rowCount();
}
catch (PDOException $e)
{
    echo -2;
}


?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>&Eacute;tablissement</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

        if (isset($_GET['res']) && $_GET['res'] == 1) {
            ?>
            <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                aria-label="close">&times;</a>
                <?php echo $lib->securite_xss($_GET['msg']); ?></div>
        <?php }
        if (isset($_GET['res']) && $_GET['res'] != 1) {
            ?>
            <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $lib->securite_xss($_GET['msg']); ?></div>
        <?php }
        ?>

    <?php } ?>


    <div class="panel panel-default">

        <div class="panel-body">

            <!-- START WIDGETS -->
            <div class="row">

                <h3>Fiche &Eacute;tablissement</h3>

                <fieldset class="cadre">
                    <legend class="libelle_champ">Informations g&eacute;n&eacute;rales</legend>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="inputEmail3"
                                       class="col-sm-2 form-control-label"><b>&Eacute;tablissement: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->NOMETABLISSEMENT_; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Adresse: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->ADRESSE; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3"
                                       class="col-sm-2 form-control-label"><b>T&eacute;l&eacute;phone: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->TELEPHONE; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Ville: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->VILLE; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Email: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->MAIL; ?>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Sigle: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->SIGLE; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Fax: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->FAX; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Pays: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->PAYS; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Site web: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->SITEWEB; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>BP: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->BP; ?>
                                </div>
                            </div>


                        </div>
                    </div>

                </fieldset>

                <fieldset class="cadre">
                    <legend class="libelle_champ">Identifiants r&eacute;glementaires</legend>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Devise: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->DEVISE; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Capital Social: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->CAPITAL; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Statut juridique: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->FORM_JURIDIQUE; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>RC: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->RC; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>NINEA: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->NINEA; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>TVA: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->NUM_TV; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Pr&eacute;fixe: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->PREFIXE; ?>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="form-group row">

                                <div class="col-sm-12" style="background-color: #E1E1E1">
                                    <img src="../../logo_etablissement/<?php echo $row_rq_etablissement->LOGO; ?>" alt=""
                                         name="" width="70%"/>
                                </div>
                            </div>


                        </div>
                    </div>
                </fieldset>

                <fieldset class="cadre">
                    <legend class="libelle_champ">Moyenne tableau d'honneur paramétrée </legend>
                    <div class="row">
                        <div class="col-lg-9">

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Moyenne: </b></label>

                                <div class="col-sm-10" style="background-color: #E1E1E1">
                                    <?php echo $row_rq_etablissement->TABLEAUHONNEUR; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </fieldset>

                <?php if (($lib->securite_xss($_SESSION['profil']) == 1) || ($lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil'])) == 1)) { ?>

                    <form method="post" name="form1" action="modifEtablissement.php">
                        <div class="row">
                            <div class="col-lg-offset-5 col-lg-1">
                                <button type="submit" class="btn btn-success" value="modifier">Modifier</button>
                            </div>
                        </div>

                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $row_rq_etablissement->IDETABLISSEMENT; ?>">
                    </form>

                <?php } ?>

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