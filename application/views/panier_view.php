<html>
<?php
include 'menu_view.php';
		$total=0;
        $nbArticles=count($_SESSION['panier']);
        if ($nbArticles <= 0){ ?>
        <div id="content" >
        <tr><td>Votre panier est vide </ td></tr></div><?php
        }
        else
        {
                ?><div id="content" >
                <h2> Votre Panier</h2>
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
                $resultat=$liste[$i];
 				 echo $resultat->prix_item;








                //echo "<td> objet : ".$id."</ td>";
                $url=base_url()."css/images/items/";
                ?>
                <td><?php echo $resultat->nom_item; ?></br><img class="rounded-sm" src=<?php echo $url.$resultat->img_item;?>></td>
                <td>Quantité : <?php echo $qte; ?>
                <?php
                    //echo "<td><input type=\"number\" size=\"1\" id=\"modific\" name=\"modific\" value=\"".$qte."\"/></td>";
                    $prix=$resultat->prix_item;
                    $mul=$prix*$qte;
                    $total=$total+$mul;
                ?>
                <form action="plus_panier" method="post">
                <input type="hidden" name="id_item" value="<?php echo $id; ?>">
                <input type="submit" value="+"/></form>
                <form action="moins_panier" method="post">
                <input type="hidden" name="id_item" value="<?php echo $id; ?>">
                <input type="submit" value="-"/></form></td>
                <td> prix unité: <?php echo $resultat->prix_item; ?>€</td>
                <td> prix du lot: <?php echo $mul; ?>€</td>
                <td><form action="suppr_panier" method="post">
                <input type="hidden" name="id_item" value="<?php echo $id; ?>">
                <input type="submit" value="Supprimer du panier"/></form></td></div>
                <?php



            }

            ?>
            </table>
            <h4>Total du panier : <?php echo $total; ?>€</h4>
            <form action="commander" method="post">
            <input type="hidden" name="id_item" value="" >
            <input type="hidden" name="qte_item" value="">
            <inpute type="hidden" name="prix_item" value="">
            <input type="submit" value="Commander"/></form>
            </div >
               <?php
        }
?>


</html>
