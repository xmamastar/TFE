<?php
require('connexionbdd.php');
    session_start();
?>
<?php

$total=0;



        $nbArticles=count($_SESSION['panier']);
        $id_cli = $_SESSION['id'];
        $nom_client = $_SESSION['nom'];
        $com= date('ymdHis');
        $bon_com = $id_cli.$com;
        echo $bon_com;



        if ($nbArticles <= 0){
        echo "<tr><td>Votre panier est vide </ td></tr>";
        }
        else
        {
                ?><div id="content" >

               <?php
            for ($i=0 ;$i < $nbArticles ; $i++)
            {

                ?><div ><table class="table table-striped">
               <?php
                $item=$_SESSION['panier'][$i];
                //echo $str;
                $id=$item[0];
                //echo $id;
                $qte=$item[1];
                $reponse = $bdd->prepare('SELECT * FROM shop WHERE id_item = :id_item');
                    $reponse->execute(array(
                        'id_item' => $id));
                    $resultat =$reponse->fetch();
                    if (!$resultat){

                        echo $resultat['prix_item'];


                    }

                    $prix=$resultat['prix_item'];
                    $mul=$prix*$qte;
                    $total=$total+$mul;

                $rq1=$bdd->prepare('INSERT INTO commande(bon_com, id_item, qte_item, prix_item) VALUES(:bon_com, :id_item, :qte_item, :prix_item)');
                $rq1->execute(array(
                'bon_com' => $bon_com,
                'id_item' => $id,
                'qte_item' => $qte,
                'prix_item' => $resultat['prix_item']));

                unset($_SESSION['panier'][$i]);
            }

           $rq1=$bdd->prepare('INSERT INTO commandeadmin(bon_com, id_client, nom_client, date_com, prix) VALUES(:bon_com, :id_client, :nom_client, :date_com, :prix)');
           $rq1->execute(array(
           'bon_com' => $bon_com,
           'id_client' => $id_cli,
           'nom_client' => $nom_client,
           'date_com' => date('y-m-d'),
           'prix' => $total));

        }

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>