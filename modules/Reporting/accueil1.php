
<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1)
$lib->Restreindre($lib->Est_autoriser(47, $lib->securite_xss($_SESSION['profil'])));

$etab = "-1";
if(isset($_SESSION['etab']))
{
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$annescolaire = "-1";
if(isset($_SESSION['ANNEESSCOLAIRE']))
{
    $annescolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $title2="NOMBRE DE CANDIDAT POUR L’EXAMEN/GENRE";
    $title3="NOMBRE DE CANDIDAT POUR L’EXAMEN PAR SERIE";
    $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $etab);
    $rs_niv = $query_rq_niv->fetchAll();

    $query_rq_niveauClasse = $dbh->query("SELECT ID, LIBELLE
                                               FROM NIV_CLASSE 
                                               WHERE IDETABLISSEMENT = " . $etab);
    $query_rq3 = $dbh->query("SELECT SERIE.IDSERIE, SERIE.LIBSERIE FROM SERIE 
                            INNER JOIN CLASSROOM ON CLASSROOM.IDSERIE=SERIE.IDSERIE
                            WHERE CLASSROOM.IDNIV = 16
                            AND CLASSROOM.EXAMEN = 1");
    $rsNbreSerie=$query_rq3->fetchAll();


         if(isset($_POST['form1']) && $_POST['form1'] === 'Ms_form')
         {
                         $nivclass=$lib->securite_xss($_POST['nivclasse']);
                         $periode=$lib->securite_xss($_POST['periode']);
                         $query = $dbh->query("SELECT ID, LIBELLE FROM NIV_CLASSE WHERE ID = ".$nivclass);
                         $rs_niv2 = $query->fetchObject();
                         $libnivclass = $rs_niv2->LIBELLE;
                         $title = "MEUILLEUR NOTE PAR MATIERE POUR LE NIVEAU : ".$libnivclass;

                         if($periode == 4 || $periode == 5 )
                         {
                                $query_rq_note_matiere = $dbh->query("SELECT MAX(DETAIL_BULLETIN.MOYENNE_SEM) as notes, MATIERE.LIBELLE
                                                                               FROM DETAIL_BULLETIN 
                                                                               INNER JOIN BULLETIN ON DETAIL_BULLETIN.FK_BULLETIN = BULLETIN.ROWID
                                                                               INNER JOIN MATIERE ON MATIERE.IDMATIERE = DETAIL_BULLETIN.MATIERE
                                                                               INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = BULLETIN.IDCLASSROOM
                                                                               WHERE CLASSROOM.IDNIV = " . $nivclass . " 
                                                                               AND BULLETIN.IDETABLISSEMENT =" . $etab . "  
                                                                               AND BULLETIN.IDANNEE = " . $annescolaire . "
                                                                               AND BULLETIN.IDPERIODE = " . $periode . "
                                                                               GROUP BY  MATIERE.IDMATIERE");
                         }
                         elseif ($periode == 1)
                         {
                                $query_rq_note_matiere = $dbh->query("SELECT MAX(DETAIL_BULLETIN.COMPO1) as notes, MATIERE.LIBELLE
                                                                                FROM DETAIL_BULLETIN 
                                                                                INNER JOIN BULLETIN ON DETAIL_BULLETIN.FK_BULLETIN = BULLETIN.ROWID
                                                                                INNER JOIN MATIERE ON MATIERE.IDMATIERE = DETAIL_BULLETIN.MATIERE
                                                                                INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = BULLETIN.IDCLASSROOM
                                                                                WHERE CLASSROOM.IDNIV = " . $nivclass . " 
                                                                                AND BULLETIN.IDETABLISSEMENT =" . $etab . "  
                                                                                AND BULLETIN.IDANNEE = " . $annescolaire . "
                                                                                AND BULLETIN.IDPERIODE = " . $periode . "
                                                                                GROUP BY  MATIERE.IDMATIERE");
                         }
                         elseif ($periode == 2)
                         {
                             $query_rq_note_matiere = $dbh->query("SELECT MAX(DETAIL_BULLETIN.COMPO2) as notes, MATIERE.LIBELLE
                                                                              FROM DETAIL_BULLETIN 
                                                                              INNER JOIN BULLETIN ON DETAIL_BULLETIN.FK_BULLETIN = BULLETIN.ROWID
                                                                              INNER JOIN MATIERE ON MATIERE.IDMATIERE = DETAIL_BULLETIN.MATIERE
                                                                              INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = BULLETIN.IDCLASSROOM
                                                                              WHERE CLASSROOM.IDNIV = " . $nivclass . " 
                                                                              AND BULLETIN.IDETABLISSEMENT =" . $etab . "  
                                                                              AND BULLETIN.IDANNEE = " . $annescolaire . "
                                                                              AND BULLETIN.IDPERIODE = " . $periode . "
                                                                              GROUP BY  MATIERE.IDMATIERE");
                         }
                         elseif($periode == 3)
                         {
                                 $query_rq_note_matiere = $dbh->query("SELECT MAX(DETAIL_BULLETIN.COMPO3) as notes, MATIERE.LIBELLE
                                                                                 FROM DETAIL_BULLETIN 
                                                                                 INNER JOIN BULLETIN ON DETAIL_BULLETIN.FK_BULLETIN = BULLETIN.ROWID
                                                                                 INNER JOIN MATIERE ON MATIERE.IDMATIERE = DETAIL_BULLETIN.MATIERE
                                                                                 INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = BULLETIN.IDCLASSROOM
                                                                                 WHERE CLASSROOM.IDNIV = " . $nivclass . " 
                                                                                 AND BULLETIN.IDETABLISSEMENT =" . $etab . "  
                                                                                 AND BULLETIN.IDANNEE = " . $annescolaire . "
                                                                                 AND BULLETIN.IDPERIODE = " . $periode . "
                                                                                 GROUP BY  MATIERE.IDMATIERE");
                         }

                         $cycle = $lib->securite_xss($_POST['IDNIVEAU']);

                         $query_rq = $dbh->query("SELECT DISTINCT(NIV_CLASSE.ID), NIV_CLASSE.LIBELLE 
                                                            FROM NIV_CLASSE 
                                                            INNER JOIN CLASSROOM ON CLASSROOM.IDNIV = NIV_CLASSE.ID
                                                            WHERE NIV_CLASSE.IDNIVEAU = ".$cycle."
                                                            AND CLASSROOM.EXAMEN = 1");
                         $rsNbreClasse=$query_rq->fetchAll();
         }
}
catch (PDOException $e)
{
    echo -2;
}
?>
<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Reporting</a></li>                    
                    <li></li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1) { ?>

                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php } ?>

                    <?php } ?>

                    <!-- START WIDGETS -->

                    <div class="row">

                        <div class="col-lg-12">

                            <fieldset class="cadre"><legend><?php echo $title; ?></legend>
                                <br/>


                                <form id="form" method="POST" action="accueil1.php" class="form-inline">

                                    <div  class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                        <div class="col-lg-9 col-sm-8">
                                            <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" data-live-search="true"  onchange="choixNiveClasse();choixPeriode();"  style="width: 100%;!important;">
                                                <option value="">--Selectionner--</option>
                                                <?php foreach ($rs_niv as $row_rq_niv) { ?>
                                                    <option value=" <?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">NIVEAU </label>
                                        <div class="col-lg-9  col-sm-8">
                                            <select name="nivclasse" id="nivclasse" class="form-control"  style="width: 100%;!important;"  >
                                                <option value="">--Selectionner--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">PERIODE </label>
                                        <div class="col-lg-9  col-sm-8">
                                            <select name="periode" id="periode" class="form-control"  style="width: 100%;!important;"  onchange="buttonControl();" >
                                                <option value="">--Selectionner--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <input name="form1" value="Ms_form" type="hidden"/>
                                        <button type="submit" class="btn btn-primary " id="validerAj" title="Rechercher" style="display: none;">Rechercher</button>
                                    </div>

                                </form>

                        <?php if(isset($_POST['form1']) && $_POST['form1'] === 'Ms_form') {
                            if(count($query_rq_note_matiere)>0){
                                ?>
                                <br><br>
                                <br>
                                <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">
                                    <tr>
                                        <th>MATIERES</th>
                                        <th>MEILLEURS NOTES</th>
                                    </tr>
                                    <?php

                                    foreach($query_rq_note_matiere->fetchAll() as $row_rq_note_matiere) {  ?>
                                        <tr>
                                            <td ><?php echo htmlentities($row_rq_note_matiere['LIBELLE']); ?></td>
                                            <td ><?php echo $row_rq_note_matiere['notes']; ?></td>
                                        </tr>
                                        <?php

                                    }  ?>


                                </table>

                        <?php   }
                        }
                        ?>



                            </fieldset>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-lg-6">

                            <fieldset class="cadre"><legend><?php echo $title2; ?></legend>

                                <?php if(isset($_POST['form1']) && $_POST['form1'] === 'Ms_form') {?>

                                 <?php
                                 foreach($rsNbreClasse as $rs_NbreClasse) {
                                     $query_rq_nbre= $dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, INDIVIDU.SEXE AS SEXE FROM INDIVIDU
                                    INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                    INNER JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                    INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = AFFECTATION_ELEVE_CLASSE.IDCLASSROOM
                                    WHERE INDIVIDU.IDETABLISSEMENT = ".$etab."
                                    AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire."
                                    AND CLASSROOM.EXAMEN =1
                                    AND CLASSROOM.IDNIV = ".$rs_NbreClasse['ID']."
                                    GROUP BY SEXE");

                                    $rs_nb=$query_rq_nbre->fetchAll();
                                   ?>
                                    <br>
                                    <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">
                                        <tr>
                                            <th colspan="2" style="text-align: center!important;font-size: 18px;">NIVEAU : <?php echo $rs_NbreClasse['LIBELLE'];?></th>
                                        </tr>
                                     <?php $tot=0;
                                     foreach($rs_nb as $rs_Nb) {?>
                                        <tr>

                                            <th>NOMBRE DE <?php if ($rs_Nb['SEXE']==0) echo"FILLES"; else echo "GARCONS";?> </th>
                                            <td><?php echo $rs_Nb['nbr'];?> </td>
                                        </tr>
                                         <?php $tot +=$rs_Nb['nbr'];
                                     } ?>
                                        <tr>

                                            <th>NOMBRE TOTAL</th>
                                            <td><?php echo $tot;?></td>
                                        </tr>
                                    </table>

                                            <?php
                                            }
                                        ?>




                                <?php   } ?>

                            </fieldset>
                        </div>

                        <div class="col-lg-6">

                            <fieldset class="cadre"><legend><?php echo $title3; ?></legend>
                                 <?php
                                 foreach($rsNbreSerie as $rs_NbreSerie) {
                                    $query_rq_nbre_serie= $dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, INDIVIDU.SEXE AS SEXE FROM INDIVIDU
                                    INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                    INNER JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                                    INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = AFFECTATION_ELEVE_CLASSE.IDCLASSROOM
                                    INNER JOIN SERIE ON SERIE.IDSERIE = CLASSROOM.IDSERIE
                                    WHERE INDIVIDU.IDETABLISSEMENT = ".$etab."
                                    AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire."
                                    AND CLASSROOM.EXAMEN =1
                                    AND SERIE.IDSERIE =".$rs_NbreSerie['IDSERIE']."
                                    AND CLASSROOM.IDNIV = 16
                                    GROUP BY SEXE");
                                    $rs_nb_serie=$query_rq_nbre_serie->fetchAll();
                                ?>
                                        <br>
                                        <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">
                                            <tr>
                                                <th colspan="2" style="text-align: center!important;font-size: 18px;">SERIE : <?php echo $rs_NbreSerie['LIBSERIE'];?></th>
                                            </tr>
                                            <?php $tot=0;
                                            foreach($rs_nb_serie as $rs_Nb_serie) {?>
                                                <tr>

                                                    <th>NOMBRE DE <?php if ($rs_Nb_serie['SEXE']==0) echo"FILLES"; else echo "GARCONS";?> </th>
                                                    <td><?php echo $rs_Nb_serie['nbr'];?> </td>
                                                </tr>
                                                <?php $tot +=$rs_Nb_serie['nbr'];
                                            } ?>
                                            <tr>

                                                <th>NOMBRE TOTAL</th>
                                                <td><?php echo $tot;?></td>
                                            </tr>
                                        </table>



                                     <?php
                                 }
                                 ?>




                            </fieldset>
                        </div>

                    </div>

                </div>


<?php include('footer.php'); ?>


<!------------- hightchart-->
<script>

    function choixNiveClasse() {
        var valSel = $("#selectNiv").val();
        $.ajax({
            type: "POST",
            url: "getNiveClasse.php",
            data: "NIVEAU=" + valSel,
            success: function (data) {
                data = JSON.parse(data);
                $("#nivclasse").html('<option selected="selected" value="">--Selectionner--</option>');
                $.each(data, function (cle, valeur) {
                    $("#nivclasse").append('<option value="' + valeur.ID + '">' + valeur.LIBELLE + '</option>');
                });
            }
        });
    }

    function choixPeriode() {
        var valSel = $("#selectNiv").val();
        $.ajax({
            type: "POST",
            url: "getPeriode.php",
            data: "NIVEAU=" + valSel,
            success: function (data) {
                data = JSON.parse(data);
                $("#periode").html('<option selected="selected" value="">--Selectionner--</option>');
                $.each(data, function (cle, valeur) {
                    $("#periode").append('<option value="' + valeur.IDPERIODE + '">' + valeur.NOM_PERIODE + '</option>');
                });
            }
        });
    }

    function buttonControl() {
        if(document.getElementById("periode").value!=""){
            $('#validerAj').css("display","block");
        }else{
            $('#validerAj').css("display","none");
        }
    }

</script>



		
        