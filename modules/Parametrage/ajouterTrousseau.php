<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");

$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(53, $lib->securite_xss($_SESSION['profil'])));

$etab = "-1";
if (isset($_SESSION['etab'])) {
    $etab = $lib->securite_xss($_SESSION['etab']);
}

if(isset($_POST) && $_POST !=null)
{
    $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDNIVEAU=" .$lib->securite_xss($_POST['FK_NIVEAU']));
    $rs_niv = $query_rq_niv->fetchObject();
    $libelleCycle=$rs_niv->LIBELLE;
    if($lib->securite_xss($_POST['sexe'])==0){
        $sexe="Fille";
    }
    elseif ($lib->securite_xss($_POST['sexe'])==1){
        $sexe="Garçon";
    }
    if($lib->securite_xss($_POST['niveau'])!=null){
        $niv=$lib->securite_xss($_POST['niveau']);
    }else{
        $niv=0;
    }
    $libTrousseau="Trousseau ".strtolower($libelleCycle)." pour  ".$sexe;
    $nbre = count($lib->securite_xss($_POST['nombre']));
    if($nbre>0){
        try
        {
           if($niv==0)
           {
                $rq_trousseau=$dbh->query("SELECT T.ROWID, T.LIBELLE, T.MONTANT, n.LIBELLE as LIBCYCLE, T.CYCLE, T.SEXE, T.FK_NIVEAU as NIV FROM TROUSSEAU T
                                        INNER JOIN NIVEAU n ON n.IDNIVEAU = T.FK_NIVEAU
                                        WHERE T.IDETABLISSEMENT = ".$etab." 
                                        AND T.FK_NIVEAU = ".$lib->securite_xss($_POST['FK_NIVEAU']) ." 
                                        AND T.SEXE =".$lib->securite_xss($_POST['sexe']));
            }
            else
            {
                $rq_trousseau=$dbh->query("SELECT T.ROWID, T.LIBELLE, T.MONTANT, n.LIBELLE as LIBCYCLE, T.CYCLE, T.SEXE, T.FK_NIVEAU as NIV FROM TROUSSEAU T
                                        INNER JOIN NIVEAU n ON n.IDNIVEAU = T.FK_NIVEAU
                                        WHERE T.IDETABLISSEMENT = ".$etab." 
                                        AND T.FK_NIVEAU = ".$lib->securite_xss($_POST['FK_NIVEAU']) ." 
                                        AND T.SEXE =".$lib->securite_xss($_POST['sexe']) ." 
                                        AND T.CYCLE = ".$niv);
            }
            $trousseau=$rq_trousseau->fetchObject();
            if($trousseau==false)
            {
                $stmt = $dbh->prepare("INSERT INTO TROUSSEAU(LIBELLE, MONTANT, FK_NIVEAU, CYCLE, SEXE, IDETABLISSEMENT)VALUES (?, ?, ?, ?, ?, ?)");
                $res1 = $stmt->execute(array($libTrousseau, $lib->securite_xss($_POST['montantT']),  $lib->securite_xss($_POST['FK_NIVEAU']), $niv, $lib->securite_xss($_POST['sexe']), $etab));
                $last_id = $dbh->lastInsertId();
                if($res1==1)
                {
                    for($i=0; $i< $nbre;$i++)
                    {
                            $query = $dbh->prepare("INSERT INTO ELEMENT_TROUSSEAU (FK_TROUSSEAU, FK_UNIFORME,  NOMBRE) VALUES (?, ?, ?)");
                            $res2 = $query->execute(array($last_id, $_POST['FK_uniform'][$i], $_POST['nombre'][$i]));
                            if($res2==1)
                            {
                                $msg = 'Ajout effectué avec succés';
                            }
                            else
                            {
                                $msg = 'Ajout effectué avec echec';
                            }
                    }
                }
            }
            else
            {
                $msg = 'Ce trousseau existe deja!';
            }
        }
        catch(PDOException $e)
        {
            $msg="Ajout effectué avec echec ";
        }
    }
    header("Location: trousseau.php?msg=".$msg."&res=".$res2);
}

?>