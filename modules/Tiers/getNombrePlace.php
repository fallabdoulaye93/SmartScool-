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
    $query = "SELECT COUNT(IDINDIVIDU) as nbrI FROM AFFECTATION_ELEVE_CLASSE where IDCLASSROOM=".$rt." AND IDANNEESSCOLAIRE=".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);

    $qnbreIns = $dbh->prepare($query);
    $qnbreIns->execute();
    $nbreIns=$qnbreIns->fetchObject();
        $query1 = "SELECT NBRE_ELEVE FROM CLASSROOM
                    WHERE IDCLASSROOM = ".$rt." AND IDETABLISSEMENT = " .$colname_rq_etablissement;
        $stmt = $dbh->prepare($query1);
        $stmt->execute();
        $nbrePlace = $stmt->fetchObject();

        if ($nbreIns->nbrI>=$nbrePlace->NBRE_ELEVE){
            $result=1;

        }else{
            $result=0;
        }

    print_r(json_encode($result));
}
