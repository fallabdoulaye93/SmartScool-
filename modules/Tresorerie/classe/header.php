<?php 
  require_once("../../config/Connexion.php");
  require_once ("../../config/Librairie.php");
  $connection =  new Connexion();
  $dbh = $connection->Connection();
  $query= "SELECT profil from profil where idProfil= ".$_SESSION['profil'];
  $stmt = $dbh->prepare($query);  
  $stmt->execute();
  $rs_user = $stmt->fetchObject();
?>

<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>SunuEcole - Gestion Administrative des Etablissements Scolaires</title>            
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="../../assets/images/users/user-ecole.jpg" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="../../css/theme-default.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="../../datetimepicker/jquery.datetimepicker.css"/>
        <!-- EOF CSS INCLUDE -->

        <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
        <script>
            tinymce.init({
                selector: '#mytextarea'
            });
        </script>
        <script language="javascript1.5" type="application/javascript">
function trim(str) {
	return String(str).replace(/^\s*/,'').replace(/\s*$/,'');
}
function mont_reliquat()
{  
	var lmontant = parseInt(document.form1.MONTANT.value);
	var lmtverset = parseInt(document.form1.MT_VERSE.value);
	var lrestant =lmontant - lmtverset;
	//document.forms['formulaire'].elements['nom'].value
	document.form1.MT_RELIQUAT.value = lrestant;
}
</script>

        
        <style>
		.cadre {
    background-color: #ffffff;
    width: 100%;
    margin: 0 auto 15px auto;
    padding: 10px;
    border: 2px solid #2589C5;
 
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 5px;
    behavior: url(border-radius.htc);
 
    background-image: -moz-linear-gradient(top, #ffffff, #f4f4f4);
    background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f4f4f4));
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4)";
	}
	 
	legend {
		color: #E05D1F;
	}
	
	.cadre1 {
    background-color: #ffffff;
    width: 50%;
    margin: 0 auto 15px auto;
    padding: 10px;
    border: 2px solid #2589C5;
 
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 5px;
    behavior: url(border-radius.htc);
 
    background-image: -moz-linear-gradient(top, #ffffff, #f4f4f4);
    background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#f4f4f4));
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff,endColorstr=#f4f4f4)";
	}
	 
	legend {
		color: #E05D1F;
	}
        </style>


    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="../../menu.php">SunuEcole</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="../../menu.php" class="profile-mini">
                            <img src="../../assets/images/users/user-ecole.jpg" alt="sunuEcole"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                            <a href="../../menu.php">
                                <img src="../../assets/images/users/user-ecole.jpg" alt="sunuEcole"/>
                                <!--<img src="../../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" alt="sunuEcole"  style="min-height:400px; min-width:400px;"/>-->
                            </a>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">
								<?php echo $_SESSION['prenom']."   ".$_SESSION['nom']; ?></div>
                                
                                <div class="profile-data-title"><?php echo $rs_user->profil; ?></div>
                            </div>
                            <div class="profile-controls">
                                
                            </div>
                        </div>                                                                        
                    </li>
                    <li class="xn-openable active">
                        <a href="accueil.php"><span class="fa fa-files-o"></span> <span class="xn-text">TRESORERIE</span></a>
                         <ul>
                         <!--  	Mensualités Règlement mensualité Paiement des professeurs Prévision budgétaire Situation financière Historique journalier Paiement du Personnel Dépenses-->
                            <li><a href="facturation.php"><span class="fa fa-heart"></span> Factures</a></li>
                            <li><a href="generationFacture.php"><span class="fa fa-download"></span> G&eacute;n&eacute;ration de factures</a></li>
                            <li><a href="accueil.php"><span class="fa fa-heart"></span> Mensualit&eacute;s</a></li>
                           <!-- <li><a href="reglementMensualites.php"><span class="glyphicon glyphicon-user"></span> R&egrave;glement mensualit&eacute;</a></li>-->
                            <li><a href="paiementProfesseur.php"><span class="glyphicon glyphicon-user"></span> Paiement des professeurs</a></li>
                            <li><a href="previsionBudgetaire.php"><span class="fa fa-heart"></span>Pr&eacute;vision budg&eacute;taire </a></li>
                         
                            <li><a href="situationFinanciere.php"><span class="fa fa-heart"></span>Situation financi&egrave;re </a></li>
                            <li><a href="historiqueJournalier.php"><span class="fa fa-history"></span> Historique journalier</a></li>
                            <li><a href="paiementPersonnel.php"><span class="fa fa-heart"></span>Paiement du Personnel </a></li>
                            <li><a href="depenses.php"><span class="fa fa-heart"></span> D&eacute;penses</a></li>
                            <li><a href="reporting.php"><span class="fa fa-dashboard"></span> Reporting</a></li>
                            
                            
                            
                            
                        </ul>
                    </li>
                  
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
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
                        
                         
                        <span style="font-size:14px; color:#fff;">Bienvenue <?php echo  $_SESSION['prenom']." ".$_SESSION['nom']; ?> </span>
                    </li>
                   
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

               