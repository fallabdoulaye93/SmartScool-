<?php
include('header.php');

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


$colname_id = "-1";
if (isset($_SESSION['id'])) {
  $colname_id = $lib->securite_xss($_SESSION['id']);
}
if (isset($_SESSION['id'])) {
    $nom = $lib->securite_xss($_SESSION['prenom']) . " " . $lib->securite_xss($_SESSION['nom']);
    $adresse = $lib->securite_xss($_SESSION['adres']);
    $TELMOBILE = $lib->securite_xss($_SESSION['telmobile']);
    $TELDOM = $lib->securite_xss($_SESSION['teldom']);
    $COURRIEL = $lib->securite_xss($_SESSION['courriel']);
    $SIT_MATRIMONIAL = $lib->securite_xss($_SESSION['situ_matri']);
    $PHOTO_FACE = $lib->securite_xss($_SESSION['photo']);
}else{
    header("Location:index.php");
}
if(isset($_POST['form1']) && $_POST['form1'] =='update') {
    $ADRES=$lib->securite_xss($_POST['adresse']);
    $TELMOBILE=$lib->securite_xss($_POST['TELMOBILE']);
    $TELDOM=$lib->securite_xss($_POST['TELDOM']);
    $COURRIEL=$lib->securite_xss($_POST['COURRIEL']);
    $id=$lib->securite_xss($_POST['id']);
    $query = sprintf("UPDATE  INDIVIDU SET ADRES =:ADRES, TELMOBILE =:TELMOBILE, TELDOM=:TELDOM, COURRIEL=:COURRIEL WHERE IDINDIVIDU =:id");
    $result = $dbh->prepare($query);
    $result->bindParam(":ADRES", $ADRES);
    $result->bindParam(":TELMOBILE", $TELMOBILE);
    $result->bindParam(":TELDOM", $TELDOM);
    $result->bindParam(":COURRIEL", $COURRIEL);
    $result->bindParam(":id",$id);
    $count = $result->execute();
    $dbh = NULL ;
    $urlredirect="";
    if($count==1){
        $msg = 'Modification effectuée avec succes';
        $urlredirect="infos.php?msg=$msg&res=$count";
    }
    else{
        $msg = 'Votre modification a echoué';
        $urlredirect="infos.php?msg=$msg&res=$count";
    }

    header("Location:$urlredirect");
}
					
?>
                <!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#"> PROFESSUER </a></li>
    <li class="active"> Modifier mes infos</li>
</ul>
<div class="row">
    <div class="panel-body">
        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
	        if(isset($_GET['res']) && $_GET['res']==1) {?>
	            <div class="alert alert-success">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					    <?php echo $lib->securite_xss($_GET['msg']); ?>
			    </div>
		    <?php  }
		    if(isset($_GET['res']) && $_GET['res']!=1) {?>
		        <div class="alert alert-danger">
				    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?php echo $lib->securite_xss($_GET['msg']); ?>
			    </div>
		    <?php } ?>
	    <?php } ?>
        <div class="col-lg-6  center-block">
            <form action="" name="from1" method="post">
                <fieldset class="cadre col-lg-6">
                    <legend class="libelle_champ">Modifier Mes Informations </legend>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Prénom(s) & Nom: </b></label>
                        <div class="col-sm-6" >
                            <input style="width: 100%;" type="text" name="nom" value="<?php echo $nom; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Adresse: </b></label>
                        <div class="col-sm-6" >
                            <input style="width: 100%;" type="text" name="adresse" value="<?php echo $adresse; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>T&eacute;l&eacute;phone: </b></label>
                        <div class="col-sm-6">
                            <input style="width: 100%;" type="text" name="TELMOBILE" value="<?php echo $TELMOBILE; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Domicile: </b></label>
                        <div class="col-sm-6" >
                            <input style="width: 100%;" type="text" name="TELDOM" value="<?php echo $TELDOM; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><b>Email: </b></label>
                        <div class="col-sm-6" >
                            <input style="width: 100%;" type="text" name="COURRIEL" value="<?php echo $COURRIEL; ?>">
                        </div>
                    </div>
                    <div class="form-group row" align="center">
                        <div class="col-sm-3 col-lg-offset-2 col-lg-2" style="height:35px" >
                            <a href="infos.php" class="btn btn-primary">Retourner</a>
                        </div>
                        <div class="col-sm-3 col-lg-offset-2 col-lg-2" style="height:35px" >
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $lib->securite_xss($_SESSION['id'])?>">
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