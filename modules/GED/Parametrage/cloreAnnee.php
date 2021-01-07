<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));

$idEtab = -1;
if (isset($_SESSION['etab'])) {
    $idEtab = $lib->securite_xss($_SESSION['etab']);
}

$idAnnee = "-1";
if (isset($_POST['IDANNEESCOLAIRE']) && $_POST['IDANNEESCOLAIRE']!="") {
    $idAnnee = intval($lib->securite_xss(base64_decode($_POST['IDANNEESCOLAIRE'])));
}


$query = $dbh->prepare("UPDATE ANNEESSCOLAIRE SET ETAT = 1 WHERE IDANNEESSCOLAIRE=".$idAnnee);
$res = $query->execute();
if ($res)
{
    $query_ = $dbh->query("SELECT DATE_DEBUT, DATE_FIN FROM ANNEESSCOLAIRE WHERE IDANNEESSCOLAIRE=".$idAnnee);
    $retour = $query_->fetchObject();
    $dateDebut = $retour->DATE_DEBUT;
    $dateFin = $retour->DATE_FIN;

    $yearDebut_ = intval(explode("-", $dateDebut)[0]) + 1;
    $yearFin_ = intval(explode("-", $dateFin)[0]) + 1;
    $newYear =  (string)$yearDebut_.'/'. (string)$yearFin_;

    $dateDebut_ = date_add(date_create($dateDebut), date_interval_create_from_date_string('1 year'));
    $dateFin_ = date_add(date_create($dateFin), date_interval_create_from_date_string('1 year'));

    $dateDebut_ = date_format($dateDebut_,"Y-m-d");
    $dateFin_ = date_format($dateFin_,"Y-m-d");
    try
    {
        $query_insert = $dbh->prepare("INSERT INTO ANNEESSCOLAIRE (LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, IDETABLISSEMENT) 
                                                 VALUES(:LIBELLE_ANNEESSOCLAIRE, :DATE_DEBUT, :DATE_FIN, :IDETABLISSEMENT)");
        $res__A = $query_insert->execute([
            'LIBELLE_ANNEESSOCLAIRE' => $newYear,
            'DATE_DEBUT' => $dateDebut_,
            'DATE_FIN' => $dateFin_,
            'IDETABLISSEMENT' => $idEtab
        ]);
        $last_id = $dbh->lastInsertId();
        if($res__A)
        {
            $query_P = $dbh->query("SELECT NOM_PERIODE, DEBUT_PERIODE, FIN_FPERIODE, IDNIVEAU FROM `PERIODE` WHERE IDANNEESSCOLAIRE=".$idAnnee);
            $retour_P = $query_P->fetchAll(PDO::FETCH_ASSOC);
            $len = sizeof($retour_P);
            foreach ($retour_P as $row => $value)
            {
                $dateD = explode(" ", $value['DEBUT_PERIODE'])[0];
                $dateF = explode(" ", $value['FIN_FPERIODE'])[0];
                $dateDebut_P = date_add(date_create($dateD), date_interval_create_from_date_string('1 year'));
                $dateFin_P = date_add(date_create($dateF), date_interval_create_from_date_string('1 year'));

                $dateDebut_P = date_format($dateDebut_P, 'Y-m-d H:i:s');
                $dateFin_P = date_format($dateFin_P, 'Y-m-d H:i:s');
                try {
                    $query_insert_periode = $dbh->prepare("INSERT INTO PERIODE (NOM_PERIODE, DEBUT_PERIODE, FIN_FPERIODE, IDANNEESSCOLAIRE, IDETABLISSEMENT, IDNIVEAU) 
                                                                      VALUES(:NOM_PERIODE, :DEBUT_PERIODE, :FIN_FPERIODE, :IDANNEESSCOLAIRE, :IDETABLISSEMENT, :IDNIVEAU)");
                    $res__ = $query_insert_periode->execute([
                        'NOM_PERIODE' => $value['NOM_PERIODE'],
                        'DEBUT_PERIODE' => $dateDebut_P,
                        'FIN_FPERIODE' => $dateFin_P,
                        'IDANNEESSCOLAIRE' => $last_id,
                        'IDETABLISSEMENT' => $idEtab,
                        'IDNIVEAU' => $value['IDNIVEAU']
                    ]);
                }catch (PDOException $e){
                    echo -2;
                }
            }
            echo 1;
        }
    }
    catch (PDOException $e){
        echo -2;
    }
}else{
    echo -1;
}

?>
