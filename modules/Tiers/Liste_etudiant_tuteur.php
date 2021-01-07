
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
$lib->Restreindre($lib->Est_autoriser(43,$_SESSION['profil']));




$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $_SESSION['etab'];
}

$IDTUTEUR=-1;
if(isset($_POST['IDTUTEUR'])&& $_POST['IDTUTEUR']!="")
{
    $IDTUTEUR = $lib->securite_xss($_POST['IDTUTEUR']);
}
if(isset($_GET['IDTUTEUR'])&& $_GET['IDTUTEUR']!="")
{
$IDTUTEUR = $lib->securite_xss($_GET['IDTUTEUR']);
}
$colname_matricule="";
if(isset($_POST['MATRICULE'])&& $_POST['MATRICULE']!="")
{
$colname_matricule=" AND INDIVIDU.MATRICULE LIKE '%".$lib->securite_xss($_POST['MATRICULE'])."%'";
}
$colname_prenom="";
if(isset($_POST['PRENOMS'])&& $_POST['PRENOMS']!="")
{
$colname_prenom=" AND INDIVIDU.PRENOMS LIKE '%".$lib->securite_xss($_POST['PRENOMS'])."%'";
}
$colname_nom="";
if(isset($_POST['NOM'])&& $_POST['NOM']!="")
{
$colname_nom=" AND INDIVIDU.NOM LIKE '%".$lib->securite_xss($_POST['NOM'])."%'";
}
$colname_tel="";
if(isset($_POST['TELMOBILE'])&& $_POST['TELMOBILE']!="")
{
$colname_tel=" AND INDIVIDU.TELMOBILE LIKE '%".$lib->securite_xss($_POST['TELMOBILE'])."%'";
}



$colname_rq_etudiant = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'] )) {
  $colname_rq_etudiant = intval($_SESSION['ANNEESSCOLAIRE']) ;
}
$colname1_rq_etudiant = "-1";
if (isset($_SESSION['etab'] )) {
  $colname1_rq_etudiant = intval($_SESSION['etab']) ;
}

$query_rq_etudiant = sprintf("SELECT INDIVIDU.IDINDIVIDU,INDIVIDU.PRENOMS, INSCRIPTION.IDINDIVIDU AS ETUDIANT, INDIVIDU.NOM, INDIVIDU.DATNAISSANCE, INDIVIDU.MATRICULE, INDIVIDU.ADRES, INDIVIDU.TELMOBILE, INDIVIDU.PHOTO_FACE FROM INDIVIDU, INSCRIPTION WHERE INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU  AND INSCRIPTION.IDANNEESSCOLAIRE=%s AND INSCRIPTION.IDETABLISSEMENT=%s ".$colname_matricule.$colname_prenom.$colname_nom.$colname_tel,$lib->GetSQLValueString($colname_rq_etudiant, "int"),$lib->GetSQLValueString($colname1_rq_etudiant, "int"));
$rq_etudiant = $dbh->query($query_rq_etudiant);




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
                 
                 <form id="form1" name="form1" method="post" action="Liste_etudiant_tuteur.php" >
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
                                     <input name="IDTUTEUR" type="hidden" id="IDTUTEUR" value="<?php echo $IDTUTEUR; ?>" /> 
                                        <input type="submit" class="btn btn-success"  value="Envoyer"  />
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
                                 <th>DATE NAISSANCE</th>
                                 <th>ADRESSE</th>
                                 <th>AFFECTER</th>
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($rq_etudiant->fetchAll() as $individu){
                                /*$even=new Evenement();*/
                                ?>
                            <tr>
        
                                <td ><?php echo $individu['MATRICULE']; ?></td>
                                <td ><?php echo $individu['PRENOMS']; ?></td>
                                <td ><?php echo $individu['NOM']; ?></td>
                                <td ><?php echo $individu['TELMOBILE']; ?></td>
                                 <td ><?php echo $individu['DATNAISSANCE']; ?></td>
                                <td ><?php echo $individu['ADRES']; ?></td>
                              
                               
                                
                                    
                                    <td><a href="affectation_tuteur.php?TUTEUR=<?php echo base64_encode($IDTUTEUR); ?>&amp;ETUDIANT=<?php echo base64_encode($individu['IDINDIVIDU']); ?>" ><i class=" glyphicon glyphicon-list"></i></a></td>
                                    
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