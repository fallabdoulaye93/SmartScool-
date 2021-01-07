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

if ($_SESSION['profil'] != 1)
    $lib->Restreindre($lib->Est_autoriser(53, $lib->securite_xss($_SESSION['profil'])));

$etab = "-1";
if (isset($_SESSION['etab'])) {
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$colname_anne = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
    $colname_anne = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}
try
{
            $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $etab);
            $rs_niv = $query_rq_niv->fetchAll();


           $row_REQ_class = $dbh->query("SELECT T.ROWID, T.LIBELLE, T.MONTANT, n.LIBELLE as LIBCYCLE, T.CYCLE, T.SEXE, T.FK_NIVEAU as NIV FROM TROUSSEAU T
                                        INNER JOIN NIVEAU n ON n.IDNIVEAU = T.FK_NIVEAU
                                        WHERE T.IDETABLISSEMENT = ".$etab." ORDER BY T.ROWID ASC");
           $rs=$row_REQ_class->fetchAll();

            if ($lib->securite_xss($_POST['IDNIVEAU'])!='')
            {
                $query_rq_uniforme = $dbh->query("SELECT ROWID, IDNIVEAU, LIBELLE, MONTANT FROM UNIFORME WHERE IDNIVEAU = " . $lib->securite_xss($_POST['IDNIVEAU']));
                $rs_uniforme = $query_rq_uniforme->fetchAll();

            }
}
catch (PDOException $e)
{
    echo -2;
}
?>

