<html>
<?php
include 'menu.php';



        $nbArticles=count($_SESSION['panier']);
        /*echo $nbArticles;
        $item=$_SESSION['panier'][0];

        //$item=array(,2);
        //array_push($_SESSION['panier'],$item);
        $str=$_SESSION['panier'][0];
        $str=implode($str);
        echo "liste".$str.'!';*/
        /*echo "id: ";
        echo $item[0];
        echo "quantite: ";
        echo $item[1];*/


        if ($nbArticles <= 0){
        echo "<tr><td>Votre panier est vide </ td></tr>";
        }
        else
        {
                ?><div id="content" >
               <?php
            for ($i=0 ;$i < $nbArticles ; $i++)
            {

                ?><div >
               <?php
                $item=$_SESSION['panier'][$i];
                //echo $str;
                $id=$item[0];
                //echo $id;
                $qte=$item[1];



                echo "<td> objet : ".$id."</ td>";
                echo "<td><input type=\"number\" size=\"1\" id=\"modific\" name=\"modific\" value=\"".$qte."\"/></td>";

                ?>
                <form action="supprpanier.php" method="post">
                <input type="hidden" name="id_item" value="<?php echo $id; ?>">
                <input type="submit" value="Supprimer du panier"/></form></div>
                <?php



            }

            ?>
            <form action="commander.php" method="post">
            <input type="hidden" name="id_item" value="" >
            <input type="submit" value="Commander"/></form>
            </div >
               <?php
        }
?>

<script>
    modific.oninput= function(){

        result.innerHTML = modific.value;

    };
</script>
</html>