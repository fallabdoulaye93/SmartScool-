<?php
include('header.php');
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

$idprof = $lib->securite_xss($_SESSION["id"]);

try
{
    $query_mens_etudiant = $dbh->prepare("SELECT m.LIBELLE as matier, d.TITRE_COURS, d.CONTENUCOURS , d.DATE, d.HEUREDEBUTCOURS, d.HEUREFINCOURS, cl.LIBELLE, s.NOM_SALLE, d.ETAT
                                                FROM DISPENSER_COURS d
                                                INNER JOIN MATIERE m ON d.IDMATIERE = m.IDMATIERE
                                                INNER JOIN CLASSROOM cl ON d.IDCLASSROOM = cl.IDCLASSROOM
                                                INNER JOIN SALL_DE_CLASSE s ON d.IDSALL_DE_CLASSE = s.IDSALL_DE_CLASSE
                                                WHERE  d.IDINDIVIDU = ?
                                                ORDER BY d.DATE DESC");
    $query_mens_etudiant->execute(array($idprof));
    $query_mens_etudiant = $query_mens_etudiant->fetchAll(PDO::FETCH_OBJ);
}
catch (PDOException $e)
{
    echo -2;
}

?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">PARENT</a></li>
    <li class="active">Mensualité</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">
        <div>
            <p><h4 style="color:#E05D1F;margin-left: 15px;">L'historique des mises à jour </h4></p>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">

                <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
                    if(isset($_GET['res']) && $_GET['res']==1)  {?>
                        <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $lib->securite_xss($_GET['msg']); ?>
                        </div>
                    <?php  }
                    if(isset($_GET['res']) && $_GET['res']!=1)  {?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?= $lib->securite_xss($_GET['msg']); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <table id="customers2" class="table datatable table-striped">
                    <thead>
                    <tr>

                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Classe</th>
                        <th>Salle de classe</th>
                        <th>Matière</th>
                        <th>Libellé du cour</th>
                        <th>Contenu du cours</th>
                        <th>Etat</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($query_mens_etudiant) > 0)
                    {
                        foreach ($query_mens_etudiant as $oneFact) {

                        if($oneFact->ETAT == 0){ $etat = "<i style='color: #ff3f43;font-size: 12px;'><b>NON VALIDER</b></i>";}
                        elseif($oneFact->ETAT == 1 ){ $etat = "<i style='color: #ffba31;font-size: 12px;'><b>VALIDER</b></i>"; }

                        ?>
                        <tr>

                            <td><?= $lib->date_fr($oneFact->DATE); ?></td>
                            <td><?= $oneFact->HEUREDEBUTCOURS; ?></td>
                            <td><?= $oneFact->HEUREFINCOURS; ?></td>
                            <td><?= $oneFact->LIBELLE ;?></td>
                            <td><?= $oneFact->NOM_SALLE ;?></td>
                            <td><?= $oneFact->matier ;?></td>
                            <td><?= $oneFact->TITRE_COURS ;?></td>
                            <td><?= html_entity_decode($oneFact->CONTENUCOURS) ; ?></td>
                            <td><?= $etat; ?></td>

                        </tr>
                    <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
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