<?php include('../header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Parametrage</a></li>
    <li>Trousseau</li>
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

                    if (isset($_GET['res']) && $_GET['res'] == 1) { ?>

                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                    <?php } if (isset($_GET['res']) && $_GET['res'] != 1) { ?>

                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $lib->securite_xss($_GET['msg']); ?>
                        </div>

                    <?php } ?>

                <?php } ?>

                <form id="form1" name="form1" method="post" action="trousseau.php">
                    <fieldset class="cadre">
                        <legend> Ajouter nouveau trousseau</legend>

                        <div class="row">
                            <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                <div class="col-lg-9 col-sm-8">
                                        <select name="IDNIVEAU" id="selectNiv" class="fo
                                            rm-control selectpicker" data-live-search="true"    style="width: 100%!important;">
                                            <option value="">--Selectionner--</option>
                                            <?php foreach ($rs_niv as $row_rq_niv) { ?>
                                                <option value=" <?php echo $row_rq_niv['IDNIVEAU']; ?>" <?php echo $lib->securite_xss($_POST['IDNIVEAU']) == $row_rq_niv['IDNIVEAU'] ? "selected": " ";?>  ><?php echo $row_rq_niv['LIBELLE']; ?>  </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">

                                        <input type="submit" class="btn btn-success" value="Continuer"/>

                                    </div>
                                </div>
                        </div>

                    </fieldset>
                </form>
        <?php if ($lib->securite_xss($_POST['IDNIVEAU'])!='') { ?>
                <form id="form2" name="form2" method="post" action="ajouterTrousseau.php">
                    <fieldset class="cadre">
                        <legend> INFORMATIONS TROUSSEAU</legend>
                        <?php
                        $i=0;
                        foreach ($rs_uniforme as $rs_rq_uniforme) {?>
                            <div class="row" style="padding-bottom: 5px!important;">
                                <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <label for="nom" class="col-lg-3 col-sm-4 control-label"><?php echo $rs_rq_uniforme['LIBELLE'];?> </label>
                                    <div class="col-lg-9 col-sm-8">
                                        <input type="hidden" name="FK_uniform[]" id="FK_uniforme<?php echo $rs_rq_uniforme['ROWID']?>" class="form-control" value="<?php echo $rs_rq_uniforme['ROWID']?>" />
                                        <input type="number" name="nombre[]" id="nombre<?php echo$i; ?>" class="form-control" min="0" placeholder="Nombre"/>
                                        <input type="hidden" name="montant[]" id="montant<?php echo$i; ?>" class="form-control" value="<?php echo $rs_rq_uniforme['MONTANT']?>" />
                                    </div>

                                </div>
                            </div>
                      <?php $i=$i+1;
                        }  ?>
                        <div class="row">
                            <div  class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label for="nom" class="col-lg-3 col-sm-4 control-label">Montant </label>
                                <div class="col-lg-9 col-sm-8">
                                  <input type="text" name="montantT" id="montantT" class="form-control" placeholder="Montant" />

                                </div>
                            </div>

                        </div><br>

                        <div class="row">
                            <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="nom" class="col-lg-4 col-sm-4 control-label">Genre</label>
                                        <div class="col-lg-8 col-sm-8">
                                            <label class="form-check-label col-xs-3">
                                                <input type="radio" class="form-check-input" name="sexe" value="1"> Garçon
                                                <input type="hidden" name="nbreligne" id="nbreligne" class="form-control" value="<?php echo$i; ?>"  />
                                            </label>
                                            &nbsp;
                                            <label class="form-check-label col-xs-3">
                                                <input type="radio" class="form-check-input" name="sexe" value="0"> Fille
                                                <input type="hidden" name="FK_NIVEAU" id="FK_NIVEAU" class="form-control"  value="<?php echo$lib->securite_xss($_POST['IDNIVEAU']); ?>"/>

                                            </label>
                                        </div>
                            </div>
                        <!--</div>-->

                     <?php if ($lib->securite_xss($_POST['IDNIVEAU'])==3) { ?>
                        <!--<div class="row">-->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="nom" class="col-lg-4 col-sm-4 control-label">Niveau</label>
                                <div class="col-lg-8 col-sm-8">
                                    <label class="form-check-label col-xs-4">
                                        <input type="radio" class="form-check-input" name="niveau" value="1"> Premier Cycle
                                      </label>
                                    <label class="form-check-label col-xs-4">
                                        <input type="radio" class="form-check-input" name="niveau" value="2"> Second Cycle
                                    </label>
                                </div>
                             </div>
                         </div>
                     <?php } ?>

                        <div class="row">
                            <div class="col-xs-offset-6 col-xs-1">
                                <div class="form-group">
                                    <div>
                                        <input type="button" class="btn btn-success" value="Valider" onclick="valider()" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </form>
        <?php } ?>


                <fieldset class="cadre">
                     <legend> Liste des trousseaux</legend>
                     <table id="customers2" class="table datatable">
                    <thead>
                    <tr>
                        <th>LIBELLE</th>
                        <th>CYCLE</th>
                        <th>MONTANT</th>
                        <th>GENRE</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                        <th>Detail</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php foreach ($rs as $classe) { ?>

                        <tr>
                            <td><?php echo $classe['LIBELLE']; ?></td>
                            <td><?php if($classe['CYCLE']==1){
                                    echo "Premier Cycle";
                                } elseif ($classe['CYCLE']==2) {
                                    echo "Second Cycle";
                                }else{
                                    echo $classe['LIBCYCLE'];
                                }
                                 ?></td>
                            <td><?php echo $classe['MONTANT']; ?></td>
                            <td><?php if($classe['SEXE']==0) echo "Fille"; else echo "Garçon"; ?></td>

                            <td><a href="modifTrousseau.php?Trou=<?php echo base64_encode($classe['ROWID']); ?>&idniv=<?php echo base64_encode($classe['NIV']); ?>"><i class=" glyphicon glyphicon-edit"></i></a></td>

                            <td>
                                <a href="suppTrousseau.php?Trou=<?php echo base64_encode($classe['ROWID']); ?>"  onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette enregistrement'));"><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                            <td><a href="detailTrousseau.php?Trou=<?php echo base64_encode($classe['ROWID']); ?>&idniv=<?php echo base64_encode($classe['NIV']); ?>"><i class="glyphicon glyphicon-list"></i></td>


                        </tr>

                    <?php }  ?>

                    </tbody>
                </table>
                </fieldset>
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

<script>
    function valider() {
        var nbre = $("#nbreligne").val();
        var sexe = $('input[name=sexe]:checked').val();
        var niveau = $('input[name=niveau]:checked').val();
        var fk_niveau = $("#FK_NIVEAU").val();
       // alert(niveau);
        var i=0;
        var tot=0;
        var caltot=0;
        for(i=0; i<nbre;i++){
            var nombre=$("#nombre"+i).val();
            var mnt=$("#montant"+i).val();
           //alert(nombre);
            caltot= nombre*mnt ;
            tot=tot+caltot;
        }

        if(fk_niveau==3){
            if(tot>0 && sexe>=0 && niveau>0) {
                $("#form2").submit();
            }else{
                alert("Les champs ne doivennt  pas etre vide!")
            }
        }else{
            if(tot>0 && sexe>=0) {
                $("#form2").submit();
            }else{
                alert("Les champs ne doivennt  pas etre vide!")
            }
        }

    }
</script>