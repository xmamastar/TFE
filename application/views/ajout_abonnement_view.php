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
                        <h1>Ajout d'un abonnement</h1>


                        <div class="form-group">
							<label for="">Nom:</label>
							<input required type="text"  name="nom_abonnement" id="nom_abonnement" class="form-control" >

						</div>
						<div class="form-group">
							<label for="">Heure maximum de réservation:</label>
								<select id="heure_max" name="heure_max"?>">
									  <option value=9>9h</option>
									  <option value=10>10h</option>
									  <option value=11>11h</option>
									  <option value=12>12h</option>
									  <option value=13>13h</option>
									  <option value=14>14h</option>
									  <option value=15>15h</option>
									  <option value=16>16h</option>
									  <option value=17>17h</option>
									  <option value=18>18h</option>
									  <option value=19>19h</option>
									  <option value=20>20h</option>
									  <option value=21>21h</option>
									  <option value=22>22h</option>
									  <option value=23>23h</option>
									  <option value=24>Minuit</option>



									</select>


						</div>
						<div class="form-group pull-right">
							<button class="btn btn-primary" id= "bouton_ajout_abonnement" type="submit" name="ajout_abonnement">Ajouter</button>


						</div>

                    </form>
                </div>
            </body>

        </html>
