
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

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(38, $lib->securite_xss($_SESSION['profil'])));

require_once('../Parametrage/classe/ProfileManager.php');
$profiles=new ProfileManager($dbh,'profil');
$profil = $profiles->getProfiles();

$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}


$colname_serach="";
if(isset($_POST['MATRICULE'])&& $lib->securite_xss($_POST['MATRICULE'])!="")
{
    $colname_serach.=" AND INDIVIDU.MATRICULE='".$lib->securite_xss($_POST['MATRICULE'])."'";
}

if(isset($_POST['PRENOMS'])&& $lib->securite_xss($_POST['PRENOMS'])!="")
{
    $colname_serach.=" AND INDIVIDU.PRENOMS='".$lib->securite_xss($_POST['PRENOMS'])."'";
}

if(isset($_POST['NOM'])&& $lib->securite_xss($_POST['NOM'])!="")
{
    $colname_serach.=" AND INDIVIDU.NOM='".$lib->securite_xss($_POST['NOM'])."'";
}

if(isset($_POST['TELMOBILE'])&& $lib->securite_xss($_POST['TELMOBILE'])!="")
{
    $colname_serach.=" AND INDIVIDU.TELMOBILE='".$lib->securite_xss($_POST['TELMOBILE'])."'";
}

$uniforme=0;
if(isset($_POST['UNIFORME'])&& $lib->securite_xss($_POST['UNIFORME'])==1)
{
    $colname_serach.=" AND INSCRIPTION.UNIFORME>0";
    $uniforme=1;

}
$transport=0;
if(isset($_POST['TRANSPORT'])&& $lib->securite_xss($_POST['TRANSPORT'])==1)
{
    $colname_serach.=" AND INSCRIPTION.TRANSPORT>0";
    $transport=1;

}

try
{
    $query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU, INSCRIPTION, NIVEAU, SERIE, ANNEESSCOLAIRE
                                            WHERE INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            AND INDIVIDU.IDETABLISSEMENT = ".$colname_rq_individu." 
                                            AND INDIVIDU.IDTYPEINDIVIDU = 8 ".$colname_serach." 
                                            AND INSCRIPTION.IDNIVEAU = NIVEAU.IDNIVEAU 
                                            AND ANNEESSCOLAIRE.IDANNEESSCOLAIRE = INSCRIPTION.IDANNEESSCOLAIRE 
                                            AND ANNEESSCOLAIRE.ETAT = 0
                                            AND INSCRIPTION.ETAT = 1
                                            AND INSCRIPTION.IDSERIE = SERIE.IDSERIE ");
   // var_dump($query_rq_individu);exit;
}
catch (PDOException $e){
    echo -2;
}


$query_rq_transport = $dbh->query("SELECT ID_SECTION, LIBELLE, MONTANT FROM SECTION_TRANSPORT");
?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Liste des éléves</li>
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
                    
                    <?php if(isset($_GET['msg']) && $lib->securite_xss($_GET['msg'])!= ''){
				 
				  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])==1)
						  {?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])!=1)
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                 
                 <form id="form" name="form1" method="post" action="listeEtudiant.php" >
      <fieldset class="cadre"><legend> Filtre</legend>
     
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <div class="col-xs-3"><label >MATRICULE</label></div>
                    <div class="col-xs-9">
                        <input type="text" name="MATRICULE" id="MATRICULE"  class="form-control"/>
                    </div>
                </div>
            </div>
            
             <div class="col-xs-6">
                <div class="form-group">
                    <div class="col-xs-3"><label >PR&Eacute;NOM(S)</label></div>
                    <div class="col-xs-9">
                        <input type="text" name="PRENOMS" id="PRENOMS"  class="form-control"/>
                    </div>
                </div>
            </div>
        </div><br>
        
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <div class="col-xs-3"><label >NOM</label></div>
                    <div class="col-xs-9">
                        <input type="text" name="NOM" id="NOM"  class="form-control"/>
                    </div>
                </div>
            </div>
            
             <div class="col-xs-6">
                <div class="form-group">
                   <div class="col-xs-3"> <label >TEL. MOBILE</label></div>
                    <div class="col-xs-9">
                        <input type="text" name="TELMOBILE" id="TELMOBILE"  class="form-control"/>
                    </div>
                </div>
            </div>
        </div> <br>

          <div class="row">
              <div class="col-xs-6">
                  <div class="form-group">
                      <div class="col-xs-3"><label >UNIFORME</label></div>
                      <div class="col-xs-9">
                          <input type="radio" class="form-check-input" name="UNIFORME" id="UNIFORME" value="1">

                      </div>
                  </div>
              </div>

              <div class="col-xs-6">
                  <div class="form-group">
                      <div class="col-xs-3"> <label >TRANSPORT</label></div>
                      <div class="col-xs-9">
                          <input type="radio" class="form-check-input" name="TRANSPORT" id="TRANSPORT" value="1">

                      </div>
                  </div>
              </div>
          </div> <br>
               <div class="row">
            <div class="col-xs-offset-6 col-xs-1">
                <div class="form-group">

                    <div>
                        <input type="submit" class="btn btn-success"  value="Rechercher"  />
                    </div>
                </div>
            </div>
            
             
        </div>
            
      </fieldset>
    </form>
                        <br/>
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1 pull-right" style="float: right">
                                <?php if($uniforme==1) { ?>
                                    <a href="../../ged/imprimer_eleveUniforme.php?>"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true" style="color: green;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT EXCEL"></i></a>

                                <?php } elseif($transport==1) { ?>
                                    <a href="../../ged/imprimer_eleveTransport.php"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true" style="color: green;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT EXCEL"></i></a>

                                <?php } ?>
                            </div>
                        </div>
                        <br/>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>

                                 <th>MATRICULE</th>
                                 <th>PR&Eacute;NOM(S)</th>
                                 <th>NOM</th>
                                 <th>TEL. MOBILE</th>
                                 <th>FILI&Egrave;RE</th>
                                 <th>CYCLE</th>
                                 <th>TRANSPORT</th>
