<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("../../restriction.php");


require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(26, $_SESSION['profil']));


$colname_rq_mensualite = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_mensualite = $_SESSION['etab'];
}

$idIndividu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
    $idIndividu = $lib->securite_xss(base64_decode($_GET['IDINDIVIDU'])) ;
}

$montant = "-1";
if (isset($_GET['montant'])) {
    $montant = $lib->securite_xss(base64_decode($_GET['montant'])) ;
}

$lemois = "-1";
if (isset($_GET['mois'])) {
    $lemois = $lib->securite_xss(base64_decode($_GET['mois'])) ;
}

$colname_rq_inscription = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
    $colname_rq_inscription = $lib->securite_xss(base64_decode($_GET['IDINSCRIPTION'])) ;
}

$colname_rq_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_anne = $_SESSION['ANNEESSCOLAIRE'];
}


$query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = $idIndividu");
$rq_individu = $query_rq_individu->fetchObject();


$query_type_payement = $dbh->query("SELECT * FROM TYPE_PAIEMENT");
$query_mode_payement = $dbh->query("SELECT `ROWID`, `LIBELLE`, `NBRE_MOIS`, `ETAT`, `IDETABLISSEMENT` FROM `MODE_PAIEMENT`");
$query_type_banque = $dbh->query("SELECT ROWID,LABEL FROM BANQUE WHERE ETAT=1");

