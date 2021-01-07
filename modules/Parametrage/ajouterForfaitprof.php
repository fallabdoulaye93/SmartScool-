<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

require_once("classe/ForfaitProfManager.php");
require_once("classe/ForfaitProf.php");

$connection =  new Connexion();
$dbh = $connection->Connection();

$lib=new Librairie();

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(49,$lib->securite_xss($_SESSION['profil'])));

$niv=new ForfaitProfManager($dbh,'FORFAIT_PROFESSEUR');


if(isset($_POST) && $_POST !=null) {
    $_POST['IDETABLISSEMENT']= base64_decode($lib->securite_xss($_POST['IDETABLISSEMENT']));
    $res=$niv->insert($lib->securite_xss_array($_POST));
    $urlredirect="";
    if($res==1){

        $msg = 'Ajout effectué avec succés';
    }
    else{
        $msg = 'Ajout effectué avec echoué';
    }
    header("Location: forfaitProf.php?msg=".$msg."&res=".$res);
}

?>