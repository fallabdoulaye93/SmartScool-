
<?php 
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib=new Librairie();

if($_SESSION['profil']!=1) 
$lib->Restreindre($lib->Est_autoriser(8, $lib->securite_xss($_SESSION['profil'])));

require_once('classe/TypeSalleManager.php');
$types=new TypeSalleManager($dbh,'TYPE_SALLE');
$type = $types->getTypeSalle("IDETABLISSEMENT", $lib->securite_xss($_SESSION['etab']));

$colname_rq_salle = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_salle = $lib->securite_xss($_SESSION['etab']);
}

try
{

    $query_rq_salle = $dbh->query("SELECT SALL_DE_CLASSE.IDSALL_DE_CLASSE, SALL_DE_CLASSE.NOM_SALLE, SALL_DE_CLASSE.NBR_PLACES, TYPE_SALLE.TYPE_SALLE 
                                              FROM SALL_DE_CLASSE, TYPE_SALLE 
                                              WHERE SALL_DE_CLASSE.IDETABLISSEMENT = ".$colname_rq_salle." 
                                              AND SALL_DE_CLASSE.IDTYPE_SALLE=TYPE_SALLE.IDTYPE_SALLE");
    $rs_salle = $query_rq_salle->fetchAll();
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
                    <li>Salle</li>
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
                            <i class="fa fa-plus"></i> Nouvelle salle</button>
                            
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
                                     <th >NOM DE LA SALLE</th>
                                     <th>TYPE DE SALLE</th>
                                     <th>NB PLACES</th>
                                     <th >Modifier</th>
                                     <th >Supprimer</th>
                            </tr>
                            </thead>
                           
                          
                            <tbody>

                           <?php foreach ($rs_salle as $salle){ ?>

                            <tr>
        
                                <td ><?php echo $lib->securite_xss($salle['NOM_SALLE']); ?></td>
                                <td ><?php echo $lib->securite_xss($salle['TYPE_SALLE']); ?></td>
                                <td ><?php echo $lib->securite_xss($salle['NBR_PLACES']); ?></td>
                                <td ><a href="modifSalle.php?idSalle=<?php echo $lib->securite_xss(base64_encode($salle['IDSALL_DE_CLASSE'])); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>
                                <td ><a href="suppSalle.php?idSalle=<?php echo $lib->securite_xss(base64_encode($salle['IDSALL_DE_CLASSE'])); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cet enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
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
                    <h3 class="panel-title text-center"> Nouvelle salle </h3> <!-- IDSALL_DE_CLASSE NOM_SALLE IDTYPE_SALLE IDETABLISSEMENT NBR_PLACES-->
                </div>
                <form action="ajouterSalle.php" method="POST">
         
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >NOM SALLE</label>
                                    <div>
                                        <input type="text" name="NOM_SALLE" id="NOM_SALLE" required class="form-control"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >Type salle</label>
                                    <div>
                                        <select name="IDTYPE_SALLE" class="form-control selectpicker" data-live-search="true" id="idsalle" >
                                        <option value="">--Selectionner le type de salle-- </option>

                                            <?php foreach ($type as $typ){ ?>

                                                <option value=" <?php echo $typ->getIDTYPE_SALLE(); ?>"><?php echo $typ->getTYPE_SALLE(); ?> </option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >NOMBRE DE PLACES</label>
                                    <div>
                                        <input type="number" name="NBR_PLACES" id="NBR_PLACES" required class="form-control"  onchange="verification();" />
                                    </div>
                                </div>
                            </div>



                        </div>

                        

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>" />

                        
                        <button type="submit" style="display: none" id="idvalider" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

       <?php include('footer.php');?>

<script>
    function verification() {
        var idsalle = document.getElementById('idsalle').value;
        var idvalider = document.getElementById('idvalider');
        if (idsalle ==""){
            alert("Veuillez selectionner le type de salle");
            idvalider.style.display="none";
        }
        else {

            idvalider.style.display="block";
        }
    }
</script>





