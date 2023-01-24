<?php 

if (!isset($_SESSION)){
    session_start();
}
require_once("restriction_menu.php");

require_once("config/Connexion.php");
require_once ("config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>sunuEcole </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
    <style>
	body {
      background: url(img/backgrounds/gardesunuecole.jpg) no-repeat;
    }
	
	</style>

</head>
<body background="img/backgrounds/gardesunuecole.jpg">
    
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                
                <button type="button" style="z-index:9999999" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="menu.php">
                    <div class="hidden-xs"><img src="assets/images/users/user-ecole.jpg" width="41%"/></div>
                    <div class="visible-xs"><img src="assets/images/users/user-ecole.jpg" width="41%" /></div>
                </a>
               </div>
                  
                <div class="col-md-8 col-sm-12 col-md-offset-1">
                 <br>
 
                 </div> 
                  
             
                  
                  
               <div class="col-md-1 col-sm-12"> <br><br>
               
               <div class="right-div" style="padding-right:10px;">
                       <a href="#"  data-toggle="dropdown" class="dropdown-toggle btn pull-right" style="color:#FFFFFF">
                       <img src="assets/img/icone/ic_user.png" width="25"  alt=""/>&nbsp;
					   <?= $_SESSION['prenom']." ".$_SESSION['nom']?>&nbsp; </a>
                       
                       <ul class="dropdown-menu">
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong><a href="logout.php">Se deconnecter</a></strong>
                                </div>
                                
                            </a>
                        </li>
                       
                    </ul>
                       
                       
               </div>
               
               
                  </div> 
                    
              </div>
            
        </div>
    </section>
     <!-- MENU SECTION END-->
     
     
    <div class="content-wrapper" id="menu">
         <div class="container" style="padding-left:25px;padding-right:25px;">
       
             <div class="row col-md-10 col-md-offset-1">
            <?php if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],8)==1) {  ;?>
                  <div class="col-md-3  bg_menu">
                     <a href="modules/Parametrage/accueil.php"><div class="hint--bottom" data-hint="DASHBOARD" >
                     <center>
                      <img src="assets/img/icone/ic_banque.png"  alt="" class="icones"/> 
                      <span class="texte">PARAMETRES / PROFILS</span>
                     </center></div>
                    </a>
                    </div> 
              <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],1)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu">
                 <a href="modules/Tiers/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_assurance.png"  alt="" class="icones"/> 
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
                  <img src="assets/img/icone/ic_transfert.png"  alt="" class="icones"/> 
                  <span class="texte">EMPLOI DU TEMPS</span>
                 </center></div>
                </a>
                </div> 
                <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],4)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu">
                 <a href="modules/Evaluations/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_achat_credit.png"  alt="" class="icones"/> 
                  <span class="texte">EVALUATIONS</span>
                 </center></div>
                </a>
                </div> 
                <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],5)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu" >
                  <a href="modules/GED/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_facture.png" class="icones"  alt=""/> 
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
                  <img src="assets/img/icone/ic_transfert.png"  alt="" class="icones"/> 
                  <span class="texte">EQUIPEMENTS</span>
                 </center></div>
                </a>
                </div> 
               <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],7)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu">
                 <a href="modules/Sanctions/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_achat_credit.png"  alt="" class="icones"/> 
                  <span class="texte">SANCTIONS</span>
                 </center></div>
                </a>
                </div> 
               <?php } if($_SESSION['profil']==1 || $lib->Acces_module($_SESSION['profil'],9)==1) {  ;?> 
                <div class="col-md-3 col-md-offset-1 bg_menu" >
                  <a href="modules/Reporting/accueil.php"><div class="" >
                 <center>
                  <img src="assets/img/icone/ic_facture.png" class="icones"  alt=""/> 
                  <span class="texte">TABLEAU DE BORD</span>
                 </center></div>
              </a>
                </div> 
                 <?php }  ?>
                <br>
             </div> 
             
            
             
             
             
             
             
                  
            </div>    
            </div>        
      
    
      
      <br><br>         
            


     
    </div>
    </div>
      <!-- CONTENT-WRAPPER SECTION END-->
      
      
      
      
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <img src="assets/img/logo_samaecole.png" width="178" height="49" alt=""/> </div>

            </div>
        </div>
    </section>
    
   
<!-- END MESSAGE BOX-->
    
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
