<?php

if((isset($_POST['login'])&& $_POST['login']!='') &&(isset($_POST['password'])&& $_POST['password']!=''))
{
	   session_start();
       require_once("modules/Administration/classe/ConnexionManager.php");
	   require_once("config/Connexion.php");
        require_once ("config/Librairie.php");
        $user=new ConnexionManager();
           $Isconncte=$user->Connecter($_POST['login'],$_POST['password']);
        if($Isconncte==1)
        {
			
			$connection =  new Connexion();
			$dbh = $connection->Connection();
            $lib= new Librairie();
			$query= "SELECT idUtilisateur, prenomUtilisateur, nomUtilisateur, idProfil, UTILISATEURS.idEtablissement, ETABLISSEMENT.PREFIXE,ETABLISSEMENT.LOGO, ETABLISSEMENT.NOMETABLISSEMENT_ FROM UTILISATEURS, ETABLISSEMENT ";
			$query.= " WHERE ETABLISSEMENT.IDETABLISSEMENT= UTILISATEURS.idEtablissement AND login=".$lib->GetSQLValueString($_POST['login'],"text")." and password=".$lib->GetSQLValueString(md5($_POST['password']),"text");
			$stmt = $dbh->prepare($query);  
			  $stmt->execute();
			  $rs_user = $stmt->fetchObject(); 
			  $total_rows= $stmt->rowCount();
			  if($total_rows > 0){
				  
							$_SESSION["id"]=$rs_user->idUtilisateur;
							$_SESSION["nom"]=$rs_user->nomUtilisateur;
							$_SESSION["prenom"]=$rs_user->prenomUtilisateur;
							
							$_SESSION["nomProfil"]=$rs_user->profil;
							$_SESSION["etab"]=$rs_user->idEtablissement;
							$_SESSION['PREFIXE']= $rs_user->PREFIXE;
							$_SESSION['nomEtablissement']= $rs_user->NOMETABLISSEMENT_;
							$_SESSION['LOGO']= $rs_user->LOGO;
							$query_rq_annee = $dbh->query("SELECT * FROM ANNEESSCOLAIRE WHERE IDETABLISSEMENT = ".$rs_user->idEtablissement." ORDER BY IDANNEESSCOLAIRE DESC");
							$row_rq_annee = $query_rq_annee->fetchObject();
							
							$_SESSION['ANNEESSCOLAIRE'] = $row_rq_annee->IDANNEESSCOLAIRE;
							
							
							
			  }
			
			
           $urlredirect="menu.php";
        }
        else{
			$urlredirect="index.php?msg=parametre de connexion invalide";
        }
		 header("Location:$urlredirect" );
    }
?>

<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>SunuEcole - Gestion Administrative des Etablissements Scolaires</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="assets/images/users/user-ecole.jpg" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
    <!-- EOF CSS INCLUDE -->
    
     <style>
		.cadre {
    background-color: #ffffff;
    width: 100%;
    margin: 0 auto 15px auto;
    padding: 10px;
    border: 2px solid #2589C5;
 
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 5px;
    behavior: url(border-radius.htc);
 
    background-image: -moz-linear-gradient(top, #ffffff, #f4f4f4);
    background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f4f4f4));
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4)";
	
	}
	 
	legend {
		color: #E05D1F;
	}
   </style>  
        
        
</head>
<body>

<div class="login-container">

    <div class="login-box animated fadeInDown">
        <div class="login-logo"></div>
        <br/>
        <br/>
        <div class="login-body">
            <div class="login-title"><strong>SunuEcole</strong></div>
<fieldset><legend>Mot de passe oublié</legend>

            <form  class="form-horizontal" method="post" action="index.php">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="text" name="login" class="form-control" placeholder="login"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-6">
                       
                    </div>
                    <div class="col-md-6">
                        <button name='connexion' class="btn btn-num_blue btn-block">Envoyer</button>
                    </div>
                </div>
            </form>
            </fieldset>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                 <a href="https://www.numherit.com">&copy; 2016 NUMHERIT</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
