<?php

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");

class ConnexionManager
{


    public function Connecter()
    {
        $connection = new Connexion();
        $dbh = $connection->Connection();
        $lib = new Librairie();
        // IDINDIVIDU 	MATRICULE 	NOM 	PRENOMS 	DATNAISSANCE 	ADRES 	TELMOBILE 	TELDOM 	COURRIEL 	LOGIN 	MP 	CODE 	BIOGRAPHIE 	PHOTO_FACE 	IDETABLISSEMENT 	IDTYPEINDIVIDU 	SEXE 	IDTUTEUR 	ANNEEBAC 	NATIONNALITE 	SIT_MATRIMONIAL 	NUMID
        $query = "SELECT IDINDIVIDU, MATRICULE, NOM, PRENOMS, IDTYPEINDIVIDU,  INDIVIDU.IDETABLISSEMENT, ETABLISSEMENT.PREFIXE,ETABLISSEMENT.LOGO, ETABLISSEMENT.NOMETABLISSEMENT_ FROM INDIVIDU, ETABLISSEMENT ";
        $query .= " WHERE ETABLISSEMENT.IDETABLISSEMENT= INDIVIDU.IDETABLISSEMENT AND INDIVIDU.IDTYPEINDIVIDU = 7 AND LOGIN=" . $lib->GetSQLValueString($_POST['login'], "text") . " and MP=" . $lib->GetSQLValueString(md5($_POST['password']), "text");
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $rs_user = $stmt->fetchObject();
        $total_rows = $stmt->rowCount();
        if ($total_rows > 0) {

            $_SESSION["id"] = $rs_user->IDINDIVIDU;
            $_SESSION["nom"] = $rs_user->NOM;
            $_SESSION["prenom"] = $rs_user->PRENOMS;
            $_SESSION["profil"] = $rs_user->IDTYPEINDIVIDU;
            return 1;

        } else {
            return -1;

        }
    }

} 