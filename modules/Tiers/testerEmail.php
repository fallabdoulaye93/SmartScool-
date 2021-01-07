<?php

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if (isset($_POST) && $_POST != null) {

    $query = "SELECT INDIVIDU.IDINDIVIDU as id FROM INDIVIDU WHERE INDIVIDU.COURRIEL = ?" ;
    $stmt = $dbh->prepare($query);
    $stmt->execute(array($_POST['COURRIEL']));
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (count($result)>0) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}
