<?php
try{

$bdd=new PDO('mysql:host=localhost;dbname=TFE;charset=utf8','root','tfe1234');

}
catch(Exception $e){

die("Erreur: ".$e->getMessage());
}
?>