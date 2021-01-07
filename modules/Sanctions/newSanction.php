
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
$lib->Restreindre($lib->Est_autoriser(45,$_SESSION['profil']));

require_once("classe/SanctionManager.php");
require_once("classe/Sanction.php");
$sanction=new SanctionManager($dbh,'SANCTION');

if ((isset($_POST)) && ($_POST != "") && ($_POST['DATEDEBUT'] != "") && ($_POST['DATEFIN'] != ""))
{
    $res = $sanction->insert($lib->securite_xss_array($_POST));
  if($res==1)
  {
	  $msg="Insertion reussie";
  }
  else
  {
	  $msg="Insertion echouee";
  }
  $insertGoTo = "accueil.php?res=".$lib->securite_xss($res)."&msg=".$lib->securite_xss($msg);
  header(sprintf("Location: %s", $insertGoTo));
}


$colname_rq_individu = "-1";
if (isset($_GET['IDINDIVIDU'])) {
  $colname_rq_individu = $lib->securite_xss($_GET['IDINDIVIDU']);
}
$colname_req_sanction = "-1";
if (isset($_SESSION['etab'])) {
    $colname_req_sanction = $lib->securite_xss($_SESSION['etab']);
}


$query_rq_TypeSanction = $dbh->query("SELECT `ID`, `LIBELLE`, `IDETABLISSEMENT` FROM `TYPE_SANCTION` WHERE  IDETABLISSEMENT = " . $colname_req_sanction);

