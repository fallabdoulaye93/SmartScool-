<?php
session_start();
require_once("../../restriction.php");
require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(49,$lib->securite_xss($_SESSION['profil'])));

$colname_REQ_class = "-1";
if (isset($_SESSION['etab'])) {
  $colname_REQ_class = $lib->securite_xss($_SESSION['etab']);
}


require_once('classe/NiveauManager.php');
$niveaux=new NiveauManager($dbh,'NIVEAU');
$niveau = $niveaux->getNiveau('IDETABLISSEMENT',$lib->securite_xss($_SESSION['etab']));


$row_REQ_class = $dbh->query("SELECT nc.ID, nc.LIBELLE, n.LIBELLE as CYCLE, n.IDNIVEAU FROM NIV_CLASSE nc
                                        INNER JOIN NIVEAU n ON nc.IDNIVEAU = n.IDNIVEAU
                                        WHERE nc.IDETABLISSEMENT = ".$colname_REQ_class." ORDER BY nc.IDNIVEAU ASC" );
?>


<?php include('../header.php'); ?>
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Niveaux</li>
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
                            <i class="fa fa-plus"></i> Nouveau niveau</button>
                            
                        </div>

                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1)
						  {?>
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
                                <th>NIVEAU</th>
                                <th>CYCLE</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                            <?php foreach ($row_REQ_class->fetchAll() as $classe) { ?>

                               <tr>
                                    <td><?php echo $classe['LIBELLE']; ?></td>
                                    <td><?php echo $classe['CYCLE']; ?></td>

                                    <td><a href="modifNiv.php?niv=<?php echo base64_encode($classe['ID']); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                               
                                    <td>
                                        <a href="suppNiv.php?niv=<?php echo base64_encode($classe['ID']); ?>"  onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
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
                    <h3 class="panel-title text-center"> Ajouter niveau </h3>
                </div>
                <form action="ajouterNiv.php" method="POST">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>CYCLE</label>
                                    <div>
                                        <select name="IDNIVEAU" class="form-control" data-live-search="true" required>
                                            <option value="">--Selectionner le cycle-- </option>
                                            <?php foreach ($niveau as $niv) { ?>
                                                <option value=" <?php echo $niv->getIDNIVEAU(); ?>"><?php echo $niv->getLIBELLE(); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                <label >LIBELLE</label>
                                <div>
                                    <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control" />
                                </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>" />

                        <button type="submit" id="idvalider" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php include('footer.php');?>

