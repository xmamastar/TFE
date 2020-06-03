<?php
require('connexionbdd.php');
    session_start();


$valeur = $_GET['val'];

echo $valeur;

$rq1=$bdd->prepare('UPDATE commandeadmin SET recu = 1 WHERE bon_com = :bon_com');
$rq1->execute(array(
'bon_com' => $valeur
));


header('Location: ' . $_SERVER['HTTP_REFERER']);

?>