<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/JourFeriesManager.php");
require_once("classe/JourFeries.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil'] != 1)
$lib->Restreindre($lib->Est_autoriser(9, $lib->securite_xss($_SESSION['profil'])));

$jfs=new JourFeriesManager($dbh,'VACANCES');


if(isset($_POST) && $_POST !=null)
{

               $res = $jfs->insert($lib->securite_xss_array($_POST));
               $urlredirect="";
			   if($res==1){
			      
                   $msg = 'Ajout effectué avec succès';
               }
               else{
                   $msg = 'Echec de l\'ajout';
			   }
    header("Location: joursFeries.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}
?>