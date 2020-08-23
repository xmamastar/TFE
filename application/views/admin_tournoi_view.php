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
                <li id="titre_tournoi"><a href="creer_tournoi" >Créer un nouveau tournoi</a></li>



            </ul>
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

                    </table>

        </div>
    </body>
    <?php } ?>
</html>
