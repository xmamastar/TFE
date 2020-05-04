<html>
    <?php

    include 'menu.php';
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

            <form action="verifModif.php" method="POST">
                <h1>Modification de vos Données</h1>
                <h2>Bonjour <?php echo($_SESSION['prenom']);?></h2>

                <label><b>Nom</b></label>
                <input type="text" value="<?php echo($_SESSION['nom']);?>" name="nom">
                <label><b>Prenom</b></label>
                <input type="text" value="<?php echo($_SESSION['prenom']);?>" name="Prenom">
                <label><b>Adresse Mail</b></label>
                <input type="email" value="<?php echo($_SESSION['mail']);?>" name="mail">



                <input type="submit" id='submit' value="Enregistrer les modification" >

            </form>
        </div>
    </body>
    <?php } ?>
</html>