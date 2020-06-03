<?php
try{

$bdd=new PDO('mysql:host=localhost;dbname=TFE;charset=utf8','root','bdTennisTFE');

}
catch(Exception $e){

die("Erreur: ".$e->getMessage());
}
?>