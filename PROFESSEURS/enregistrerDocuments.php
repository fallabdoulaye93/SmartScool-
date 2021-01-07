<?php

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if (isset($_POST) && isset($_FILES) && isset($_GET['idProf']) && isset($_GET['idEtab'])) {
    extract($lib->securite_xss_array($_POST));
    unset($_POST);
    extract($lib->securite_xss_array($_GET));
    unset($_GET);
    $extFile = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
    $dateDoc = gmstrftime("%Y-%m-%d")." ".gmstrftime("%T");
    $nomFichier = $idProf . "-" . $dateDoc . "." . $extFile;
    $libelle = $lib->GetSQLValueString($libelle, "text");
    $query = " INSERT INTO document_prof (nomdoc,libelle,nom_fichier,idprof,idetab,datedoc) VALUES ( '" . $nomdoc . "' ," . $libelle . " , '" . $nomFichier . "' , " . $idProf . " , " . $idEtab . " , :dat ) ";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(":dat", $dateDoc);
    if ($stmt->execute()) {
        $query = "SELECT MAX(document_prof.iddoc) as iddoc FROM document_prof WHERE document_prof.idprof = " . $idProf;
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $iddoc = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (count($iddoc) == 1) {
            $iddoc = $iddoc[0]->iddoc + 0;
            foreach ($idclass as $oneId) {
                $oneId+=0;
                $query = "INSERT INTO affecter_doc (iddoc, idclasse, idetab) VALUES ( :iddoc, :idclass, :idtab )";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(":idtab", $idEtab);
                $stmt->bindParam(":idclass", $oneId);
                $stmt->bindParam(":iddoc", $iddoc);
                $stmt->execute();
            }

            $a=move_uploaded_file($_FILES['document']['tmp_name'], "../document/" . $nomFichier);

            header("Location:publierDocuments.php?msg=Document ajouté avec succes&res=1");

        } else {
            header("Location:publierDocuments.php?msg=Votre ajout du document a échoué&res=-1");
        }
    } else {
        header("Location:publierDocuments.php?msg=Votre ajout du document a échoué&res=-1");
    }
}