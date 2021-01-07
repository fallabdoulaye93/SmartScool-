
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

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(43,$lib->securite_xss($_SESSION['profil'])));


$colname_rq_individu = "-1";
if (isset($_SESSION['etab']))
{
    $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_detail_recrutPrrof = "-1";
if (isset($_GET['IDRECRUTE_PROF']))
{
  $colname_rq_detail_recrutPrrof = $lib->securite_xss(base64_decode($_GET['IDRECRUTE_PROF']));
}


try
{
    $query_rq_detail_prof = "SELECT RECRUTE_PROF.IDRECRUTE_PROF, RECRUTE_PROF.TARIF_HORAIRE, RECRUTE_PROF.TYPES, RECRUTE_PROF.VOLUME_HORAIRE, INDIVIDU.MATRICULE, 
                            INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.PHOTO_FACE, FORFAIT_PROFESSEUR.LIBELLE  as forfait
                            FROM RECRUTE_PROF INNER JOIN INDIVIDU ON RECRUTE_PROF.IDINDIVIDU=INDIVIDU.IDINDIVIDU
                            LEFT JOIN FORFAIT_PROFESSEUR ON RECRUTE_PROF.FK_FORFAIT=FORFAIT_PROFESSEUR.ROWID
                            WHERE RECRUTE_PROF.IDRECRUTE_PROF = " . $colname_rq_detail_recrutPrrof ;

    $rq_detail_tuteur = $dbh->query($query_rq_detail_prof);
    $row_rq_detail_tuteur = $rq_detail_tuteur->fetchObject();

    $query_rq_classroom = $dbh->query("SELECT CLASSROOM.LIBELLE as classe FROM CLASSROOM, CLASSE_ENSEIGNE 
                                                 WHERE CLASSE_ENSEIGNE.IDRECRUTE_PROF = " . $colname_rq_detail_recrutPrrof . " 
                                                 AND CLASSE_ENSEIGNE.IDCLASSROM=CLASSROOM.IDCLASSROOM
                                                 AND CLASSE_ENSEIGNE.IDANNESCOLAIRE=".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
    $r_classe = $query_rq_classroom->fetchAll();


    $query_rq_matiere = $dbh->query("SELECT MATIERE.LIBELLE as matiere FROM MATIERE
                                     INNER JOIN MATIERE_ENSEIGNE ON MATIERE.IDMATIERE=MATIERE_ENSEIGNE.ID_MATIERE
                                     INNER JOIN RECRUTE_PROF ON RECRUTE_PROF.IDINDIVIDU=MATIERE_ENSEIGNE.ID_INDIVIDU
                                     WHERE RECRUTE_PROF.IDRECRUTE_PROF = " . $colname_rq_detail_recrutPrrof. " AND MATIERE_ENSEIGNE.IDANNESCOLAIRE=".$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']));
    $r_matiere = $query_rq_matiere->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}

?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Détail professeurs recrutés</li>
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

                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) { ?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->affichage_xss($_GET['msg']); ?></div>
                  <?php  }
                  if(isset($_GET['res']) && $_GET['res']!=1) { ?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->affichage_xss($_GET['msg']); ?></div>
                  <?php } ?>
                 
			     <?php } ?>

                 <div class="row">
                 <div class="col-lg-12">

                     <fieldset class="cadre"><legend>DETAILS SUR LE PROFESSEUR</legend>
                        <table class="table table-responsive table-striped">
  
  
                            <tr>
                                <td><b>MATRICULE : </b></td>
                                <td><?php echo $row_rq_detail_tuteur->MATRICULE; ?></td>
                            </tr>

                            <tr>
                                <td><b>NOM : </b></td>
                                <td><?php echo $row_rq_detail_tuteur->NOM; ?></td>
                            </tr>

                            <tr>
                                <td><b>PRENOM : </b></td>
                                <td><?php echo $row_rq_detail_tuteur->PRENOMS; ?></td>
                            </tr>

                            <tr>
                                <td><b>MATIERE(S) ENSEIGNE (S) : </b></td>
                                <td>
                                <?php foreach ($r_matiere as $matiere) { ?>

                                    <?php echo $matiere['matiere']." - "; ?>

                                <?php } ?>
                                </td>
                            </tr>

                             <tr>
                                 <td><b>CLASSE(S) ENSEIGNE(S) : </b></td>
                                 <td>
                                 <?php foreach ($r_classe as $classroom) {?>

                                        <?php echo $classroom['classe']." - "; ?>

                                 <?php } ?>
                                 </td>
                             </tr>

                             <?php if($row_rq_detail_tuteur->TYPES==1){ ?>
                                 <tr>
                                     <td><b>FORFAIT : </b></td>
                                     <td><?php echo $row_rq_detail_tuteur->forfait; ?></td>
                                 </tr>
                             <?php } else {?>
                             <tr>
                                 <td><b>TARIF HORAIRE : </b></td>
                                 <td><?php echo $lib->nombre_form($row_rq_detail_tuteur->TARIF_HORAIRE) ; ?></td>
                             </tr>
                             <tr>
                                 <td><b>VOLUME HORAIRE : </b></td>
                                 <td><?php echo $row_rq_detail_tuteur->VOLUME_HORAIRE; ?></td>
                             </tr>
      <?php }?>
                 </table>
                         <div class="form-group">
                             <div class="pull-right">
                                 <a href="listeProfesseurRecrutes.php">
                                     <button type="button" class="btn btn-success">RETOUR</button>
                                 </a>
                             </div>

                         </div>
                     </fieldset>

                 </div>

</div>

                 
                 
    

                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

 
<?php include('footer.php'); ?>