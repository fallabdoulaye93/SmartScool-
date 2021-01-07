<?php
include('header.php');

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();



if (!isset($_SESSION['id'])) {
  header("Location:index.php");
  exit;
}

if ((isset($_POST["form1"])) && ($_POST["form1"] == "update")) {

    $id = $_SESSION["id"];
    $mdp = md5($_POST['confirm']);
    $query ="UPDATE INDIVIDU SET MP='".$mdp."' WHERE IDINDIVIDU=$id" ;
    $requete=$dbh->prepare($query);
    $requete->execute();
    $totalRows=$requete->rowCount();
    //var_dump($totalRows);die();
    $urlredirectsucces = "index.php?msg=Operation effectuee avec succes";
    $urlredirectError = "modifpass.php?msg=erreur operation non effectuee";
    if($totalRows==1) {

        // On démarre la session
        session_start ();

        // On détruit les variables de notre session
        session_unset ();

// On détruit notre session
        session_destroy ();

// On redirige le visiteur vers la page d'accueil
        header ('location: infos.php');;
    }
    else {
        header("Location:$urlredirectError");
    }

};

?>
<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryValidationConfirm.css">
<link rel="stylesheet" type="text/css" href="../SpryAssets/SpryValidationPassword.css">
<script src="../SpryAssets/SpryValidationConfirm.js"></script>
<script src="../SpryAssets/SpryValidationPassword.js"></script>

<ul class="breadcrumb">
    <li><a href="#"> PROFEESEUR </a></li>
    <li class="active">Mes infos</li>
</ul>
<div class="row">
    <div class="panel-body">
        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
		    if(isset($_GET['res']) && $_GET['res']==1) {?>
	            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                <?php echo $lib->securite_xss($_GET['msg']); ?>
	            </div>
	        <?php  }
	        if(isset($_GET['res']) && $_GET['res']!=1)  { ?>
	            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			        <?php echo $lib->securite_xss($_GET['msg']); ?>
		        </div>
	        <?php } ?>
        <?php } ?>
        <div class="col-lg-6  center-block">
            <form action="modifpass.php" name="form" method="post" id="form">
                <fieldset class="cadre col-lg-6">
                    <legend class="libelle_champ">Modifier mon mot de passe</legend>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Ancien mot de passe: </b></label>
                        <div class="col-sm-6" >
                            <input type="password" name="ancien"  class="form-control" required onchange="ancienPwd(this.value);">
                            <span id="msg2"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Nouveau mot de passe: </b></label>
                        <div class="col-sm-6">
                            <span id="sprypassword1">
                                <input type="password" name="nouveau"  id="nouveau" class="form-control" >
                            <span class="passwordRequiredMsg">Une valeur est requise.</span></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Confirmation de Mot de passe: </b></label>
                        <div class="col-sm-6" >
                            <input type="password" name="confirm"  id="confirme" class="form-control" onchange="confirmPassword();" >
                            <span id="msg3"></span>
                        </div>
                    </div>
                    <div class="form-group row" align="center">
                        <div class="col-sm-3 col-lg-offset-2 col-lg-2" style="height:35px" >
                            <a href="infos.php" class="btn btn-primary">Retourner</a>
                        </div>
                        <div class="col-sm-3 col-lg-offset-2 col-lg-2" style="height:35px" >
                            <!--<button type="submit" class="btn btn-primary">Enregistrer</button>-->
                            <input type="submit" id="button" class="btn btn-primary" value="Enregister"/>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $lib->securite_xss($_SESSION['id'])?>">
                        <input type="hidden" name="form1" value="update">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>

    <script type="text/javascript">
        function ancienPwd(ancien) {

            $.get("verifpwdprof.php?id=<?= $id ?>&pass="+ancien , function (data) {
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
            var nouveau=$('#nouveau').val();
            var confirmation=$('#confirme').val();

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

        <?php include('footer.php'); ?>