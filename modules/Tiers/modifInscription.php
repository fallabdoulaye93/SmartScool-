
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
$lib->Restreindre($lib->Est_autoriser(36,$lib->securite_xss($_SESSION['profil'])));


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

// idInscription=1249&IDSERIE=49&IDNIVEAU=2&IDINDIVIDU=11096

$IDINDIVIDU="";
if(isset($_GET['IDINDIVIDU'])&& $_GET['IDINDIVIDU']!="")
{
    $IDINDIVIDU= $lib->securite_xss(base64_decode($_GET['IDINDIVIDU']) );
}

$idInscription="";
if(isset($_GET['idInscription'])&& $_GET['idInscription']!="")
{
    $idInscription= $lib->securite_xss(base64_decode($_GET['idInscription']) );
}

$IDSERIE="";
if(isset($_GET['IDSERIE'])&& $_GET['IDSERIE']!="")
{
    $IDSERIE= $lib->securite_xss(base64_decode($_GET['IDSERIE']) );
}

$IDNIVEAU="";
if(isset($_GET['IDNIVEAU'])&& $_GET['IDNIVEAU']!="")
{
    $IDNIVEAU= $lib->securite_xss(base64_decode($_GET['IDNIVEAU']) );
}


$query_rq_etudiant = $dbh->query("SELECT INDIVIDU.*, INSCRIPTION.*,AFFECTATION_ELEVE_CLASSE.* 
                                            from INDIVIDU, INSCRIPTION, AFFECTATION_ELEVE_CLASSE 
                                            WHERE INSCRIPTION.IDINSCRIPTION = $idInscription 
                                            AND INDIVIDU.IDINDIVIDU = INSCRIPTION.IDINDIVIDU 
                                            AND INDIVIDU.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU");
$row_rq_mtinscription= $query_rq_etudiant->fetchObject();

$query_rq_niveau = $dbh->query("SELECT * FROM NIVEAU WHERE IDETABLISSEMENT = $colname_rq_individu");

$query_rq_filiere = $dbh->query("SELECT * FROM SERIE WHERE IDETABLISSEMENT = $colname_rq_individu");

$query_rq_classe = $dbh->query("SELECT * FROM CLASSROOM WHERE IDNIVEAU = ".$IDNIVEAU." AND CLASSROOM.IDSERIE=".$IDSERIE);

$query_rq_transport = $dbh->query("SELECT * FROM SECTION_TRANSPORT");

$query_rq_moyenp = $dbh->query("SELECT IDMOYEN_PAIEMENT,LIB_MOYEN_PAIEMENT FROM MOYEN_PAIEMENT");
$rs_moyenp = $query_rq_moyenp->fetchAll();

$query_rq_uniforme = $dbh->query("SELECT ROWID, IDNIVEAU, LIBELLE, MONTANT FROM UNIFORME WHERE IDNIVEAU = " . $IDNIVEAU);
$rs_uniforme = $query_rq_uniforme->fetchAll();

$query_rq_banque = $dbh->query("SELECT ROWID, LABEL FROM BANQUE WHERE ETAT = 1");
$rs_banque = $query_rq_banque->fetchAll();


$query_rq_an = $dbh->query("SELECT DATE_DEBUT, DATE_FIN 
                                          FROM ANNEESSCOLAIRE
                                          WHERE IDETABLISSEMENT = " . $colname_rq_individu ." 
                                          AND IDANNEESSCOLAIRE=" . $lib->securite_xss($_SESSION['ANNEESSCOLAIRE'])."
                                          AND ETAT = 0"

);
$row_rq_an = $query_rq_an->fetchObject();
$date_debut = $row_rq_an->DATE_DEBUT;
$date_fin = $row_rq_an->DATE_FIN;

$d1 = new DateTime($date_debut);
$d2 = new DateTime($date_fin);
$difference = $d1->diff($d2)->m - 2;
?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Historique inscription</li>
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
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) 
						  {?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $_GET['msg']; ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $_GET['res']!=1) 
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $_GET['msg']; ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                 
                 <form id="form1" name="form1" method="post" action="updateInscription.php" >
                 
                <?php  
				//print_r($resultat);
				?>
               
                  
                   <div class="row">
                   
                   <div class="col-lg-12">
                       <div class="form-group">
                           <div class="col-md-2"><label>CYCLE</label></div>
                           <div class="col-lg-4">
                               <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" onchange="controlButton()">
                                   <option value="">-- Selectionner le cycle-- </option>
                                   <?php foreach ( $query_rq_niveau->fetchAll() as $niveau){ ?>
                                       <option value="<?php echo $niveau['IDNIVEAU']; ?>" <?php if($niveau['IDNIVEAU']==$IDNIVEAU) echo "selected";?>><?php echo $niveau['LIBELLE']; ?></option>
                                   <?php } ?>
                               </select>
                           </div>
                           <div class="col-md-1"><label >FILIERE / SERIE</label></div>
                           <div class="col-lg-5">
                               <select name="IDSERIE" id="selectSerie" class="form-control selectpicker" onchange="controlButton_();">
                                   <option value="">-- Selectionner la filiere-- </option>
                               </select>
                           </div>
                       </div>
       </div><br><br>
       
       
        
        <div class="col-lg-12">
             <div class="form-group">
                   <div class="col-lg-2"><label >DATE D'INSCRIPTION</label></div>
                 
                  <div class="col-lg-10"> <input type="text" name="DATEINSCRIPT" id="date_foo"  class="form-control" value="<?php echo date("Y-m-d")?>"/>
                 </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                   <div class="col-lg-2"><label >MONTANT DE LA MENSUALITE</label></div>
                   <div class="col-lg-10">
                  <input type="text" name="MONTANT" id="MONTANT"  class="form-control" value="<?php echo $row_rq_mtinscription->MONTANT; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >FRAIS INSCRIPTION</label></div>
                 
                 <div class="col-lg-10"> <input type="text" name="FRAIS_INSCRIPTION" id="FRAIS_INSCRIPTION"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_INSCRIPTION; ?>"/>
                 </div>
                
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >ACCOMPTE VERSE</label></div>
                  <div class="col-lg-10">
                  <input type="text" name="ACCOMPTE_VERSE" id="ACCOMPTE_VERSE"  class="form-control" value="<?php echo $row_rq_mtinscription->ACCOMPTE_VERSE; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >ACCORD MENSUALITE</label></div>
                  <div class="col-lg-10">
                  <input type="text" name="ACCORD_MENSUELITE" id="ACCORD_MENSUELITE"  class="form-control" value="<?php echo $row_rq_mtinscription->ACCORD_MENSUELITE; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >DERNIER ETABLISSEMENT FREQUENTEE</label></div>
                  <div class="col-lg-10">
                  <input type="text" name="DERNIER_ETAB" id="DERNIER_ETAB"  class="form-control" value="<?php echo $row_rq_mtinscription->DERNIER_ETAB; ?>"/>
                  </div>
             </div>
       </div><br><br>
       <div class="col-lg-12">
           <div class="form-group">
               <div class="col-lg-2"><label >UNIFORME</label></div>
               <div class="col-lg-4">
                   <input type="text" name="UNIFORME" id="UNIFORME"  class="form-control" value="<?php echo $row_rq_mtinscription->UNIFORME; ?>" />
               </div>

               <div class="col-lg-2"><label >ACOMPTE</label></div>
               <div class="col-lg-4">
                   <input type="text" name="MONTANT_UNIFORME" id="MONTANT_UNIFORME"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_UNIFORME; ?>"/>
               </div>

           </div>
       </div><br><br>
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >FRAIS DOSSIER</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="FRAIS_DOSSIER" id="FRAIS_DOSSIER"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_DOSSIER; ?>" />
                  </div>
                  
                  <div class="col-lg-2"><label >ACOMPTE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_DOSSIER" id="MONTANT_DOSSIER"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_DOSSIER; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
       <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >FRAIS EXAMEN</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="FRAIS_EXAMEN" id="FRAIS_EXAMEN"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_EXAMEN; ?>" />
                  </div>
                  
                  <div class="col-lg-2"><label >ACOMPTE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_EXAMEN" id="MONTANT_EXAMEN"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_EXAMEN; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
      
       <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >VACCINATION</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="VACCINATION" id="VACCINATION"  class="form-control" value="<?php echo $row_rq_mtinscription->VACCINATION; ?>"/>
                  </div>
                  
                  <div class="col-lg-2"><label >ACOMPTE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_VACCINATION" id="MONTANT_VACCINATION"  class="form-control" value="<?php echo $row_rq_mtinscription->MONTANT_VACCINATION; ?>" />
                  </div>
             </div>
       </div><br><br>
       
       <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >ASSURANCE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="ASSURANCE" id="ASSURANCE"  class="form-control" value="<?php echo $row_rq_mtinscription->ASSURANCE; ?>"/>
                  </div>
                  
                  <div class="col-lg-2"><label >ACOMPTE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_ASSURANCE" id="MONTANT_ASSURANCE"  class="form-control"  value="<?php echo $row_rq_mtinscription->MONTANT_ASSURANCE; ?>"/>
                  </div>
             </div>
       </div><br><br>
       
       <div class="col-lg-12">
             <div class="form-group">
                 <div class="col-lg-2"> <label >FRAIS SOUTENANCE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="FRAIS_SOUTENANCE" id="FRAIS_SOUTENANCE"  class="form-control" value="<?php echo $row_rq_mtinscription->FRAIS_SOUTENANCE; ?>"/>
                  </div>
                  
                  <div class="col-lg-2"><label >ACOMPTE</label></div>
                  <div class="col-lg-4">
                  <input type="text" name="MONTANT_SOUTENANCE" id="MONTANT_SOUTENANCE"  class="form-control" value="<?php echo $row_rq_mtinscription->MONTANT_SOUTENANCE; ?>" />
                  </div>
             </div>
       </div><br><br>

       <div class="col-lg-12">
           <div class="form-group">
               <div class="col-lg-2"><label>TRANSPORT</label></div>
               <div class="col-lg-4">
                   <div class="form-check-inline">
                       <label class="form-check-label">
                           <input type="radio" class="form-check-input" name="optTransport" value="1" <?php echo $row_rq_mtinscription->TRANSPORT == 1 ? "checked" : "";?> > OUI
                       </label>
                       &nbsp;
                       <label class="form-check-label">
                           <input type="radio" class="form-check-input" name="optTransport" value="0"<?php echo $row_rq_mtinscription->TRANSPORT == 0 ? "checked" : "";?> > NON
                       </label>
                   </div>
               </div>
               <div id="selection" style="<?php echo $row_rq_mtinscription->TRANSPORT == 0 ? "display:none" : "display:block";?>">
                   <div class="col-lg-2"><label>SECTION</label></div>
                   <div class="col-lg-4">
                       <select class="form-control" id="selectSection" name="selectSection" required>
                           <option value="">Selectionner une section</option>
                           <?php
                           foreach ($query_rq_transport->fetchAll() as $rq_section) {?>
                               <option value="<?php echo $rq_section['ID_SECTION'] ?>"<?php if($row_rq_mtinscription->FK_SECTION==$rq_section['ID_SECTION']) echo "selected"; ?>><?php echo $rq_section['LIBELLE'].' -----> '.$lib->nombre_form($rq_section['MONTANT']).' F CFA'; ?></option>
                           <?php }
                           ?>
                       </select>
                   </div>
               </div>


           </div>
       </div>
       <br><br>
       
        <div class="col-lg-12">
             <div class="form-group">
                  <div class="col-lg-2"><label >CLASSE</label></div>
                  <div class="col-lg-10">
                    <select  id="classe" name="classe" class="form-control" required>
                      <option value="">Selectionner une classe</option>
                    </select>
                  </div>
             </div>
       </div>

                       <br><br>
                       <div class="col-lg-12">
                           <div class="form-group">
                               <div class="col-lg-2"><label>MOYEN DE PAIEMENT :</label></div>
                               <div class="col-lg-3">
                                   <div class="col-lg-10">
                                       <select id="FK_MOYENPAIEMENT" name="FK_MOYENPAIEMENT" class="form-control" data-live-search="true" required onchange="getMoyenPaie()">
                                           <option value="" selected> --Séléctionner moyen de paiement-- </option>
                                           <?php foreach ($rs_moyenp as $rq_moyenp) { ?>
                                               <option value="<?php echo $rq_moyenp['IDMOYEN_PAIEMENT'] ?>" <?php if($row_rq_mtinscription->FK_MOYENPAIEMENT==$rq_moyenp['IDMOYEN_PAIEMENT']) echo "selected"; ?>><?php echo $rq_moyenp['LIB_MOYEN_PAIEMENT'] ?></option>
                                           <?php } ?>
                                       </select>
                                   </div>
                               </div>

                               <div id="moyenpaie" style="<?php echo $row_rq_mtinscription->FK_MOYENPAIEMENT == 1 ? "display:none" : "display:block";?>">

                                   <div class="col-lg-1"><label>N° CHEQUE : </label></div>
                                   <div class="col-lg-2">
                                       <input type="text" name="NUM_CHEQUE" id="NUM_CHEQUE" class="form-control" value="<?php echo $row_rq_mtinscription->NUM_CHEQUE; ?>" />
                                   </div>

                                   <div class="col-lg-1"><label>BANQUE :</label></div>
                                   <div class="col-lg-3">
                                       <div class="col-lg-10">
                                           <select id="FK_BANQUE" name="FK_BANQUE" class="form-control" data-live-search="true">
                                               <option value="" selected> --Séléctionner une banque-- </option>
                                               <?php foreach ($rs_banque as $row_bq) { ?>
                                                   <option value="<?php echo $row_bq['ROWID']; ?>" <?php if($row_rq_mtinscription->FK_BANQUE==$row_bq['ROWID']) echo "selected"; ?>><?php echo $row_bq['LABEL']; ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                   </div>

                               </div>

                           </div>
                       </div>


                       <br><br>
                       <?php// if ($row_rq_mtinscription->TROUSSEAU == 1){?>
                       <div class="col-lg-12">
                           <div class="form-group">
                               <div class="col-lg-2"><label >TROUSSEAU : </label></div>
                               <div class="col-lg-10">
                                   <input type="number" name="UNIFORME" id="UNIFORME" value="<?php echo $row_rq_mtinscription->UNIFORME; ?>" class="form-control" />

                               </div>
                           </div>
                       </div>

                       <div class="col-lg-12" id="Acompte_trousseau" style="<?php echo $row_rq_mtinscription->MONTANT_UNIFORME == 0 ? "display:none" : "display:block";?>">

                           <div class="form-group">
                               <div class="col-lg-2"><label>ACOMPTE TROUSSEAU : </label></div>
                               <div class="col-lg-4">
                                   <input type="number" name="MONTANT_UNIFORME" id="MONTANT_UNIFORME" value="<?php echo $row_rq_mtinscription->MONTANT_UNIFORME; ?>"  class="form-control" />
                               </div>
                               <div class="col-lg-2"></div>
                               <div class="col-lg-4">
                               </div>
                           </div>

                       </div>
                       <?php //} ?>



                       <br><br>
                <?php if ($row_rq_mtinscription->AVANCE == 1) {?>
                       <div class="col-lg-12">
                           <div class="form-group">
                               <div class="col-lg-2"><label>AVANCE MENSUALITE : </label></div>
                               <div class="col-lg-4">
                                   <div class="form-check-inline">

                                       <label class="form-check-label">
                                           <input type="radio" class="form-check-input" name="optAvance" id="oui" value="1" checked > OUI
                                       </label>
                                   </div>
                               </div>
                           <div class="col-lg-2"><label>Nombre de mois : </label></div>
                           <div class="col-lg-4">

                               <input type="number" name="nombremois" id="nombremois" value="<?php echo $row_rq_mtinscription->NBRE_MOIS; ?>" max="<?php echo $difference; ?>" class="form-control" readonly/>

                           </div>
                       </div>
                       <?php }else{ ?>
                       <div class="col-lg-12">

                           <div class="form-group">
                               <div class="col-lg-2"><label>AVANCE MENSUALITE : </label></div>
                               <div class="col-lg-4">
                                   <div class="form-check-inline">
                                       <label class="form-check-label">
                                           <input type="radio" class="form-check-input" name="optAvance" id="non" value="0" > NON
                                       </label>
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <label class="form-check-label">
                                           <input type="radio" class="form-check-input" name="optAvance" id="oui" value="1" > OUI
                                       </label>
                                   </div>
                               </div>
                               <div id="avance" style="display:none">
                                   <div class="col-lg-2"><label>Nombre de mois : </label></div>
                                   <div class="col-lg-4">
                                       <input type="number" name="nombremois" id="nombremois" value="0" max="<?php echo $difference; ?>" class="form-control"/>

                                   </div>

                               </div>

                           </div>

                       </div>
                <?php } ?>

                       <br><br>
       
      
        
        <input type="hidden" name="STATUT" value="" />
        <input type="hidden" name="IDINDIVIDU" value="<?php echo $lib->securite_xss($_GET['IDINDIVIDU']); ?>" />
        <input type="hidden" name="IDINSCRIPTION" value="<?php echo $lib->securite_xss($_GET['idInscription']); ?>" />
        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo base64_encode($_SESSION['etab']) ;?>" />
        <input type="hidden" name="IDANNEESSCOLAIRE" value="<?php echo base64_encode($_SESSION['ANNEESSCOLAIRE']) ;?>" />
        <input type="hidden" name="IDAFFECTATION" value="<?php echo base64_encode($row_rq_mtinscription->IDAFFECTATTION_ELEVE_CLASSE) ;?>" />
        <input type="hidden" name="VALIDETUDE" value="" />
        <input type="hidden" name="RESULTAT_ANNUEL" value="" />
        <div class="col-lg-offset-9 col-lg-1" id="idvalider"> <input name="" type="submit" value="S'inscrire" class="btn btn-success"/> </div>
        
      </div> 
     
    </form>




            </div></div></div>
            <!-- END WIDGETS -->



        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>

<script>
    $(function() {
        $.ajax({
            method: "POST",
            url: "requestCycle.php",
            data: {
                IDNIVEAU: btoa(<?php echo $IDNIVEAU; ?>)
            }
        }).done(function (data) {
            var data = $.parseJSON(data)
            $('#selectSerie').children('option:not(:first)').remove()
            $('#selectSerie').selectpicker('refresh')
            for (i = 0, len = data.length; i < len; i++){
                $('#selectSerie').append(new Option(data[i].LIBSERIE, data[i].IDSERIE))
                $('#selectSerie').selectpicker('refresh')
            }
            $("#selectSerie option").each(function(){
                if ($(this).val() == "<?php echo $IDSERIE ;?>")
                    $(this).attr("selected","selected");
            })
            $('#selectSerie').selectpicker('refresh')
        })
        $.ajax({
            method: "POST",
            url: "requestClasse.php",
            data: {
                IDNIVEAU: btoa(<?php echo $IDNIVEAU; ?>)
            }
        }).done(function (data) {
            var data = $.parseJSON(data)
            $('#classe').children('option:not(:first)').remove()
            for (i = 0, len = data.length; i < len; i++){
                $('#classe').append(new Option(data[i].LIBELLE, data[i].IDCLASSROOM))
            }
            $("#classe option").each(function(){
                if (parseInt($(this).val()) == "<?php echo $row_rq_mtinscription->IDCLASSROOM ;?>"){
                    $(this).attr("selected","selected");
                }
            })
            
        })
    });

    function controlButton() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv != "") {
            $('#idvalider').css("display","none")
            $.ajax({
                method: "POST",
                url: "requestCycle.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }

            }).done(function (data) {
                var data = $.parseJSON(data)
                $('#selectSerie').children('option:not(:first)').remove()
                $('#selectSerie').selectpicker('refresh')
                for (i = 0, len = data.length; i < len; i++){
                    $('#selectSerie').append(new Option(data[i].LIBSERIE, data[i].IDSERIE))
                    $('#selectSerie').selectpicker('refresh')
                }
            })
            $.ajax({
                method: "POST",
                url: "requestClasse.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }
            }).done(function (data) {
                var data = $.parseJSON(data)
                $('#classe').children('option:not(:first)').remove()
                for (i = 0, len = data.length; i < len; i++){
                    $('#classe').append(new Option(data[i].LIBELLE, data[i].IDCLASSROOM))
                }
            })
        }
    }
    $("#selectNiv").on('change', function () {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv == "") {
            $('#selectSerie').children('option:not(:first)').remove()
            $('#selectSerie').selectpicker('refresh')
            $('#classe').children('option:not(:first)').remove()
            $('#idvalider').css("display","none")
        }
    })

    function controlButton_() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        var selectedSer = $("#selectSerie").find("option:selected").val()

        if(selectedNiv == "" || selectedSer == "") {
            $('#idvalider').css("display","none")
        }
        else {
            $.post("RequetesFraisFiliere.php",
                {
                    filiere: selectedSer,
                    niveau: selectedNiv
                },
                function(data, status){
                    if(status == "success"){
                        var myData = JSON.parse(data);
                        if(myData != -1){
                            $("#MONTANT").val(myData.MT_MENSUALITE);
                            $("#FRAIS_INSCRIPTION").val(myData.FRAIS_INSCRIPTION);
                            $("#UNIFORME").val(myData.UNIFORME);
                            $("#FRAIS_DOSSIER").val(myData.FRAIS_DOSSIER);
                            $("#FRAIS_EXAMEN").val(myData.FRAIS_EXAMEN);
                            $("#VACCINATION").val(myData.VACCINATION);
                            $("#ASSURANCE").val(myData.ASSURANCE);
                            $("#FRAIS_SOUTENANCE").val(myData.FRAIS_SOUTENANCE);
                        }else {
                            $("#MONTANT").val(0);
                            $("#FRAIS_INSCRIPTION").val(0);
                            $("#UNIFORME").val(0);
                            $("#FRAIS_DOSSIER").val(0);
                            $("#FRAIS_EXAMEN").val(0);
                            $("#VACCINATION").val(0);
                            $("#ASSURANCE").val(0);
                            $("#FRAIS_SOUTENANCE").val(0);
                        }
                    }
                }
            );
            $('#idvalider').css("display","block")
        }
    }
</script>
<script>
    $("input").on('click', function () {
        if($("input:checked").val() == "1"){
            $("#selection").css('display','block');

        }else{
            $("#selection").css('display','none')


            $('#selectSection').val("")
        }
        if($('input[name=optAvance]:checked').val() == "1"){
           // alert(1);
            $("#avance").css('display','block');
        }else {
            $("#avance").css('display', 'none')
        }


    });

    function getMoyenPaie() {
        var moyen = $("#FK_MOYENPAIEMENT").val();
        if (moyen==2){
            $('#moyenpaie').css("display","block");
        }else{
            $('#moyenpaie').css("display","none");
        }
    }

</script>