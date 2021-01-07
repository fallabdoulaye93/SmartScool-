<?php
include('header.php');

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

$query = "SELECT CONTROLE.IDCONTROLE as idcont,CONTROLE.LIBELLE_CONTROLE as libcont,CONTROLE.DATEDEBUT as datecont, CONTROLE.DATEFIN as datefincont, CONTROLE.HEUREDEBUT as debut,CONTROLE.HEUREFIN as fin,CONTROLE.IDCLASSROOM as idclass,CLASSROOM.LIBELLE as libclass,MATIERE.LIBELLE as libmatiere
          FROM CONTROLE
          INNER JOIN CLASSROOM ON CONTROLE.IDCLASSROOM = CLASSROOM.IDCLASSROOM
          INNER JOIN MATIERE ON CONTROLE.IDMATIERE = MATIERE.IDMATIERE
          WHERE CONTROLE.IDINDIVIDU = ".$_SESSION['id']."
          ORDER BY CONTROLE.DATEDEBUT ASC";
$stmt = $dbh->prepare($query);
$stmt->execute();
$tabCont = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
    <style>
        .panel-body{background-color: #FFFFFF}
    </style>
<ul class="breadcrumb">
    <li><a href="#"> PROFESSEUR </a></li>
    <li class="active"> Mes contrôles</li>
</ul>
<div class="row">
    <div class="panel-body">
        <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){
		    if(isset($_GET['res']) && $_GET['res']==1)  {?>
			    <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?= $_GET['msg']; ?>
			    </div>
		    <?php  }
		    if(isset($_GET['res']) && $_GET['res']!=1)  {?>
			    <div class="alert alert-danger">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?= $_GET['msg']; ?>
			    </div>
		    <?php } ?>
	    <?php } ?>
	    <table id="customers2" class="table datatable table-striped">
            <thead>
            <tr>
                <th width="16">Controle</th>
                <th width="14">Date</th>
                <th width="14">Heure debut</th>
                <th width="14">Heure fin</th>
                <th width="14">Classe</th>
                <th width="14">Matiere</th>
                <th width="14" style="text-align: center;">NOTER</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabCont as $oneCont){ ?>
                <tr>
                    <td><?= $oneCont->libcont; ?></td>
                    <td><?= substr($lib->date_time_fr($oneCont->datecont), 0, -8); ?></td>
                    <!--<td><?/*= $oneCont->debut; */?></td>-->
                    <td><?= date('H:i:s', strtotime($oneCont->datecont)); ?></td>
                    <?php
                        $tm = $oneCont->datefincont;
                        $tps=strtotime($tm);
                    ?>
                    <td><?= date('H:i:s',strtotime($tm)); ?></td>
                    <td><?= $oneCont->libclass; ?></td>
                    <td><?= $oneCont->libmatiere; ?></td>
                    <td style="text-align: center;">
                        <a href="saisirNotes.php?IDCLASSROOM=<?= $oneCont->idclass; ?>&IDCONTROLE=<?= $oneCont->idcont; ?>&libclass=<?= str_replace(" ","-",$oneCont->libclass); ?>">
                            <i class=" glyphicon glyphicon-list"></i>
                        </a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
                    
</div>
</div>
</div>

<?php include('footer.php'); ?>