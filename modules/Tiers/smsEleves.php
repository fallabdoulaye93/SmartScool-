
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
$lib->Restreindre($lib->Est_autoriser(39, $lib->securite_xss($_SESSION['profil'])));

$colname_rq_classe = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_classe = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}
$query_rq_classe = $dbh->query("SELECT IDCLASSROOM, LIBELLE, IDNIVEAU, IDETABLISSEMENT, IDSERIE 
                                              FROM CLASSROOM 
                                              WHERE IDETABLISSEMENT = ".$colname_rq_classe." 
                                              ORDER BY LIBELLE ASC");
$rs_classe = $query_rq_classe->fetchAll();
//var_dump($rs_classe);exit;

$query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $colname_rq_classe);
$rs_niv = $query_rq_niv->fetchAll();


$colname_rq_individu = " ";
$classe="";
$matricule="";
if (isset($_POST['classe']) && $lib->securite_xss($_POST['classe'])!="")
{
    $classe=$lib->securite_xss($_POST['classe']);
    $colname_rq_individu.= " AND a.IDCLASSROOM ='".$lib->securite_xss($_POST['classe'])."'";
    if (isset($_POST['MATRICULE']) && $lib->securite_xss($_POST['MATRICULE'])!=""){
        $matricule=$lib->securite_xss($_POST['MATRICULE']);
        $colname_rq_individu=" AND i.MATRICULE ='".$lib->securite_xss($_POST['MATRICULE'])."'";
    }




    try
    {

        $query_rq_individu = $dbh->query("SELECT a.IDCLASSROOM, a.IDINDIVIDU, i.MATRICULE, i.NOM, 
                                                i.PRENOMS, i.TELMOBILE, i.IDINDIVIDU, i.PHOTO_FACE, c.LIBELLE AS LIBCLASSE 
                                                FROM AFFECTATION_ELEVE_CLASSE a
                                                INNER JOIN INDIVIDU i ON a.IDINDIVIDU = i.IDINDIVIDU
                                                INNER JOIN CLASSROOM c ON a.IDCLASSROOM = c.IDCLASSROOM
                                                INNER JOIN ANNEESSCOLAIRE an ON an.IDANNEESSCOLAIRE = a.IDANNEESSCOLAIRE
                                                INNER JOIN INSCRIPTION ins ON i.IDINDIVIDU = ins.IDINDIVIDU    
                                                WHERE an.ETAT = 0 
                                                AND ins.IDANNEESSCOLAIRE = ".$colname_anne."
                                                AND ins.ETAT = 1 ".$colname_rq_individu."
                                                AND i.TELMOBILE!=''");
       // var_dump($query_rq_individu);exit;
        $rs_indi = $query_rq_individu->fetchAll();


    }
    catch (PDOException $e)
    {
        echo -2;
    }
}
?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Liste des &eacute;léves par classe</li>
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
                        <div class="row">
                            <div class="col-md-12">

                            <form id="form" name="form2" method="POST" action="" class="form-inline">
                              <fieldset class="cadre"><legend> FILTRE</legend>
                                          <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

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
                                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                  <label for="nom" class="col-lg-3 col-sm-4 control-label">CLASSE </label>
                                                  <div class="col-lg-9  col-sm-8">
                                                      <select name="classe" id="classe" class="form-control" required  style="width: 100%;!important;"  onchange="buttonControl();" >
                                                          <option value="">--Selectionner--</option>
                                                      </select>
                                                  </div>
                                            
                                          </div>
                                             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                  <label for="nom" class="col-lg-3 col-sm-4 control-label">MATRICULE&nbsp;&nbsp;</label>
                                                  <div class="col-lg-9  col-sm-8">
                                                      <input type="text" name="MATRICULE" id="MATRICULE"  class="form-control" style="margin-left: 10px;" onclick="buttonControl();" onblur="buttonControl();" />
                                                    <!--  <select name="eleve" id="eleve" class="form-control selectpicker" data-live-search="true"   style="width: 100%;!important;" >
                                                          <option value="">--Selectionner--</option>
                                                      </select>-->
                                                  </div>

                                          </div>

                                          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
                                              <button type="submit" class="btn btn-primary " id="validerAj" title="Rechercher" style="display: none;">Rechercher</button>
                                          </div>


                                </fieldset>
                        </form>
                    </div>
                     </div>


                        <br/>

<?php if (isset($_POST['classe']) && $lib->securite_xss($_POST['classe'])!="") { ?>

                        <table id="customers2" class="table datatable">

                         <thead>
                            <tr>

                                <th>MATRICULE</th>
                                <th>PR&Eacute;NOM(S)</th>
                                 <th>NOM</th>
                                 <th>TEL. MOBILE</th>
                                 <th>CLASSE</th>
                                 <!--<th>MODIFIER</th>
                                 <th>SUPPRIMER</th>
-->

                            </tr>
                            </thead>


                            <tbody>
                           <?php foreach ($rs_indi as $individu){
                                $array = array(
                                    "id" => $individu['IDINDIVIDU']
                                );
                                $param=base64_encode(json_encode($array));

                                ?>
                            <tr>

                                <td ><?php echo $individu['MATRICULE']; ?></td>
                                <td ><?php echo $individu['PRENOMS']; ?></td>
                                <td ><?php echo $individu['NOM']; ?></td>
                                <td ><?php echo $individu['TELMOBILE']; ?></td>
                                <td ><?php echo $individu['LIBCLASSE']; ?></td>


                             <!--   <td><a href="modifEtudiantClasse.php?idIndividu=<?php /*echo $param ; */?>"><i class=" glyphicon glyphicon-edit"></i></a></td>

                                <td><a href="suppEtudiantClasse.php?idIndividu=<?php /*echo $param ; */?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
-->
                            </tr>
                           <?php }  ?>
                            </tbody>
                    </table>

                    <br/>
                    <div class="btn-group pull-right">
                        <button data-toggle="modal" data-target="#envoyer" onmouseover="$(document).ready(myEfface());" style="background-color:#DD682B;margin-top: 15px;" class='btn dropdown-toggle', aria-hidden='true' >
                            Envoyer SMS
                        </button>

                    </div>
    
              <?php } ?>

                    </div></div></div>
                    <!-- END WIDGETS -->                    

                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="envoyer" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> ENVOI SMS </h3>
                </div>

            <form id="myform" name="form1" method="post" action="envoieSMS_E.php" >

                <fieldset class="cadre"> <legend >VOTRE MESSAGE</legend>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Message</label>
                            <div>
                                <textarea  name="message" id="message"  class="form-control" required="required" ></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="classe" id="classe" required class="form-control" value="<?php echo $classe; ?>" readonly/>
                    <input type="hidden" name="annee" id="annee" required class="form-control" value="<?php echo $colname_anne; ?>" readonly/>
                    <input type="hidden" name="matricule" id="matricule" required class="form-control" value="<?php if($matricule!='') echo $matricule; ?>" readonly/>
                    <br/>
                    <div class="btn-group pull-right">
                        <button type="button" id="envoyer" name="envoyer" class="btn btn-primary center-block" style="margin-top: 10px;" onclick="envoie();">Envoyer</button>
                    </div>
                </fieldset>

    </form>
            </div>
        </div>
</div>




<script>
    function choixClasse(elem) {
        var valSel = elem.value;
        $.ajax({
                type: "POST",
                url: "getClasseNive.php",
                data: "NIVEAU=" + valSel,
                success: function (data) {
                    data = JSON.parse(data);
                    $("#classe").html('<option selected="selected" value="">--Selectionner--</option>');
                    $.each(data, function (cle, valeur) {
                        $("#classe").append('<option value="' + valeur.IDCLASSROOM + '">' + valeur.LIBELLE + '</option>');
                    });
                }
            });

    }

function choixEleve(elem) {
        var valSel = elem.value;
        $.ajax({
                type: "POST",
                url: "getElevClasse.php",
                data: "CLASSE=" + valSel,
                success: function (data) {
                    data = JSON.parse(data);
                    $("#eleve").html('<option selected="selected" value="">--Selectionner--</option>');
                    $.each(data, function (cle, valeur) {
                        $("#eleve").append('<option value="' + valeur.IDINVIDU + '">' + valeur.MATRICULE+' '+ valeur.PRENOMS+' '+ valeur.NOM + '</option>');
                    });
                }
            });

    }

    function buttonControl() {
        if(document.getElementById("classe").value!=""){
            $('#validerAj').css("display","block");
        }else{
            $('#validerAj').css("display","none");
        }
    }
    function envoie() {

        if(document.getElementById("message").value !=''){
            document.getElementById("myform").submit();
        }else{
            alert("Le message ne doit pas etre vide")
        }

    }
</script>
        <?php include('footer.php'); ?>


