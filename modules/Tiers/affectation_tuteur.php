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

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(43, $_SESSION['profil']));


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = intval($_SESSION['etab']);
}
try
{
        $insertSQL = sprintf("INSERT INTO PARENT (idParent, ideleve) VALUES (%s, %s)",
                                    $lib->GetSQLValueString(base64_decode($_GET['TUTEUR']), "int"),
                                    $lib->GetSQLValueString(base64_decode($_GET['ETUDIANT']), "int"));

        $Result1 = $dbh->query($insertSQL);
        $insertGoTo = "detailTuteur.php?IDTUTEUR=".$lib->securite_xss($_GET['TUTEUR']);
        header(sprintf("Location: %s", $insertGoTo));
}
catch (PDOException $e)
{
    $insertGoTo = "detailTuteur.php?IDTUTEUR=".$lib->securite_xss($_GET['TUTEUR']);
    header(sprintf("Location: %s", $insertGoTo));
}

?>