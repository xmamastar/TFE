<?php
require('connexionbdd.php');
    session_start();
?>
<?php

//$_SESSION['test']=$_POST['id_item'];
$id_item=$_POST['id_item'];
$qte_item=1;
$is_in_panier=false;
$count=0;
$taille_panier=count($_SESSION['panier']);

if ($taille_panier>0){

    for($i=0;$i<$taille_panier;$i++){
        $item=$_SESSION['panier'][$i];
        if($item[0]==$id_item){

            $qte_item=$item[1];
            $_SESSION['test']=$item[0];
            $_SESSION['test1']=$item[1];

            $is_in_panier=true;
            $count=$i;
        }

    }
    if ($is_in_panier==true)
          {

            $item=array();
            $qte_item+=1;
            array_push($item,$id_item);
            array_push($item,$qte_item);
            $_SESSION['panier'][$count]=$item;
            //array_push($_SESSION['panier'],$item);
            //$_SESSION['panier'][$positionProduit] = $_SESSION['panier']['qte'][$positionProduit] + $qte_item ;
          }
    else
          {
             //Sinon on ajoute le produit

            $item=array();
            array_push($item,$id_item);
            array_push($item,$qte_item);
            $qte_item=1;
            array_push($_SESSION['panier'],$item);
          }

          header("location: shop.php?cat=all");
}


else{
             //Sinon on ajoute le produit
            $qte_item=1;
            $item=array();
            array_push($item,$id_item);
            array_push($item,$qte_item);
            $_SESSION['test']=$id_item;
             $_SESSION['test1']=$qte_item;
            array_push($_SESSION['panier'],$item);
          }

header('Location: ' . $_SERVER['HTTP_REFERER'].'#'.$id_item);


?>