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
    $lib->Restreindre($lib->Est_autoriser(24, $lib->securite_xss($_SESSION['profil'])));


$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $lib->securite_xss($_SESSION['etab']);
}
$colname_rq_liste_eveleve = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_liste_eveleve = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_classe = $dbh->query("SELECT MOIS FROM FACTURE WHERE IDETABLISSEMENT = " . $colname_rq_classe . " AND FACTURE.IDANNEESCOLAIRE = " . $colname_rq_anne." GROUP BY MOIS ");


$cond = "";
$titre = "Les factures ";
if (isset($_POST['MOIS']) && $_POST['MOIS'] != '') {
    $cond .= " AND f.MOIS='" . $lib->securite_xss($_POST['MOIS']) . "'";
    $titre .= " DU MOIS DE " . $lib->affiche_mois($_POST['MOIS']);
}

if (isset($_POST['MATRICULE']) && $_POST['MATRICULE'] != '') {
    $cond .= " AND INDIVIDU.MATRICULE='" . $lib->securite_xss($_POST['MATRICULE']) . "'";
    $titre .= " DE MATRICULE  " . $lib->securite_xss($_POST['MATRICULE']);
}
if (isset($_POST['DATE']) && $_POST['DATE'] != '') {
    $date = explode(' ', $lib->securite_xss($_POST['DATE']))[0];
    $cond .= " AND f.DATEREGLMT='" . $date . "'";
    $titre .= " LA DATE DU  " . $lib->date_franc($date);
}
if (isset($_POST['NOM']) && $_POST['NOM'] != '') {
    $cond .= " AND INDIVIDU.NOM='" . $lib->securite_xss($_POST['NOM']) . "'";
    $titre .= " DONT LE NOM EST : " . $lib->securite_xss($_POST['NOM']);
}
if (isset($_POST['PRENOMS']) && $_POST['PRENOMS'] != '') {
    $cond .= " AND INDIVIDU.PRENOMS='" . $lib->securite_xss($_POST['PRENOMS']) . "'";
    $titre .= " DONT LE PRENOM EST : " . $lib->securite_xss($_POST['PRENOMS']);
}
if (isset($_POST['ETAT']) && $_POST['ETAT'] != '') {
    $cond .= " AND f.ETAT='" . $lib->securite_xss($_POST['ETAT']) . "'";
    $titre .= "  NON PAYEES ";
    if ($_POST['ETAT'] == 1) {
        $titre .= "  PAYEES ";
    }
}

