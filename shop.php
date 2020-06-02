<html>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">
    </head>

    <body>
        <?php

           include 'menu.php';
           require('connexionbdd.php');
           $_SESSION['cat']=$_GET['cat'];


        ?>
        <div id="content" class="row row-cols-4">
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1 ){ ?>
                    <a href="ajoutitem.php"><button >Ajouter un nouvel objet à la boutique</button></a>
            <?php   }?>
        <ul class="category">
            <li><a href="shop.php?cat=raquette" >Raquette de tennis</a></li>
            <li><a href="shop.php?cat=vetement">Vêtements de tennis</a></li>
            <li><a href="shop.php?cat=chaussure">Chaussures de tennis</a></li>
            <li><a href="shop.php?cat=sac">Sac de tennis</a></li>
            <li><a href="shop.php?cat=balle">Balles de tennis</a></li>
            <li><a href="shop.php?cat=autre">Autres</a></li>
            <li><a href="panier.php">Panier</a></li>

        </ul>

        <div>
            <?php

                $reponse = $bdd->query('SELECT * FROM shop');

                while ($donnees = $reponse->fetch()){

                    if($_SESSION['cat']=="all"){

                        ?><div class="col" id=<?php echo $donnees['id_item'] ?>>
                        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1 ){ ?>
                        <form action="suppritem.php" method="post">
                        <input type="hidden" name="id_item" value="<?php echo $donnees['id_item'] ?>">
                        <input type="submit" value="Supprimer"/></form>
                        <form action="quantitem.php" method="post">
                        <input type="hidden" name="id_item" value="<?php echo $donnees['id_item'] ?>">
                        <input type="number" name="qte_item" value="<?php echo $donnees['qte_item'] ?>">
                        <input type="submit" value="Modif Qte"/></form>

                        <?php } ?>

                        <a class="aitem" href="shop.php?cat=<?php echo $donnees['id_item'] ?>" >
                        <?php

                            echo '<img src=images/items/'.$donnees['img_item'].'>'.'<br>';
                            echo $donnees['nom_item'].'<br>';
                            echo $donnees['prix_item']."€".'<br>';
                            if($donnees['qte_item']==0)
                            {
                                echo "Rupture de stock".'<br>';
                            }

                        ?></a>
                        <form action="ajoutpanier.php" method="post">
                         <input type="hidden" name="id_item" value="<?php echo $donnees['id_item'] ?>">
                         <input type="submit" value="Ajouter au panier"/></form></div><?php
                    }
                    if($donnees['cat_item']==$_SESSION['cat']){
                        ?><div class="item" id=<?php echo $donnees['id_item'] ?>>
                        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1 ){ ?>
                        <form action="suppritem.php" method="post">
                        <input type="hidden" name="id_item" value="<?php echo $donnees['id_item'] ?>">
                        <input type="submit" value="Supprimer"/></form>
                        <form action="quantitem.php" method="post">
                        <input type="hidden" name="id_item" value="<?php echo $donnees['id_item'] ?>">
                        <input type="number" name="qte_item" value="<?php echo $donnees['qte_item'] ?>">
                        <input type="submit" value="Modif Qte"/></form>
                        <?php } ?>

                        <a class="aitem" href="shop.php?cat=<?php echo $donnees['id_item'] ?>" ><?php
                            echo '<img src=images/items/'.$donnees['img_item'].'>'.'<br>';
                            echo $donnees['nom_item'].'<br>';
                            echo $donnees['prix_item']."€".'<br>';
                            if($donnees['qte_item']==0)
                            {
                                echo "Rupture de stock".'<br>';
                            }
                            
                        ?></a>
                        <form action="ajoutpanier.php" method="post">
                        <input type="hidden" name="id_item" value="<?php echo $donnees['id_item'] ; ?>">
                        <input type="submit" value="Ajouter au panier"/></form></div><?php
                    }
                    if($donnees['id_item']==$_SESSION['cat']){
                        echo '<h2>'.$donnees['nom_item'].'</h2>'.'<br>';
                        echo '<img src=images/items/'.$donnees['img_item'].'>'.'<br>';
                        echo $donnees['descri_item'].'<br>';
                        echo $donnees['prix_item']."€".'<br>';
                        if($donnees['qte_item']==0)
                        {
                            echo "Rupture de stock";
                        }
                    }
                }
            ?>
        </div>

        </div>
        <script src="js/jquery-3.4.1.min.js">
                $(".suppr").click(function(){


                })
                </script>

    </body>
</html>
