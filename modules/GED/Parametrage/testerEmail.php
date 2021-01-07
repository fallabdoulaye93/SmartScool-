<?php
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

require_once("classe/UtilisateurManager.php");
require_once("classe/Utilisateur.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$niv = new UtilisateurManager($dbh, 'UTILISATEURS');

if (isset($_POST) && $_POST != null) {
    $res = ( isset($_POST['email']) ) ? $niv->userExistByCol($_POST['email'], null) : $niv->userExistByCol(null, $_POST['login']);
    if ($res) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}
