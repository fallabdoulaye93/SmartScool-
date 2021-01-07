<?php
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

$colname_rq_etablissement = "1";
if (isset($_GET['idetablissement'])) {
    $colname_rq_etablissement = $lib->securite_xss(base64_decode($_GET['idetablissement']));
}


try
{
    $query_rq_etablissement = $dbh->query("SELECT IDETABLISSEMENT, NOMETABLISSEMENT_, SIGLE, ADRESSE, TELEPHONE, VILLE, PAYS, FAX, MAIL, SITEWEB, LOGO FROM ETABLISSEMENT WHERE IDETABLISSEMENT = ".$colname_rq_etablissement);
    $row_rq_etablissement =$query_rq_etablissement->fetchObject();

    $colname_rq_eleve = "-1";
    if (isset($_GET['idinscription'])) {
        $colname_rq_eleve = $lib->securite_xss(base64_decode($_GET['idinscription']));
    }
   // var_dump($colname_rq_eleve);exit;

    $query_rq_eleve = $dbh->query("SELECT INS.*, IND.*, S.LIBSERIE, CL.LIBELLE, NIV.ID_NIV_SER, NIV.dure, NI.LIBELLE as niveauetude, A.LIBELLE_ANNEESSOCLAIRE, B.LABEL 
                                      FROM INSCRIPTION INS
                                      INNER JOIN INDIVIDU IND ON IND.IDINDIVIDU = INS.IDINDIVIDU 
                                      INNER JOIN SERIE S ON INS.IDSERIE = S.IDSERIE 
                                      INNER JOIN AFFECTATION_ELEVE_CLASSE AFF ON INS.IDINDIVIDU = AFF.IDINDIVIDU 
                                      INNER JOIN CLASSROOM CL ON CL.IDCLASSROOM = AFF.IDCLASSROOM 
                                      INNER JOIN NIVEAU_SERIE NIV ON INS.IDNIVEAU = NIV.IDNIVEAU
                                      INNER JOIN NIVEAU NI ON NI.IDNIVEAU = INS.IDNIVEAU 
                                      INNER JOIN ANNEESSCOLAIRE A ON A.IDANNEESSCOLAIRE = INS.IDANNEESSCOLAIRE 
                                      LEFT JOIN BANQUE B ON B.ROWID = INS.FK_BANQUE 
                                      WHERE INS.IDINSCRIPTION = ".$colname_rq_eleve);
    $row_rq_eleve = $query_rq_eleve->fetchObject();
    $colname_rq_tuteur = "-1";
    if (isset($row_rq_eleve->IDTUTEUR)) {
        $colname_rq_tuteur = $row_rq_eleve->IDTUTEUR;
    }
    if($row_rq_eleve->FK_MOYENPAIEMENT==2) {
        $moyen= "Cheque";
        $num_cheque=$row_rq_eleve->NUM_CHEQUE;
    }else{
        $moyen= "Espece";
    }

    $query_rq_tuteur = $dbh->query("SELECT * FROM INDIVIDU WHERE INDIVIDU.IDINDIVIDU = ".$colname_rq_tuteur);
    $row_rq_tuteur = $query_rq_tuteur->fetchObject();
    $colname_rq_pays =$row_rq_eleve->NATIONNALITE ;

    $query_rq_pays = $dbh->query("SELECT * FROM PAYS WHERE ROWID = ".$colname_rq_pays);
    $row_rq_pays = $query_rq_pays->fetchObject();

    //dure de la formation
    $colname_rq_dure_formation = $row_rq_eleve->IDSERIE;
    $colname1_rq_dure_formation =$row_rq_eleve->IDNIVEAU;

 /*   $query_rq_dure_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE IDSERIE = ".$colname_rq_dure_formation." AND NIVEAU_SERIE.IDNIVEAU = ".$colname1_rq_dure_formation);
    $row_rq_dure_formation = $query_rq_dure_formation->fetchObject();*/

   $query_rq_dure_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE NIVEAU_SERIE.IDNIVEAU = ".$colname1_rq_dure_formation);
    $row_rq_dure_formation = $query_rq_dure_formation->fetchObject();

    $mensPD=($row_rq_eleve->ACCORD_MENSUELITE*2);
    $colname_rq_nbremois = "-1";
    if (isset($_GET['nbremois'])) {

        $colname_rq_nbremois = $lib->securite_xss($_GET['nbremois']);
        $montant_nbre_mois=($row_rq_eleve->ACCORD_MENSUELITE*$colname_rq_nbremois);

    }else{
        $montant_nbre_mois=0;
    }
    //cout total
    if($row_rq_eleve->MONTANT_UNIFORME>0){
        $somme_frais= $row_rq_eleve->FRAIS_INSCRIPTION+$row_rq_eleve->FRAIS_DOSSIER+$row_rq_eleve->MONTANT_TRANSPORT+$row_rq_eleve->FRAIS_EXAMEN+$row_rq_eleve->MONTANT_UNIFORME+ $row_rq_eleve->VACCINATION+ $row_rq_eleve->ASSURANCE+$row_rq_eleve->FRAIS_SOUTENANCE+$mensPD ;

    }else{
        $somme_frais= $row_rq_eleve->FRAIS_INSCRIPTION+$row_rq_eleve->FRAIS_DOSSIER+$row_rq_eleve->MONTANT_TRANSPORT+$row_rq_eleve->FRAIS_EXAMEN+$row_rq_eleve->UNIFORME+ $row_rq_eleve->VACCINATION+ $row_rq_eleve->ASSURANCE+$row_rq_eleve->FRAIS_SOUTENANCE+$mensPD ;

    }
    $cout_total_formation=($row_rq_eleve->ACCORD_MENSUELITE * ($row_rq_dure_formation->dure-2)) + $somme_frais;
    //$cout_scolarite=($row_rq_eleve->ACCORD_MENSUELITE * $row_rq_dure_formation->dure) + $row_rq_eleve->FRAIS_INSCRIPTION;
    $cout_scolarite = $row_rq_eleve->FRAIS_INSCRIPTION;
}
catch (PDOException $e)
{
    echo -2;die();
}


$marge_gauche=10;
$marge_droite=10;
$marge_haute=10;
$marge_basse=10;
$page_largeur=160;
$posy=10;
$posx=60;
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// add a page
$pdf->AddPage();
if($row_rq_etablissement->LOGO)
    $pdf->Image("../logo_etablissement/".$row_rq_etablissement->LOGO, $marge_gauche, $posy, 0, 20);
//if($row_rq_eleve->PHOTO_FACE)
//$pdf->Image("../imgtiers/".$row_rq_eleve->PHOTO_FACE, $page_largeur, $posy, 0, 20);
// set some text for example
$txt = $row_rq_etablissement->NOMETABLISSEMENT_;
$pdf->SetFont('','', 10);
$posy=$posy+2;
$pdf->writeHTMLCell(90, 3,$posx, $posy, $txt, 0, 1,false,true, 'C');
$txt =$row_rq_etablissement->ADRESSE;
$pdf->SetFont('','', 8);
$posy=$posy+5;
$pdf->writeHTMLCell(110, 3,$posx-10, $posy, $txt, 0, 1,false,true, 'C');
$txt = "FICHE D'INSCRIPTION";
$posy=$posy+15;
$pdf->SetFont('','B', 10);
$pdf->writeHTMLCell(170, 3,$marge_gauche+10, $posy, $txt, 0, 1,false,true, 'C');

$txt = "Domaine:";
$posy=$posy+5;
$pdf->SetFont('','B', 8);
$pdf->SetX(20);
$pdf->SetY($posy);
$pdf->Cell(20, 3, $txt);
$txt = $row_rq_eleve->LIBSERIE;
$pdf->SetFont('','', 8);
$pdf->SetXY(25,$posy);
$pdf->Cell(20, 3, $txt);

$txt = "Annee Scolaire:";
$posy=$posy+5;
$pdf->SetFont('','B', 8);
$pdf->SetX($posx+90);
$pdf->Cell(20, 3, $txt);
$txt = $row_rq_eleve->LIBELLE_ANNEESSOCLAIRE;
$posy=$posy+5;
$pdf->SetFont('','', 8);
$pdf->SetX(180);
$pdf->Cell(20, 3, $txt);

$txt = "IDENTIFICATION DE L'ELEVE:";
$posy=$posy+5;
$pdf->SetFont('','B', 8);
$pdf->writeHTMLCell(90, 3, $posx-23, $posy, $txt, 0, 1);
$nexY = $pdf->GetY();
$height_note=$nexY-10;
// Rect prend une longueur en 3eme param
$pdf->SetDrawColor(192,192,192);
// IDENTIFICATION DE L'ETUDIANT
$pdf->Rect($marge_gauche, $posy, 100, 45);
// Num etudiant
$txt = "Matricule:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posy+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $row_rq_eleve->MATRICULE);
//Prénom et nom
$txt = "Prénom et nom:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $row_rq_eleve->PRENOMS." ".$row_rq_eleve->NOM);
//Date de naissance
$txt = "Date de naissance:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $lib->date_franc($row_rq_eleve->DATNAISSANCE));

//Nationalité
$txt = "Nationalité:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3,$row_rq_pays->LIBELLE );

//Adresse
$txt = "Adresse:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $row_rq_eleve->ADRES);

//Téléphone
$txt = "Téléphone:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $row_rq_eleve->TELMOBILE);

//Email
$txt = "Email:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $row_rq_eleve->COURRIEL);

//Classe
$txt = "Classe:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
//$pdf->SetXY($posx+27,$posY);
$pdf->writeHTMLCell(70, 3, $posx+27, $posY, $row_rq_eleve->LIBELLE, 0, 1);

//Date d'inscription
$txt = "Date d'inscription:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY+2);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY+2);
$pdf->Cell(100, 3,$lib->date_franc($row_rq_eleve->DATEINSCRIPT));

// SITUATION FAMILIALE
$pdf->Rect($marge_gauche+100, $posy, 90, 10);
// Célibataire
$txt = "Célibataire:";
$pdf->SetFont('','', 8);
$posY=$posy+4;
$posx=$marge_gauche+100+2;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+17,$posY);
$html = <<<EOD
<input type="checkbox" name="agree" value="1" />
EOD;
//$pdf->Cell(100, 3, "Tivaouane");
$pdf->writeHTML($html, true, 0, true, 0);

