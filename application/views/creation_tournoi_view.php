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
    <?php


    ?>
        <div id="container2">

        <form action="verif_tournoi" method="POST">
        <a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/admin_tournoi" ;?> >retour </a>
        <h1>Créer un tournoi</h1>
        <label><b>Nom du tournoi :</b></label>
        <input type="text" placeholder="Entrer le nom du tournoi" name="nom_tournoi" value="<?php if(isset($nom_tournoi)){echo $nom_tournoi;}else{echo '';} ?>" required>
        <label><b>Début du tournoi :</b></label>
        <input type="date" placeholder="Entrer le début du tournoi" name="date_debut" value=""required>
        <label><b>Fin du tournoi :</b></label>
        <input type="date" placeholder="Entrer la fin du tournoi" name="date_fin" value="" required>
        <input type="submit" id='submit' value="Créer le tournoi" >
        </form>


        </div>
    </body>
    <?php } ?>
</html>
