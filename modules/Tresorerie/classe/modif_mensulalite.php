
<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("../../restriction.php");


require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil'] != 1) 
$lib->Restreindre($lib->Est_autoriser(27,$_SESSION['profil']));


$colname_rq_mensualite = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_mensualite = $_SESSION['etab'];
}

$idIndividu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $idIndividu = $_GET['IDINDIVIDU'];
}

$query_rq_individu = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = $idIndividu");
$rq_individu = $query_rq_individu->fetchObject();



$colname_rq_inscription = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_inscription = $_GET['IDINSCRIPTION'];
}

$query_rq_inscription = $dbh->query("SELECT INSCRIPTION.*, NIVEAU.LIBELLE, SERIE.LIBSERIE FROM INSCRIPTION, NIVEAU, SERIE WHERE IDINSCRIPTION = ".$colname_rq_inscription." AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU AND INSCRIPTION.IDSERIE=SERIE.IDSERIE");

$row_rq_inscription = $query_rq_inscription->fetchObject();

//echo $query_rq_inscription;
//historique de la mensualite
$colname_rq_historique_mensulaite = "-1";
if (isset($_GET['IDINSCRIPTION'])) {
  $colname_rq_historique_mensulaite = $_GET['IDINSCRIPTION'];
}

$query_rq_historique_mensulaite = $dbh->query("SELECT * FROM MENSUALITE WHERE IDINSCRIPTION = ".$colname_rq_historique_mensulaite." ORDER BY IDMENSUALITE ASC");




//echo $query_rq_historique_mensulaite;
// cout total de la formation
if($row_rq_inscription->IDSERIE!=NULL or  $row_rq_inscription->IDNIVEAU!=NULL)
{
$colname_rq_cout_formation = $row_rq_inscription->IDSERIE;

$query_rq_cout_formation = $dbh->query("SELECT * FROM NIVEAU_SERIE WHERE IDSERIE = ".$colname_rq_cout_formation." AND NIVEAU_SERIE.IDNIVEAU=".$row_rq_inscription->IDNIVEAU);
//echo $query_rq_cout_formation;

$row_rq_cout_formation = $query_rq_cout_formation->fetchObject();

}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $mois=$lib->Le_mois($_POST['MOIS'])." / ".$_POST['anne'];
  
//IDMENSUALITE MOIS MONTANT DATEREGLMT IDINSCRIPTION IDETABLISSEMENT MT_VERSE MT_RELIQUAT id_type_paiment
  $insertSQL = $dbh->prepare("INSERT INTO MENSUALITE ( MOIS, MONTANT, DATEREGLMT, IDINSCRIPTION, IDETABLISSEMENT, MT_VERSE, MT_RELIQUAT,id_type_paiment) VALUES (:MOIS, :MONTANT, :DATEREGLMT, :IDINSCRIPTION, :IDETABLISSEMENT, :MT_VERSE, :MT_RELIQUAT,:id_type_paiment)");
  $insertSQL->execute(array(
    "MOIS" => $mois,
    "MONTANT" => $_POST['MONTANT'],
    "DATEREGLMT" => $_POST['DATEREGLMT'],
	"IDINSCRIPTION" => $_POST['IDINSCRIPTION'],
    "IDETABLISSEMENT" => $_POST['IDETABLISSEMENT'],
    "MT_VERSE" => $_POST['MT_VERSE'],
	"MT_RELIQUAT" => $_POST['MT_RELIQUAT'],
    "id_type_paiment" => $_POST['id_type_paiment']
));
  
  //$Result1 = $dbh->query($insertSQL);
  $colname_rq_max_mensualite = "-1";
if (isset($_POST['IDINSCRIPTION'])) {
  $colname_rq_max_mensualite = $_POST['IDINSCRIPTION'];
}

$query_rq_max_mensualite = $dbh->query("SELECT MAX(MENSUALITE.IDMENSUALITE) as nb FROM MENSUALITE WHERE MENSUALITE.IDINSCRIPTION=".$colname_rq_max_mensualite);

$row_rq_max_mensualite = $query_rq_max_mensualite->fetchObject();



$query_rq_paiement = $dbh->query("SELECT * FROM TYPE_PAIEMENT");

$row_rq_paiement = $query_rq_paiement->fetchObject();


    $insertGoTo = "../../ged/imprimer_recu.php?IDINDIVIDU=".$_POST['IDINDIVIDU']."&IDMENSUALITE=".$row_rq_max_mensualite->nb;

 //  $insertGoTo = "fiche_mensualite.php?IDINSCRIPTION=". $_POST['IDINSCRIPTION']."&IDINDIVIDU=".$_POST['IDINDIVIDU']; 
 header(sprintf("Location: %s", $insertGoTo));
}
//cout total
$somme_frais= $row_rq_inscription->FRAIS_INSCRIPTION+$row_rq_inscription->FRAIS_DOSSIER+$row_rq_inscription->FRAIS_EXAMEN+$row_rq_inscription->UNIFORME+ $row_rq_inscription->VACCINATION+ $row_rq_inscription->ASSURANCE+$row_rq_inscription->FRAIS_SOUTENANCE ;
$cout_total_formation=($row_rq_inscription->ACCORD_MENSUELITE * $row_rq_cout_formation->dure) + $somme_frais;
///ECHO $row_rq_inscription['FRAIS_INSCRIPTION'];
//total verse
$total_verse=$row_rq_inscription->ACCOMPTE_VERSE+$row_rq_inscription->MONTANT_DOSSIER+$row_rq_inscription->MONTANT_EXAMEN+$row_rq_inscription->MONTANT_UNIFORME+$row_rq_inscription->MONTANT_VACCINATION+ $row_rq_inscription->MONTANT_ASSURANCE+$row_rq_inscription->MONTANT_SOUTENANCE ;

