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

                    <form action="test_connexion" method="POST">
                        <h1>Connexion</h1>

                        <label><b>adresse mail</b></label>
                        <input type="email" placeholder="Entrer votre adresse mail" value="<?php if (isset($mail)){ echo $mail;}else{echo'';}?>"name="mail" required>

                        <label><b>Mot de passe</b></label>
                        <input type="password" placeholder="Entrer le mot de passe" name="mdp" required>

                        <input type="submit" id='submit' value='LOGIN' >

                    </form>
                </div>
            </body>
        </html>
