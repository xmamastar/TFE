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

                    <form action="modifier_user" method="POST">
                    <a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/list_users"?> >retour </a>

                        <h1>Joueur <span><?php echo $joueur->id;?></span></h1>

						<div class="form-group">
							<label for="">Nom</label>
								<input required type="text"  name="nom_joueur" id="nom_joueur" value=<?php echo $joueur->nom;?> class="form-control">
								<input required type="hidden"  name="id_joueur" id="id_joueur" class="form-control" value=<?php echo $joueur->id;?> >

						</div>
						<div class="form-group">
							<label for="">Prenom</label>
								<input required type="text" name="prenom_joueur" id="prenom_joueur" value=<?php echo $joueur->prenom;?> class="form-control">

						</div>
						<div class="form-group">
							<label for="">E-mail</label>
							<input required type="text"  name="mail_joueur" id="mail_joueur" value=<?php echo $joueur->mail;?> class="form-control">

						</div>
						<?php $liste_classement=["NC","C30.6","C30.5","C30.4","C30.3","C30.2","C30.1","C30.0","C15.5","C15.4","C15.3","C15.2","C15.1","C15","B4/6","B2/6","B0","B-2/6","B-4/6","B-15","B-15.1","B-15.2","B-15.4","A Nat","A int"];?>
						<div class="form-group">

							<label><b>Classement:</b></label>
                                                        <select id="classement_joueur" name="classement_joueur">
                                                        <?php foreach($liste_classement as $c){

                                                        		if ($c==$joueur->classement){

                                                        			echo "<option selected value=".$c.">".$c."</option>";

                                                        		}
                                                        		else{
                                                        			echo "<option  value=".$c.">".$c."</option>";
                                                        		}
                                                        }?>


                                                        </select>
							<input required type="hidden"  name="mdp_joueur" id="mdp_joueur" class="form-control" value=<?php echo $joueur->mdp;?> >
						</div>
						<div class="form-group">
								<label for="">Administrateur</label>
								<input type="checkbox" id="statut_joueur" name="statut_joueur" value="1" <?php if($joueur->statut==1){

									echo "checked";

								}?>>

							</div>
							<div class="form-group">
                            							<label for="">Abonnement:</label>
                            								<select id="abonnement" name="abonnement_joueur"?>">
                            								<?php if (isset($abonnements)){?>
                            										<option value=0>Pas d'abonnement</option><?php
                            										foreach($abonnements as $abo){


                            											if($joueur->abonnement==$abo['id']){
                            												echo "<option selected value=".$abo['id'].'>'.$abo["nom"].'</option>';
                            											}
                            											else{

                            												echo "<option value=".$abo['id'].'>'.$abo["nom"].'</option>';

                            											}


                            										}

                            								}?>




                            									</select>

                            						</div>


						<div class="form-group pull-right">
							<button class="btn btn-primary" id= "bouton-admin" type="submit" name="submitAdmin">Modifier</button>


						</div>

                    </form>
                </div>
            </body>

        </html>
