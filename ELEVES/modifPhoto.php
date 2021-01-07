
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
$ind=new IndividuManager($dbh,'INDIVIDU');


$colname_rq_etablissement = "-1";
if (isset($_SESSION['etab'])) {
  $colname_rq_etablissement = $_SESSION['etab'];
}

$colname_rq_idindividu = "-1";
if (isset($_SESSION['id'])) {
  $colname_rq_idindividu = $_SESSION['id'];
}

//$_SESSION["id"]


$query_rq_etablissement = $dbh->query("SELECT * FROM INDIVIDU WHERE IDINDIVIDU = ".$colname_rq_idindividu);
$row_rq_etablissement = $query_rq_etablissement->fetchObject();


if(isset($_POST) && $_POST !=null ) {
	

$dossier = "../imgtiers/";


if (basename($_FILES['PHOTO_FACE']['name']) == '') {
		$file_photo = $row_rq_etablissement->PHOTO_FACE ;
	} else {
		$file_photo = basename($_FILES['PHOTO_FACE']['name']);
}



$taille_maxi = 2048000;

$taille_photo = filesize($_FILES['PHOTO_FACE']['tmp_name']);

$extensions = array('.png', '.gif', '.jpg', '.jpeg','');

$ext_photo = strrchr($_FILES['PHOTO_FACE']['name'], '.');




//D&eacute;but des v&eacute;rifications de s&eacute;curit&eacute;...

//V&eacute;rification des extensions...
if(!in_array($ext_photo, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $msg = 'Vous ne pouvez pas transf&eacute;r&eacute;s ce type de fichier, Voici les types de fichiers autoris&eacute;s png, gif, jpg, jpeg...';
                                                
}




//V&eacute;rification des tailles de fichiers...
if($taille_photo>$taille_maxi)
{
     $msg = 'un des fichiers est trop gros, la taille maximale de chaque fichiers est 1024 Ko...';
}


//S'il n'y a pas d'erreur, on upload
if(!isset($msg)) 
{
    
     if(move_uploaded_file($_FILES['PHOTO_FACE']['tmp_name'], $dossier . $file_photo)) //Si la fonction renvoie TRUE, c'est que &ccedil;a a fonctionn&eacute;...
     {
          //echo 'la photo a &eacute;t&eacute; envoy&eacute; avec succ&egrave;s ! <br>';
		   $res = $ind->modifier($_POST,'IDINDIVIDU',$_POST['IDINDIVIDU']);
			if ($res==1) {
				$msg="modification reussie";
		
			}
			else{
				$msg="modification echouee";
			}
			header("Location: accueil.php?msg=".$msg."&res=".$res);
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          $msg='Echec de l\'upload !';
		  $res=-1;
		  header("Location: accueil.php?msg=".$msg."&res=".$res);
     }
	 	 
}
else
{
     $msg=$msg;
	 $res=-1;
	 header("Location: accueil.php?msg=".$msg."&res=".$res);
}



   
}


?>


<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#"> ELEVE/ETUDIANT </a></li>                    
                    <li class="active"> </li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1)
                        {?>
                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $_GET['msg']; ?></div>
                        <?php  }
                        if(isset($_GET['res']) && $_GET['res']!=1)
                        {?>
                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $_GET['msg']; ?></div>
                        <?php }
                        ?>

                    <?php } ?>
                    
                    <!-- START WIDGETS -->                    
                    <div class="row">
                                       
                    
      
                <form action="modifPhoto.php" method="post"  enctype="multipart/form-data">
               
                
                <table class="table table-striped table-responsive">
                <thead>
                    <th>PHOTO</th>
                    <th>MODIFIER</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                <tr>
                
                 <td><img src="../imgtiers/<?php echo $row_rq_etablissement->PHOTO_FACE; ?>" alt=""  width="41px"/> </td>
                  
                 <td>  <input type="file" name="PHOTO_FACE" id="PHOTO_FACE"  class="form-control"/> </td>
                  
                 <td><input type="submit" value="Modifier l'image" class="btn btn-success"/> </td>
                 
                  
              </tr>
     </tbody>                       
    </table>
            
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