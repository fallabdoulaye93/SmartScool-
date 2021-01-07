
<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("restriction.php");

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

require_once('classe/IndividuManager.php');
$ind = new IndividuManager($dbh,'INDIVIDU');


$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_idindividu = "-1";
if (isset($_SESSION['id'])) {
  $colname_rq_idindividu = $lib->securite_xss($_SESSION['id']);
}


$query_rq_etablissement = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = ".$colname_rq_idindividu);
$row_rq_etablissement = $query_rq_etablissement->fetchObject();

$query_rq_cv = $dbh->query("SELECT * FROM CV WHERE IDINDIVIDU = ".$colname_rq_idindividu);
$row_rq_cv = $query_rq_cv->fetchObject();





$colname_id = "-1";
if (isset($_SESSION['id'])) {
    $colname_id = $lib->securite_xss($_SESSION['id']);
}

if ((isset($_POST["form2"])) && ($_POST["form2"] == "update2"))
{
    $id = $lib->securite_xss($_SESSION["id"]);
    $COURRIEL = $lib->securite_xss($_POST['COURRIEL']);
    $ADRES = $lib->securite_xss($_POST['ADRES']);
    $TELMOBILE = $lib->securite_xss($_POST['TELMOBILE']);

    $query ="UPDATE INDIVIDU SET COURRIEL='".$COURRIEL."', ADRES='".$ADRES."', TELMOBILE='".$TELMOBILE."' WHERE IDINDIVIDU = $id" ;
    $requete = $dbh->prepare($query);
    $requete->execute();
    $totalRows = $requete->rowCount();

    if($totalRows==1)
    {
        $urlredirectsucces = "accueil.php?msg=Operation effectuee avec succes";
    }
    else
    {
        $urlredirectError = "accueil.php?msg=erreur operation non effectuee";
    }
    header("Location:$urlredirectError");
}



?>

