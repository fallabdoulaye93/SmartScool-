<?php
/**
 * Created by PhpStorm.
 * User: developpeur2
 * Date: 07/10/2016
 * Time: 10:15
 */

require_once("../config/Connexion.php");
require_once("../config/Librairie.php");
$connection = new Connexion();
$dbh = $connection->Connection();
$lib = new Librairie();

extract($_POST);
unset($_POST);
$query = "SELECT MESSAGERIE.MESSAGE as message FROM MESSAGERIE WHERE MESSAGERIE.IDMESSAGERIE = " . $IDMSG;
$stmt = $dbh->prepare($query);
$stmt->execute();
$msg = $stmt->fetchAll(PDO::FETCH_OBJ);
echo($msg[0]->message);