<!--                                 <th>TROUSSEAU</th>-->
                                 <th>DETAIL</th>
                                 <th>MODIFIER</th>
                                 <th>SUPPRIMER</th>

                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($query_rq_individu->fetchAll() as $individu){
                                $array = array(
                                    "id" => $individu['IDINDIVIDU']
                                );
                              // var_dump($individu);exit;
                                $param=base64_encode(json_encode($array));
                                ?>
                            <tr>
        
                                <td ><?php echo $individu['MATRICULE']; ?></td>
                                <td ><?php echo $individu['PRENOMS']; ?></td>
                                <td ><?php echo $individu['NOM']; ?></td>
                                <td ><?php echo $individu['TELMOBILE']; ?></td>
                                <td ><?php echo $individu['LIBSERIE']; ?></td>
                                <td ><?php echo $individu['LIBELLE']; ?></td>
                                <td >
                                    <?php
                                    if ($individu['TRANSPORT'] == 1) {
                                        //echo "<span style='color: green;cursor: pointer' class='transport deact glyphicon glyphicon-ok-circle' id='".$individu['IDINDIVIDU']."'></span>";
                                        echo "<a href='#transport' class='deact' data-toggle='modal' data-id='".$individu['IDINDIVIDU']."' data-toggle='tooltip' data-placement='bottom' title='DESABONNER'><i style='color: green;cursor: pointer' class='glyphicon glyphicon-hand-left'></i></a>";
                                    } else {
                                        echo "<a href='#transport' class='act' data-toggle='modal' data-id='".$individu['IDINDIVIDU']."' data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"ABONNER\"><i style='color: darkred;cursor: pointer' class='glyphicon glyphicon-hand-right'></i></a>";
                                    }
                                    ?>
                                </td>
<!--                                <td > <a href="#trousseau" class="deact" data-toggle="modal" data-id="<?php /*echo $individu['IDINDIVIDU']; */?>"   data-toggle='tooltip' data-placement='bottom' title='Trousseau'><i class="glyphicon glyphicon-lock"></i></a></td>
-->                                <td ><a href="detailsEleve.php?idIndividu=<?php echo $param; ?>"><i class="glyphicon glyphicon-search"></i></a></td>
                                <td ><a href="modifeleve.php?idIndividu=<?php echo $param; ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                                
                                    <td ><a data-toggle="modal" href="suppeleve.php?idIndividu=<?php echo $param ; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
                                     <!--<td><a href="../cv/<?php //echo $individu['FICHIER'];?>" target="_blank"><i class="glyphicon glyphicon-eye-open"></i></a></td>-->
                                    
                                  </tr>
                            <?php }  ?>
           
                    </tbody>
                    </table>

                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="transport" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center">DESABONNEMENT DE:</h3>
                </div>
                <form action="updateInscriptionTransport.php" method="POST" id="form" name="form" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prenoms" class="col-form-label">Prenoms:</label>
                                    <input type="text" class="form-control" id="prenoms" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom" class="col-form-label">Nom:</label>
                                    <input type="text" class="form-control" id="nom" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" id="sectionT">
                                <div class="form-group">
                                    <label for="nom" class="col-form-label">SECTION:</label>
                                    <select class="form-control" id="selectSection" name="selectSection" required>
                                        <option value="">Selectionner une section</option>
                                        <?php
                                        foreach ($query_rq_transport->fetchAll() as $rq_section) {?>
                                            <option value="<?php echo base64_encode($rq_section['ID_SECTION']); ?>"><?php echo $rq_section['LIBELLE'].' ---> '. $lib->nombre_form($rq_section['MONTANT']).' FCFA'; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" id="idIndividu" name="IDINDIVIDU">
                        <input type="hidden" id="action" name="ACTION">
                        <button type="submit" id="validBtn" class="btn btn-primary pull-right"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="trousseau" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="panel panel-default">
                <!--<div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>-->

                <form id="form2" name="form2" method="post" action="ajouterTrousseau.php">

                    <fieldset class="cadre">
                        <legend> INFORMATIONS TROUSSEAU</legend>

                        <div class="row" style="padding-bottom: 10px!important;">
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="nom" class="col-lg-4 col-sm-4 control-label">UNIFORMES</label>
                                <label for="nom" class="col-lg-4 col-sm-4 control-label">NOMBRES</label>
                                <label for="nom" class="col-lg-4 col-sm-4 control-label">MONTANTS</label>
                            </div>

                        </div>
                        <hr style="font-weight: bold;color: #00a8c6"/>

                        <?php
                        $i=0;
                        foreach ($rs_uniforme as $rs_rq_uniforme) {?>

                            <div class="row" style="padding-bottom: 10px!important;">
                                <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="nom" class="col-lg-3 col-sm-3 control-label"><?php echo $rs_rq_uniforme['LIBELLE'];?> : </label>

                                    <div class="col-lg-5 col-sm-5">
                                        <input type="hidden" name="FK_uniform[]" id="FK_uniforme<?php echo $rs_rq_uniforme['ROWID']?>" class="form-control" value="<?php echo $rs_rq_uniforme['ROWID']?>" />
                                        <input type="number" name="nombre[]" id="nombre<?php echo$i;?>" class="form-control" min="0" placeholder="Nombre" value="0" required disabled onchange="valider();"/>
                                    </div>

                                    <div class="col-lg-3 col-sm-3">
                                        <input type="text" name="montant[]" id="montant<?php echo$i;?>" class="form-control" value="<?php echo $rs_rq_uniforme['MONTANT']?>" readonly />
                                    </div>

                                    <div class="col-lg-1 col-sm-1">
                                        <input type="checkbox" id="choix<?php echo$i; ?>" name="choix" value="<?php echo $i; ?>" onclick="valider()"/>
                                    </div>

                                </div>
                            </div>

                            <?php $i=$i+1;
                        }  ?>


                        <div class="row">
                            <div class="col-xs-offset-6 col-xs-1">
                                <div class="form-group">
                                    <input type="hidden" name="nbreligne" id="nbreligne" class="form-control" value="<?php echo$i; ?>"  />
                                    <input type="button" class="btn btn-success" data-dismiss="modal" id="terminer" value="Terminer" />
                                </div>
                            </div>
                        </div>

                    </fieldset>

                </form>

            </div>

        </div>
    </div>
</div>





<?php include('footer.php'); ?>
<script>
    $('#transport').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget)
        var id = link.data('id')
        var cl = link.attr('class')
        var ajaxResult = $.ajax({
            type: "POST",
            url: "request.php",
            data: {
                IDINDIVIDU: btoa(id)
            }
        })
        ajaxResult.done(function (data) {
            var data = JSON.parse(data)
            $('#prenoms').val(data.PRENOMS)
            $('#nom').val(data.NOM)
            $('#idIndividu').val(btoa(data.IDINDIVIDU))
            if(cl == "deact"){
                var action = 0
                $('#sectionT').css('display','none')
                $('#validBtn').html('DESABONNER')
                $('#action').val(btoa(action))
            }else{
                var action = 1
                $('#sectionT').css('display','block')
                $('#validBtn').html('ABONNER')
                $('#action').val(btoa(action))
            }
        })
    })
</script>