<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryValidationConfirm.css">
<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryValidationPassword.css">
<script src="../SpryAssets/SpryValidationConfirm.js"></script>
<script src="../SpryAssets/SpryValidationPassword.js"></script>
<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active"> Mes infos</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" style="background-color: #FFFFFF">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1)
                        {?>
                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                        <?php  }
                        if(isset($_GET['res']) && $_GET['res']!=1)
                        {?>
                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                        <?php }
                        ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                                       
                    <table  class="table table-bordered table-hover">
          <caption><center><h3> Informations personnelles</h3> </center> </caption>
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>MATRICULE</th>
              <th>PRENOMS/NOM</th>
              
              <th>EMAIL</th>
              <th>ADRESSE</th>
              <th>TEL</th>
              <th>LOGIN</th>
              <th>CV</th>
              
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><img src="../imgtiers/<?php echo $row_rq_etablissement->PHOTO_FACE;?>" width="31px" height="31px"/></td>
              <td><?php echo $row_rq_etablissement->MATRICULE;?></td>
              <td><?php echo $row_rq_etablissement->PRENOMS."  ".$row_rq_etablissement->NOM;?></td>
              <td><?php echo $row_rq_etablissement->COURRIEL;?></td>
              <td><?php echo $row_rq_etablissement->ADRES;?></td>
              <td><?php echo $row_rq_etablissement->TELMOBILE;?></td>
              <td><?php echo $row_rq_etablissement->LOGIN;?></td>
              <?php if($query_rq_cv->rowCount() > 0){  ?>
              <td><a href="../cv/<?php echo $row_rq_cv->FICHIER;?>" target="_blank"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;&Iota;&nbsp;<a href="joindreCV.php"><i class="glyphicon glyphicon-edit"></i></a></td>
              <?php  }  else { ?>
              <td><a href="joindreCV.php"><i class="glyphicon glyphicon-plus"></i></a></td>
              <?php } ?>
              
            </tr>
            
          </tbody>
                        
          <tfoot>
              <th colspan="3">
                  <center>
                      <button data-toggle="modal" data-target="#ajouter" style="background-color:#0e4194; color: #FFFFFF;" class='btn dropdown-toggle', aria-hidden='true' >
                                 Modifier mes infos
                      </button>
                  </center>
              </th>

              <th colspan="3">
                  <center>
                      <button data-toggle="modal" data-target="#ajouter1" style="background-color:#0e4194; color: #FFFFFF;" class='btn dropdown-toggle', aria-hidden='true' >
                                 Modifier mon mot de passe
                      </button>
                  </center>
              </th>
          </tfoot>

        </table>
       
   
                      
                    </div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
        
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Modifier mes infos </h3> <!-- IDSALL_DE_CLASSE NOM_SALLE IDTYPE_SALLE IDETABLISSEMENT NBR_PLACES-->
                </div>
                <form action="" method="POST" enctype="multipart/form-data" name="form" id="form">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >MATRICULE</label>
                                    <div>
                                        <input type="text" name="MATRICULE" id="MATRICULE" readonly class="form-control" value="<?php echo $row_rq_etablissement->MATRICULE;?>"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >PRENOMS</label>
                                    <div>
                                        <input type="text" name="PRENOMS" id="PRENOMS" readonly class="form-control" value="<?php echo $row_rq_etablissement->PRENOMS;?>"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >NOM</label>
                                    <div>
                                        <input type="text" name="NOM" id="NOM" readonly class="form-control" value="<?php echo $row_rq_etablissement->NOM;?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >LOGIN</label>
                                    <div>
                                        <input type="text" name="LOGIN" id="LOGIN" required class="form-control" readonly value="<?php echo $row_rq_etablissement->LOGIN;?>"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >EMAIL</label>
                                    <div>
                                        <input type="text" name="COURRIEL" id="COURRIEL" required class="form-control" value="<?php echo $row_rq_etablissement->COURRIEL;?>"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >ADRESSE</label>
                                    <div>
                                        <input type="text" name="ADRES" id="ADRES" required class="form-control" value="<?php echo $row_rq_etablissement->ADRES;?>"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >TEL</label>
                                    <div>
                                        <input type="text" name="TELMOBILE" id="TELMOBILE" required class="form-control" value="<?php echo $row_rq_etablissement->TELMOBILE;?>"/>
                                    </div>
                                </div>
                            </div>
                            
                           <!-- <div class="col-xs-12">
                                <div class="form-group">
                                    <label >PHOTO</label>
                                    <div col-lg-12>
                                        <div class="col-lg-9"><input type="file" name="PHOTO_FACE" id="PHOTO_FACE"  class="form-control" /></div>
                                         <div class="col-lg-3"><img src="../imgtiers/<?php /*echo $row_rq_etablissement->PHOTO_FACE;*/?>"  alt="" width="41px" height="41px"/></div>
                                    </div>
                                </div>
                            </div>-->

                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo intval($_SESSION['etab']); ?>" />
                        <input type="hidden" name="IDINDIVIDU" value="<?php echo intval($_SESSION['id']); ?>" />

                        <input type="hidden" name="form2" value="update2">
                        <button type="submit" class="btn btn-primary pull-right">Modifier</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

 <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter1" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Modifier mon mot de passe </h3>
                </div>
                <form action="modifpass.php" method="POST"  name="form1" id="form1">
         
                    <div class="panel-body">
                        <div class="row">
                         <div class="col-xs-12">
                          <div class="form-group">
                      <label ><b>Ancien mot de passe: </b></label>
                      <div>
                      <input type="password" name="ancien" id="ancien"  class="form-control" required onchange="ancienPwd(this.value);" >
                      <span id="msg2"></span>
                    </div>
                    </div></div>
                 
                 
                  <div class="col-xs-12">
                      <div class="form-group">
                          <label ><b>Nouveau mot de passe: </b></label>
                          <div>
                          <span id="sprypassword1">
                             <input type="password" name="nouveau"  id="nouveau" class="form-control" >
                          </div>
                      </div></div>

                    <div class="col-xs-12">
                      <div class="form-group">
                          <label><b>Confirmation de Mot de passe: </b></label>
                          <div >
                          <span id="spryconfirm1">
                             <input type="password" name="confirm"  id="confirme" class="form-control" >
                             <span class="confirmRequiredMsg">Une valeur est requise.</span><span class="confirmInvalidMsg">Les deux mots de passe ne sont identiques.</span></span>
  
                          </div>
                      </div>
                    </div>
                     
             

                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo intval($_SESSION['etab']); ?>" />
                        <input type="hidden" name="IDINDIVIDU" value="<?php echo intval($_SESSION['id']); ?>" />
                        <input type="hidden" name="form1" value="update">

                        <input type="submit" id="buttonedit" class="btn btn-primary pull-right" value="Modifier"/>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    function ancienPwd(ancien) {

        $.get("verifpwdeleve.php?id=<?= $id ?>&pass="+ancien , function (data) {
            console.log(data);

            if (data==1) {

                $('#msg2').html("<p style='color:green;display: inline;border: 1px solid green'>mot de passe correct.</p>");
                $('#buttonedit').css('display', 'block');

            }
            else {
                $('#buttonedit').css('display', 'none');
                $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>Veuillez entrer le bon mot de passe</p>");

            }
        },'JSON');

    }
</script>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "nouveau", {validateOn: ['blur', 'change']});
</script>

        <?php include('footer.php'); ?>