//echo $total_verse;
$visibe=" ";
//echo $row_rq_cout_formation['FRAIS_INSCRIPTION'];

if(isset($_POST['payer']) && $_POST['payer'] =="Payer la mensualité") {
//IDMENSUALITE MOIS MONTANT DATEREGLMT IDINSCRIPTION IDETABLISSEMENT MT_VERSE MT_RELIQUAT id_type_paiment

   $req = $dbh->prepare('UPDATE `MENSUALITE` SET `MOIS`=:MOIS, `MONTANT`=:MONTANT, `DATEREGLMT`=:DATEREGLMT, `IDINSCRIPTION`=:IDINSCRIPTION, `IDETABLISSEMENT`=:IDETABLISSEMENT, `MT_VERSE`=:MT_VERSE,`MT_RELIQUAT`=:MT_RELIQUAT,`id_type_paiment`=:id_type_paiment  WHERE IDMENSUALITE=:IDMENSUALITE');
    $req->bindParam(':MOIS', $_POST['MOIS'], PDO::PARAM_STR);
	 $req->bindParam(':MONTANT', $_POST['MONTANT'], PDO::PARAM_STR);
	  $req->bindParam(':DATEREGLMT', $_POST['DATEREGLMT'], PDO::PARAM_STR);
	   $req->bindParam(':IDINSCRIPTION', $_GET['IDINSCRIPTION'], PDO::PARAM_STR);
	    $req->bindParam(':IDETABLISSEMENT', $_SESSION['etab'], PDO::PARAM_STR);
		 $req->bindParam(':MT_VERSE', $_POST['MT_VERSE'], PDO::PARAM_STR);
		  $req->bindParam(':MT_RELIQUAT', $_POST['MT_RELIQUAT'], PDO::PARAM_STR);
		   $req->bindParam(':id_type_paiment', $_POST['id_type_paiment'], PDO::PARAM_STR);
		   $req->bindParam(':IDMENSUALITE', $_GET['IDMENSUALITE'], PDO::PARAM_STR);
    $res=$req->execute();
    if ($res==1) {
        $msg="modification reussie";

    }
    else{
        $msg="modification echouee";
    }
    echo "<meta http-equiv='refresh' content='0;URL=ficheMensualite.php?msg=$msg&res=$res'>";
}

?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li class="active">Mensualites</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                    
                     <div class="panel panel-default">
                    <div class="panel-heading">
                        &nbsp;&nbsp;&nbsp;

                        <div class="btn-group pull-right">
							
                            
                        </div>

                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) 
						  {?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $_GET['msg']; ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $_GET['res']!=1) 
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $_GET['msg']; ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                
      
                    
                     <form action="" method="post" name="form1" id="form1">
        <fieldset class="cadre"><legend > EMETTRE UN REGLEMENT</legend>
        <div class="row">
        <div class="col-lg-4">
        <label for="MOIS" class="control-label">MOIS</label>
        <select name="MOIS" class="form-control">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
         </select>
         </div>
         
           <div class="col-lg-4">   
              <label for="anne" class="control-label">ANNEE</label>
                <select name="anne" class="form-control">
                  <option value="<?php echo  date('Y');?>"><?php echo  date('Y');?></option>
                  <option value="2012">2012</option>
                  <option value="2013">2013</option>
                  
                </select>
          </div>    
              
              <div class="col-lg-4">
               <label for="MONTANT" class="control-label">MONTANT</label>
                <input name="MONTANT" id="MONTANT" type="text" class="form-control" value="<?php echo $lib->nombre_form($row_rq_inscription->ACCORD_MENSUELITE); ?>"  />
                </div></div>
                
             <div class="row">
             <div class="col-lg-4">
             <label for="DATEREGLMT" class="control-label">DATE REGLEMENT</label>
                <input name="DATEREGLMT" type="text" class="form-control" id="date_foo" value="<?php echo date('Y-m-d');?>"   />
                </div>
              
              <div class="col-lg-4">
               <label for="MT_VERSE" class="control-label">MONTANT VERSE</label>
              <input name="MT_VERSE" id="MT_VERSE" type="text" class="form-control"  />
              </div>
              
              <div class="col-lg-4">
              
             <label for="MT_RELIQUAT">MONTANT RELIQUAT</label>  
            <input name="MT_RELIQUAT" type="text" id="MT_RELIQUAT" class="form-control"  onclick="mont_reliquat();"  onchange="mont_reliquat();"/>
            </div></div>
            
            <div class="row">
            <div class="col-lg-4">
            <label for="id_type_paiment" class="control-label">MODE PAYEMENT</label>  
                <select name="id_type_paiment" class="form-control">
                  <option value="" disabled="disabled" selected="selected">choisir</option>
                  <option value="1">chèque</option>
                  <option value="2">espèce</option>
                  <option value="3">virement</option>
                </select>
                </div>
                <div class="col-lg-4">
               <label for="" class="control-label">&nbsp;&nbsp;&nbsp;</label> 
             <input  type="submit"  class="btn btn success" name="payer" value="Payer la mensualité"  />
             </div></div>
        </fieldset>
       <input type="hidden" name="IDMENSUALITE" value="<?php echo $_GET['IDMENSUALITE'];?>" />
         <input type="hidden" name="IDINDIVIDU" value="<?php echo $_GET['IDINDIVIDU'];?>" />
        <input type="hidden" name="IDETABLISSEMENT" value="<?php  echo $_SESSION['etab'];?>" />
        
      </form>
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>