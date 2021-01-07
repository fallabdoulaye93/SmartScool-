<?php
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/AnneeScolaireManager.php");
require_once("classe/Classe.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
//$lib->Restreindre($lib->Est_autoriser(11,$_SESSION['profil']));

$annee = new AnneeScolaireManager($dbh,'ANNEESSCOLAIRE');
if(isset($_POST) && $_POST !=null)
{
    $res = $annee->insert($lib->securite_xss_array($_POST));
    $urlredirect="";
    if($res==1)
    {
        $msg = 'Ajout effectué avec succés';
    }
    else
    {
        $msg = 'Ajout effectué avec echec';
    }
    header("Location: anneesScolaires.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}
?>