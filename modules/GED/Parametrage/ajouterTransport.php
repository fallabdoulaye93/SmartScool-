<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/TransportManager.php");
require_once("classe/Transport.php");

$connection =  new Connexion();
$dbh = $connection->Connection();

$lib=new Librairie();

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(49,$lib->securite_xss($_SESSION['profil'])));

$niv=new TransportManager($dbh,'SECTION_TRANSPORT');

if(isset($_POST) && $_POST !=null) {
    $res = $niv->insert($lib->securite_xss_array($_POST));
    $urlredirect="";
    if($res==1){
        $msg = 'Ajout effectué avec succés';
    }
    else{
        $msg = 'Ajout effectué avec echoué';
    }
    header("Location: sectionTransport.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}
?>