try
{
    $query_rq_liste_eveleve = $dbh->query("SELECT f.IDFACTURE, f.NUMFACTURE, f.MOIS, f.MONTANT as MONTANT_F, f.DATEREGLMT, f.IDINSCRIPTION, f.IDETABLISSEMENT, f.MT_VERSE, f.MT_RELIQUAT, f.ETAT as FETAT,
                                                INSCRIPTION.*, INDIVIDU.* 
                                                FROM INSCRIPTION, FACTURE f, INDIVIDU 
                                                WHERE f.IDETABLISSEMENT = " . $colname_rq_liste_eveleve . " 
                                                AND f.IDINSCRIPTION = INSCRIPTION.IDINSCRIPTION 
                                                AND INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU  
                                                AND f.IDANNEESCOLAIRE = " . $colname_rq_anne . " " . $cond . " 
                                                ORDER BY f.IDFACTURE DESC");
}
catch (PDOException $e){
    echo -2;
}
?>

<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TRESORERIE</a></li>
    <li>Facture</li>
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

                <form id="form1" name="form1" method="post" action="">
                    <fieldset class="cadre">
                        <legend> Filtre</legend>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">

                                    <div class="col-lg-3"><label class="control-label">MOIS</label></div>
                                    <div class="col-lg-9">
                                        <select name="MOIS" id="MOIS" class="form-control">
                                            <option value="">mois</option>
                                            <?php foreach ($query_rq_classe->fetchAll() as $row) { ?>
                                                <option
                                                    value="<?php echo $row['MOIS']; ?>" <?php //if($_POST['MOIS'] == $row['MOIS']) echo "selected"; ?>><?php echo $lib->affiche_mois($row['MOIS']); ?></option>
                                            <?php } ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>DATE</label></div>
                                        <div class="col-lg-9">
                                            <input type="text" name="DATE" id="date_foo" class="form-control"
                                                   value="<?php /*echo $_POST['DATE'];*/ ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>ETAT</label></div>
                                        <div class="col-lg-9">
                                            <select name="ETAT" id="ETAT" class="form-control">
                                                <option value="">ETAT DE PAYEMENT</option>
                                                <option value="1" <?php //if($_POST['ETAT'] == 1) echo "selected"; ?>>
                                                    PAY&Eacute;E
                                                </option>
                                                <option value="0" <?php //if($_POST['ETAT'] == 0) echo "selected"; ?>>
                                                    NON PAY&Eacute;E
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>MATRICULE</label></div>
                                        <div class="col-lg-9">
                                            <input type="text" name="MATRICULE" id="MATRICULE" class="form-control"
                                                   value="<?php //echo $_POST['MATRICULE']; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>PRENOMS</label></div>
                                        <div class="col-lg-9">
                                            <input type="text" name="PRENOMS" id="PRENOMS" class="form-control"
                                                   value="<?php //echo $_POST['PRENOMS']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>NOM</label></div>
                                        <div class="col-lg-9">
                                            <input type="text" name="NOM" id="NOM" class="form-control"
                                                   value="<?php //echo $_POST['NOM']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-lg-offset-6 col-lg-1">
                                <div class="form-group">

                                    <div>
                                        <input type="submit" class="btn btn-success" value="Recherher"/>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </fieldset>
                </form>
                <br/>
                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-10"></div>
                  <?php  if (isset($_POST['MOIS']) && $lib->securite_xss($_POST['MOIS'])!="") { ?>

                       <div class="col-md-1">
                           <a href="../../ged/imprimer_listeFacture.php?idMois=<?php echo base64_encode($lib->securite_xss($_POST['MOIS']));?>"><i class="fa fa-file-pdf-o fa-3x" aria-hidden="true" style="color: red;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT PDF"></i></a>
                        </div>
                        <div class="col-md-1">
                            <a href="../../ged/imprimer_listeFactureExcel.php?idMois=<?php echo base64_encode($lib->securite_xss($_POST['MOIS']));?>"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true" style="color: green;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT EXCEL"></i></a>
                        </div>
                    <?php } else { ?>

                        <div class="col-md-1">
                            <a href="../../ged/imprimer_listeFacture.php"><i class="fa fa-file-pdf-o fa-3x" aria-hidden="true" style="color: red;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT PDF"></i></a>
                        </div>
                        <div class="col-md-1">
                            <a href="../../ged/imprimer_listeFactureExcel.php"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true" style="color: green;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT EXCEL"></i></a>
                        </div>
                  <?php } ?>
                    </div>


                </div>
                <br/>


                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Matricule</th>
                        <th>Pr&eacute;nom(s) &amp; Nom</th>
                        <th>Num&eacute;ro</th>
                        <th>Date facture</th>
                        <th>Montant</th>
                        <th>Montant vers&eacute;</th>
                        <th>Montant restant</th>
                        <th>Imprimer</th>
                        <th>Payer</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php foreach ($query_rq_liste_eveleve->fetchAll() as $row_eleve) {
                        $query_rq_liste_eleve_facture = $dbh->query("SELECT ETAT FROM TRANSPORT_MENSUALITE WHERE NUM_FACTURE='".$row_eleve['NUMFACTURE']."'");
                        $req_Etat=$query_rq_liste_eleve_facture->fetchObject();
                        ?>
                        <tr>
                            <td><?php echo $lib->affiche_mois($row_eleve['MOIS']); ?></td>
                            <td><?php echo $row_eleve['MATRICULE']; ?></td>
                            <td><?php echo $row_eleve['PRENOMS'] . "  " . $row_eleve['NOM']; ?></td>
                            <td><?php echo $row_eleve['NUMFACTURE']; ?></td>
                            <td><?php echo $lib->date_franc($row_eleve['DATEREGLMT']); ?></td>
                            <td><?php echo $lib->nombre_form($row_eleve['MONTANT_F']); ?></td>
                            <td><?php echo $lib->nombre_form($row_eleve['MT_VERSE']); ?></td>
                            <td><?php echo $lib->nombre_form($row_eleve['MT_RELIQUAT']); ?></td>

                            <td>
                               
                                <a href="../../ged/imprimer_facture.php?facture=<?= base64_encode($row_eleve['IDFACTURE']); ?>&individu=<?php echo base64_encode($row_eleve['IDINDIVIDU']); ?>&IDINSCRIPTION=<?php echo base64_encode($row_eleve['IDINSCRIPTION']); ?>">
                                    <i class="glyphicon glyphicon-print"></i>
                                </a>
                            </td>

                            <td>

                                <?php if ($row_eleve['FETAT'] != 1 || $req_Etat->ETAT != 0) { ?>

                                    <a href="ficheMensualite.php?IDINDIVIDU=<?php echo base64_encode($row_eleve['IDINDIVIDU']) ; ?>&montant=<?php echo base64_encode($row_eleve['MONTANT_F'])  ?>&IDINSCRIPTION=<?php echo base64_encode($row_eleve['IDINSCRIPTION']) ; ?>&mois=<?php echo base64_encode($row_eleve['MOIS'])  ?>&IDFACTURE=<?php echo base64_encode($row_eleve['IDFACTURE']) ; ?>">
                                        <i class="glyphicon glyphicon-credit-card"></i>
                                    </a>

                                <?php }  if ($row_eleve['FETAT'] == 1 && $req_Etat->ETAT == 0) { ?>

                                    <span style="color:#D3D3D3">
                                        <i class="glyphicon  glyphicon-credit-card"></i>
                                    </span>

                                <?php } ?>

                            </td>

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


<?php include('footer.php'); ?>


