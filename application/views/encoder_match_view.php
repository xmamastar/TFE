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

                    <form action="encoder_match_verif" method="POST">
                    	<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."tournoi/create_tableau?id=".$id_tournoi;?> >retour </a>
                        <h1><?php echo $statut;?></h1>
                        <div class="form-group timeslot">
						<label>Joueur1:</label>
						<input required type="text" readonly name="joueur1" id="joueur1" class="form-control" value=<?php echo $joueur1;?>>
						<label>Joueur2:</label>
						<input required type="text" readonly name="joueur2" id="joueur2" class="form-control" value=<?php echo $joueur2;?>>
						<input required type="hidden" readonly name="statut" id="terrain"class="form-control" value=<?php echo $statut;?>>
						<input required type="hidden" readonly name="id_tournoi" id="terrain"class="form-control" value=<?php echo $id_tournoi;?>>
						<input required type="hidden" readonly name="id_joueur1" id="terrain"class="form-control" value=<?php echo $id_joueur1;?>>
						<input required type="hidden" readonly name="id_joueur2" id="terrain"class="form-control" value=<?php echo $id_joueur2;?>>
						<input required type="hidden" readonly name="id_match" id="terrain"class="form-control" value=<?php echo $id_match;?>>
						</div>

						<div class="form-group">
						<label>Vainqueur:</label>
							<select id="vainqueur" name="vainqueur">

							  <option value=1>Joueur1</option>
							  <option value=2>joueur2</option>
							  </select>

						</div>
                        <div class="form-group">
							<label for="">Score:</label>
							<table>
								<tr>
									<td></td>
									<td>Set1</td>
									<td>Set2</td>
									<td>Set3</td>

								</tr>

								<tr>
								<td>Joueur1</td>
								<td><input required  required type="number" min='0' max='7' name="score1_set1" class="form-control" value= <?php if(isset($score1_set1)){echo $score1_set1;}?>></td>
								<td><input required  required type="number" min='0' max='7' name="score1_set2" class="form-control" value= <?php if(isset($score1_set2)){echo $score1_set2;}?>></td>
								<td><input type="number" min='0' max='7' name="score1_set3" class="form-control" value= <?php if(isset($score1_set3)){echo $score1_set3;}else{echo 0;}?>></td>
								</tr>
								<tr>
									<td>Joueur2</td>
									<td><input required  required type="number" min='0' max='7' name="score2_set1" class="form-control" value= <?php if(isset($score2_set1)){echo $score2_set1;}?>></td>
									<td><input required  required type="number" min='0' max='7' name="score2_set2" class="form-control" value= <?php if(isset($score2_set2)){echo $score2_set2;}?>></td>
                                    <td><input type="number" min='0' max='7' name="score2_set3" class="form-control" value= <?php if(isset($score2_set3)){echo $score2_set3;}else{echo 0;}?>></td>
                                </tr>
							</table>


						</div>


						<div class="form-group pull-right">
							<button class="btn btn-primary" id= "bouton-admin" type="submit" name="submitAdmin">valider</button>


						</div>

                    </form>
                </div>
            </body>

        </html>
