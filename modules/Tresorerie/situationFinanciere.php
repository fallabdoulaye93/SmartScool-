
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

if($lib->securite_xss($_SESSION['profil']) != 1)
$lib->Restreindre($lib->Est_autoriser(31,$lib->securite_xss($_SESSION['profil'])));


$colname_rq_mois = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_mois = $lib->securite_xss($_SESSION['etab']);
}
$colname1_rq_mois = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname1_rq_mois = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$query_rq_mois = $dbh->query("SELECT MONTH(MENSUALITE.DATEREGLMT) as mois FROM MENSUALITE INNER JOIN INSCRIPTION ON INSCRIPTION.IDINSCRIPTION = MENSUALITE.IDINSCRIPTION  WHERE MENSUALITE.IDETABLISSEMENT = ".$colname_rq_mois."  AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname1_rq_mois."  GROUP BY MONTH(MENSUALITE.DATEREGLMT)");


?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li>Situation Financi&egrave;re</li>
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
                    
                    <?php if(isset($_GET['msg']) && $lib->securite_xss($_GET['msg'])!= ''){
				 
				  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])==1)
						  {?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->affichage_xss($_GET['msg']); ?></div>
						 <?php  }
						  if(isset($_GET['res']) && $lib->securite_xss($_GET['res'])!=1)
						  {?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->affichage_xss($_GET['msg']); ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                 
                 
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-hover">
                 <!-- <tr> <th colspan="5">ANNEE SCOLAIRE EN COURS</th> </tr>-->
                 <caption><center> <h3> ANNEE SCOLAIRE EN COURS </h3></center></caption>
                  
                        
                         <thead>
                         
                            <tr>
                                <th>&nbsp;&nbsp;</th>
                                <th>SCOLARITES</th>
                                <th>PAIEMENT PROFESSEUR</th>
                                <th>PAIEMENT ADMINISTRATION</th>
                                <th>DEPENSE</th>
                                <th>SOLDES</th>
                                
                                
                                 
                            </tr>
                            </thead>
                           
                          
                            <tbody>
                            
                                  
                            
                            <?php 
	 $total_socalrite=0;
	 $total_paiement_prof=0;
	 $total_charge=0;
	 
	 
	    foreach($query_rq_mois->fetchAll() as $row_rq_mois){    
	      
					
	//TOTAL SCOLARITE
    $colname_rq_scolarite = $lib->securite_xss($_SESSION['etab']);
    $coldate_rq_scolarite = $row_rq_mois['mois'];
    $colname1_rq_scolarite = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);


    $query_rq_scolarite = $dbh->query("SELECT SUM(MENSUALITE.MONTANT) as somme_verse FROM MENSUALITE INNER JOIN INSCRIPTION ON INSCRIPTION.IDINSCRIPTION = MENSUALITE.IDINSCRIPTION  WHERE  MENSUALITE.IDETABLISSEMENT = ".$colname_rq_scolarite."  AND  MONTH(MENSUALITE.DATEREGLMT)=".$coldate_rq_scolarite."  AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname1_rq_scolarite);


    $row_rq_scolarite = $query_rq_scolarite->fetchObject();
		
    //PAIEMENT DES PROF
    $colname_rq_somme_prof = $row_rq_mois['mois'];
    $col_etab_rq_somme_prof = $lib->securite_xss($_SESSION['etab']);
    $col_anne_rq_somme_prof = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);

    $query_rq_somme_prof = $dbh->query("SELECT SUM(REGLEMENT_PROF.MONTANT) AS SOMME_PROF FROM REGLEMENT_PROF INNER JOIN RECRUTE_PROF ON REGLEMENT_PROF.INDIVIDU=RECRUTE_PROF.IDINDIVIDU  WHERE  MONTH(REGLEMENT_PROF.DATE_REGLEMENT )= ".$colname_rq_somme_prof." AND RECRUTE_PROF.IDETABLISSEMENT=".$col_etab_rq_somme_prof." AND RECRUTE_PROF.IDANNEESSCOLAIRE=".$col_anne_rq_somme_prof);

    $row_rq_somme_prof = $query_rq_somme_prof->fetchObject();
			
 // AUTRES CHARGES

    $colname_rq_equipement = $lib->securite_xss($_SESSION['etab']);
    $col_mois_rq_equipement = $row_rq_mois['mois'];
    $col_ann_rq_equipement = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);


    $query_rq_equipement = $dbh->query("SELECT SUM(REGLEMENT_PERSO.MONTANT) AS SOMME_PERSO FROM REGLEMENT_PERSO INNER JOIN UTILISATEURS ON REGLEMENT_PERSO.INDIVIDU=UTILISATEURS.idUtilisateur WHERE  MONTH(REGLEMENT_PERSO.DATE_REGLEMENT )= ".$col_mois_rq_equipement." AND REGLEMENT_PERSO.IDANNEESCOLAIRE=".$col_ann_rq_equipement);

    $row_rq_equipement = $query_rq_equipement->fetchObject();

    //CHARGES ;
    //$solde=$row_rq_scolarite['somme_verse'] -($row_rq_somme_prof['SOMME_PROF'] +$row_rq_equipement['SOMME_PERSO'] );
     // DEPENSE

    $colname_rq_depense = $lib->securite_xss($_SESSION['etab']);
    $col_mois_rq_depense = $row_rq_mois['mois'];
    $col_ann_rq_depense = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);


    $query_rq_depense = $dbh->query("SELECT SUM(DEPENSE.MONTANT) AS DEPNSE FROM DEPENSE WHERE  MONTH(DEPENSE.DATE_REGLEMENT )= ".$col_mois_rq_depense."  AND  DEPENSE.IDANNEESCOLAIRE=".$col_ann_rq_equipement." AND  DEPENSE.IDETABLISSEMENT=".$colname_rq_depense);

    $row_rq_depense = $query_rq_depense->fetchObject();

    //DEPENSE ;
    $solde=$row_rq_scolarite->somme_verse -($row_rq_somme_prof->SOMME_PROF +$row_rq_depense->DEPNSE+$row_rq_equipement->SOMME_PERSO  );
	//CALCUL DES TOTAUX
	 $total_socalrite+=$row_rq_scolarite->somme_verse;
	 $total_paiement_prof+=$row_rq_somme_prof->SOMME_PROF;
	 $total_charge+=$row_rq_equipement->SOMME_PERSO;
	 $total_charge2+=$row_rq_depense->DEPNSE;
	  ?>
      
      
                          
                            <tr>
        
                                <th><?php echo $lib->Le_mois($row_rq_mois['mois']); ?></th>
                                <td><?php echo $lib->nombre_form($row_rq_scolarite->somme_verse); ?></td>
                                <td><?php echo $lib->nombre_form($row_rq_somme_prof->SOMME_PROF); ?></td>
                                <td><?php echo $lib->nombre_form($row_rq_equipement->SOMME_PERSO); ?></td>
                                <td><?php echo $lib->nombre_form($row_rq_depense->DEPNSE); ?></td>
                                <td><?php echo $lib->nombre_form($solde); ?></td>
                                
                                    
                                  </tr>
<?php
		 
		 }  ?>  
         <tr>
          <th>TOTAL</th>
        <th><?php echo $lib->nombre_form($total_socalrite); ?></th>
        <th><?php echo $lib->nombre_form($total_paiement_prof); ?></th>
        <th><?php echo $lib->nombre_form($total_charge); ?></th>
        <th><?php echo $lib->nombre_form($total_charge2); ?></th>
        <th><?php echo $lib->nombre_form($total_socalrite -($total_charge + $total_paiement_prof+$total_charge2)); ?></th>
      </tr>         
    </tbody>     
    </table><br><br>
    
    
                    
                    
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>