
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

$colname_rq_annee = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_rq_annee = $_SESSION['ANNEESSCOLAIRE'];
}



$colname_rq_idindividu = "-1";
if (isset($_SESSION['id'])) {
  $colname_rq_idindividu = $_SESSION['id'];
}

//$_SESSION["id"]


$query_rq_etablissement = $dbh->query("SELECT *, NIVEAU.LIBELLE, SERIE.LIBSERIE FROM INSCRIPTION, NIVEAU, SERIE WHERE IDINDIVIDU = ".$colname_rq_idindividu." AND IDANNEESSCOLAIRE = ".$colname_rq_annee."  AND NIVEAU.IDNIVEAU= INSCRIPTION.IDNIVEAU AND SERIE.IDSERIE = INSCRIPTION.IDSERIE");






?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active">Inscription </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
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
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                                       
                   
       <table id="customers2" class="table datatable">
                        
                         <thead>
                            <tr>
                                    <th>DATE INSCRIPTION</th>
                                    <th>NIVEAU</th>
                                    <th>SERIE</th>
                                    <th>FRAIS INSCRIPTION</th>
                                    <th>MONTANT</th>
                                    <th >ACCOMPTE VERSE</th>
                                    <th >ACCORD MENSUALITE</th>
                                   
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                           <?
                            foreach ($query_rq_etablissement->fetchAll() as $insc){
                               
                                ?>
                            <tr>
        
                                <td ><?php echo $lib->date_fr($insc['DATEINSCRIPT']); ?></td>
                                <td ><?php echo $insc['LIBELLE']; ?></td>
                                <td ><?php echo $insc['LIBSERIE']; ?></td>
                                <td ><?php echo $insc['FRAIS_INSCRIPTION']; ?></td>
                                <td ><?php echo $insc['MONTANT']; ?></td>
                                 <td ><?php echo $insc['ACCOMPTE_VERSE']; ?></td>
                                 <td ><?php echo $lib->nombre_form($insc['ACCORD_MENSUELITE']); ?></td>
                                
                               
                                
                                   </tr>
                            <?php }  ?>
           
    </tbody>     
    </table>
                      
                    </div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        
        
        

        <?php include('footer.php'); ?>