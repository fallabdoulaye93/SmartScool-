<?php

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if (isset($_POST) && isset($_GET['idProf']) && isset($_GET['idEtab'])) {
//    echo "<pre>";var_dump($_POST);exit;
    extract($_POST);
    unset($_POST);
    extract($_GET);
    unset($_GET);
    $dateMSG = gmstrftime("%Y-%m-%d")." ".gmstrftime("%T");
    $query = " INSERT INTO MESSAGERIE ( DATE_MESSAGE, MESSAGE, OBJET_MSG, IDETABLISSEMENT, IDINDIVIDU) VALUES ( '" . $dateMSG . "' , :message , :objet , " . $idEtab . " , :idInd ) ";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(":idInd", $idProf);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":objet", $objet);
    if ($stmt->execute()) {
        $query = "SELECT MAX(MESSAGERIE.IDMESSAGERIE) as idmsg FROM MESSAGERIE WHERE MESSAGERIE.IDINDIVIDU = " . $idProf;
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $idmsg = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (count($idmsg) == 1) {
            $idmsg = $idmsg[0]->idmsg + 0;
            foreach ($idclass as $oneId) {
                $oneId+=0;
                $query = "INSERT INTO MESSAGE_DESTINATAIRE ( IDDEST, IDMESSAGERIE, IDETABLISSEMENT) VALUES ( :iddest, :idmsg, :idetab )";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(":idetab", $idEtab);
                $stmt->bindParam(":idmsg", $idmsg);
                $stmt->bindParam(":iddest", $oneId);
                $stmt->execute();
            }
            header("Location:messagerie.php?msg=Votre message a été envoyé avec succes&res=1");
        } else {
            header("Location:publierDocuments.php?msg=L'envoi du message a échoué&res=-1");
        }
    } else {
        header("Location:publierDocuments.php?msg=L'envoi du message échoué&res=-1");
    }
}