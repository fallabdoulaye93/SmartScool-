<?php
session_start();
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(25, $lib->securite_xss($_SESSION['profil'])));

$colname_annee_scolaire = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_annee_scolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

function insertBulletin($bu, $de, $dbh, $id, $idclass, $mois, $idyear, $idetab, $niveau)
{
    try
    {
        $sql = "INSERT INTO BULLETIN (TOTAL_COEF, TOTAL_POINT, MOYENNE_SEM, RANG, IDINDIVIDU, IDCLASSROOM, MOIS, IDANNEE, IDETABLISSEMENT) 
                VALUES (:TOTAL_COEF, :TOTAL_POINT, :MOYENNE_SEM, :RANG, :IDINDIVIDU, :IDCLASSROOM, :MOIS, :IDANNEE, :IDETABLISSEMENT)";

        $query_SQL = $dbh->prepare($sql);
        $query_SQL->bindParam(":TOTAL_COEF", $bu["Total_Coef"]);
        $query_SQL->bindParam(":TOTAL_POINT", $bu["Total_Point"]);
        $query_SQL->bindParam(":MOYENNE_SEM", $bu["Moyen_Gen"]);
        $query_SQL->bindParam(":RANG", $bu["rang"]);
        $query_SQL->bindParam(":IDINDIVIDU", $id);
        $query_SQL->bindParam(":IDCLASSROOM", $idclass);
        $query_SQL->bindParam(":MOIS", $mois);
        $query_SQL->bindParam(":IDANNEE", $idyear);
        $query_SQL->bindParam(":IDETABLISSEMENT", $idetab);
        $query_SQL->execute();

        $last_id = $dbh->lastInsertId();
    }
    catch (PDOException $e)
    {
        echo -2;
    }
    if($last_id > 0) {
        try
        {
            $sql_de = "INSERT INTO DETAIL_BULLETIN (FK_BULLETIN, MATIERE, COEF, MOY_CONTROLE) 
                                VALUES (:FK_BULLETIN, :MATIERE, :COEF, :MOY_CONTROLE)";

            foreach ($de as $kk => $detail){
                $query_SQL_de = $dbh->prepare($sql_de);
                $query_SQL_de->bindParam(":FK_BULLETIN",$last_id);
                $query_SQL_de->bindParam(":MATIERE",$kk);
                $query_SQL_de->bindParam(":COEF",$detail['Coeff']);
                $query_SQL_de->bindParam(":MOY_CONTROLE",$detail['Moy_Cont']);
                $query_SQL_de->execute();
            }
        }
        catch (PDOException $e){
            echo -2;
        }
    }
    return $last_id;
}


