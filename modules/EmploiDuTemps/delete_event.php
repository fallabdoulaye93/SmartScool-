<?php
$id = $_POST['id'];
try {
$bdd = new PDO("mysql:host=mysql.samaecole-labs.com;dbname=samaecolelabscom230", 'sunuecoledb', '68qb5JmA');
} catch(Exception $e) {
exit('Unable to connect to database.');
}
$sql = "DELETE from evenement WHERE id=".$id;
$q = $bdd->prepare($sql);
$q->execute();
?>
