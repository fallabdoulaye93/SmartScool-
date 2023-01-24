<?php

$hostname_connexion = "mysql-layefall93.alwaysdata.net";
$database_connexion = "layefall93_scool";
$username_connexion = "221763_root";
$password_connexion = "layeFALL93";

function Connection()
{
    $conn = NULL;
    try {
        $this->pdo = new PDO("mysql:host=mysql-layefall93.alwaysdata.net;dbname=layefall93_scool", "221763_root", "layeFALL93");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        return 500;
    }
}

function code_identification()
{
    // on declare une chaine de caractÃ¨res
    $chaine = "0123456789";
//nombre de caractÃ¨res dans le mot de passe
    $nb_caract = 6;
// on fait une variable contenant le futur pass
    $pass = "";
//on fait une boucle
    for ($u = 1; $u <= $nb_caract; $u++) {
//on compte le nombre de caractÃ¨res prÃ©sents dans notre chaine
        $nb = strlen($chaine);
// on choisie un nombre au hasard entre 0 et le nombre de caractÃ¨res de la chaine
        $nb = mt_rand(0, ($nb - 1));
// on ajoute la lettre a la valeur de $pass
        $pass .= $chaine[$nb];
    }
// on retourne le rÃ©sultat :
    return $pass;
}

function generer_code_barre()
{
    $LeCodebarre = "7";
    $i = 0;
    for ($i = 0; $i < 12; $i++) {
        $LeCodebarre = $LeCodebarre . rand(0, 9);
    }
    return $LeCodebarre;
}

// extraire une chaine
function extraire_chaine($chaine, $pos1, $nbre)
{
    return substr($chaine, $pos1, $nbre);
}

function VerifToken($login)
{
    $sql = "SELECT login FROM UTILISATEURS WHERE login=:login";
    $dbh = Connection();
    if ($dbh != 500) {
        try {
            $result = $dbh->prepare($sql);
            $result->bindParam(":login", $login);
            $result->execute();
            $count = count($result->fetchAll(PDO::FETCH_OBJ));
            return ($count === 1) ? 0 : 1;
            //1000 login esistant
            //1 login non existant
        } catch (PDOException $e) {
            return 403;  //Erreur requete
        }
    } else return $dbh;
}

function GetIdEntity($email = "")
{
    $sql = "SELECT IDETABLISSEMENT FROM ETABLISSEMENT WHERE MAIL=:email";
    $dbh = Connection();
    if ($dbh != 500) {
        try {
            $result = $dbh->prepare($sql);
            $result->bindParam(":email", $email);
            $result->execute();
            $count = count($result->fetchAll(PDO::FETCH_OBJ));
            return ($count === 1) ? 0 : 1;
        } catch (PDOException $e) {
            return 403;  //Erreur requete
        }
    } else return $dbh;
}

