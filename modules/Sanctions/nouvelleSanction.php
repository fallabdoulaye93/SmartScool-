
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
$lib->Restreindre($lib->Est_autoriser(45,$_SESSION['profil']));


$colname_matricule="";
if(isset($_POST['MATRICULE'])&& $_POST['MATRICULE']!="")
{
    $colname_matricule=" AND INDIVIDU.MATRICULE='".$lib->securite_xss($_POST['MATRICULE'])."'";
}
$colname_prenom="";
if(isset($_POST['PRENOMS'])&& $_POST['PRENOMS']!="")
{
    $colname_prenom=" AND INDIVIDU.PRENOMS='".$lib->securite_xss($_POST['PRENOMS'])."'";
}
$colname_nom="";
if(isset($_POST['NOM'])&& $_POST['NOM']!="")
{
    $colname_nom=" AND INDIVIDU.NOM='".$lib->securite_xss($_POST['NOM'])."'";
}
$colname_tel="";
if(isset($_POST['TELMOBILE'])&& $_POST['TELMOBILE']!="")
{
$colname_tel=" AND INDIVIDU.TELMOBILE='".$lib->securite_xss($_POST['TELMOBILE'])."'";
}


$colname_rq_etudiant = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etudiant = intval($_SESSION['etab']);
}
$colname2_rq_etudiant = "-1";
if (isset( $_SESSION['ANNEESSCOLAIRE']))
{
  $colname2_rq_etudiant =  intval($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.*, INDIVIDU.MATRICULE, INDIVIDU.PRENOMS, INDIVIDU.NOM, INDIVIDU.TELMOBILE, INDIVIDU.COURRIEL, INSCRIPTION.DATEINSCRIPT, INSCRIPTION.MONTANT 
                                            FROM INDIVIDU, INSCRIPTION 
                                            WHERE INDIVIDU.IDETABLISSEMENT = ".$colname_rq_etudiant." 
                                            AND INDIVIDU.IDTYPEINDIVIDU=8 
                                            AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                            AND INSCRIPTION.IDANNEESSCOLAIRE= ".$colname2_rq_etudiant.$colname_matricule.$colname_prenom.$colname_nom.$colname_tel);
    $rs_etudiant = $query_rq_etudiant->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}
?>

<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Sanction</a></li>                    
                    <li>Nouvelle sanction</li>
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

						 <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

						  <?php echo $lib->securite_xss($_GET['msg']); ?> </div>

						  <?php } ?>
                 
			     <?php } ?>
                 
                  <form id="form1" name="form1" method="post" action="" >
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
                                  <th>TEL MOBILE</th>
                                  <th>COURRIEL</th>
                                  <th>SANCTIONNER</th>
                                    
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php foreach ($rs_etudiant as $row_rq_etudiant){ ?>
                            <tr>
        
                                <td ><?php echo $row_rq_etudiant['MATRICULE']; ?></td>
                                <td ><?php echo $row_rq_etudiant['PRENOMS']; ?></td>
                                <td ><?php echo $row_rq_etudiant['NOM']; ?></td>
                                <td ><?php echo $row_rq_etudiant['TELMOBILE']; ?></td>
                                 <td ><?php echo $row_rq_etudiant['COURRIEL']; ?></td>
                                <td ><a href="newSanction.php?IDINDIVIDU=<?php echo $row_rq_etudiant['IDINDIVIDU']; ?>"<i class="glyphicon glyphicon-plus"></i></a></td>
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