<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

require_once("classe/FiliereManager.php");
require_once("classe/Filiere.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1)
$lib->Restreindre($lib->Est_autoriser(4,$lib->securite_xss($_SESSION['profil'])));


$serie=new FiliereManager($dbh,'SERIE');

if(isset($_POST) && $_POST !=null) {
    $_POST['IDETABLISSEMENT'] = intval(base64_decode($lib->securite_xss($_POST['IDETABLISSEMENT']))) ;
    $_POST['IDNIVEAU'] = intval(base64_decode($lib->securite_xss($_POST['IDNIVEAU'])));
    $res = $serie->insert($lib->securite_xss_array($_POST));
    $urlredirect="";
    if($res == 1){

       $msg = 'Ajout effectué avec succés';
    }
    else{
       $msg = 'Ajout effectué avec echec';
    }
   header("Location: filieres.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}

?>