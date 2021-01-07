<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(20, $lib->securite_xss($_SESSION['profil'])));

if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}
if(isset($_GET['IDCONTROLE'])){
    $colname_rq_controle = $lib->securite_xss(base64_decode($_GET['IDCONTROLE']));
}

if(isset($_POST['modif']) && $_POST['modif']!= "")
{

    if ((isset($_POST["DATEDEBUT"])) && ($_POST["DATEDEBUT"] != ""))
    {
        $modif = $lib->securite_xss(base64_decode($_POST['modif']));
        if($modif == 0)
        {
            $stmt = $dbh->prepare("INSERT INTO CONTROLE (LIBELLE_CONTROLE, DATEDEBUT, DATEFIN, IDCLASSROOM, IDMATIERE, IDETABLISSEMENT, IDINDIVIDU, IDTYP_CONTROL, NOTER, IDPERIODE,VALIDER,IDANNEE,FK_NIVEAU) 
                                             VALUES (:LIBELLE_CONTROLE, :DATEDEBUT, :DATEFIN, :IDCLASSROOM, :IDMATIERE, :IDETABLISSEMENT, :IDINDIVIDU, :IDTYP_CONTROL, :NOTER, :IDPERIODE, :VALIDER, :IDANNEE, :FK_NIVEAU)");
        }
        else {
            $stmt = $dbh->prepare("UPDATE CONTROLE SET LIBELLE_CONTROLE=:LIBELLE_CONTROLE, DATEDEBUT=:DATEDEBUT, DATEFIN=:DATEFIN, 
                                            IDCLASSROOM=:IDCLASSROOM, FK_NIVEAU=:FK_NIVEAU, IDMATIERE=:IDMATIERE, IDETABLISSEMENT=:IDETABLISSEMENT, IDINDIVIDU=:IDINDIVIDU, 
                                            IDTYP_CONTROL=:IDTYP_CONTROL, NOTER=:NOTER, IDPERIODE=:IDPERIODE,VALIDER=:VALIDER,IDANNEE=:IDANNEE 
                                            WHERE IDCONTROLE=:IDCONTROLE");

            $stmt->bindParam(':IDCONTROLE', $lib->securite_xss(base64_decode($_POST['IDCONTROLE'])));
        }
        $stmt->bindParam(':LIBELLE_CONTROLE', $lib->securite_xss($_POST['LIBELLE_CONTROLE']));
        $stmt->bindParam(':DATEDEBUT', $lib->securite_xss($_POST['DATEDEBUT']));
        $stmt->bindParam(':DATEFIN', $lib->securite_xss($_POST['DATEFIN']));
        $stmt->bindParam(':IDCLASSROOM', $lib->securite_xss($_POST['IDCLASSROOM']));
        $stmt->bindParam(':FK_NIVEAU', $lib->securite_xss($_POST['nivclass']));
        $stmt->bindParam(':IDMATIERE', $lib->securite_xss($_POST['IDMATIERE']));
        $stmt->bindParam(':IDETABLISSEMENT', $lib->securite_xss(base64_decode($_POST['IDETABLISSEMENT'])));
        $stmt->bindParam(':IDINDIVIDU', $lib->securite_xss($_POST['IDINDIVIDU']));
        $stmt->bindParam(':IDTYP_CONTROL', $lib->securite_xss($_POST['IDTYP_CONTROL']));
        $stmt->bindParam(':NOTER', $lib->securite_xss($_POST['NOTER']));
        $stmt->bindParam(':IDPERIODE', $lib->securite_xss($_POST['IDPERIODE']));
        $stmt->bindParam(':VALIDER', $lib->securite_xss($_POST['VALIDER']));
        $stmt->bindParam(':IDANNEE', $annee);
        $res = $stmt->execute();
        if ($res == 1)
        {
            $msg = "Contrôle créé avec succes";
        }
        else {
            $msg = "Votre création de contrôle a echouée";
        }
        header("Location: gestionControle.php?res=" . $lib->securite_xss($res) . "&msg=" . $lib->securite_xss($msg));
    }

}


?>