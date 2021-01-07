 <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="../../logout.php" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="../../audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="../../audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                  
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="../../js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../../js/plugins/bootstrap/bootstrap.min.js"></script>  
        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script> 
<script>
$(function () {

    // Make monochrome colors and set them as default for all pies
    Highcharts.getOptions().plotOptions.pie.colors = (function () {
        var colors = [],
            base = Highcharts.getOptions().colors[5],
            i;

        for (i = 0; i < 10; i += 1) {
            // Start out with a darkened base color (negative brighten), and end
            // up with a much brighter color
            colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
        }
        return colors;
    }());

    // Build the chart
   <?php /*?> $('#container2').highcharts({
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
               ?>
               <?php echo "{ name: '".$tab[$i]['Nationalite']."' , y: ".$tab[$i]['nbreEeleves']." }";
 
               } else  {
              echo "{ name: '".$tab[$i]['Nationalite']."' , y: ".$tab[$i]['nbreEeleves']."  },";
              } 
             }?>
            ]
        }]
    });<?php */?>
});
</script>

         <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>       
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='../../js/plugins/icheck/icheck.min.js'></script>        
        <script type="text/javascript" src="../../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="../../js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        
        <script type="text/javascript" src="../../js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="../../js/plugins/morris/morris.min.js"></script>       
        <script type="text/javascript" src="../../js/plugins/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="../../js/plugins/rickshaw/rickshaw.min.js"></script>
        <script type='text/javascript' src='../../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
        <script type='text/javascript' src='../../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>                
        <script type='text/javascript' src='../../js/plugins/bootstrap/bootstrap-datepicker.js'></script>                
        <script type="text/javascript" src="../../js/plugins/owl/owl.carousel.min.js"></script>                 
        
        <script type="text/javascript" src="../../js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="../../js/plugins/daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="../../js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
		$(document).ready(function() {
            $('#customers2').DataTable( {
               "language": {
                   //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
				   "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
             }
           } );
        } );
		</script>
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="../../js/settings.js"></script>
        
        <script type="text/javascript" src="../../js/plugins.js"></script>        
        <script type="text/javascript" src="../../js/actions.js"></script>
        
        <script type="text/javascript" src="../../js/demo_dashboard.js"></script>

        <script type="text/javascript" src="../../datetimepicker/build/jquery.datetimepicker.full.js"></script>
        <!-- validation formulaire -->
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.js"></script>
        <script type="text/javascript" src="../../js/plugins/jquery-validation/localization/messages_fr.js"></script>
        <script type="text/javascript">
            $("form").validate();
       </script>
      <!--fin validation formulaire -->


 <script type="text/javascript">
     $('#date_foo').datetimepicker({
         formatTime:'H:i',
         formatDate:'d.m.Y',
         //defaultDate:'8.12.1986', // it's my birthday
         defaultDate:'+01.01.1970', // it's my birthday
         defaultTime:'08:00',
         timepickerScrollbar:false
     });
     $('#date_foo2').datetimepicker({
         formatTime:'H:i',
         formatDate:'d.m.Y',
         //defaultDate:'8.12.1986', // it's my birthday
         defaultDate:'+01.01.1970', // it's my birthday
         defaultTime:'08:00',
         timepickerScrollbar:false
     });
	 
	 $('#date_foo3').datepicker({
		  format: "yyyy-mm-dd"
		 });

 </script>


        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->

    </body>
</html>


