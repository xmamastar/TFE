<?php
require('connexionbdd.php');
    session_start();
?>
<?php

//$_SESSION['test']=$_POST['id_item'];
$panier=$_SESSION['panier'];
$id_item=$_POST['id_item'];
$taille_panier=count($_SESSION['panier']);
    for($i=0;$i<$taille_panier;$i++){
        $item=$_SESSION['panier'][$i];
        if($item[0]==$id_item){
            echo "test";
            $qte_item = $item[1]-1;
            echo $qte_item;
            var_dump($panier);
            var_dump($item);
            $remplace = array(1 => $qte_item);
            var_dump($remplace);
            $newpa = array_replace($item, $remplace);
            var_dump($newpa);
            $panier=$newpa;
            //array_splice($panier, $i, 1, $newpa);
            var_dump($panier);
            $_SESSION['panier'][$i]=$panier;

        }


    }




header('Location: ' . $_SERVER['HTTP_REFERER']);


?>