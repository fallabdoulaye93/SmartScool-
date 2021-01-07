<?php
if (isset($_POST) && $_POST != null) {
    session_start();
    $_SESSION['ANNEESSCOLAIRE'] = intval($_POST['idannee']);
    if ($_SESSION['ANNEESSCOLAIRE'] == $_POST['idannee']) {
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
}
