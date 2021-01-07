
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

if($lib->securite_xss($_SESSION['profil'])!=1)
$lib->Restreindre($lib->Est_autoriser(47,$lib->securite_xss($_SESSION['profil'])));


$colname_rq_totat_eleve = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_totat_eleve = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_totat_eleve = $dbh->query("SELECT count(IDINDIVIDU) as tot_eleve FROM INDIVIDU WHERE IDETABLISSEMENT = ".$colname_rq_totat_eleve." AND IDTYPEINDIVIDU=8");
$row_rq_totat_eleve = $query_rq_totat_eleve->fetchObject();


$colname_rq_eleve_par_pays = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_eleve_par_pays = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne_rq_eleve_par_pays = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_eleve_par_pays = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_eleve_par_pays = $dbh->query("SELECT count(INSCRIPTION.IDINSCRIPTION) as nbre, INDIVIDU.NATIONNALITE, PAYS.LIBELLE,PAYS.ROWID FROM INDIVIDU, PAYS, INSCRIPTION WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_eleve_par_pays." AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU AND PAYS.ROWID=INDIVIDU.NATIONNALITE   AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_anne_rq_eleve_par_pays." GROUP BY  PAYS.ROWID");


$colname_rq_nbre_prof = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_nbre_prof = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_nbre_prof = $dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as tot_eleve, RECRUTE_PROF.IDINDIVIDU FROM INDIVIDU, RECRUTE_PROF WHERE INDIVIDU.IDETABLISSEMENT = ".$colname_rq_nbre_prof." AND IDTYPEINDIVIDU=7 AND RECRUTE_PROF.IDINDIVIDU=INDIVIDU.IDINDIVIDU GROUP BY INDIVIDU.IDINDIVIDU");
$row_rq_nbre_prof = $query_rq_nbre_prof->fetchObject();



$colname_rq_inscription_par_niveau = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_inscription_par_niveau = $lib->securite_xss($_SESSION['etab']);
}
$colname_anne_rq_inscription_par_niveau = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_inscription_par_niveau = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_inscription_par_niveau = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) as nbre, INSCRIPTION.IDNIVEAU, NIVEAU.LIBELLE FROM INSCRIPTION, NIVEAU WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_inscription_par_niveau." AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_anne_rq_inscription_par_niveau." GROUP BY INSCRIPTION.IDNIVEAU");

$colname_rq_inscription_par_filiere = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_inscription_par_filiere = $lib->securite_xss($_SESSION['etab']);
}
$colname_anne_rq_inscription_par_filiere = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_inscription_par_filiere = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_inscription_par_filiere = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE, INSCRIPTION.IDSERIE, SERIE.LIBSERIE FROM INSCRIPTION, SERIE WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_inscription_par_filiere." AND INSCRIPTION.IDSERIE =SERIE.IDSERIE AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_anne_rq_inscription_par_filiere." GROUP BY INSCRIPTION.IDSERIE");



$colname_rq_eleve_inscrit = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_eleve_inscrit = $lib->securite_xss($_SESSION['etab']);
}
$colname_annee_rq_eleve_inscrit = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_annee_rq_eleve_inscrit = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_eleve_inscrit = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE FROM INSCRIPTION WHERE IDETABLISSEMENT = ".$colname_rq_eleve_inscrit." AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_annee_rq_eleve_inscrit);
$row_rq_eleve_inscrit = $query_rq_eleve_inscrit->fetchObject();





?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Reporting</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $lib->securite_xss($_GET['msg'])!= ''){

                        if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])==1)
                        {?>
                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $_GET['msg']; ?></div>
                        <?php  }
                        if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])!=1)
                        {?>
                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $_GET['msg']; ?></div>
                        <?php }
                        ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                    
                    <div class="col-lg-6">
                     <fieldset class="cadre"><legend>REPORTING </legend>
                    <table  width="100%" border="0" cellpadding="0" cellspacing="3" class="table table-striped">
                      <tr>
                        <th >NOMBRE D'&Eacute;L&Egrave;VES INSCRITS:</th>
                        <td ><?php echo $row_rq_eleve_inscrit->NBRE; ?></td>
                      </tr>
                      
                      <tr>
                        <th >NOMBRE DE PROFESSEURS:</th>
                        <td ><?php echo $row_rq_nbre_prof->tot_eleve; ?></td>
                      </tr>
                      
                   </table>
                    </fieldset>
                    </div>
                    
                    <div class="col-lg-6">
                    
                    <fieldset class="cadre"><legend>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS PAR NATIONALIT&Eacute;</legend>
                    
                     <table width="100%" border="0" cellspacing="3" cellpadding="0" class="table table-striped">
        
                            <tr>
                              <th>NATIONALIT&Eacute;S</th>
                              <th>NOMBRE</th>
                              </tr>
                            <?php 
                            $tab=array();
                            $i=0;
                            foreach($query_rq_eleve_par_pays->fetchAll() as $row_rq_eleve_par_pays) {  ?>
                            <tr>
                              <td ><?php echo htmlentities($row_rq_eleve_par_pays['LIBELLE']); ?></td>
                              <td ><?php echo $row_rq_eleve_par_pays['nbre']; ?></td>
                              </tr>
                            <?php 
                            $tab[$i]=array("Nationalite"=>$row_rq_eleve_par_pays['LIBELLE'],"nbreEeleves"=>$row_rq_eleve_par_pays['nbre']);
                            $i++;
                                                 }  ?>
         
          
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
		
        