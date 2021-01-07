<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
$colname_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}
if (isset($_POST['classe']) && $lib->securite_xss($_POST['classe'])!="")
{
    $colname_rq_individu.= " AND a.IDCLASSROOM ='".$lib->securite_xss($_POST['classe'])."'";
    if (isset($_POST['matricule']) && $lib->securite_xss($_POST['matricule'])!=""){
        $colname_rq_individu=" AND i.MATRICULE ='".$lib->securite_xss($_POST['matricule'])."'";
    }

    try
    {
    $query_rq_individu = $dbh->query("SELECT a.IDCLASSROOM, a.IDINDIVIDU, i.MATRICULE, i.NOM, 
                                                i.PRENOMS, i.TELMOBILE,i.COURRIEL, i.IDINDIVIDU, i.PHOTO_FACE, c.LIBELLE AS LIBCLASSE 
                                                FROM AFFECTATION_ELEVE_CLASSE a
                                                INNER JOIN INDIVIDU i ON a.IDINDIVIDU = i.IDINDIVIDU
                                                INNER JOIN CLASSROOM c ON a.IDCLASSROOM = c.IDCLASSROOM
                                                INNER JOIN ANNEESSCOLAIRE an ON an.IDANNEESSCOLAIRE = a.IDANNEESSCOLAIRE
                                                INNER JOIN INSCRIPTION ins ON i.IDINDIVIDU = ins.IDINDIVIDU    
                                                WHERE an.ETAT = 0 
                                                AND ins.IDANNEESSCOLAIRE = ".$colname_anne."
                                                AND ins.ETAT = 1 ".$colname_rq_individu."
                                                AND i.TELMOBILE!=''");

           $rs_indi = $query_rq_individu->fetchAll();
           foreach ($rs_indi as $individu)
           {
             $lib->envoiLoginEleve($individu['COURRIEL'], $individu['PRENOMS'] . " " . $individu['NOM'], $individu['TELMOBILE'], $lib->securite_xss($_POST['message']));
             $lib->sendSMS('CEMAD', $individu['TELMOBILE'], $lib->securite_xss($_POST['message']));


           }
        $res=1;
        $msg = "SMS envoyé avec succès";
        $urlredirect = "smsEleves.php?msg=$msg&res=$res";
        header("Location:$urlredirect");

    }
    catch (PDOException $e)
    {
        echo -2;
    }
}



