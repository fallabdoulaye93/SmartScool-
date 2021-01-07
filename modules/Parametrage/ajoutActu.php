<?php
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/ActualiteManager.php");
require_once("classe/Actualite.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$niv=new ActualiteManager($dbh,'ACTUALITES');


if(isset($_POST) && $_POST !=null)
{
    $res = $niv->insert($lib->securite_xss_array($_POST));
    if($res==1)
    {
        $msg = 'Ajout effectué avec succés';
    }
    else
    {
        $msg = 'Ajout effectué avec echec';
    }
    header("Location: journalEcole.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));
}
?>