<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once("classe/UtilisateurManager.php");
require_once("classe/Utilisateur.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(2, $lib->securite_xss($_SESSION['profil'])));

$niv = new UtilisateurManager($dbh, 'UTILISATEURS');

if (isset($_POST) && $_POST != null)
{
    $pass = $lib->securite_xss($_POST['password']);
    $_POST['password'] = md5($lib->securite_xss($_POST['password']));

    $res = $niv->insert($lib->securite_xss_array($_POST));
    if ($res == 1)
    {
        $lib->envoiLogin($lib->securite_xss($_POST['email']), $lib->securite_xss($_POST['prenomUtilisateur']) . " " . $lib->securite_xss($_POST['nomUtilisateur']), $lib->securite_xss($_POST['login']), $pass);
        $msg = 'Ajout effectué avec succés';
    } else {
        $msg = 'Votre ajout a échoué';
    }
    header("Location: utilisateurs.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}
