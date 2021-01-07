<?php
include('header.php');
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

$id = "-1";
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

	if(isset($_POST['form1']) && $_POST['form1'] =='update')
	{
        $res=-1;
        $ancien=$lib->securite_xss($_POST['ancien']);
        $nouveau=$lib->securite_xss($_POST['nouveau']);
        $confirm=md5($lib->securite_xss($_POST['confirm']));
        $id=$lib->securite_xss($_POST['id']);

        $query = sprintf("UPDATE  INDIVIDU SET MP =:MP WHERE IDINDIVIDU =:id");
        $result = $dbh->prepare($query);
        $result->bindParam(":MP", $confirm);
        $result->bindParam(":id",$id);
        $res = $result->execute();
        $dbh = NULL ;
        $urlredirect="";
        if($res == 1)
        {
            $msg = 'modification reussie';
            $urlredirect="index.php?msg=$msg&res=$res";
        }
        else
        {
            $msg = 'modification echouée';
            $urlredirect="index.php?msg=$msg&res=$res";
        }
        header("Location:$urlredirect");
    }
					
?>
<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryValidationConfirm.css">
<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryValidationPassword.css">
<script src="../SpryAssets/SpryValidationConfirm.js"></script>
<script src="../SpryAssets/SpryValidationPassword.js"></script>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> PARENT </a></li>                    
                    <li class="active">Mes infos </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
               
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        
                        <div class="panel-body">
                             
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
    
                  <div class="col-lg-6  center-block">
                  <form action="" name="form" method="post" id="form">
            <fieldset class="cadre col-lg-6">
              <legend class="libelle_champ">Modifier mon mot de passe</legend>
                    
                      <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Ancien mot de passe: </b></label>
                  <div class="col-sm-6" >
                      <input type="password" name="ancien"  class="form-control" required onchange="ancienPwd(this.value);" />
                      <span id="msg2"></span>
                  </div>
                 </div>
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Nouveau mot de passe: </b></label>
                          <div class="col-sm-6">
                          <span id="sprypassword1">
                             <input type="password" name="nouveau"  id="newpassword" class="form-control" >

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Confirmation de Mot de passe: </b></label>
                          <div class="col-sm-6" >
                          <span id="spryconfirm1">
                             <input type="password" name="confirm"  id="confirmpassword" class="form-control" onchange="confirmPassword();"  />
                                <span id="msg3"></span>
                          </div>
                      </div>
                      <div class="form-group row" align="center">
                          <div class="col-sm-3 btn-primary col-lg-offset-2 col-lg-2" style="height:35px" >
                              <a href="infos.php" style="color:#FFFFFF; font-size:14px;text-align: center;vertical-align: middle;line-height: 35px;"> Retour</a>
                          </div>

                          <div class="col-sm-3 col-lg-offset-2 col-lg-2" style="height:35px" >
                              <button type="submit" style="height: 37px; font-size: 14px;" class="btn btn-primary">Enregistrer</button>
                          </div>
                          <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                          <input type="hidden" name="form1" value="update">
                      </div>
                   </fieldset>
                </form>
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

<script type="text/javascript">
    function ancienPwd(ancien) {

        $.get("verifpwd.php?id=<?= $id ?>&pass="+ancien , function (data) {
            console.log(data);

            if (data==1) {

                $('#msg2').html("<p style='color:green;display: inline;border: 1px solid green'>mot de passe correct.</p>");

            }
            else {
                $('#button').css('display', 'none');
                $('#msg2').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>Veuillez entrer le bon mot de passe</p>");

            }
        },'JSON');

    }
</script>
<script>
    function confirmPassword() {
        var nouveau=$('#newpassword').val();
        var confirmation=$('#confirmpassword').val();

        if(nouveau==confirmation){
            $('#msg3').html("<p style='color:green;display: inline;border: 1px solid green'>Confirmation effectuée avec succés</p>");
            $('#button').css('display', 'block');
        }
        else{
            $('#msg3').html("<p style='color:#F00;display: inline;border: 1px solid #F00'>Les deux mots de passe ne correspondent pas.</p>");
            $('#button').css('display', 'none');
        }


    }
</script>
