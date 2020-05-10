<?php
require('connexionbdd.php');
?>
<?php
    session_start();

?>
<?php
$id_item=$_POST['id_item'];

$query1="SELECT * FROM shop WHERE id_item = ?";
$query2="DELETE FROM shop WHERE id_item = ?";
    try{
        $rq1= $bdd->prepare($query1);
        $rq1->bindParam(1, $id_item, PDO::PARAM_STR);
        $rq1->execute();
        $donnees = $rq1->fetch();
        unlink('images/items/'. $donnees['img_item']);

        $rq1= $bdd->prepare($query2);
        $rq1->bindParam(1, $id_item, PDO::PARAM_STR);
        $rq1->execute();



    }
    catch(PDOException $e){
        echo 'Erreur SQL : '. $e->getMessage(). '<br/>';die();

    }


   header("location: shop.php?cat=all");

?>