$query_rq_inscription = $dbh->query("SELECT INSCRIPTION.*, NIVEAU.LIBELLE, SERIE.LIBSERIE 
                                                FROM INSCRIPTION, NIVEAU, SERIE 
                                                WHERE INSCRIPTION.IDINSCRIPTION = " . $colname_rq_inscription . " 
                                                AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU 
                                                AND INSCRIPTION.IDSERIE=SERIE.IDSERIE 
                                                AND INSCRIPTION.IDANNEESSCOLAIRE=" . $colname_rq_anne);

$row_rq_inscription = $query_rq_inscription->fetchObject();

$query_frais = $dbh->query("SELECT FRAIS_INSCRIPTION,FRAIS_DOSSIER,FRAIS_EXAMEN,UNIFORME,
                                            VACCINATION,ASSURANCE,ACCOMPTE_VERSE,MONTANT_DOSSIER,MONTANT_EXAMEN,MONTANT_UNIFORME,
                                            MONTANT_VACCINATION,MONTANT_ASSURANCE 
                                            FROM INSCRIPTION WHERE IDINSCRIPTION = " . $colname_rq_inscription);

$frais_montant = $query_frais->fetchAll();
//var_dump($frais_montant);die();
$frais_label = array('FRAIS_INSCRIPTION','FRAIS_DOSSIER','FRAIS_EXAMEN','UNIFORME','VACCINATION','ASSURANCE');
$mtn_frais_label = array('ACCOMPTE_VERSE','MONTANT_DOSSIER','MONTANT_EXAMEN','MONTANT_UNIFORME','MONTANT_VACCINATION','MONTANT_ASSURANCE');
$frais = array();
for ($i=0;$i < 6; $i++){
    array_push($frais,$frais_montant[0][$i]);
}
$mnt_frais = array();
for ($i=6;$i < 12; $i++){
    array_push($mnt_frais,$frais_montant[0][$i]);
}

//historique de la mensualite
$colname_rq_historique_mensulaite = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
    $colname_rq_historique_mensulaite = $lib->securite_xss(base64_decode($_GET['IDINSCRIPTION'])) ;
}

$query_rq_historique_mensulaite = $dbh->query("SELECT * FROM MENSUALITE WHERE IDINSCRIPTION = " . $colname_rq_historique_mensulaite . " AND IDETABLISSEMENT = " . $colname_rq_mensualite . " ORDER BY IDMENSUALITE ASC");
//echo $query_rq_historique_mensulaite;
// cout total de la formation
if ($row_rq_inscription->IDSERIE != NULL or $row_rq_inscription->IDNIVEAU != NULL) {
    $colname_rq_cout_formation = $row_rq_inscription->IDSERIE;

    $query_rq_cout_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE NIVEAU_SERIE.IDSERIE = " . $colname_rq_cout_formation . " AND NIVEAU_SERIE.IDNIVEAU=" . $row_rq_inscription->IDNIVEAU);
//echo $query_rq_cout_formation;

    $row_rq_cout_formation = $query_rq_cout_formation->fetchObject();

}
$facture = $lib->securite_xss(base64_decode($_GET['IDFACTURE'])) ;
$query_num_facture = $dbh->query("SELECT NUMFACTURE,MONTANT, MT_VERSE, MT_RELIQUAT, ETAT FROM `FACTURE` WHERE IDFACTURE = " . $facture );
$result_query_facture = $query_num_facture->fetchObject();


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $colname_rq_max_mensualite = "-1";
    if (isset($_POST['IDINSCRIPTION'])) {
        $colname_rq_max_mensualite = $lib->securite_xss(base64_decode($_POST['IDINSCRIPTION']));
    }
    $montant = $lib->securite_xss(base64_decode($_GET['montant']));
    $avance=1;
  // var_dump($arri[0]." ".$arri[1]);exit;

    if ($lib->securite_xss($_POST['id_mode_paiment'])!=1){
        $query_mpayement = $dbh->query("SELECT `ROWID`, `LIBELLE`, `NBRE_MOIS`, `ETAT`, `IDETABLISSEMENT` FROM `MODE_PAIEMENT` WHERE ROWID=".$lib->securite_xss($_POST['id_mode_paiment']));
        $row_mpayement=$query_mpayement->fetchObject();
        $nbresMoisPaiement=$row_mpayement->NBRE_MOIS;
    }else{
        $nbresMoisPaiement=1;
    }

    if($nbresMoisPaiement>1){


        $res = "0";
        $etatt=1;
        $reliqat=0;
        $mnt_verse = "FACTURE.MT_VERSE=".$montant;
        //var_dump($mnt_verse);die();
        $query = sprintf("UPDATE FACTURE SET ".$mnt_verse.",FACTURE.ETAT=:ETAT, FACTURE.MT_RELIQUAT=:MT_RELIQUAT, AVANCE=:AVANCE WHERE FACTURE.IDFACTURE=:fature");
        $result = $dbh->prepare($query);
        $result->bindParam("ETAT", $etatt);
        $result->bindParam("MT_RELIQUAT", $reliqat);
        $result->bindParam("fature", $facture);
        $result->bindParam("AVANCE", $avance);
        $count = $result->execute();
        if ($count == 1) {
            $msg = "Facture payee avec succes";
            $res = "1";

        } else {
            $msg = "Paiement echouee";
            $res = "-1";

        }

        if($res == "1"){
            $mois = $lib->Le_mois(substr($lib->securite_xss($_POST['MOIS']), 0, 2)) . " / " . substr($lib->securite_xss($_POST['MOIS']), 3, 4);
            //var_dump($_POST);die();
            $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE ( MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,id_type_paiment,NUMFACT,NUM_CHEQUE,FK_BANQUE) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:id_type_paiment,:NUMFACT,:NUM_CHEQUE,:FK_BANQUE)");
            $insertSQL->execute(array(
                "MOIS" => $mois,
                "MONTANT" => $montant,
                "DATEREGLMT" => $lib->securite_xss($_POST['DATEREGLMT']),
                "IDINSCRIPTION" => $lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])),
                "IDETABLISSEMENT" => $lib->securite_xss($_POST['IDETABLISSEMENT']),
                "MT_VERSE" => $montant,
                "MT_RELIQUAT" => $reliqat,
                "id_type_paiment" => $lib->securite_xss($_POST['id_type_paiment']),
                "NUMFACT" => $result_query_facture->NUMFACTURE,
                "NUM_CHEQUE" => $lib->securite_xss($_POST['numero']) != '' ? $lib->securite_xss($_POST['numero']) : null,
                "FK_BANQUE" => $lib->securite_xss($_POST['id_type_banque']) != '' ? $lib->securite_xss($_POST['id_type_banque']) : null
            ));

            if (isset($_POST['MONTANT_TRANSPORT_VERSE']) && $_POST['MONTANT_TRANSPORT_VERSE'] != null) {
                $reliq = 0;
                $etatF = 0;
                $insertSQL_Facture = $dbh->prepare("INSERT INTO TRANSPORT_MENSUALITE ( MOIS, MONTANT, DATEREGLEMENT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUM_FACTURE,ETAT) VALUES (:MOIS, :MONTANT, :DATEREGLEMENT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:NUM_FACTURE, :ETAT)");
                $insertSQL_Facture->execute(array(
                    "MOIS" => $mois,
                    "MONTANT" => $lib->securite_xss($_POST['MONTANT_TRANSPORT']),
                    "DATEREGLEMENT" => $lib->securite_xss($_POST['DATEREGLMT']),
                    "IDINSCRIPTION" => $lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])),
                    "IDETABLISSEMENT" => $lib->securite_xss($_POST['IDETABLISSEMENT']),
                    "MT_VERSE" => $lib->securite_xss($_POST['MONTANT_TRANSPORT_VERSE']),
                    "MT_RELIQUAT" => $reliq,
                    "NUM_FACTURE" => $result_query_facture->NUMFACTURE,
                    "ETAT" => $etatF
                ));


            }

        }
        $nbresMoisP=$nbresMoisPaiement-1;
        $idInscription=$lib->securite_xss(base64_decode($_POST['IDINSCRIPTION']));
        for($i=1;$i<=$nbresMoisP;$i++){
            $arri=explode('-',$lib->securite_xss($_POST['MOIS']));
            $arri1=$arri[0]+$i;
            if($arri1<=12){
                $moisP=$arri1."-".$arri[1];
            }else{
                $MP='01';
                $AP=$arri[1]+1;
                $moisP=$MP."-".$AP;

            }

            if ($lib->si_facture_existe($moisP, $idInscription) == 2 || $lib->si_facture_existe($moisP, $idInscription) == 0) {
                $num_facture = "FACT" . $lib->code_identification() . $etablissement;
                $INSERT = "INSERT INTO FACTURE(NUMFACTURE, MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, ETAT, IDANNEESCOLAIRE, AVANCE) VALUES (:NUMFACTURE, :MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :ETAT, :IDANNEESCOLAIRE, :AVANCE)";
                $reqIns = $dbh->prepare($INSERT);
                $reqIns->execute(array(
                    ':NUMFACTURE' => $num_facture,
                    ':MOIS' => $moisP,
                    ':MONTANT' => $montant,
                    ':DATEREGLMT' => date('Y-m-d'),
                    ':IDINSCRIPTION' => $idInscription,
                    ':IDETABLISSEMENT' => $lib->securite_xss($_POST['IDETABLISSEMENT']),
                    ':MT_VERSE' => $montant,
                    ':MT_RELIQUAT' => 0,
                    ':ETAT' => 1,
                    ':IDANNEESCOLAIRE' => $colname_rq_anne,
                    ':AVANCE' => $avance,
                ));

                if($reqIns==1){
                    $moispP = $lib->Le_mois(substr($moisP, 0, 2)) . " / " . substr($moisP, 3, 4);
                    //var_dump($_POST);die();
                    $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE (MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, NUMFACT) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :NUMFACT)");
                    $insertSQL->execute(array(
                        "MOIS" => $moispP,
                        "MONTANT" => $montant,
                        "DATEREGLMT" => date('Y-m-d'),
                        "IDINSCRIPTION" => $idInscription,
                        "IDETABLISSEMENT" => $etablissement,
                        "MT_VERSE" => $montant,
                        "MT_RELIQUAT" => 0,
                        "NUMFACT" => $num_facture,
                    ));

                    if (isset($_POST['MONTANT_TRANSPORT_VERSE']) && $_POST['MONTANT_TRANSPORT_VERSE'] != null) {
                        $reliq = 0;
                        $etatF = 0;
                        $insertSQL_Facture = $dbh->prepare("INSERT INTO TRANSPORT_MENSUALITE ( MOIS, MONTANT, DATEREGLEMENT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUM_FACTURE,ETAT) VALUES (:MOIS, :MONTANT, :DATEREGLEMENT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:NUM_FACTURE, :ETAT)");
                        $insertSQL_Facture->execute(array(
                            "MOIS" => $moispP,
                            "MONTANT" => $lib->securite_xss($_POST['MONTANT_TRANSPORT']),
                            "DATEREGLEMENT" => $lib->securite_xss($_POST['DATEREGLMT']),
                            "IDINSCRIPTION" => $lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])),
                            "IDETABLISSEMENT" => $lib->securite_xss($_POST['IDETABLISSEMENT']),
                            "MT_VERSE" => $lib->securite_xss($_POST['MONTANT_TRANSPORT_VERSE']),
                            "MT_RELIQUAT" => $reliq,
                            "NUM_FACTURE" => $num_facture,
                            "ETAT" => $etatF
                        ));


                    }
                }

            }

        }

    }else{

        if (isset($_POST['MT_TRANSPORT_RESTANT_RELIQUAT']) && $_POST['MT_TRANSPORT_RESTANT_RELIQUAT'] != null) {
            $req = $lib->securite_xss($_POST['MT_TRANSPORT_RELIQUAT_']);
            $etat_ = -1;
            if($req == "0"){
                $etat_ = 0; // 0 => payé
            }else{
                $etat_ = 1; // 1 => restant
            }
            /*var_dump($lib->securite_xss($_POST['MT_TRANSPORT_RESTANT_RELIQUAT']));
            var_dump($req);
            die();*/
            $q_ = sprintf("UPDATE TRANSPORT_MENSUALITE SET MT_VERSE=MT_VERSE + ".$lib->securite_xss($_POST['MT_TRANSPORT_RESTANT_RELIQUAT']).", MT_RELIQUAT=:MT_RELIQUAT, ETAT=:ETAT WHERE NUM_FACTURE=:NUMFACT");
            $r_ = $dbh->prepare($q_);
            $r_->bindParam("MT_RELIQUAT", $req);
            $r_->bindParam("NUMFACT", $result_query_facture->NUMFACTURE);
            $r_->bindParam("ETAT", $etat_);
            $c_ = $r_->execute();
        }else {
            $mnt_verse = -1;
            if(isset($_POST['MT_RESTANT_RELIQUAT']) && $_POST['MT_RESTANT_RELIQUAT'] != null){
                $mnt_verse = "FACTURE.MT_VERSE=FACTURE.MT_VERSE+".$lib->securite_xss($_POST['MT_RESTANT_RELIQUAT']);
            }elseif($_POST['MT_VERSE'] !=null){
                $mnt_verse = "FACTURE.MT_VERSE=".$lib->securite_xss($_POST['MT_VERSE']);
            }

            $etat = -1;
            $requat = -1;

            if($lib->securite_xss($_POST['MT_RELIQUAT']) == "0"){
                $etat = 1;
                $requat = 0;
            }else{
                $etat = 2;
                $requat = $lib->securite_xss($_POST['MT_RELIQUAT']);
            }

            $res = "0";
            //var_dump($mnt_verse);die();
            $query = sprintf("UPDATE FACTURE SET ".$mnt_verse.",FACTURE.ETAT=:ETAT, FACTURE.MT_RELIQUAT=:MT_RELIQUAT WHERE FACTURE.IDFACTURE=:fature");
            $result = $dbh->prepare($query);
            $result->bindParam("ETAT", $etat);
            $result->bindParam("MT_RELIQUAT", $requat);
            $result->bindParam("fature", $facture);
            $count = $result->execute();
            if ($count == 1) {
                $msg = "Facture payee avec succes";
                $res = "1";

            } else {
                $msg = "Paiement echouee";
                $res = "-1";

            }

            if($res == "1"){
                if(isset($_POST['MT_RESTANT_RELIQUAT']) && $_POST['MT_RESTANT_RELIQUAT'] != null){
                    $q = sprintf("UPDATE MENSUALITE SET MT_VERSE=MT_VERSE + ".$lib->securite_xss($_POST['MT_RESTANT_RELIQUAT']).", MT_RELIQUAT=:MT_RELIQUAT WHERE NUMFACT=:NUMFACT");
                    $r = $dbh->prepare($q);
                    $r->bindParam("MT_RELIQUAT", $requat);
                    $r->bindParam("NUMFACT", $result_query_facture->NUMFACTURE);
                    $c = $r->execute();
                }else{
                    $mois = $lib->Le_mois(substr($lib->securite_xss($_POST['MOIS']), 0, 2)) . " / " . substr($lib->securite_xss($_POST['MOIS']), 3, 4);
                    //var_dump($_POST);die();
                    $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE ( MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,id_type_paiment,NUMFACT,NUM_CHEQUE,FK_BANQUE) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:id_type_paiment,:NUMFACT,:NUM_CHEQUE,:FK_BANQUE)");
                    $insertSQL->execute(array(
                        "MOIS" => $mois,
                        "MONTANT" => $montant,
                        "DATEREGLMT" => $lib->securite_xss($_POST['DATEREGLMT']),
                        "IDINSCRIPTION" => $lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])),
                        "IDETABLISSEMENT" => $lib->securite_xss($_POST['IDETABLISSEMENT']),
                        "MT_VERSE" => $lib->securite_xss($_POST['MT_VERSE']),
                        "MT_RELIQUAT" => $requat,
                        "id_type_paiment" => $lib->securite_xss($_POST['id_type_paiment']),
                        "NUMFACT" => $result_query_facture->NUMFACTURE,
                        "NUM_CHEQUE" => $lib->securite_xss($_POST['numero']) != '' ? $lib->securite_xss($_POST['numero']) : null,
                        "FK_BANQUE" => $lib->securite_xss($_POST['id_type_banque']) != '' ? $lib->securite_xss($_POST['id_type_banque']) : null
                    ));

                }
                if (isset($_POST['MONTANT_TRANSPORT_VERSE']) && $_POST['MONTANT_TRANSPORT_VERSE']!=null) {
                    $requatFac = $lib->securite_xss($_POST['MONTANT_TRANSPORT_RELIQUAT']);
                    $mois = $lib->Le_mois(substr($lib->securite_xss($_POST['MOIS']), 0, 2)) . " / " . substr($lib->securite_xss($_POST['MOIS']), 3, 4);
                    $etatT = -1;
                    if($requatFac == "0"){
                        $etatT = 0; // 0 => payé
                    }else{
                        $etatT = 1; // 1 => restant
                    }

                    $insertSQL_Facture = $dbh->prepare("INSERT INTO TRANSPORT_MENSUALITE ( MOIS, MONTANT, DATEREGLEMENT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,NUM_FACTURE,ETAT) VALUES (:MOIS, :MONTANT, :DATEREGLEMENT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:NUM_FACTURE, :ETAT)");
                    $insertSQL_Facture->execute(array(
                        "MOIS" => $mois,
                        "MONTANT" => $lib->securite_xss($_POST['MONTANT_TRANSPORT']),
                        "DATEREGLEMENT" => $lib->securite_xss($_POST['DATEREGLMT']),
                        "IDINSCRIPTION" => $lib->securite_xss(base64_decode($_POST['IDINSCRIPTION'])),
                        "IDETABLISSEMENT" => $lib->securite_xss($_POST['IDETABLISSEMENT']),
                        "MT_VERSE" => $lib->securite_xss($_POST['MONTANT_TRANSPORT_VERSE']),
                        "MT_RELIQUAT" => $requatFac,
                        "NUM_FACTURE" => $result_query_facture->NUMFACTURE,
                        "ETAT" => $etatT
                    ));
                }
            }
        }




    }


    $valueToUpdate="";
    $existRow = 0;
    foreach ($_POST as $key => $value)
    {
        if(in_array($key,$mtn_frais_label)){
            $existRow += 1;
        }
    }
    if($existRow != 0) {
        foreach ($_POST as $key => $value)
        {
            if(in_array($key,$mtn_frais_label)){
                $valueToUpdate .= $key."=".$key."+".$value.",";
            }
        }
        $valueToUpdate = substr_replace($valueToUpdate ,"", -1);

        $updateInscription = sprintf("UPDATE INSCRIPTION SET ". $valueToUpdate ." WHERE IDINSCRIPTION = " . $colname_rq_inscription);
        $result = $dbh->prepare($updateInscription);
        $result->execute();
    }


    /*$query_rq_max_mensualite = $dbh->query("SELECT MAX(MENSUALITE.IDMENSUALITE) as nb FROM MENSUALITE WHERE MENSUALITE.IDINSCRIPTION=" . $colname_rq_max_mensualite);

    $row_rq_max_mensualite = $query_rq_max_mensualite->fetchObject();


    $query_rq_paiement = $dbh->query("SELECT * FROM TYPE_PAIEMENT");

    $row_rq_paiement = $query_rq_paiement->fetchObject();*/
    

    header("Location: impressionValide.php?msg=".base64_encode($msg)."&res=".base64_encode($res)."&facture=".$_GET['IDFACTURE']."&individu=".$_GET['IDINDIVIDU']."&IDINSCRIPTION=".$_GET['IDINSCRIPTION']);
    //header("Location: facturation.php?msg=$msg&res=$res");
}

