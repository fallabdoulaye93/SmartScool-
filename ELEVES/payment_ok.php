
<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("restriction.php");


require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();


function readinscrit($id){
$connection =  new Connexion();
$dbh = $connection->Connection();
 $query_rq_etab = $dbh->query("SELECT IDINSCRIPTION FROM INSCRIPTION WHERE  INSCRIPTION.IDINDIVIDU = $id ");	
	                           
								$rs_etab= $query_rq_etab->fetchObject();
			                    return  $rs_etab->IDINSCRIPTION;
}	
function readEtab($id){
$connection =  new Connexion();
$dbh = $connection->Connection();
 $query_rq_etab = $dbh->query("SELECT PREFIXE FROM ETABLISSEMENT,INDIVIDU WHERE  INDIVIDU.IDETABLISSEMENT=ETABLISSEMENT.IDETABLISSEMENT  AND INDIVIDU.IDINDIVIDU= $id");	
	                           
								$rs_etab= $query_rq_etab->fetchObject();
			                    return  $rs_etab->PREFIXE;
}	
function readIDEtab($id){
$connection =  new Connexion();
$dbh = $connection->Connection();
 $query_rq_etab = $dbh->query("SELECT ETABLISSEMENT.IDETABLISSEMENT FROM ETABLISSEMENT,INDIVIDU WHERE  INDIVIDU.IDETABLISSEMENT=ETABLISSEMENT.IDETABLISSEMENT  AND INDIVIDU.IDINDIVIDU= $id");	
	                           
								$rs_etab= $query_rq_etab->fetchObject();
			                    return  $rs_etab->IDETABLISSEMENT;
}	

	
if($_GET['val']==1 && $_GET['montant']!=''){
 //$bdd = new PDO("mysql:host=$d$bdd = Connection(); 
         $montant = $lib->securite_xss($_GET['montant']);
         $inscrit=readinscrit($_SESSION['etudiant']);
         $etat=1;
         $requat=0;
		 $facture=$_SESSION['numfact'];
          $query = sprintf("UPDATE FACTURE SET FACTURE.MT_VERSE =:MT_VERSE,FACTURE.ETAT=:ETAT ,FACTURE.MT_RELIQUAT=:MT_RELIQUAT 
		WHERE FACTURE.IDFACTURE=:fature");
								$result = $dbh->prepare($query);
								$result->bindParam("MT_VERSE",$montant);
								$result->bindParam("ETAT",$etat);
								$result->bindParam("MT_RELIQUAT",$requat);
								//$result->bindParam("IDINSCRIPTION",$inscrit);
								$result->bindParam("fature", $facture);
								 $count = $result->execute();
								$resultat=0;
								if($count==1)
							    {  $datejour=date('Y-m-d');
								    $MT_RELIQUAT=0;
									$id_type_paiment=4;
								    $sigle=readEtab($_SESSION['etudiant']);
									$idEtab=readIDEtab($_SESSION['etudiant']);
								    $numtransaction= $lib->genererNumTransaction($sigle);
								   $query =sprintf("INSERT INTO MENSUALITE(MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, id_type_paiment,numtransac) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :id_type_paiment,:numtransac)");
								   $result = $dbh->prepare($query);
								   $result->bindParam("MOIS",$lib->Le_mois($_SESSION['mois']));
								   $result->bindParam("MONTANT",$montant);
								   $result->bindParam("DATEREGLMT",$datejour);
								   $result->bindParam("IDINSCRIPTION",$inscrit);
								   $result->bindParam("IDETABLISSEMENT",$idEtab);
								   $result->bindParam("MT_VERSE",$montant);
								   $result->bindParam("MT_RELIQUAT",$MT_RELIQUAT);
								   $result->bindParam("id_type_paiment",$id_type_paiment);
								  $result->bindParam("numtransac",$numtransaction);
								 
								   $resultat = $result->execute(); 
								   if($resultat==1)
							        { 
									  $MM_restrictGoTo = "jula.php?mes=OK&montant=$montant";
									  
									  $_SESSION['montant'] =NULL;
									  unset( $_SESSION['montant']);
									  $_SESSION['redirection']=NULL;
									  unset( $_SESSION['redirection']);
									  $_SESSION['etudiant']=NULL;
									  unset( $_SESSION['etudiant']);
									  $_SESSION['mois']=NULL;
									  unset( $_SESSION['mois']);
									  $_SESSION['numfact']=NULL;
									  unset( $_SESSION['numfact']);
									   header("Location: ". $MM_restrictGoTo);
									  
									  }
									  else
									  { 
										   $MM_restrictGoTo = "jula.php?mes=non";
										   header("Location: ". $MM_restrictGoTo);
									   }
							      }
								
								$dbh = null ;
								
 
 }
 else
 { 
 $MM_restrictGoTo = "jula.php?mes=non";
 header("Location: ". $MM_restrictGoTo);
 }
 ?>