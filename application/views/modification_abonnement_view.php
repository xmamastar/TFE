<html>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>

    <body>
        <?php
           include 'menu_view.php';

		?>
		<div id="container2">
                    <!-- zone de connexion -->

                    <form action="ajout_abonnement" method="POST">
                    	<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/list_abonnements" ;?> >retour </a>
                        <h1>Abonnement n°<?php if(isset($id)){
                        	echo $id;
                        }?></h1>


                        <div class="form-group">
							<label for="">Nom:</label>
							<input required type="text"  name="nom_abonnement" id="nom_abonnement" class="form-control" value=<?php if(isset($nom)){
								echo $nom;
							} ?>>

						</div>
						<div class="form-group">
							<label for="">Heure maximum de réservation:</label>
								<select id="heure_max" name="heure_max"?>">
									  <option <?php if (isset($heure_max)){if($heure_max==9){echo 'selected';}}?> value=9>9h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==10){echo 'selected';}}?>value=10>10h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==11){echo 'selected';}}?>value=11>11h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==12){echo 'selected';}}?>value=12>12h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==13){echo 'selected';}}?>value=13>13h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==14){echo 'selected';}}?>value=14>14h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==15){echo 'selected';}}?>value=15>15h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==16){echo 'selected';}}?>value=16>16h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==17){echo 'selected';}}?>value=17>17h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==18){echo 'selected';}}?>value=18>18h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==19){echo 'selected';}}?>value=19>19h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==20){echo 'selected';}}?>value=20>20h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==21){echo 'selected';}}?>value=21>21h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==22){echo 'selected';}}?>value=22>22h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==23){echo 'selected';}}?>value=23>23h</option>
									  <option <?php if (isset($heure_max)){if($heure_max==24){echo 'selected';}}?>value=24>Minuit</option>



									</select>


						<div class="form-group pull-right">
							<button class="btn btn-primary" id= "bouton_ajout_abonnement" type="submit" name="ajout_abonnement">Ajouter</button>


						</div>

                    </form>
                </div>
            </body>

        </html>
