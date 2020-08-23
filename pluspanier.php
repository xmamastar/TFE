<?php
require('connexionbdd.php');
    session_start();
?>
<?php

//$_SESSION['test']=$_POST['id_item'];





header('Location: ' . $_SERVER['HTTP_REFERER']);


?>