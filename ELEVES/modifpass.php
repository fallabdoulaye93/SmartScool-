<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("restriction.php");
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

$colname_id = "-1";
if (isset($_SESSION['id'])) {
  $colname_id = $lib->securite_xss($_SESSION['id']);
}

if ((isset($_POST["form1"])) && ($_POST["form1"] == "update"))
{
    $id = $lib->securite_xss($_SESSION["id"]);
    $mdp = md5($lib->securite_xss($_POST['confirm']));
    $query ="UPDATE INDIVIDU SET MP='".$mdp."' WHERE IDINDIVIDU=$id" ;
    $requete=$dbh->prepare($query);
    $requete->execute();
    $totalRows=$requete->rowCount();

    if($totalRows==1)
    {
        $urlredirectsucces = "index.php?msg=Operation effectuee avec succes";
        session_start ();
        session_unset ();
        session_destroy ();
        header("Location:$urlredirectError");
    }
    else
    {
        $urlredirectError = "modifpass.php?msg=erreur operation non effectuee";
        header("Location:$urlredirectError");
    }

}
					
?>
