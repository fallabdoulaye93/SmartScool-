
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

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(42,$lib->securite_xss($_SESSION['profil'])));

$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname_matricule="";
if(isset($_POST['MATRICULE'])&& $lib->securite_xss($_POST['MATRICULE'])!="")
{
    $colname_matricule=" AND UTILISATEURS.matriculeUtilisateur='".$lib->securite_xss($_POST['MATRICULE'])."'";
}

$colname_prenom="";
if(isset($_POST['PRENOMS'])&& $lib->securite_xss($_POST['PRENOMS'])!="")
{
    $colname_prenom=" AND UTILISATEURS.prenomUtilisateur='".$lib->securite_xss($_POST['PRENOMS'])."'";
}
$colname_nom="";
if(isset($_POST['NOM'])&& $lib->securite_xss($_POST['NOM'])!="")
{
    $colname_nom=" AND UTILISATEURS.nomUtilisateur='".$lib->securite_xss($_POST['NOM'])."'";
}
$colname_tel="";
if(isset($_POST['TELMOBILE'])&& $lib->securite_xss($_POST['TELMOBILE'])!="")
{
    $colname_tel=" AND UTILISATEURS.telephone='".$lib->securite_xss($_POST['TELMOBILE'])."'";
}

try
{
    $query_rq_individu = $dbh->query("SELECT idUtilisateur, matriculeUtilisateur, codeUtilisateur, prenomUtilisateur, nomUtilisateur, telephone, adresse, email
                                                FROM UTILISATEURS 
                                                WHERE idEtablissement = ".$colname_rq_individu." 
                                                AND idProfil IN (1,2,3,4,5,6)".$colname_matricule.$colname_prenom.$colname_nom.$colname_tel);

    $rs_administratif = $query_rq_individu->fetchAll();
}
catch (PDOException $e){
    echo -2;
}



?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Liste du personnel administratifs</li>
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
				 
				        if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						    <?php echo $lib->securite_xss($_GET['msg']); ?>
                          </div>

						 <?php  } if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						    <?php echo $lib->securite_xss($_GET['msg']); ?>
                          </div>

						  <?php } ?>
                 
			     <?php } ?>
                 
                 <form id="form" name="form1" method="post" action="" >
                   <fieldset class="cadre"><legend> Filtre</legend>

                        <div class="row">
                            <div class="col-xs-6">
                                                <div class="form-group">
                                                   <div class="col-xs-3"> <label >MATRICULE</label></div>
                                                    <div class="col-xs-9">
                                                        <input type="text" name="MATRICULE" id="MATRICULE"  class="form-control"/>
                                                    </div>
                                                </div>
                            </div>

                             <div class="col-xs-6">
                                                <div class="form-group">
                                                    <div class="col-xs-3"><label >PRENOMS</label></div>
                                                    <div class="col-xs-9">
                                                        <input type="text" name="PRENOMS" id="PRENOMS"  class="form-control"/>
                                                    </div>
                                                </div>
                            </div>
                         </div><br>

                         <div class="row">

                         <div class="col-xs-6">
                                            <div class="form-group">
                                               <div class="col-xs-3"> <label >NOM</label></div>
                                                <div class="col-xs-9">
                                                    <input type="text" name="NOM" id="NOM"  class="form-control"/>
                                                </div>
                                            </div>
                        </div>

                         <div class="col-xs-6">
                                            <div class="form-group">
                                                <div class="col-xs-3"><label >TELMOBILE</label></div>
                                                <div class="col-xs-9">
                                                    <input type="text" name="TELMOBILE" id="TELMOBILE"  class="form-control"/>
                                                </div>
                                            </div>
                        </div>

                        </div> <br>

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

                                <th>MATRICULE</th>
                                <th>PRENOMS</th>
                                 <th>NOM</th>
                                 <th>TELMOBILE</th>
                                 <th>DETAILS</th>
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($rs_administratif as $individu){
                                /*$even=new Evenement();*/
                                ?>
                            <tr>
        
                                <td ><?php echo $individu['matriculeUtilisateur']; ?></td>
                                <td ><?php echo $individu['prenomUtilisateur']; ?></td>
                                <td ><?php echo $individu['nomUtilisateur']; ?></td>
                                <td ><?php echo $individu['telephone']; ?></td>
                                <td ><a href="detailPersonnel.php?idIndividu=<?php echo base64_encode($individu['idUtilisateur']); ?>"><i class="glyphicon glyphicon-search"></i></a></td>



                                <!--<td ><a href="modifIndividu.php?idIndividu=<?php /*echo $individu['IDINDIVIDU']; */?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                                
                                <td ><a href="suppIndividu.php?idIndividu=<?php /*echo $individu['IDINDIVIDU']; */?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>-->
                                    
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