// Marié 
$txt = "Marié:";
$pdf->SetFont('','', 8);
$posx=$posx+23;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+10,$posY);
$html = <<<EOD



<input type="checkbox" name="agree" value="1" />
EOD;
$pdf->writeHTML($html, true, 0, true, 0);

// Marié 
$txt = "Divorcé:";
$pdf->SetFont('','', 8);
$posx=$posx+15;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+14,$posY);
$html = <<<EOD



<input type="checkbox" name="agree" value="1" />
EOD;
$pdf->writeHTML($html, true, 0, true, 0);

// Veuf 
$txt = "Veuf:";
$pdf->SetFont('','', 8);
$posx=$posx+20;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+10,$posY);
$html = <<<EOD



<input type="checkbox" name="agree" value="1" />
EOD;
$pdf->writeHTML($html, true, 0, true, 0);
// ANCIENNE SCOLARITE
$pdf->Rect($marge_gauche+100, $posy+10, 90,35);
//Ancienne école
$txt = "Ancienne école:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2+100;
$posY=$posy+12;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+37,$posY);
if(strlen($row_rq_eleve->DERNIER_ETAB) > 0){
    $pdf->Cell(100, 3, $row_rq_eleve->DERNIER_ETAB);
}
else{
    $pdf->Cell(100, 3, '');
}
//Niveau d'étude
$txt = "Niveau d'étude:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+37,$posY);
$pdf->Cell(100, 3, $row_rq_eleve->niveauetude);
//Autres Diplome
$txt = "";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+25,$posY);
$pdf->Cell(100, 3, "");