if ($_POST) {
    $res = 0;
    $msg = "";
    $classeNiveau = trim($lib->securite_xss($_POST['IDNIVEAU']));
    $mois = trim($lib->securite_xss($_POST['MOIS']));
    $Classe = trim($lib->securite_xss($_POST['Classe']));

    $query = $dbh->query("SELECT IDINDIVIDU FROM AFFECTATION_ELEVE_CLASSE WHERE IDCLASSROOM = ".$Classe);

    $qq = $dbh->query("SELECT LIBELLE FROM CLASSROOM WHERE IDCLASSROOM ='".$Classe."'");
    $qq_r= $qq->fetchObject();


    $mois_d = explode('-',$mois);
    $le_mois = $mois_d[0];
    $le_an = $mois_d[1];



    $greatQuery = $dbh->query("SELECT CONTROLE.IDMATIERE
                                        FROM CONTROLE
                                        INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM = CONTROLE.IDCLASSROOM
                                        WHERE CONTROLE.VALIDER = 1 
                                        AND (CONTROLE.IDTYP_CONTROL = 1)  
                                        AND MONTH(CONTROLE.DATEDEBUT) = '".$le_mois."'
                                        AND MONTH(CONTROLE.DATEFIN) = '".$le_mois."'
                                        AND YEAR(CONTROLE.DATEDEBUT) = '".$le_an."'
                                        AND YEAR(CONTROLE.DATEFIN) = '".$le_an."'
                                        AND CLASSROOM.IDNIVEAU = '".$classeNiveau."' 
                                        AND CONTROLE.IDCLASSROOM = '".$Classe."' ");



    $matieres = array();
    $matieres_id = array();

    while ($matiere = $greatQuery->fetchObject()){
        $matieres[] = $matiere;
    }

    for ($i=0;$i<count($matieres);$i++){
        $matieres_id[]=$matieres[$i]->IDMATIERE;
    }
    $matieres_id = array_values(array_unique($matieres_id));

    $info_gene = array();
    $info_gene_rank = array();
    $info_gene_rank_ok = array();

     if($query->rowCount() > 0)
     {
        foreach ($query->fetchAll() as $query_indiv)
        {
            $total_coef = 0;
            $total_base = 0;
            $total_point = 0;
            $moyen_Se = 0;
            $info_mat = array();
            $info_indiv = array();

            $info_bul = array();
            $info_det = array();
            $all = array();
            $all_compo = array();
            $rr_ = array();
            $rr_compo = array();

            $query_info = $dbh->query("SELECT MATRICULE, NOM, PRENOMS, DATNAISSANCE FROM INDIVIDU WHERE IDINDIVIDU=".$query_indiv['IDINDIVIDU']);
            $query_info_ = $query_info->fetchObject();

                for ($i=0; $i<count($matieres_id); $i++)
                {
                    $controle = "";
                    $q=$dbh->query("SELECT IDCONTROLE 
                                              FROM CONTROLE 
                                              WHERE IDCLASSROOM = ".$Classe." 
                                              AND IDMATIERE = ".$matieres_id[$i]." 
                                              AND IDTYP_CONTROL = 1 
                                              AND MONTH(CONTROLE.DATEDEBUT) = '".$le_mois."'
                                              AND MONTH(CONTROLE.DATEFIN) = '".$le_mois."'
                                              AND YEAR(CONTROLE.DATEDEBUT) = '".$le_an."'
                                              AND YEAR(CONTROLE.DATEFIN) = '".$le_an."'" );
                    while ($res = $q->fetchObject()){
                        $controle .= $res->IDCONTROLE.',';
                    }

                    $controle = substr_replace($controle ,"", -1);
                    $controle = "(".$controle.")";

                    $Q=$dbh->query("SELECT SUM(NOTE)/ COUNT(NOTE.IDCONTROLE) AS MOYENNE_continue, CONTROLE.IDMATIERE, MATIERE.LIBELLE ,NOTE.IDINDIVIDU 
                                              FROM NOTE 
                                              INNER JOIN CONTROLE ON CONTROLE.IDCONTROLE = NOTE.IDCONTROLE 
                                              INNER JOIN MATIERE ON CONTROLE.IDMATIERE = MATIERE.IDMATIERE 
                                              WHERE NOTE.IDCONTROLE IN".$controle." 
                                              AND NOTE.IDINDIVIDU='".$query_indiv['IDINDIVIDU']."' 
                                              GROUP BY NOTE.IDINDIVIDU");
                    while ($qq = $Q->fetchObject()){
                        $all[]=$qq;
                    }
                    $Query_ = $dbh->query("SELECT DISTINCT COEFFICIENT.COEFFICIENT 
                                                     FROM COEFFICIENT 
                                                     INNER JOIN CLASSROOM ON CLASSROOM.IDSERIE = COEFFICIENT.IDSERIE
                                                     INNER JOIN NIVEAU ON NIVEAU.IDNIVEAU = COEFFICIENT.IDNIVEAU
                                                     INNER JOIN MATIERE ON MATIERE.IDMATIERE = COEFFICIENT.IDMATIERE 
                                                     INNER JOIN CONTROLE ON COEFFICIENT.IDMATIERE = CONTROLE.IDMATIERE 
                                                     WHERE CLASSROOM.IDCLASSROOM = '".$Classe."'
                                                     AND CONTROLE.IDTYP_CONTROL = 1  
                                                     AND CONTROLE.VALIDER = 1 
                                                     AND COEFFICIENT.IDMATIERE =".$matieres_id[$i]." 
                                                     AND MONTH(CONTROLE.DATEDEBUT) = '".$le_mois."'
                                                     AND MONTH(CONTROLE.DATEFIN) = '".$le_mois."'
                                                     AND YEAR(CONTROLE.DATEDEBUT) = '".$le_an."'
                                                     AND YEAR(CONTROLE.DATEFIN) = '".$le_an."'" );
                    $rr_[] = $Query_->fetchObject();

                }
                for ($i=0; $i<count($all); $i++){
                    $total_coef += $rr_[$i]->COEFFICIENT;
                    $moyen = $all[$i]->MOYENNE_continue;
                    $total_point += ($rr_[$i]->COEFFICIENT * $moyen);

                    $idMat = array();
                    $idMat["Coeff"] = $rr_[$i]->COEFFICIENT;
                    $idMat["Moy_Cont"] = number_format((float)$all[$i]->MOYENNE_continue, 2, '.', '');
                    $idMat["Moy_Sem"] = number_format((float)$moyen, 2, '.', '');

                    $idBu = array();
                    $idBu["Total_Coef"] = $total_coef;
                    $idBu["Total_Point"] = number_format((float)$total_point, 2, '.', '');
                    $moyen_Se = $total_point / $total_coef;
                    $moyen_Se = number_format((float)$moyen_Se, 2, '.', '');
                    $idBu["Moyen_Gen"] = $moyen_Se;

                    $info_mat[$all[$i]->IDMATIERE] = $idMat;
                }

            $info_indiv["Detail"]=$info_mat;
            $info_indiv["Bulletin"]=$idBu;

            $info_gene[$query_indiv['IDINDIVIDU']] = $info_indiv;

            $total_coef = 0;
            $total_point = 0;
            $total_base=0;
            $moyen_Se = 0;

        }

         foreach ($info_gene as $idIndiv => $types){
             foreach ($types as $type => $typeName){
                 if($type == "Bulletin"){
                     foreach ($typeName as $keyName => $name){
                         if($keyName == "Moyen_Gen"){
                             $info_gene_rank[$idIndiv] = $name;
                         }
                     }
                 }
             }
         }

         $ordered_values = $info_gene_rank;
         rsort($ordered_values);

         foreach ($info_gene_rank as $key => $value) {
             $k = $key;
             foreach ($ordered_values as $ordered_key => $ordered_value) {
                 if ($value === $ordered_value) {
                     $key = $ordered_key;
                     break;
                 }
             }
             $info_gene_rank_ok[$k]= ((int) $key + 1);
         }

         $idclass = trim($lib->securite_xss($_POST['Classe']));
         $periode = trim( $lib->securite_xss($_POST['MOIS']));
         $idyear = $colname_annee_scolaire;
         $idetab = $colname_rq_etablissement;
         $classeNiveau = trim($lib->securite_xss($_POST['IDNIVEAU']));

         array_walk($info_gene,function (&$value,$key)use($info_gene_rank_ok,$dbh,$idclass,$periode,$idyear,$idetab,&$msg,&$res,$classeNiveau){
             $value["Bulletin"]['rang'] = $info_gene_rank_ok[$key] ;
             $bultin = $value["Bulletin"];
             $details = $value["Detail"];
             try {
                 insertBulletin($bultin,$details,$dbh,$key,$idclass,$periode,$idyear,$idetab,$classeNiveau);

                 $msg = "La génération des bulletins est terminée";
                 $res = "1";
             }
             catch (PDOException $e){
                 $msg = "Echec de la génération des bulletins";
                 $res = "-1";
             }
         });
     }
     header("Location: GenebulletinNoteMensuelTermine.php?msg=".base64_encode($msg)."&res=".base64_encode($res)."&idperiode=".base64_encode($mois)."&idclassroom=".base64_encode($Classe)."&idannee=".base64_encode($colname_annee_scolaire)."&ideatb=".base64_encode($colname_rq_etablissement)."&idniveau=".base64_encode($classeNiveau));
}


