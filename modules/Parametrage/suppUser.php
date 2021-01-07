<?php

session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(2,$_SESSION['profil']));


require_once("classe/UtilisateurManager.php");
require_once("classe/Utilisateur.php");
$niv = new UtilisateurManager($dbh,'UTILISATEURS');

$iduser = "-1";
if (isset($_GET['activer']))
{
    $iduser = $lib->securite_xss(base64_decode($_GET['activer']));
}
if (isset($_GET['desactiver']))
{
    $iduser = $lib->securite_xss(base64_decode($_GET['desactiver']));
}

$param = [
    "ETAT"=>$lib->securite_xss($_GET['etat'])
];
$res = $niv->modifier($param, 'idUtilisateur', $iduser);


if ($res==1) {
    $msg="Action effectuée avec succès";

}
else{
    $msg="Action non effectuée";
}
header("Location: utilisateurs.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));

?>