<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

/*if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(20,$lib->securite_xss($_SESSION['profil'])));*/

$etab = "-1";
if (isset($_SESSION['etab'])) {
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$idNiveau = "-1";
if(isset($_POST['classe']) && $_POST['classe'] != "" && isset($_POST['IDNIVEAU']) && $_POST['IDNIVEAU'] != "" )
{
    $classe = $lib->securite_xss($_POST['classe']);
    $idNiveau = $lib->securite_xss($_POST['IDNIVEAU']);
    $sexe = $lib->securite_xss($_POST['sexe']);
}

if($idNiveau == 3)
{
    $sqltest = $dbh->query("SELECT COUNT(c.IDCLASSROOM) nb FROM CLASSROOM c INNER JOIN NIV_CLASSE n ON c.IDNIV = n.ID WHERE c.IDNIV IN (9, 10, 11, 12) AND c.IDCLASSROOM = ".$classe);
    $count = $sqltest->fetchObject();
    if($count->nb > 0)
    {
        $sql = $dbh->query("SELECT ROWID, LIBELLE, MONTANT FROM TROUSSEAU WHERE FK_NIVEAU = ".$idNiveau." AND CYCLE = 1 AND SEXE = ".$sexe." AND IDETABLISSEMENT=".$etab);
    }
    else
    {
        $sql = $dbh->query("SELECT ROWID, LIBELLE, MONTANT FROM TROUSSEAU WHERE FK_NIVEAU = ".$idNiveau." AND CYCLE = 2 AND SEXE = ".$sexe." AND IDETABLISSEMENT=".$etab);
    }
}
elseif($idNiveau == 2)
{
    $sql = $dbh->query("SELECT ROWID, LIBELLE, MONTANT FROM TROUSSEAU WHERE FK_NIVEAU = ".$idNiveau." AND CYCLE = 0 AND SEXE = ".$sexe." AND IDETABLISSEMENT=".$etab);
}
else
{
    $sql = $dbh->query("SELECT ROWID, LIBELLE, MONTANT FROM TROUSSEAU WHERE FK_NIVEAU = ".$idNiveau." AND CYCLE = 0 AND IDETABLISSEMENT=".$etab);
}

$classes = array();

while ($classe = $sql->fetchObject())
{
    $classes[] = $classe;
}

echo json_encode($classes);

?>
