<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
if (isset($_POST) && $_POST != null) {
    $colname_rq_etablissement = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
    }
    $chapit = explode("_",$lib->securite_xss($_POST['MOIS']));

    try
    {
        $query_rq_montant = $dbh->query("SELECT DISPENSER_COURS.HEUREDEBUTCOURS, DISPENSER_COURS.HEUREFINCOURS, RECRUTE_PROF.VOLUME_HORAIRE, 
                                              RECRUTE_PROF.TARIF_HORAIRE, FK_FORFAIT, FORFAIT_PROFESSEUR.MONTANT as MONTANTF 
                                              FROM RECRUTE_PROF 
                                              INNER JOIN DISPENSER_COURS ON DISPENSER_COURS.IDINDIVIDU = RECRUTE_PROF.IDINDIVIDU
                                              LEFT JOIN FORFAIT_PROFESSEUR ON FORFAIT_PROFESSEUR.ROWID = RECRUTE_PROF.FK_FORFAIT
                                              WHERE DISPENSER_COURS.IDINDIVIDU = " .$chapit[1]. "  
                                              AND DISPENSER_COURS.IDMATIERE = ".$chapit[2]." 
                                              AND DISPENSER_COURS.MOIS = '".$chapit[0]."'");
        $rs_montant = $query_rq_montant->fetchAll();
    }
    catch (PDOException $e)
    {
        echo -2;
    }

  if($query_rq_montant->rowCount()>0)
  {
        foreach ($rs_montant as $row_rq_montant)
        {
            $diffe =round($row_rq_montant['HEUREFINCOURS'] - $row_rq_montant['HEUREDEBUTCOURS'],2);
            $temp_heure = $temp_heure + $diffe;
            if($row_rq_montant['FK_FORFAIT']!=0)
            {
                $result=$row_rq_montant['MONTANTF'];
            }
            else
            {
                $result = ($temp_heure * $row_rq_montant['TARIF_HORAIRE']);
            }
      }
  }
  else
  {
       $result=0;
  }
  print_r(json_encode($result));
}
?>



