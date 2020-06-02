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
    <?php
    if (isset($_POST['nom_tournoi'])||isset($_POST["date_debut"])||isset($_POST["date_fin"])){
        $nom_tournoi=htmlspecialchars($_POST["nom_tournoi"]);
        $date_debut=date($_POST["date_debut"]);
        $date_fin=date($_POST["date_fin"]);
        if ($_POST['nom_tournoi']!="" && $_POST['date_debut']!=""&& $_POST["date_fin"]!=""){
            if(preg_match("#^[1-9a-zA-Zéèçàùê-]{2,60}$#", $nom_tournoi)){
                if($_POST['date_debut']!=""&& $_POST["date_fin"]!=""){

                $rq1=$bdd->prepare('INSERT INTO tournoi(nom_tournoi, date_debut, date_fin) VALUES(:nom_tournoi, :date_debut, :date_fin)');
                $rq1->execute(array(
                    'nom_tournoi' => $nom_tournoi,
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin
                ));
                    echo "<div class='alert alert-success' role='alert'>Tournoi crée</div>";
                }
                else{
                    echo "<div class='alert alert-danger' role='alert'>Entrez des dates valides</div>";
                }

            }
            else{
                echo "<div class='alert alert-danger' role='alert'>Entrez un nom valide</div>";
            }

        }
        else{
            echo "<div class='alert alert-danger' role='alert'>Remplissez tout les champs</div>";
            }
    }

    ?>
        <div id="container2">
        <form action="creertournoi.php" method="POST">
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