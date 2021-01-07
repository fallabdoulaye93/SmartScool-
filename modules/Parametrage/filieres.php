<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(4, $lib->securite_xss($_SESSION['profil'])));

$colname_REQ_filiere = "-1";
if (isset($_SESSION['etab'])) {
  $colname_REQ_filiere = $lib->securite_xss($_SESSION['etab']);
}

try
{
    $query_REQ_filiere = $dbh->query("SELECT s.LIBSERIE, s.IDSERIE, n.IDNIVEAU, n.LIBELLE FROM SERIE s 
                                                INNER JOIN NIVEAU n ON s.IDNIVEAU = n.IDNIVEAU
                                                WHERE s.IDETABLISSEMENT = ".$colname_REQ_filiere." ORDER BY s.IDNIVEAU ASC");

    $rs_filiere = $query_REQ_filiere->fetchAll();


    $query_rq_cycle = $dbh->query("SELECT IDNIVEAU, LIBELLE FROM NIVEAU");
    $rs_cycle = $query_rq_cycle->fetchAll();
}
catch (PDOException $e)
{
    echo -2;
}


?>


<?php include('../header.php'); ?>
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>S&eacute;rie</li>
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
							<button data-toggle="modal" data-target="#ajouter"  
                            style="background-color:#DD682B" class='btn dropdown-toggle', aria-hidden='true' >
                            <i class="fa fa-plus"></i> Nouvelle S&eacute;rie</button>
                            
                        </div>

                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $_GET['res']!=1) 
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                <th>S&eacute;rie</th>
                                <th>Cycle</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                            <?php foreach ($rs_filiere as $filiere){ ?>
                            <tr>

                                    <td><?php echo $filiere['LIBSERIE']; ?></td>
                                    <td>
                                        <?php echo $filiere['LIBELLE']; ?>
                                    </td>
                                    <td><a href="modifFiliere.php?idSerie=<?php echo base64_encode($filiere['IDSERIE']); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                               
                                    <td><a href="suppFiliere.php?idSerie=<?php echo base64_encode($filiere['IDSERIE']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
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
        
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog" style="width: 50%">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="panel-title text-center"> Nouvelle S&eacute;rie </h3>
                        </div>
                        <form action="ajouterFiliere.php" method="POST">

                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label>CYCLE</label>
                                            <select class="form-control" id="selectCycle" name="IDNIVEAU" required>
                                                <option value="">Selectionner un cycle</option>

                                                <?php foreach ($rs_cycle as $rq_cycle) {?>

                                                    <option value="<?php echo base64_encode($rq_cycle['IDNIVEAU']) ?>"><?php echo $rq_cycle['LIBELLE'] ?></option>

                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                        <label >S&eacute;rie</label>
                                        <div>
                                            <input type="text" name="LIBSERIE" id="LIBSERIE" required class="form-control"/>
                                        </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="panel-footer">
                                <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                                <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss(base64_encode($_SESSION['etab'])); ?>" />
                                <button type="submit" class="btn btn-primary pull-right">Valider</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

<?php include('footer.php');?>



