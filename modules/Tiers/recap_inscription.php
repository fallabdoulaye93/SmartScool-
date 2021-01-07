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

if (isset($_POST) && $_POST != null && $_POST['recap'] == 1)
{
   // var_dump($_POST['nbremois']);exit;
    $res=1;
    $msg = "Inscription effectuée avec succes";
    if (isset($_POST['nbremois'])) {
        $urlredirect = "inscription.php?msg=$msg&res=$res&idetablissement=".$lib->securite_xss($_POST['idetablissement']). "&idinscription=" . $_POST['idinscription'] . "&IDINDIVIDU=" . $_POST['IDINDIVIDU'] ."&nbremois=".$_POST['nbremois'];

    }else{
        $urlredirect = "inscription.php?msg=$msg&res=$res&idetablissement=".$lib->securite_xss($_POST['idetablissement']). "&idinscription=" . $_POST['idinscription'] . "&IDINDIVIDU=" . $_POST['IDINDIVIDU'];

    }
    header("Location:$urlredirect");
}



$colname_rq_etablissement = "1";
if (isset($_GET['idetablissement'])) {
    $colname_rq_etablissement = $lib->securite_xss(base64_decode($_GET['idetablissement']));
}


try
{
    $query_rq_etablissement = $dbh->query("SELECT IDETABLISSEMENT, NOMETABLISSEMENT_, SIGLE, ADRESSE, TELEPHONE, VILLE, PAYS, FAX, MAIL, SITEWEB, LOGO FROM ETABLISSEMENT WHERE IDETABLISSEMENT = ".$colname_rq_etablissement);
    $row_rq_etablissement =$query_rq_etablissement->fetchObject();

    $colname_rq_eleve = "-1";
    if (isset($_GET['idinscription'])) {
        $colname_rq_eleve = $lib->securite_xss(base64_decode($_GET['idinscription']));
    }



    $query_rq_eleve = $dbh->query("SELECT INS.*, IND.*, S.LIBSERIE, CL.LIBELLE, NIV.ID_NIV_SER, NIV.dure, NI.LIBELLE as niveauetude, A.LIBELLE_ANNEESSOCLAIRE, B.LABEL
                                      FROM INSCRIPTION INS
                                      INNER JOIN INDIVIDU IND ON IND.IDINDIVIDU = INS.IDINDIVIDU 
                                      INNER JOIN SERIE S ON INS.IDSERIE = S.IDSERIE 
                                      INNER JOIN AFFECTATION_ELEVE_CLASSE AFF ON INS.IDINDIVIDU = AFF.IDINDIVIDU 
                                      INNER JOIN CLASSROOM CL ON CL.IDCLASSROOM = AFF.IDCLASSROOM 
                                      INNER JOIN NIVEAU_SERIE NIV ON INS.IDNIVEAU = NIV.IDNIVEAU
                                      INNER JOIN NIVEAU NI ON NI.IDNIVEAU = INS.IDNIVEAU 
                                      INNER JOIN ANNEESSCOLAIRE A ON A.IDANNEESSCOLAIRE = INS.IDANNEESSCOLAIRE 
                                      LEFT JOIN BANQUE B ON B.ROWID = INS.FK_BANQUE 
                                      WHERE INS.IDINSCRIPTION = ".$colname_rq_eleve);
    $row_rq_eleve = $query_rq_eleve->fetchObject();

    $colname_rq_tuteur = "-1";
    if (isset($row_rq_eleve->IDTUTEUR)) {
        $colname_rq_tuteur = $row_rq_eleve->IDTUTEUR;
    }

    $query_rq_tuteur = $dbh->query("SELECT * FROM INDIVIDU WHERE INDIVIDU.IDINDIVIDU = ".$colname_rq_tuteur);
    $row_rq_tuteur = $query_rq_tuteur->fetchObject();
    $colname_rq_pays =$row_rq_eleve->NATIONNALITE ;

    $query_rq_pays = $dbh->query("SELECT * FROM PAYS WHERE ROWID = ".$colname_rq_pays);
    $row_rq_pays = $query_rq_pays->fetchObject();

    //dure de la formation
    $colname_rq_dure_formation = $row_rq_eleve->IDSERIE;
    $colname1_rq_dure_formation =$row_rq_eleve->IDNIVEAU;
    //var_dump($colname_rq_dure_formation." ".$colname1_rq_dure_formation);exit;

   /* $query_rq_dure_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE IDSERIE = ".$colname_rq_dure_formation." AND NIVEAU_SERIE.IDNIVEAU = ".$colname1_rq_dure_formation);
    $row_rq_dure_formation = $query_rq_dure_formation->fetchObject();
    */

    $query_rq_dure_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE NIVEAU_SERIE.IDNIVEAU = ".$colname1_rq_dure_formation);
    $row_rq_dure_formation = $query_rq_dure_formation->fetchObject();
   // var_dump($row_rq_dure_formation);exit;

    $mensPD=($row_rq_eleve->ACCORD_MENSUELITE*2);
    $colname_rq_nbremois = "-1";
    //var_dump($_GET['nbremois']);
    if (isset($_GET['nbremois'])) {

        $colname_rq_nbremois = $lib->securite_xss($_GET['nbremois']);
        $montant_nbre_mois=($row_rq_eleve->ACCORD_MENSUELITE*$colname_rq_nbremois);

    }else{
        $montant_nbre_mois=0;
    }
   // var_dump($montant_nbre_mois);exit;
    //cout total
   // var_dump($row_rq_eleve->MONTANT_UNIFORME);
    if($row_rq_eleve->MONTANT_UNIFORME>0){
        $somme_frais= $row_rq_eleve->FRAIS_INSCRIPTION+$row_rq_eleve->FRAIS_DOSSIER+$row_rq_eleve->MONTANT_TRANSPORT+$row_rq_eleve->FRAIS_EXAMEN+$row_rq_eleve->MONTANT_UNIFORME+ $row_rq_eleve->VACCINATION+ $row_rq_eleve->ASSURANCE+$row_rq_eleve->FRAIS_SOUTENANCE+$mensPD ;
//var_dump($somme_frais);exit;
    }else{
        $somme_frais= $row_rq_eleve->FRAIS_INSCRIPTION+$row_rq_eleve->FRAIS_DOSSIER+$row_rq_eleve->MONTANT_TRANSPORT+$row_rq_eleve->FRAIS_EXAMEN+$row_rq_eleve->UNIFORME+ $row_rq_eleve->VACCINATION+ $row_rq_eleve->ASSURANCE+$row_rq_eleve->FRAIS_SOUTENANCE+$mensPD ;

    }
    $cout_total_formation=($row_rq_eleve->ACCORD_MENSUELITE * ($row_rq_dure_formation->dure-2)) + $somme_frais;
    //var_dump($row_rq_dure_formation->dure-2);exit;
    //$cout_scolarite=($row_rq_eleve->ACCORD_MENSUELITE * $row_rq_dure_formation->dure) + $row_rq_eleve->FRAIS_INSCRIPTION;
    $cout_scolarite = $row_rq_eleve->FRAIS_INSCRIPTION;
}
catch (PDOException $e)
{
    echo -2;die();
}
?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TIERS</a></li>
    <li>Recap Inscription</li>
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

                <?php if(isset($_GET['msg']) && $_GET['msg'] != '') {

                    if(isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>
                <div class="row">
                    <div style="font-size: 16px;font-weight: bold;text-align: center;">FICHE D'INSCRIPTION</div>
                </div>

                    <div class="row">

                    <!--    <div class="col-md-6 pull-left"><span style="font-weight: bold;">Domaine :</span> <?php /*echo $row_rq_eleve->LIBSERIE; */?></div>
                        <div class="col-md-6 pull-right" style="float: right"><span style="font-weight: bold;">Annee Scolaire :</span><?php /*echo $row_rq_eleve->LIBELLE_ANNEESSOCLAIRE; */?></div>
-->
                    </div>
                <fieldset class="cadre">
                    <legend> IDENTIFICATION DE L'ELEVE </legend>
                    <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Matricule:</div>
                        <div class="col-md-6"><?php echo $row_rq_eleve->MATRICULE ?></div>

                    </div>
                    <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Prénom et nom:</div>
                        <div class="col-md-6"><?php echo $row_rq_eleve->PRENOMS." ".$row_rq_eleve->NOM ?></div>

                    </div>
                    <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Date de naissance:</div>
                        <div class="col-md-6"><?php echo $lib->date_franc($row_rq_eleve->DATNAISSANCE)?></div>

                    </div>
                     <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Téléphone:</div>
                        <div class="col-md-6"><?php echo $row_rq_eleve->TELMOBILE?></div>

                    </div>

                    <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Classe:</div>
                        <div class="col-md-6"><?php echo $row_rq_eleve->LIBELLE?></div>

                    </div>
                    <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Date d'inscription:</div>
                        <div class="col-md-6"><?php echo $lib->date_franc($row_rq_eleve->DATEINSCRIPT)?></div>

                    </div>
                </fieldset>

                <hr/>

                <fieldset class="cadre">
                    <legend> ENGAGEMENTS </legend>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Moyen de paiement: </div>
                        <div class="col-md-6"><?php if($row_rq_eleve->FK_MOYENPAIEMENT==2) echo "Cheque";else echo "Espece"?></div>

                    </div>
                <?php if($row_rq_eleve->FK_MOYENPAIEMENT==2){ ?>
                    <div class="row">

                        <div class="col-md-6" style="font-weight: bold">Numero cheque:</div>
                        <div class="col-md-6"><?php echo $row_rq_eleve->NUM_CHEQUE ?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Banque: </div>
                        <div class="col-md-6"><?php echo $row_rq_eleve->LABEL ?></div>

                    </div>
                <?php } ?>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Frais inscription: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($cout_scolarite)." FCFA"?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Deux Mois: </div>
                        <div class="col-md-6"><?php echo  $lib->nombre_form($mensPD)." FCFA"?></div>

                    </div>
                    <?php if($montant_nbre_mois>0) {?>
                        <div class="row">
                            <div class="col-md-6" style="font-weight: bold">Avance mensualite : </div>
                            <div class="col-md-6"><?php echo $lib->nombre_form($montant_nbre_mois)." FCFA"?></div>

                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Uniforme: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($row_rq_eleve->UNIFORME)." FCFA"?></div>

                    </div>

                    <?php if($row_rq_eleve->MONTANT_UNIFORME>0) {?>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Acompte uniforme: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($row_rq_eleve->MONTANT_UNIFORME)." FCFA"?></div>

                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Transport: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($row_rq_eleve->MONTANT_TRANSPORT)." FCFA"?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Assurance: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($row_rq_eleve->ASSURANCE)." FCFA" ?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Frais de dossier: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($row_rq_eleve->FRAIS_DOSSIER)." FCFA" ?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">Frais d'examen: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($row_rq_eleve->FRAIS_EXAMEN)." FCFA" ?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">TOTAL INSCRIPTION: </div>
                        <div class="col-md-6"><?php  if($row_rq_eleve->MONTANT_UNIFORME>0){echo $lib->nombre_form($cout_scolarite+$mensPD+$row_rq_eleve->MONTANT_UNIFORME+$row_rq_eleve->MONTANT_TRANSPORT+$row_rq_eleve->ASSURANCE+$row_rq_eleve->FRAIS_DOSSIER+$row_rq_eleve->FRAIS_EXAMEN+$montant_nbre_mois); } else {echo $lib->nombre_form($cout_scolarite+$mensPD+$row_rq_eleve->UNIFORME+$row_rq_eleve->MONTANT_TRANSPORT+$row_rq_eleve->ASSURANCE+$row_rq_eleve->FRAIS_DOSSIER+$row_rq_eleve->FRAIS_EXAMEN+$montant_nbre_mois);} " FCFA " ?></div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" style="font-weight: bold">MONTANT TOTAL FORMATION: </div>
                        <div class="col-md-6"><?php echo $lib->nombre_form($cout_total_formation)." francsCFA " ?></div>

                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-12 pull-right">
                        <form id="form" name="form1" method="post" action="recap_inscription.php">
                            <input type="hidden" name="recap" value="1">
                            <input type="hidden" name="idetablissement" value="<?php print $lib->securite_xss($_GET['idetablissement']); ?>">
                            <input type="hidden" name="idinscription" value="<?php print $lib->securite_xss($_GET['idinscription']); ?>">
                            <input type="hidden" name="IDINDIVIDU" value="<?php print $lib->securite_xss($_GET['IDINDIVIDU']); ?>">
                           <?php if (isset($_GET['nbremois'])){ ?>
                                <input type="hidden" name="nbremois" value="<?php print $lib->securite_xss($_GET['nbremois']); ?>">
                            <?php } ?>
                            <input type="submit"  id="valider" name="valider" class="btn btn-success" value="Imprimer">

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


