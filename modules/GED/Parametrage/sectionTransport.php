
<?php
session_start();
require_once("../../restriction.php");

require_once("../../config/Connexion.php");
require_once ("../../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(49,$lib->securite_xss($_SESSION['profil'])));


$query_REQ_transport = $dbh->query("SELECT ID_SECTION, LIBELLE, MONTANT FROM SECTION_TRANSPORT");
$rs_section = $query_REQ_transport->fetchAll();

?>


<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Param&eacute;trage</a></li>
    <li>Transports</li>
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
                    <button data-toggle="modal" data-target="#ajouter"  style="background-color:#DD682B" class='btn dropdown-toggle', aria-hidden='true' ><i class="fa fa-plus"></i> Nouvelle section</button>
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

                <table id="customers2" class="table datatable">

                    <thead>
                    <tr>

                        <th>LIBELLE</th>
                        <th>MONTANT (FCFA)</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>


                    <tbody>

                    <?php foreach($rs_section as $row_REQ_transport ){ ?>

                        <tr>
                            <td><?php echo $row_REQ_transport['LIBELLE']; ?></td>

                            <td><?php echo number_format($row_REQ_transport['MONTANT'],0,' ', ' '); ?></td>

                            <td><a href="modifTransport.php?ID_SECTION=<?php echo base64_encode($row_REQ_transport['ID_SECTION']); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>

                            <td><a href="suppTransport.php?ID_SECTION=<?php echo base64_encode($row_REQ_transport['ID_SECTION']); ?>"  onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a></td>
                        </tr>

                    <?php } ?>

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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="ajouter" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="panel-title text-center"> Nouvelle section </h3> <!--IDNIVEAU LIBELLE IDETABLISSEMENT-->
                </div>
                <form action="ajouterTransport.php" method="post">

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >LIBELLE</label>
                                    <div>
                                        <input type="text" name="LIBELLE" id="LIBELLE" required class="form-control"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>MONTANT (FCFA)</label>
                                    <div>
                                        <input type="number" name="montant" id="montant" required class="form-control" min="0" value="0"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <button type="reset" class="btn btn-danger">R&eacute;initialiser</button>
                        <button type="submit" class="btn btn-primary pull-right">Valider</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php include('footer.php'); ?>