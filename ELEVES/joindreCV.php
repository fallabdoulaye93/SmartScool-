
<?php
if (!isset($_SESSION)){
    session_start();
}
require_once("restriction.php");

require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();

require_once('classe/IndividuManager.php');
$ind = new IndividuManager($dbh,'INDIVIDU');

$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etablissement = $lib->securite_xss($_SESSION['etab']);
}

$colname_rq_idindividu = "-1";
if (isset($_SESSION['id'])) {
  $colname_rq_idindividu = $lib->securite_xss($_SESSION['id']);
}

$query_rq_cv = $dbh->query("SELECT IDCV, FICHIER, IDETABLISSEMNT, IDINDIVIDU FROM CV WHERE IDINDIVIDU = ".$colname_rq_idindividu);
$row_rq_cv = $query_rq_cv->fetchAll();
$totalRows_rq_cv = $query_rq_cv->rowCount();
if($totalRows_rq_cv > 0)
{
	  $DELETE = $dbh->query("DELETE FROM CV  WHERE IDINDIVIDU = ".$colname_rq_idindividu);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
{
    $res= -1;
    $dossier = "../cv/";
    $file_photo = basename($_FILES['FICHIER']['name']);
    $taille_maxi = 2048000;
    $taille_photo = filesize($_FILES['FICHIER']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg','.doc','.docx','.pdf');
    $ext_photo = strrchr($_FILES['FICHIER']['name'], '.');

    //D&eacute;but des v&eacute;rifications de s&eacute;curit&eacute;...
    //V&eacute;rification des extensions...
    if(!in_array($ext_photo, $extensions)) //Si l'extension n'est pas dans le tableau
    {
         $msg = "Vous ne pouvez pas transf&eacute;r&eacute;s ce type de fichier, Voici les types de fichiers autoris&eacute;s png, gif, jpg, jpeg...";
    }
    //V&eacute;rification des tailles de fichiers...
    if($taille_photo>$taille_maxi)
    {
         $msg = "un des fichiers est trop gros, la taille maximale de chaque fichiers est 1024 Ko...";
    }
    //S'il n'y a pas d'erreur, on upload
    if(!isset($msg))
    {

         if(move_uploaded_file($_FILES['FICHIER']['tmp_name'], $dossier . $file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
         {
            $res = $dbh->query("INSERT INTO CV (FICHIER, IDETABLISSEMNT, IDINDIVIDU) VALUES ( '".$file_photo."', ".$lib->securite_xss($_POST['IDETABLISSEMENT']).", ".$lib->securite_xss($_POST['IDINDIVIDU']).")");

            if($res == 1)
            {
                $msg="CV joint avec succes";
            }
            else{
              $res=-1;
              $msg="CV joint avec echec";
            }
         }
         else //Sinon (la fonction renvoie FALSE).
         {
             $res=-1;
              $msg= "Echec de l\'upload !";
         }
         $res=-1;
    }
    header("Location: accueil.php");
}

?>
        <?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE </a></li>
                    <li class="active"> </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1)
                        {?>
                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                        <?php } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php } ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <form action="joindreCV.php" method="post"  name="form1" id="form1" enctype="multipart/form-data">
               
                
                <table class="table table-striped table-responsive">
                <thead>
                    <th>CV</th>
                   
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                <tr>
                
                
                  
                 <td>  <input type="file" name="FICHIER" id="FICHIER"  class="form-control"/> </td>
                  
                 <td><input type="submit" value="Joindre CV" class="btn btn-success"/> </td>
                 
                  
              </tr>
     </tbody>                       
    </table>
        
        
        <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $_SESSION['etab'] ;?>" />
        <input type="hidden" name="IDINDIVIDU" value="<?php echo $_SESSION['id']; ?>" />
        <input type="hidden" name="MM_insert" value="form1" />
            
       </form>
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