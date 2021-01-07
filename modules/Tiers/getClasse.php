<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
var_dump($_POST);exit;
if (isset($_POST) && $_POST != null) {
    $colname_rq_etablissement = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
    }
        $query = "SELECT CLASSROOM.*
                 FROM CLASSROOM
                 WHERE CLASSROOM.IDCLASSROOM NOT IN (
                    SELECT CLASSROOM.IDCLASSROOM
                    FROM CLASSROOM
                    INNER JOIN EMPLOIEDUTEMPS ON CLASSROOM.IDCLASSROOM = EMPLOIEDUTEMPS.IDCLASSROOM
                    WHERE EMPLOIEDUTEMPS.IDPERIODE = ".$lib->securite_xss("PERIODE")." AND CLASSROOM.IDETABLISSEMENT = ".$colname_rq_etablissement." AND EMPLOIEDUTEMPS.IDANNEE = ".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE'])."
                 )";


         $stmt = $dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchObject();
        var_dump($result);exit;
        if ($result>0) {
            echo json_encode($result);
        } else {
            echo json_encode(0);
        }

}
