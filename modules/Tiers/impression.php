
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
$lib->Restreindre($lib->Est_autoriser(44, $lib->securite_xss($_SESSION['profil'])));

/*require_once('../Parametrage/classe/ProfileManager.php');
$profiles=new ProfileManager($dbh,'profil');
$profil = $profiles->getProfiles();*/
$profiles = $dbh->query("SELECT idProfil, profil FROM `profil` WHERE idProfil IN (7,8,9)");
$profil = $profiles->fetchAll();


$colname_rq_classroom = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_classroom = $lib->securite_xss($_SESSION['etab']);
}

$query_rq_classroom = $dbh->query("SELECT `IDCLASSROOM`, `LIBELLE`, `IDNIVEAU`, `IDETABLISSEMENT`, `IDSERIE` FROM `CLASSROOM` WHERE IDETABLISSEMENT = ".$colname_rq_classroom);



$query_rq_niveau = $dbh->query("SELECT `IDNIVEAU`, `LIBELLE`, `IDETABLISSEMENT` FROM `NIVEAU` WHERE IDETABLISSEMENT = ".$colname_rq_classroom);


$query_rq_pays = $dbh->query("SELECT `ROWID`, `CODE`, `CODE_ISO`, `LIBELLE`, `ACTIVE` FROM `PAYS` ORDER BY LIBELLE ASC");


$query_rq_filiere = $dbh->query("SELECT `IDSERIE`, `LIBSERIE`, `IDETABLISSEMENT` FROM `SERIE` WHERE IDETABLISSEMENT = ".$colname_rq_classroom);






