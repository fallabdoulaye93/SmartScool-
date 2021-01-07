
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

$query_rq_totat_eleve = $dbh->query("SELECT count(IDINDIVIDU) as tot_eleve FROM INDIVIDU WHERE IDETABLISSEMENT = ".$colname_rq_totat_eleve." AND IDTYPEINDIVIDU=8");
$row_rq_totat_eleve = $query_rq_totat_eleve->fetchObject();


$colname_rq_eleve_par_pays = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_eleve_par_pays = $_SESSION['etab'];
}

$colname_anne_rq_eleve_par_pays = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_eleve_par_pays = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_eleve_par_pays = $dbh->query("SELECT count(INSCRIPTION.IDINSCRIPTION) as nbre, INDIVIDU.NATIONNALITE, PAYS.LIBELLE,PAYS.ROWID FROM INDIVIDU, PAYS, INSCRIPTION WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_eleve_par_pays." AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU AND PAYS.ROWID=INDIVIDU.NATIONNALITE   AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_anne_rq_eleve_par_pays." GROUP BY  PAYS.ROWID");


$colname_rq_nbre_prof = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_nbre_prof = $_SESSION['etab'];
}

$query_rq_nbre_prof = $dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as tot_eleve, RECRUTE_PROF.IDINDIVIDU FROM INDIVIDU, RECRUTE_PROF WHERE INDIVIDU.IDETABLISSEMENT = ".$colname_rq_nbre_prof." AND IDTYPEINDIVIDU=7 AND RECRUTE_PROF.IDINDIVIDU=INDIVIDU.IDINDIVIDU GROUP BY INDIVIDU.IDINDIVIDU");
$row_rq_nbre_prof = $query_rq_nbre_prof->fetchObject();


$colname_rq_filirre = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_filirre = $_SESSION['etab'];
}

$query_rq_filirre = $dbh->query("SELECT count(IDSERIE) as nbre FROM SERIE WHERE IDETABLISSEMENT = ".$colname_rq_filirre);
$row_rq_filirre = $query_rq_filirre->fetchObject();


$query_rq_niveau = $dbh->query("SELECT count(IDNIVEAU) as nbre FROM NIVEAU WHERE IDETABLISSEMENT = ".$colname_rq_filirre);
$row_rq_niveau = $query_rq_niveau->fetchObject();


$colname_rq_nbr_salle_classe = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_nbr_salle_classe = $_SESSION['etab'];
}

$query_rq_nbr_salle_classe = $dbh->query("SELECT count(IDSALL_DE_CLASSE) as nbre FROM SALL_DE_CLASSE WHERE IDETABLISSEMENT = ".$colname_rq_nbr_salle_classe);
$row_rq_nbr_salle_classe = $query_rq_nbr_salle_classe->fetchObject();


$colname_rq_inscription_par_niveau = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_inscription_par_niveau = $_SESSION['etab'];
}
$colname_anne_rq_inscription_par_niveau = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_inscription_par_niveau = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_inscription_par_niveau = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) as nbre, INSCRIPTION.IDNIVEAU, NIVEAU.LIBELLE FROM INSCRIPTION, NIVEAU WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_inscription_par_niveau." AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_anne_rq_inscription_par_niveau." GROUP BY INSCRIPTION.IDNIVEAU");

$colname_rq_inscription_par_filiere = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_inscription_par_filiere = $_SESSION['etab'];
}
$colname_anne_rq_inscription_par_filiere = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_inscription_par_filiere = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_inscription_par_filiere = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE, INSCRIPTION.IDSERIE, SERIE.LIBSERIE FROM INSCRIPTION, SERIE WHERE INSCRIPTION.IDETABLISSEMENT = ".$colname_rq_inscription_par_filiere." AND INSCRIPTION.IDSERIE =SERIE.IDSERIE AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_anne_rq_inscription_par_filiere." GROUP BY INSCRIPTION.IDSERIE");



$colname_rq_eleve_inscrit = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_eleve_inscrit = $_SESSION['etab'];
}
$colname_annee_rq_eleve_inscrit = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_annee_rq_eleve_inscrit = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_eleve_inscrit = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE FROM INSCRIPTION WHERE IDETABLISSEMENT = ".$colname_rq_eleve_inscrit." AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname_annee_rq_eleve_inscrit);
$row_rq_eleve_inscrit = $query_rq_eleve_inscrit->fetchObject();





?>


<?php include('../header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">PARAMETRAGE</a></li>                    
                    <li>Reporting</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
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
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                    
                   <div class="col-lg-6">
                    <fieldset class="cadre"><legend>REPORTING</legend>
                    <table  width="100%" border="0" cellpadding="0" cellspacing="3" class="table table-striped">
                     
                      <tr>
                        <th >NOMBRE DE FILI&Egrave;RES:</th>
                        <td ><?php echo $row_rq_filirre->nbre; ?></td>
                      </tr>
                      
                      <tr>
                        <th >NOMBRE DE NIVEAU:</th>
                        <td ><?php echo $row_rq_niveau->nbre; ?></td>
                      </tr>
                      
                      <tr>
                        <th >NOMBRE DE SALLE DE CLASSE:</th>
                        <td ><?php echo $row_rq_nbr_salle_classe->nbre; ?></td>
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
		
        