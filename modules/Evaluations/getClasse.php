<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();



if (isset($_POST) && $_POST != null)
{
    $colname_rq_etablissement = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
    }
    $annee_scolaire = "-1";
    if (isset($_SESSION['ANNEESSCOLAIRE']))
    {
        $annee_scolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
    }
    $individu = $lib->securite_xss($_POST['PROF']);
    $niveau = $lib->securite_xss($_POST['NIVEAU']);

    $query = "SELECT R.IDRECRUTE_PROF, CL.IDCLASSROOM, CL.LIBELLE 
              FROM RECRUTE_PROF R
              INNER JOIN CLASSE_ENSEIGNE CE ON R.IDRECRUTE_PROF=CE.IDRECRUTE_PROF
              INNER JOIN CLASSROOM CL ON CE.IDCLASSROM=CL.IDCLASSROOM
              INNER JOIN AFFECTATION_ELEVE_CLASSE AF ON AF.IDCLASSROOM=CE.IDCLASSROM
              WHERE R.IDINDIVIDU = ".$individu." 
              AND R.IDANNEESSCOLAIRE = ".$annee_scolaire." 
              AND CL.IDNIV = ".$niveau."
              AND CL.IDETABLISSEMENT = ".$colname_rq_etablissement."
              AND R.IDRECRUTE_PROF = CE.IDRECRUTE_PROF 
              AND CE.IDCLASSROM = CL.IDCLASSROOM 
              GROUP BY CL.IDCLASSROOM";



    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if(count($result)==0){
        print_r(-2);
    }else{
        print_r(json_encode($result));

    }

}