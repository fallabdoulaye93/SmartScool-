<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();
$niveau = $lib->securite_xss($_GET['IDCLASSROOM']);

if(!isset($_GET['IDCLASSROOM']) || !isset($_GET['IDETUDIANT']) || !isset($_GET['NOM']))
    header("location:/sunuecole/PARENTS/mes_etudiant.php");
$nomEtudiant = str_replace("-"," ",$_GET['NOM']);
$anScol = (isset($_POST['anScol'])) ? $_POST['anScol'] : $_SESSION['ANNEESSCOLAIRE'];
$requete = "SELECT DISPENSER_COURS.DATE as dateCours, DISPENSER_COURS.HEUREDEBUTCOURS as heureDeb, DISPENSER_COURS.HEUREFINCOURS as heureFin, DISPENSER_COURS.TITRE_COURS as titreCours, DISPENSER_COURS.CONTENUCOURS as contenuCours, MATIERE.LIBELLE as matiere, CLASSROOM.LIBELLE as classroom, SALL_DE_CLASSE.NOM_SALLE as salle, INDIVIDU.NOM as nomProf, INDIVIDU.PRENOMS as prenomProf, PRESENCE_ELEVES.ETAT_PRESENCE as etatPresence
            FROM DISPENSER_COURS
                INNER JOIN CLASSROOM ON DISPENSER_COURS.IDCLASSROOM = CLASSROOM.IDCLASSROOM
                INNER JOIN MATIERE ON DISPENSER_COURS.IDMATIERE = MATIERE.IDMATIERE
                INNER JOIN SALL_DE_CLASSE ON DISPENSER_COURS.IDSALL_DE_CLASSE = SALL_DE_CLASSE.IDSALL_DE_CLASSE
                INNER JOIN INDIVIDU ON DISPENSER_COURS.IDINDIVIDU = INDIVIDU.IDINDIVIDU
                LEFT JOIN PRESENCE_ELEVES ON PRESENCE_ELEVES.IDINDIVIDU = " . $_GET['IDETUDIANT'] . "
            WHERE DISPENSER_COURS.ANNEESCOLAIRE = $anScol AND DISPENSER_COURS.IDCLASSROOM = " .$_GET['IDCLASSROOM'] ;
if(isset($_POST['idMat']) && $_POST['idMat'] != "" ) $requete .= " AND MATIERE.IDMATIERE = ".$_POST['idMat'];
if(isset($_POST['date']) && $_POST['date'] != "" ) $requete .= " AND DISPENSER_COURS.DATE = '".$_POST['date']."'";
//echo $requete;exit();
$cours = $dbh->query($requete);

/*$query = "SELECT MATIERE.IDMATIERE as idmatiere, MATIERE.LIBELLE as libmatiere
          FROM   DETAIL_TIMETABLE
              INNER JOIN EMPLOIEDUTEMPS ON DETAIL_TIMETABLE.IDEMPLOIEDUTEMPS = EMPLOIEDUTEMPS.IDEMPLOIEDUTEMPS
              INNER JOIN MATIERE ON DETAIL_TIMETABLE.IDMATIERE = MATIERE.IDMATIERE
          WHERE EMPLOIEDUTEMPS.IDCLASSROOM = ".$_GET['IDCLASSROOM']." AND EMPLOIEDUTEMPS.IDANNEE = $anScol
          GROUP BY MATIERE.LIBELLE";*/




$query = "SELECT IDMATIERE as idmatiere, LIBELLE as libmatiere
          FROM   MATIERE
          WHERE IDNIVEAU = ".$niveau;

//            echo $query;exit();
$matiere = $dbh->query($query);
include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">PARENT</a></li>
    <li class="active">Cahier Texte</li>
</ul>
<!-- END BREADCRUMB -->
<style>
    .bolder{
        font-weight: bolder;
    }
</style>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">
        <div>
            <p><h4 style="color:#E05D1F;margin-left: 15px;">L'historique des cours de l'étudiant : <b><?= $nomEtudiant; ?></b></h4></p>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <form id="form1" name="form1" method="POST" action="" class="form-inline">
                    <fieldset class="cadre">
                        <legend>Filtre</legend>
                        <div class="col-lg-12">
                            <div class="col-lg-5">
                                <div class="col-lg-2"><label class="control-label">DATE</label></div>
                                <div class="col-lg-10">
                                    <input type="date" value="<?= $_POST['date']; ?>" name="date" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="col-lg-2"><label class="control-label">MATIERE</label></div>
                                <div class="col-lg-10">
                                    <select name="idMat" id="MATIERE" class="form-control selectpicker" data-live-search="true">
                                        <option value=""> --Selectionner--</option>
                                        <?php foreach ($matiere->fetchAll(PDO::FETCH_OBJ) as $oneMatiere) { ?>
                                            <option value="<?= $oneMatiere->idmatiere; ?>"><?= $oneMatiere->libmatiere; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-offset-1 col-lg-1">
                                <button type="submit" class="btn btn-success">Rechercher</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <table id="customers2" class="table datatable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure de cours</th>
                        <th>Titre</th>
                        <th>Mati&egrave;re</th>
                        <th>Salle</th>
                        <th>Professeur</th>
                        <th>Pr&eacute;sence</th>
                        <th>Contenu</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cours->fetchAll(PDO::FETCH_OBJ) as $oneCour) { ?>
                        <tr>
                            <td><?= $lib->date_fr($oneCour->dateCours); ?></td>
                            <td><?= "De ".$oneCour->heureDeb." à ".$oneCour->heureFin; ?></td>
                            <td><?= $oneCour->titreCours; ?></td>
                            <td><?= $oneCour->matiere; ?></td>
                            <td><?= $oneCour->salle; ?></td>
                            <td><?= $oneCour->prenomProf." ".$oneCour->nomProf; ?></td>
                            <td><?= ($oneCour->etatPresence == 1)?"<span class='text-success bolder'>Present</span>":"<span class='text-danger bolder'>Absent</span>"; ?></td>
                            <td>
                               <a onclick="$('#en-tete').text('Contenu du cours de : <?= $oneCour->matiere; ?>');$('#contenu').html('<?= $oneCour->contenuCours; ?>');"
                                    data-toggle="modal" href="#voir-cont-cour" >
                                    <i class="fa fa-2x fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="modal fade" id="voir-cont-cour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #2b4f89;">
                        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">
                            <i style="color: white;" class="bold glyphicon glyphicon-remove"></i>
                        </button>
                        <h4 class="modal-title" style="color: white;">
                            <span id="en-tete"></span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <p id="contenu"></p>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>
                    </div>
                    <br/>
                    <div class="modal-footer" style="border-top-color: #2b4f89;">
                        <button class="btn btn-sm btn-default text-danger" type="button" data-dismiss="modal">
                            <b>Fermer</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
    <!-- END WIDGETS -->


</div>

    <div class="form-group row" >
        <div class="col-sm-5"></div>
        <div class="col-sm-5"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-1 btn-primary" style="width: 60px;" >
            <a href="mes_etudiant.php" style="color:#FFFFFF; font-size:14px;vertical-align: middle;line-height: 35px;"> Retour</a>
        </div>
    </div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<?php include('footer.php'); ?>