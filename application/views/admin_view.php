<html>
    <?php

    include 'menu_view.php';
    if ($_SESSION["admin"]!=1){


        echo "vous n'etes pas Administrateur";
        redirect(base_url()."index/accueil");

    }

    else{

    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="content">
            <ul class="category">
                <li><a href="admin_com" >Commandes<?php if(isset($abonnement_en_attente)){echo '('.$abonnement_en_attente.')';}?></a></li>
                <li><a href="admin_tournoi" >Tournois</a></li>
                <li><a href="liste_cordage" >Cordages</a></li>
                <li><a href="inscription_en_attente" >Inscriptions<?php if(isset($count)){echo '('.$count.')';}?></a></li>
                <li><a href="list_users" >Utilisateurs</a></li>
                <li><a href="list_abonnements" >Abonnements</a></li>



            </ul>
            <div id="list_user">


            <?php

            if(isset($commandes)){
				$count=0;
				echo "<h1>Commandes en cours:";
				echo '<table>';
            	foreach($commandes as $c){

					 if($count%2!=0){
					 	$classe="pair";
					 }
					 if($count%2==0){$classe='impair';}
					 $url="commande_recue?val=".$c->bon_com;
					 if($c->prete==1){

					 ?>

					 <tr class= <?php echo $classe;?>><td><a href=<?php echo $url;?>><?php  echo "La commande a bien été reçue par le client?  Si oui cliquez ici";?></a><br>
					 <?php
					 }
					 if($c->prete==0){
					 ?><tr class= <?php echo $classe;?>><td><?php
					 }
					 echo $c->nom_client.'<br>';
					 echo $c->date_com.'<br>';
					 echo $c->prix."€<br></td>";
					 echo "<td> <a class='btn btn-xs btn-primary'  href=".base_url()."admin/commande_detail?id=".$c->bon_com. ">Voir Commande </a></td>";
					 if ($c->prete==0){
					 	echo "<td> <a class='btn btn-xs btn-primary'  href=".base_url()."admin/commande_prete?id=".$c->bon_com. ">Commande prête </a></td>";
					 }
					 else{
					 	echo "<td>Commande prête </td>";
					 }

					 echo "</tr>";
					 $count+=1;

            	}
            	echo '</table>';

            }
            if(isset($tournois)){?>

            <ul class="category">

                            <li id="titre_tournoi"><a href="creer_tournoi" >Créer un nouveau tournoi</a></li>



                        </ul>
                        <h1>Liste des tournois</h1>
                        <table id="tournois_admin" class="table table-striped">
                                <?php
            					$count=0;
                                foreach($tournois as $t){
                                	if($count==0){

                                		echo "<tr><td>Nom</td><td>Début</td><td>Fin</td><td></td><td></td></tr>";

                                	}
                                	$date_debut=$t->date_debut;
                                	$date=explode("-",$date_debut);
                                	$date_debut=array_reverse($date);
                                	$date_debut=implode("-",$date_debut);
                                	$date_fin=$t->date_fin;
            						$date=explode("-",$date_fin);
            						$date_fin=array_reverse($date);
            						$date_fin=implode("-",$date_fin);
                                	 echo "<tr><td>".$t->nom_tournoi.'</td> ';
            						 echo '<td>'.$date_debut.'</td> ';
            						 echo '<td>'.$date_fin.'</td>';
            						 /*
            						 <td>
            						  <form action="ajoutparti" method="post">
            						   <input type="hidden" name="id_tournoi" value=<?php echo $t->id_tournoi; ?>>
            						   <input type="submit" value="Participer"/></form>
            						   </td>"""*/
            						   ?>
            						   <td>
            						   <form action="supprimer_tournoi" method="post">
            						   <input type="hidden" name="id_tournoi" value=<?php echo $t->id_tournoi; ?>>
            						   <input type="submit" value="Supprimer"/></form>
            						   </td>
            						   <td>
            						   <form action="supprimer_tournoi" method="post">
            						   <input type="hidden" name="id_tournoi" value=<?php echo $t->id_tournoi; ?>>
            						   <input type="submit" value="Cloturer"/></form>
            						   </td>
            						  <?php
            						  $count+=1;


                                }

                                ?>

                                </table><?php }

            if(isset($cordages)){?>
            	<li><a href="ajouter_cordage" >Ajouter une raquette à corder</a></li>
				<table class="table table-striped">
				<?php
				echo "<tr><td><h2>Bon commande</h2></td>";
				echo "<td><h2>type de cordage, tension</h2></td>";
				echo "<td><h2>Nom</h2></td>";
				echo "<td><h2>prête</h2></td>";
				echo "<td><h2>Récupéré</h2></td></tr>";
				$count6=0;
            	foreach($cordages as $donnees){
					if($donnees->pret==1&&$donnees->retirer==1){

					}

					else{
						if($count6==0){


						}
						$classe="";
						//if($count5%2==0){$classe='pair';}
						//if($count5%2==1){$classe='impair';}
						echo "<tr ><td>".$donnees->bon_cordage.'</td>';
						 echo '<td>'.$donnees->type_cordage." et tension: ".$donnees->tension.' </td> ';
						 echo '<td>'.$donnees->nom.'</td>';
						 if($donnees->pret==1){
							echo "<td> Cordage préparé </td>";

						 }
						 if($donnees->pret==0){
							echo "<td><a class='btn btn-xs btn-primary'  href= ".base_url()."admin/cordage_pret/?id=".$donnees->bon_cordage.'>Prêt</td>';


						 }

						 if($donnees->retirer==0&&$donnees->pret==1){
							echo "<td><a class='btn btn-xs btn-primary'  href= ".base_url()."admin/cordage_recup/?id=".$donnees->bon_cordage.'>Récupéré</td>';

						 }
						 else{
						 	echo "<td></td>";
						 }
						 echo '</tr>';

					}
					$count6+=1;





            	}?>

                                                 </table><?php

            }
            if(isset($liste_user)){
            	$count=0;?>
            	<h1>Liste des utilisateurs</h1>
            	<form  action="recherche_joueur" method="POST">
            	<label for="site-search">Cherchez un joueur avec son adresse mail:</label>
                <input type="search" id="site-search" name="recherche"
                       aria-label="Search through site content">
				<button type="submit">Recherche</button>

                </form>
                <?php
            	echo '<table>';
            	foreach($liste_user as $li2){

            		if ($count==0){

						?>
						<tr>
							<td><h2>Nom</h2></td>
							<td><h2>Prénom</h2></td>
							<td><h2>Mail</h2></td>
							<td><h2>Abonnement</h2></td>
							<td><h2>Modifier</h2></td>
							<td><h2>Supprimer</h2></td>



						</tr>
						<?php
						$count+=1;
						}
						if($count!=0){


						?>



							<tr>
								<td <?php if($count%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $li2->nom;?></td>
								<td <?php if($count%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $li2->prenom;?></a></td>
								<td <?php if($count%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $li2->mail; ?></td>
								<td <?php if($count%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $li2->abonnement; ?></td>
								<td <?php if($count%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/modification_user?id=".$li2->id;?> >Modifier </a></td>
								<td <?php if($count%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><a class='btn btn-xs btn-danger'  href= <?php echo base_url()."admin/supprimer_user?id=".$li2->id;?> >Supprimer </a></td>


							</tr>
							<?php
								}
								$count+=1;
            		}
            		echo '</table>';

            	}


					if(isset($abonnement)){
						$count2=0;?>
						<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/ajouter_abonnement";?> >Ajouter un abonnement</a>
						<?php
						echo '<table>';
						foreach($abonnement as $abo){

							if ($count2==0){

								?>
								<tr>
									<td><h2>Id</h2></td>
									<td ><h2>Nom</h2></td>
									<td ><h2>HeureMax</h2></td>




								</tr>
								<?php
								$count2+=1;
								}
								if($count2!=0){


								?>


								<tr>

										<td <?php if($count2%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $abo->id;?></td>
										<td <?php if($count2%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $abo->nom;?></a></td>
										<td <?php if($count2%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><?php echo $abo->heure_max;?></td>
										<td <?php if($count2%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/modifier_abonnement_existant_view?id=".$abo->id;?> >Modifier </a></td>
										<td <?php if($count2%2==0){echo "class='pair'";}else{echo "class='impair'";}?>><a class='btn btn-xs btn-danger'  href= <?php echo base_url()."admin/supprimer_abonnement?id=".$abo->id;?> >Supprimer </a></td>


								</tr>
									<?php
										}
										$count2+=1;
							}
							echo '</table>';

						}


            if(isset($liste)){
            $compteur=0;
			?>
				<h1>Inscriptions en attente de validation </h1>
				<table>
				<?php

            foreach($liste as $i){
					$classe="";
					if ($compteur %2==0){
						$classe="pair";

					}
					if($compteur%2==1){

						$classe="impair";

					}
					if($compteur==0){
					?>
					<tr>

						<td><h2>Nom</h2></td>
						<td><h2>Prénom</h2></td>
						<td><h2>Mail</h2></td>
						<td></td>
					</tr>

					<?php

					}
					if($compteur!=0){


					?>



            			<tr class=<?php echo $classe; ?>>
            				<td><?php echo $i->nom;?></td>
            				<td><?php echo $i->prenom;?></a></td>
            				<td><?php echo $i->mail; ?></td>
            				<td><a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/validation_inscription/?id=".$i->id."&id_joueur=".$i->id_joueur ;?> >valider </a></td>
							<td><a class='btn btn-xs btn-danger'  href= <?php echo base_url()."admin/suppression_inscription/?id=".$i->id."&id_joueur=".$i->id_joueur ;?> >supprimer</a></td>

                        </tr>
                        <?php
							}
							$compteur+=1;
                        }
                        echo "</table>";
                       }
                        ?>
            </div>

        </div>
    </body>

    <?php } ?>
    <script>
    	$("#site-search").click(function test(){
        	var chaine=$(this).attr('id-reservation');
        	var date=$(this).attr('date');
        	var terrain= $(this).attr('data-terrain');
        	var ts= $(this).attr('timeslot');
        	var url="http://localhost/codeIgniter/reservation/admin_booking?id="+id_reservation.toString()+"?ts="+ts+"?terrain="+terrain+"?date="+date;
        	window.location.replace(url);

        	});
    </script>
</html>
