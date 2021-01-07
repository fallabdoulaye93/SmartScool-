<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
?>
<?php

try {
    $colname_rq_type_ind = "-1";
    if (isset($_POST['TYPE_INDIVIDU'])) {
        $colname_rq_type_ind = $lib->securite_xss($_POST['TYPE_INDIVIDU']);
    }

    $query_rq_type_ind = $dbh->query("SELECT LIBELLE FROM TYPEINDIVIDU WHERE IDTYPEINDIVIDU = ".$colname_rq_type_ind);
    $row_rq_type_ind = $query_rq_type_ind->fetchObject();


    $titre=$row_rq_type_ind->LIBELLE;

//var_dump($_POST);die();

    $colname_rq_etudiant = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_etudiant = $_SESSION['etab'];
    }


//Filtrere
    $From=" FROM INDIVIDU ";
    $where=" WHERE INDIVIDU.IDETABLISSEMENT =$colname_rq_etudiant AND INDIVIDU.IDTYPEINDIVIDU=".$lib->securite_xss($_POST['TYPE_INDIVIDU']);


    if($lib->securite_xss($_POST['TYPE_INDIVIDU'])==8)
    {
        $From .=" ,INSCRIPTION,NIVEAU,SERIE ";
        $where.=" AND INDIVIDU.IDINDIVIDU = INSCRIPTION.IDINDIVIDU AND NIVEAU.IDNIVEAU = INSCRIPTION.IDNIVEAU AND SERIE.IDSERIE = INSCRIPTION.IDSERIE AND INSCRIPTION.ETAT= 1 ";

        if(isset($_POST['CLASSROOM']) && $lib->securite_xss($_POST['CLASSROOM'])!='')
        {
            $From .=" ,AFFECTATION_ELEVE_CLASSE, CLASSROOM";
            $where.=" AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$lib->securite_xss($_POST['CLASSROOM'])." AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INDIVIDU.IDINDIVIDU AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM ";
            //libelle de la classe
            $colname_rq_classe = "-1";
            if (isset($_POST['CLASSROOM'])) {
                $colname_rq_classe = $lib->securite_xss($_POST['CLASSROOM']);
            }

            $query_rq_classe = $dbh->query("SELECT LIBELLE FROM CLASSROOM WHERE IDCLASSROOM = ".$colname_rq_classe);

            $row_rq_classe = $query_rq_classe->fetchObject();

            $titre.=" de la classe : ".$row_rq_classe->LIBELLE;
        }
//
        if(isset($_POST['NIVEAU']) && $lib->securite_xss($_POST['NIVEAU'])!='')
        {
            $where.=" AND INSCRIPTION.IDNIVEAU=".$lib->securite_xss($_POST['NIVEAU']);
            //
            $colname_rq_niveau = "-1";
            if (isset($_SESSION['etab'])) {
                $colname_rq_niveau = $_SESSION['etab'];
            }

            $query_rq_niveau = $dbh->query("SELECT LIBELLE FROM NIVEAU WHERE IDETABLISSEMENT = ".$colname_rq_niveau." AND IDNIVEAU=".$lib->securite_xss($_POST['NIVEAU']));

            $row_rq_niveau =$query_rq_niveau->fetchObject();

            $titre.=" du niveau : ".$row_rq_niveau->LIBELLE;
            //
        }
//
        if(isset($_POST['FILIERE']) && $lib->securite_xss($_POST['FILIERE'])!='')
        {
            $where.=" AND INSCRIPTION.IDSERIE=".$lib->securite_xss($_POST['FILIERE']);
            $colname_rq_filiere = "-1";
            if (isset($_SESSION['etab'])) {
                $colname_rq_filiere = $_SESSION['etab'];
            }

            $query_rq_filiere = $dbh->query("SELECT LIBSERIE FROM SERIE WHERE IDETABLISSEMENT = ".$colname_rq_filiere." AND IDSERIE=".$lib->securite_xss($_POST['FILIERE']));

            $row_rq_filiere = $query_rq_filiere->fetchObject();

            $titre.=" de la  filiére : ".$row_rq_filiere->LIBSERIE;
        }

        $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, `SERIE`.`LIBSERIE`, NIVEAU.LIBELLE ".$From." " .$where." ");
        $res = $query_rq_etudiant->fetchAll();
        echo json_encode($res);

    } else {
        $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, INDIVIDU.COURRIEL ".$From." " .$where." ");
        $res = $query_rq_etudiant->fetchAll();
        echo json_encode($res);
    }
}catch (PDOException $e){
    echo -1;
}

?>