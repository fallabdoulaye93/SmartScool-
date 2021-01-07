
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
$lib->Restreindre($lib->Est_autoriser(47, $lib->securite_xss($_SESSION['profil'])));

$etab = "-1";
if(isset($_SESSION['etab']))
{
    $etab = $lib->securite_xss($_SESSION['etab']);
}

$annescolaire = "-1";
if(isset($_SESSION['ANNEESSCOLAIRE']))
{
    $annescolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
}

try
{
    $query_rq_niv = $dbh->query("SELECT IDNIVEAU, LIBELLE, IDETABLISSEMENT FROM NIVEAU WHERE IDETABLISSEMENT = " . $etab);
    $rs_niv = $query_rq_niv->fetchAll();



    $query_rq_niv_classe = $dbh->query("SELECT ID, LIBELLE FROM NIV_CLASSE WHERE IDETABLISSEMENT = " . $etab);
    $rs_niv_classe = $query_rq_niv_classe->fetchAll();

//var_dump($rs_niv_classe);die();

    $query_age=$dbh->query("SELECT DATNAISSANCE 
                                      FROM INDIVIDU 
                                      INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                      WHERE  INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                      AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire);


    /*******DEB*********/
    $query_rq_totat_eleve = $dbh->query("SELECT count(IDINDIVIDU) as tot_eleve 
                                                      FROM INDIVIDU 
                                                      WHERE IDETABLISSEMENT = ".$etab." 
                                                      AND IDTYPEINDIVIDU = 8");
    $row_rq_totat_eleve = $query_rq_totat_eleve->fetchObject();

    $query_rq_eleve_par_pays = $dbh->query("SELECT count(INSCRIPTION.IDINSCRIPTION) as nbre, INDIVIDU.NATIONNALITE, PAYS.LIBELLE, PAYS.ROWID 
                                                          FROM INDIVIDU, PAYS, INSCRIPTION 
                                                          WHERE INSCRIPTION.IDETABLISSEMENT = ".$etab." 
                                                          AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                                          AND PAYS.ROWID=INDIVIDU.NATIONNALITE 
                                                          AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                                          GROUP BY  PAYS.ROWID");
    $rs_pays = $query_rq_eleve_par_pays->fetchAll();

    $query_rq_nbre_prof = $dbh->query("SELECT COUNT(RECRUTE_PROF.IDRECRUTE_PROF) as tot_eleve 
                                                    FROM RECRUTE_PROF
                                                    WHERE RECRUTE_PROF.IDETABLISSEMENT =".$etab);
    $row_rq_nbre_prof = $query_rq_nbre_prof->fetchObject();

    $query_rq_filirre = $dbh->query("SELECT count(IDSERIE) as nbre 
                                                   FROM SERIE 
                                                   WHERE IDETABLISSEMENT = ".$etab);
    $row_rq_filirre = $query_rq_filirre->fetchObject();

    $query_rq_nbr_salle_classe = $dbh->query("SELECT count(IDSALL_DE_CLASSE) as nbre 
                                                            FROM SALL_DE_CLASSE 
                                                            WHERE IDETABLISSEMENT = ".$etab);
    $row_rq_nbr_salle_classe = $query_rq_nbr_salle_classe->fetchObject();

    $query_rq_inscription_par_niveau = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) as nbre, INSCRIPTION.IDNIVEAU, NIVEAU.LIBELLE 
                                                                  FROM INSCRIPTION, NIVEAU 
                                                                  WHERE INSCRIPTION.IDETABLISSEMENT = ".$etab." 
                                                                  AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU 
                                                                  AND INSCRIPTION.IDANNEESSCOLAIRE=".$annescolaire." 
                                                                  GROUP BY INSCRIPTION.IDNIVEAU");
    $rs_niveau = $query_rq_inscription_par_niveau->fetchAll();

    $query_rq_inscription_par_filiere = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE, INSCRIPTION.IDSERIE, SERIE.LIBSERIE 
                                                                   FROM INSCRIPTION, SERIE 
                                                                   WHERE INSCRIPTION.IDETABLISSEMENT = ".$etab." 
                                                                   AND INSCRIPTION.IDSERIE = SERIE.IDSERIE 
                                                                   AND INSCRIPTION.IDANNEESSCOLAIRE=".$annescolaire." 
                                                                   GROUP BY INSCRIPTION.IDSERIE");
    $rs_filiere = $query_rq_inscription_par_filiere->fetchAll();


    $query_rq_eleve_inscrit = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE 
                                                        FROM INSCRIPTION 
                                                        WHERE IDETABLISSEMENT = ".$etab." 
                                                        AND INSCRIPTION.IDANNEESSCOLAIRE=".$annescolaire);
    $row_rq_eleve_inscrit = $query_rq_eleve_inscrit->fetchObject();


    $query_rq_eleve_par_genre = $dbh->query("SELECT count(INS.IDINSCRIPTION) as nbre, IND.SEXE 
                                                          FROM INSCRIPTION INS 
                                                          INNER JOIN INDIVIDU IND ON INS.IDINDIVIDU = IND.IDINDIVIDU 
                                                          WHERE INS.IDETABLISSEMENT = ".$etab." 
                                                          AND INS.IDANNEESSCOLAIRE = ".$annescolaire." 
                                                          GROUP BY IND.SEXE");
    $rs_genre = $query_rq_eleve_par_genre->fetchAll();


    $query_rq_eleve_par_genre = $dbh->query("SELECT count(INS.IDINSCRIPTION) as nbre, IND.SEXE 
                                                          FROM INSCRIPTION INS 
                                                          INNER JOIN INDIVIDU IND ON INS.IDINDIVIDU = IND.IDINDIVIDU 
                                                          WHERE INS.IDETABLISSEMENT = ".$etab." 
                                                          AND INS.IDANNEESSCOLAIRE = ".$annescolaire." 
                                                          GROUP BY IND.SEXE");
    $rs_genre = $query_rq_eleve_par_genre->fetchAll();

    $query_rq_eleve_totale = $dbh->query("SELECT count(INS.IDINSCRIPTION) as nbre
                                                    FROM INSCRIPTION INS 
                                                    WHERE INS.IDETABLISSEMENT = ".$etab." 
                                                    AND INS.IDANNEESSCOLAIRE = ".$annescolaire." ");
    $rs_totale = $query_rq_eleve_totale->fetchObject();
    /*******FIN*******/







    $title = 'Pyramide des âges de toutes les classes, par genre';
    if(isset($_POST['form1']) && $_POST['form1'] === 'Ms_form')
    {
        $classe = $lib->securite_xss($_POST['classe']);


        $query_classe = $dbh->query("SELECT IDCLASSROOM, LIBELLE FROM CLASSROOM WHERE IDCLASSROOM = " . $classe);
        $rs_classe = $query_classe->fetchObject()->LIBELLE;

        $title = 'Pyramide des âges de la classe de :'.$rs_classe.' par genre';


        $queryM=$dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                        FROM INDIVIDU 
                                        INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                        INNER JOIN AFFECTATION_ELEVE_CLASSE ON INSCRIPTION.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
                                        WHERE INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                        AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                        AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = ".$classe." 
                                        AND SEXE = 1 
                                        GROUP by age");

        $queryF=$dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                        FROM INDIVIDU 
                                        INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                        INNER JOIN AFFECTATION_ELEVE_CLASSE ON INSCRIPTION.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
                                        WHERE INDIVIDU.IDETABLISSEMENT = ".$etab."  
                                        AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                        AND AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = ".$classe." 
                                        AND SEXE = 0 
                                        GROUP by age");




        /******DEB*******/
        $query_rq_totat_eleve = $dbh->query("SELECT count(IDINDIVIDU) as tot_eleve 
                                                      FROM INDIVIDU 
                                                      WHERE IDETABLISSEMENT = ".$etab." 
                                                      AND IDTYPEINDIVIDU = 8");
        $row_rq_totat_eleve = $query_rq_totat_eleve->fetchObject();

        $query_rq_eleve_par_pays = $dbh->query("SELECT count(INSCRIPTION.IDINSCRIPTION) as nbre, INDIVIDU.NATIONNALITE, PAYS.LIBELLE, PAYS.ROWID 
                                                          FROM INDIVIDU, PAYS, INSCRIPTION 
                                                          WHERE INSCRIPTION.IDETABLISSEMENT = ".$etab." 
                                                          AND INSCRIPTION.IDINDIVIDU=INDIVIDU.IDINDIVIDU 
                                                          AND PAYS.ROWID=INDIVIDU.NATIONNALITE 
                                                          AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                                          GROUP BY  PAYS.ROWID");
        $rs_pays = $query_rq_eleve_par_pays->fetchAll();

        $query_rq_nbre_prof = $dbh->query("SELECT COUNT(RECRUTE_PROF.IDRECRUTE_PROF) as tot_eleve 
                                                    FROM RECRUTE_PROF
                                                    WHERE RECRUTE_PROF.IDETABLISSEMENT =".$etab);
        $row_rq_nbre_prof = $query_rq_nbre_prof->fetchObject();



        $query_rq_filirre = $dbh->query("SELECT count(IDSERIE) as nbre 
                                                   FROM SERIE 
                                                   WHERE IDETABLISSEMENT = ".$etab);
        $row_rq_filirre = $query_rq_filirre->fetchObject();

        $query_rq_nbr_salle_classe = $dbh->query("SELECT count(IDSALL_DE_CLASSE) as nbre 
                                                            FROM SALL_DE_CLASSE 
                                                            WHERE IDETABLISSEMENT = ".$etab);
        $row_rq_nbr_salle_classe = $query_rq_nbr_salle_classe->fetchObject();

        $query_rq_inscription_par_niveau = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) as nbre, INSCRIPTION.IDNIVEAU, NIVEAU.LIBELLE 
                                                                  FROM INSCRIPTION, NIVEAU 
                                                                  WHERE INSCRIPTION.IDETABLISSEMENT = ".$etab." 
                                                                  AND INSCRIPTION.IDNIVEAU=NIVEAU.IDNIVEAU 
                                                                  AND INSCRIPTION.IDANNEESSCOLAIRE=".$annescolaire." 
                                                                  GROUP BY INSCRIPTION.IDNIVEAU");
        $rs_niveau = $query_rq_inscription_par_niveau->fetchAll();



        $query_rq_inscription_par_filiere = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE, INSCRIPTION.IDSERIE, SERIE.LIBSERIE 
                                                                   FROM INSCRIPTION, SERIE 
                                                                   WHERE INSCRIPTION.IDETABLISSEMENT = ".$etab." 
                                                                   AND INSCRIPTION.IDSERIE = SERIE.IDSERIE 
                                                                   AND INSCRIPTION.IDANNEESSCOLAIRE=".$annescolaire." 
                                                                   GROUP BY INSCRIPTION.IDSERIE");
        $rs_filiere = $query_rq_inscription_par_filiere->fetchAll();


        $query_rq_eleve_inscrit = $dbh->query("SELECT COUNT(INSCRIPTION.IDINSCRIPTION) AS NBRE 
                                                        FROM INSCRIPTION 
                                                        WHERE IDETABLISSEMENT = ".$etab." 
                                                        AND INSCRIPTION.IDANNEESSCOLAIRE=".$annescolaire);
        $row_rq_eleve_inscrit = $query_rq_eleve_inscrit->fetchObject();

        /*****FIN****/


    }
    else{

        $queryM = $dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                        FROM INDIVIDU 
                                        INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                        WHERE INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                        AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                        AND SEXE = 1 
                                        GROUP by age");

        $queryF = $dbh->query("SELECT count(INDIVIDU.IDINDIVIDU) as nbr, DATNAISSANCE, YEAR(CURDATE()) - YEAR(`DATNAISSANCE`) - IF(STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(`DATNAISSANCE`), '-', DAY(`DATNAISSANCE`)) ,'%Y-%c-%e') > CURDATE(), 1, 0) AS age
                                        FROM INDIVIDU 
                                        INNER JOIN INSCRIPTION ON INSCRIPTION.IDINDIVIDU = INDIVIDU.IDINDIVIDU 
                                        WHERE INDIVIDU.IDETABLISSEMENT = ".$etab." 
                                        AND INSCRIPTION.IDANNEESSCOLAIRE = ".$annescolaire." 
                                        AND SEXE = 0 
                                        GROUP by age");

    }
    $rs_Garcon = $queryM->fetchAll();
    $rs_Fille = $queryF->fetchAll();
    $garcons = [];
    $filles = [];

    $categorie  =range(0,99,5);
    array_walk($categorie, function($value)use(&$garcons, &$filles, $rs_Garcon, $rs_Fille)
    {
        $cpt_g = 0;
        $cpt_f = 0;
        foreach ($rs_Garcon as $g)
        {
            $age = $g['age'];
            if($age <= $value + 4 &&  $age >= $value )
            {
                $cpt_g += intval($g['nbr']);
            }
        }
        foreach ($rs_Fille as $f)
        {
            $age = $f['age'];
            if($age <= $value + 4 &&  $age >= $value )
            {
                $cpt_f += intval($f['nbr']);
            }
        }
        $garcons[] = $cpt_g ;
        $filles[] = $cpt_f ;
    });
}
catch (PDOException $e)
{
    echo -2;
}
?>
<?php include('header.php'); ?>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Reporting</a></li>                    
                    <li></li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <?php if(isset($_GET['msg']) && $_GET['msg']!= ''){

                        if(isset($_GET['res']) && $_GET['res']==1) { ?>

                            <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php  } if(isset($_GET['res']) && $_GET['res']!=1) { ?>

                            <div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $lib->securite_xss($_GET['msg']); ?>
                            </div>

                        <?php } ?>

                    <?php } ?>

                    <!-- START WIDGETS -->

                    <div class="row">

                        <div class="col-lg-6">

                            <fieldset class="cadre"><legend><?php echo $title; ?></legend>
                                <br/>


                                <form id="form" method="POST" action="accueil.php" class="form-inline">

                                    <div  class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">CYCLE </label>
                                        <div class="col-lg-9 col-sm-8">
                                            <select name="IDNIVEAU" id="selectNiv" class="form-control" onchange="choixClasse(this);"  style="width: 100%!important;">
                                                <option value="">--Selectionner--</option>
                                                <?php  foreach ($rs_niv as $row_rq_niv) { ?>
                                                    <option value=" <?php echo $row_rq_niv['IDNIVEAU']; ?>"><?php echo $row_rq_niv['LIBELLE']; ?>  </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">CLASSE </label>
                                        <div class="col-lg-9  col-sm-8">
                                            <select name="classe" id="classe" class="form-control"  style="width: 100%!important;"  onchange="buttonControl();" >
                                                <option value="">--Selectionner--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
                                        <input name="form1" value="Ms_form" type="hidden"/>
                                        <button type="submit" class="btn btn-primary " id="validerAj" title="Rechercher" style="display: none;">Rechercher</button>
                                    </div>

                                </form>

                                <br>

                                <figure class="highcharts-figure">
                                    <div id="container" style="width: 100%; height: 400px !important;"></div>
                                </figure>

                            </fieldset>
                        </div>

                        <div class="col-lg-6">

                            <fieldset class="cadre"><legend>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS PAR NATIONALIT&Eacute;</legend>

                                <div class="col-lg-4" >

                                    <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">

                                        <tr>
                                            <th>NATIONALIT&Eacute;S</th>
                                            <th>NOMBRE</th>
                                        </tr>
                                        <?php
                                        $tab=array();
                                        $i=0;
                                        foreach($rs_pays as $row_rq_eleve_par_pays) {  ?>
                                            <tr>
                                                <td ><?php echo htmlentities($row_rq_eleve_par_pays['LIBELLE']); ?></td>
                                                <td ><?php echo $row_rq_eleve_par_pays['nbre']; ?></td>
                                            </tr>
                                            <?php
                                            $tab[$i]=array("Nationalite"=>$row_rq_eleve_par_pays['LIBELLE'],"nbreEeleves"=>$row_rq_eleve_par_pays['nbre']);
                                            $i++;
                                        }  ?>

                                    </table>

                                </div>

                                <div class="col-lg-8" >
                                    <div id="container2" style="width: 100%; height: 445px !important;"> </div>
                                </div>

                            </fieldset>
                        </div>

                    </div>

                     <div class="row">
                     
                            <div class="col-lg-6">

                                <fieldset class="cadre"><legend>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS PAR GENRE</legend>
                                    <table width="100%"  border="0" cellpadding="0" cellspacing="3" class = "table table-striped">
                                        <tr>
                                            <th>GENRE</th>
                                            <th style="text-align: center !important;">NOMBRE</th>
                                        </tr>
                                        <?php foreach($rs_genre as $rs_rows) { ?>
                                            <tr>
                                                <td><?php if($rs_rows['SEXE'] == 0) echo 'FILLES'; if($rs_rows['SEXE'] == 1) echo 'GARCONS' ; ?></td>
                                                <td align="center"><?php echo $rs_rows['nbre']; ?></td>
                                            </tr>
                                        <?php  }  ?>
                                    </table>
                                </fieldset>
                                <br>

                                <fieldset class="cadre"><legend>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS PAR SERIE</legend>
                                      <table width="100%"  border="0" cellpadding="0" cellspacing="3" class = "table table-striped">
                                        <tr>
                                          <th>SERIE</th>
                                          <th>NOMBRE</th>
                                        </tr>
                                        <?php foreach($rs_filiere as $row_rq_inscription_par_filiere) { ?>
                                        <tr>
                                          <td ><?php echo $row_rq_inscription_par_filiere['LIBSERIE']; ?></td>
                                          <td ><?php echo $row_rq_inscription_par_filiere['NBRE']; ?></td>
                                          </tr>
                                        <?php  }  ?>
                                      </table>
                                </fieldset>
                                <br/>

                                <fieldset class="cadre"><legend>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS PAR CYCLE</legend>
                                    <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">
                                        <tr>
                                            <th >CYCLE</th>
                                            <th>NOMBRE</th>
                                        </tr>
                                        <?php foreach($rs_niveau as $row_rq_inscription_par_niveau) { ?>
                                            <tr>
                                                <td ><?php echo $row_rq_inscription_par_niveau['LIBELLE']; ?></td>
                                                <td ><?php echo $row_rq_inscription_par_niveau['nbre']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </fieldset>
                                <br/>

                                <fieldset class="cadre"><legend>STATISTIQUES</legend>
                                    <table  width="100%" border="0" cellpadding="0" cellspacing="3" class = "table table-striped">

                                        <tr>
                                            <th>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS:</th>
                                            <td><?php echo $row_rq_eleve_inscrit->NBRE; ?></td>
                                        </tr>

                                        <tr>
                                            <th>NOMBRE DE PROFESSEURS:</th>
                                            <td><?php echo $row_rq_nbre_prof->tot_eleve; ?></td>
                                        </tr>

                                        <tr>
                                            <th>NOMBRE DE S&Egrave;RIES:</th>
                                            <td><?php echo $row_rq_filirre->nbre; ?></td>
                                        </tr>

                                        <tr>
                                            <th>NOMBRE DE SALLE DE CLASSE:</th>
                                            <td><?php echo $row_rq_nbr_salle_classe->nbre; ?></td>
                                        </tr>

                                    </table>
                                    <br/>

                                </fieldset>

                            </div>

                             <div class="col-lg-6">

                                 <fieldset class="cadre"><legend>EFFECTIF TOTAL</legend>
                                     <table width="100%"  border="0" cellpadding="0" cellspacing="3" class = "table table-striped">
                                         <tr>
                                             <th style="text-align: center !important;">NOMBRE TOTAL</th>
                                         </tr>
                                             <tr>
                                                 <td align="center"><?php echo $rs_totale->nbre; ?></td>
                                             </tr>
                                     </table>
                                     <br/><br/>
                                 </fieldset>
                                 <br/>


                                 <fieldset class="cadre"><legend>NOMBRE D'&Eacute;L&Egrave;VES INSCRITS PAR CLASSE</legend>


                                     <div class="container" style="width: 99% !important;">

                                         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                             <?php foreach ($rs_niv_classe as $lig) { ?>

                                             <div class="panel panel-default">
                                                 <div class="panel-heading" role="tab" id="collapse-heading-<?php echo $lig['ID']?>">
                                                     <a role="button" class="panel-link" data-toggle="collapse" data-parent="#accordion" href="#collapse-category-<?php echo $lig['ID']?>" aria-expanded="false" aria-controls="collapse-category-<?php echo $lig['ID']?>">
                                                         <?php echo $lig['LIBELLE']?>
                                                     </a>
                                                 </div>

                                                 <div class="panel-collapse collapse" id="collapse-category-<?php echo $lig['ID']?>" role="tabpanel" aria-labelledby="collapse-heading-<?php echo $lig['ID']?>">
                                                     <div class="panel-body">

                                                         <?php
                                                         $query_rq_eleve_par_classe = $dbh->query("SELECT COUNT(af.IDINDIVIDU) as nbre, c.LIBELLE  
                                                                    FROM AFFECTATION_ELEVE_CLASSE af 
                                                                    INNER JOIN CLASSROOM c ON af.IDCLASSROOM = c.IDCLASSROOM
                                                                    WHERE c.IDNIV = ".$lig['ID']." GROUP BY af.IDCLASSROOM");
                                                         $rs_cl = $query_rq_eleve_par_classe->fetchAll();
                                                         $row_count = $query_rq_eleve_par_classe->rowCount();
                                                         ?>

                                                         <?php if($row_count > 0) { ?>
                                                         <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">
                                                             <tr>
                                                                 <th>CLASSE</th>
                                                                 <th style="text-align: center !important;">NOMBRE</th>
                                                             </tr>
                                                             <?php

                                                             foreach($rs_cl as $row_cl) { ?>
                                                                 <tr>
                                                                     <td ><?php echo $row_cl['LIBELLE']; ?></td>
                                                                     <td align="center"><?php echo $row_cl['nbre']; ?></td>
                                                                 </tr>
                                                             <?php } ?>

                                                         </table>
                                                         <?php } else {?>

                                                             <table width="100%" border="0" cellspacing="3" cellpadding="0" class = "table table-striped">
                                                                 <tr>
                                                                     <th style="text-align: center !important;">Pas d'éléves inscrits</th>
                                                                 </tr>

                                                             </table>

                                                         <?php }?>

                                                     </div>
                                                 </div>
                                             </div>

                                            <?php } ?>

                                         </div>
                                     </div>

                                 </fieldset>
                             </div>
                     </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <fieldset class="cadre"><legend>SITUATION FINANCIERE</legend>
                                <?php
                                if(isset($_POST['IDANNEESSCOLAIRE']) && $_POST['IDANNEESSCOLAIRE']!='')
                                {
                                    $anScolaire= $lib->securite_xss($_POST['IDANNEESSCOLAIRE']);
                                }
                                else
                                {
                                    $anScolaire=$lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
                                }
                                $queryAnneScolaire=($dbh->query("SELECT IDANNEESSCOLAIRE, LIBELLE_ANNEESSOCLAIRE, DATE_DEBUT, DATE_FIN, ETAT, IDETABLISSEMENT 
                                                                           FROM ANNEESSCOLAIRE WHERE 
                                                                           IDETABLISSEMENT=".$etab));
                                $rs_anneScolaire = $queryAnneScolaire->fetchAll();
                                ?>

                                <br/>


                                <form id="form2" method="POST" action="accueil.php" class="form-inline" style="margin-bottom: 30px;">

                                    <div  class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                        <label for="nom" class="col-lg-3 col-sm-4 control-label">ANNEE SCOLAIRE </label>
                                        <div class="col-lg-9 col-sm-8">
                                            <select name="IDANNEESSCOLAIRE" id="selectIDANNEESSCOLAIRE" class="form-control selectpicker" data-live-search="true" style="width: 100%;!important;">
                                                <option value="">--Selectionner--</option>

                                                <?php  foreach($rs_anneScolaire as $row_rq_an) { ?>

                                                    <option value=" <?php echo $row_rq_an['IDANNEESSCOLAIRE']; ?>"><?php echo $row_rq_an['LIBELLE_ANNEESSOCLAIRE']; ?>  </option>

                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">

                                        <button type="submit" class="btn btn-primary" title="Rechercher" >Rechercher</button>
                                    </div>

                                </form>
                                <br/>

                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-hover">

                                    <thead>
                                        <tr>

                                            <th>&nbsp;&nbsp;</th>
                                            <th>SCOLARITES</th>
                                            <th>PAIEMENT PROFESSEUR</th>
                                            <th>PAIEMENT ADMINISTRATION</th>
                                            <th>DEPENSE</th>
                                            <th>SOLDES</th>

                                        </tr>
                                    </thead>


                                    <tbody>
                                    <?php
                                    $query_rq_mois = $dbh->query("SELECT MONTH(MENSUALITE.DATEREGLMT) as mois FROM MENSUALITE INNER JOIN INSCRIPTION ON INSCRIPTION.IDINSCRIPTION = MENSUALITE.IDINSCRIPTION  WHERE MENSUALITE.IDETABLISSEMENT = ".$etab."  AND INSCRIPTION.IDANNEESSCOLAIRE=".$anScolaire."  GROUP BY MONTH(MENSUALITE.DATEREGLMT)");
                                    $total_socalrite=0;
                                    $total_paiement_prof=0;
                                    $total_charge=0;

                                    foreach($query_rq_mois->fetchAll() as $row_rq_mois)
                                    {
                                        //TOTAL SCOLARITE
                                        $colname_rq_scolarite = $lib->securite_xss($_SESSION['etab']);
                                        $coldate_rq_scolarite = $row_rq_mois['mois'];
                                        $colname1_rq_scolarite = $anScolaire;

                                        $query_rq_scolarite = $dbh->query("SELECT SUM(MENSUALITE.MONTANT) as somme_verse FROM MENSUALITE INNER JOIN INSCRIPTION ON INSCRIPTION.IDINSCRIPTION = MENSUALITE.IDINSCRIPTION  WHERE  MENSUALITE.IDETABLISSEMENT = ".$colname_rq_scolarite."  AND  MONTH(MENSUALITE.DATEREGLMT)=".$coldate_rq_scolarite."  AND INSCRIPTION.IDANNEESSCOLAIRE=".$colname1_rq_scolarite);
                                        $row_rq_scolarite = $query_rq_scolarite->fetchObject();

                                        //PAIEMENT DES PROF
                                        $colname_rq_somme_prof = $row_rq_mois['mois'];
                                        $col_etab_rq_somme_prof = $lib->securite_xss($_SESSION['etab']);
                                        $col_anne_rq_somme_prof = $anScolaire;

                                        $query_rq_somme_prof = $dbh->query("SELECT SUM(REGLEMENT_PROF.MONTANT) AS SOMME_PROF FROM REGLEMENT_PROF INNER JOIN RECRUTE_PROF ON REGLEMENT_PROF.INDIVIDU=RECRUTE_PROF.IDINDIVIDU  WHERE  MONTH(REGLEMENT_PROF.DATE_REGLEMENT )= ".$colname_rq_somme_prof." AND RECRUTE_PROF.IDETABLISSEMENT=".$col_etab_rq_somme_prof." AND RECRUTE_PROF.IDANNEESSCOLAIRE=".$col_anne_rq_somme_prof);
                                        $row_rq_somme_prof = $query_rq_somme_prof->fetchObject();

                                        // AUTRES CHARGES
                                        $colname_rq_equipement = $lib->securite_xss($_SESSION['etab']);
                                        $col_mois_rq_equipement = $row_rq_mois['mois'];
                                        $col_ann_rq_equipement = $anScolaire;

                                        $query_rq_equipement = $dbh->query("SELECT SUM(REGLEMENT_PERSO.MONTANT) AS SOMME_PERSO FROM REGLEMENT_PERSO INNER JOIN UTILISATEURS ON REGLEMENT_PERSO.INDIVIDU=UTILISATEURS.idUtilisateur WHERE  MONTH(REGLEMENT_PERSO.DATE_REGLEMENT )= ".$col_mois_rq_equipement." AND REGLEMENT_PERSO.IDANNEESCOLAIRE=".$col_ann_rq_equipement);
                                        $row_rq_equipement = $query_rq_equipement->fetchObject();

                                        $colname_rq_depense = $lib->securite_xss($_SESSION['etab']);
                                        $col_mois_rq_depense = $row_rq_mois['mois'];
                                        $col_ann_rq_depense = $anScolaire;

                                        $query_rq_depense = $dbh->query("SELECT SUM(DEPENSE.MONTANT) AS DEPNSE FROM DEPENSE WHERE  MONTH(DEPENSE.DATE_REGLEMENT )= ".$col_mois_rq_depense."  AND  DEPENSE.IDANNEESCOLAIRE=".$col_ann_rq_equipement." AND  DEPENSE.IDETABLISSEMENT=".$colname_rq_depense);
                                        $row_rq_depense = $query_rq_depense->fetchObject();

                                        //DEPENSE ;
                                        $solde=$row_rq_scolarite->somme_verse -($row_rq_somme_prof->SOMME_PROF +$row_rq_depense->DEPNSE+$row_rq_equipement->SOMME_PERSO  );
                                        //CALCUL DES TOTAUX
                                        $total_socalrite+=$row_rq_scolarite->somme_verse;
                                        $total_paiement_prof+=$row_rq_somme_prof->SOMME_PROF;
                                        $total_charge+=$row_rq_equipement->SOMME_PERSO;
                                        $total_charge2+=$row_rq_depense->DEPNSE;
                                        ?>



                                        <tr>

                                            <th><?php echo $lib->Le_mois($row_rq_mois['mois']); ?></th>
                                            <td><?php echo $lib->nombre_form($row_rq_scolarite->somme_verse); ?></td>
                                            <td><?php echo $lib->nombre_form($row_rq_somme_prof->SOMME_PROF); ?></td>
                                            <td><?php echo $lib->nombre_form($row_rq_equipement->SOMME_PERSO); ?></td>
                                            <td><?php echo $lib->nombre_form($row_rq_depense->DEPNSE); ?></td>
                                            <td><?php echo $lib->nombre_form($solde); ?></td>


                                        </tr>
                                        <?php

                                    }  ?>
                                    <tr>
                                        <th>TOTAL</th>
                                        <th><?php echo $lib->nombre_form($total_socalrite); ?></th>
                                        <th><?php echo $lib->nombre_form($total_paiement_prof); ?></th>
                                        <th><?php echo $lib->nombre_form($total_charge); ?></th>
                                        <th><?php echo $lib->nombre_form($total_charge2); ?></th>
                                        <th><?php echo $lib->nombre_form($total_socalrite -($total_charge + $total_paiement_prof+$total_charge2)); ?></th>
                                    </tr>
                                    </tbody>
                                </table><br><br>

                            </fieldset>
                        </div>


                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

<?php include('footer.php'); ?>



		
        