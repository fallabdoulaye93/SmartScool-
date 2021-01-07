<?php

if (session_status() == 1) {
    session_start();
}
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();


function readinscrit($id)
{
    $connection = new Connexion();
    $dbh = $connection->Connection();

    $query = "SELECT IDINSCRIPTION FROM INSCRIPTION WHERE  INSCRIPTION.IDINDIVIDU = :id";
    $query = $dbh->prepare($query);
    $query->bindParam(":id", $id);
    $query->execute();
    $query = $query->fetchAll(PDO::FETCH_OBJ);
    return $query[0]->IDINSCRIPTION;
}

function readEtab($id)
{
    $connection = new Connexion();
    $dbh = $connection->Connection();

    $query = "SELECT PREFIXE FROM ETABLISSEMENT,INDIVIDU WHERE  INDIVIDU.IDETABLISSEMENT=ETABLISSEMENT.IDETABLISSEMENT  AND INDIVIDU.IDINDIVIDU = :id";
    $query = $dbh->prepare($query);
    $query->bindParam(":id", $id);
    $query->execute();
    $query = $query->fetchAll(PDO::FETCH_OBJ);
    return $query[0]->PREFIXE;
}

function readIDEtab($id)
{
    $connection = new Connexion();
    $dbh = $connection->Connection();

    $query = "SELECT ETABLISSEMENT.IDETABLISSEMENT FROM ETABLISSEMENT,INDIVIDU WHERE  INDIVIDU.IDETABLISSEMENT=ETABLISSEMENT.IDETABLISSEMENT  AND INDIVIDU.IDINDIVIDU = :id";
    $query = $dbh->prepare($query);
    $query->bindParam(":id", $id);
    $query->execute();
    $query = $query->fetchAll(PDO::FETCH_OBJ);
    return $query[0]->IDETABLISSEMENT;
}


if ($_GET['val'] == 1 && $_GET['montant'] != '') {
    //$bdd = new PDO("mysql:host=$d$bdd = Connection();
    $montant = $lib->securite_xss($_GET['montant']);
    $inscrit = readinscrit($_SESSION['etudiant']);
    $etat = 1;
    $requat = 0;
    $facture = $_SESSION['numfact'];
    $query = sprintf("UPDATE FACTURE SET FACTURE.MT_VERSE =:MT_VERSE,FACTURE.ETAT=:ETAT ,FACTURE.MT_RELIQUAT=:MT_RELIQUAT
		WHERE FACTURE.NUMFACTURE=:facture");
    $result = $dbh->prepare($query);
    $result->bindParam("MT_VERSE", $montant);
    $result->bindParam("ETAT", $etat);
    $result->bindParam("MT_RELIQUAT", $requat);
    //$result->bindParam("IDINSCRIPTION",$inscrit);
    $result->bindParam("facture", $facture);
    $count = $result->execute();
    $resultat = 0;
    if ($count == 1) {
        $datejour = date('Y-m-d');
        $MT_RELIQUAT = 0;
        $id_type_paiment = 4;
        $sigle = readEtab($_SESSION['etudiant']);
        $idEtab = readIDEtab($_SESSION['etudiant']);
        $mois = $lib->Le_mois($_SESSION['mois']);
        $numtransaction = $lib->genererNumTransaction($sigle);
        $query = sprintf("INSERT INTO MENSUALITE(MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT, id_type_paiment,numtransac,NUMFACT) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT, :id_type_paiment,:numtransac,:numfact)");
        $result = $dbh->prepare($query);
        $result->bindParam("MOIS", $mois);
        $result->bindParam("MONTANT", $montant);
        $result->bindParam("DATEREGLMT", $datejour);
        $result->bindParam("IDINSCRIPTION", $inscrit);
        $result->bindParam("IDETABLISSEMENT", $idEtab);
        $result->bindParam("MT_VERSE", $montant);
        $result->bindParam("MT_RELIQUAT", $MT_RELIQUAT);
        $result->bindParam("id_type_paiment", $id_type_paiment);
        $result->bindParam("numtransac", $numtransaction);
        $result->bindParam("numfact", $facture);

        $resultat = $result->execute();
        if ($resultat == 1) {
            $mes = "Votre paiement d’un montant de ".$_SESSION['montant']." F.CFA a été effectué avec succés";
            $MM_restrictGoTo = "mensualite.php?IDETUDIANT=".$_SESSION['etudiant']."&NOM=".$_SESSION['nomEtu']."&msg=".$mes."&res=1";

            $_SESSION['montant'] = NULL;
            unset($_SESSION['montant']);
            $_SESSION['redirection'] = NULL;
            unset($_SESSION['redirection']);
            $_SESSION['etudiant'] = NULL;
            unset($_SESSION['etudiant']);
            $_SESSION['mois'] = NULL;
            unset($_SESSION['mois']);
            $_SESSION['numfact'] = NULL;
            unset($_SESSION['numfact']);
            $_SESSION['nomEtu'] = NULL;
            unset($_SESSION['nomEtu']);
        } else {
            $mes = "Votre paiement d’un montant de ".$_SESSION['montant']." F.CFA a échoué";
            $MM_restrictGoTo = "mensualite.php?IDETUDIANT=".$_SESSION['etudiant']."&NOM=".$_SESSION['nomEtu']."&msg=".$mes."&res=0";
        }
    }
    $dbh = null;
} else {
    $mes = "Votre paiement d’un montant de ".$_SESSION['montant']." F.CFA a échoué";
    $MM_restrictGoTo = "mensualite.php?IDETUDIANT=".$_SESSION['etudiant']."&NOM=".$_SESSION['nomEtu']."&msg=".$mes."&res=0";
}
?>
<a href="<?= $MM_restrictGoTo; ?>" id="link" class="hidden" target="_top"></a>
<script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>
<script>
    (function redirect (){ $("#link")[0].click(); })()
</script>
