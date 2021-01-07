<?php
session_start(); 
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
?>
<?php


$colname_rq_type_ind = "-1";
if (isset($_GET['TYPE_INDIVIDU'])) {
  $colname_rq_type_ind = $lib->securite_xss(base64_decode($_GET['TYPE_INDIVIDU']));
}

$query_rq_type_ind = $dbh->query("SELECT LIBELLE FROM TYPEINDIVIDU WHERE IDTYPEINDIVIDU = ".$colname_rq_type_ind);
$row_rq_type_ind = $query_rq_type_ind->fetchObject();


$titre=$row_rq_type_ind->LIBELLE;

$colname_rq_etudiant = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etudiant = $_SESSION['etab'];
}
//Filtrere
$From=" FROM INDIVIDU ";
$where=" WHERE INDIVIDU.IDETABLISSEMENT =$colname_rq_etudiant AND INDIVIDU.IDTYPEINDIVIDU=".$lib->securite_xss(base64_decode($_GET['TYPE_INDIVIDU']));

if(base64_decode($_GET['TYPE_INDIVIDU'])==8)
{
	$From .=" ,INSCRIPTION,NIVEAU,SERIE ";
	$where.=" AND INDIVIDU.IDINDIVIDU = INSCRIPTION.IDINDIVIDU AND NIVEAU.IDNIVEAU = INSCRIPTION.IDNIVEAU AND SERIE.IDSERIE = INSCRIPTION.IDSERIE AND INSCRIPTION.ETAT= 1 ";
    if(isset($_GET['CLASSROOM']) && $_GET['CLASSROOM']!='')
    {
        $From .=" ,AFFECTATION_ELEVE_CLASSE, CLASSROOM";
        $where.=" AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM=".$lib->securite_xss(base64_decode($_GET['CLASSROOM']))." AND AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INDIVIDU.IDINDIVIDU AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM ";
        //libelle de la classe
        $colname_rq_classe = "-1";
        if (isset($_GET['CLASSROOM'])) {
            $colname_rq_classe = $lib->securite_xss(base64_decode($_GET['CLASSROOM']));
        }

        $query_rq_classe = $dbh->query("SELECT LIBELLE FROM CLASSROOM WHERE IDCLASSROOM = ".$colname_rq_classe);

        $row_rq_classe = $query_rq_classe->fetchObject();

        $titre.=" de la classe : ".$row_rq_classe->LIBELLE;
    }
//
    if(isset($_GET['NIVEAU'])&& $_GET['NIVEAU']!='')
    {
        $where.=" AND INSCRIPTION.IDNIVEAU=".$lib->securite_xss(base64_decode($_GET['NIVEAU']));
        //
        $colname_rq_niveau = "-1";
        if (isset($_SESSION['etab'])) {
            $colname_rq_niveau = $_SESSION['etab'];
        }

        $query_rq_niveau = $dbh->query("SELECT LIBELLE FROM NIVEAU WHERE IDETABLISSEMENT = ".$colname_rq_niveau." AND IDNIVEAU=".$lib->securite_xss(base64_decode($_GET['NIVEAU'])));

        $row_rq_niveau =$query_rq_niveau->fetchObject();

        $titre.=" du niveau : ".$row_rq_niveau->LIBELLE;
        //
    }
    //
    if(isset($_GET['FILIERE']) && $_GET['FILIERE']!='')
    {
        $where.=" AND INSCRIPTION.IDSERIE=".$lib->securite_xss(base64_decode($_GET['FILIERE']));
        $colname_rq_filiere = "-1";
        if (isset($_SESSION['etab'])) {
            $colname_rq_filiere = $_SESSION['etab'];
        }

        $query_rq_filiere = $dbh->query("SELECT LIBSERIE FROM SERIE WHERE IDETABLISSEMENT = ".$colname_rq_filiere." AND IDSERIE=".$lib->securite_xss(base64_decode($_GET['FILIERE'])));

        $row_rq_filiere = $query_rq_filiere->fetchObject();

        $titre.=" de la  filiére : ".$row_rq_filiere->LIBSERIE;
    }

    $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, `SERIE`.`LIBSERIE`, NIVEAU.LIBELLE ".$From." " .$where." ");
}else {
    $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, INDIVIDU.COURRIEL ".$From." " .$where." ");
}

?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table width="661" height="97" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr >
    <td height="19" colspan="6" class="Titre"><?php echo $titre; ?></td>
  </tr>
  <tr >
    <td height="3" colspan="6" bgcolor="#FF0000"></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="17" height="19">&nbsp;</td>
    <td width="95" align="left" valign="middle" class="titretablo">Matricule</td>
    <td width="168" align="left" valign="middle" class="titretablo">Prenom</td>
    <td width="101" align="left" valign="middle" class="titretablo">Nom</td>
      <?php if(base64_decode($_GET['TYPE_INDIVIDU'])!=8) { ;?>
          <td width="140" align="left" valign="middle" class="titretablo">EMAIL</td>
          <td width="119" align="left" valign="middle" class="titretablo">TEL </td>
      <?php } else { ;?>
          <td width="140" align="left" valign="middle" class="titretablo">CYCLE</td>
          <td width="119" align="left" valign="middle" class="titretablo">FILIERE</td>
      <?php }
      ;?>
  </tr>
  <?php 
	 
	 foreach ($query_rq_etudiant->fetchAll() as $row_rq_etudiant ) { 
	       
	  ?>
  <tr >
    <td height="20" align="center" valign="middle"><img src="../images/icoindividu.png"/></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['MATRICULE']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['PRENOMS']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo $row_rq_etudiant['NOM']; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo base64_decode($_GET['TYPE_INDIVIDU']) !=8 ?  $row_rq_etudiant['COURRIEL'] : $row_rq_etudiant['LIBELLE'] ; ?></td>
    <td align="left" valign="middle" class="textBrute"><?php echo base64_decode($_GET['TYPE_INDIVIDU']) !=8 ? $row_rq_etudiant['TELMOBILE'] : $row_rq_etudiant['LIBSERIE']; ?></td>
  </tr>
  <?php
		
		 }  ?>
</table>
</page>


