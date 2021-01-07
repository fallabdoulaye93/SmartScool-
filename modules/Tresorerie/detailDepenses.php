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

if (isset($_GET['IDREGLEMENT'])) {
    $idDepense = $lib->securite_xss(base64_decode($_GET['IDREGLEMENT']));

}
$query_rq_depense = $dbh->query("SELECT DEPENSE.IDREGLEMENT, DATE_REGLEMENT, MONTANT, MOTIF,  TYPE_PAIEMENT.libelle_paiement as typePaiemnet, REFERENCE, NUM_CHEQUE, BANQUE.LABEL as banque, DEPENSE.IDTYPEPAIEMENT
                                              FROM  DEPENSE
                                              INNER JOIN TYPE_PAIEMENT ON TYPE_PAIEMENT.id_type_paiment = DEPENSE.IDTYPEPAIEMENT 
                                              LEFT JOIN BANQUE ON BANQUE.ROWID = DEPENSE.FK_BANQUE 
                                              WHERE DEPENSE.IDREGLEMENT = ".$idDepense);
$query_rq_depense = $query_rq_depense->fetchObject();


?>
<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Dépenses</li>
    <li>Details</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Detail</span></a></li>

                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content" style="margin-top: 30px;">
                            <div role="tabpanel" class="tab-pane active" id="detail">
                                <div class="col-lg-offset-3 col-md-6 col-lg-offset-3">

                                        <table class="table table-responsive table-striped" >
                                            <tr>
                                                <td><strong>DATE REGLEMENT</strong></td>
                                                <td style="text-align: right;"><?php  echo $lib->date_fr($query_rq_depense->DATE_REGLEMENT);  ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>MONTANT</strong></td>
                                                <td style="text-align: right;"><?php  echo $query_rq_depense->MONTANT;  ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>MOTIF</strong></td>
                                                <td style="text-align: right;"><?php  echo $query_rq_depense->MOTIF;  ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>TYPE DE PAYEMENT</strong></td>
                                                <td style="text-align: right;"><?php  echo $query_rq_depense->typePaiemnet;  ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>REFERENCE</strong></td>
                                                <td style="text-align: right;"><?php  echo $query_rq_depense->REFERENCE;  ?></td>
                                            </tr>


                                            <?php if($query_rq_depense->IDTYPEPAIEMENT == 1 || $query_rq_depense->IDTYPEPAIEMENT == 3){ ?>

                                                <tr>
                                                    <td><strong>NUMERO CHEQUE</strong></td>
                                                    <td style="text-align: right;"><?php  echo $query_rq_depense->NUM_CHEQUE;  ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>BANQUE</strong></td>
                                                    <td style="text-align: right;"><?php  echo $query_rq_depense->banque;  ?></td>
                                                </tr>

                                            <?php } ?>

                                            <tr>
                                                <td></td>
                                                <td style="text-align: right;">
                                                    <a href="depenses.php"><input type="button" class="btn btn-success" value="Retour"/></a>
                                                </td>
                                            </tr>
                                        </table>
                                </div>
                        </div>
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

