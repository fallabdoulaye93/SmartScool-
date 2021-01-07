<?php
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
require_once("classe/RecrutManager.php");
require_once("classe/Recrut.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if(isset($_POST) && $_POST !=null)
{
    $mois = count($_POST['MOIS']);

    $typeexo = $lib->securite_xss($_POST['FK_TYPE_EXONERATION']);
    if($mois > 0 && $typeexo > 0)
    {
        $query="DELETE FROM MOIS_EXONORE WHERE IDINSCRIPTION=:IDINSCRIPTION";
        try
        {
            $moisExo = $dbh->prepare($query);
            $moisExo->execute(array("IDINSCRIPTION"=>$lib->securite_xss($_POST['idinscription'])));
            $moisExo->execute();
            for($i=0; $i< $mois;$i++)
            {
                $stmt = $dbh->prepare("INSERT INTO MOIS_EXONORE(IDINSCRIPTION, MOIS)VALUES (?, ?)");
                $res1 = $stmt->execute(array($lib->securite_xss($_POST['idinscription']), $_POST['MOIS'][$i]));
                if($res1==1)
                {
                    $query = $dbh->prepare("UPDATE INSCRIPTION SET NBRE_EXONORE =:NBRE_EXONORE, FK_TYPE_EXONERATION =:FK_TYPE_EXONERATION WHERE IDINSCRIPTION =:IDINSCRIPTION");
                    $res2 = $query->execute(array("NBRE_EXONORE"=>$mois, "FK_TYPE_EXONERATION"=>$typeexo, "IDINSCRIPTION"=>$lib->securite_xss($_POST['idinscription'])));
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
        catch(PDOException $e)
        {
            $msg="Ajout effectué avec echec ";
        }
    }
    else{
        $msg="Données envoyées invalides";
    }
}
else{
    $msg="Veuillez renseigner les champs obligatoires";
}
header("Location: exonoration.php?msg=".$msg."&res=".$res2);
?>