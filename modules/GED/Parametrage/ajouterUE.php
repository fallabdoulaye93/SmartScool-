

<?php
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

require_once("classe/UEManager.php");
require_once("classe/UE.php");

$connection =  new Connexion();
$dbh = $connection->Connection();

$ue=new UEManager($dbh,'UE');


if(isset($_POST) && $_POST !=null) {

               $res=$ue->insert($_POST);
               $urlredirect="";
			   if($res==1){
			      
                   $msg = 'Ajout effectué avec succés';


                   //$urlredirect="profile.php?msg=$msg&res=$res";
			   }
               else{
                   $msg = 'Ajout effectué avec echec';
                  // $urlredirect="profile.php?msg=$msg&res=$res";


			   }
    //header("Location:$urlredirect");
    header("Location: uniteEnseignement.php?msg=".$msg."&res=".$res);
}

?>