
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
$lib->Restreindre($lib->Est_autoriser(21,$_SESSION['profil']));


$colname_rq_periode = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_periode = $_SESSION['etab'];
}

$colname_rq_clas = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_clas = $_SESSION['etab'];
}
$anne = $lib->securite_xss($_SESSION["ANNEESSCOLAIRE"]);

$colname_serach="";
if(isset($_POST['IDNIVEAU'])&& $lib->securite_xss($_POST['IDNIVEAU'])!="")
{
    $colname_serach.=" AND c.IDNIVEAU='".$lib->securite_xss($_POST['IDNIVEAU'])."'";
}

if(isset($_POST['classe'])&& $lib->securite_xss($_POST['classe'])!="")
{
    $colname_serach.=" AND b.IDCLASSROOM='".$lib->securite_xss($_POST['classe'])."'";
}

if(isset($_POST['periode'])&& $lib->securite_xss($_POST['periode'])!="")
{
    $colname_serach.=" AND b.IDPERIODE='".$lib->securite_xss($_POST['periode'])."'";
}



$query_bulletin = $dbh->query("SELECT DISTINCT b.IDPERIODE, b.IDCLASSROOM, p.NOM_PERIODE, c.LIBELLE AS CLASSE, n.LIBELLE AS CYCLE, c.IDNIVEAU
                                         FROM BULLETIN b 
                                         INNER JOIN PERIODE p ON p.IDPERIODE = b.IDPERIODE 
                                         INNER JOIN CLASSROOM c ON b.IDCLASSROOM = c.IDCLASSROOM
                                         INNER JOIN NIVEAU n ON c.IDNIVEAU = n.IDNIVEAU
                                         WHERE b.IDETABLISSEMENT = ".$colname_rq_clas." 
                                         AND b.IDANNEE = ".$anne." ".$colname_serach);

$rs_bulletin = $query_bulletin->fetchAll(PDO::FETCH_ASSOC);

$query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU");
$rs_niv = $query_rq_niv->fetchAll();
?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Evaluations</a></li>                    
                    <li>Bulletin de notes</li>
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
				 
                      if(isset($_GET['res']) && $_GET['res']==1) { ?>

                              <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                             <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                              <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                              <?php } ?>

                     <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form" name="form1" method="POST" action="" class="form-inline">
                                <fieldset class="cadre"><legend> FILTRE</legend>
                                    <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                        <div class="col-lg-9 col-sm-8">
                                            <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" data-live-search="true"  onchange="controlButton();"  style="width: 100%;!important;">
                                                <option value="">--Selectionner--</option>
                                                <?php  foreach ($rs_niv as $row_rq_niv) { ?>

                                                    <option value=" <?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>

                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">CLASSE </label>
                                        <div class="col-lg-9  col-sm-8">
                                            <select name="classe" id="classe" class="form-control selectpicker" required  style="width: 100%;!important;"  onchange="" >
                                                <option value="">--Selectionner--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">PERIODE</label>
                                        <div class="col-lg-9  col-sm-8">
                                            <select name="periode" id="periode" class="form-control selectpicker" required  style="width: 100%;!important;"  onchange="" >
                                                <option value="">--Selectionner--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-1">
                                        <button type="submit" class="btn btn-primary " id="validerAj" title="Rechercher">Rechercher</button>
                                    </div>


                                </fieldset>
                            </form>
                        </div>
                    </div>


                     <table id="customers2" class="table datatable">
                            <thead>
                                <tr>
                                      <th>PERIODE</th>
                                      <th >CLASSE</th>
                                      <th>CYCLE</th>
                                      <th>IMPRIMER</th>
                                </tr>
                            </thead>

                           <tbody>

                               <?php foreach($rs_bulletin as $row_rq_clas) { ?>

                                <tr>
                                        <td><?php echo $row_rq_clas['NOM_PERIODE']; ?></td>
                                        <td><?php echo $row_rq_clas['CLASSE']; ?></td>
                                        <td><?php echo $row_rq_clas['CYCLE']; ?></td>

                                        <td>
                                            <a target="_blank" href="../../ged/imprimer_bulletin.php?idclassroom=<?php echo base64_encode($row_rq_clas['IDCLASSROOM']);?>&idperiode=<?php echo base64_encode($row_rq_clas['IDPERIODE']); ?>&idniveau=<?php echo base64_encode($row_rq_clas['IDNIVEAU']); ?>">
                                                <i class="glyphicon glyphicon-print"></i>
                                            </a>
                                        </td>
                                </tr>

                                <?php } ?>
           
                            </tbody>

                     </table>
    
              
                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->


<?php include('footer.php'); ?>

<script>
    $( document ).ready(function() {

    })
    function controlButton() {
        var selectedNiv = $("#selectNiv").find("option:selected").val()
        if(selectedNiv != "") {
            $.ajax({
                method: "POST",
                url: "requestCycle.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }

            }).done(function (data) {
                var data = $.parseJSON(data)
                var classes = data.classes
                var periodes = data.periodes
                $('#classe').children('option:not(:first)').remove()
                for (i = 0, len = classes.length; i < len; i++){
                    $('#classe').append(new Option(classes[i].LIBELLE, classes[i].IDCLASSROOM))
                    $('#classe').selectpicker('refresh')
                }
                $('#periode').children('option:not(:first)').remove()
                for (i = 0, len = periodes.length; i < len; i++){
                    $('#periode').append(new Option(periodes[i].NOM_PERIODE, periodes[i].IDPERIODE))
                    $('#periode').selectpicker('refresh')
                }
            })
        }else if (selectedNiv == "") {
            $('#classe').children('option:not(:first)').remove()
            $('#classe').selectpicker('refresh')
            $('#periode').children('option:not(:first)').remove()
            $('#periode').selectpicker('refresh')
        }
    }
</script>
