<?php
if ((isset($_POST['login']) && $_POST['login'] != '') && (isset($_POST['password']) && $_POST['password'] != '')) {
    session_start();

    require_once("ConnexionManager.php");
    require_once("../config/Connexion.php");
    require_once("../config/Librairie.php");
    $connection = new Connexion();
    $dbh = $connection->Connection();
    $lib = new Librairie();

    $user = new ConnexionManager();
    $Isconncte = $user->Connecter($lib->securite_xss($_POST['login']), $lib->securite_xss($_POST['password']));
    if ($Isconncte == 1)
    {
        $query = "SELECT IDINDIVIDU, IDTYPEINDIVIDU, MATRICULE, NOM, PRENOMS, IDTYPEINDIVIDU, COURRIEL, INDIVIDU.IDETABLISSEMENT, 
        ETABLISSEMENT.PREFIXE, ETABLISSEMENT.LOGO, ETABLISSEMENT.NOMETABLISSEMENT_ 
        FROM INDIVIDU, ETABLISSEMENT ";
        $query .= " WHERE ETABLISSEMENT.IDETABLISSEMENT = INDIVIDU.IDETABLISSEMENT 
        AND INDIVIDU.IDTYPEINDIVIDU = 9 
        AND LOGIN = " . $lib->GetSQLValueString($_POST['login'], "text") . " 
        AND MP = " . $lib->GetSQLValueString(md5($_POST['password']), "text");
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $rs_user = $stmt->fetchObject();
        $total_rows = $stmt->rowCount();
        if ($total_rows > 0)
        {
            $_SESSION["id"] = $rs_user->IDINDIVIDU;
            $_SESSION["idtype"] = $rs_user->IDTYPEINDIVIDU;
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
                                                    FROM ANNEESSCOLAIRE WHERE IDETABLISSEMENT = " . $rs_user->IDETABLISSEMENT . " 
                                                    AND ETAT = 0
                                                    ORDER BY IDANNEESSCOLAIRE DESC");
            $row_rq_annee = $query_rq_annee->fetchObject();
            $_SESSION['ANNEESSCOLAIRE'] = $row_rq_annee->IDANNEESSCOLAIRE;

        }
        $urlredirect = "infos.php";
    }
    else
    {
        $mess = 'parametre de connexion invalide';
        $urlredirect = "index.php?msg = ".$lib->securite_xss($mess);
    }
    header("Location:$urlredirect");
}
?>
<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>CEMAD - SunuEcole</title>
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
        <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

            if (isset($_GET['res']) && $_GET['res'] == 1) {


                //var_dump($_GET['msg']); die();

                ?>

                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $_GET['msg']; ?>
                </div>

            <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $_GET['msg']; ?>
                </div>

            <?php } ?>

        <?php } ?>


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
                        <input type="text" name="login" class="form-control" placeholder="Login"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe"/>
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
                &copy; 2019 SAMAECOLE
            </div>

        </div>
    </div>

</div>

</body>
</html>
