<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$id = $lib->securite_xss($_SESSION["id"]);
$pass = $lib->securite_xss($_GET['pass']);


if (isset($_GET['id']) && isset($_GET['pass'])) {


    $query ="SELECT password FROM UTILISATEURS  WHERE idUtilisateur = ".$id." AND password = '".md5($pass)."'" ;
    $requete=$dbh->prepare($query);
    $requete->execute();
    $totalRows=$requete->rowCount();


    echo json_encode($totalRows);

}






