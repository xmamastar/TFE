<html>
    <?php

    include 'menu_view.php';
    if ($_SESSION["statut"]!=1){

        echo "vous n'etes pas Administrateur";
                 redirect(base_url()."index/accueil");

    }

    else{
    	if(isset($cat_tournoi)){
			$cat=$cat_tournoi;

		   }
		   else{
				$cat='en_cours';
		   }


    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="content">
			<ul class="category">
                    	<table>
                        <li><a href="accueil?cat_tournoi=en_cours" >Tournois en cours</a></li>
                        <li><a href="accueil?cat_tournoi=a_venir">Tournois à venir</a></li>
						</table>

            </ul>
            <?php $url=base_url().'css/images/attention.png';
            echo "<div id=warning ><img height='50px width='50px' src=".$url. "><p>Attention, pour pouvoir s'inscrire, il est nécessaire d'être disponible au moins tous les jours du tournoi de 18h30 à 21h merci de votre compréhension</p></div>";


            if (isset($msg)){
            	echo $msg;
            }
            	if($cat=="all"||$cat=="en_cours"){

					if(isset($tournoi_en_cours)){
						echo "<div id=list_tournoi_en_cours>";
						echo "<table>";
						echo "<h2>Tournois en cours</h2>";
						echo "<tr>
						<td>N° Tournoi</td>
						<td>Date début</td>
						<td>Date de fin</td>
						<td></td>



						</tr>";
						foreach($tournoi_en_cours as $t){

							echo "<tr>";
							echo "<td>";
							echo $t['id_tournoi'];
							echo "</td>";
							echo "<td>";
							$debut=new DateTime($t['debut']);
							$debut=$debut->format("d-m-Y");
							echo $debut;
							echo "</td>";
							echo "<td>";
							$fin=new DateTime($t['fin']);
							$fin=$fin->format("d-m-Y");
							echo $fin;
							echo "</td>";
							echo "<td></td>";
							echo "<td>";
							echo "<a class='btn btn-xs btn-primary'  href= ".base_url()."tournoi/create_tableau?id=".$t['id_tournoi']." >Voir Tableaux </a>";
							echo "</td>";



							echo "</tr>";



						}
						echo "</table";
						echo "</div>";

					}
				}

            	if($cat=="a_venir"){
            		if(isset($tournoi_a_venir)){
                    					echo "<div id=list_tournoi_a_venir>";
                                		echo "<table>";
                                		echo "<h2>Tournois à venir</h2>";
                                		echo "<tr>
                                		<td>N° Tournoi</td>
                                		<td>Date début</td>
                                		<td>Date de fin</td>
                                		<td>nb inscrits</td>



                                		</tr>";
                                		foreach($tournoi_a_venir as $t){

                                			echo "<tr>";
                    						echo "<td>";
                    						echo $t['id_tournoi'];
                    						echo "</td>";
                    						echo "<td>";
                    						$debut=new DateTime($t['debut']);
                    						$debut=$debut->format("d-m-Y");
                    						echo $debut;
                    						echo "</td>";
                    						echo "<td>";
                    						$fin=new DateTime($t['fin']);
                    						$fin=$fin->format("d-m-Y");
                    						echo $fin;
                    						echo "</td>";
                    						echo "<td>";
                    						echo $t['nb_inscrit'].'/8';
                    						echo "</td>";
                    						echo "<td>";
                    						if ($t['nb_inscrit']>=8){
                    							echo "COMPLET";
                    						}
                    						if($t['nb_inscrit']<8){
                    							echo "<a class='btn btn-xs btn-primary'  href= ".base_url()."tournoi/s_inscrire?id=".$t['id_tournoi']." >S'inscrire </a>";
                    						}

                    						echo "</td>";



                                			echo "</tr>";



                                		}
                                		echo "</table";
                                		echo "</div>";

                                	}


            	}





            ?>



        </div>
    </body>
    <?php } ?>
</html>
