<?php
if (!isset($_SESSION)){
    session_start();
}

require_once("restriction.php");


require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

require_once('classe/IndividuManager.php');
$ind=new IndividuManager($dbh,'INDIVIDU');


$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etablissement = $_SESSION['etab'];
}

$colname_rq_idindividu = "-1";
if (isset($_SESSION['id'])) {
  $colname_rq_idindividu = $_SESSION['id'];
}

$colname_rq_classe = "-1";
if (isset($_POST['IDCLASSE'])) {
    $colname_rq_classe = $_POST['IDCLASSE'];
}

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_rq_annee = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_classe_eleve = $dbh->query("SELECT * FROM INDIVIDU,  AFFECTATION_ELEVE_CLASSE WHERE AFFECTATION_ELEVE_CLASSE.IDINDIVIDU = INDIVIDU.IDINDIVIDU AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = ".$colname_rq_classe." AND AFFECTATION_ELEVE_CLASSE.IDANNEESSCOLAIRE = ".$colname_rq_annee." AND INDIVIDU.IDINDIVIDU = ".$colname_rq_idindividu);


	$query_rq_classe = $dbh->query("SELECT NIVEAU.LIBELLE as lib, CLASSROOM.*   FROM CLASSROOM, NIVEAU WHERE IDCLASSROOM = ".$colname_rq_classe." AND NIVEAU.IDNIVEAU=CLASSROOM.IDNIVEAU");
	
	$row_rq_classe = $query_rq_classe->fetchObject();






?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active"> Bulletins de note</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="panel panel-default">

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
                
                <div class="row">


              
                    
                     <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                  <th >&nbsp;</th>
                                  <th>MATRICULE</th>
                                  <th>PRENOMS</th>
                                  <th>NOM</th>
                                   <th>TEL</th>
                                   <th>NIVEAU </th>
                                   <th>CLASSE</th>
                                  <th>IMPRIMER</th>
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                            <?php foreach($query_rq_classe_eleve->fetchAll() as $row_rq_classe_eleve) {  ?>
                            <tr>
                                    <td><img src="../imgtiers/<?php echo $row_rq_classe_eleve['PHOTO_FACE']; ?>" width="31px" height="31px" /></td>
                                    <td><?php echo $row_rq_classe_eleve['MATRICULE']; ?></td>
                                    <td><?php echo $row_rq_classe_eleve['PRENOMS']; ?></td>
                                     <td><?php echo $row_rq_classe_eleve['NOM']; ?></td>
                                     <td><?php echo $row_rq_classe_eleve['TELMOBILE']; ?></td>
                                     <td><?php echo $row_rq_classe->lib; ?></td>
                                     <td><?php echo $row_rq_classe->LIBELLE; ?></td>
                                    <td ><a href="#" onclick="imprimer2(<?php echo $row_rq_classe_eleve['IDINDIVIDU']; ?>)" ><i class="glyphicon glyphicon-print"></i> </a></td>
                                  </tr>
                            <?php } ?>
           
    </tbody>     
    </table>  
    <form id="form1" name="form1" method="post" action="" class="form-inline">

                    <input type="hidden" name="idetablissement" id="idetablissement"  value="<?php echo $_SESSION['etab']; ?>" />
                    <input type="hidden" name="IDPERIODE" id="IDPERIODE"  value="<?php echo $_POST['IDPERIODE']; ?>" />
                    <input type="hidden" name="IDCLASSE" id="IDCLASSE"  value="<?php echo $_POST['IDCLASSE']; ?>" />
                    <input type="hidden" name="IDANNEE" id="IDANNEE"  value="<?php echo $_SESSION['ANNEESSCOLAIRE']; ?>" />

                </form>


           
            </div>
                    <!-- END WIDGETS -->                    
                    
                        </div></div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
        
        

        <?php include('footer.php'); ?>