
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(6,$lib->securite_xss($_SESSION['profil'])));

$colname_REQ_ue = "-1";
if (isset($_SESSION['etab'])) {
    $colname_REQ_ue = $lib->securite_xss($_SESSION['etab']);
}

require_once('classe/FiliereManager.php');
$series=new FiliereManager($dbh,'SERIE');
$serie = $series->getFiliere('IDETABLISSEMENT',$lib->securite_xss($_SESSION['etab']));

require_once('classe/NiveauManager.php');
$niveaux=new NiveauManager($dbh,'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT',$lib->securite_xss($_SESSION['etab']));


$colname_rq_filiere = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_filiere = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_filiere = $dbh->query("SELECT * FROM SERIE WHERE IDETABLISSEMENT = ".$colname_rq_filiere." ORDER BY LIBSERIE ASC");

$row_rq_filiere = $query_rq_filiere->fetchObject();


$colname_rq_niveau = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_niveau = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_niveau = $dbh->query("SELECT * FROM NIVEAU WHERE IDETABLISSEMENT = ".$colname_rq_niveau);

$row_rq_niveau = $query_rq_niveau->fetchObject();


$colname_rq_ue_etab = "-1";
if (isset($_GET['idUE'])) {
    $param=json_decode(base64_decode($_GET['idUE']));
    $colname_rq_ue_etab=$param->id;
}

$query_rq_ue_etab = $dbh->query("SELECT UE.*, NIVEAU.LIBELLE AS LIBNIVEAU, SERIE.LIBSERIE FROM UE, NIVEAU, SERIE WHERE UE.IDUE = ".$colname_rq_ue_etab."  AND SERIE.IDSERIE=UE.IDSERIE AND NIVEAU.IDNIVEAU=UE.IDNIVEAU");

$row_rq_ue_etab = $query_rq_ue_etab->fetchObject();


$colname_rq_ue_matiere = "-1";
if (isset($_GET['idUE'])) {
    $param=json_decode(base64_decode($_GET['idUE']));
    $colname_rq_ue_matiere=$param->id;

}

$query_rq_ue_matiere = $dbh->query("SELECT MATIERE_UE.*, MATIERE.LIBELLE AS LIBMATIERE FROM MATIERE_UE, MATIERE WHERE IDUE = ".$colname_rq_ue_matiere." AND MATIERE.IDMATIERE = MATIERE_UE.IDMATIERE");

$row_rq_ue_matiere = $query_rq_ue_matiere->fetchAll();


$colname_rq_nbr_tot_credit = "-1";
if (isset($_GET['idUE'])) {
    $param=json_decode(base64_decode($_GET['idUE']));
    $colname_rq_nbr_tot_credit=$param->id;

}

$query_rq_nbr_tot_credit = $dbh->query("SELECT SUM(MATIERE_UE.nbcredit) as tot_credit FROM MATIERE_UE WHERE MATIERE_UE.IDUE= ".$colname_rq_nbr_tot_credit);

$row_rq_nbr_tot_credit = $query_rq_nbr_tot_credit->fetchObject();


$colname_rq_semestre =$row_rq_ue_etab->SEMESTRES;

//var_dump($query_rq_ue_etab); die;

$query_rq_semestre = $dbh->query("SELECT NOM_PERIODE FROM PERIODE WHERE IDPERIODE = $colname_rq_semestre");

$row_rq_semestre = $query_rq_semestre->fetchObject();




?>


<?php include('header.php'); ?> 
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Unit&eacute; d'enseignement</li>
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
                    
                    <?php if(isset($_GET['msg']) && $lib->securite_xss($_GET['msg'])!= ''){
				 
				  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])==1)
						  {?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $_GET['msg']; ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])!=1)
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $_GET['msg']; ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                    
            <fieldset class="cadre"><legend >DETAILS D'UNE UNIT&Eacute; D'ENSEIGNEMENT</legend>
  <table class="table table-striped table-responsive table-bordered" width="100%">
      <tr >
        <td >LIBELLE:</td>
        <td ><?php echo $row_rq_ue_etab->LIBELLE; ?></td>
</tr>
      <tr >
        <td >Semestre:</td>
        <td ><?php echo $row_rq_semestre->NOM_PERIODE; ?></td>
      </tr>
      <tr >
        <td >NIVEAU:</td>
        <td ><?php echo $row_rq_ue_etab->LIBNIVEAU; ?></td>
      </tr>
      <tr >
        <td >FILI&Egrave;RE/S&Eacute;RIE:</td>
        <td ><?php echo $row_rq_ue_etab->LIBSERIE; ?></td>
      </tr>
      <tr >
        <td >Nombre total de credit:</td>
        <td ><?php echo $row_rq_nbr_tot_credit->tot_credit; ?></td>
      </tr>
    </table>   </fieldset>  
                    
                    
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
       <?php include('footer.php');?>



