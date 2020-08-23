<html>
    <?php

    include 'menu_view.php';

    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="content">
            <ul class="category">
                <li><a href="mes_commandes" >Mes Commandes</a></li>

                <li><a href="mes_cordages" >Mes Cordages</a></li>
                <li><a href="mes_reservations" >Mes Reservations</a></li>
                <li><a href="profil_view" >Mes Données</a></li>




            </ul>
            <div id="mes_reservations">

            <?php
            if(isset($mes_cordages)){
				$count3=0;
				echo "<h1>Cordages en cours:</h1>";
				echo '<table>';
				foreach($mes_cordages as $c){
					if ($c==null){

						echo "Pas de cordages";

					}
					 if($count3%2!=0){
						$classe="pair";
					 }
					 if($count3%2==0){$classe='impair';}
					 //$url="commande_recue?val=".$c->bon_com;
					 if($c->pret==1){

					 ?>

					 <tr class= <?php echo $classe;?>><td>
					 <?php
					 }
					 if($c->pret==0){
					 ?><tr class= <?php echo $classe;?>><td><?php
					 	echo $c->bon_cordage.'<br>';
						 echo $c->type_cordage.'<br>';
						 echo $c->prix_cordage."€<br></td>";
					 }


					 if ($c->pret==0){
						echo "<td> Commande en cours </td>";
					 }
					 else{
					 	if($c->retirer==0){
					 		echo $c->bon_cordage.'<br>';
							 echo $c->type_cordage.'<br>';
							 echo $c->prix_cordage."€<br></td>";
					 		echo "<td>Commande prête </td>";
					 	}


					 }

					 echo "</tr>";
					 $count3+=1;

				}
				echo '</table>';

			}
            if(isset($mes_commandes)){
            				$count=0;
            				echo "<h1>Commandes en cours:";
            				echo '<table>';
                        	foreach($mes_commandes as $c){

            					 if($count%2!=0){
            					 	$classe="pair";
            					 }
            					 if($count%2==0){$classe='impair';}
            					 $url="commande_recue?val=".$c->bon_com;
            					 if($c->prete==1){

            					 ?>

            					 <tr class= <?php echo $classe;?>><td>
            					 <?php
            					 }
            					 if($c->prete==0){
            					 ?><tr class= <?php echo $classe;?>><td><?php
            					 }
            					 echo $c->nom_client.'<br>';
            					 echo $c->date_com.'<br>';
            					 echo $c->prix."€<br></td>";
            					 echo "<td> <a class='btn btn-xs btn-primary'  href=".base_url()."user/commande_detail?id=".$c->bon_com. ">Voir Commande </a></td>";
            					 if ($c->prete==0){
            					 	echo "<td> Commande en cours </td>";
            					 }
            					 else{
            					 	echo "<td>Commande prête </td>";
            					 }

            					 echo "</tr>";
            					 $count+=1;

                        	}
                        	echo '</table>';

                        }
            if(isset($liste_reservation)){

            	$count=0;
            	echo '<h1>Mes réservations</h1>';
            	echo '<table>';
            	foreach($liste_reservation as $r){

            		if ($count==0)
            		{	?>
            			<td><h2><?php echo "Date";?></h2></td>
						<td><h2><?php echo "Heure";?></h2></td>
						<td><h2><?php echo "Terrain";?></h2></td>
						<?php
						$count+=1;
					}
					if($count!=0)
					{
					?>
					<tr>
							<td><?php $date=new DateTime($r["date"]);$date=$date->format('d-m-Y'); echo $date;?></td>
							<td><?php echo $r["timeslot"];?></td>
							<td><?php echo $r["terrain"];?></td>
							<td><a class='btn btn-xs btn-primary'  href= <?php echo base_url()."user/supprimer?numero=".$r['numero_reservation'] ;?> >supprimer la reservation </a></td>


					</tr>



					<?php
						}
            		}
            		echo '</table>';

            	}
            if(isset($donnees)){

            	?>
            	<div id="container3">
					  <!-- zone de connexion -->

					  <form action="verif_modif" method="POST">
						  <h1>Modification de vos Données</h1>


						  <label><b>Nom</b></label>
						  <input type="text" value="<?php echo($_SESSION['nom']);?>" name="nom">
						  <label><b>Prenom</b></label>
						  <input type="text" value="<?php echo($_SESSION['prenom']);?>" name="prenom">
						  <input type="hidden" value="<?php echo($_SESSION['mail']);?>" name="mail">
						<?php $liste_classement=["NC","C30.6","C30.5","C30.4","C30.3","C30.2","C30.1","C30.0","C15.5","C15.4","C15.3","C15.2","C15.1","C15","B4/6","B2/6","B0","B-2/6","B-4/6","B-15","B-15.1","B-15.2","B-15.4","A Nat","A int"];?>

						<label><b>Classement:</b></label>
						<select id="classement_joueur" name="classement_joueur">
						<?php foreach($liste_classement as $c){

								if ($c==$_SESSION['classement']){

									echo "<option selected value=".$c.">".$c."</option>";

								}
								else{
									echo "<option  value=".$c.">".$c."</option>";
								}
						}?>


						</select>
						<div>
						<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."user/modifier_mot_de_passe" ;?> >Modifier mot de passe </a>

						</div>
						  <input type="submit" id='submit' value="Enregistrer les modification" >

					  </form>
				  </div>
				  <?php

            }
            if(isset($modification_view)){
            ?>
			<div id="container3">
						<!-- zone de connexion -->

						<form action="verif_modification_mot_de_passe" method="POST">
							<h1>Modification du mot de passe</h1>


							<label><b>Ancien mot de passe:</b></label>
							<input type="password" name="old_password">
							<label><b>Nouveau mot de passe:</b></label>
							<input type="password" name="new_password1">
							<label><b>Confirmez le nouveau mot de passe:</b></label>
							<input type="password" name="new_password2">

							<input type="submit" id='submit' value="Modifier le mot de passe" >

						</form>
					</div>

            <?php


            }

				?>
            </div>

        </div>
    </body>

</html>