// ZONE TUTEUR
$posY=$posY+28;
$pdf->Rect($marge_gauche, $posY, 190, 25);
/*// Nom tuteur
$txt = "IDENTIFICATION DU PARENT / TUTEUR :";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+1;
$pdf->SetXY($posx,$posY);
$pdf->writeHTMLCell(190, 3,$posx, $posY, $txt, 0, 1,false,true, 'C');
//$pdf->Cell(20, 3, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+43,$posY);
//exe
$txt = "Nom ou dénomination sociale :";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+43,$posY);
$pdf->Cell(150, 3, $row_rq_tuteur->PRENOMS." ".$row_rq_tuteur->NOM);
// Employeur tuteur
$txt = "Employeur:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+20,$posY);
$pdf->Cell(150, 3, "");
// Adresse: tuteur
$txt = "Adresse:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+20,$posY);
$pdf->Cell(150, 3, $row_rq_tuteur->ADRES);
// Tel domicile tuteur
$txt = "Tel domicile:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+20,$posY);
$pdf->Cell(150, 3, $row_rq_tuteur->TELDOM);
// Tel Bureau tuteur
$txt = "Tel Bureau:";
$pdf->SetFont('','B', 8);
$pdf->SetXY($posx+60,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+77,$posY);
$pdf->Cell(150, 3, "");
// Tel portable tuteur
$txt = "Tel portable:";
$pdf->SetFont('','B', 8);
$pdf->SetXY($posx+120,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+139,$posY);
$pdf->Cell(150, 3, $row_rq_tuteur->TELMOBILE);
// N pièce d´identité tuteur
$txt = "N pièce d´identité:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+25,$posY);
$pdf->Cell(150, 3, $row_rq_tuteur->NUMID);
// RC tuteur
$txt = "RC:";
$pdf->SetFont('','B', 8);
$pdf->SetXY($posx+60,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+77,$posY);
$pdf->Cell(150, 3,$row_rq_tuteur->NUMID);
// Dèlivré le : tuteur
$txt = "Dèlivré le :";
$pdf->SetFont('','B', 8);
$pdf->SetXY($posx+120,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+139,$posY);
$pdf->Cell(150, 3, "");*/

