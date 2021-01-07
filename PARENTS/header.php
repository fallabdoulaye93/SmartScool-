<?php //require_once("restriction.php");
if (session_status() == 1) {
    session_start();
}

if (!isset($_SESSION['id']) || $_SESSION['idtype'] != 9) {
    header("Location:index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>SunuEcole - Gestion Administrative des Etablissements Scolaires</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="icon" href="../assets/images/users/user-ecole.jpg" type="image/x-icon"/>
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="../css/theme-default.css"/>
    <link rel="stylesheet" type="text/css" id="theme" href="../datetimepicker/jquery.datetimepicker.css"/>
    <!-- EOF CSS INCLUDE -->

    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>

    <style>
        .cadre {
            background-color: #ffffff;
            width: 100%;
            margin: 0 auto 15px auto;
            padding: 10px;
            border: 1px solid #2589C5;

            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 5px;
            behavior: url(border-radius.htc);

            background-image: -moz-linear-gradient(top, #ffffff, #f4f4f4);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f4f4f4));
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff, endColorstr=#f4f4f4);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4)";
        }

        legend {
            color: #1f85c7;
        }
    </style>


</head>
<body>
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE SIDEBAR -->
    <div class="page-sidebar">
        <!-- START X-NAVIGATION -->
        <ul class="x-navigation">
            <li class="xn-logo">
                <a href="">SunuEcole</a>
                <a href="#" class="x-navigation-control"></a>
            </li>
            <li class="xn-profile">
                <a href="#" class="profile-mini">
                    <img src="../assets/images/users/avatar.jpg" alt="John Doe"/>
                </a>

                <div class="profile">
                    <div class="profile-image">
                        <img src="../assets/images/users/user-ecole.jpg" alt="John Doe"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name">
                            <?php echo $_SESSION['prenom'] . "   " . $_SESSION['nom']; ?></div>
                        <?php
                        require_once("../config/Connexion.php");
                        require_once("../config/Librairie.php");
                        $connection = new Connexion();
                        $dbh = $connection->Connection();
                        $query = "SELECT profil from profil where idProfil= " . $_SESSION['profil'];
                        $stmt = $dbh->prepare($query);
                        $stmt->execute();
                        $rs_user = $stmt->fetchObject();
                        ?>
                        <div class="profile-data-title"><?php echo $rs_user->profil; ?></div>
                    </div>
                    <div class="profile-controls">

                    </div>
                </div>
            </li>
            <li class="xn-openable active">
                <a href="accueil.php"><span class="fa fa-files-o"></span> <span class="xn-text">PARAMETRAGE</span></a>
                <ul>
                    <li><a href="infos.php"><span class="fa fa-heart"></span> Mes infos</a></li>
                    <li>
                        <a href="mes_etudiant.php">
                            <span class="glyphicon glyphicon-user"></span> Mes &eacute;tudiants
                        </a>
                    </li>
                    <li><a href="messagerie.php"><span class="fa fa-send"></span> Messagerie</a></li>
<!--                    <li><a href="inscription.php"><span class="glyphicon glyphicon-user"></span>Historique des inscriptions</a></li>-->
<!--                    <li><a href="payment.php"><span class="glyphicon glyphicon-user"></span> Payement de scolarit&eacute;</a></li>-->
<!--                    <li><a href="sanction.php"><span class="fa fa-heart"></span> Sanctions </a></li>-->
<!--                    <li><a href="JF.php"><span class="fa fa-heart"></span> Jours feri&eacute;s</a></li>-->
<!--                    <li><a href="journalecole.php"><span class="fa fa-heart"></span> Consultation du journal de l'&eacute;cole</a></li>-->
<!--                    <li><a href="RI.php"><span class="fa fa-heart"></span> Reglement int&eacute;rieur </a></li>-->
                </ul>
            </li>
        </ul>
        <!-- END X-NAVIGATION -->
    </div>
    <!-- END PAGE SIDEBAR -->

    <!-- PAGE CONTENT -->
    <div class="page-content">
        <!-- START X-NAVIGATION VERTICAL -->
        <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
            <!-- TOGGLE NAVIGATION -->
            <li class="xn-icon-button">
                <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
            </li>
            <!-- END TOGGLE NAVIGATION -->
            <!-- SEARCH -->
            <li class="btn-group-lg"><br>

                <div class="plugin-date" id="plugin-date" style="font-size:18px; color:#fff;">Loading...</div>
            </li>
            <li class="btn-group-lg"><br>

                <div> &nbsp;&nbsp;</div>
            </li>
            <li class="btn-group-lg"><br>

                <div class="plugin-clock" style="font-size:18px; color:#fff;"> 00:00</div>
            </li>
            <!-- END SEARCH -->
            <!-- SIGN OUT -->
            <li class="xn-icon-button pull-right">
                <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
            </li>
            <!-- END SIGN OUT -->
            <li class="xn-icon-button pull-right"><br>
                <span style="font-size:14px; color:#fff;">Bienvenue <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom']; ?> </span>
            </li>
        </ul>
        <!-- END X-NAVIGATION VERTICAL -->