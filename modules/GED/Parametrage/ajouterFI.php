<?php
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once("classe/FraisInscriptionManager.php");
require_once("classe/FraisInscription.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(7, $lib->securite_xss($_SESSION['profil'])));

$fi = new FraisInscriptionManager($dbh, 'NIVEAU_SERIE');

if (isset($_POST) && $_POST != null) {

    $_POST['montant_total'] = (intval($_POST['MT_MENSUALITE']) * intval($_POST['dure'])) + intval($_POST['FRAIS_INSCRIPTION']) + intval($_POST['FRAIS_DOSSIER']) + intval($_POST['VACCINATION']) + intval($_POST['UNIFORME']) + intval($_POST['ASSURANCE']) + intval($_POST['FRAIS_SOUTENANCE']) + intval($_POST['FOURNITURE']);

    $res = $fi->insert($lib->securite_xss_array($_POST));
    $urlredirect = "";
    if ($res == 1)
    {
        $msg = 'Ajout effectué avec succés';
    }
    else {
        $msg = 'Votre Ajout a échoué';
    }
    header("Location: fraisInscription.php?msg=" . $lib->securite_xss($msg) . "&res=" . $lib->securite_xss($res));
}

?>