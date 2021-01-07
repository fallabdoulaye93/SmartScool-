<?php
    session_start();
    require_once("../config/Connexion.php");
    require_once("../config/Librairie.php");
    $connection = new Connexion();
    $dbh = $connection->Connection();
    $lib = new Librairie();

    if ($_SESSION['profil'] != 1)
        $lib->Restreindre($lib->Est_autoriser(21, $_SESSION['profil']));

    $colname_rq_mensualite = "-1";
    if (isset($_SESSION['etab'])) {
        $colname_rq_mensualite = $lib->securite_xss($_SESSION['etab']);
    }

    $idAnnescolaire = "-1";
    if (isset($_SESSION['ANNEESSCOLAIRE'])) {
        $idAnnescolaire = $lib->securite_xss($_SESSION['ANNEESSCOLAIRE']);
    }

    if(isset($_GET) && $_GET != '')
    {
        $indivClass = array();
        $idclassroom = "-1";
        if (isset($_GET['idclassroom']))
        {
            $idclassroom = $lib->securite_xss(base64_decode($_GET['idclassroom'])) ;
        }
        $idperiode = "-1";
        if (isset($_GET['idperiode']))
        {
            $idperiode = $lib->securite_xss(base64_decode($_GET['idperiode'])) ;
        }

        $greatQuery = $dbh->query("SELECT DISTINCT CLASSROOM.IDNIVEAU, CLASSROOM.IDSERIE, COEFFICIENT.COEFFICIENT, COEFFICIENT.IDMATIERE, CONTROLE.IDCONTROLE, CONTROLE.IDTYP_CONTROL 
                                            FROM CLASSROOM 
                                            INNER JOIN COEFFICIENT ON CLASSROOM.IDNIVEAU = COEFFICIENT.IDNIVEAU 
                                            INNER JOIN MATIERE ON MATIERE.IDMATIERE = COEFFICIENT.IDMATIERE 
                                            INNER JOIN CONTROLE ON COEFFICIENT.IDMATIERE = CONTROLE.IDMATIERE 
                                            INNER JOIN SERIE ON CLASSROOM.IDSERIE = SERIE.IDSERIE 
                                            WHERE CLASSROOM.IDCLASSROOM = '".$idclassroom."' 
                                            AND CONTROLE.IDTYP_CONTROL = 2 
                                            AND CONTROLE.VALIDER = 1 
                                            AND CONTROLE.IDPERIODE = '".$idperiode."'");

        $matieres = array();
        $matieres_id = array();

        while ($matiere = $greatQuery->fetchObject()){
            $matieres[] = $matiere;
        }

        for ($i=0;$i<count($matieres);$i++){
            $matieres_id[]=$matieres[$i]->IDMATIERE;
        }
        $matieres_id = array_values(array_unique($matieres_id)) ;

        $query_periode = $dbh->query("SELECT NOM_PERIODE FROM PERIODE WHERE IDPERIODE=".$idperiode);
        $query_result_periode = $query_periode->fetchObject();
        $nom_periode = $query_result_periode->NOM_PERIODE;

        $query_annee = $dbh->query("SELECT LIBELLE_ANNEESSOCLAIRE FROM `ANNEESSCOLAIRE` WHERE `IDANNEESSCOLAIRE`=".$idAnnescolaire);
        $query_result_annee = $query_annee->fetchObject();
        $nom_annee = $query_result_annee->LIBELLE_ANNEESSOCLAIRE;

        $query_Indiv = $dbh->query("SELECT IDINDIVIDU FROM `AFFECTATION_ELEVE_CLASSE` WHERE IDCLASSROOM=".$idclassroom);
        while ($query_Indiv_result = $query_Indiv->fetchObject()) {
            array_push($indivClass, $query_Indiv_result->IDINDIVIDU);
        }

        function myfunction(&$value,$key)
        {
            require_once("../config/Connexion.php");
            $connection = new Connexion();
            $dbh = $connection->Connection();
            $sql = "SELECT MATIERE, COEF, COMPO1 FROM `DETAIL_BULLETIN` WHERE `FK_BULLETIN` =".$value['ROWID'];
            $query = $dbh->query($sql);
            $value['DETAIL_MATIERE'] = array();
            while($q = $query->fetchObject()){
                $value['DETAIL_MATIERE'][$q->MATIERE] = $q;
            }
        }

        for($i=0;$i<count($indivClass);$i++)
        {
            $query_Indiv_civilite = $dbh->query("SELECT I.PRENOMS, I.NOM, I.MATRICULE, I.DATNAISSANCE, C.LIBELLE, B.ROWID, B.TOTAL_COEF, B.TOTAL_POINT, B.MOYENNE_SEM AS MOY_GENE, B.RANG, B.IDINDIVIDU
                                                            FROM INDIVIDU I 
                                                            INNER JOIN BULLETIN B ON  I.IDINDIVIDU = B.IDINDIVIDU
                                                            INNER JOIN CLASSROOM C ON C.IDCLASSROOM = B.IDCLASSROOM
                                                            WHERE B.IDCLASSROOM =".$idclassroom." 
                                                            AND B.IDPERIODE =".$idperiode." 
                                                            AND B.IDANNEE =".$idAnnescolaire." 
                                                            AND B.IDINDIVIDU =".$indivClass[$i]." 
                                                            AND B.IDETABLISSEMENT =".$colname_rq_mensualite);

            $query_Indiv_civilite_result = $query_Indiv_civilite->fetchObject();

            $req_check = $dbh->query("SELECT ROWID, TOTAL_COEF, TOTAL_POINT, MOYENNE_SEM, RANG, IDPERIODE
                                                FROM BULLETIN 
                                                WHERE IDINDIVIDU='".$indivClass[$i]."' 
                                                AND IDCLASSROOM='".$idclassroom."' 
                                                AND IDANNEE='".$idAnnescolaire."' 
                                                AND IDETABLISSEMENT='".$colname_rq_mensualite."' 
                                                GROUP BY IDPERIODE");
           $tab = array();

            while ($res = $req_check->fetchObject()){
                $tab_bul = array();
                $tab_bul['ROWID'] = $res->ROWID;
                $tab_bul['TOTAL_COEF'] = $res->TOTAL_COEF;
                $tab_bul['TOTAL_POINT'] = $res->TOTAL_POINT;
                $tab_bul['MOYENNE_SEM'] = $res->MOYENNE_SEM;
                $tab_bul['RANG'] = $res->RANG;
                $tab[$res->IDPERIODE]= $tab_bul;
           }

            array_walk($tab,myfunction);

            $total_Base = 0;
            $total_Compo1 = 0;
            $total_Compo = 0;
            $total_Compo = 0;
            $total_Somme_Moyenne = 0;
            $somme_array = array();
            ?>

            <style>
                .title {
                    border: solid 1px #0a0a0a;
                    text-align: center !important;
                    padding: 7px 0px 7px 0px !important;
                    margin: 3px 0px 0px 0px !important;
                }

                .sousTitle {
                    border-top: solid 0.5px #0a0a0a !important;
                    border-bottom: solid 0.5px #0a0a0a !important;
                    border-right: solid 0.5px #0a0a0a !important;
                    border-left: solid 0.5px #0a0a0a !important;
                }

                .sousTitleCenter {
                    text-align: center !important;
                }
                td {
                    padding: 2px;
                }
            </style>
            <page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
                <page_header>
                    <strong style="text-align: center !important;">ANNEE SCOLAIRE : <?php echo $nom_annee; ?></strong>
                </page_header>

                <table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>

                    <tr>
                        <td align="left" valign="top" class="Titre"><img src="../logo_etablissement/<?php echo $_SESSION['LOGO']; ?>" height="60" /></td>
                        <td colspan="3" align="center" valign="middle">

                        </td>
                        <td colspan="3" align="center" style="font-size: 10px !important; text-align: center !important">
                            <strong><?php echo $_SESSION['SIGLE']; ?></strong><br/>
                            <?php echo $_SESSION['nomEtablissement']; ?><br/>
                            <strong>BP :</strong> <?php echo $_SESSION['BP']; ?> - <strong>Tél: </strong><?php echo $_SESSION['TELEPHONEETAB']; ?><br/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="10" align="center" valign="middle" class="title"><strong>COMPOSITION DU : </strong> <?php echo strtoupper($nom_periode) ;?> </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <tr>
                        <td width="32%">
                            <?php echo '<strong>Prénom et Nom: </strong>'.$query_Indiv_civilite_result->PRENOMS.' '.$query_Indiv_civilite_result->NOM; ?>
                        </td>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="3" align="right">
                            <?php echo '<strong>Matricule : </strong>'. $query_Indiv_civilite_result->MATRICULE ;?>
                        </td>
                    </tr>
                    <tr>
                        <td width="32%">
                            <?php echo '<strong>Classe de : </strong>'. $query_Indiv_civilite_result->LIBELLE; ?>
                        </td>
                        <td colspan="3"></td>
                        <td colspan="3" align="right">
                            <?php echo '<strong>Date de Naissance : </strong>'. $lib->date_franc($query_Indiv_civilite_result->DATNAISSANCE) ;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="sousTitle sousTitleCenter"><strong>Matieres</strong></td>
                        <td class="sousTitle" width="7%"  align="center" valign="middle" nowrap="nowrap"><strong>Base</strong></td>
                        <td class="sousTitle" width="8%" align="center" valign="middle" nowrap="nowrap"><strong>Compo 1</strong></td>
                        <td class="sousTitle" width="7%"  align="center" valign="middle" nowrap="nowrap"><strong>Compo 2</strong></td>
                        <td class="sousTitle" width="6%" align="center" valign="middle" nowrap="nowrap"><strong>Compo 3</strong></td>
                        <td class="sousTitle" colspan="5" align="center" valign="middle" nowrap="nowrap"></td>
                    </tr>

                    <?php
                    for($j = 0; $j < count($matieres_id); $j++){
                        $queryMatiere = $dbh->query("SELECT LIBELLE, BASE_NOTES, IDMATIERE FROM MATIERE WHERE IDMATIERE =".$matieres_id[$j]);
                        $q = $queryMatiere->fetchObject();
                        ?>

                        <tr>
                            <td class="sousTitle">
                                <?php
                                echo $q->LIBELLE;
                                ?>
                            </td>
                            <td class="sousTitle" align="center" valign="middle" class="sousTitle">
                                <?php echo $q->BASE_NOTES; $total_Base+=$q->BASE_NOTES; ?>
                            </td>
                            <td class="sousTitle" align="center" align="center" valign="middle" nowrap="nowrap">
                                <?php
                                foreach ($tab as $t => $tt){
                                    echo $t == 1 ?   number_format((float)$tt['DETAIL_MATIERE'][$q->IDMATIERE]->COMPO1, 2, '.', '')  : '';
                                }
                                ?>
                            </td>
                            <td class="sousTitle" align="center" align="center" valign="middle" nowrap="nowrap">
                                <?php
                                foreach ($tab as $t => $tt){
                                    echo $t == 2 ?   number_format((float)$tt['DETAIL_MATIERE'][$q->IDMATIERE]->COMPO1, 2, '.', '')  : '';
                                }
                                ?>
                            </td>
                            <td class="sousTitle" align="center" align="center" valign="middle" nowrap="nowrap">
                                <?php
                                foreach ($tab as $t => $tt){
                                    echo $t == 3 ?   number_format((float)$tt['DETAIL_MATIERE'][$q->IDMATIERE]->COMPO1, 2, '.', '')  : '';
                                }
                                ?>
                            </td>
                            <td class="sousTitle" colspan="5" align="center" valign="middle">&nbsp;</td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td class="sousTitle" align="right">
                            TOTAL
                        </td>
                        <td class="sousTitle" align="center" valign="middle" class="sousTitle">
                            <?php echo $total_Base; ?>
                        </td>
                        <?php
                        foreach ($tab as $t => $tt){
                            $somme = 0;
                            if ($t == 1){
                                for($k = 0; $k < count($matieres_id); $k++){
                                    $somme+=$tt['DETAIL_MATIERE'][$matieres_id[$k]]->COMPO1;
                                }
                                array_push($somme_array,$somme);
                            }
                            if ($t == 2){
                                for($l = 0; $l < count($matieres_id); $l++){
                                    $somme+=$tt['DETAIL_MATIERE'][$matieres_id[$l]]->COMPO1;
                                }
                                array_push($somme_array,$somme);
                            }
                            if ($t == 3){
                                for($m = 0; $m < count($matieres_id); $m++){
                                    $somme+=$tt['DETAIL_MATIERE'][$matieres_id[$m]]->COMPO1;
                                }
                                array_push($somme_array,$somme);
                            }
                        }
                        ?>
                        <td class="sousTitle" align="center" align="center" valign="middle" nowrap="nowrap">
                            <?php
                            if($somme_array[0] != null){
                                echo number_format((float)$somme_array[0], 2, '.', '') ;
                            }
                            ?>
                        </td>
                        <td class="sousTitle" align="center" align="center" valign="middle" nowrap="nowrap">
                            <?php
                            if($somme_array[1] != null){
                                echo number_format((float)$somme_array[1], 2, '.', '') ;
                            }
                            ?>
                        </td>
                        <td class="sousTitle" align="center" align="center" valign="middle" nowrap="nowrap">
                            <?php
                            if($somme_array[2] != null){
                                echo number_format((float)$somme_array[2], 2, '.', '') ;
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="sousTitle" align="left" valign="middle"><strong>TOTAL COEFFICIENTS</strong></td>
                        <td class="sousTitle" colspan="3" align="center" valign="middle"><?php echo $query_Indiv_civilite_result->TOTAL_COEF;?></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="sousTitle" align="left" valign="middle"><strong>TOTAL POINTS</strong></td>
                        <td class="sousTitle" colspan="3" align="center" valign="middle">
                            <?php
                            $last = end($tab);
                            echo number_format((float)$last['TOTAL_POINT'], 2, '.', '');
                            ?>
                        </td>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <?php
                    foreach ($tab as $t => $tt){
                        $total_Somme_Moyenne+= $tt['MOYENNE_SEM']; ?>
                        <tr>
                            <td class="sousTitle" align="left" valign="middle"><strong>MOYENNE COMPO <?php echo $t ;?></strong></td>
                            <td class="sousTitle" colspan="3" align="center" valign="middle"><?php echo number_format((float)$tt['MOYENNE_SEM'], 2, '.', '') ;?></td>
                            <td colspan="3">&nbsp;</td>
                        </tr>

                    <?php } if (count($tab) == 3){ ?>

                        <tr>
                            <td class="sousTitle" align="left" valign="middle"><strong>MOYENNE ANNUELLE /10</strong></td>
                            <td class="sousTitle" colspan="3" align="center" valign="middle"><?php echo number_format((float)($total_Somme_Moyenne / count($tab)), 2, '.', '') ;?></td>
                            <td colspan="3">&nbsp;</td>
                        </tr>

                    <?php }  ?>

                    <?php if(count($tab) < 3){ ?>
                        <tr>
                            <td class="sousTitle" align="left" valign="middle"><strong>RANG DE L'ELEVE</strong></td>
                            <td class="sousTitle" colspan="3" align="center" valign="middle"> <?php echo $query_Indiv_civilite_result->RANG ; ?></td>
                            <td colspan="3">&nbsp;</td>
                        </tr>

                    <?php }elseif (count($tab) == 3){ ?>

                        <tr>
                            <td class="sousTitle" align="left" valign="middle"><strong>RANG ANNUEL DE L'ELEVE</strong></td>
                            <td class="sousTitle" colspan="3" align="center" valign="middle"> 2</td>
                            <td colspan="3">&nbsp;</td>
                        </tr>

                    <?php } ?>



                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>


                    <tr>
                        <td class="sousTitle" align="center" valign="middle"><strong>Appreciation du travail</strong></td>
                        <td colspan="1" rowspan="7" align="center" valign="middle">&nbsp;</td>
                        <td class="sousTitle" colspan="3" align="center" valign="middle"><strong>Conduite</strong></td>
                        <td colspan="1" rowspan="7" align="center" valign="middle"></td>
                        <td class="sousTitle" colspan="1"  align="center" valign="middle"><strong>Decision conseil</strong></td>
                    </tr>



                    <tr>
                        <td class="sousTitle" align="left" valign="middle">Félicitations</td>
                        <td class="sousTitle" colspan="3" align="left" valign="middle">Trés bonne</td>
                        <td class="sousTitle" align="left" valign="middle">Passe en Classe Sup</td>
                    </tr>

                    <tr>
                        <td class="sousTitle" align="left" valign="middle">Encouragement</td>
                        <td class="sousTitle" colspan="3" align="left" valign="middle">Bonne</td>
                        <td class="sousTitle" align="left" valign="middle">Autorisé(e) à redoubler</td>
                    </tr>

                    <tr>
                        <td class="sousTitle" align="left" valign="middle">Tableau d'honneur</td>
                        <td class="sousTitle" colspan="3" align="left" valign="middle">A améliorer</td>
                        <td class="sousTitle" align="left" valign="middle">Cours de Vacances obligatoire</td>
                    </tr>

                    <tr>
                        <td class="sousTitle" align="left" valign="middle">Moyen</td>
                        <td class="sousTitle" colspan="3" align="left" valign="middle">Avertissement</td>
                        <td class="sousTitle" align="left" valign="middle">Non repris</td>
                    </tr>

                    <tr>
                        <td class="sousTitle" align="left" valign="middle">Insuffisant</td>
                        <td class="sousTitle" colspan="3" align="left" valign="middle">Blame</td>
                        <td colspan="2" rowspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="sousTitle" align="left" valign="middle">Peut mieux faire</td>
                        <td class="sousTitle" colspan="3" align="left" valign="middle">Risque l'exclusion</td>
                    </tr>

                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left" valign="middle"></td>
                        <td colspan="3" align="left" valign="middle"><strong>LA DIRECTION</strong></td>
                    </tr>

                    </tbody>
                </table>
            </page>


        <?php }
    }
?>


