
<?php
session_start();
require_once("../config/Connexion.php");
require_once ("../config/Librairie.php");
$connection =  new Connexion();
$dbh = $connection->Connection();
$lib =  new Librairie();



/*$colname_Etab_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_Etab_rq_individu = $_SESSION['etab'];
}
$colname_anne_rq_individu = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_individu = $_SESSION['ANNEESSCOLAIRE'];
}*/

$colname_Etab_rq_individu = "-1";
if (isset($_SESSION['etab'])) {
  $colname_Etab_rq_individu = $_SESSION['etab'];
}
$colname_anne_rq_individu = "-1";
if (isset($_SESSION['ANNEESSCOLAIRE'])) {
  $colname_anne_rq_individu = $_SESSION['ANNEESSCOLAIRE'];
}

$query_rq_individu = $dbh->query("SELECT R.IDRECRUTE_PROF, R.TARIF_HORAIRE, R.VOLUME_HORAIRE, I.MATRICULE, 
                                            I.NOM, I.PRENOMS, M.LIBELLE as matiere, I.PHOTO_FACE 
                                            FROM RECRUTE_PROF R 
                                            INNER JOIN INDIVIDU I ON R.IDINDIVIDU = I.IDINDIVIDU
                                            INNER JOIN MATIERE_ENSEIGNE ME ON ME.ID_INDIVIDU = I.IDINDIVIDU
                                            INNER JOIN MATIERE M ON ME.ID_MATIERE = M.IDMATIERE
                                            WHERE R.IDETABLISSEMENT = ".$colname_Etab_rq_individu."  
                                            AND R.IDANNEESSCOLAIRE =  ".$colname_anne_rq_individu);
$rs_individu = $query_rq_individu->fetchAll();


?>

<link href="../styles_page_model.css" rel="stylesheet" type="text/css" />

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm" >
<table border="0" align="center" >
  <tr>
    <td width="170" height="20" align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" width="150" height="94" /></td>
    <td height="20" colspan="3" align="center" valign="middle" class="Titre"> LISTE DES PROFESSEURS RECRUTES<br />
    <?php echo date("j-m-y"); ?></td>
   
  
  
  </tr>
  <tr>
    <td height="6" colspan="7" align="left" valign="top" class="Titre"><img src="../images/im_lign.jpg" width="730" height="1" /></td>
  </tr>
  <tr valign="middle" >
    <td height="20" align="center" nowrap="nowrap" bgcolor="#F3F3F3" class="nomEntrepr">NOMS &amp; PRENOMS</td>
    <td width="89" align="center" bgcolor="#F3F3F3" class="textBrute"><span class="nomEntrepr">MATIERES</span></td>
<!--    <td width="96" align="center" bgcolor="#F3F3F3" class="textBrute"><span class="nomEntrepr">CLASSES</span></td>
-->    <td width="126" align="center" bgcolor="#F3F3F3" class="nomEntrepr"><span class="textBrute">VOLUME HORAIRE</span></td>



  </tr>
  <?php foreach($rs_individu as $row_rq_individu) { ?>
    <tr valign="middle">
      <td height="20" align="center" nowrap="nowrap" class="textBrute"><?php echo $row_rq_individu['NOM'];?>&nbsp;      <?php echo $row_rq_individu['PRENOMS']; ?></td>
      <td align="center" class="textBrute"><?php echo $row_rq_individu['matiere']; ?></td>
      <!--<td align="center" class="textBrute"><span class="textBrute"><?php /*echo $row_rq_individu['classe']; */?></span></td>-->
      <td align="center" class="textBrute"><?php echo $row_rq_individu['VOLUME_HORAIRE']; ?></td>
      

    </tr>
    <?php }  ?>
</table>
</page>

