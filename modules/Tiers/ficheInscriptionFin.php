<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
require_once("classe/InscriptionManager.php");
require_once("classe/Inscription.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(36, $lib->securite_xss($_SESSION['profil'])));

$inscription = new InscriptionManager($dbh, 'INSCRIPTION');
$idSection = $lib->securite_xss($_POST['selectSection']);

$montantT = 0;
if($idSection == "") {
    $montantT = 0;
    $idSection = 0;
}
else
{
    $query_rq_transport = $dbh->query("SELECT MONTANT FROM SECTION_TRANSPORT WHERE ID_SECTION=".$idSection);
    $resulat = $query_rq_transport->fetchObject();
    $montantT = intval($resulat->MONTANT);
}
//var_dump($_POST['FRAIS_INSCRIPTION']);exit;
if (isset($_POST) && $_POST != null && $_POST['FRAIS_INSCRIPTION'] != "")
{
    if($_POST['optTrousseau'] == 2)
    {
        $_POST['UNIFORME'] = $lib->securite_xss($_POST['montantT']);
    }
    if($_POST['FK_MOYENPAIEMENT'] == 2)
    {
        $_POST['NUM_CHEQUE'] = $lib->securite_xss($_POST['NUM_CHEQUE']);
        $_POST['FK_BANQUE'] = $lib->securite_xss($_POST['FK_BANQUE']);
    }else{
        $_POST['NUM_CHEQUE'] = "";
    }
    $_POST['TROUSSEAU'] = $lib->securite_xss($_POST['optTrousseau']);
    unset($_POST['optTrousseau']);
    unset($_POST['montantT']);
    try
    {
        $sql = "INSERT INTO INSCRIPTION (DATEINSCRIPT, MONTANT, FRAIS_INSCRIPTION, ACCOMPTE_VERSE, STATUT, IDNIVEAU, IDINDIVIDU, IDETABLISSEMENT, 
                IDANNEESSCOLAIRE, IDSERIE, DERNIER_ETAB, VALIDETUDE, FRAIS_DOSSIER, FRAIS_EXAMEN, UNIFORME, VACCINATION, ASSURANCE, TRANSPORT, MONTANT_TRANSPORT,  
                MONTANT_DOSSIER, MONTANT_EXAMEN, MONTANT_UNIFORME, MONTANT_VACCINATION, MONTANT_ASSURANCE, RESULTAT_ANNUEL, ACCORD_MENSUELITE, FK_SECTION, TROUSSEAU, 
                FK_MOYENPAIEMENT, NUM_CHEQUE, FK_BANQUE, AVANCE, NBRE_MOIS)
                VALUES (:DATEINSCRIPT, :MONTANT, :FRAIS_INSCRIPTION, :ACCOMPTE_VERSE, :STATUT, :IDNIVEAU, :IDINDIVIDU, :IDETABLISSEMENT, :IDANNEESSCOLAIRE, :IDSERIE, 
                :DERNIER_ETAB, :VALIDETUDE, :FRAIS_DOSSIER, :FRAIS_EXAMEN, :UNIFORME, :VACCINATION, :ASSURANCE, :TRANSPORT, :MONTANT_TRANSPORT ,:MONTANT_DOSSIER, 
                :MONTANT_EXAMEN, :MONTANT_UNIFORME, :MONTANT_VACCINATION, :MONTANT_ASSURANCE, :RESULTAT_ANNUEL, :ACCORD_MENSUELITE, :FK_SECTION, :TROUSSEAU, 
                :FK_MOYENPAIEMENT, :NUM_CHEQUE, :FK_BANQUE, :AVANCE, :NBRE_MOIS)";

        $req = $dbh->prepare($sql);
        $res = $req->execute(array(
            ':DATEINSCRIPT' => $_POST['DATEINSCRIPT'],
            ':MONTANT' => $lib->GetSQLValueString($_POST['MONTANT'], "int"),
            ':FRAIS_INSCRIPTION' => $lib->GetSQLValueString($_POST['FRAIS_INSCRIPTION'], "int"),
            ':ACCOMPTE_VERSE' => $lib->GetSQLValueString($_POST['ACCOMPTE_VERSE'], "int"),
            ':STATUT' => $lib->GetSQLValueString($_POST['STATUT'], "int"),
            ':IDNIVEAU' => $lib->GetSQLValueString(base64_decode($_POST['IDNIVEAU']), "int"),
            ':IDINDIVIDU' => $lib->GetSQLValueString(base64_decode($_POST['IDINDIVIDU']), "int"),
            ':IDETABLISSEMENT' => $lib->GetSQLValueString(base64_decode($_POST['IDETABLISSEMENT']), "int"),
            ':IDANNEESSCOLAIRE' => $lib->GetSQLValueString(base64_decode($_POST['IDANNEESSCOLAIRE']), "int"),
            ':IDSERIE' => $lib->GetSQLValueString(base64_decode($_POST['IDSERIE']), "int"),
            ':DERNIER_ETAB' => $lib->GetSQLValueString($_POST['DERNIER_ETAB'], "text"),
            ':VALIDETUDE' => $lib->GetSQLValueString($_POST['VALIDETUDE'], "int"),
            ':FRAIS_DOSSIER' => $lib->GetSQLValueString($_POST['FRAIS_DOSSIER'], "int"),
            ':FRAIS_EXAMEN' => $lib->GetSQLValueString($_POST['FRAIS_EXAMEN'], "int"),
            ':UNIFORME' => $lib->GetSQLValueString($_POST['UNIFORME'], "int"),
            ':VACCINATION' => $lib->GetSQLValueString($_POST['VACCINATION'], "int"),
            ':ASSURANCE' => $lib->GetSQLValueString($_POST['ASSURANCE'], "int"),
            ':TRANSPORT' => $lib->GetSQLValueString(intval($_POST['optTransport']), "int"),
            ':MONTANT_TRANSPORT' => $montantT,
            ':MONTANT_DOSSIER' => $lib->GetSQLValueString($_POST['MONTANT_DOSSIER'], "int"),
            ':MONTANT_EXAMEN' => $lib->GetSQLValueString($_POST['MONTANT_EXAMEN'], "int"),
            ':MONTANT_UNIFORME' => $lib->GetSQLValueString($_POST['MONTANT_UNIFORME'], "int"),
            ':MONTANT_VACCINATION' => $lib->GetSQLValueString($_POST['MONTANT_VACCINATION'], "int"),
            ':MONTANT_ASSURANCE' => $lib->GetSQLValueString($_POST['MONTANT_ASSURANCE'], "int"),
            ':RESULTAT_ANNUEL' => $lib->GetSQLValueString($_POST['RESULTAT_ANNUEL'], "int"),
            ':ACCORD_MENSUELITE' => $lib->GetSQLValueString($_POST['ACCORD_MENSUELITE'], "int"),
            ':FK_SECTION' => $idSection,
            ':TROUSSEAU' => $lib->GetSQLValueString($_POST['optTrousseau'], "int"),
            ':FK_MOYENPAIEMENT' => $lib->GetSQLValueString($_POST['FK_MOYENPAIEMENT'], "int"),
            ':NUM_CHEQUE' => $lib->GetSQLValueString($_POST['NUM_CHEQUE'], "int"),
            ':FK_BANQUE' => $lib->GetSQLValueString($_POST['FK_BANQUE'], "int"),
            ':AVANCE' => $lib->GetSQLValueString($_POST['optAvance'], "int"),
            ':NBRE_MOIS' => $lib->GetSQLValueString($_POST['nombremois'], "int"),
        ));

        $idInscription=$dbh->lastInsertId();

    }
    catch (PDOException $e)
    {
        echo -2;
    }

    if($res == 1)
    {
           if($_POST['MATRICULE'] == "")
           {
               $query = "SELECT MAX(MATRICULE) AS MATRICULE FROM INDIVIDU WHERE IDTYPEINDIVIDU = 8";
               $stmt = $dbh->prepare($query);
               $stmt->execute();
               $result = $stmt->fetchObject();
               if (count($result) > 0)
               {
                   $leMatricule = sprintf("%04d", intval($result->MATRICULE)+ 1);
               }
               else
               {
                   $leMatricule = '0001';
               }
               $updateIndiv = sprintf("UPDATE INDIVIDU SET MATRICULE = '" . $leMatricule . "' WHERE IDINDIVIDU = " . base64_decode($_POST['IDINDIVIDU']));
               $result = $dbh->prepare($updateIndiv);
               $result->execute();
           }
        $classe = $lib->securite_xss($_POST['classe']);
        $etablissement = $lib->securite_xss(base64_decode($_POST['IDETABLISSEMENT']));
        $individu = $lib->securite_xss(base64_decode($_POST['IDINDIVIDU']));
        $annees = $lib->GetSQLValueString(base64_decode($_POST['IDANNEESSCOLAIRE']), "int");
        $avance=1;
        $idtype=2;
        try
        {
            $insertSQL1 = "INSERT INTO AFFECTATION_ELEVE_CLASSE (IDCLASSROOM, IDINDIVIDU, IDANNEESSCOLAIRE, IDETABLISSEMENT) VALUES (:classe, :individu, :annees, :etablissement)";
            $req2 = $dbh->prepare($insertSQL1);
            $req2->execute(array(':classe' => $classe, ':individu' => $individu, ':annees' => $annees, ':etablissement' => $etablissement));
            if($req2==1)
            {
                    $sqlq= $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT FROM ANNEESSCOLAIRE where IDANNEESSCOLAIRE=".$annees." AND IDETABLISSEMENT=" .$etablissement);
                     $rqsql=$sqlq->fetchObject();
                     $arr = explode('-',$rqsql->DATE_DEBUT);
                     $arr1 = explode('-',$rqsql->DATE_FIN);
                     $mois1=$arr[1].'-'.$arr[0];
                     $an1= $arr[0];
                     $derniermois=$arr1[1].'-'.$arr1[0];
                     $andernier=$arr1[0];
                     $montant=$lib->securite_xss($_POST['MONTANT']);

                    if($lib->si_facture_existe($mois1, $idInscription) == 0 || $lib->si_facture_existe($mois1, $idInscription) == 2 )
                    {
                            $num_facture = "FACT" . $lib->code_identification() . $etablissement;
                            $INSERT = "INSERT INTO FACTURE(NUMFACTURE, MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, ETAT, IDANNEESCOLAIRE, AVANCE) VALUES (:NUMFACTURE, :MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :ETAT, :IDANNEESCOLAIRE, :AVANCE)";
                            $reqIns = $dbh->prepare($INSERT);
                            $reqIns->execute(array(
                            ':NUMFACTURE' => $num_facture,
                            ':MOIS' => $mois1,
                            ':MONTANT' => $montant,
                            ':DATEREGLMT' => date('Y-m-d'),
                            ':IDINSCRIPTION' => $idInscription,
                            ':IDETABLISSEMENT' => $etablissement,
                            ':MT_VERSE' => $montant,
                            ':MT_RELIQUAT' => 0,
                            ':ETAT' => 1,
                            ':IDANNEESCOLAIRE' => $annees,
                             ':AVANCE' => $avance,
                                ));

                            if($reqIns==1){

                            $moisp = $lib->Le_mois(substr($mois1, 0, 2)) . " / " . substr($mois1, 3, 4);
                            $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE (MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, NUMFACT, id_type_paiment) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :NUMFACT, :id_type_paiment)");
                            $insertSQL->execute(array(
                                "MOIS" => $moisp,
                                "MONTANT" => $montant,
                                "DATEREGLMT" => date('Y-m-d'),
                                "IDINSCRIPTION" => $idInscription,
                                "IDETABLISSEMENT" => $etablissement,
                                "MT_VERSE" => $montant,
                                "MT_RELIQUAT" => 0,
                                "NUMFACT" => $num_facture,
                                "id_type_paiment" => $idtype,
                            ));

                              if($lib->securite_xss($_POST['selectSection'])!=''){
                                  $requatFac=0;
                                  $etatT=0;
                                  $insertSQL_Facture = $dbh->prepare("INSERT INTO TRANSPORT_MENSUALITE ( MOIS, MONTANT, DATEREGLEMENT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUM_FACTURE,ETAT) VALUES (:MOIS, :MONTANT, :DATEREGLEMENT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:NUM_FACTURE, :ETAT)");
                                  $insertSQL_Facture->execute(array(
                                      "MOIS" => $moisp,
                                      "MONTANT" => $montantT,
                                      "DATEREGLEMENT" => date('Y-m-d'),
                                      "IDINSCRIPTION" => $idInscription,
                                      "IDETABLISSEMENT" => $etablissement,
                                      "MT_VERSE" => $montantT,
                                      "MT_RELIQUAT" => $requatFac,
                                      "NUM_FACTURE" => $num_facture,
                                      "ETAT" => $etatT,
                                  ));
                              }
                        }

                    }

                    if ($lib->si_facture_existe($derniermois, $idInscription) == 0 || $lib->si_facture_existe($derniermois, $idInscription) == 2)
                    {
                        $num_facture1 = "FACT" . $lib->code_identification() . $etablissement;
                        $INSERT = "INSERT INTO FACTURE(NUMFACTURE, MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, ETAT, IDANNEESCOLAIRE, AVANCE) VALUES (:NUMFACTURE, :MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :ETAT, :IDANNEESCOLAIRE, :AVANCE)";
                        $reqIns = $dbh->prepare($INSERT);
                        $reqIns->execute(array(
                            ':NUMFACTURE' => $num_facture1,
                            ':MOIS' => $derniermois,
                            ':MONTANT' => $montant,
                            ':DATEREGLMT' => date('Y-m-d'),
                            ':IDINSCRIPTION' => $idInscription,
                            ':IDETABLISSEMENT' => $etablissement,
                            ':MT_VERSE' => $montant,
                            ':MT_RELIQUAT' => 0,
                            ':ETAT' => 1,
                            ':IDANNEESCOLAIRE' => $annees,
                            ':AVANCE' => $avance,
                        ));

                        if($reqIns == 1)
                        {
                            $moisd = $lib->Le_mois(substr($derniermois, 0, 2)) . " / " . substr($derniermois, 3, 4);
                            $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE (MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUMFACT, id_type_paiment) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :NUMFACT, :id_type_paiment)");
                            $insertSQL->execute(array(
                                "MOIS" => $moisd,
                                "MONTANT" => $montant,
                                "DATEREGLMT" => date('Y-m-d'),
                                "IDINSCRIPTION" => $idInscription,
                                "IDETABLISSEMENT" => $etablissement,
                                "MT_VERSE" => $montant,
                                "MT_RELIQUAT" => 0,
                                "NUMFACT" => $num_facture1,
                                "id_type_paiment" => $idtype,
                            ));

                            if($lib->securite_xss($_POST['selectSection'])!='')
                            {
                                $requatFac=0;
                                $etatT=0;
                                $insertSQL_Facture = $dbh->prepare("INSERT INTO TRANSPORT_MENSUALITE ( MOIS, MONTANT, DATEREGLEMENT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUM_FACTURE,ETAT) VALUES (:MOIS, :MONTANT, :DATEREGLEMENT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:NUM_FACTURE, :ETAT)");
                                $insertSQL_Facture->execute(array(
                                    "MOIS" => $moisd,
                                    "MONTANT" => $montantT,
                                    "DATEREGLEMENT" => date('Y-m-d'),
                                    "IDINSCRIPTION" => $idInscription,
                                    "IDETABLISSEMENT" => $etablissement,
                                    "MT_VERSE" => $montantT,
                                    "MT_RELIQUAT" => $requatFac,
                                    "NUM_FACTURE" => $num_facture1,
                                    "ETAT" => $etatT,
                                ));
                            }
                        }
                    }
                if($_POST['optAvance']==1){
                    for ($i = 1; $i <= $_POST['nombremois']; $i++) {
                        $ms=$arr[1]+$i;
                        if($ms==13){
                            $an=$an1+1;
                            $moiis=01;
                        }elseif($ms==14) {
                            $an=$an1+1;
                            $moiis=01+1;
                        }elseif($ms==15) {
                            $an=$an1+1;
                            $moiis=02+1;
                        }elseif($ms==16) {
                            $an=$an1+1;
                            $moiis=03+1;
                        }elseif($ms==17) {
                            $an=$an1+1;
                            $moiis=04+1;
                        }elseif($ms==16) {
                            $an=$an1+1;
                            $moiis=05+1;
                        }else{
                            $an=$an1;
                            $moiis=$ms;
                        }
                        if($moiis<10){$moi='0'.$moiis;}else{$moi=$moiis;}
                        $moisav=$moi.'-'.$an;
                        if($lib->si_facture_existe($moisav, $idInscription) == 0 || $lib->si_facture_existe($moisav, $idInscription) == 2 )
                        {
                            $num_facture = "FACT" . $lib->code_identification() . $etablissement;
                            $INSERT = "INSERT INTO FACTURE(NUMFACTURE, MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, ETAT, IDANNEESCOLAIRE, AVANCE) VALUES (:NUMFACTURE, :MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :ETAT, :IDANNEESCOLAIRE, :AVANCE)";
                            $reqIns = $dbh->prepare($INSERT);
                            $reqIns->execute(array(
                                ':NUMFACTURE' => $num_facture,
                                ':MOIS' => $moisav,
                                ':MONTANT' => $montant,
                                ':DATEREGLMT' => date('Y-m-d'),
                                ':IDINSCRIPTION' => $idInscription,
                                ':IDETABLISSEMENT' => $etablissement,
                                ':MT_VERSE' => $montant,
                                ':MT_RELIQUAT' => 0,
                                ':ETAT' => 1,
                                ':IDANNEESCOLAIRE' => $annees,
                                ':AVANCE' => $avance,
                            ));

                            if($reqIns==1){

                                $moisp = $lib->Le_mois(substr($moisav, 0, 2)) . " / " . substr($moisav, 3, 4);
                                $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE (MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, NUMFACT, id_type_paiment) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :NUMFACT, :id_type_paiment)");
                                $insertSQL->execute(array(
                                    "MOIS" => $moisp,
                                    "MONTANT" => $montant,
                                    "DATEREGLMT" => date('Y-m-d'),
                                    "IDINSCRIPTION" => $idInscription,
                                    "IDETABLISSEMENT" => $etablissement,
                                    "MT_VERSE" => $montant,
                                    "MT_RELIQUAT" => 0,
                                    "NUMFACT" => $num_facture,
                                    "id_type_paiment" => $idtype,
                                ));

                                if($lib->securite_xss($_POST['selectSection'])!=''){
                                    $requatFac=0;
                                    $etatT=0;
                                    $insertSQL_Facture = $dbh->prepare("INSERT INTO TRANSPORT_MENSUALITE ( MOIS, MONTANT, DATEREGLEMENT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUM_FACTURE,ETAT) VALUES (:MOIS, :MONTANT, :DATEREGLEMENT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:NUM_FACTURE, :ETAT)");
                                    $insertSQL_Facture->execute(array(
                                        "MOIS" => $moisp,
                                        "MONTANT" => $montantT,
                                        "DATEREGLEMENT" => date('Y-m-d'),
                                        "IDINSCRIPTION" => $idInscription,
                                        "IDETABLISSEMENT" => $etablissement,
                                        "MT_VERSE" => $montantT,
                                        "MT_RELIQUAT" => $requatFac,
                                        "NUM_FACTURE" => $num_facture,
                                        "ETAT" => $etatT,
                                    ));
                                }
                            }
                        }
                    }
                }
            }
        }
        catch (PDOException $e) {
            echo -2;
        }

        // REQUETE POUR RECUPERER LID DE LINSCRIPTION
        $colname_rq_inscription = "-1";
        if (isset($_SESSION['etab'])) {
            $colname_rq_inscription = $lib->securite_xss($_SESSION['etab']);
        }
        $colname1_rq_inscription = "-1";
        if (isset($_POST['IDINDIVIDU'])) {
            $colname1_rq_inscription = $lib->securite_xss(base64_decode($_POST['IDINDIVIDU']));
        }
        $colname2_rq_inscription = "-1";
        if (isset($_POST['IDANNEESSCOLAIRE'])) {
            $colname2_rq_inscription = $lib->securite_xss(base64_decode($_POST['IDANNEESSCOLAIRE']));
        }

        $query_rq_inscription = $dbh->query("SELECT INSCRIPTION.IDINSCRIPTION 
                                                       FROM INSCRIPTION 
                                                       WHERE INSCRIPTION.IDETABLISSEMENT=" . $colname_rq_inscription . "  
                                                       AND INSCRIPTION.IDINDIVIDU=" . $colname1_rq_inscription . "  
                                                       AND INSCRIPTION.IDANNEESSCOLAIRE = " . $colname2_rq_inscription);
        $row_rq_inscription = $query_rq_inscription->fetchObject();

        $IDINSCRIPTION = $row_rq_inscription->IDINSCRIPTION;
        $msg = "Inscription effectuée avec succes";
        //$urlredirect = "inscription.php?msg=$msg&res=$res&idetablissement=".$lib->securite_xss($_POST['IDETABLISSEMENT']). "&idinscription=" . base64_encode($IDINSCRIPTION) . "&IDINDIVIDU=" . base64_encode($individu);
        if($_POST['optAvance']==1){
            $urlredirect = "recap_inscription.php?msg=$msg&res=$res&idetablissement=".$lib->securite_xss($_POST['IDETABLISSEMENT']). "&idinscription=" . base64_encode($IDINSCRIPTION) . "&IDINDIVIDU=" . base64_encode($individu)."&nbremois=".$lib->securite_xss($_POST['nombremois']);

        }else{
            $urlredirect = "recap_inscription.php?msg=$msg&res=$res&idetablissement=".$lib->securite_xss($_POST['IDETABLISSEMENT']). "&idinscription=" . base64_encode($IDINSCRIPTION) . "&IDINDIVIDU=" . base64_encode($individu);

        }

    } else {
        $msg = "Votre inscription a echouée";
        $urlredirect = "inscription.php?msg=$msg&res=$res";
    }
    header("Location:$urlredirect");

}