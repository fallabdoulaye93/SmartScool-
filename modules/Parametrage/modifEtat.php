<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil'])));

require_once("classe/ProfileManager.php");
require_once("classe/Profile.php");
$niv = new ProfileManager($dbh, 'profil');

if (isset($_GET['idProfil']) && isset($_GET['etat']))
{
    $_GET['etat'] = $lib->securite_xss(base64_decode($_GET['etat']));

    $idprofil = $lib->securite_xss(base64_decode($_GET['idProfil']));
    unset($_GET['idProfil']);

    $res = $niv->modifier($lib->securite_xss_array($_GET), 'idProfil', $idprofil);
    if ($res == 1) {
        $msg = "Modification effectuée avec succés";
    } else {
        $msg = "Modification effectuée avec echec";
    }
    header("Location: profile.php?msg=" . $msg . "&res=" . $res);
}