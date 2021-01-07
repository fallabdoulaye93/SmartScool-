
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
$lib->Restreindre($lib->Est_autoriser(37,$lib->securite_xss($_SESSION['profil'])));

require_once('../Parametrage/classe/ProfileManager.php');
$profiles=new ProfileManager($dbh,'profil');
$profil = $profiles->getProfiles();


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}
$colanne_rq_annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
$query_rq_individu = $dbh->query("SELECT COUNT(i.IDINSCRIPTION) as nbre, n.LIBELLE, s.LIBSERIE, i.IDSERIE, i.IDNIVEAU 
                                            FROM INSCRIPTION i
                                            INNER JOIN NIVEAU n ON i.IDNIVEAU = n.IDNIVEAU
                                            INNER JOIN SERIE s ON s.IDSERIE = i.IDSERIE 
                                            INNER JOIN INDIVIDU id ON  id.IDINDIVIDU = i.IDINDIVIDU 
                                            INNER JOIN ANNEESSCOLAIRE a ON a.IDANNEESSCOLAIRE = i.IDANNEESSCOLAIRE
                                            WHERE i.IDETABLISSEMENT= ".$colname_rq_individu."
                                            AND i.IDANNEESSCOLAIRE=".$colanne_rq_annee." 
                                            AND a.ETAT = 0
                                            GROUP BY i.IDSERIE, i.IDNIVEAU");
?>


<?php require_once('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Historique inscription</li>
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
						  { ?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->affichage_xss($_GET['msg']); ?></div>

                          <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->affichage_xss($_GET['msg']); ?></div>

                        <?php } ?>
                 
			     <?php } ?>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                <th>Cycle</th>
                                <th>Fili&egrave;re / Série </th>
                                 <th>&Eacute;ffectif</th>
                                 <th>D&eacute;tails</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php foreach ($query_rq_individu->fetchAll() as $individu){ ?>
                            <tr>
                                <td ><?php echo $individu['LIBELLE']; ?></td>
                                <td ><?php echo $individu['LIBSERIE']; ?></td>
                                <td ><?php echo $individu['nbre']; ?></td>
                                <td ><a href="detailHistoInscription.php?IDSERIE=<?php echo base64_encode($individu['IDSERIE']); ?>&amp;IDNIVEAU=<?php echo base64_encode($individu['IDNIVEAU']) ; ?>&amp;LIBSERIE=<?php echo base64_encode($individu['LIBSERIE']) ; ?>&amp;NIVEAU=<?php echo base64_encode($individu['LIBELLE']) ; ?>"><i class=" glyphicon glyphicon-list"></i></a></td>
                            </tr>

                            <?php }  ?>
           
                            </tbody>
                     </table>
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>