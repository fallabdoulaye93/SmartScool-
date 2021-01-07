
<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(1, $lib->securite_xss($_SESSION['profil'])));



$le_profil = $lib->securite_xss($_POST['profil']);
$lesactions = $lib->securite_xss_array($_POST['action']);
// affectation de droits au profil selectionne

$count=count($lesactions);
if($count > 0)
{
    // suppression des droits du profil selectionne
    $query="DELETE FROM affectationDroit WHERE profil=:profil";
    try
    {
        $profil = $dbh->prepare($query);
        $profil->execute(array("profil"=>$le_profil));
        $profil->execute();


        foreach($lesactions as $action)
        {

            $req = $dbh->prepare("INSERT INTO affectationDroit ( action, profil) VALUES (:action,:profil )");
            $res=$req->execute(array(
                "action" => $action	,
                "profil" =>$le_profil

            ));

        }
        if($res==1){
            $msg="Affectation de droit  effectuée avec succés. ";
            header('Location: profile.php?msg='.$lib->securite_xss($msg).'&res='.$lib->securite_xss($res));
        }
        else{
            $msg="Affectation de droit effectuée avec echec. ";
            header('Location: profile.php?msg='.$lib->securite_xss($msg).'&res='.$lib->securite_xss($res));
        }
    }
    catch(PDOException $e)
    {
        $msg="Affectation de droit effectuée avec echec. ";
        header('Location: profile.php?msg='.$lib->securite_xss($msg).'&res='.$lib->securite_xss($res));
    }
}
else{
    $msg="Affectation de droit effectuée avec echec. ";
    header('Location: profile.php?msg='.$lib->securite_xss($msg).'&res='.$lib->securite_xss($res));
}

?>