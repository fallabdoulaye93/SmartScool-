

<?php
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");



$connection =  new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();



if(isset($_POST) && $_POST !=null) {
var_dump($lib->securite_xss($_POST['nombre']));exit;
////if ($lib->securite_xss($_POST['MOIS'])!='')
    $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDNIVEAU=" .$lib->securite_xss($_POST['IDNIVEAU']). " AND IDETABLISSEMENT = " . $etab);
    $rs_niv = $query_rq_niv->fetchObject();
    $libelleCycle=$rs_niv->LIBELLE;
    if($lib->securite_xss($_POST['SEXE'])==0){
        $sexe="Fille";
    }elseif ($lib->securite_xss($_POST['SEXE'])==1){
        $sexe="Garçon";
    }
    if($lib->securite_xss($_POST['NIVEAU'])!=null){
        $niv=$lib->securite_xss($_POST['NIVEAU']);
    }else{
        $niv=0;
    }
    $libTrousseau="Trousseau ".$libelleCycle." pour  ".$sexe;
    $nbre = count($_POST['nombre']);
    if($nbre>0){

        try
        {

            for($i=0; $i< $nbre;$i++){
                //var_dump($i);exit;
                // var_dump($_POST['MOIS'][$i]);exit;
                $stmt = $dbh->prepare("INSERT INTO TROUSSEAU(LIBELLE, MONTANT, FK_NIVEAU, CYCLE, SEXE)VALUES (?, ?, ?, ?, ?)");
                $res1 = $stmt->execute(array($libelleCycle, $_POST['nombre'][$i]*$_POST['montant'][$i],  $lib->securite_xss($_POST['IDNIVEAU']), $niv, $lib->securite_xss($_POST['SEXE']) ));
                if($res1==1){
                    $last_id = $dbh->lastInsertId();
                    $query = $dbh->prepare("INSERT INTO ELEMENT_TROUSSEAU (FK_TROUSSEAU, FK_UNIFORME,  NOMBRE) VALUES (?, ?, ?, ?)");
                    $res2 = $query->execute(array($last_id, $lib->securite_xss($_POST['FK_uniform']), $_POST['nombre'][$i]));
                    if($res2==1){
                        $msg = 'Ajout effectué avec succés';

                    } else{
                        $msg = 'Ajout effectué avec echec';


                    }
                }
            }

        }
        catch(PDOException $e)
        {
            $msg="Ajout effectué avec echec ";

            //return -2;
        }
    }

    header("Location: exonoration.php?msg=".$msg."&res=".$res2);



}

?>