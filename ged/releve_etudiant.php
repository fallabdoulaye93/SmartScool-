<?php require_once('../Connections/connexion.php');
 include('../restriction_page.php'); ?>
<?php
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$colname_rq_periode = "-1";
if (isset($_GET['id_periode'])) {
  $colname_rq_periode = $_GET['id_periode'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_periode = sprintf("SELECT * FROM PERIODE WHERE IDPERIODE = %s", GetSQLValueString($colname_rq_periode, "int"));
$rq_periode = mysql_query($query_rq_periode, $connexion) or die(mysql_error());
$row_rq_periode = mysql_fetch_assoc($rq_periode);
$totalRows_rq_periode = mysql_num_rows($rq_periode);

/*$colname_rq_annee = $row_rq_periode['IDANNEESSCOLAIRE'];
if (isset($_GET['idannee'])) {
  $colname_rq_annee = $_GET['idannee'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_annee = sprintf("SELECT * FROM ANNEESSCOLAIRE WHERE IDANNEESSCOLAIRE = %s", GetSQLValueString($colname_rq_annee, "int"));
$rq_annee = mysql_query($query_rq_annee, $connexion) or die(mysql_error());
$row_rq_annee = mysql_fetch_assoc($rq_annee);
$totalRows_rq_annee = mysql_num_rows($rq_annee);*/
$colname_rq_etablissement = "-1";
if (isset($_GET['idetablissement'])) {
  $colname_rq_etablissement = $_GET['idetablissement'];
}
mysql_select_db($database_connexion, $connexion);
$query_rq_etablissement = sprintf("SELECT IDETABLISSEMENT, NOMETABLISSEMENT_, SIGLE, ADRESSE, TELEPHONE, VILLE, PAYS, FAX, MAIL, SITEWEB, LOGO FROM ETABLISSEMENT WHERE IDETABLISSEMENT = %s", GetSQLValueString($colname_rq_etablissement, "int"));
$rq_etablissement = mysql_query($query_rq_etablissement, $connexion) or die(mysql_error());
$row_rq_etablissement = mysql_fetch_assoc($rq_etablissement);
$totalRows_rq_etablissement = mysql_num_rows($rq_etablissement);
// RQ ELEVE DE LA de l'etudiant
$colname_rq_classe_eleve = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_classe_eleve = $_GET['IDINDIVIDU'];
}
$colname2_rq_classe_eleve = $_SESSION['ANNEESSCOLAIRE'];
mysql_select_db($database_connexion, $connexion);
$query_rq_classe_eleve = sprintf("SELECT IDINDIVIDU FROM AFFECTATION_ELEVE_CLASSE WHERE IDINDIVIDU = %s AND AFFECTATION_ELEVE_CLASSE.IDANNEESSCOLAIRE=%s", GetSQLValueString($colname_rq_classe_eleve, "int"),GetSQLValueString($colname2_rq_classe_eleve, "int"));
$rq_classe_eleve = mysql_query($query_rq_classe_eleve, $connexion) or die(mysql_error());
$totalRows_rq_classe_eleve = mysql_num_rows($rq_classe_eleve);



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$posY=10;
while($row_rq_classe_eleve = mysql_fetch_assoc($rq_classe_eleve))
{
	$colname_rq_eleve =$_GET['IDINDIVIDU'];
	if (isset($_GET['IDINDIVIDU'])) {
	  $colname_rq_eleve =$_GET['IDINDIVIDU'];
	}
	mysql_select_db($database_connexion, $connexion);
	$query_rq_eleve = sprintf("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = %s", GetSQLValueString($colname_rq_eleve, "int"));
	$rq_eleve = mysql_query($query_rq_eleve, $connexion) or die(mysql_error());
	$row_rq_eleve = mysql_fetch_assoc($rq_eleve);
	$totalRows_rq_eleve = mysql_num_rows($rq_eleve);
	$colname_rq_inscription = $row_rq_classe_eleve['IDINDIVIDU'];
	$colname_rq_classe = "-1";
	if (isset($_GET['idclasse'])) {
	  $colname_rq_classe = $_GET['idclasse'];
	}
	mysql_select_db($database_connexion, $connexion);
	$query_rq_classe = sprintf("SELECT NIVEAU.LIBELLE as lib, CLASSROOM.*   FROM CLASSROOM, NIVEAU WHERE IDCLASSROOM = %s AND NIVEAU.IDNIVEAU=CLASSROOM.IDNIVEAU", GetSQLValueString($colname_rq_classe, "int"));
	$rq_classe = mysql_query($query_rq_classe, $connexion) or die(mysql_error());
	$row_rq_classe = mysql_fetch_assoc($rq_classe);
	$totalRows_rq_classe = mysql_num_rows($rq_classe);
	$niveau=$row_rq_classe['lib'];
	$classe= $row_rq_classe['LIBELLE'];	
	$idserie=$row_rq_classe['IDSERIE'];
	$idniveau=$row_rq_classe['IDNIVEAU'] ;	
	$colname_rq_ue = "-1";
	if (isset($idserie)) {
	  $colname_rq_ue = $idserie;
	}
	$colname2_rq_ue = "-1";
	if (isset($idniveau)) {
	  $colname2_rq_ue = $idniveau;
	}
	mysql_select_db($database_connexion, $connexion);
	$query_rq_ue = sprintf(" SELECT  * FROM  UE WHERE UE.IDNIVEAU=%s AND UE.IDSERIE=%s", GetSQLValueString($colname2_rq_ue, "int"),GetSQLValueString($colname_rq_ue, "int"));
	$rq_ue = mysql_query($query_rq_ue, $connexion) or die(mysql_error());
	//$row_rq_ue = mysql_fetch_assoc($rq_ue);
	$totalRows_rq_ue = mysql_num_rows($rq_ue);
	
	$marge_gauche=10;
	$marge_droite=10;
	$marge_haute=10;
	$marge_basse=10;
	$page_largeur=170;
	$posy=10;
	$posx=60;
	
	// LOGO ETABLISSEMENT
	$pdf->AddPage();
	if($row_rq_etablissement['LOGO'])
	$pdf->Image("../logo_etablissement/".$row_rq_etablissement['LOGO'], $marge_gauche, $posy, 0, 20);
	//
	// NOM ETABLISSEMENT 
	$txt = $row_rq_etablissement['NOMETABLISSEMENT_'];
	$pdf->SetFont('','', 10);
	$posy=$posy+2;
	$pdf->writeHTMLCell(90, 3,$posx, $posy, $txt, 0, 1,false,true, 'C');
	// RAISON SOCIALE 
	$txt = $row_rq_etablissement['SIGLE'];
	$posy=$posy+4;
	$pdf->SetFont('','', 10);
	$pdf->writeHTMLCell(170, 3,$marge_gauche+10, $posy, $txt, 0, 1,false,true, 'C');
	// ADRESSE
	$txt = $row_rq_etablissement['ADRESSE'];
	$posy=$posy+4;
	$pdf->SetFont('','', 10);
	$pdf->writeHTMLCell(170, 3,$marge_gauche+10, $posy, $txt, 0, 1,false,true, 'C');
	//trait
	$txt = "";
	$posy=$posy+4;
	$pdf->SetFont('','', 10);
	$pdf->writeHTMLCell(170, 3,$marge_gauche+10, $posy, $txt, 0, 1,false,true, 'C');
	//ANNEE
	$txt = "ANNEE ACADEMIQUE: ".$_SESSION['ANNEESSCOLAIRE'];
	$posy=$posy+7;
	$pdf->SetFont('','', 6);
	$pdf->writeHTMLCell(70, 3,$marge_gauche+150, $posy, $txt, 0, 1,false,true, 'L');
	//CLASSE
	$txt = "CLASSE: ".$classe;
	$posy=$posy+4;
	$pdf->SetFont('','', 6);
	$pdf->writeHTMLCell(70, 3,$marge_gauche+150, $posy, $txt, 0, 1,false,true, 'L');
	//NIVEAU
	$txt = "NIVEAU: ".$niveau;
	$posy=$posy+4;
	$pdf->SetFont('','', 6);
	$pdf->writeHTMLCell(70, 3,$marge_gauche+150, $posy, $txt, 0, 1,false,true, 'L');
	//NOM PRENOM
	$txt = "PRENOM: ".$row_rq_eleve['PRENOMS']." ".$row_rq_eleve['NOM'];
	$posy=$posy+2;
	$pdf->SetFont('','', 6);
	$pdf->writeHTMLCell(170, 3,$marge_gauche, $posy, $txt, 0, 1,false,true, 'L');
	//DATE DE NAISSANCE
	$txt = "DATE ET LIEU DE NAISSANCE: ".$row_rq_eleve['DATNAISSANCE']."  ";
	$posy=$posy+3;
	$pdf->SetFont('','', 6);
	$pdf->writeHTMLCell(170, 3,$marge_gauche, $posy, $txt, 0, 1,false,true, 'L');
	
	$txt = "RELEVE DE NOTES ".$row_rq_periode['NOM_PERIODE'];
	$posy=$posy+5;
	$pdf->SetFont('','B', 10);
	$pdf->writeHTMLCell(170, 3,$marge_gauche+10, $posy, $txt, 0, 1,false,true, 'C');
	//UNITES D ENSEIGNEMENT
	$txt = "UNITES D 'ENSEIGNEMENT";
	$posy=$posy+10;
	$pdf->SetFont('','B', 8);
	$pdf->writeHTMLCell(90, 3, $marge_gauche+3, $posy, $txt, 0, 1);
	
	// Rect prend une longueur en 3eme param
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche, $posy-2, 45, 7);
	
	$txt = "Valeur Credit ";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 45+12, $posy, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+45, $posy-2, 15, 7);
	
	$txt = $row_rq_periode['NOM_PERIODE'];
	$pdf->SetFont('','B', 7);
	$pdf->writeHTMLCell(100, 3, 57+15, $posy-2, $txt, 0, 1,false,true, 'C');
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+60, $posy-2, 125, 3);
	
	$txt = "CC/TD";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 57+15, $posy+2, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+60, $posy+1, 15, 4);
	
	$txt = "EXAM";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 57+30, $posy+2, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+75, $posy+1, 15, 4);
	
	$txt = "MOY";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 87+15, $posy+2, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+90, $posy+1, 15, 4);
	
	$txt = "APPRECIATION";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 102+15, $posy+2, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+105, $posy+1, 20, 4);
	
	$txt = "MOY UE";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 117+20, $posy+2, $txt, 0, 1);
	 
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+125, $posy+1, 15, 4);
	
	$txt = "MOY*COEF";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 137+15, $posy+2, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+140, $posy+1, 15, 4);
	
	$txt = "Nb credits obtenus";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(15, 3, 152+15, $posy+1, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+155, $posy+1, 15, 4);
	
	$txt = "Validite du credit";
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(30, 3, 165+15, $posy+2, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+170, $posy+1, 15, 4);
	$posy=$posy+7;
	$nb_cresh_tot=0;
	$nb_cresh_obt=0;
	$moy_sem=0;
	while($row_rq_ue = mysql_fetch_assoc($rq_ue))
	{
		$idue= $row_rq_ue['IDUE'];
		$colname_rq_matiere = "-1";
		if (isset($idue)) {
		  $colname_rq_matiere = $idue;
		}
		mysql_select_db($database_connexion, $connexion);
		$query_rq_matiere = sprintf("SELECT MATIERE.IDMATIERE, MATIERE.LIBELLE, MATIERE_UE.IDUE, MATIERE_UE.IDMATIERE, MATIERE_UE.nbcredit FROM MATIERE, MATIERE_UE WHERE MATIERE_UE.IDMATIERE = MATIERE.IDMATIERE AND MATIERE_UE.IDUE=%s", GetSQLValueString($colname_rq_matiere, "int"));
		$rq_matiere = mysql_query($query_rq_matiere, $connexion) or die(mysql_error());
		$totalRows_rq_matiere = mysql_num_rows($rq_matiere);
		$txt = $row_rq_ue['LIBELLE'];
		$pdf->SetFont('','B', 6);
		$pdf->writeHTMLCell(45, 3, $marge_gauche+3, $posy-1, $txt, 0, 1);
		
		// Rect prend une longueur en 3eme param
		$pdf->SetDrawColor(192,192,192);
		$pdf->Rect($marge_gauche, $posy-2, 45, 7);
		
		$pdf->SetDrawColor(192,192,192);
		$pdf->Rect($marge_gauche+45, $posy-2, 140, 7);
		$posy=$posy+7;
		$posY=$posy-2;
		$i=1;
		$nb_cresh=0;
		$moy_ue=0;
		while($row_rq_matiere = mysql_fetch_assoc($rq_matiere))
		{
			$idperiode=$colname_rq_periode;
			$idmatiere=$row_rq_matiere['IDMATIERE'];
			$ideleve=$row_rq_classe_eleve['IDINDIVIDU'];
			$colname_rq_cc = "-1";
			if (isset($idmatiere)) {
			  $colname_rq_cc = $idmatiere;
			}
			$colname3_rq_cc = "-1";
			if (isset($idperiode)) {
			  $colname3_rq_cc = $idperiode;
			}
			$colname2_rq_cc = "-1";
			if (isset($ideleve)) {
			  $colname2_rq_cc = $ideleve;
			}
			mysql_select_db($database_connexion, $connexion);
			$query_rq_cc = sprintf("SELECT avg( NOTE.NOTE) as moy FROM NOTE, CONTROLE WHERE NOTE.IDCONTROLE=CONTROLE.IDCONTROLE AND CONTROLE.IDTYP_CONTROL=5 AND CONTROLE.IDMATIERE=%s AND NOTE.IDINDIVIDU=%s AND CONTROLE.IDPERIODE=%s", GetSQLValueString($colname_rq_cc, "int"),GetSQLValueString($colname2_rq_cc, "int"),GetSQLValueString($colname3_rq_cc, "int"));
			$rq_cc = mysql_query($query_rq_cc, $connexion) or die(mysql_error());
			$row_rq_cc = mysql_fetch_assoc($rq_cc);
			$totalRows_rq_cc = mysql_num_rows($rq_cc);
			
			$colname_rw_exam = "-1";
			if (isset($idmatiere)) {
			  $colname_rw_exam = $idmatiere;
			}
			$colname2_rw_exam = "-1";
			if (isset($ideleve)) {
			  $colname2_rw_exam = $ideleve;
			}
			$colname3_rw_exam = "-1";
			if (isset($idperiode)) {
			  $colname3_rw_exam = $idperiode;
			}
			mysql_select_db($database_connexion, $connexion);
			$query_rw_exam = sprintf("SELECT avg( NOTE.NOTE) as moy FROM NOTE, CONTROLE WHERE NOTE.IDCONTROLE=CONTROLE.IDCONTROLE AND CONTROLE.IDTYP_CONTROL=2 AND CONTROLE.IDMATIERE=%s AND NOTE.IDINDIVIDU=%s AND CONTROLE.IDPERIODE=%s", GetSQLValueString($colname_rw_exam, "int"),GetSQLValueString($colname2_rw_exam, "int"),GetSQLValueString($colname3_rw_exam, "int"));
			$rw_exam = mysql_query($query_rw_exam, $connexion) or die(mysql_error());
			$row_rw_exam = mysql_fetch_assoc($rw_exam);
			$totalRows_rw_exam = mysql_num_rows($rw_exam);
			$txt =$row_rq_matiere['LIBELLE'];
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(40, 3, $marge_gauche+3, $posY, $txt, 0, 1);
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche, $posy-2, 45, 3);
			
			
			// Nombre de credit de la matiere
			$nb_cresh=$nb_cresh+$row_rq_matiere['nbcredit'];
			$txt =$row_rq_matiere['nbcredit'] ;
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(40, 3, $marge_gauche+52, $posY, $txt, 0, 1);
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche+45, $posy-2, 15, 3);
			
			
			// Moyenne de CC
			$txt =number_format($row_rq_cc['moy'], 2, ',', ' '); ;
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(40, 3, $marge_gauche+64, $posY, $txt, 0, 1);
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche+60, $posy-2, 15, 3);
			
			
			// Moyenne des exams
			$txt =number_format($row_rw_exam['moy'], 2, ',', ' '); ;
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(40, 3, $marge_gauche+79, $posY, $txt, 0, 1);
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche+75, $posy-2, 15, 3);
			
			// Moyenne Matiere
			$moy=($row_rw_exam['moy']+$row_rq_cc['moy'])/2;
			$moy_ue=$moy_ue+$moy;
			$txt =number_format($moy, 2, ',', ' '); ;
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(40, 3, $marge_gauche+94, $posY, $txt, 0, 1);
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche+90, $posy-2, 15, 3);
			
			// Appreciation Matiere
			$txt ="Abien" ;
			if($moy>=16)
				$txt = "Excellent";
			else if(($moy>=14)&&($moy<16))
				$txt = "Bon Travail";
			else if(($moy>=12)&&($moy<14))
				$txt = "Abien";
			else
				$txt = "Insuffisant";
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(20, 3, $marge_gauche+105, $posY, $txt, 0, 1,false,true, 'C');
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche+105, $posy-2, 20, 3);
			
			// Moyenne UE
			if($i==$totalRows_rq_matiere){
				
				$moy_sem=(($moy_ue/$i)*$nb_cresh)+$moy_sem;
				$txt =number_format($moy_ue/$i, 2, ',', ' ');
				$pdf->SetFont('','', 5);
				$pdf->writeHTMLCell(40, 3, $marge_gauche+130, $posY - (3*($i-1))/2, $txt, 0, 1);
				
				$pdf->SetDrawColor(192,192,192);
				$pdf->Rect($marge_gauche+125, $posy-2  - (3*($i-1)), 15, 3*$i);
			}
			// Moyenne fois coeff
			$txt =number_format($moy*$row_rq_matiere['nbcredit'], 2, ',', ' ');
			$pdf->SetFont('','', 5);
			$pdf->writeHTMLCell(40, 3, $marge_gauche+144, $posY, $txt, 0, 1);
			
			$pdf->SetDrawColor(192,192,192);
			$pdf->Rect($marge_gauche+140, $posy-2, 15, 3);
			
			
			if($i==$totalRows_rq_matiere){
				// nombre de credits obtenus
				$txt =0 ;
				if(($moy_ue/$i)>10){
					$nb_cresh_obt=$nb_cresh+$nb_cresh_obt;
					$txt =$nb_cresh ;
				}
				$pdf->SetFont('','', 5);
				$pdf->writeHTMLCell(40, 3, $marge_gauche+160, $posY- (3*($i-1))/2, $txt, 0, 1);
				
				$pdf->SetDrawColor(192,192,192);
				$pdf->Rect($marge_gauche+155, $posy-2 -(3*($i-1)), 15, 3*$i);
				// validation UE
				$txt ="Non val" ;
				if(($moy_ue/$i)>10)
				$txt ="val" ;
				$pdf->SetFont('','', 5);
				$pdf->writeHTMLCell(40, 3, $marge_gauche+174, $posY- (3*($i-1))/2, $txt, 0, 1);
				
				$pdf->SetDrawColor(192,192,192);
				$pdf->Rect($marge_gauche+170, $posy-2 -(3*($i-1)), 15, 3*$i);
			}
			$posy=$posy+3;
			$posY=$posy-2;
			$i++;
		}
		$nb_cresh_tot=$nb_cresh_tot+$nb_cresh;
	}
	
	$txt ="TOTAUX" ;
	$pdf->SetFont('','B', 5);
	$pdf->writeHTMLCell(45, 4, $marge_gauche, $posY+0.5, $txt, 0, 1,false,true, 'C');
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche, $posy-2, 45, 3);
	// Nombre de credit total
	$txt =$nb_cresh_tot ;
	$pdf->SetFont('','B', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+52, $posY, $txt, 0, 1);
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+45, $posy-2, 15, 3);
	// Nombre de credit total obtenus
	$txt =$nb_cresh_obt ;
	$pdf->SetFont('','B', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+160, $posY, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+155, $posy-2 , 15, 3);
	
	$txt = "MOYENNE SEMESTRIELLE: ";
	$posy=$posy+7;
	$posY=$posy-2;
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche, $posY, $txt, 0, 1);
	$pdf->SetFont('','B', 5);
	$moy=@($moy_sem/$nb_cresh_tot);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+40, $posY, number_format($moy, 2, ',', ' '), 0, 1);
	$txt = "CREDITS OBTENUS:   ";
	$posy=$posy+3;
	$posY=$posy-2;
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche, $posY, $txt, 0, 1);
	$pdf->SetFont('','B', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+40, $posY,$nb_cresh_obt, 0, 1);
	
	$txt = "NOMBRE D HEURES D ABSENCE";
	$posy=$posy+3;
	$posY=$posy-2;
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche, $posY, $txt, 0, 1);
	$pdf->SetFont('','B', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+40, $posY,$nb_cresh_obt." heures ", 0, 1);
	$txt = "APPRECIATIONS GENERALES";
	$posy=$posy+2;
	$posY=$posy;
	$pdf->SetFont('','', 5);
	$pdf->writeHTMLCell(40, 3, $marge_gauche, $posY, $txt, 0, 1);
	
	$pdf->SetDrawColor(192,192,192);
	$pdf->Rect($marge_gauche+40, $posY, 35, 3);
	if($moy>=16)
		$txt = "Excellent";
	else if(($moy>=14)&&($moy<16))
		$txt = "Bon Travail";
	else if(($moy>=12)&&($moy<14))
		$txt = "Assez Bon Travail";
	else
		$txt = "Insuffisant";
	$pdf->SetFont('','B', 8);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+43, $posY-0.5,$txt, 0, 1);
	$pdf->SetFont('','B', 8);
	$pdf->writeHTMLCell(40, 3, $marge_gauche+150, $posY," Le directeur des études ", 0, 1);
	
}
//Close and output PDF document
$pdf->Output('INSCRIPTION.pdf', 'I');
 
?>
