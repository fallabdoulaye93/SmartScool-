<?php
 session_start();
 require_once("../../restriction.php");


require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
	//var_dump($_POST);die();

$idSection = $lib->securite_xss($_POST['selectSection']);
if($idSection == "") {
    $montant = 0;
    $transport = 0;
    $idSection = 0;
}else {
    $query_rq_transport = $dbh->query("SELECT MONTANT FROM SECTION_TRANSPORT WHERE ID_SECTION=".$idSection);
    $resulat = $query_rq_transport->fetchObject();
    $montant = intval($resulat->MONTANT);
    $transport = intval($lib->securite_xss($_POST['optTransport']));
}

    if(isset($_POST) && $_POST !=null && $_POST['FRAIS_INSCRIPTION']!="") {
    $mnt_sco=$_POST['MONTANT'];

	$sql= "UPDATE INSCRIPTION SET DATEINSCRIPT = :DATEINSCRIPT,MONTANT = :MONTANT,FRAIS_INSCRIPTION = :FRAIS_INSCRIPTION,ACCOMPTE_VERSE  = :ACCOMPTE_VERSE,STATUT = :STATUT,IDNIVEAU =  :IDNIVEAU,IDINDIVIDU= :IDINDIVIDU,IDETABLISSEMENT = :IDETABLISSEMENT, IDANNEESSCOLAIRE = :IDANNEESSCOLAIRE, IDSERIE = :IDSERIE, DERNIER_ETAB = :DERNIER_ETAB,VALIDETUDE = :VALIDETUDE,FRAIS_DOSSIER = :FRAIS_DOSSIER, FRAIS_EXAMEN= :FRAIS_EXAMEN,UNIFORME = :UNIFORME,VACCINATION = :VACCINATION,ASSURANCE = :ASSURANCE,FRAIS_SOUTENANCE = :FRAIS_SOUTENANCE, TRANSPORT = :TRANSPORT, MONTANT_TRANSPORT = :MONTANT_TRANSPORT ,MONTANT_DOSSIER = :MONTANT_DOSSIER,MONTANT_EXAMEN = :MONTANT_EXAMEN,MONTANT_UNIFORME = :MONTANT_UNIFORME,MONTANT_VACCINATION = :MONTANT_VACCINATION,MONTANT_ASSURANCE = :MONTANT_ASSURANCE,MONTANT_SOUTENANCE = :MONTANT_SOUTENANCE,RESULTAT_ANNUEL = :RESULTAT_ANNUEL,ACCORD_MENSUELITE = :ACCORD_MENSUELITE, FK_SECTION = :FK_SECTION, TROUSSEAU = :TROUSSEAU, FK_MOYENPAIEMENT = :FK_MOYENPAIEMENT, NUM_CHEQUE = :NUM_CHEQUE, FK_BANQUE = :FK_BANQUE, AVANCE = :AVANCE, NBRE_MOIS = :NBRE_MOIS WHERE IDINSCRIPTION = :IDINSCRIPTION";
	$req = $dbh->prepare($sql);
	$res= $req->execute(array(
		               ':DATEINSCRIPT'=>$_POST['DATEINSCRIPT'],
                       ':MONTANT'=>$lib->GetSQLValueString($_POST['MONTANT'], "int"),
					   ':FRAIS_INSCRIPTION'=>$lib->GetSQLValueString($_POST['FRAIS_INSCRIPTION'], "int"),
                       ':ACCOMPTE_VERSE'=>$lib->GetSQLValueString($_POST['ACCOMPTE_VERSE'], "int"),
                       ':STATUT'=>$lib->GetSQLValueString($_POST['STATUT'], "int"),
                       ':IDNIVEAU'=>$lib->GetSQLValueString($_POST['IDNIVEAU'], "int"),
                       ':IDINDIVIDU'=>$lib->GetSQLValueString(base64_decode($_POST['IDINDIVIDU']) , "int"),
                       ':IDETABLISSEMENT'=>$lib->GetSQLValueString(base64_decode($_POST['IDETABLISSEMENT']) , "int"),
                       ':IDANNEESSCOLAIRE'=>$lib->GetSQLValueString(base64_decode($_POST['IDANNEESSCOLAIRE']) , "int"),
                       ':IDSERIE'=>$lib->GetSQLValueString($_POST['IDSERIE'], "int"),
                       ':DERNIER_ETAB'=>$lib->GetSQLValueString($_POST['DERNIER_ETAB'], "text"),
                       ':VALIDETUDE'=>$lib->GetSQLValueString($_POST['VALIDETUDE'], "int"),
                       ':FRAIS_DOSSIER'=>$lib->GetSQLValueString($_POST['FRAIS_DOSSIER'], "int"),
                       ':FRAIS_EXAMEN'=>$lib->GetSQLValueString($_POST['FRAIS_EXAMEN'], "int"),
                       ':UNIFORME'=>$lib->GetSQLValueString($_POST['UNIFORME'], "int"),
                       ':VACCINATION'=>$lib->GetSQLValueString($_POST['VACCINATION'], "int"),
                       ':ASSURANCE'=>$lib->GetSQLValueString($_POST['ASSURANCE'], "int"),
                       ':FRAIS_SOUTENANCE'=>$lib->GetSQLValueString($_POST['FRAIS_SOUTENANCE'], "int"),
                       ':TRANSPORT'=>$transport,
                       ':MONTANT_TRANSPORT'=>$montant,
					    ':MONTANT_DOSSIER'=>$lib->GetSQLValueString($_POST['MONTANT_DOSSIER'], "int"),
                       ':MONTANT_EXAMEN'=>$lib->GetSQLValueString($_POST['MONTANT_EXAMEN'], "int"),
                       ':MONTANT_UNIFORME'=>$lib->GetSQLValueString($_POST['MONTANT_UNIFORME'], "int"),
					    ':MONTANT_VACCINATION'=>$lib->GetSQLValueString($_POST['MONTANT_VACCINATION'], "int"),
                       ':MONTANT_ASSURANCE'=>$lib->GetSQLValueString($_POST['MONTANT_ASSURANCE'], "int"),
                       ':MONTANT_SOUTENANCE'=>$lib->GetSQLValueString($_POST['MONTANT_SOUTENANCE'], "int"),
                       ':RESULTAT_ANNUEL'=>$lib->GetSQLValueString($_POST['RESULTAT_ANNUEL'], "int"),
                       ':ACCORD_MENSUELITE'=>$lib->GetSQLValueString($_POST['ACCORD_MENSUELITE'], "int"),
					   ':IDINSCRIPTION'=>$lib->GetSQLValueString(base64_decode($_POST['IDINSCRIPTION']) , "int"),
					   ':FK_SECTION'=>$idSection,
                        ':TROUSSEAU' => $lib->GetSQLValueString($_POST['optTrousseau'], "int"),
                        ':FK_MOYENPAIEMENT' => $lib->GetSQLValueString($_POST['FK_MOYENPAIEMENT'], "int"),
                        ':NUM_CHEQUE' => $lib->GetSQLValueString($_POST['NUM_CHEQUE'], "int"),
                        ':FK_BANQUE' => $lib->GetSQLValueString($_POST['FK_BANQUE'], "int"),
                        ':AVANCE' => $lib->GetSQLValueString($_POST['optAvance'], "int"),
                        ':NBRE_MOIS' => $lib->GetSQLValueString($_POST['nombremois'], "int"),

					   ));
						// $res=$inscription->insert($_POST);
						   if($res==1){
							   
							 
							    $classe=$_POST['classe'];
								$etablissement=$lib->securite_xss(base64_decode($_POST['IDETABLISSEMENT']));
								$individu=$lib->securite_xss(base64_decode($_POST['IDINDIVIDU']));
								$annees = $lib->GetSQLValueString(base64_decode($_POST['IDANNEESSCOLAIRE']), "int");
								$idAffectation=  $lib->securite_xss(base64_decode($_POST['IDAFFECTATION']));
								$insertSQL1 = "UPDATE AFFECTATION_ELEVE_CLASSE set IDCLASSROOM=:IDCLASSROOM, IDINDIVIDU=:IDINDIVIDU, IDANNEESSCOLAIRE=:IDANNEESSCOLAIRE, IDETABLISSEMENT=:IDETABLISSEMENT where IDAFFECTATTION_ELEVE_CLASSE =:IDAFFECTATTION_ELEVE_CLASSE";
								$req2 = $dbh->prepare($insertSQL1);
								$req2->execute(array(
									':IDCLASSROOM'=>$classe,
									':IDINDIVIDU'=>$individu,
									':IDANNEESSCOLAIRE'=>$annees,
									':IDETABLISSEMENT'=>$etablissement,
									':IDAFFECTATTION_ELEVE_CLASSE'=>$idAffectation
									));


                               // REQUETE POUR RECUPER LID DE LINSCRIPTION
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

                               $query_rq_inscription = $dbh->query("SELECT INSCRIPTION.IDINSCRIPTION FROM INSCRIPTION WHERE INSCRIPTION.IDETABLISSEMENT=".$colname_rq_inscription."  AND INSCRIPTION.IDINDIVIDU=".$colname1_rq_inscription."  AND INSCRIPTION.IDANNEESSCOLAIRE = ".$colname2_rq_inscription);

                               $row_rq_inscription = $query_rq_inscription->fetchObject();


                               $IDINSCRIPTION=$row_rq_inscription->IDINSCRIPTION;
                              // var_dump($IDINSCRIPTION);exit;

                               $sqlq= $dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT FROM ANNEESSCOLAIRE where IDANNEESSCOLAIRE=".$colname2_rq_inscription." AND IDETABLISSEMENT=" .$colname_rq_inscription);
                               $rqsql=$sqlq->fetchObject();
                               $arr = explode('-',$rqsql->DATE_DEBUT);
                               $arr1 = explode('-',$rqsql->DATE_FIN);
                               $mois1=$arr[1].'-'.$arr[0];
                               $an1= $arr[0];
                               $derniermois=$arr1[1].'-'.$arr1[0];
                               $andernier=$arr1[0];
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
                                       $avance=1;
                                       $idtype=2;
                                       if($lib->si_facture_existe($moisav, $IDINSCRIPTION) == 0 || $lib->si_facture_existe($moisav, $IDINSCRIPTION) == 2 )
                                       {
                                           //var_dump($moisav);exit;
                                           $num_facture = "FACT" . $lib->code_identification() . $etablissement;
                                           $INSERT = "INSERT INTO FACTURE(NUMFACTURE, MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, ETAT, IDANNEESCOLAIRE, AVANCE) VALUES (:NUMFACTURE, :MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :ETAT, :IDANNEESCOLAIRE, :AVANCE)";
                                           $reqIns = $dbh->prepare($INSERT);
                                           $reqIns->execute(array(
                                               ':NUMFACTURE' => $num_facture,
                                               ':MOIS' => $moisav,
                                               ':MONTANT' => $mnt_sco,
                                               ':DATEREGLMT' => date('Y-m-d'),
                                               ':IDINSCRIPTION' => $IDINSCRIPTION,
                                               ':IDETABLISSEMENT' => $etablissement,
                                               ':MT_VERSE' => $mnt_sco,
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
                                                   "MONTANT" => $mnt_sco,
                                                   "DATEREGLMT" => date('Y-m-d'),
                                                   "IDINSCRIPTION" => $IDINSCRIPTION,
                                                   "IDETABLISSEMENT" => $etablissement,
                                                   "MT_VERSE" => $mnt_sco,
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
                                                       "MONTANT" => $montant,
                                                       "DATEREGLEMENT" => date('Y-m-d'),
                                                       "IDINSCRIPTION" => $IDINSCRIPTION,
                                                       "IDETABLISSEMENT" => $etablissement,
                                                       "MT_VERSE" => $montant,
                                                       "MT_RELIQUAT" => $requatFac,
                                                       "NUM_FACTURE" => $num_facture,
                                                       "ETAT" => $etatT,
                                                   ));
                                               }
                                           }
                                       }
                                   }
                               }


                              // var_dump($mnt_sco);exit;

							   
							   $msg = "Inscription effectuée avec succés";
							  
							   $urlredirect = "../../ged/inscription.php?idetablissement=".$_POST['IDETABLISSEMENT']."&idinscription=".base64_encode($IDINSCRIPTION)."&IDINDIVIDU=".base64_encode($individu);
						   }
						   else{
							   $msg = "Inscription effectuée avec echec";
							  $urlredirect="inscription.php?msg=$msg&res=$res";
			
			
						   }					
					 
	
    header("Location:$urlredirect");
    
}

?>