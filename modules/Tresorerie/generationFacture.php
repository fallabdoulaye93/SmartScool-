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
    $lib->Restreindre($lib->Est_autoriser(25, $lib->securite_xss($_SESSION['profil'])));
$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_classe = $lib->securite_xss($_SESSION['etab']);
}
$query_rq_classe = $dbh->query("SELECT IDCLASSROOM, LIBELLE, IDNIVEAU, IDETABLISSEMENT, IDSERIE 
                                          FROM CLASSROOM WHERE IDETABLISSEMENT = " . $colname_rq_classe);

$query_rq_an = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT 
                                      FROM ANNEESSCOLAIRE 
                                      WHERE  IDETABLISSEMENT = " . $colname_rq_classe ." 
                                      AND IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
$row_rq_an = $query_rq_an->fetchObject();
$date_debut = $row_rq_an->DATE_DEBUT;
$date_fin = $row_rq_an->DATE_FIN;
$libanne=$row_rq_an->LIBELLE_ANNEESSOCLAIRE;


$query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $colname_rq_classe);
$rs_niv = $query_rq_niv->fetchAll();

if (isset($_POST['envoyer']) && $_POST['envoyer'] != "" && $_POST['MOIS'] != "" && $_POST['Classe'] != "")
{
    $res = "-1";
    $msg = "Generation des factures du mois echoué&";
    $colname_rq_inscription = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_inscription = $lib->securite_xss($_SESSION['etab']);
    }

    $mois = $lib->securite_xss($_POST['MOIS']);

    $colname_rq_individu.= " AND A.IDCLASSROOM='".$lib->securite_xss($_POST['Classe'])."'";
    $inner.="";
    if(isset($_POST['MATRICULE']) && $lib->securite_xss($_POST['MATRICULE'])!="")
    {
        $inner.=" INNER JOIN INDIVIDU IND ON IND.IDINDIVIDU = I.IDINDIVIDU";
        $matricule=$lib->securite_xss($_POST['MATRICULE']);
        $colname_rq_individu.=" AND IND.MATRICULE ='".$lib->securite_xss($_POST['MATRICULE'])."'";
    }
    $sql = "SELECT DISTINCT I.IDINSCRIPTION, DATEINSCRIPT, FRAIS_INSCRIPTION, MONTANT, ACCOMPTE_VERSE, STATUT, IDNIVEAU, I.IDINDIVIDU, I.IDETABLISSEMENT, I.IDANNEESSCOLAIRE, IDSERIE, DERNIER_ETAB, VALIDETUDE, 
            FRAIS_DOSSIER, FRAIS_EXAMEN, UNIFORME, VACCINATION, ASSURANCE, FRAIS_SOUTENANCE, TRANSPORT, MONTANT_TRANSPORT, MONTANT_DOSSIER, MONTANT_EXAMEN, MONTANT_UNIFORME, MONTANT_VACCINATION, 
            MONTANT_ASSURANCE, MONTANT_SOUTENANCE, RESULTAT_ANNUEL, ACCORD_MENSUELITE, NBRE_EXONORE, MOIS_EXONORE.MOIS as moisexo 
            FROM INSCRIPTION I
            INNER JOIN AFFECTATION_ELEVE_CLASSE A ON A.IDINDIVIDU = I.IDINDIVIDU 
            LEFT JOIN MOIS_EXONORE ON MOIS_EXONORE.IDINSCRIPTION = I.IDINSCRIPTION  ".$inner."
            WHERE I.IDETABLISSEMENT = " . $colname_rq_inscription ." 
            AND I.IDANNEESSCOLAIRE= " . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']) . "
            AND I.ETAT=1 ".$colname_rq_individu."  ";

    $query_rq_inscription = $dbh->query($sql);


    $query_fact=$dbh->query("SELECT IDFACTURE, NUMFACTURE, MOIS, FACTURE.MONTANT, DATEREGLMT, FACTURE.IDINSCRIPTION, FACTURE.IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, FACTURE.ETAT 
                            FROM FACTURE 
                            INNER JOIN INSCRIPTION I ON I.IDINSCRIPTION = FACTURE.IDINSCRIPTION
                            INNER JOIN AFFECTATION_ELEVE_CLASSE A ON A.IDINDIVIDU = I.IDINDIVIDU ".$inner."
                            WHERE FACTURE.MOIS='".$mois."' 
                            AND FACTURE.AVANCE=0  
                            ".$colname_rq_individu."
                            AND I.IDETABLISSEMENT = " . $colname_rq_inscription . " 
                            AND I.IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));








    /*$query_rq_inscription = $dbh->query("SELECT INSCRIPTION.IDINSCRIPTION, `DATEINSCRIPT`, `FRAIS_INSCRIPTION`, `MONTANT`, `ACCOMPTE_VERSE`, `STATUT`, `IDNIVEAU`, INSCRIPTION.IDINDIVIDU, INSCRIPTION.IDETABLISSEMENT, INSCRIPTION.IDANNEESSCOLAIRE, `IDSERIE`, `DERNIER_ETAB`, `VALIDETUDE`, `FRAIS_DOSSIER`, `FRAIS_EXAMEN`, `UNIFORME`, `VACCINATION`, `ASSURANCE`, `FRAIS_SOUTENANCE`, `TRANSPORT`, `MONTANT_TRANSPORT`, `MONTANT_DOSSIER`,
                                                          MONTANT_EXAMEN, MONTANT_UNIFORME, MONTANT_VACCINATION, MONTANT_ASSURANCE, `MONTANT_SOUTENANCE`, `RESULTAT_ANNUEL`, `ACCORD_MENSUELITE`, `NBRE_EXONORE`, MOIS_EXONORE.MOIS as moisexo 
                                                          FROM INSCRIPTION  
                                                          INNER JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INSCRIPTION.IDINDIVIDU 
                                                          LEFT JOIN MOIS_EXONORE ON MOIS_EXONORE.IDINSCRIPTION=INSCRIPTION.IDINSCRIPTION 
                                                          where INSCRIPTION.IDETABLISSEMENT = " . $colname_rq_inscription . " 
                                                          AND INSCRIPTION.IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']) ."
                                                          AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$lib->securite_xss($_POST['Classe'])." 
                                                          AND INSCRIPTION.ETAT=1");
    $mois = $lib->securite_xss($_POST['MOIS']);
    $query_fact=$dbh->query("SELECT `IDFACTURE`, `NUMFACTURE`, `MOIS`, FACTURE.MONTANT, `DATEREGLMT`, FACTURE.IDINSCRIPTION, FACTURE.IDETABLISSEMENT, `MT_VERSE`, `MT_RELIQUAT`, FACTURE.ETAT FROM `FACTURE` 
                            INNER JOIN INSCRIPTION ON INSCRIPTION.IDINSCRIPTION=FACTURE.IDINSCRIPTION
                            INNER  JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INSCRIPTION.IDINDIVIDU 
                            WHERE FACTURE.MOIS='".$mois."' 
                            AND FACTURE.AVANCE=0  
                            AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$lib->securite_xss($_POST['Classe'])."
                            AND INSCRIPTION.IDETABLISSEMENT = " . $colname_rq_inscription . " 
                            AND INSCRIPTION.IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));*/

    if($query_fact->rowCount() > 0)
    {
        $res = "-1";
        $msg = "Factures de ce mois déja générées pour cette classe ";
    }
    else
    {
        if($query_rq_inscription->rowCount() > 0)
        {
            foreach ($query_rq_inscription->fetchAll() as $row_rq_inscription)
            {
               if ($row_rq_inscription['NBRE_EXONORE']>0 && $row_rq_inscription['moisexo']==$mois) $mnt=0; else $mnt=$row_rq_inscription['ACCORD_MENSUELITE'];
               $lib->Generer_facture($mois, $mnt, $row_rq_inscription['IDINSCRIPTION'], $lib->securite_xss($_SESSION['etab']), $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
            }
            $mois = $lib->securite_xss($_POST['MOIS']);
            $classe = $lib->securite_xss($_POST['Classe']);

            if(isset($_POST['MATRICULE']) && $lib->securite_xss($_POST['MATRICULE'])!=""){
                $matricule = $lib->securite_xss($_POST['MATRICULE']);
            }


                ob_start();
                include('factureClasse.php');
                $content = ob_get_clean();
                require_once('../../ged/html2pdf/html2pdf.class.php');
                try
                {
                    $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
                    $html2pdf->setDefaultFont('Times', 8);
                    $html2pdf->writeHTML($content);
                    $html2pdf->Output('factureClasse.pdf', 'D');
                }
                catch (HTML2PDF_exception $e)
                {
                    echo $e;
                    exit;
                }
            $res = 1;
            $msg = "Vos factures du mois ont été générées avec succès";
        }
    }
    header('Location: generationFacture.php?res=' . $res . '&msg=' . $msg);
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

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?></div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) {?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->affichage_xss($_GET['msg']); ?>
                        </div>

                    <?php }
                } ?>

                <form id="form1" name="form1" method="post" action="">
                    <fieldset class="cadre">
                        <legend> G&eacute;n&eacute;ration facture par classe</legend>
                        <div class="row" onmouseout=" $('#MOIS').removeAttr('required'); $('#Classe').removeAttr('required');">
                            <div class="col-lg-12">
                                <div class="col-lg-3">
                                    <div class="col-lg-3"><label class="control-label">MOIS</label></div>
                                    <div class="col-lg-9">
                                        <?php
                                        function debug($var){

                                            return $var;

                                        }?>
                                        <select name="MOIS" id="MOIS" class="form-control" onchange="buttonControl();">
                                            <option value="">Mois</option>
                                          <?php
                                        $date1 = new DateTime($date_debut);
                                        $date2 = new DateTime($date_fin);
                                        $mois = array();
                                        $mois[] =  $date1->format('m-Y');
                                        while($date1 <= $date2){
                                            $date1->add(new DateInterval("P1M"));
                                            $mois[] = $date1->format('m-Y');

                                        }
                                        foreach (debug($mois) as $row) { ?>

                                            <option
                                                    value="<?php echo $row; ?>"><?php echo $lib->affiche_mois($row); ?>
                                            </option>


                                        <?php }  ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                        <div class="col-lg-9 col-sm-8">
                                            <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" data-live-search="true"  onchange="choixClasse(this);"  style="width: 100%;!important;">
                                                <option value="">--Selectionner--</option>
                                                <?php  foreach ($rs_niv as $row_rq_niv) { ?>

                                                    <option value=" <?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="col-lg-3"><label>CLASSE</label></div>
                                        <div class="col-lg-9">
                                            <select  name="Classe" id="Classe" class="form-control" onchange="buttonControl();" data-live-search="true">
                                                <option value="">--Selectionner--</option>

                                            </select>
                                            <label id="Classe-error" class="error hidden" for="Classe" style="display: inline-block;">This field is required.</label>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label">MATRICULE&nbsp;&nbsp;</label>
                                    <div class="col-lg-9  col-sm-8">
                                        <input type="text" name="MATRICULE" id="MATRICULE"  class="form-control" style="margin-left: 10px;" />
                                    </div>
                                </div>








                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div onmouseover="$('#MOIS').attr('required','required');$('#Classe').attr('required','required');"">
                                            <input type="submit" class="btn btn-success" name="envoyer" value="Valider" id="validerAj" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>



                    </fieldset>
                </form>
                <br><br>

        </div>
    </div>
    <!-- END WIDGETS -->
</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


    <script>
        function choixClasse(elem)
        {
            var valSel = elem.value;
            $.ajax({
                type: "POST",
                url: "getClasseNive.php",
                data: "NIVEAU=" + valSel,
                success: function (data) {
                    data = JSON.parse(data);
                    $("#Classe").html('<option selected="selected" value="">--Selectionner--</option>');
                    $.each(data, function (cle, valeur) {
                        $("#Classe").append('<option value="' + valeur.IDCLASSROOM + '">' + valeur.LIBELLE + '</option>');
                    });
                }
            });
        }

        function buttonControl()
        {
            if(document.getElementById("MOIS").value!="" && document.getElementById("Classe").value!="")
            {
                $('#validerAj').css("display","block");
            }
            else
            {
                $('#validerAj').css("display","none");
            }
        }
    </script>
<?php include('footer.php'); ?>