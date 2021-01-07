<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../restriction.php");


require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

/*if($_SESSION['profil']!=1)
$lib->Restreindre($lib->Est_autoriser(43,$_SESSION['profil']));*/




$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $_SESSION['etab'];
}

if ((isset($_GET['ideleve'])) && ($_GET['ideleve'] != "")) {
  $deleteSQL = sprintf("DELETE FROM PARENT WHERE ideleve=%s",
                       $lib->GetSQLValueString($_GET['ideleve'], "int"));

 
  $Result1 = $dbh->query($deleteSQL);

  $deleteGoTo = "detailTuteur.php?IDTUTEUR=".$_GET['idparent'];
 
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_rq_tuteur = "-1";
if (isset($_GET['idparent'])) {
  $colname_rq_tuteur = $_GET['idparent'];
}
$colname2_rq_tuteur = "-1";
if (isset($_GET['ideleve'])) {
  $colname2_rq_tuteur = $_GET['ideleve'];
}

$query_rq_tuteur = sprintf("SELECT * FROM PARENT WHERE PARENT.idParent=%s  AND PARENT.ideleve=%s", $lib->GetSQLValueString($colname_rq_tuteur, "int"),$lib->GetSQLValueString($colname2_rq_tuteur, "int"));
$rq_tuteur = $dbh->query($query_rq_tuteur);





?>