?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">TIERS</a></li>                    
                    <li>Impression</li>
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
						  { ?>
						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>
						 <?php }
						  if(isset($_GET['res']) && $_GET['res']!=1) 
						  { ?>
						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>
						  <?php }
						  ?>
                 
			     <?php } ?>
                 
                 <form id="form1" name="form1">
                   <fieldset class="cadre"><legend> FILTRE</legend>
                      <div class="col-md-12">
                          <div class="form-group col-lg-2">
                              <label for="exampleInputName2">Type d'individu</label>
                              <select name="TYPE_INDIVIDU" id="TYPE_INDIVIDU" class="form-control" onchange="Active_classe();">
                                  <option value="">--SELECTION TYPE INDIVIDU--</option>
                                  <?php foreach ($profil as $prof){ ?>
                                      <option value="<?php echo $prof['idProfil']; ?>"  <?php if($prof['idProfil']==$lib->securite_xss($_POST['idProfil'])) echo "selected"; ?>><?php echo $prof['profil']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>

                          <div class="form-group col-lg-2">
                              <label for="NIVEAU" id="LABNIVEAU" style="visibility:hidden;">CYCLE</label>
                              <select name="NIVEAU" id="NIVEAU" class="form-control"  style="visibility:hidden;" onchange="controlButton();">
                                  <option value="">--CYCLE--</option>
                              </select>
                          </div>
                          <div class="form-group col-lg-2">
                              <label id="LABFILIERE" style="visibility:hidden;">FILIERE</label>
                              <select name="FILIERE" id="FILIERE" style="visibility:hidden;" class="form-control">
                                  <option value="">--FILIERE--</option>
                              </select>
                          </div>
                          <div class="form-group col-lg-2">
                              <label id="LABCLASS" style="visibility:hidden;">CLASSE</label>
                              <select name="CLASSROOM" id="CLASSROOM" style="visibility:hidden;" class="form-control">
                                  <option value="">--CLASSES--</option>
                              </select>
                          </div>
                          <div class="form-group col-lg-1" style="margin-top: 21px;">
                              <button type="submit" class="btn btn-primary">Rechercher</button>
                          </div>
                      </div>
                   </fieldset>
                </form>


    
              
                    </div></div></div>
                    <!-- END WIDGETS -->
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-10"></div>
                        <div class="col-md-1">
                            <a id="pdfExport"><i class="fa fa-file-pdf-o fa-3x" aria-hidden="true" style="color: red;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT PDF"></i></a>
                        </div>
                        <div class="col-md-1">
                                <?php  if($_POST['TYPE_INDIVIDU']!='') {
                                   $type=$lib->securite_xss($_POST['TYPE_INDIVIDU']);
                                } ?>
                            <a id="ExcelExport"><i class="fa fa-file-excel-o fa-3x" aria-hidden="true" style="color: green;" data-toggle="tooltip" data-placement="bottom" title="EXPORT EN FORMAT EXCEL"></i></a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" id="divAutres">
                    <table id="autres" class="table">
                        <thead>
                            <tr>
                                <th>MATRICULE</th>
                                <th>PRENOM</th>
                                <th>NOM</th>
                                <th>EMAIL</th>
                                <th>TEL</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="panel-body" id="divEleve" style="display: none;">
                    <table id="eleves" class="table">
                        <thead>
                            <tr>
                                <th>MATRICULE</th>
                                <th>PRENOM</th>
                                <th>NOM</th>
                                <th>CYCLE</th>
                                <th>FILIERE</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            </div>            
            <!-- END PAGE CONTENT -->
        </div>

        <!-- END PAGE CONTAINER -->

 
        <?php include('footer.php'); ?>

<script type="text/javascript" src="../../js/jquery.form.min.js"></script>
<script>
    $( document ).ready(function() {
        $.ajax({
            method: "POST",
            url: "requestNiveau.php"

        }).done(function (data) {
            var data = $.parseJSON(data)
            $('#NIVEAU').children('option:not(:first)').remove()
            for (i = 0, len = data.length; i < len; i++){
                $('#NIVEAU').append(new Option(data[i].LIBELLE, data[i].IDNIVEAU))
            }
        })
        $('#autres').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
            }
        })
        $('#eleves').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
            }
        })
    })
    var options = {
        url:       "requestForImpression.php",
        type:      "post",
        dataType:  "json",
        success: generateTable
    }
    $('#form1').submit(function() {
        // get all the inputs into an array except the last input.
        var $inputs = $('#form1 :input:not(:last)');

        // not sure if you wanted this, but I thought I'd add it.
        // get an associative array of just the values.
        var values = {};
        $inputs.each(function() {
            values[this.name] = $(this).val();
        });
        var keys = Object.keys(values);
        var first = keys[0];
        var href="../../ged/imprimer_individu.php?"
        var href1="../../ged/imprimer_individuExcel.php?"
        $.each(values, function (key, value) {
            if(key == first){
                if (value != "") {
                    href+=key+'='+btoa(value);
                    href1+=key+'='+btoa(value)
                } else {
                    href+=key+'=';
                    href1+=key+'='
                }
            }else {
                if (value != "") {
                    href+='&'+key+'='+btoa(value);
                    href1+='&'+key+'='+btoa(value)
                } else {
                    href+='&'+key+'=';
                    href1+='&'+key+'='
                }
            }
        })
        $('#pdfExport').attr("href",href);
        $('#ExcelExport').attr("href",href1);

        $(this).ajaxSubmit(options);
        return false;
    })
    function generateTable(res) {
        var selected = $("#TYPE_INDIVIDU").find("option:selected").val()

        if(selected != 8){
            var result = res.map(({ MATRICULE, PRENOMS, NOM, COURRIEL, TELMOBILE }) => [MATRICULE, PRENOMS, NOM, COURRIEL, TELMOBILE])
            var t = $('#autres').DataTable();
            t.destroy()
            $('#autres').empty()
            $('#autres').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
                },
                data: result,
                columns: [
                    { title: "MATRICULE" },
                    { title: "PRENOM" },
                    { title: "NOM" },
                    { title: "EMAIL" },
                    { title: "TEL" }
                ]
            })
            //t.row().destroy();
        }else {
            var result = res.map(({ MATRICULE, PRENOMS, NOM, LIBELLE, LIBSERIE }) => [MATRICULE, PRENOMS, NOM, LIBELLE, LIBSERIE])
            var t = $('#eleves').DataTable();
            //t.row().destroy();
            t.destroy();
            $('#eleves').empty()
            $('#eleves').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
                },
                data: result,
                columns: [
                    { title: "MATRICULE" },
                    { title: "PRENOM" },
                    { title: "NOM" },
                    { title: "CYCLE" },
                    { title: "FILIERE" }
                ]
            })
        }


        //console.log(result)
        /*for (var individu in res){
            t.row.add([
                res[individu][1],
                res[individu][3],
                res[individu][2],
                res[individu][5],
                res[individu][4],
            ])
        }
        t.row().draw()*/
    }
    $("#TYPE_INDIVIDU").on('change', function () {
        var selected = $("#TYPE_INDIVIDU").find("option:selected").val()
        if(selected != 8){
            $('#NIVEAU option[value=""]').attr("selected",true);
            $('#NIVEAU').children('option:not(:first)').remove()
            $('#FILIERE option[value=""]').attr("selected",true);
            $('#FILIERE').children('option:not(:first)').remove()
            $('#CLASSROOM option[value=""]').attr("selected",true);
            $('#CLASSROOM').children('option:not(:first)').remove()
            $.ajax({
                method: "POST",
                url: "requestNiveau.php"

            }).done(function (data) {
                var data = $.parseJSON(data)
                for (i = 0, len = data.length; i < len; i++){
                    $('#NIVEAU').append(new Option(data[i].LIBELLE, data[i].IDNIVEAU))
                }
            })
            $('#divAutres').css('display','block')
            $('#divEleve').css('display','none')
        }else {
            $('#divEleve').css('display','block')
            $('#divAutres').css('display','none')
        }
    })

    function controlButton() {
        var selectedNiv = $("#NIVEAU").find("option:selected").val()
        if(selectedNiv != "") {
            $.ajax({
                method: "POST",
                url: "requestCycle.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }

            }).done(function (data) {
                var data = $.parseJSON(data)
                $('#FILIERE').children('option:not(:first)').remove()
                for (i = 0, len = data.length; i < len; i++){
                    $('#FILIERE').append(new Option(data[i].LIBSERIE, data[i].IDSERIE))
                }
            })
            $.ajax({
                method: "POST",
                url: "requestClasse.php",
                data: {
                    IDNIVEAU: btoa(selectedNiv)
                }
            }).done(function (data) {
                var data = $.parseJSON(data)
                $('#CLASSROOM').children('option:not(:first)').remove()
                for (i = 0, len = data.length; i < len; i++){
                    $('#CLASSROOM').append(new Option(data[i].LIBELLE, data[i].IDCLASSROOM))
                }
            })
        }
    }
</script>
