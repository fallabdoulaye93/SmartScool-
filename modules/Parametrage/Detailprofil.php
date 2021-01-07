<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once("classe/ProfileManager.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil'])));

$colname_REQ_users = "-1";
if (isset($_SESSION['etab']))
{
    $colname_REQ_users = $lib->securite_xss($_SESSION['etab']);
}
$id = base64_decode($lib->securite_xss($_GET['idProfil']));
try
{
    $rq_dictionnaire_module = $dbh->query("SELECT idModule, nomModule FROM MODULE WHERE 1 ORDER BY idModule ASC");
    $rs_module = $rq_dictionnaire_module->fetchAll();

    $sql_p = $dbh->query("SELECT profil FROM profil WHERE idProfil = ".$id);
    $le_profil = $sql_p->fetchObject()->profil;
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
    <li>Détail Profil</li>
</ul>

<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

            </div>
            <div class="panel-body">


                <fieldset class="cadre">
                    <legend class="libelle_champ">Gérer les actions du profil : <?php echo $le_profil; ?></legend>

                    <div class="row">

                        <div class="col-lg-6">
                            <button class="btn btn-warning">Retour</button>
                        </div>


                        <div class="col-lg-6">
                            <button class="btn btn-success" data-toggle="modal" data-target="#actionsProfil">Gérer les actions du profil</button>
                        </div>

                    </div>

                </fieldset>

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


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="actionsProfil" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
                <div class="panel panel-default">

                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Droits &amp; permissions du profil : <?php echo $le_profil; ?></h4>
                    </div>

                    <div class="panel-body">

                        <form method="post" action="permissionTraite.php" >
                            <div class="box-body">

                                <?php foreach($rs_module  as $module){ ?>


                                    <fieldset class="cadre">
                                        <legend>

                                            <dl>
                                                <dt style="padding: 15px 0px 0px 0px;"><?php echo $module['nomModule']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" style="width: 9%;" class="check<?= $module['idModule']; ?>" id="checkAll<?= $module['idModule']; ?>"> Séléctionner tout</dt>
                                            </dl>
                                        </legend>

                                        <div class="row">
                                            <dl>
                                                <dd>
                                                    <?php
                                                    try
                                                    {
                                                        $allActions = $dbh->query("SELECT a.idAction, a.label, a.module FROM ACTION a WHERE  a.module = ".$module['idModule']);
                                                        $res = $allActions->fetchAll(PDO::FETCH_ASSOC);

                                                        $mesactionsAutorises = array();
                                                        $sql = $dbh->query("SELECT idAffectation, action, profil, valide FROM affectationDroit WHERE profil = ".$id);
                                                        $a = $sql->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach($a as $t)
                                                    {
                                                        array_push($mesactionsAutorises, $t['action']);
                                                    }
                                                    foreach($res as $action){ ?>

                                                        <div style="display:flex;float:left;" class="col-lg-4 col-md-4 col-sm-6 col-xs-12 flat-red-bis">
                                                            <input type="checkbox" style="width: 9%;" name="action[]" value="<?= $action['idAction'];  ?>" id="lesactions" class="check<?= $module['idModule']; ?>" <?php if(in_array($action['idAction'], $mesactionsAutorises)) echo 'checked' ?>  />&nbsp;<span style="float:left;"><?= ($action['label']); ?>&nbsp;</span>
                                                        </div>

                                                    <?php }

                                                    }
                                                    catch (PDOException $exception){
                                                        echo -2;
                                                    }?>

                                                </dd>
                                            </dl>
                                        </div>

                                    </fieldset>

                                <?php } ?>
                            </div>
                            <input type="hidden" name="profil" id="profil" value="<?php echo $lib->securite_xss($id); ?>"/>

                            <div class="modal-footer">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="reset" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" name="button" id="valider" value="valide"  class="btn btn-success">Enregistrer</button>
                                </div>
                            </div>


                        </form>

                    </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal-dialog -->
    </div


<?php include('footer.php'); ?>

<script>
    <?php foreach($rs_module as $module){?>

    $( "#checkAll<?= $module['idModule']; ?>" ).click(function() {
        $(".check<?= $module['idModule']; ?>").prop('checked', $(this).prop('checked'));
    });

    <?php } ?>
</script>
