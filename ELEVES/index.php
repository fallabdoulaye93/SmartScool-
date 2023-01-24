<?php
if((isset($_POST['login'])&& $_POST['login']!='') &&(isset($_POST['password'])&& $_POST['password']!=''))
{
	   session_start();
       require_once("ConnexionManager.php");
	   require_once("../config/Connexion.php");
       require_once ("../config/Librairie.php");
       $user=new ConnexionManager();
       $connection =  new Connexion();

       $dbh = $connection->Connection();
       $lib= new Librairie();
       $Isconncte=$user->Connecter($lib->securite_xss($_POST['login']), $lib->securite_xss($_POST['password']));
       if($Isconncte == 1)
       {
               try
               {
                    $query= "SELECT i.IDINDIVIDU, i.MATRICULE, i.NOM, i.PRENOMS, i.COURRIEL, i.IDTYPEINDIVIDU, i.IDETABLISSEMENT, e.PREFIXE, e.LOGO, e.NOMETABLISSEMENT_ , a.IDCLASSROOM
                    FROM INDIVIDU i 
                    INNER JOIN ETABLISSEMENT e ON e.IDETABLISSEMENT = i.IDETABLISSEMENT 
                    INNER JOIN INSCRIPTION ins ON ins.IDINDIVIDU = i.IDINDIVIDU
                    INNER JOIN AFFECTATION_ELEVE_CLASSE a ON ins.IDINDIVIDU = i.IDINDIVIDU
                    WHERE i.IDTYPEINDIVIDU = 8 
                    AND ins.ETAT = 1
                    AND i.LOGIN = ".$lib->GetSQLValueString($_POST['login'],"text")." 
                    AND i.MP = ".$lib->GetSQLValueString(md5($_POST['password']),"text");
                    $stmt = $dbh->prepare($query);
                    $stmt->execute();
                    $rs_user = $stmt->fetchObject();
                    $total_rows = $stmt->rowCount();
               }
               catch (PDOException $e)
               {
                    echo -2;
               }

			  if($total_rows > 0)
			  {
                  $_SESSION["id"] = $rs_user->IDINDIVIDU;
                  $_SESSION["matricule"] = $rs_user->MATRICULE;
                  $_SESSION["nom"] = $rs_user->NOM;
                  $_SESSION["email"] = $rs_user->COURRIEL;
                  $_SESSION["prenom"] = $rs_user->PRENOMS;
                  $_SESSION["profil"] = $rs_user->IDTYPEINDIVIDU;
                  $_SESSION["etab"] = $rs_user->IDETABLISSEMENT;
                  $_SESSION['PREFIXE'] = $rs_user->PREFIXE;
                  $_SESSION['nomEtablissement'] = $rs_user->NOMETABLISSEMENT_;
                  $_SESSION['LOGO'] = $rs_user->LOGO;
                  $query_rq_annee = $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT 
                                                          FROM ANNEESSCOLAIRE WHERE ETAT = 0 
                                                          AND IDETABLISSEMENT = ".$rs_user->IDETABLISSEMENT." 
                                                          ORDER BY IDANNEESSCOLAIRE DESC");
                  $row_rq_annee = $query_rq_annee->fetchObject();
                  $_SESSION['ANNEESSCOLAIRE'] = $row_rq_annee->IDANNEESSCOLAIRE;

                   $query1= "SELECT  c.IDCLASSROOM, c.LIBELLE, c.IDNIVEAU
                    FROM CLASSROOM c
                    INNER JOIN AFFECTATION_ELEVE_CLASSE a ON a.IDCLASSROOM = c.IDCLASSROOM
                    WHERE a.IDINDIVIDU = ".$lib->securite_xss($_SESSION["id"])."
                    AND a.IDETABLISSEMENT = ".$lib->securite_xss($_SESSION["etab"])."
                    AND a.IDANNEESSCOLAIRE =  ".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);

                  $stmt1 = $dbh->prepare($query1);
                  $stmt1->execute();
                  $rs_donne = $stmt1->fetchObject();

                  $_SESSION["IDNIVEAU"] = $rs_donne->IDNIVEAU;
                  $_SESSION["IDCLASSROOM"] = $rs_donne->IDCLASSROOM;
                  $_SESSION["CLASSE"] = $rs_donne->LIBELLE;
			  }
              $urlredirect="accueil.php";
        }
        else{
			$urlredirect="index.php?msg=parametre de connexion invalide";
        }
		 header("Location:".$lib->securite_xss($urlredirect) );
    }
?>



<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>CEMAD - SunuEcole</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="../assets/images/users/user-ecole.jpg" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="../css/theme-default.css"/>
    <!-- EOF CSS INCLUDE -->
</head>
<body>

<div class="login-container">

    <div class="login-box animated fadeInDown">
        <div class="login-logo"></div>
        <br/>
        <br/>
        <div class="login-body">
            <div class="row" align="center">

                <div class="col-md-4"></div>

                <div class="col-md-4" style="padding-bottom: 10px">
                    <img src="../assets/images/users/logo-accueil.png" alt="CEMAD" />
                </div>

                <div class="col-md-4"></div>

            </div>

            <form  class="form-horizontal" method="post" action="index.php">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="text" name="login" class="form-control" placeholder="login"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <button name='connexion' class="btn btn-num_blue btn-block">Se connecter</button>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                <a href="https://www.samaecole.com">&copy; 2019 SAMAECOLE</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
