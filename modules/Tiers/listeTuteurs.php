
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
$lib->Restreindre($lib->Est_autoriser(43, $lib->securite_xss($_SESSION['profil'])));


$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname1_rq_detail_eleve = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE']))
{
    $colname1_rq_detail_eleve = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

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

try
{
    $query_rq_individu = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.ADRES, 
                                                INDIVIDU.TELMOBILE, INDIVIDU.COURRIEL, TYPEINDIVIDU.IDTYPEINDIVIDU, TYPEINDIVIDU.LIBELLE, 
                                                INDIVIDU.IDINDIVIDU, INDIVIDU.PHOTO_FACE 
                                                FROM INDIVIDU, TYPEINDIVIDU 
                                                WHERE INDIVIDU.IDTYPEINDIVIDU=TYPEINDIVIDU.IDTYPEINDIVIDU 
                                                AND INDIVIDU.IDTYPEINDIVIDU = 9 
                                                AND INDIVIDU.IDETABLISSEMENT = $colname_rq_individu".$colname_matricule.$colname_prenom.$colname_nom.$colname_tel);
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
				        if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						 <?php } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

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
                                    </div>

                                    <br><div class="row">
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
                                     <th>NOMBRE D'ENFANT</th>
                                     <th>MODIFIER</th>
                                     <th>SUPPRIMER</th>
                                     <th>DETAILS</th>

                                </tr>
                                </thead>


                                <tbody>
                               <?php foreach ($rs_individu as $individu){ ?>
                                <tr>

                                    <td><?php echo $lib->securite_xss($individu['MATRICULE']); ?></td>
                                    <td><?php echo $lib->securite_xss($individu['PRENOMS']); ?></td>
                                    <td><?php echo $lib->securite_xss($individu['NOM']); ?></td>
                                    <td><?php echo $lib->securite_xss($individu['TELMOBILE']); ?></td>

                                    <?php
                                    try
                                    {
                                          $query_rq_nbre = "SELECT COUNT(p.ideleve) as nombre FROM INDIVIDU i
                                          INNER JOIN PARENT p ON i.IDINDIVIDU = p.ideleve 
                                          INNER JOIN INSCRIPTION ins ON ins.IDINDIVIDU = i.IDINDIVIDU 
                                          WHERE p.idParent = ".$lib->securite_xss($individu['IDINDIVIDU'])." 
                                          AND ins.ETAT = 1 
                                          AND ins.IDANNEESSCOLAIRE = " .$colname1_rq_detail_eleve;
                                        $rq_nbre = $dbh->query($query_rq_nbre);
                                        $row_rq_nbre = $rq_nbre->fetchObject();
                                    }
                                    catch (PDOException $e){
                                        echo -2;
                                    }


                                        if($row_rq_nbre) { ?>

                                        <td style="text-align: center"><?php echo $lib->securite_xss($row_rq_nbre->nombre); ?></td>

                                        <?php } ?>

                                       <td><a href="modifTuteur.php?idIndividu=<?php echo base64_encode($lib->securite_xss($individu['IDINDIVIDU'])); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>

                                        <td><a href="suppIndividu.php?idIndividu=<?php echo base64_encode($lib->securite_xss($individu['IDINDIVIDU'])); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cet enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>

                                        <td><a href="detailTuteur.php?IDTUTEUR=<?php echo base64_encode($lib->securite_xss($individu['IDINDIVIDU'])); ?>" ><i class=" glyphicon glyphicon-list"></i></a></td>

                                      </tr>

                                <?php }  ?>

                                </tbody>
                            </table>
    
              
                        </div>
                     </div>
                    </div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

 
        <?php include('footer.php'); ?>