// ZONE ENGAGEMENT
$txt = "ENGAGEMENTS";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+8;
$pdf->SetXY($posx,$posY);
$pdf->writeHTMLCell(190, 3,$posx, $posY, $txt, 0, 1,false,true, 'C');
$posY=$posY+5;
//$posY=$posY+13;
$pdf->Rect($marge_gauche, $posY, 190, 65);
$pdf->Rect($marge_gauche+110, $posY, 80, 65);
// nom étudiant et tuteur
$txt = "Je soussigné:  Mr/Mme ".$row_rq_eleve->PRENOMS." ".$row_rq_eleve->NOM." ";
//$txt = "Je soussigné ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+20,$posY);
//$pdf->Cell(100, 3,  $row_rq_eleve['PRENOMS']." ".$row_rq_eleve['NOM']);
$txt = "Je soussigné: ";
$pdf->SetFont('','B', 8);
$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+110+20,$posY);
$pdf->Cell(100, 3, $row_rq_tuteur->PRENOMS." ".$row_rq_tuteur->NOM);
//engagement 
$txt = "m´engage á payer le cout de ma scolarité ainsi libellé:";
$pdf->SetFont('','B', 8);
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, "m'engage á avaliser le paiement de la scolarité de ");

//MOYEN DE PAIEMENT:
$txt = "Moyen de paiement ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(120, 3, $moyen);

if($row_rq_eleve->FK_MOYENPAIEMENT==2) {
    $txt = "Numero cheque ";
    $pdf->SetFont('', 'B', 8);
    $posx = $marge_gauche + 2;
    $posY = $posY + 4;
    $pdf->SetXY($posx, $posY);
    $pdf->Cell(20, 0, $txt);
    $pdf->SetFont('', '', 8);
    $pdf->SetXY($posx + 27, $posY);
    $pdf->Cell(120, 3, $num_cheque);

    $txt = "Banque ";
    $pdf->SetFont('', 'B', 8);
    $posx = $marge_gauche + 2;
    $posY = $posY + 4;
    $pdf->SetXY($posx, $posY);
    $pdf->Cell(20, 0, $txt);
    $pdf->SetFont('', '', 8);
    $pdf->SetXY($posx + 27, $posY);
    $pdf->Cell(120, 3, $row_rq_eleve->LABEL);
}
// Scolarité Annuelle:
$txt = "Frais inscription: ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $lib->nombre_form($cout_scolarite)." FCFA");
$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, "M. ". $row_rq_eleve->PRENOMS." ".$row_rq_eleve->NOM);
// Bibliothèque
$txt = "Bibliothèque ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
//$pdf->SetXY($posx+27,$posY);
//$pdf->Cell(100, 3, "0 FCFA");
$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, "libellé ci contre pour un montant de ");

/*$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, nombre_form($row_rq_eleve['MONTANT_EXAMEN'])." FCFA");*/

//PREMIER ET DERNIER MOIS:
$txt = "Deux Mois:";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(120, 3, $lib->nombre_form($mensPD)." FCFA");

