
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

if($_SESSION['profil'] != 1) 
$lib->Restreindre($lib->Est_autoriser(32,$lib->securite_xss($_SESSION['profil'])));

$date_debut = $lib->securite_xss($_POST['date_debut']);
$date_fin = $lib->securite_xss($_POST['date_fin']);

$colname_rq_histo_paiement = "-1";
if (isset($_SESSION["etab"])) {
  $colname_rq_histo_paiement = $lib->securite_xss($_SESSION["etab"]);
}

$colname_rq_annee = "-1";
if (isset($_SESSION["ANNEESSCOLAIRE"])) {
  $colname_rq_annee = $lib->securite_xss($_SESSION["ANNEESSCOLAIRE"]);
}

$cond = "";
if (isset($date_debut) && isset($date_fin) && $date_debut !='' && $date_fin !="" )
{
    $cond.=" AND M.DATEREGLMT >='".$date_debut."'"." AND M.DATEREGLMT <='".$date_fin."'";
}


try
{
    $query_rq_histo_paiement = $dbh->query("SELECT M.DATEREGLMT, M.MOIS, M.MT_VERSE, IND.MATRICULE, IND.NOM, IND.PRENOMS, T.libelle_paiement
                                                FROM MENSUALITE M
                                                INNER JOIN INSCRIPTION I ON M.IDINSCRIPTION = I.IDINSCRIPTION 
                                                INNER JOIN INDIVIDU IND ON I.IDINDIVIDU = IND.IDINDIVIDU 
                                                INNER JOIN TYPE_PAIEMENT T ON M.id_type_paiment = T.id_type_paiment 
                                                WHERE I.IDETABLISSEMENT = ".$colname_rq_histo_paiement." 
                                                AND I.IDANNEESSCOLAIRE = ". $colname_rq_annee." ".$cond);
    $rs_reglement = $query_rq_histo_paiement->fetchAll();

    $histo_paiement = $dbh->query("SELECT SUM(M.MT_VERSE) as montant, T.libelle_paiement
                                          FROM MENSUALITE M
                                          INNER JOIN TYPE_PAIEMENT T ON M.id_type_paiment = T.id_type_paiment ".$cond." 
                                          GROUP BY M.id_type_paiment");
    $rs_total = $histo_paiement->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOException $e){
    echo -2;
}


?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TRESORERIE</a></li>                    
                    <li>Historique Périodique</li>
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
                 
                         <form id="form1" name="form1" method="post" action="" >
                                <fieldset class="cadre"><legend> Filtre</legend>

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group" style="width: 100%;padding: 10px;">
                                            <label for="nom" class="control-label">Date de début</label>
                                            <input type="date" name="date_debut" id="from"  class="form-control"
                                                   value="" style="width: 100%" >
                                            <span class="help-block with-errors"> </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group" style="width: 100%;padding: 10px;">
                                            <label for="nom" class="control-label">Date de fin</label>
                                            <input type="date" name="date_fin"  class="form-control"
                                                   style="width: 100%" >
                                            <span class="help-block with-errors"> </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group" style="width: 100%;padding: 10px;">
                                            <label for="nom" class="control-label"></label>
                                            <div>
                                                <button  style="text-align: right; margin-top: 5px;" data-form="my-form"  class="btn btn-success" type="submit"><i class="fa fa-check"></i>Rechercher</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </fieldset>
                         </form><br><br>

                        <div>
                            <center>
                                <h4> Historique périodique des réglements du  <?php echo $lib->date_fr($date_debut);?> au <?php echo $lib->date_fr($date_fin);?>  </h4>
                            </center>
                        </div>

                        <table id="customers2" class="table datatable">

                            <thead>
                                <tr>
                                    <th>DATE DE REGLEMENT</th>
                                    <th>MOIS</th>
                                    <th>MATRICULE</th>
                                    <th>NOM</th>
                                    <th>PRENOMS</th>
                                    <th>TYPE PAIEMENT</th>
                                    <th style="text-align: right !important;">MONTANT VERSE (F CFA)</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                            $total = 0;
                            foreach($rs_reglement as $row_rq_histo_paiement)
                            {
                                $total+=$row_rq_histo_paiement['MT_VERSE'];
                                ?>
                                <tr>
                                    <td><?php echo $lib->date_fr($row_rq_histo_paiement['DATEREGLMT']); ?></td>
                                    <td><?php echo $row_rq_histo_paiement['MOIS']; ?></td>
                                    <td><?php echo $row_rq_histo_paiement['MATRICULE']; ?></td>
                                    <td><?php echo $row_rq_histo_paiement['NOM']; ?></td>
                                    <td><?php echo $row_rq_histo_paiement['PRENOMS']; ?></td>
                                    <td><?php echo $row_rq_histo_paiement['libelle_paiement']; ?></td>
                                    <td style="text-align: right !important;"><?php echo $lib->nombre_form($row_rq_histo_paiement['MT_VERSE']); ?></td>
                                </tr>

                            <?php } ?>

                            </tbody>
                        </table>

                        <div class="col-sm-3"></div>

                        <div class="col-sm-6">
                            <fieldset class="cadre">
                                <legend>Total par Type de paiement</legend>
                                <table  class="table">

                                    <thead>
                                    <tr>
                                        <th>TYPE DE PAIEMENT</th>
                                        <th style="text-align: right !important;">MONTANT (F CFA)</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $total2 = 0;
                                    foreach($rs_total as $moyen_paiement){
                                        $total2+=$moyen_paiement['montant'];
                                        ?>

                                        <tr>
                                            <td><?php echo $moyen_paiement['libelle_paiement']; ?></td>
                                            <td style="text-align: right">
                                                <?php echo $lib->nombre_form($moyen_paiement['montant']); ?>
                                            </td>
                                        </tr>


                                    <?php } ?>


                                    <tr>
                                        <th>TOTAL : </th>

                                        <td style="text-align: right"><?php echo $lib->nombre_form($total2);?></td>
                                    </tr>

                                    </tbody>


                                </table>
                            </fieldset>
                        </div>

                        <div class="col-sm-3"></div>

              
                    </div>
                     </div>
                    </div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTAINER -->


        <?php include('footer.php'); ?>