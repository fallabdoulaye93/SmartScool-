<?php
session_start();
require_once("../restriction.php");
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$id=$_SESSION["id"];
$pass=$_GET['pass'];


if (isset($_GET['id']) && isset($_GET['pass'])) {


    $query ="SELECT MP from INDIVIDU where IDINDIVIDU = ".$id." AND MP = '".md5($pass)."'" ;
    $requete=$dbh->prepare($query);
    $requete->execute();
    $totalRows=$requete->rowCount();


    echo json_encode($totalRows);

}






