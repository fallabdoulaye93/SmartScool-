<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("../restriction.php");
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$etat=1;
if($_SESSION["id"] !=NULL){
    $etat= 0;
}

try
{
    $stmt = $dbh->prepare("INSERT INTO DISPENSER_COURS (IDCLASSROOM, IDINDIVIDU, DATE, HEUREDEBUTCOURS, HEUREFINCOURS, TITRE_COURS, CONTENUCOURS, IDSALL_DE_CLASSE, IDETABLISSEMENT, IDMATIERE, ANNEESCOLAIRE, MOIS, ETAT) 
                                     VALUES (:IDCLASSROOM, :IDINDIVIDU, :DATE, :HEUREDEBUTCOURS, :HEUREFINCOURS, :TITRE_COURS, :CONTENUCOURS, :IDSALL_DE_CLASSE, :IDETABLISSEMENT, :IDMATIERE, :ANNEESCOLAIRE, :MOIS, :ETAT)");

    $stmt->bindParam(':IDCLASSROOM', $lib->securite_xss($_POST['IDCLASSROOM']));
    $stmt->bindParam(':IDINDIVIDU', $lib->securite_xss($_POST['IDINDIVIDU']));
    $stmt->bindParam(':DATE', $lib->securite_xss($_POST['DATE']));
    $stmt->bindParam(':HEUREDEBUTCOURS', $lib->securite_xss($_POST['HEUREDEBUTCOURS']));
    $stmt->bindParam(':HEUREFINCOURS', $lib->securite_xss($_POST['HEUREFINCOURS']));
    $stmt->bindParam(':TITRE_COURS', $lib->securite_xss($_POST['TITRE_COURS']));
    $stmt->bindParam(':CONTENUCOURS', $lib->securite_xss($_POST['CONTENUCOURS']));
    $stmt->bindParam(':IDSALL_DE_CLASSE', $lib->securite_xss($_POST['IDSALL_DE_CLASSE']));
    $stmt->bindParam(':IDETABLISSEMENT', $lib->securite_xss($_POST['IDETABLISSEMENT']));
    $stmt->bindParam(':IDMATIERE', $lib->securite_xss($_POST['IDMATIERE']));
    $stmt->bindParam(':ANNEESCOLAIRE', $lib->securite_xss($_POST['ANNEESCOLAIRE']));
    $stmt->bindParam(':MOIS', $lib->securite_xss($_POST['MOIS']));
    $stmt->bindParam(':ETAT', $etat);

    $res = $stmt->execute();
    if($res == 1)
    {
        $msg = "Enregistrement nouveau cours réussi";
    }
    else
    {
        $msg = "Enregistrement nouveau cours échoué";
    }
}
catch (PDOException $e)
{
    $msg = "Enregistrement nouveau cours échoué, erreur technique";
}
$insertGoTo = "listeMajCours.php?res=".$lib->securite_xss($res) . "&msg=" . $lib->securite_xss($msg);

header(sprintf("Location: %s", $insertGoTo));