<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once("../../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(50, $lib->securite_xss($_SESSION['profil'])));

require_once('../Parametrage/classe/ProfileManager.php');
$profiles = new ProfileManager($dbh, 'profil');
$profil = $profiles->getProfiles();

$colname_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
    $colname_rq_individu = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

$colname_matricule = "";
if (isset($_POST['MATRICULE']) && $_POST['MATRICULE'] != "")
{
    $colname_matricule = " INDIVIDU.MATRICULE='" . $lib->securite_xss($_POST['MATRICULE']) . "'";
}

if ($lib->securite_xss($_POST['MATRICULE'])!='')
{
    $query_rq_etudiant = $dbh->query("SELECT INDIVIDU.IDINDIVIDU, INDIVIDU.MATRICULE, INDIVIDU.NOM, INDIVIDU.PRENOMS, INDIVIDU.TELMOBILE, INDIVIDU.IDTUTEUR, INSCRIPTION.IDINSCRIPTION as idinscription, INSCRIPTION.NBRE_EXONORE, INSCRIPTION.FK_TYPE_EXONERATION
                                                FROM INDIVIDU INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU
                                                WHERE " . $colname_matricule);

    $individu = $query_rq_etudiant->fetchObject();

    $query_an = $dbh->query("SELECT `IDANNEESSCOLAIRE`, `LIBELLE_ANNEESSOCLAIRE`, `DATE_DEBUT`, `DATE_FIN`, `ETAT`, `IDETABLISSEMENT` FROM `ANNEESSCOLAIRE` where IDANNEESSCOLAIRE=" . $colname_anne);
    $row_rq_an = $query_an->fetchObject();
    $date_debut = $row_rq_an->DATE_DEBUT;
    $date_fin = $row_rq_an->DATE_FIN;
    $libanne=$row_rq_an->LIBELLE_ANNEESSOCLAIRE;

}

?>


<?php include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">TIERS</a></li>
    <li>Exonoration</li>
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

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <form id="form" name="form1" method="post" action="exonoration.php">
                    <fieldset class="cadre">
                        <legend> Filtre</legend>

                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label>MATRICULE</label>

                                    <div>
                                        <input type="text" name="MATRICULE" id="MATRICULE" class="form-control" value="<?php if ($lib->securite_xss($_POST['MATRICULE'])!='') echo $lib->securite_xss($_POST['MATRICULE']);?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label></label>
                                    <div>
                                        <input type="submit" class="btn btn-success" value="Rechercher"/>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>

                <?php if($lib->securite_xss($_POST['MATRICULE'])!='' && $individu->MATRICULE!=''){ ?>

                <form id="form" name="form1" method="post" action="ajoutExonoration.php">
                    <fieldset class="cadre">
                        <legend> INFORMATIONS ELEVE</legend>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>MATRICULE</label>
                                    <div>
                                        <input type="text" name="MATRICULE" id="MATRICULE" class="form-control" value="<?php echo $individu->MATRICULE; ?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>PRENOMS</label>

                                    <div>
                                        <input type="text" name="PRENOMS" id="PRENOMS" class="form-control" value="<?php echo $individu->PRENOMS; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>NOM</label>

                                    <div>
                                        <input type="text" name="NOM" id="NOM" class="form-control"
                                               value="<?php echo $individu->NOM; ?>" readonly/>
                                        <input type="hidden" name="idinscription" value="<?php echo $individu->idinscription; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php



                        $query_rq_classe = $dbh->query("SELECT ROWID, LABEL FROM TYPE_EXONERATION 
                                              WHERE ETAT = 1");
                        $rs_classe = $query_rq_classe->fetchAll();


                        if($individu->IDTUTEUR>0){
                            $query_rq_nbre ="SELECT COUNT(PARENT.ideleve) as nombre 
                                                          FROM INDIVIDU 
                                                          INNER JOIN PARENT ON INDIVIDU.IDINDIVIDU=PARENT.ideleve 
                                                          INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                                          WHERE PARENT.idParent=" . $lib->securite_xss($individu->IDTUTEUR)." 
                                                          AND INSCRIPTION.ETAT=1 
                                                          AND INSCRIPTION.IDANNEESSCOLAIRE=" .$colname_anne;

                            $rq_nbre = $dbh->query($query_rq_nbre);
                            $row_rq_nbre = $rq_nbre->fetchObject();
                            $nombre = $row_rq_nbre->nombre;
                        }else $nombre = 0;



                        if($nombre){
                            ?>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>NOMBRE D'ENFANT DU TUTEUR</label>

                                    <div>
                                        <input type="text" name="NOMBRE" id="NOMBRE" class="form-control"
                                               value="<?php echo $row_rq_nbre->nombre; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php } ?>


                    </fieldset>


                    <fieldset class="cadre">
                        <legend> MOIS EXONORE POUR ANNEE SCOLAIRE : <?php echo $libanne; ?></legend>

                        <div class="row">



                            <div class="col-lg-12">

                                <div class="form-group">
                                    <div class="col-lg-2"><label>TYPE EXONERATION : </label></div>
                                    <div class="col-lg-10">
                                        <select id="classe" name="FK_TYPE_EXONERATION" class="form-control" data-live-search="true" required >
                                            <option value="" <?php if($individu->FK_TYPE_EXONERATION == 0) echo 'selected';?>> --Séléctionner un type éxonération-- </option>
                                            <?php foreach ($rs_classe as $rq_classe) { ?>
                                                <option value="<?php echo $rq_classe['ROWID'] ?>" <?php if($individu->FK_TYPE_EXONERATION == $rq_classe['ROWID']) echo 'selected';?> ><?php echo $rq_classe['LABEL'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>


<br>
<br>
<br>



                            <div class="col-xs-12">
                                <div class="form-group">


                                    <div>
                                        <?php
                                        function debug($var){
                                            return $var;
                                        }
                                        if($individu->NBRE_EXONORE>0)
                                        {
                                            $mesmoisExenorer= array();
                                            $query_mois = $dbh->query("SELECT `ROWID`, `IDINSCRIPTION`, `MOIS`, `VALIDE` FROM `MOIS_EXONORE` WHERE IDINSCRIPTION=".$individu->idinscription);
                                            $a = $query_mois->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($a as $t)
                                            {
                                                array_push($mesmoisExenorer, $t['MOIS']);
                                            }
                                        }

                                        $date1 = new DateTime($date_debut);
                                        $date2 = new DateTime($date_fin);

                                        $mois = array();
                                        $mois[] =  $date1->format('m-Y');
                                        while($date1 <= $date2){
                                            $date1->add(new DateInterval("P1M"));
                                            $mois[] = $date1->format('m-Y');

                                        }
                                        foreach (debug($mois) as $row) { ?>
                                            <div class="col-md-4" style="padding-bottom: 15px;">
                                               <input type="checkbox" name="MOIS[]" value="<?php echo $row; ?>" <?php if($individu->NBRE_EXONORE>0){if(in_array($row, $mesmoisExenorer)) echo 'checked'; }?> > <?php echo $lib->affiche_mois($row);?>
                                            </div>

                                       <?php } ?>

                                    </div>
                                </div>
                            </div>

                    </fieldset>
                        <br>

                    <div class="row">
                        <div class="col-xs-offset-6 col-xs-1">
                            <div class="form-group">

                                <div>
                                    <input type="submit" class="btn btn-success" value="Valider"/>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
        <?php } elseif($lib->securite_xss($_POST['MATRICULE'])!='' && (!$individu)) {
                    echo'<div style="color: red; font-weight: 600">Matricule non enregistré!!!</div>';
                }?>

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