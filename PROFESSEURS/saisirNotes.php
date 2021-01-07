<?php
include('header.php');

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

if (isset($_GET['IDCLASSROOM']) && isset($_GET['IDCONTROLE'])) {

    $query = "SELECT INDIVIDU.IDINDIVIDU as id,INDIVIDU.MATRICULE as matri,INDIVIDU.PRENOMS as prenom,INDIVIDU.NOM as nom,INDIVIDU.DATNAISSANCE as datNaiss,CLASSROOM.LIBELLE as libclass,NOTE.IDNOTE as idNote,NOTE.NOTE as note
              FROM INDIVIDU
              INNER JOIN AFFECTATION_ELEVE_CLASSE ON INDIVIDU.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
              INNER JOIN CLASSROOM ON AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM
              INNER JOIN NOTE ON INDIVIDU.IDINDIVIDU = NOTE.IDINDIVIDU
              WHERE NOTE.IDCONTROLE = " . $_GET['IDCONTROLE'] . " AND CLASSROOM.IDCLASSROOM = " . $_GET['IDCLASSROOM'] . "
              ORDER BY INDIVIDU.NOM ASC";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $tabElev = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (count($tabElev) == 0) {
        $query = "SELECT INDIVIDU.IDINDIVIDU as id,INDIVIDU.MATRICULE as matri,INDIVIDU.PRENOMS as prenom,INDIVIDU.NOM as nom,INDIVIDU.DATNAISSANCE as datNaiss,CLASSROOM.LIBELLE as libclass
                  FROM INDIVIDU
                  INNER JOIN AFFECTATION_ELEVE_CLASSE ON INDIVIDU.IDINDIVIDU = AFFECTATION_ELEVE_CLASSE.IDINDIVIDU
                  INNER JOIN CLASSROOM ON AFFECTATION_ELEVE_CLASSE.IDCLASSROOM = CLASSROOM.IDCLASSROOM
                  WHERE CLASSROOM.IDCLASSROOM = " . $_GET['IDCLASSROOM'] . "
                  ORDER BY INDIVIDU.NOM ASC";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $tabElev = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
} else {
    header("Location:publierNotes.php?msg=Notes ajoutés avec succes&res=1");
}
//echo "<pre>";var_dump($tabElev);exit;
?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Professeur</a></li>
    <li class="active">Saisir notes</li>
</ul>
<!-- END BREADCRUMB -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">

                <?php if (isset($_GET['msg']) && $_GET['msg'] != '') {

                    if (isset($_GET['res']) && $_GET['res'] == 1) {
                        ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"
                                                            aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    if (isset($_GET['res']) && $_GET['res'] != 1) {
                        ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                                           aria-label="close">&times;</a>
                            <?php echo $_GET['msg']; ?></div>
                    <?php }
                    ?>

                <?php } ?>

                <div>
                    <h4 style="color:#E05D1F;">Liste des eleves de la classe : <?= str_replace("-"," ",$_GET['libclass']); ?></h4>
                </div>
                <form id="form1" name="form1" onsubmit="return valideForm();">
                    <table id="customers2" class="table datatable table-condensed table-radius table-striped">
                        <thead>
                        <tr>
                            <th width="5%">&nbsp;</th>
                            <th width="18%">MATRICULE</th>
                            <th width="30%">PRENOMS</th>
                            <th width="17%">NOM</th>
                            <th width="20%">DATE DE NAISSANCE</th>
                            <th width="10%">NOTES / 20</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($tabElev) && count($tabElev) > 0) {
                            foreach ($tabElev as $oneElev) { ?>
                                <tr>
                                    <td align="center">
                                        <!--<img src="../imgtiers/imgDefaultIndividu.jpg" width="31px" height="39px"/>-->
                                        <img src="../imgtiers/imgDefaultIndividu.jpg" width="21px" height="25px"/>
                                    </td>
                                    <td><?php echo $oneElev->matri; ?></td>
                                    <td><?php echo $oneElev->prenom; ?></td>
                                    <td><?php echo $oneElev->nom; ?></td>
                                    <td><?php echo str_replace("-", "/", $lib->date_fr($oneElev->datNaiss)); ?></td>
                                    <td>
                                        <?php if (isset($oneElev->note)) { ?>
                                            <input style="width: 50px;" value="<?= $oneElev->note; ?>" class="form-control"
                                                   onchange="insertNotesEleve('<?= "_Upd-" . $oneElev->idNote; ?>');"
                                                   id="<?= "_Upd-" . $oneElev->idNote; ?>" type="text">
                                        <?php } else { ?>
                                            <input style="width: 50px;" value="0" class="form-control"
                                                   onchange="insertNotesEleve('<?= $oneElev->id; ?>');"
                                                   id="<?= $oneElev->id; ?>" type="text">
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-offset-5 col-lg-1">
                            <button type="submit" class="btn btn-success"
                                    onclick="postForm('<?= $_GET['IDCONTROLE']; ?>','<?= $_SESSION["etab"]; ?>','<?= $_GET['IDCLASSROOM']; ?>');"
                                    value="modifier">Valider
                            </button>
                        </div>
                    </div>
                </form>
                <style>
                    .invalide {
                        box-shadow: 0 0 1em red;
                    }
                </style>
                <script>
                    var tabNote = [];

                    function insertNotesEleve(idEleve) {
                        var note = $("#" + idEleve);
                        if (isNaN(parseFloat(note[0].value)) || parseFloat(note[0].value) > 20) {
                            alert("Veillez saisir une note valide !");
                            note.addClass("invalide");
                        } else {
                            note.removeClass("invalide");
                            note = parseFloat(note[0].value);
                            if (tabNote.length == 0 || !updateIfExist(idEleve, note)) {
                                tabNote.push(idEleve + "-" + note);
                            }
                        }
                    }

                    function updateIfExist(idEleve, note) {
                        for (var i = 0; i < tabNote.length; i++) {
                            if (tabNote[i].startsWith(idEleve)) {
                                tabNote[i] = idEleve + "-" + note;
                                return true;
                            }
                        }
                        return false;
                    }
                    function postForm(idCont, idEtab, idClass) {
                        if ($(".invalide").length == 0 && tabNote.length != 0) {
                            if (tabNote[0].startsWith("_Upd")) {
                                $.ajax({
                                    type: "POST",
                                    url: "enregistrerNotes.php?IDCONTROLE=" + idCont + "&IDETAB=" + idEtab + "&IDCLASS=" + idClass + "&ETAT=UPDATE",
                                    data: "tabNote=" + tabNote.toString(),
                                    success: function (data) {
//                                        alert(data)
                                    }
                                });
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: "enregistrerNotes.php?IDCONTROLE=" + idCont + "&IDETAB=" + idEtab + "&IDCLASS=" + idClass + "&ETAT=INSERT",
                                    data: "tabNote=" + tabNote.toString(),
                                    success: function (data) {
//                                        alert(data)
                                    }
                                });
                            }
                        }
                    }
                    function valideForm (){
                        if ($(".invalide").length == 0) {
                            return true;
                        }else{
                            alert("Un ou plusieurs champs sont invalides !");
                            return false;
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
</div>

<?php include('footer.php'); ?>
