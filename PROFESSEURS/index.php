<?php
if ((isset($_POST['login']) && $_POST['login'] != '') && (isset($_POST['password']) && $_POST['password'] != '')) {
    session_start();
    require_once("../config/Connexion.php");
    require_once("../config/Librairie.php");

    $connection = new Connexion();
    $dbh = $connection->Connection();
    $lib = new Librairie();

    try
    {
        $query = "SELECT IDINDIVIDU,IDTYPEINDIVIDU, MATRICULE, NOM, PRENOMS, IDTYPEINDIVIDU, COURRIEL, ADRES, TELMOBILE, TELDOM, COURRIEL,SIT_MATRIMONIAL, PHOTO_FACE, 
                  INDIVIDU.IDETABLISSEMENT, ETABLISSEMENT.PREFIXE, ETABLISSEMENT.LOGO, ETABLISSEMENT.NOMETABLISSEMENT_ 
                  FROM INDIVIDU, ETABLISSEMENT ";

                  $query .= " WHERE ETABLISSEMENT.IDETABLISSEMENT = INDIVIDU.IDETABLISSEMENT 
                AND INDIVIDU.IDTYPEINDIVIDU = 7 
                AND LOGIN = " . $lib->GetSQLValueString($_POST['login'], "text") . " 
                AND MP = " . $lib->GetSQLValueString(md5($_POST['password']), "text");
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $rs_user = $stmt->fetchObject();
        $total_rows = $stmt->rowCount();
        if ($total_rows > 0) {
            $query_rq_annee = $dbh->query("SELECT * FROM ANNEESSCOLAIRE WHERE ETAT = 0 AND IDETABLISSEMENT = " . $rs_user->IDETABLISSEMENT . " ORDER BY IDANNEESSCOLAIRE DESC");
            $row_rq_annee = $query_rq_annee->fetchObject();
            $_SESSION["id"] = $rs_user->IDINDIVIDU;
            $_SESSION["idtype"] = $rs_user->IDTYPEINDIVIDU;
            $_SESSION["matricule"] = $rs_user->MATRICULE;
            $_SESSION["nom"] = $rs_user->NOM;
            $_SESSION["email"] = $rs_user->COURRIEL;
            $_SESSION["prenom"] = $rs_user->PRENOMS;
            $_SESSION["profil"] = $rs_user->IDTYPEINDIVIDU;
            $_SESSION["adres"] = $rs_user->ADRES;
            $_SESSION["telmobile"] = $rs_user->TELMOBILE;
            $_SESSION["teldom"] = $rs_user->TELDOM;
            $_SESSION["mp"] = md5($_POST['password']);
            $_SESSION["courriel"] = $rs_user->COURRIEL;
            $_SESSION["situ_matri"] = $rs_user->SIT_MATRIMONIAL;
            $_SESSION["photo"] = $rs_user->PHOTO_FACE;
            $_SESSION["etab"] = $rs_user->IDETABLISSEMENT;
            $_SESSION['PREFIXE'] = $rs_user->PREFIXE;
            $_SESSION['nomEtablissement'] = $rs_user->NOMETABLISSEMENT_;
            $_SESSION['LOGO'] = $rs_user->LOGO;
            $_SESSION['ANNEESSCOLAIRE'] = $row_rq_annee->IDANNEESSCOLAIRE;

            $urlredirect = "infos.php";

        } else {
            $urlredirect = "index.php?msg=parametre de connexion invalide";
        }
    }
    catch (PDOException $e)
    {
        $urlredirect = "index.php?msg=parametre de connexion invalide";
    }
    header("Location:$urlredirect");
}
?>
<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>NUMHERIT - SunuEcole</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="icon" href="../assets/images/users/user-ecole.jpg" type="image/x-icon"/>
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

            <form class="form-horizontal" method="post" action="index.php">
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
                        <!--<a href="#" class="btn btn-link btn-block">Mot de passe oublié?</a>-->
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
                <a href="https://www.numherit.com">&copy; 2019 NUMHERIT</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>