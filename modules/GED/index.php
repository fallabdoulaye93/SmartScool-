
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


require_once('../Parametrage/classe/ProfileManager.php');
$profiles=new ProfileManager($dbh,'profil');
$profil = $profiles->getProfiles();


include('header.php'); ?>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">GED</a></li>
    <li>Accueil</li>
</ul>
<!-- END BREADCRUMB -->
<script>
    function myEfface()
    {
        (!$('#mceu_29').hasClass("hidden")) ? $('#mceu_29').addClass("hidden") : null ;
    }
</script>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                &nbsp;&nbsp;&nbsp;

            </div>
            <div class="panel-body">

                <h1>MODULE GED</h1>

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