$trans = $dbh->query("SELECT MONTANT, MT_VERSE, MT_RELIQUAT, NUM_FACTURE,ETAT FROM `TRANSPORT_MENSUALITE` WHERE TRANSPORT_MENSUALITE.NUM_FACTURE ='".$result_query_facture->NUMFACTURE."'" );
$result_query_trans = $trans->fetchObject();

$somme_frais = $row_rq_inscription->FRAIS_INSCRIPTION + $row_rq_inscription->FRAIS_DOSSIER + $row_rq_inscription->FRAIS_EXAMEN + $row_rq_inscription->UNIFORME + $row_rq_inscription->VACCINATION + $row_rq_inscription->ASSURANCE + $row_rq_inscription->FRAIS_SOUTENANCE;
$cout_total_formation = ($row_rq_inscription->ACCORD_MENSUELITE * $row_rq_cout_formation->dure) + $somme_frais;

$total_verse = $row_rq_inscription->ACCOMPTE_VERSE + $row_rq_inscription->MONTANT_DOSSIER + $row_rq_inscription->MONTANT_EXAMEN + $row_rq_inscription->MONTANT_UNIFORME + $row_rq_inscription->MONTANT_VACCINATION + $row_rq_inscription->MONTANT_ASSURANCE + $row_rq_inscription->MONTANT_SOUTENANCE;


