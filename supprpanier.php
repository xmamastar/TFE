<?php
require('connexionbdd.php');
    session_start();
?>
<?php

//$_SESSION['test']=$_POST['id_item'];
$id_item=$_POST['id_item'];
$taille_panier=count($_SESSION['panier']);
    for($i=0;$i<$taille_panier;$i++){
        $panier=$_SESSION['panier'];
        $item=$_SESSION['panier'][$i];
        if($item[0]==$id_item){
            echo "test";
            var_dump($panier);
            array_splice ($panier , $i, 1);
            //array_splice($_SESSION['panier'][$i]);
            var_dump($panier);
            $_SESSION['panier']=$panier;
        }


    }



header("location: panier.php");


?>