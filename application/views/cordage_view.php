<html>

	<body>
        <?php
            include 'menu_view.php';


        ?>
        <div id="content" class="row row-cols-4">
            <h1>Cordages disponibles actuellement:</h1>
            <h3>Temps d'attente actuel: 2Jours </h3>
            <p>Pour en savoir plus, vous pouvez appeler le:<a href="tel:+32478858575">0478858575</a></p>

            <?php

            	foreach($cordages as $c){
            		?>
					<div class="col" id=<?php echo $c->img_cordage; ?>>

					<?php
						$url=base_url().'css/images/cordages/'.$c->img_cordage;
                        echo '<img src='.$url.' height="300px" width="250px">'.'<br>';
						//echo "<img class='images_petit' src=images/cordages/".$c->img_cordage.'>'.'<br>';
						echo $c->type_cordage.'<br>';
						echo "prix: <br>" ;
						echo $c->prix_cordage."€".'<br>';
						echo '</div>';

            	}

                ?>



        </div>

	</body>
</html>
