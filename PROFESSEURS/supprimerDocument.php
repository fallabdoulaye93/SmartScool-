<?php

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if (isset($_GET['idDoc']) && isset($_GET['idAff']) && isset($_GET['nomFichier'])) {
    extract($_GET);
    unset($_GET);
    $query = "DELETE FROM affecter_doc WHERE affecter_doc.idaff =" . $idAff ;
    $stmt = $dbh->prepare($query);
    if ($stmt->execute()) {
        header("Location:publierDocuments.php?msg=Document supprimé avec succes&res=1");
    } else {
        header("Location:publierDocuments.php?msg=Votre suppression du document a échouée&res=-1");
    }
}