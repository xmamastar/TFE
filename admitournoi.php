<html>
    <?php

    include 'menu.php';
    require('connexionbdd.php');
    if ($_SESSION["admin"]!=1){

        header ("location: index.php");
        echo "vous n'etes pas Administrateur";

    }

    else{

    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="content">
            <ul class="category">
                <li><a href="creertournoi.php" >Créer un nouveau tournoi</a></li>
                <li><a href="clottournoi.php" >Cloturer un nouveau tournoi</a></li>


            </ul>
            <table class="table table-striped">
                    <?php
                    $reponse = $bdd->query('SELECT * FROM tournoi');

                        while ($donnees = $reponse->fetch()){

                             echo "<tr><td>".$donnees['nom_tournoi'].'<br>';
                             echo $donnees['date_debut'].'  ';
                             echo $donnees['date_fin'].'';
                             ?>
                              <form action="ajoutparti.php" method="post">
                               <input type="hidden" name="id_tournoi" value="<?php echo $donnees['id_tournoi'] ?>">
                               <input type="submit" value="Participer"/></form>
                              <?php


                        }
                    ?>

                    </table>

        </div>
    </body>
    <?php } ?>
</html>