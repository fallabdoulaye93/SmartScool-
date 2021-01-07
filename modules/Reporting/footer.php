<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Se <strong>déconnecter</strong> ?</div>
            <div class="mb-content">
                <p>Etes vous sur de vouloir vous déconnecter ?</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="../../logout.php" class="btn btn-success btn-lg">Oui</a>
                    <button class="btn btn-default btn-lg mb-control-close">Non</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->

<!-- START PRELOADS -->
<audio id="audio-alert" src="../../audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="../../audio/fail.mp3" preload="auto"></audio>

<script type="text/javascript" src="../../js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../../js/plugins/jquery/jquery-ui.min.js"></script>
<!--<script src="../../js/jquery-3.1.1.min.js"></script>-->

<!-- START PLUGINS -->
<script type='text/javascript' src='../../js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="../../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="../../js/plugins/scrolltotop/scrolltopcontrol.js"></script>


<script type="text/javascript" src="../../js/plugins/bootstrap/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<!-- END PLUGINS -->
<script type="text/javascript" src="../../js/settings.js"></script>

<script type="text/javascript" src="../../js/plugins.js"></script>
<script type="text/javascript" src="../../js/actions.js"></script>
<script type="text/javascript" src="../../datetimepicker/build/jquery.datetimepicker.full.js"></script>



<script type="text/javascript">
    $('#date_foo').datetimepicker({
        formatTime: 'H:i',
        formatDate: 'd.m.Y',
        //defaultDate:'8.12.1986', // it's my birthday
        defaultDate: '+01.01.1970', // it's my birthday
        defaultTime: '08:00',
        timepickerScrollbar: false
    });
    $('#date_foo2').datetimepicker({
        formatTime: 'H:i',
        formatDate: 'd.m.Y',
        //defaultDate:'8.12.1986', // it's my birthday
        defaultDate: '+01.01.1970', // it's my birthday
        defaultTime: '08:00',
        timepickerScrollbar: false
    });

    function mySelectAction(select){
        var child2 = select.children[2];
        child2.className = (child2.className == "btn-group bootstrap-select form-control open") ? "btn-group bootstrap-select form-control": "btn-group bootstrap-select form-control open";
    }
    function mySelectValueChange(){
        var idAnnee = $("#annee_scolaire").val();
        $.ajax({
            type: "POST",
            url: "../changeAnneeScolaire.php",
            data: "idannee=" + idAnnee,
            success: function (data) {
                if (data == 1) {
                    window.location.reload();
                } else {
                    alert("ERREUR ! Changement de l'année scolaire non effectué.")
                }
            }
        });
    }

    (function anonyme(){
            var menu_open = $("li.active")[0].children[1].children;
            var link_open = window.location.pathname;
            for (var i = 0 ; i < menu_open.length ; i++){
                if(link_open == menu_open[i].children[0].pathname){
                    menu_open[i].children[0].style = "color: rgb(237, 95, 0);padding-left: 35px;";
                    break;
                }
            }
        }
    )()
</script>

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

    function buttonControl()
    {
        if(document.getElementById("classe").value!=""){
            $('#validerAj').css("display","block");
        }else{
            $('#validerAj').css("display","none");
        }
    }
</script>


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

<script>
    $(function () {
        $('#container2').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },

            title: {
                text: "NOMBRE D'ELEVES INSCRITS PAR NATIONALITE"
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                data: [
                    <?php $taille=sizeof($tab); ?>
                    <?php for($i=0;$i<$taille;$i++){
                    if($i==$taille-1) {
                        echo "{ name: '".$tab[$i]['Nationalite']."' , y: ".$tab[$i]['nbreEeleves']." }";
                    } else  {
                        echo "{ name: '".str_replace('\'',' ',$tab[$i]['Nationalite'])."' , y: ".$tab[$i]['nbreEeleves']."  }";
                        if($i!=$taille-1) {
                            echo ",";
                        }
                    }
                }?>
                ]
            }]
        });
    });
</script>

</body>
</html>


