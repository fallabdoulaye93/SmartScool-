<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

require_once("classe/PeriodeScolaireManager.php");
require_once("classe/PeriodeScolaire.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(12,$lib->securite_xss($_SESSION['profil'])));

$periode = new PeriodeScolaireManager($dbh,'PERIODE');


if(isset($_POST) && $_POST !=null) {

    $res=$periode->insert($lib->securite_xss_array($_POST));
    if($res==1)
    {
        $msg = 'Ajout effectué avec succés';
    }
    else
    {
        $msg = 'Ajout effectué avec echec';
    }
   header("Location: periodeScolaires.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>