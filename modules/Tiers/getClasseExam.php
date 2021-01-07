<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
//var_dump(explode("_",$_POST['idclasse']));exit;
if (isset($_POST) && $_POST != null) {
    $colname_rq_etablissement = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
    }

         $rt=$lib->securite_xss($_POST['idclasse']);

        $query1 = "SELECT EXAMEN FROM CLASSROOM
                    WHERE IDCLASSROOM = ".$rt." AND IDETABLISSEMENT = " .$colname_rq_etablissement;
        $stmt = $dbh->prepare($query1);
        $stmt->execute();
        $classeExam = $stmt->fetchObject();
        $result=$classeExam->EXAMEN;
    
        print_r(json_encode($result));
}
