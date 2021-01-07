
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
$lib->Restreindre($lib->Est_autoriser(47,$_SESSION['profil']));


$colname_rq_totat_eleve = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_totat_eleve = $_SESSION['etab'];
  
}



$cond="";

if(isset($_POST['date1'])&& $_POST['date1']!='')
{
	$cond.=" AND MENSUALITE.DATEREGLMT >= '".$_POST['date1']."'";
	
}

if(isset($_POST['date2'])&& $_POST['date2']!='')
{
	$cond.=" AND MENSUALITE.DATEREGLMT <= '".$_POST['date2']."'";
	
}


$colname1_rq_mois = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname1_rq_mois = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_mois =  $dbh->query("SELECT SUM(MENSUALITE.MONTANT) as somme_totale, SUM(MENSUALITE.MT_VERSE) as somme_verse, SUM(MENSUALITE.MT_RELIQUAT) as somme_reliquat, INSCRIPTION.IDINSCRIPTION FROM MENSUALITE, INSCRIPTION WHERE  INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_totat_eleve."  AND  MENSUALITE.IDINSCRIPTION=INSCRIPTION.IDINSCRIPTION  AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname1_rq_mois.$cond);

$row_rq_mois = $query_rq_mois->fetchObject();






?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li class="active">Reporting</li>
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
                    
                    <div class="col-lg-12">
                    <fieldset class="cadre"><legend>Filtre</legend>
                    
                     <form id="form1" name="form1" method="post" action="" >
      
                        <div class="form-group col-lg-2">
                    <label for="exampleInputName2">Date debut : </label>
                    <input type="text" name="date1" id="date_foo" />
                  </div> 
                  
                    <div class="form-group col-lg-2">
                    <label for="exampleInputName2">Date fin : </label>
                     <input type="text" name="date2" id="date_foo2" />
                  </div>
                  
                  
                   <div class="form-group col-lg-1">
                  <button type="submit" class="btn btn-primary">Rechercher</button>
                  </div>
                </form>
                    </fieldset>
                    </div> 
                     </div>
                     
                     
                     <div class="row">
                    
                    <div class="col-lg-12">
                    <fieldset class="cadre"><legend></legend>
                    
                    <table width="80%" border="0" cellpadding="0" cellspacing="0">
                        <tr>                       
                            <th>MONTANT PREVU</th>
                            <td><?php  echo $lib->nombre_form($row_rq_mois->somme_totale); ?></td>
                        </tr>
                        
                        <tr>                       
                            <th>MONTANT VERSE</th>
                            <td><?php echo $lib->nombre_form($row_rq_mois->somme_verse); ?></td>
                        </tr>
                        
                        <tr>                       
                            <th>MONTANT RESTANT</th>
                            <td><?php echo $lib->nombre_form($row_rq_mois->somme_reliquat); ?></td>
                        </tr>
                        
                         
                        
                 </table>
                    
                    </fieldset>
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
		
        