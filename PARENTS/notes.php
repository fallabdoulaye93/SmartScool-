<?php
include('header.php');

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");

$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if (!isset($_GET['IDPERIODE']) || !isset($_GET['NOM']) || !isset($_GET['IDETUDIANT'])){
    header("location:mes_etudiant.php");
}
$idPeriode= $lib->securite_xss($_GET['IDPERIODE']);
$nomEtudiant = str_replace("-"," ",$lib->securite_xss($_GET['NOM']));
$idEtudiant = $lib->securite_xss($_GET['IDETUDIANT']);
$annee = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);

$query_note_etudiant = $dbh->query("SELECT NOTE.NOTE, MATIERE.LIBELLE, CONTROLE.LIBELLE_CONTROLE as LIBCONT, CONTROLE.DATEDEBUT as DATECONT
                                              FROM NOTE
                                              INNER JOIN CONTROLE ON NOTE.IDCONTROLE = CONTROLE.IDCONTROLE
                                              INNER JOIN MATIERE ON CONTROLE.IDMATIERE = MATIERE.IDMATIERE
                                              WHERE CONTROLE.IDANNEE = ".$annee." 
                                              AND CONTROLE.VALIDER = 1 
                                              AND CONTROLE.IDPERIODE = ".$idPeriode." 
                                              AND NOTE.IDINDIVIDU = ".$idEtudiant);
?>
                <!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#"> PARENT </a></li>
    <li class="active"> Notes</li>
</ul>

<div class="row">
    <div class="panel panel-default">
    <div>
        <p><h4 style="color:#E05D1F;margin-left: 15px;">Les Notes du <?= ($idPeriode == 1)?" premier ":" second "; ?> semestre de : <b><?= $nomEtudiant; ?></b></h4></p>
    </div>
    <div class="panel-heading">
        &nbsp;&nbsp;&nbsp;
    </div>
    <div class="panel-body">
        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
		    if(isset($_GET['res']) && $_GET['res']==1) {?>
			    <div class="alert alert-success">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?= $lib->securite_xss($_GET['msg']); ?>
			    </div>
		    <?php  } if(isset($_GET['res']) && $_GET['res']!=1) {?>
			    <div class="alert alert-danger">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?= $lib->securite_xss($_GET['msg']); ?>
			    </div>
		    <?php }
	    } ?>
        <div class="row">
            <table id="customers2" class="table datatable">
                <thead>
                    <tr>
                        <th>CONTROLE</th>
                        <th>DATE</th>
                        <th>MATIERE</th>
                        <th>NOTE / 20</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($query_note_etudiant->fetchAll() as $controle){ ?>
                        <tr>
                            <td ><?= $controle['LIBCONT']; ?></td>
                            <td ><?= $lib->date_fr($controle['DATECONT']); ?></td>
                            <td ><?= $controle['LIBELLE']; ?></td>
                            <td style="font-size: 16px;"><?= ($controle['NOTE']>=10) ? "<b><i class='text-success'>".$controle['NOTE']."</i></b>" : "<b><i class='text-danger'>0".$controle['NOTE']."</i></b>"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="form-group row" >
        <div class="col-sm-5"></div>
        <div class="col-sm-5"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-1 btn-primary" style="width: 60px;" >
            <a href="mes_etudiant.php" style="color:#FFFFFF; font-size:14px;vertical-align: middle;line-height: 35px;"> Retour</a>
        </div>
    </div>
</div>

</div>
</div>
</div>

<?php include('footer.php'); ?>