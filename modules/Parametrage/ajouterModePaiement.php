<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
/*require_once("classe/ModepaiementManager.php");
require_once("classe/Modepaiement.php");*/

$connection =  new Connexion();
$dbh = $connection->Connection();

$lib=new Librairie();

    //$niv=new ModepaiementManager($dbh,'MODE_PAIEMENT');
    $libelle = $lib->securite_xss($_POST['TEST']);
    $nb_mois = $lib->securite_xss($_POST['NBRE_MOIS']);
    $etat = 1;
    $etablissement = $lib->securite_xss($_POST['IDETABLISSEMENT']);
if(isset($_POST) && $_POST !=null)
{
    $res = 0;
    try
    {
        $sql = "INSERT INTO MODE_PAIEMENT (LIBELLE, NBRE_MOIS, ETAT, IDETABLISSEMENT) VALUES (?,?,?,?)";
        $stmt= $dbh->prepare($sql);
        $res =  $stmt->execute([$libelle, $nb_mois, $etat, $etablissement]);
        if($res==1)
        {
            $msg = 'Ajout effectué avec succés';
        }
        else
        {
            $msg = 'Ajout non effectué echec';
        }
    }
    catch (PDOException $e)
    {
        $res = -2;
        $msg = 'Ajout non effectué echec';
    }
    header("Location: modePaiement.php?msg=".$lib->securite_xss($msg)."&res=".$lib->securite_xss($res));

}

?>