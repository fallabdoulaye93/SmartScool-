<?php
session_start();
require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

/*
if($_SESSION['profil']!=1)
    $lib->Restreindre($lib->Est_autoriser(22,$lib->securite_xss($_SESSION['profil'])));*/
if(isset($_GET['IDINDIVIDU']) && $_GET['IDINDIVIDU']!='') {
    $idIDINDIVIDU = base64_decode($lib->securite_xss($_GET['IDINDIVIDU']));
    $idPeriode = base64_decode($lib->securite_xss($_GET['idperiode']));
    $nomProf = str_replace("-", "  ", base64_decode($lib->securite_xss($_GET['NOM'])));
   // var_dump(1);exit;
}else{
    $idIDINDIVIDU=$lib->securite_xss($_SESSION['id']);
    $idPeriode = base64_decode($lib->securite_xss($_GET['idperiode']));
    $nomProf=$lib->securite_xss($_SESSION['prenom']). " ".$lib->securite_xss($_SESSION['nom']);
}
$_SESSION["IDINDIVIDU"] = $idIDINDIVIDU;
try
{

function calendar($jour, $date_deb, $date_fin, $idIDINDIVIDU, $idPeriode){
    require_once("../config/Connexion.php");
    require_once ("../config/Librairie.php");
    $connection =  new Connexion();
    $dbh = $connection->Connection();
    $lib =  new Librairie();

    $query = "SELECT DETAIL_TIMETABLE.JOUR_SEMAINE as jour,DETAIL_TIMETABLE.DATEDEBUT as debut, 
              DETAIL_TIMETABLE.DATEFIN as fin,MATIERE.LIBELLE as libmatiere,SALL_DE_CLASSE.NOM_SALLE as libsalle,CLASSROOM.LIBELLE as libclass,EMPLOIEDUTEMPS.IDPERIODE
              FROM   DETAIL_TIMETABLE
              INNER JOIN MATIERE ON DETAIL_TIMETABLE.IDMATIERE = MATIERE.IDMATIERE
              INNER JOIN SALL_DE_CLASSE ON DETAIL_TIMETABLE.IDSALL_DE_CLASSE = SALL_DE_CLASSE.IDSALL_DE_CLASSE
              INNER JOIN EMPLOIEDUTEMPS ON DETAIL_TIMETABLE.IDEMPLOIEDUTEMPS = EMPLOIEDUTEMPS.IDEMPLOIEDUTEMPS
              INNER JOIN CLASSROOM ON EMPLOIEDUTEMPS.IDCLASSROOM = CLASSROOM.IDCLASSROOM
              WHERE EMPLOIEDUTEMPS.IDANNEE =".$lib->securite_xss($_SESSION["ANNEESSCOLAIRE"])." 
              AND DETAIL_TIMETABLE.IDINDIVIDU =".$idIDINDIVIDU."
              AND EMPLOIEDUTEMPS.IDPERIODE =".$idPeriode."
              AND DETAIL_TIMETABLE.JOUR_SEMAINE ='".$jour."'
              AND DETAIL_TIMETABLE.DATEDEBUT ='".$date_deb."'
              AND DETAIL_TIMETABLE.DATEFIN ='".$date_fin."'
              ORDER BY DETAIL_TIMETABLE.DATEDEBUT ASC  ";

    //var_dump($query);exit;
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $tabEmp = $stmt->fetchObject();
    return $tabEmp;
}
}
catch (PDOException $e)
{
    echo -2;
}
?>
<link href="../styles_page_model.css" rel="stylesheet" type="text/css"/>
<page backtop="7mm" backbottom="7mm" backleft="7mm" backright="7mm" orientation="landscape">
    <table border="0" width="100%"  >
        <tr>
            <td align="left" valign="top" ><img src="../assets/images/users/logo-accueil.png"  width="80"/></td>
                <td rowspan="10" width="700">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

            <td  align="center" valign="middle" style="font-size: 10px !important;"><strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                <?php echo $_SESSION['nomEtablissement']; ?><br/>
                <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?>
            </td>
        </tr>


                </table>

    <table width="50%" border="0" align="center">
       <tr>
           <td align="center" valign="middle" class="textBrute">
                  <strong><span style="font-size: 25px;"> PROFESSEUR : <?php echo $nomProf;?> </span></strong>
             </td>
       </tr>
    </table>
<br/>
        <table border="1"  align="center" cellpadding="0" cellspacing="0" width="100%" >

            <tr>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b> HEURES <br/> JOURS</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>08H30 - 09H30</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>09H30 - 10H30</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>11H00 - 12H00</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>12H00 - 13H00</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>13H30 - 14H30</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>14H30 - 15H30</b></td>
                <td style="color: #2F4686;text-align: center;padding: 20px;"><b>15H30 - 16H30</b></td>
            </tr>
            <tr style="padding: 10px;">
                <td style="color: #2F4686;text-align: left;padding: 20px;"><strong>LUNDI</strong></td>


                <td style='color: #56688A;padding: 20px;' >
                    <?php
                    $result = calendar("LUN", '08:30', '09:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("LUN", '09:30', '10:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("LUN", '11:00', '12:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("LUN", '12:00', '13:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("LUN", '13:30', '14:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("LUN", '14:30', '15:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("LUN", '15:30', '16:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>




            </tr>

            <tr>
                <td style="color: #2F4686;text-align: left;padding: 20px;"><strong>MARDI</strong></td>


                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '08:30', '09:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '09:30', '10:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '11:00', '12:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '12:00', '13:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '13:30', '14:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '14:30', '15:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MAR", '15:30', '16:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>




            </tr>

            <tr>
                <td style="color: #2F4686;text-align: left;padding: 20px;"><strong>MERCREDI</strong></td>


                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '08:30', '09:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '09:30', '10:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '11:00', '12:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '12:00', '13:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '13:30', '14:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '14:30', '15:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("MER", '15:30', '16:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>




            </tr>



            <tr>
                <td style="color: #2F4686;text-align: left;padding: 20px;"><strong>JEUDI</strong></td>


                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '08:30', '09:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '09:30', '10:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '11:00', '12:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '12:00', '13:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '13:30', '14:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '14:30', '15:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("JEU", '15:30', '16:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>




            </tr>

            <tr>
                <td style="color: #2F4686;text-align: left;padding: 20px;"><strong>VENDREDI</strong></td>


                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '08:30', '09:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '09:30', '10:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '11:00', '12:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '12:00', '13:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '13:30', '14:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '14:30', '15:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("VEN", '15:30', '16:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>




            </tr>

            <tr>
                <td style="color: #2F4686;text-align: left;padding: 20px;"><strong>SAMEDI</strong></td>


                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '08:30', '09:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '09:30', '10:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '11:00', '12:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '12:00', '13:00', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '13:30', '14:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '14:30', '15:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>

                <td style='color: #56688A;padding: 20px;'>
                    <?php
                    $result = calendar("SAM", '15:30', '16:30', $idIDINDIVIDU, $idPeriode);

                    if ($result!=false) {


                        print "<b>".$result->libclass."</b><br/><b>salle</b> : ".$result->libsalle."<br/>";

                    } ?>
                </td>




            </tr>



        </table>

</page>