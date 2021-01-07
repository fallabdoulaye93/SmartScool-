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
    $etablissement = "-1";
    if(isset($_SESSION['etab']))
    {
        $etablissement = $lib->securite_xss($_SESSION['etab']);
    }
    $rq_anne = "-1";
    if(isset($_SESSION['ANNEESSCOLAIRE']))
    {
        $rq_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
    }

    $chapit = explode("_",$lib->securite_xss($_POST['MOIS']));
    try
    {
        $sql = $dbh->query("SELECT IDREGLEMENT, MOIS 
                                      FROM REGLEMENT_PROF 
                                      WHERE MOIS = '".$chapit[0]."'
                                      AND INDIVIDU = ".$chapit[1]."
                                      AND IDETABLISSEMENT = ".$etablissement." 
                                      AND IDANNEESCOLAIRE = ".$rq_anne."");
        $rs_montant = $sql->fetchObject();
        if($sql->rowCount()>0)
        {
            $result = 1;
        }
        else
        {
            $result=0;
        }
    }
    catch (PDOException $e)
    {
        $result = -2;
    }
    print_r(json_encode($result));
}
?>



