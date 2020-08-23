<html>
    <?php

    include 'menu_view.php';
    if ($_SESSION["statut"]!=1){
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
        <div id="container2">
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
    </body>
    <?php } ?>
</html>