// Avance mensualite
if($montant_nbre_mois>0) {
    $txt = "Avance mensualite ";
    $pdf->SetFont('', 'B', 8);
    $posx = $marge_gauche + 2;
    $posY = $posY + 4;
    $pdf->SetXY($posx, $posY);
    $pdf->Cell(20, 0, $txt);
    $pdf->SetFont('', '', 8);
    $pdf->SetXY($posx + 27, $posY);
    $pdf->Cell(100, 3, $lib->nombre_form($montant_nbre_mois) . " FCFA");
}


/*$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, nombre_form($row_rq_eleve['MONTANT_EXAMEN'])." FCFA");*/
// Uniforme
$txt = "Uniforme ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3,$lib->nombre_form($row_rq_eleve->UNIFORME)." FCFA");
// Acompte Uniforme
if($row_rq_eleve->MONTANT_UNIFORME>0) {
    $txt = "Acompte uniforme ";
    $pdf->SetFont('', 'B', 8);
    $posx = $marge_gauche + 2;
    $posY = $posY + 4;
    $pdf->SetXY($posx, $posY);
    $pdf->Cell(20, 0, $txt);
    $pdf->SetFont('', '', 8);
    $pdf->SetXY($posx + 27, $posY);
    $pdf->Cell(100, 3, $lib->nombre_form($row_rq_eleve->MONTANT_UNIFORME) . " FCFA");
}
$pdf->SetXY($posx+110,$posY);
$pdf->Cell(20, 0, $lib->nombre_form($cout_total_formation)." francsCFA ");
// transport
$txt = "Transport ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3,$lib->nombre_form($row_rq_eleve->MONTANT_TRANSPORT)." FCFA");
// Assurance
$txt = "Assurance ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $lib->nombre_form($row_rq_eleve->ASSURANCE)." FCFA");
// Frais de dossier
$txt = "Frais de dossier ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $lib->nombre_form($row_rq_eleve->FRAIS_DOSSIER)." FCFA");
// CDI-ASE
$txt = "CDI-ASE: ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
//$pdf->Cell(100, 3, "0 FCFA");
// Frais de stage
$txt = "Frais d'examen ";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+27,$posY);
$pdf->Cell(100, 3, $lib->nombre_form($row_rq_eleve->FRAIS_EXAMEN)." FCFA");
$pdf->writeHTML($html, true, 0, true, 0);

// Frais de stage
$txt = "TOTAL INSCRIPTION";
$pdf->SetFont('','B', 8);
$posx=$marge_gauche+2;
$posY=$posY+4;
$pdf->SetXY($posx,$posY);
$pdf->Cell(20, 0, $txt);
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+30,$posY);
if($row_rq_eleve->MONTANT_UNIFORME>0){
    $pdf->Cell(100, 3, $lib->nombre_form($cout_scolarite + $mensPD + $row_rq_eleve->MONTANT_UNIFORME + $row_rq_eleve->MONTANT_TRANSPORT + $row_rq_eleve->ASSURANCE + $row_rq_eleve->FRAIS_DOSSIER + $row_rq_eleve->FRAIS_EXAMEN + $montant_nbre_mois) . " FCFA");
}else{
    $pdf->Cell(100, 3, $lib->nombre_form($cout_scolarite + $mensPD + $row_rq_eleve->UNIFORME + $row_rq_eleve->MONTANT_TRANSPORT + $row_rq_eleve->ASSURANCE + $row_rq_eleve->FRAIS_DOSSIER + $row_rq_eleve->FRAIS_EXAMEN + $montant_nbre_mois) . " FCFA");
}
$pdf->writeHTML($html, true, 0, true, 0);

// ETUDIANT
$txt = "";
$pdf->SetFont('','', 8);
$posY=$posY+10;
$pdf->SetXY($posx,$posY+3);
$pdf->Cell(20, 0, $txt);
// ETUDIANT
$txt = "";
$pdf->SetFont('','', 8);
$posY=$posY+10;
$pdf->SetXY($posx,$posY+3);
$pdf->Cell(20, 0, $txt);
// TUTEUR
$txt = "TUTEUR";
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+50,$posY+3);
$pdf->Cell(20, 0, $txt);
// PAR
$txt = "";
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+100,$posY+3);
$pdf->Cell(20, 0, $txt);
// LE COMPATABLE
$txt = "LE COMPTABLE";
$pdf->SetFont('','', 8);
$pdf->SetXY($posx+140,$posY+3);
$pdf->Cell(20, 0, $txt);
//Close and output PDF document
//header("Location : ../modules/Tiers/historiqueInscription.php");
$pdf->Output('inscription.pdf', 'D');