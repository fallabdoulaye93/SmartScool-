<?php
/**
 * Created by PhpStorm.
 * User: numherit-dev
 * Date: 23/02/16
 * Time: 13:01
 */

//require_once("../../../../../config/Connexion.php");
require_once("config/Connexion.php");
require_once("config/Librairie.php");

class ConnexionManager
{


    public function Connecter($login, $motpass)
    {

        $connection = new Connexion();
        $dbh = $connection->Connection();
        $lib = new Librairie();
        $query = "SELECT idUtilisateur, prenomUtilisateur, nomUtilisateur, idProfil FROM UTILISATEURS ";
        $query .= " WHERE login=" . $lib->GetSQLValueString($login, "text") . " and password=" . $lib->GetSQLValueString(md5($motpass), "text");
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $rs_user = $stmt->fetchObject();
        $total_rows = $stmt->rowCount();
        if ($total_rows > 0)
        {
            $_SESSION["id"] = $rs_user->idUtilisateur;
            $_SESSION["nom"] = $rs_user->nomUtilisateur;
            $_SESSION["prenom"] = $rs_user->prenomUtilisateur;
            $_SESSION["profil"] = $rs_user->idProfil;
            return 1;
        } else {
            return -1;

        }
    }

} 