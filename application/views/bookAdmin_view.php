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

                    <form action="delete_element" method="POST">
                    	<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."reservation/book?date=".$date ;?> >retour </a>
                        <h1>Réservation le <?php echo date('d/m/Y',strtotime($date));?> sur le Terrain <span id="slotAdmin"> <?php echo $terrain;?></span></h1>
                        <div class="form-group timeslot">
						<label>Plage de reservation:</label>
						<input required type="text" readonly name="timeslotAdmin" id="timeslotAdmin" class="form-control" value=<?php echo $timeslot;?>>
						<input required type="hidden" readonly name="id_reservation" id="id_reservation" class="form-control"value=<?php echo $id_reservation;?>>
						<input required type="hidden" readonly name="date" id="date_day"class="form-control" value=<?php echo $date;?>>
						<input required type="hidden" readonly name="terrain" id="terrain"class="form-control" value=<?php echo $terrain;?>>
						</div>

                        <div class="form-group">
							<label for="">Id du joueur:</label>
							<input required type="text" readonly name="id_joueur" id="id_joueur" class="form-control" value=<?php echo $id;?> >

						</div>
						<div class="form-group">
							<label for="">Name</label>
								<input required type="text" readonly name="nom_joueur" id="nom_joueur" value=<?php echo $name;?> class="form-control">

						</div>
						<div class="form-group">
							<label for="">E-mail</label>
							<input required type="text" readonly name="prenom_joueur" id="prenom_joueur" value=<?php echo $mail;?> class="form-control">

						</div>
						<div class="form-group pull-right">
							<button class="btn btn-primary" id= "bouton-admin" type="submit" name="submitAdmin">Supprimer une réservation</button>


						</div>

                    </form>
                </div>
            </body>

        </html>
