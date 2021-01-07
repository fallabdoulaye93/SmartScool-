<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/ModePaiementManager.php");
require_once("classe/ModePaiement.php");

$connection =  new Connexion();
$dbh = $connection->Connection();

$lib=new Librairie();

if($_SESSION['profil']!=1) 

$niv=new ModePaiementManager($dbh,'MODE_PAIEMENT');


if(isset($_POST) && $_POST !=null) {
    $_POST['IDETABLISSEMENT']= base64_decode($lib->securite_xss($_POST['IDETABLISSEMENT']));
   $res=$niv->insert($lib->securite_xss_array($_POST));
   $urlredirect="";
   if($res==1)
   {
       $msg = 'Ajout effectué avec succés';
   }
   else{
       $msg = 'Ajout non effectué echec';
   }
  header("Location: modePaiement.php?msg=".$msg."&res=".$res);
}

?>