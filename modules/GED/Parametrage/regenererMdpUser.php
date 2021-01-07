<?php

session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(2, $lib->securite_xss($_SESSION['profil'])));


require_once("classe/UtilisateurManager.php");
require_once("classe/Utilisateur.php");
$niv=new UtilisateurManager($dbh,'UTILISATEURS');

$colname_rq_user_etab = "-1";
if (isset($_GET['idUtilisateur'])) {
    $colname_rq_user_etab = $lib->securite_xss(base64_decode($_GET['idUtilisateur']));
}
if(isset($_GET['idUser'])){
    $pass = $lib->mot_de_passe();
    $param = [
        "password"=>md5($pass)
    ];
    $res = $niv->modifier($param, 'idUtilisateur', $lib->securite_xss(base64_decode($_GET['idUser'])));
    if ($res==1)
    {
        $lib->envoiNewMDP($lib->securite_xss(base64_decode($_GET['email'])), $lib->securite_xss(base64_decode($_GET['prenom_nom'])), $lib->securite_xss(base64_decode($_GET['login'])), $pass);
        $msg="Regeneration mot de passe reussie";
    }else{
        $msg="Regeneration mot de passe echouee";
    }
} else{
    $msg="Regeneration mot de passe echouee";
}
header("Location: utilisateurs.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
