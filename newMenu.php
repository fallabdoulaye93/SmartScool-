<?php //require_once("restriction.php");
?>
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
    <head>        
       <title>SunuEcole - Gestion Administrative des Etablissements Scolaires</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="assets/images/users/user-ecole.jpg" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
    <!-- EOF CSS INCLUDE -->
    
     <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />            
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.php">SunuEcole</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="menu.php" class="profile-mini">
                            <img src="assets/images/users/user-ecole.jpg" alt="sunuEcole"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <a href="menu.php"><img src="assets/images/users/user-ecole.jpg" alt="sunuEcole"/></a>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">
								<?php //echo $_SESSION['prenom']."   ".$_SESSION['nom']; ?></div>
                                <?php 
								/*require_once("../../config/Connexion.php");
                                require_once ("../../config/Librairie.php");
                                $connection =  new Connexion();
                                $dbh = $connection->Connection();
								$query= "SELECT profil from profil where idProfil= ".$_SESSION['profil'];
			                    $stmt = $dbh->prepare($query);  
			                    $stmt->execute();
			                    $rs_user = $stmt->fetchObject();*/
								?>
                                <div class="profile-data-title"><?php //echo $rs_user->profil; ?></div>
                            </div>
                            <div class="profile-controls">
                                
                            </div>
                        </div>                                                                        
                    </li>
                  
                 
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                     <li class="btn-group-lg"><br>
                      <div class="plugin-date" id="plugin-date" style="font-size:18px; color:#fff;">Loading...</div>   
                    </li>
                    <li class="btn-group-lg"><br>
                    <div  > &nbsp;&nbsp;</div>
                    </li>
                    <li class="btn-group-lg"><br>
                    <div class="plugin-clock" style="font-size:18px; color:#fff;"> 00:00</div>
                    </li>  
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                     <li class="xn-icon-button pull-right"><br>
                        
                         
                        <span style="font-size:14px; color:#fff;">Bienvenue <?php //echo  $_SESSION['prenom']." ".$_SESSION['nom']; ?> </span>
                    </li>
                   
                </ul>
                                  
                 
                    
                    
                    
                    <div class="login-container2">

    <div class="login-box2 animated fadeInDown">
        <div class="login-logo2"></div>
        <br/>
     
        <div class="login-body2">

            <div class="content-wrapper" id="menu">
         <div class="container" style="padding-left:25px;padding-right:25px;">
       
             <div class="row col-md-10 col-md-offset-1">
            <?php if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],8)==1) {  ;?>
                  <div class="col-md-3  bg_menu">
                     <a href="modules/Parametrage/accueil.php"><div class="hint--bottom" data-hint="DASHBOARD" >
                     <center>
                      <img src="assets/img/icone/ic_scolarite.png"  alt="" class="icones"/> 
                      <span class="texte">PARAMETRES / PROFILS</span>
                     </center></div>
                    </a>
                    </div> 
              <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],1)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu">
                 <a href="modules/Tiers/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png"  alt="" class="icones"/> 
                  <span class="texte"> TIERS </span>
                 </center></div>
                </a>
                </div>
                <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],2)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu" >
                  <a href="modules/Tresorerie/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png" class="icones"  alt=""/> 
                  <span class="texte">TRESORERIE</span>
                 </center></div>
              </a>
                </div>  
                
          <?php }  ?>
                <br>
  
             </div>  
              
            </div>        
               <br><br>
    
       <div class="container" style="padding-left:25px;padding-right:25px;">
       
             <div class="row col-md-10 col-md-offset-1">
              <?php if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],3)==1) {  ;?>
              <div class="col-md-3  bg_menu">
                 <a href="modules/EmploiDuTemps/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png"  alt="" class="icones"/> 
                  <span class="texte">EMPLOI DU TEMPS</span>
                 </center></div>
                </a>
                </div> 
                <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],4)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu">
                 <a href="modules/Evaluations/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png"  alt="" class="icones"/> 
                  <span class="texte">EVALUATIONS</span>
                 </center></div>
                </a>
                </div> 
                <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],5)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu" >
                  <a href="modules/GED/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png" class="icones"  alt=""/> 
                  <span class="texte">GED</span>
                 </center></div>
              </a>
                </div> 
                 <?php }  ?>
                <br>
             </div>  
            </div>    
            <br><br>
        
         
    
       <div class="container" style="padding-left:25px;padding-right:25px;">
       
             <div class="row col-md-10 col-md-offset-1">
              <?php if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],6)==1) {  ;?>
              <div class="col-md-3  bg_menu">
                 <a href="modules/Equipements/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png"  alt="" class="icones"/> 
                  <span class="texte">EQUIPEMENTS</span>
                 </center></div>
                </a>
                </div> 
               <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],7)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu">
                 <a href="modules/Sanctions/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png"  alt="" class="icones"/> 
                  <span class="texte">SANCTIONS</span>
                 </center></div>
                </a>
                </div> 
               <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],9)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu" >
                  <a href="modules/Reporting/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_scolarite.png" class="icones"  alt=""/> 
                  <span class="texte">TABLEAU DE BORD</span>
                 </center></div>
              </a>
                </div> 
                 <?php }  ?>
                <br>
             </div>  
            </div>       
            </div> 
            
        </div>
        
        <div class="footer-section">
            <div class="col-lg-offset-0">
                <a href="https://www.samaecole.com">&copy; 2016 SAMAECOLE</a>
            </div>
        </div>
        
    </div>

</div>
                    
                    
                    
                    
                        
                        
                        
                        
                   
                    <!-- END WIDGETS -->                    
                    
                   
                    
              
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

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
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                  
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>        
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        
        <script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>       
        <script type="text/javascript" src="js/plugins/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="js/plugins/rickshaw/rickshaw.min.js"></script>
        <script type='text/javascript' src='js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
        <script type='text/javascript' src='js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>                
        <script type='text/javascript' src='js/plugins/bootstrap/bootstrap-datepicker.js'></script>                
        <script type="text/javascript" src="js/plugins/owl/owl.carousel.min.js"></script>                 
        
        <script type="text/javascript" src="js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="js/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/settings.js"></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>
        
        <script type="text/javascript" src="js/demo_dashboard.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>






