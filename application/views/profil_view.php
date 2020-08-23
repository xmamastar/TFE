<html>
    <?php

    include 'menu_view.php';
    if ($_SESSION["statut"]!=1){

        header ("location: index.php");
        echo "vous n'etes pas connecté";

    }

    else{

    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="container2">
            <!-- zone de connexion -->

            <form action="verif_modif" method="POST">
                <h1>Modification de vos Données</h1>
                <h2>Bonjour <?php echo($_SESSION['prenom']);?></h2>

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
    </body>
    <?php } ?>
</html>
