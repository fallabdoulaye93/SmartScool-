<?php
include('header.php');

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

$query = "SELECT cl.IDCLASSROOM as idclass, cl.LIBELLE as libclass, s.LIBSERIE as libserie 
          FROM CLASSROOM cl
          INNER JOIN CLASSE_ENSEIGNE ce ON cl.IDCLASSROOM = ce.IDCLASSROM
          
          INNER JOIN RECRUTE_PROF rf ON rf.IDRECRUTE_PROF = ce.IDRECRUTE_PROF
          
          INNER JOIN INDIVIDU i ON rf.IDINDIVIDU = i.IDINDIVIDU
          
          INNER JOIN SERIE s ON cl.IDSERIE = s.IDSERIE
          
          WHERE i.IDINDIVIDU = ".$_SESSION['id'] ;
$stmt = $dbh->prepare($query);
$stmt->execute();
$tabDest = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
    <style>
        .panel-body {
            background:#FFFFFF;}
    </style>
<ul class="breadcrumb">
    <li><a href="#"> PROFESSEUR </a></li>
    <li class="active"> Mes classes</li>
</ul>
<div class="row">
    <div class="panel-body panel-default">
        <?php if(isset($_GET['msg']) && $_GET['msg']!= '') {
		    if(isset($_GET['res']) && $_GET['res']==1) { ?>
			    <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?php echo $_GET['msg']; ?>
			    </div>
		    <?php  }
		    if(isset($_GET['res']) && $_GET['res']!=1) { ?>
			    <div class="alert alert-danger">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				    <?php echo $_GET['msg']; ?>
			    </div>
		    <?php } ?>
	    <?php } ?>
	    <table id="customers2" class="table datatable table-striped">

            <thead>
            <tr>
                <th width="50%">LIBELLE</th>
                <th width="50%">SERIE</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabDest as $oneClass){ ?>
                <tr>
                    <td><?php echo $oneClass->libclass; ?></td>
                    <td><?php echo $oneClass->libserie; ?></td>
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