try
{
    $query_rq_individu = $dbh->query("SELECT `MATRICULE`, `NOM`, `PRENOMS`,PHOTO_FACE, CLASSROOM.LIBELLE AS LIBCLASS 
                                              FROM INDIVIDU 
                                              INNER JOIN AFFECTATION_ELEVE_CLASSE ON AFFECTATION_ELEVE_CLASSE.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                              INNER JOIN CLASSROOM ON CLASSROOM.IDCLASSROOM=AFFECTATION_ELEVE_CLASSE.IDCLASSROOM 
                                              WHERE INDIVIDU.IDINDIVIDU= ".$colname_rq_individu);
    $row_rq_individu = $query_rq_individu->fetchObject();

    $query_rq_parent = $dbh->query("SELECT idParent FROM PARENT WHERE `ideleve` = ".$colname_rq_individu);
    $rs_parent = $query_rq_parent->fetchObject();


    $query_req_sanction = $dbh->query("SELECT  SANCTION.DATE, SANCTION.MOTIF, SANCTION.DATEDEBUT, SANCTION.DATEFIN, TYPE_SANCTION.LIBELLE AS TYPESANCTION
                                            FROM SANCTION 
                                            INNER JOIN TYPE_SANCTION ON TYPE_SANCTION.ID=SANCTION.IDTYPE_SANCTION
                                            WHERE SANCTION.IDETABLISSEMENT = ".$colname_req_sanction."  
                                            AND SANCTION.IDINDIVIDU= ".$colname_rq_individu);
    $rs_sanction = $query_req_sanction->fetchAll();
}
catch (PDOException $e){
    echo -2;
}
?>
<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Sanction</a></li>                    
                    <li>Nouvelle sanction</li>
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
				 
				        if(isset($_GET['res']) && $_GET['res']==1) { ?>

						  <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

						 <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

						  <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
						  <?php echo $lib->securite_xss($_GET['msg']); ?></div>

                        <?php } ?>
                 
			     <?php } ?>
                 
         <div class="row"> 
         <div class="col-lg-6" >      
       <fieldset class="cadre"><legend> INFORMATIONS PERSONNELLES</legend>
       <table border="0" >
           <tr>
               <td><img  width="150px" height="150px" alt="<?php echo $row_rq_individu->PHOTO_FACE; ?>"
                         src="../../imgtiers/<?php echo $row_rq_individu->PHOTO_FACE; ?>" style="margin-right: 30px;">
               </td>
               <td style="line-height: 35px;"><b>MATRICULE : </b> <?php echo $row_rq_individu->MATRICULE; ?><br/>
                   <b>NOM : </b><?php echo $row_rq_individu->NOM; ?><br/>
                   <b>PRENOMS :</b> <?php echo $row_rq_individu->PRENOMS; ?><br/>
                   <b>CLASSE :</b> <?php echo $row_rq_individu->LIBCLASS; ?>
               </td>
           </tr>
       </table>
      </fieldset>
      </div>
      <div class="col-lg-6" >
          <fieldset class="cadre"><legend> EMETTRE UNE SANCTION</legend>

              <form action="" method="post" name="form1" id="form1">

                  <div class="row">
                      <div class="col-xs-6">
                          <div class="form-group">
                              <div class="col-xs-3"> <label >DATE</label></div>
                              <div class="col-xs-9">
                                  <input type="text" name="DATE" id="DATE"  class="form-control" value="<?php  echo date('Y-m-d'); ?>"/>
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-6">
                          <div class="form-group">
                              <div class="col-xs-3"> <label>TYPE DE SANCTION</label></div>
                              <div class="col-xs-9">
                                  <select name="IDTYPE_SANCTION" id="IDTYPE_SANCTION" class="form-control"  required>
                                      <option value="">--Selectionner--</option>
                                      <?php  foreach ($query_rq_TypeSanction as $row_rq_TypeSanction) { ?>

                                          <option value=" <?php echo $row_rq_TypeSanction['ID']; ?>"><?php echo $row_rq_TypeSanction['LIBELLE']; ?>  </option>

                                      <?php } ?>
                                  </select>
                              </div>
                          </div>
                      </div>


                  </div>
                  <br>

                  <div class="row">
                      <div class="col-xs-6">
                          <div class="form-group">
                              <div class="col-xs-3"> <label >DATE DEBUT</label></div>
                              <div class="col-xs-9">
                                  <input type="text" name="DATEDEBUT" id="date_foo" required class="form-control"/>
                              </div>
                          </div>
                      </div>

                      <div class="col-xs-6">
                          <div class="form-group">
                              <div class="col-xs-3"><label >DATE FIN</label></div>
                              <div class="col-xs-9">
                                  <input type="text" name="DATEFIN" id="date_foo2" required class="form-control"/>
                              </div>
                          </div>
                      </div>
                  </div><br>
                  <div class="row">
                      <div class="col-xs-12">
                          <div class="form-group">
                              <div class="col-xs-1"><label >MOTIF</label></div>
                              <div class="col-xs-11">
                                  <textarea name="MOTIF" id="MOTIF" required  class="form-control" ></textarea>

                              </div>
                          </div>
                      </div>
                  </div>
                  <br>

                  <div class="col-xs-offset-9 col-xs-1">
                      <input  type="submit" value="Valider" class="btn btn-success"  />
                  </div>

                  <input type="hidden" name="IDINDIVIDU" value="<?php echo $lib->securite_xss($_GET['IDINDIVIDU']); ?>"/>
                  <input type="hidden" name="IDETABLISSEMENT" value="<?php echo $lib->securite_xss($_SESSION['etab']); ?>" />
                  <input type="hidden" name="IDANNEE" value="<?php echo $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']); ?>" />
                  <input type="hidden" name="ID_AUTHORITE" value="<?php echo $rs_parent->idParent; ?>" />

              </form>
          </fieldset>

      </div>
      </div>
      
      
      <div class="row">
      <div class="col-lg-12" >


          <fieldset class="cadre"><legend> HISTORIQUE DES SANCTIONS</legend>
              <table width="616" border="0" cellspacing="2" id="customers2" class="table datatable">
                  <tr>
                      <td>DATE</td>
                      <td>TYPE DE SANCTION</td>
                      <td>MOTIF</td>
                      <td>DATE DEBUT</td>
                      <td>DATE FIN</td>
                  </tr>
                  <?php foreach($rs_sanction as $row_req_sanction){  ?>
                      <tr>
                          <td class="textBrute"><?php echo $lib->date_franc($row_req_sanction['DATE']); ?></td>
                          <td class="textBrute"><?php echo $row_req_sanction['TYPESANCTION']; ?></td>
                          <td class="textBrute"><?php echo $row_req_sanction['MOTIF']; ?></td>
                          <td class="textBrute"><?php echo $lib->date_franc($row_req_sanction['DATEDEBUT']); ?></td>
                          <td class="textBrute"><?php echo $lib->date_franc($row_req_sanction['DATEFIN']); ?></td>
                      </tr>
                  <?php } ?>
              </table>
          </fieldset>


      </div>
      </div>

                    </div></div></div>
                    <!-- END WIDGETS -->                    
                    
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

 
        <?php include('footer.php'); ?>