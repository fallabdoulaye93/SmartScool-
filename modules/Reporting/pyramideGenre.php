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
$lib->Restreindre($lib->Est_autoriser(47, $lib->securite_xss($_SESSION['profil'])));

$etab = "-1";
if(isset($_SESSION['etab']))
{
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$annescolaire = "-1";
if(isset($_SESSION['ANNEESSCOLAIRE']))
{
    $annescolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $etab);
    $rs_niv = $query_rq_niv->fetchAll();


    $query_annescolaire=$dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT 
                                            FROM ANNEESSCOLAIRE 
                                            WHERE IDANNEESSCOLAIRE = ".$annescolaire);
    $row_query_annescolaire = $query_annescolaire->fetchObject();

    $libannesclolaire = $row_query_annescolaire->LIBELLE_ANNEESSOCLAIRE;

    $query_age=$dbh->query("SELECT DATNAISSANCE 
                                  FROM INDIVIDU 
                                  INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                  WHERE  INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                  AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire);


    $title = 'Pyramide des âges de toutes les classes, par genre';
    if(isset($_POST['form1']) && $_POST['form1'] === 'Ms_form')
    {
        $classe = $lib->securite_xss($_POST['classe']);


        $query_classe = $dbh->query("SELECT IDCLASSROOM, LIBELLE FROM CLASSROOM WHERE IDCLASSROOM = " . $classe);
        $rs_classe = $query_classe->fetchObject()->LIBELLE;

        $title = 'Pyramide des âges de la classe de :'.$rs_classe.' par genre';


        $queryM=$dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                FROM INDIVIDU 
                                INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                INNER JOIN AFFECTATION_ELEVE_CLASSE ON INSCRIPTION.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
                                WHERE INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = ".$classe." 
                                AND SEXE = 1 
                                GROUP by age");

        $queryF=$dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                FROM INDIVIDU 
                                INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                INNER JOIN AFFECTATION_ELEVE_CLASSE ON INSCRIPTION.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
                                WHERE INDIVIDU.IDETABLISSEMENT = ".$etab."  
                                AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = ".$classe." 
                                AND SEXE = 0 
                                GROUP by age");

    }
    else{

        $queryM=$dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                FROM INDIVIDU 
                                INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                WHERE INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                AND SEXE = 1 
                                GROUP by age");

        $queryF=$dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                FROM INDIVIDU 
                                INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                WHERE INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                AND SEXE = 0 
                                GROUP by age");
    }
    
    $rs_Garcon = $queryM->fetchAll();
    $rs_Fille = $queryF->fetchAll();
    $garcons = [];
    $filles = [];

    $categorie = range(0,99,5);

    array_walk($categorie, function($value)use(&$garcons, &$filles, $rs_Garcon, $rs_Fille)
    {
        $cpt_g = 0;
        $cpt_f = 0;

        foreach ($rs_Garcon as $g)
        {
            $age = $g['age'];
            if($age <= $value + 4 &&  $age >= $value )
            {
                $cpt_g += intval($g['nbr']);
            }
        }

        foreach ($rs_Fille as $f)
        {
            $age = $f['age'];
            if($age <= $value + 4 &&  $age >= $value )
            {
                $cpt_f += intval($f['nbr']);
            }
        }
        $garcons[] = $cpt_g ;
        $filles[] = $cpt_f ;
    });
}
catch (PDOException $e)
{
    echo -2;
}
?>


           <?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Reporting</a></li>                    
                    <li></li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1) { ?>

                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                        <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                        <?php } ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->

                    <div class="row">
                    
                        <div class="col-lg-6">

                            <fieldset class="cadre"><legend><?php echo $title; ?></legend>
                                <br/>


                                <form id="form" method="POST" action="pyramideGenre.php" class="form-inline">

                                        <div  class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                            <div class="col-lg-9 col-sm-8">
                                                <select name="IDNIVEAU" id="selectNiv" class="form-control selectpicker" data-live-search="true"  onchange="choixClasse(this);"  style="width: 100%;!important;">
                                                    <option value="">--Selectionner--</option>
                                                    <?php  foreach ($rs_niv as $row_rq_niv) { ?>
                                                        <option value=" <?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            <label for="nom" class="col-lg-3 col-sm-4 control-label">CLASSE </label>
                                            <div class="col-lg-9  col-sm-8">
                                                <select name="classe" id="classe" class="form-control" required  style="width: 100%;!important;"  onchange="buttonControl();" >
                                                    <option value="">--Selectionner--</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
                                            <input name="form1" value="Ms_form" type="hidden"/>
                                            <button type="submit" class="btn btn-primary " id="validerAj" title="Rechercher" style="display: none;">Rechercher</button>
                                        </div>

                                </form>

                                <br>

                                <figure class="highcharts-figure">
                                    <div id="container" style="width: 100%; height: 600px !important;"></div>
                                </figure>

                            </fieldset>
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


<!------------- hightchart-->
<script>
    function choixClasse(elem) {
        var valSel = elem.value;
        $.ajax({
            type: "POST",
            url: "getClasseNive.php",
            data: "NIVEAU=" + valSel,
            success: function (data) {
                data = JSON.parse(data);
                $("#classe").html('<option selected="selected" value="">--Selectionner--</option>');
                $.each(data, function (cle, valeur) {
                    $("#classe").append('<option value="' + valeur.IDCLASSROOM + '">' + valeur.LIBELLE + '</option>');
                });
            }
        });


    }

    function buttonControl() {
        if(document.getElementById("classe").value!=""){
            $('#validerAj').css("display","block");
        }else{
            $('#validerAj').css("display","none");
        }
    }
</script>

<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/hightcharts.js"></script>
<script src="../../js/exporting.js"></script>
<script src="../../js/export-data.js"></script>
<script src="../../js/accessibility.js"></script>

<script>

    // Data gathered from http://populationpyramid.net/germany/2015/

    // Age categories
    var categories = [
        '0-4', '5-9', '10-14', '15-19',
        '20-24', '25-29', '30-34', '35-39', '40-44',
        '45-49', '50-54', '55-59', '60-64', '65-69',
        '70-74', '75-79', '80-84', '85-89', '90-94',
        '95-99', '100 + '
    ];

    Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: '  Pyramide des âges  '
        },
        subtitle: {
            text: ''
        },
        accessibility: {
            point: {
                descriptionFormatter: function (point) {
                    var index = point.index + 1,
                        category = point.category,
                        val = Math.abs(point.y),
                        series = point.series.name;
                    return index + ', Age ' + category + ', ' + val + '%. ' + series + '.';
                }
            }
        },
        xAxis: [{
            categories: categories,
            reversed: false,
            labels: {
                step: 1
            },
            accessibility: {
                description: 'Age (Garçons)'
            }
        }, { // mirror axis on right side
            opposite: true,
            reversed: false,
            categories: categories,
            linkedTo: 0,
            labels: {
                step: 1
            },
            accessibility: {
                description: 'Age (Filles)'
            }
        }],
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                formatter: function () {
                    return Math.abs(this.value) + '%';
                }
            },
            accessibility: {
                description: 'Percentage population',
                rangeDescription: 'Range: 0 to 5%'
            }
        },

        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + ', age ' + this.point.category + '</b><br/>' +
                    'Population: ' + Highcharts.numberFormat(Math.abs(this.point.y), 1) + '%';
            }
        },

        series: [{
            name: 'Garçons',
            data: [
                <?php foreach($garcons as $nbr){?>
                <?php echo -1 * $nbr ; ?>,
                <?php }
                ?>
            ]
        }, {
            name: 'Filles',
            data: [
                <?php foreach($filles as $nbr){?>
                <?php echo $nbr ; ?>,
                <?php }
                ?>
            ]
        }]
    });

</script>



<!------ Fin hight chart -->