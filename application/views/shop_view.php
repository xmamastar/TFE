<html>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">
    </head>

    <body>
        <?php

           include 'menu_view.php';
           if(isset($_GET['cat'])){
           		$cat=htmlspecialchars($_GET['cat']);
           		$_SESSION['cat']=$cat;

           }
           else{
           		$_SESSION['cat']='all';
           }



        ?>
        <div id="content" class="row row-cols-4">
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']==1 ){ ?>
                    <a href="ajout_item"><button >Ajouter un nouvel objet à la boutique</button></a>
            <?php   }?>
        <ul class="category">
        	<li><a href="shop_view?cat=all" >Voir Tout</a></li>
            <li><a href="shop_view?cat=raquette" >Raquettes</a></li>
            <li><a href="shop_view?cat=grips">Grips</a></li>
            <li><a href="shop_view?cat=sac">Sacs</a></li>
            <li><a href="shop_view?cat=balle">Balles</a></li>
 			<li><a href="shop_view?cat=accessoire">Accessoires</a></li>
            <li><a href="shop_view?cat=autre">Autres</a></li>
            <li><a href="panier">Panier<?php if (isset($_SESSION['panier'])){$count=0;foreach($_SESSION['panier']as $item){$qte=$item[1];$count+=$qte;}echo'('.$count.')';}?></a></li>

        </ul>

        <div>
            <?php

                //$reponse = $bdd->query('SELECT * FROM shop');
				if(isset($articles)&&$is_null==false){
					foreach($articles as $donnees){
						?><div class="col" id=<?php echo $donnees->id_item; ?>>
						<?php
						if(isset($_SESSION['admin']) && $_SESSION['admin']==1 )
						{ ?>
						<form action="suppritem" method="post">
						<input type="hidden" name="id_item" value="<?php echo $donnees->id_item ;?>">
						<input type="submit" value="Supprimer"/></form>
						<form action="quantitem" method="post">
						<input type="hidden" name="id_item" value="<?php echo $donnees->id_item ?>">
						<input type="number" name="qte_item" value="<?php echo $donnees->qte_item ?>">
						<input type="submit" value="Modif Qte"/></form>

						<?php
						}
						?>

						<a class="aitem" href="shop.php?cat=<?php echo $donnees->id_item ?>" >
						<?php

							$url=base_url().'css/images/items/'.$donnees->img_item;
							echo '<img src='.$url.' >'.'<br>';
							echo $donnees->nom_item.'<br>';
							echo $donnees->prix_item."€".'<br>';
							if($donnees->qte_item==0)
							{
								echo "Rupture de stock".'<br>';
							}
							if($donnees->qte_item>0){
								echo "En stock".'<br>';
							}


						?></a>
						<form action="ajout_panier" method="post">
						 <input type="hidden" name="id_item" value="<?php echo $donnees->id_item ;?>">
						 <input type="submit" value="Ajouter au panier"/></form></div><?php


					}

					if($donnees->id_item==$_SESSION['cat']){
						echo '<h2>'.$donnees->nom_item.'</h2>'.'<br>';
						echo '<img height="150px" width="100px" src=images/items/'.$donnees->img_item.'>'.'<br>';
						echo $donnees->descri_item.'<br>';
						echo $donnees->prix_item."€".'<br>';
						if($donnees->qte_item==0)
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