function AddEtablissement($nom_etab, $sigle, $adresse, $telephone, $ville, $pays, $email, $siteweb, $rc, $ninea, $prefixe, $logo)
{
    $dbh = Connection();
    if ($dbh != 500) {
        try {
            $query = sprintf("INSERT INTO ETABLISSEMENT (NOMETABLISSEMENT_, SIGLE, ADRESSE, TELEPHONE, VILLE, PAYS, MAIL, SITEWEB, LOGO, RC, NINEA, PREFIXE)
                                   VALUES (:NOMETABLISSEMENT,:SIGLE,:ADRESSE,:TELEPHONE,:VILLE,:PAYS,:MAIL,:SITEWEB,:LOGO,:RC,:NINEA,:PREFIXE)");
            $result = $dbh->prepare($query);
            $result->bindParam(":NOMETABLISSEMENT", $nom_etab);
            $result->bindParam(":SIGLE", $sigle);
            $result->bindParam(":ADRESSE", $adresse);
            $result->bindParam(":TELEPHONE", $telephone);
            $result->bindParam(":VILLE", $ville);
            $result->bindParam(":PAYS", $pays);
            $result->bindParam(":MAIL", $email);
            $result->bindParam(":SITEWEB", $siteweb);
            $result->bindParam(":LOGO", $logo);
            $result->bindParam(":RC", $rc);
            $result->bindParam(":NINEA", $ninea);
            $result->bindParam(":PREFIXE", $prefixe);
            $count = $result->execute();
            return ($count) ? $dbh->lastInsertId() : 0 ;
            // retourne l'identifiant de l'etablissement inseré en cas de succes
            // retourne 0 en cas d'echec
        } catch (Exception $e) {
            return $e->getMessage();//-403; //erreur requete;
        }
    } else return -500;
}

function AddUser($nom, $prenom, $adresse, $telephone, $email, $login, $pass, $entite, $prefixe)
{
    $dbh = Connection();
    if ($dbh != 500) {
        try {
            $password = md5($pass);
            $code = generer_code_barre();
            $admin = 1;
            $matricule = $prefixe . "" . extraire_chaine($code, 9, 4);

            $dateCreation = \gmstrftime("%Y-%m-%d") . " " . \gmstrftime("%T");
            $dateModification = \gmstrftime("%Y-%m-%d") . " " . \gmstrftime("%T");
            $userCreation = 0;
            $userModification = 0;

            $req = "INSERT INTO `UTILISATEURS`(`matriculeUtilisateur`, `codeUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `telephone`, `adresse`, `email`, `login`, `password`, `idEtablissement`, `idProfil`, `dateCreation`, `userCreation`, `dateModification`, `userModification`) 
                    VALUES (:matriculeUtilisateur,:codeUtilisateur,:prenomUtilisateur,:nomUtilisateur,:telephone,:adresse,:email,:login,:password,:idEtablissement,:idProfil,:dateCreation,:userCreation,:dateModification,:userModification)";
            $query = sprintf($req);
            $result = $dbh->prepare($query);
            $result->bindParam(":matriculeUtilisateur", $matricule);
            $result->bindParam(":codeUtilisateur", $code);
            $result->bindParam(":nomUtilisateur", $nom);
            $result->bindParam(":prenomUtilisateur", $prenom);
            $result->bindParam(":telephone", $telephone);
            $result->bindParam(":adresse", $adresse);
            $result->bindParam(":email", $email);
            $result->bindParam(":login", $login);
            $result->bindParam(":password", $password);
            $result->bindParam(":idEtablissement", $entite);
            $result->bindParam(":idProfil", $admin);
            $result->bindParam(":dateCreation", $dateCreation);
            $result->bindParam(":userCreation", $userCreation);
            $result->bindParam(":dateModification", $dateModification);
            $result->bindParam(":userModification", $userModification);
            $count = $result->execute();
            //if($count) envoiLogin($email, $prenom." ".$nom);
            return ($count) ? 1 : 0;
            // 1 - Insertion succes
            // 0 - Insertion echec
        } catch (Exception $e) {
            return 403; //erreur requete;
        }
    } else return $dbh;
}

function UpdatePassUser($login, $pass)
{
    $dbh = Connection();
    if ($dbh != 500) {
        try {
            $password = md5($pass);

            $req = "UPDATE `UTILISATEURS` SET `password` =:password WHERE `login` =:login";
            $query = sprintf($req);
            $result = $dbh->prepare($query);
            $result->bindParam(":login", $login);
            $result->bindParam(":password", $password);
            $count = $result->execute();
            return ($count) ? 1 : 0;
            // 1 - Insertion succes
            // 0 - Insertion echec
        } catch (Exception $e) {
            return 403; //erreur requete;
        }
    } else return $dbh;
}

function ConnectUser($email, $pass)
{
    $dbh = Connection();
    if ($dbh != 500) {
        try {
            $password = md5($pass);

            $req = "SELECT idUtilisateur as id, prenomUtilisateur as prenom, nomUtilisateur as nom, idProfil as profil, UTILISATEURS.idEtablissement as etab, ETABLISSEMENT.PREFIXE,ETABLISSEMENT.LOGO, ETABLISSEMENT.NOMETABLISSEMENT_ as nomEtablissement, MAX(ANNEESSCOLAIRE.IDANNEESSCOLAIRE) as ANNEESSCOLAIRE
                    FROM UTILISATEURS
                    INNER JOIN ETABLISSEMENT ON UTILISATEURS.idEtablissement = ETABLISSEMENT.IDETABLISSEMENT
                    INNER JOIN ANNEESSCOLAIRE ON UTILISATEURS.idEtablissement = ANNEESSCOLAIRE.IDETABLISSEMENT
                    WHERE UTILISATEURS.email = :email AND UTILISATEURS.password = :password";
            $query = sprintf($req);
            $result = $dbh->prepare($query);
            $result->bindParam(":email", $email);
            $result->bindParam(":password", $password);
            $count = $result->execute();
//            return $count->fetchAll(PDO::FETCH_ASSOC); // retourne les infos du clients
            return 1;
        } catch (Exception $e) {
            return 403; //erreur requete;
        }
    } else return $dbh;
}

function envoiLogin($destinataire, $prenom)
{
    $sujet = "Creation compte sunuEcole"; //Sujet du mail
    $de_mail = "no-reply@sunuEcole.com";
    $vers_nom = $prenom;
    $vers_mail = $destinataire;
    $message = "<table width='550px' border='0'>";
    $message .= "<tr>";
    $message .= "<td> Cher " . $vers_nom . ", </td>";
    $message .= "</tr>";
    $message .= "<tr>";
    $message .= "<td align='left' valign='top'><p>Votre Souscription à l'application sunuEcole vient d'&ecirc;tre validée.<br />";
    $message .= "Vous pourrez d&eacute;sormais vous connecter au portail en cliquant sur le lien suivant.<br />";
    $message .= "<a target='_blank' href='https://www.samaecole-labs.com/sunucloud/client/launchApp/5'>Cliquer sur ce lien pour acc&eacute;der &aacute; votre compte.</a>";
    $message .= "<br />";
    $message .= "</p></td>";
    $message .= "</tr>";
    $message .= "</table>";
    /** Envoi du mail **/
    $entete = "Content-type: text/html; charset=utf8\r\n";
    $entete .= "To: $vers_nom<$vers_mail> \r\n";
    $entete .= "From:sunuEcole <no-reply@sunuEcole.com>\r\n";
    mail($destinataire, $sujet, $message, $entete);
}
