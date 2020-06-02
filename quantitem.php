<?php
require('connexionbdd.php');
?>
<?php
    session_start();

?>
<?php
$id_item=$_POST['id_item'];
$qte_item=$_POST['qte_item'];

    try{
        $rq=$bdd->prepare('UPDATE shop SET qte_item= :qte_item WHERE id_item=:id_item');
                $rq->execute(array(
                        'qte_item' => $qte_item,
                        'id_item'=>$id_item));


    }
    catch(PDOException $e){
        echo 'Erreur SQL : '. $e->getMessage(). '<br/>';die();

    }


   header('Location: ' . $_SERVER['HTTP_REFERER'].'#'.$id_item);

?>