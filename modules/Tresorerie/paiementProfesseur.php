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
$lib->Restreindre($lib->Est_autoriser(29,$lib->securite_xss($_SESSION['profil'])));


$condi_matricule =" ";
if (isset($_POST['MATRICULE']) && $_POST['MATRICULE']!=NULL) {
  $condi_matricule = " AND INDIVIDU.MATRICULE = '". $lib->securite_xss($_POST['MATRICULE']) ."'";
}
else
{
	$condi_matricule =" ";
}
$condi_nom =" ";
if (isset($_POST['NOM']) && $_POST['NOM']!=NULL) {
  $condi_nom = " AND INDIVIDU.NOM = '".$lib->securite_xss($_POST['NOM'])."'";
}
else
{
	$condi_nom =" ";
}
$condi_prenom=" ";
if (isset($_POST['PRENOMS']) && $_POST['PRENOMS']!=NULL)
{
  $condi_prenom = " AND INDIVIDU.PRENOMS = '".$lib->securite_xss($_POST['PRENOMS'])."'";
}
else
{
	$condi_prenom=" ";

}
$condi_telmob=" ";
if(isset($_POST['TELMOBILE']) && $_POST['TELMOBILE']!=NULL)
{
  $condi_telmob = " AND INDIVIDU.TELMOBILE = '".$lib->securite_xss($_POST['TELMOBILE'])."'";
}
else
{
	$condi_telmob=" ";
}

$colname_Etab_rq_individu = "-1";
if (isset($_SESSION['etab']))
{
  $colname_Etab_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne_rq_individu = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
  $colname_anne_rq_individu = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $query_rq_individu = $dbh->query("SELECT RECRUTE_PROF.IDRECRUTE_PROF, RECRUTE_PROF.TARIF_HORAIRE, RECRUTE_PROF.VOLUME_HORAIRE, INDIVIDU.MATRICULE, 
                                            INDIVIDU.NOM, INDIVIDU.PRENOMS, MATIERE.LIBELLE, CLASSROOM.LIBELLE, INDIVIDU.PHOTO_FACE, INDIVIDU.IDINDIVIDU, INDIVIDU.TELMOBILE 
                                            FROM RECRUTE_PROF, CLASSE_ENSEIGNE, INDIVIDU, MATIERE_ENSEIGNE, MATIERE, CLASSROOM 
                                            WHERE RECRUTE_PROF.IDETABLISSEMENT = ".$colname_Etab_rq_individu." 
                                            AND RECRUTE_PROF.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                            AND RECRUTE_PROF.IDINDIVIDU = MATIERE_ENSEIGNE.ID_INDIVIDU
                                            AND MATIERE_ENSEIGNE.ID_MATIERE = MATIERE.IDMATIERE 
                                            AND RECRUTE_PROF.IDRECRUTE_PROF = CLASSE_ENSEIGNE.IDRECRUTE_PROF
                                            AND CLASSE_ENSEIGNE.IDCLASSROM = CLASSROOM.IDCLASSROOM
                                            AND RECRUTE_PROF.IDANNEESSCOLAIRE = ".$colname_anne_rq_individu.$condi_matricule.$condi_nom.$condi_prenom.$condi_telmob." 
                                            GROUP BY INDIVIDU.IDINDIVIDU");

    $rs_individu = $query_rq_individu->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li>Paiement Professeur</li>
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
				 
				  if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

						    <?php echo $lib->securite_xss($_GET['msg']); ?>

                          </div>

						 <?php } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 

                              <?php echo $lib->securite_xss($_GET['msg']); ?>

                          </div>

						  <?php } ?>
                 
			     <?php } ?>
                    
                    <form id="form1" name="form1" method="post" action="" >
                        <fieldset class="cadre"><legend> Filtre</legend>
     
                            <div class="row">
                                <div class="col-xs-6">
                                <div class="form-group">
                                     <div class="col-xs-3"><label >MATRICULE</label></div>
                                    <div class="col-xs-9">
                                        <input type="text" name="MATRICULE" id="MATRICULE"  class="form-control"/>
                                    </div>
                                </div>
                                  </div>

                                 <div class="col-xs-6">
                                <div class="form-group">
                                    <div class="col-xs-3"> <label >PRENOMS</label></div>
                                    <div class="col-xs-9">
                                        <input type="text" name="PRENOMS" id="PRENOMS"  class="form-control"/>
                                    </div>
                                </div>
                                    </div>
                                </div><br>
        
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                             <div class="col-xs-3"><label >NOM</label></div>
                                            <div class="col-xs-9">
                                                <input type="text" name="NOM" id="NOM"  class="form-control"/>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-xs-6">
                                        <div class="form-group">
                                             <div class="col-xs-3"><label >TEL MOBILE</label></div>
                                            <div class="col-xs-9">
                                                <input type="text" name="TELMOBILE" id="TELMOBILE"  class="form-control"/>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-offset-6 col-xs-1">
                                        <div class="form-group">
                                            <div>
                                                <input type="submit" class="btn btn-success"  value="Rechercher"  />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                          </fieldset>
                    </form>


                     <table id="customers2" class="table datatable">
                         <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>MATRICULE</th>
                                <th>PRENOMS</th>
                                 <th>NOM</th>
                                 <th>TEL</th>
                                 <th>Details</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php foreach($rs_individu as  $row_rq_individu){
                               $array = array(
                                   "id" => $row_rq_individu['IDINDIVIDU']
                               );
                               $param=base64_encode(json_encode($array));
                            
                                ?>
                            <tr>

                                <td ><img name="" src="../../imgtiers/<?php echo $row_rq_individu['PHOTO_FACE']; ?>" width="40" height="20" alt="" /></td>
                                <td ><?php echo $row_rq_individu['MATRICULE']; ?></td>
                                <td ><?php echo $row_rq_individu['PRENOMS']; ?></td>
                                <td ><?php echo $row_rq_individu['NOM']; ?></td>
                                <td ><?php echo $row_rq_individu['TELMOBILE']; ?></td>
                                <td ><a href="fichePaiementProf.php?IDINDIVIDU=<?php echo $param ; ?>" class="textBrute"><i class="glyphicon glyphicon-list"></i></a></td>
                                

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