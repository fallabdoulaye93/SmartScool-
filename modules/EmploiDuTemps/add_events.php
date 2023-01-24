<?php
// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// connection to the database
try {
$bdd = new PDO("mysql:host=mysql-layefall93.alwaysdata.net;dbname=layefall93_scool", "221763_root", "layeFALL93");
} catch(Exception $e) {
exit('Unable to connect to database.');
}

// insert the records
$sql = "INSERT INTO evenement (title, start, end) VALUES (:title, :start, :fin )";
$q = $bdd->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':fin'=>$end));
?>
