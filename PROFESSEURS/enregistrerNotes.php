<?php

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if (isset($_POST) && isset($_GET['IDCONTROLE']) && isset($_GET['IDETAB']) && isset($_GET['IDCLASS']) && isset($_GET['ETAT'])) {
    $tabNotes = explode(",", $_POST['tabNote']);

    if ($_GET['ETAT'] == "UPDATE") {
        foreach ($tabNotes as $oneNote) {
            $oneNote = explode("-",$oneNote);
            $query = "UPDATE NOTE SET NOTE = ".$oneNote[2]." WHERE NOTE.IDNOTE = ".$oneNote[1];
            $stmt = $dbh->prepare($query);
            $stmt->execute();
        }
        echo json_encode(1);
    } elseif ($_GET['ETAT'] == "INSERT") {

        $query = "SELECT INDIVIDU.IDINDIVIDU as id
              FROM INDIVIDU
              INNER JOIN AFFECTATION_ELEVE_CLASSE ON INDIVIDU.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
              INNER JOIN CLASSROOM ON AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM
              WHERE CLASSROOM.IDCLASSROOM = " . $_GET['IDCLASS'];

        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $tabElev = $stmt->fetchAll(PDO::FETCH_OBJ);

        $idCont = $_GET['IDCONTROLE'];
        $idEat = $_GET['IDETAB'];

        foreach ($tabElev as $oneElev) {
            $note = 0;
            foreach ($tabNotes as $oneNote) {
                $oneNote = explode("-",$oneNote);
                if ($oneElev->id == $oneNote[0]) {
                    $note = $oneNote[1];
                    break;
                }
            }
            $query = "INSERT INTO NOTE (NOTE,IDCONTROLE,IDINDIVIDU,IDETABLISSEMENT) VALUES ( $note, $idCont, $oneElev->id , $idEat )";
            $stmt = $dbh->prepare($query);
            $stmt->execute();
        }
        echo json_encode(1);
    }
}