$visibe = " ";


?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TIERS</a></li>
    <li>Mensualit&eacute;s</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-sm-6">
                            <fieldset class="cadre">
                                <legend> Infos personnelles</legend>

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label>MATRICULE: </label>&nbsp;&nbsp;
                                        <?php echo $rq_individu->MATRICULE; ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>PRENOMS: </label>&nbsp;&nbsp;
                                        <?php echo $rq_individu->PRENOMS; ?>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>NOM: </label>&nbsp;&nbsp;
                                        <?php echo $rq_individu->NOM; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label>FILIERE: </label>&nbsp;&nbsp;

                                        <?php echo $row_rq_inscription->LIBSERIE; ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>NIVEAU: </label>&nbsp;&nbsp;
                                        <?php echo $row_rq_inscription->LIBELLE; ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>TELMOBILE: </label>&nbsp;&nbsp;
                                        <?php echo $rq_individu->TELMOBILE; ?>
                                    </div>

                                </div>

                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset class="cadre">
                                <legend> HISTORIQUE DES PAYEMENTS</legend>

                                <table id="histo" class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Mois</th>
                                            <th>Mensualité</th>
                                            <th>Montant versé</th>
                                            <th>Reliquat</th>
                                            <th>Imprimer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // $cout_verse_formation=0;
                                        $monatnt_paye = 0;
                                        foreach ($query_rq_historique_mensulaite->fetchAll() as $row_rq_historique_mensulaite) {
                                            $monatnt_paye = $monatnt_paye + $row_rq_historique_mensulaite['MT_VERSE'];

                                            ?>
                                            <tr>

                                                <td><?php echo $lib->date_franc($row_rq_historique_mensulaite['DATEREGLMT']); ?></td>
                                                <td><?php echo $row_rq_historique_mensulaite['MOIS']; ?></td>
                                                <td><?php echo $lib->nombre_form($row_rq_historique_mensulaite['MONTANT']); ?></td>
                                                <td><?php echo $lib->nombre_form($row_rq_historique_mensulaite['MT_VERSE']); ?></td>
                                                <td><?php echo $lib->nombre_form($row_rq_historique_mensulaite['MT_RELIQUAT']); ?></td>
                                                <td>
                                                    <a href="../../ged/imprimer_recu.php?IDINDIVIDU=<?php echo $rq_individu->IDINDIVIDU; ?>&amp;IDMENSUALITE=<?php echo $row_rq_historique_mensulaite['IDMENSUALITE']; ?>"><i
                                                                class=" glyphicon glyphicon-print"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <table width="100%" height="41" border="0" cellpadding="2" cellspacing="2">
                                    <tr>
                                        <th>cout total</th>
                                        <th>Total vers&eacute;</th>
                                        <th>Restant total</th>
                                    </tr>

                                    <tr>
                                        <td><?php echo $lib->nombre_form($cout_total_formation); ?></td>

                                        <td><?php echo $lib->nombre_form($total_verse + $monatnt_paye); ?></td>

                                        <td><?php echo $lib->nombre_form($cout_total_formation - ($total_verse + $monatnt_paye)) ?></td>
                                    </tr>

                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-12">

                        <form action="" method="post" name="form1" id="form1">
                            <fieldset class="cadre">
                                <legend> EMETTRE UN REGLEMENT</legend>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="MOIS" class="control-label">MOIS</label>
                                        <input type="text" name="MOIS" id="MOIS" readonly value="<?php echo $lemois; ?>"
                                               class="form-control"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="DATEREGLMT" class="control-label">DATE REGLEMENT</label>
                                        <input name="DATEREGLMT" type="text" class="form-control" id="date_foo"
                                               value="<?php echo date('Y-m-d'); ?>"/>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="id_mode_paiment" class="control-label">MODE DE PAIEMENT</label>
                                        <select name="id_mode_paiment" id="id_mode_paiment" required class="form-control">
                                            <?php foreach ($query_mode_payement->fetchAll() as $row_mode_payement) { ?>
                                                <option value="<?php echo $row_mode_payement['ROWID']; ?>"><?php echo $row_mode_payement['LIBELLE']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <br/><br/>
                                <?php  if($result_query_facture->ETAT == '2') { ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="MT_VERSE" class="control-label">MONTANT MENSUALITE DEJÀ VERSE</label>
                                            <input name="MT_VERSE" id="MT_VERSE" type="number" min="0" value="<?php echo $result_query_facture->MT_VERSE ;?>" class="form-control" disabled/>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="MT_RESTANT" class="control-label">MONTANT RESTANT</label>
                                            <input name="MT_RESTANT" id="MT_RESTANT" type="number" min="0" value="<?php echo $result_query_facture->MT_RELIQUAT ;?>" class="form-control" disabled/>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="MT_RESTANT_RELIQUAT">MONTANT VERSE</label>
                                            <input name="MT_RESTANT_RELIQUAT" type="number" id="MT_RESTANT_RELIQUAT" class="form-control" min="0" max="<?php echo $result_query_facture->MT_RELIQUAT ;?>" onBlur="mont_restant_reliquat();" required/>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="MT_RELIQUAT">RELIQUAT</label>
                                            <input name="MT_RELIQUAT" type="number" id="MT_RELIQUAT" class="form-control" onclick="mont_restant_reliquat();" onchange="mont_transport_reliquat();" readonly />
                                        </div>
                                    </div>
                                    <br/>
                                <?php } ;?>
                                <?php  if($result_query_facture->ETAT == '0') { ?>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="MONTANT" class="control-label">MENSUALITE</label>
                                            <input name="MONTANT" id="MONTANT" type="text" class="form-control"
                                                   value="<?php echo $montant ; ?>" readonly/>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="MT_VERSE" class="control-label">MONTANT VERSE</label>
                                            <input name="MT_VERSE" id="MT_VERSE" type="number" min="0"
                                                   max="<?php echo $montant; ?>" class="form-control"
                                                   onBlur="mont_reliquat();" required/>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="MT_RELIQUAT">MONTANT RELIQUAT</label>
                                            <input name="MT_RELIQUAT" type="number" id="MT_RELIQUAT" class="form-control"
                                                   onclick="mont_reliquat();" onchange="mont_reliquat();" readonly required/>
                                        </div>
                                    </div>
                                    <br/>
                                <?php } ;?>

                                <?php  if($row_rq_inscription->TRANSPORT == '1') {
                                        if($result_query_trans){
                                            if($result_query_trans->ETAT == '1'){?>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label for="MT_TRANSPORT_VERSE_d" class="control-label">MONTANT TRANSPORT DEJÀ VERSE</label>
                                                        <input name="MT_TRANSPORT_VERSE_d" id="MT_TRANSPORT_VERSE_d" type="number" min="0" value="<?php echo $result_query_trans->MT_VERSE ;?>" class="form-control" disabled/>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="MT_TRANSPORT_RESTANT" class="control-label">MONTANT TRANSPORT RESTANT</label>
                                                        <input name="MT_TRANSPORT_RESTANT" id="MT_TRANSPORT_RESTANT" type="number" min="0" value="<?php echo $result_query_trans->MT_RELIQUAT ;?>" class="form-control" disabled/>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="MT_TRANSPORT_RESTANT_RELIQUAT">MONTANT VERSE</label>
                                                        <input name="MT_TRANSPORT_RESTANT_RELIQUAT" type="number" id="MT_TRANSPORT_RESTANT_RELIQUAT" class="form-control" min="0" max="<?php echo $result_query_trans->MT_RELIQUAT ;?>" onBlur="mont_transport_restant_reliquat();" required/>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="MT_TRANSPORT_RELIQUAT_">RELIQUAT</label>
                                                        <input name="MT_TRANSPORT_RELIQUAT_" type="number" id="MT_TRANSPORT_RELIQUAT_" class="form-control" onclick="mont_transport_restant_reliquat();" onchange="mont_transport_restant_reliquat();" readonly />
                                                    </div>
                                                </div>
                                            <?php }
                                        }else {?>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="MONTANT_TRANSPORT" class="control-label">TRANSPORT</label>
                                                    <input name="MONTANT_TRANSPORT" id="MONTANT_TRANSPORT" type="text" class="form-control"
                                                           value="<?php echo $row_rq_inscription->MONTANT_TRANSPORT ; ?>" readonly/>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="MONTANT_TRANSPORT_VERSE" class="control-label">MONTANT VERSE</label>
                                                    <input name="MONTANT_TRANSPORT_VERSE" id="MONTANT_TRANSPORT_VERSE" type="number" min="0"
                                                           max="<?php echo $row_rq_inscription->MONTANT_TRANSPORT; ?>" class="form-control"
                                                           onBlur="mont_transport_reliquat();" required/>
                                                </div>

                                                <div class="col-lg-4">

                                                    <label for="MONTANT_TRANSPORT_RELIQUAT">MONTANT RELIQUAT</label>
                                                    <input name="MONTANT_TRANSPORT_RELIQUAT" type="number" id="MONTANT_TRANSPORT_RELIQUAT" class="form-control"
                                                           onclick="mont_transport_reliquat();" onchange="mont_transport_reliquat();" readonly required/>
                                                </div>
                                            </div>
                                            <br/>
                                        <?php }
                                    ?>

                                <?php } ;?>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="id_type_paiment" class="control-label">TYPE DE PAIEMENT</label>
                                        <select name="id_type_paiment" id="id_type_paiment" required class="form-control">
                                            <option value="" disabled="disabled" selected="selected">choisir le type de paiement</option>
                                            <?php foreach ($query_type_payement->fetchAll() as $row_type_payement) { ?>
                                                <option value="<?php echo $row_type_payement['id_type_paiment']; ?>"><?php echo $row_type_payement['libelle_paiement']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div id="lotTypePayement" style="display: none">
                                        <div class="col-lg-4">
                                            <label class="control-label" id="titre_id_type_banque"></label>
                                            <input type="text" class="form-control" name="numero" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="id_type_banque" class="control-label">BANQUE</label>
                                            <select name="id_type_banque" id="id_type_banque" required class="form-control">
                                                <option value="" disabled="disabled" selected="selected">choisir la banque</option>
                                                <?php foreach ($query_type_banque->fetchAll() as $row_type_banque) { ?>
                                                    <option value="<?php echo $row_type_banque['ROWID']; ?>"><?php echo $row_type_banque['LABEL']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="cadre">
                                <legend>RELIQUATS POUR LES FRAIS</legend>
                                <table id="reliquatFrais" class="table">

                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Frais</th>
                                        <th>Montant</th>
                                        <th>Montant vers&eacute;</th>
                                        <th>Montant restant</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    <?php for ($i=0;$i < count($mnt_frais); $i++) {
                                        if (intval($mnt_frais[$i])!=0 && intval($frais[$i])!= 0 &&  intval($mnt_frais[$i]) < intval($frais[$i])){
                                            $restant = intval($frais[$i]) - intval($mnt_frais[$i])?>
                                            <tr>
                                                <td><input type="checkbox" value="<?php echo $i; ?>"></td>
<!--                                                <td style="display: none">--><?php //echo $i; ?><!--</td>-->
                                                <td><?php echo $frais_label[$i]; ?></td>
                                                <td><?php echo $frais[$i]; ?></td>
                                                <td><?php echo $mnt_frais[$i]; ?></td>
                                                <td><?php echo $restant; ?></td>
                                                <td><input name="<?php echo $mtn_frais_label[$i]; ?>" id="nouveauMontant_<?php echo $i; ?>" type="number" value="0" min="0" max="<?php echo $restant; ?>" style="display: none"></td>
                                            </tr>
                                        <?php }
                                    }?>
                                    </tbody>
                                </table>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-lg-4">
                                    <input type="submit" class="btn btn-success" value="Payer la mensualit&eacute;"/>
                                </div>
                                <div class="col-lg-4">
                                </div>
                            </div>
                            <input type="hidden" name="IDMENSUALITE" value=""/>
                            <input type="hidden" name="IDINSCRIPTION" value="<?php echo $_GET['IDINSCRIPTION']; ?>"/>
                            <input type="hidden" name="IDINDIVIDU" value="<?php echo $_GET['IDINDIVIDU']; ?>"/>
                            <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $_SESSION['etab']; ?>"/>
                            <input type="hidden" name="MM_insert" value="form1"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WIDGETS -->


</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>
<script type="text/javascript" src="../../js/dataTables.select.min.js"></script>
<script>
    $(document).ready(function () {
        $('#reliquatFrais').DataTable({
            "language": {
                //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
            },
        })
        $('#histo').DataTable({
            "language": {
                //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
            },
        })
    })

    $('#form1 :checkbox').change(function() {
        // this will contain a reference to the checkbox
        if (this.checked) {
            // the checkbox is now checked
            var currentDataIndex = $(this).val()
            $('#nouveauMontant_'+currentDataIndex).css('display','block')
        } else {
            // the checkbox is now no longer checked
            var currentDataIndex = $(this).val()
            $('#nouveauMontant_'+currentDataIndex).css('display','none')
            $('#nouveauMontant_'+currentDataIndex).val(0)
        }
    });

    $("#id_type_paiment").on('change', function () {
        var selectedPay = $("#id_type_paiment").find("option:selected").val()
        if(selectedPay != 2){
            if(selectedPay == 1){
                $('#titre_id_type_banque').text("NUMERO CHEQUE")
            }else{
                $('#titre_id_type_banque').text("NUMERO VIREMENT")
            }
            $('#lotTypePayement').css('display', 'block')
        }else {
            $('#lotTypePayement').css('display', 'none')
            $('#id_type_banque').prop('selectedIndex',0);
            //$('#id_type_banque').children('option:not(:first)').remove()
        }
    })

    function mont_transport_reliquat() {
        var lmontant = parseInt($('#MONTANT_TRANSPORT').val())
        var lmtverset = parseInt($('#MONTANT_TRANSPORT_VERSE').val())
        var lrestant = lmontant - lmtverset;
        //document.forms['formulaire'].elements['nom'].value
        $('#MONTANT_TRANSPORT_RELIQUAT').val(lrestant)
    }
    function mont_restant_reliquat() {
        var lmontant = parseInt($('#MT_RESTANT').val())
        var lmtverset = parseInt($('#MT_RESTANT_RELIQUAT').val())
        var lrestant = lmontant - lmtverset;
        //document.forms['formulaire'].elements['nom'].value
        $('#MT_RELIQUAT').val(lrestant)
    }
    function mont_transport_restant_reliquat() {
        var lmontant = parseInt($('#MT_TRANSPORT_RESTANT').val())
        var lmtverset = parseInt($('#MT_TRANSPORT_RESTANT_RELIQUAT').val())
        var lrestant = lmontant - lmtverset;
        //document.forms['formulaire'].elements['nom'].value
        $('#MT_TRANSPORT_RELIQUAT_').val(lrestant)
    }
</script>
