
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(51,$_SESSION['profil']));

$colname_rq_typsalle = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_typsalle = $lib->securite_xss($_SESSION['etab']);
}


$query_banque = $dbh->query("SELECT ROWID, LABEL, TEL, ADRESSE, ETAT, IDETABLISSEMENT 
                                       FROM BANQUE 
                                       WHERE ETAT = 1 
                                       AND IDETABLISSEMENT =  ".$colname_rq_typsalle." 
                                       ORDER BY LABEL ASC");
$rs_banque = $query_banque->fetchAll();

?>


<?php include('../header.php'); ?>
               <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Param&eacute;trage</a></li>                    
                    <li>Banques</li>
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
                            <i class="fa fa-plus"></i> Nouvelle banque</button>
                        </div>

                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
				 
				  if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						 <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						  <?php } ?>
                 
			     <?php } ?>
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                    <th>Banque</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>

                                    <th >Modifier</th>
                                    <th >Supprimer</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?php foreach ($rs_banque as $row) { ?>

                            <tr>
                                <td><?php echo $row['LABEL']; ?></td>
                                <td><?php echo $row['TEL']; ?></td>
                                <td><?php echo $row['ADRESSE']; ?></td>
                                <td><a href="modifBanque.php?ban=<?php echo base64_encode($row['ROWID']); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                                <td><a href="suppBanque.php?ban=<?php echo base64_encode($row['ROWID']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
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
                    <h3 class="panel-title text-center"> Nouvelle banque </h3>
                </div>
                <form action="ajouterBanque.php" method="POST">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                <label >LIBELLE (*) : </label>
                                <div>
                                    <input type="text" name="LABEL" id="LABEL" required class="form-control"/>
                                </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                <label >TEL : </label>
                                <div>
                                    <input type="number" name="TEL" id="TEL" class="form-control" placeholder="format : 221XXXXXXXXX"/>
                                </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                <label >ADRESSE : </label>
                                <div>
                                    <textarea name="ADRESSE" class="form-control"rows="5"></textarea>
                                </div>
                                </div>
                            </div>
                            

                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>" />

                        
                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

       <?php include('footer.php');?>



