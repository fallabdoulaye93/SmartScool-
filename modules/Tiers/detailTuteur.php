
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

$colname_rq_detail_tuteur = "-1";
if (isset($_GET['IDTUTEUR']))
{
   $colname_rq_detail_tuteur = base64_decode($lib->securite_xss($_GET['IDTUTEUR']));
}

$colname1_rq_detail_eleve = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $colname1_rq_detail_eleve = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}


try
{
    $query_rq_detail_tuteur = sprintf("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = %s", $lib->GetSQLValueString($colname_rq_detail_tuteur, "int"));
    $rq_detail_tuteur = $dbh->query($query_rq_detail_tuteur);
    $row_rq_detail_tuteur = $rq_detail_tuteur->fetchObject();


    $query_rq_detail_eleve = sprintf("SELECT i.NOM, i.PRENOMS, i.DATNAISSANCE, i.ADRES, i.TELMOBILE, c.LIBELLE, p.idParent, p.ideleve, i.PHOTO_FACE 
                                         FROM INDIVIDU i 
                                         INNER JOIN AFFECTATION_ELEVE_CLASSE af ON af.IDINDIVIDU = i.IDINDIVIDU
                                         INNER JOIN CLASSROOM c ON af.IDCLASSROOM = c.IDCLASSROOM
                                         INNER JOIN PARENT p ON i.IDINDIVIDU = p.ideleve
                                         INNER JOIN INSCRIPTION ins ON i.IDINDIVIDU = ins.IDINDIVIDU
                                         WHERE ins.ETAT = 1
                                         AND p.idParent = ".$colname_rq_detail_tuteur."
                                         AND af.IDANNEESSCOLAIRE = ".$colname1_rq_detail_eleve);
    $rq_detail_eleve = $dbh->query($query_rq_detail_eleve);


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
                    <li>Liste des tuteurs</li>
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
				 
                          if(isset($_GET['res']) && $_GET['res']==1)
						  {?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->affichage_xss($_GET['msg']) ; ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $_GET['res']!=1) 
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->affichage_xss($_GET['msg']) ; ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
               <div class="row">
                   <div class="btn-group pull-right">
                       <!--<a href="Liste_etudiant_tuteur.php?IDTUTEUR=<?php /*echo $colname_rq_detail_tuteur; */?>"><button
                                   style="background-color:#DD682B" class='btn dropdown-toggle', aria-hidden='true' >
                               <i class="fa fa-plus"></i> Nouvelle affectation</button>
                       </a>-->
                   </div>
               </div>

                 <div class="row">
                     <div class="col-lg-12">

                         <fieldset class="cadre"><legend>DETAILS SUR LE TUTEUR</legend>
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
                                        <td><b>COURRIEL : </b></td>
                                        <td><?php echo $row_rq_detail_tuteur->COURRIEL; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b> TEL : </b></td>
                                        <td><?php echo $row_rq_detail_tuteur->TELMOBILE; ?></td>
                                      </tr>
                                      <tr>
                                        <td><b>ADRESSE : </b></td>
                                        <td><?php echo $row_rq_detail_tuteur->ADRES; ?></td>
                                      </tr>
                                 </table>
                         </fieldset>

                     </div>
                 </div>
                        <div>
                             <div class="col-lg-12">

                                        <fieldset class="cadre"><legend>LES ENFANTS DU TUTEUR</legend>

                                        <table class="table table-striped">
                                              <tr>
                                                    <th>&nbsp;</th>
                                                    <th>NOM</th>
                                                    <th>PRENOM</th>
                                                    <th>DATE DE NAISSANCE</th>
                                                    <th>ADRESSE</th>
                                                    <th>TEL MOBILE</th>
                                                    <th>CLASSE</th>
                                                    <th>SUPPRIMER AFFECTATION</th>
                                                </tr>

                                              <?php foreach( $rq_detail_eleve->fetchAll() as $row_rq_detail_eleve ) { ?>
                                              <tr>
                                                    <td><img name="" src="../../imgtiers/<?php echo $row_rq_detail_eleve['PHOTO_FACE']; ?>" width="31" alt="" /></td>
                                                    <td><?php echo $row_rq_detail_eleve['NOM']; ?></td>
                                                    <td><?php echo $row_rq_detail_eleve['PRENOMS']; ?></td>
                                                    <td><?php echo $lib->date_fr($row_rq_detail_eleve['DATNAISSANCE']); ?></td>
                                                    <td><?php echo $row_rq_detail_eleve['ADRES']; ?></td>
                                                    <td><?php echo $row_rq_detail_eleve['TELMOBILE']; ?></td>
                                                    <td><?php echo $row_rq_detail_eleve['LIBELLE']; ?></td>
                                                    <td><a href="suppAffectation.php?ideleve=<?php echo base64_encode($row_rq_detail_eleve['ideleve']) ;?>&amp;idparent=<?php echo base64_encode($row_rq_detail_eleve['idParent']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
                                                </tr>
                                              <?php }  ?>
                                            </table>
                                        </fieldset>
                             </div>
                        </div>
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    

                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

 
        <?php include('footer.php'); ?>