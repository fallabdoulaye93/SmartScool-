<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
//var_dump($_POST);exit;
if (isset($_POST) && $_POST != null) {
    $colname_rq_etablissement = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
    }
        $query = "SELECT a.IDINDIVIDU,i.MATRICULE,i.PRENOMS,i.NOM
                                                FROM AFFECTATION_ELEVE_CLASSE a
                                                INNER JOIN INDIVIDU i ON a.IDINDIVIDU = i.IDINDIVIDU
                                                INNER JOIN CLASSROOM c ON a.IDCLASSROOM = c.IDCLASSROOM
                                                INNER JOIN ANNEESSCOLAIRE an ON an.IDANNEESSCOLAIRE = a.IDANNEESSCOLAIRE
                                                INNER JOIN INSCRIPTION ins ON i.IDINDIVIDU = ins.IDINDIVIDU    
                                                WHERE an.ETAT = 0 
                                                AND c.IDCLASSROOM = ".$lib->securite_xss($_POST['CLASSE'])."
                                                AND i.IDETABLISSEMENT = " .$colname_rq_etablissement."
                                                AND ins.ETAT = 1 
                                                AND i.TELMOBILE!=''";
        $stmt = $dbh->prepare($query);
      // var_dump($stmt);exit;
        $stmt->execute();
        $result = $stmt->fetchAll();
         print_r(json_encode($result));

}
