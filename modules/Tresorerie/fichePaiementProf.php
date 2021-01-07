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
    $lib->Restreindre($lib->Est_autoriser(29, $lib->securite_xss($_SESSION['profil'])));

$colname_rq_individu = "-1";
if (isset($_GET['IDINDIVIDU']))
{
    $param=json_decode(base64_decode($lib->securite_xss($_GET['IDINDIVIDU'])));
    $colname_rq_individu = $param->id;
}
elseif(isset($_GET['IDIV']))
{
    $colname_rq_individu = base64_decode($lib->securite_xss($_GET['IDIV']));
}

$colname_rq_anne = "-1";
if(isset($_SESSION['ANNEESSCOLAIRE']))
{
    $colname_rq_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $query_rq_module = $dbh->query("SELECT RECRUTE_PROF.IDINDIVIDU, RECRUTE_PROF.VOLUME_HORAIRE, RECRUTE_PROF.TARIF_HORAIRE, MATIERE.LIBELLE, MATIERE_ENSEIGNE.ID_MATIERE AS IDMATIERE, 
                                          CLASSROOM.IDCLASSROOM, CLASSROOM.LIBELLE as classe, FK_FORFAIT, FORFAIT_PROFESSEUR.MONTANT as MONTANTF, FORFAIT_PROFESSEUR.LIBELLE as libelleF, 
                                          DISPENSER_COURS.MOIS as MOISDISP
                                            FROM RECRUTE_PROF
                                            INNER JOIN MATIERE_ENSEIGNE ON RECRUTE_PROF.IDINDIVIDU = MATIERE_ENSEIGNE.ID_INDIVIDU
                                            INNER JOIN MATIERE ON MATIERE_ENSEIGNE.ID_MATIERE=MATIERE.IDMATIERE
                                            INNER JOIN CLASSE_ENSEIGNE ON RECRUTE_PROF.IDRECRUTE_PROF = CLASSE_ENSEIGNE.IDRECRUTE_PROF
                                            INNER JOIN CLASSROOM ON CLASSE_ENSEIGNE.IDCLASSROM = CLASSROOM.IDCLASSROOM
                                            INNER JOIN DISPENSER_COURS ON DISPENSER_COURS.IDCLASSROOM = CLASSROOM.IDCLASSROOM
                                            LEFT JOIN FORFAIT_PROFESSEUR ON FORFAIT_PROFESSEUR.ROWID = RECRUTE_PROF.FK_FORFAIT
                                            WHERE RECRUTE_PROF.IDINDIVIDU = " . $colname_rq_individu . " 
                                            AND RECRUTE_PROF.IDANNEESSCOLAIRE = " . $colname_rq_anne ." group by MOISDISP");
    $rs_module = $query_rq_module->fetchAll();


    $query_rq_historique_paiement = $dbh->query("SELECT * FROM REGLEMENT_PROF, TYPE_PAIEMENT 
                                                      WHERE INDIVIDU = " . $colname_rq_individu . " 
                                                      AND TYPE_PAIEMENT.id_type_paiment=REGLEMENT_PROF.IDTYPEPAIEMENT 
                                                      AND REGLEMENT_PROF.IDANNEESCOLAIRE =" . $colname_rq_anne . " 
                                                      ORDER BY IDREGLEMENT DESC");
    $rs_paiements = $query_rq_historique_paiement->fetchAll();

    $query_rq_individu = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, MATRICULE, NOM, PRENOMS, DATNAISSANCE, ADRES, TELMOBILE, TELDOM, COURRIEL, LOGIN, MP, CODE, 
                                                BIOGRAPHIE, PHOTO_FACE, INDIVIDU.IDETABLISSEMENT, IDTYPEINDIVIDU, SEXE, IDTUTEUR, LIEN_PARENTE, ANNEEBAC, NATIONNALITE, 
                                                SIT_MATRIMONIAL, NUMID, IDSECTEUR, LIEU_TRAVAIL, PATHOLOGIE, ALLERGIE, MEDECIN_TRAITANT, FICHE_RECTO, FICHE_VERSO, 
                                                DIPLOMES, DISCIPLINE, ANNEE, DATE_ARRIVE_CEMAD, FILIERE_ENSEIGNE, ID_NIVEAU, DUREE_ENSEIGNEMENT, ENGAGEMENT, 
                                                RAISON_ENGAGEMENT, FK_FORFAIT, FORFAIT_PROFESSEUR.MONTANT as MONTANTF, FORFAIT_PROFESSEUR.LIBELLE as libelleF, TYPES
                                                FROM INDIVIDU
                                                INNER JOIN RECRUTE_PROF ON RECRUTE_PROF.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                                LEFT JOIN FORFAIT_PROFESSEUR ON FORFAIT_PROFESSEUR.ROWID = RECRUTE_PROF.FK_FORFAIT
                                                WHERE INDIVIDU.IDINDIVIDU = " . $colname_rq_individu);
    $row_rq_individu = $query_rq_individu->fetchObject();

    $query_rq_tot_encaisse = $dbh->query("SELECT SUM(REGLEMENT_PROF.MONTANT) as tot_encasisse FROM REGLEMENT_PROF WHERE INDIVIDU = " . $colname_rq_individu);
    $row_rq_tot_encaisse = $query_rq_tot_encaisse->fetchObject();

    $query_rq_paiement = $dbh->query("SELECT * FROM TYPE_PAIEMENT  WHERE id_type_paiment not in (4)");
    $rs_paiement = $query_rq_paiement->fetchAll();

    $query_an = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT 
                                        FROM ANNEESSCOLAIRE WHERE IDANNEESSCOLAIRE = " . $colname_rq_anne);
    $row_rq_an = $query_an->fetchObject();

    $date_debut = $row_rq_an->DATE_DEBUT;
    $date_fin = $row_rq_an->DATE_FIN;
    $libanne=$row_rq_an->LIBELLE_ANNEESSOCLAIRE;

    $query_type_banque = $dbh->query("SELECT ROWID,LABEL FROM BANQUE WHERE ETAT = 1");
    $rs_banque = $query_type_banque->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
{
    $mois = $lib->securite_xss($_POST['MOIS']);
    $mnt = $lib->securite_xss($_POST['MONTANT']);

    $colname_rq_mensualite = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_mensualite = intval($_SESSION['etab']);
    }

    $numero = $lib->securite_xss($_POST['numero']) != '' ? $lib->securite_xss($_POST['numero']) : " ";
    $idtype = $lib->securite_xss($_POST['id_type_banque']) != '' ? $lib->securite_xss($_POST['id_type_banque']) : " ";

    $insertSQL = $dbh->prepare("INSERT INTO REGLEMENT_PROF(DATE_REGLEMENT, MOIS, MONTANT, MONTANT_VERSE, INDIVIDU, MOTIF, IDTYPEPAIEMENT, IDANNEESCOLAIRE, NUM_CHEQUE, FK_BANQUE,IDETABLISSEMENT) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $Result1 = $insertSQL->execute(array($lib->securite_xss($_POST['DATE_REGLEMENT']),
                                        $mois, $lib->securite_xss($_POST['MONTANT']),
                                        $mnt,
                                        $colname_rq_individu,
                                        $lib->securite_xss($_POST['MOTIF']),
                                        $lib->securite_xss($_POST['paiement']),
                                        $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']),
                                        $numero, $idtype, $colname_rq_mensualite));

    if($Result1)
    {
        $mois = $lib->securite_xss($_POST['MOIS']);
        $prof = $lib->securite_xss($_POST['IDINDIVIDU']);
        ob_start();
        include('factureProf.php');
        $content = ob_get_clean();
        require_once('../../ged/html2pdf/html2pdf.class.php');
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
            $html2pdf->setDefaultFont('Times', 8);
            $html2pdf->writeHTML($content);
            $html2pdf->Output('factureProf.pdf', 'D');
        }
        catch (HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
        $res=1;
        $msg="Paiement ajouté avec succes";
    }
    else
    {
       $res=-1;
       $msg="Votre paiement a échoué";
    }
    header("Location:fichePaiementProf.php?IDIV=". base64_encode($colname_rq_individu)."&msg=$msg&res=$res");
}
?>
<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TRESORERIE</a></li>
    <li>Paiement Professeur</li>
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
                        <i class="fa fa-plus"></i> Nouveau paiement
                    </button>


                </div>

            </div>

            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if(isset($_GET['res']) && $_GET['res'] == 1) { ?>

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


                <fieldset class="cadre">
                    <legend> Informations personnelles</legend>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="col-lg-4"><label class="control-label">MATRICULE : </label></div>
                            <div class="col-lg-8"><?php echo $row_rq_individu->MATRICULE; ?></div>
                        </div>

                        <div class="col-lg-3">
                            <div class="col-lg-4"><label class="control-label">PRENOMS : </label></div>
                            <div class="col-lg-8"><?php echo $row_rq_individu->PRENOMS; ?></div>
                        </div>

                        <div class="col-lg-3">
                            <div class="col-lg-4"><label class="control-label">NOM : </label></div>
                            <div class="col-lg-8"> <?php echo $row_rq_individu->NOM; ?></div>
                        </div>

                        <div class="col-lg-3">
                            <div class="col-lg-4"><label class="control-label">TEL MOBILE : </label></div>
                            <div class="col-lg-8"> <?php echo $row_rq_individu->TELMOBILE; ?></div>
                        </div>
                    </div>

                    <br>


                </fieldset>

                <table id="customers2" class="table datatable">

                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Classe</th>
                            <th>Matiéres</th>

                           <?php if($row_rq_individu->FK_FORFAIT!=0){ ?>
                                 <th>Forfait
                                 <input type="hidden" id="forfait" value="<?php echo $row_rq_individu->FK_FORFAIT; ?>">
                                 </th>
                            <?php }else{ ?>

                               <th>Nb.heures totales</th>

                          <?php } ?>
                            <th>Nb.heures dispensées</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php


                    $total_payer = 0;

                    foreach ($rs_module as $row_rq_module) {

                                $colindividu_rq_montant = $row_rq_individu->IDINDIVIDU;
                                $colmatiere_rq_montant = $row_rq_module['IDMATIERE'];
                                $colmois = $row_rq_module['MOISDISP'];

                                $query_rq_montant = $dbh->query("SELECT DISPENSER_COURS.HEUREDEBUTCOURS, DISPENSER_COURS.HEUREFINCOURS 
                                                                           FROM DISPENSER_COURS 
                                                                           WHERE  DISPENSER_COURS.IDINDIVIDU=" . $colindividu_rq_montant . "  
                                                                           AND DISPENSER_COURS.IDMATIERE=" . $colmatiere_rq_montant ." 
                                                                           AND DISPENSER_COURS.MOIS='" .$colmois."'");

                                $temp_heure = 0;
                                foreach ($query_rq_montant->fetchAll() as $row_rq_montant)
                                {
                                    $diffe = round($row_rq_montant['HEUREFINCOURS'] - $row_rq_montant['HEUREDEBUTCOURS'],2);
                                    $temp_heure = $temp_heure + $diffe;
                                }
                                if($row_rq_module['FK_FORFAIT']!=0)
                                {
                                    $montant = $row_rq_module['MONTANTF'];
                                    $montant_brute +=$row_rq_module['MONTANTF'];
                                }
                                else
                                {
                                    $montant = ($temp_heure * $row_rq_module['TARIF_HORAIRE']);
                                    $montant_brute += $temp_heure * $row_rq_module['TARIF_HORAIRE'];
                                }
                         ?>


                        <tr>
                            <td><?php echo $lib->affiche_mois($row_rq_module['MOISDISP']); ?></td>
                            <td><?php echo $row_rq_module['classe']; ?></td>
                            <td><?php echo $row_rq_module['LIBELLE']; ?></td>
                            <?php if($row_rq_module['FK_FORFAIT']!=0) { ?>
                                <td><?php echo $row_rq_module['libelleF']; ?></td>

                            <?php }else{ ?>

                             <td><?php echo $row_rq_module['VOLUME_HORAIRE']; ?></td>

                            <?php } ?>

                            <td><?php echo $temp_heure; ?></td>
                            <td><?php echo $lib->nombre_form($montant); ?></td>
                        </tr>
                        <?php
                        $total_payer = $total_payer + $montant;
                    } ?>

                    </tbody>
                </table>
                <br><br>


                <div class="row">

                    <div class="col-lg-8">

                        <?php if ($query_rq_historique_paiement->rowCount() > 0) { ?>

                            <fieldset class="cadre">
                            <legend class="nomEntrepr">PAIEMENTS</legend>
                                <table width="100%" class="table table-striped table-responsive">

                                    <tr>
                                        <th>Date</th>
                                        <th>Mois</th>
                                        <th>Montant Total</th>
                                        <th>Montant Versé</th>
                                        <th>Motif</th>
                                        <th>Type Paiement</th>
                                        <th>Numero</th>
                                    </tr>

                                    <?php
                                    $total_encaisee = 0;
                                    $montant_restant = 0;

                                    foreach ($rs_paiements as $row_rq_historique_paiement) { ?>

                                        <tr>
                                            <td><?php echo $lib->date_fr($row_rq_historique_paiement['DATE_REGLEMENT']); ?></td>
                                            <td><?php echo $lib->affiche_mois($row_rq_historique_paiement['MOIS']); ?></td>
                                            <td><?php echo $lib->nombre_form($row_rq_historique_paiement['MONTANT']); ?></td>
                                            <td><?php echo $lib->nombre_form($row_rq_historique_paiement['MONTANT_VERSE']); ?></td>
                                            <td><?php echo $row_rq_historique_paiement['MOTIF']; ?></td>
                                            <td><?php echo $row_rq_historique_paiement['libelle_paiement']; ?></td>
                                            <td><?php echo $row_rq_historique_paiement['NUM_CHEQUE']; ?></td>
                                        </tr>

                                        <?php
                                        $total_encaisee += $row_rq_historique_paiement['MONTANT_VERSE'];
                                        $montant_restant = $montant_brute - $total_encaisee;

                                    } ?>

                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>

                                    <tr>
                                        <th>TOTAL ENCAISSE:</th>
                                        <td>&nbsp;</td>
                                        <td><?php echo $lib->nombre_form($total_encaisee); ?></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <th>MONTANT RESTANT:</th>
                                        <td>&nbsp;</td>
                                        <td><?php echo $lib->nombre_form($montant_restant); ?></td>
                                        <td>
                                            <a href="../../ged/imprimer_recu_prof.php?INDIVIDU=<?php echo base64_encode($colname_rq_individu); ?>">
                                                <img src="../../images/bt_imprimer.png" width="99" height="27" />
                                            </a>
                                        </td>
                                    </tr>

                                </table>
                            </fieldset>

                        <?php } ?>

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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog" style="width: 50%">

        <div class="modal-content">

            <div class="panel panel-default">

                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouveau paiement </h3>
                </div>

                <form action="" method="POST" id="form1" name="form1">

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">DATE</label>

                                    <div>
                                        <input type="text" name="DATE_REGLEMENT" id="date_foo" required class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MOIS</label>

                                    <div>
                                        <select name="MOIS" id="MOIS" class="form-control" required onchange="GetMontantTotal();verifMonth();">
                                            <option value="">--- Selectionner le mois ---</option>
                                        <?php

                                        function debug($var){
                                            return $var;
                                        }

                                        $date1 = new DateTime($date_debut);
                                        $date2 = new DateTime($date_fin);

                                        $mois = array();
                                        $mois[] =  $date1->format('m-Y');
                                        while($date1 <= $date2)
                                        {
                                            $date1->add(new DateInterval("P1M"));
                                            $mois[] = $date1->format('m-Y');

                                        } foreach (debug($mois) as $row) { ?>

                                            <option  value="<?php echo $row; ?>"><?php echo $lib->affiche_mois($row); ?></option>

                                        <?php  } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MONTANT TOTAL</label>

                                    <div>
                                        <input type="number" name="MONTANT" id="MONTANT" required class="form-control" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">MOTIF</label>
                                    <div>
                                        <input type="text" name="MOTIF" id="MOTIF" required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="">TYPE PAIEMENT</label>
                                    <div>
                                        <select required name="paiement" id="paiement" onchange="Paiement();">
                                            <option value="" selected="selected" disabled="disabled">--Selectionnez--
                                            </option>
                                            <?php foreach ($rs_paiement as $row_rq_paiement) { ?>
                                                <option
                                                    value="<?php echo $row_rq_paiement['id_type_paiment'] ?>"><?php echo $row_rq_paiement['libelle_paiement'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12" id="lotTypePayement" style="display: none">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" id="titre_id_type_banque"></label>
                                        <div>
                                            <input type="text" class="form-control" name="numero" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="id_type_banque" class="control-label">BANQUE</label>
                                        <div>
                                    <select name="id_type_banque" id="id_type_banque" required class="form-control">
                                        <option value="" disabled="disabled" selected="selected">choisir la banque</option>
                                        <?php foreach ($rs_banque as $row_type_banque) { ?>
                                            <option value="<?php echo $row_type_banque['ROWID']; ?>"><?php echo $row_type_banque['LABEL']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                </div>
                            </div>
                            </div>

                        </div>

                    </div>

                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDREGLEMENT" value=""/>
                        <input type="hidden" name="IDINDIVIDU" id="IDINDIVIDU" value="<?php echo $colindividu_rq_montant;?>"/>
                        <input type="hidden" name="MATIERE" id="MATIERE" value="<?php echo $colmatiere_rq_montant;?>"/>
                        <input type="hidden" name="MM_insert" value="form1"/>
                        <button type="submit" class="btn btn-primary pull-right" id="validerR">Valider</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



    <script>

        function TypePaiement()
        {
            if(document.getElementById("radio2").checked){
                document.getElementById("paiementPartiel").style.visibility = 'visible';
                document.getElementById("paiementPartiel").style.display = 'block';
            }
            else{
                document.getElementById("paiementPartiel").style.visibility = 'hidden';
                document.getElementById("paiementPartiel").style.display = 'none';
            }
        }

        function Paiement()
        {
            var selectedPay = $("#paiement").find("option:selected").val();
            if(selectedPay != 2){
                if(selectedPay == 1){
                    $('#titre_id_type_banque').text("NUMERO CHEQUE");
                }else{
                    $('#titre_id_type_banque').text("NUMERO VIREMENT");
                }
                $('#lotTypePayement').css('display', 'block');
            }
            else
            {
                $('#lotTypePayement').css('display', 'none');
                $('#id_type_banque').prop('selectedIndex',0);
            }
        }

        function calculReliquat()
        {
            var $mnt=$("#MONTANT").val();
            var $mntverse=$("#MONTANT_VERSE").val();
            document.getElementById("RELIQUAT").value=$mnt - $mntverse;
        }

        function GetMontantTotal()
        {
            var $mois=$("#MOIS").val();
            $.ajax({
                type: "POST",
                url: "getMontantTotal.php",
                data: "MOIS=" + $mois+"_"+$('#IDINDIVIDU').val()+"_"+$('#MATIERE').val(),
                success: function (data) {
                    data = JSON.parse(data);
                    document.getElementById("MONTANT").value=data;
                    if(data==0){
                        document.getElementById("validerR").disabled = true;
                    }else{
                        document.getElementById("validerR").disabled = false;
                    }
                }
            });
        }

        function verifMonth()
        {
            var $mois = $("#MOIS").val();
            $.ajax({
                type: "POST",
                url: "verifMonth.php",
                data: "MOIS=" + $mois+"_"+$('#IDINDIVIDU').val(),
                success: function (data)
                {
                    data = JSON.parse(data);
                    if(data == 1)
                    {
                        alert('Ce mois est déjà payé au professeur !!');
                        document.getElementById("validerR").disabled = true;
                    }
                    else
                    {
                        document.getElementById("validerR").disabled = false;
                    }
                }
            });
        }

    </script>

<?php include('footer.php'); ?>