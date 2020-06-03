<html>
    <?php
    require('connexionbdd.php');
    include 'menu.php';
    if ($_SESSION["statut"]!=1){

        header ("location: index.php");
        echo "<div class='alert alert-danger' role='alert'>vous n'etes pas connecté</div>";

    }

    else{
    if(isset($_POST['id_joueur'])){
    $reponse1 = $bdd->query('SELECT * FROM joueur_tournoi');
        $donnees1 = $reponse1->fetch();
        if ($donnees1==null){

            $id_joueur=$_POST['id_joueur'];
            $classement=$_POST['classement'];
            $id_tournoi=$_POST['id_tournoi'];

            $rq1=$bdd->prepare('INSERT INTO joueur_tournoi (id_joueur, classement, id_tournoi) VALUES(:id_joueur, :classement, :id_tournoi)');
                 $rq1->execute(array(
                 'id_joueur' => $id_joueur,
                 'classement' => $classement,
                 'id_tournoi' => $id_tournoi));


            echo "<div class='alert alert-success' role='alert'>Vous avez bien été ajouté au tournoi</div>";



        }

        else{

        $reponse = $bdd->query('SELECT * FROM joueur_tournoi');
        while ($donnees = $reponse->fetch()){
        if($_SESSION['id'] == $donnees['id_joueur']){

            echo "<div class='alert alert-danger' role='alert'>Vous etes déjà inscrit au tournoi</div>";


         }
         else{

            $id_joueur=$_POST['id_joueur'];
            $classement=$_POST['classement'];
            $id_tournoi=$_POST['id_tournoi'];

            $rq1=$bdd->prepare('INSERT INTO joueur_tournoi (id_joueur, classement, id_tournoi) VALUES(:id_joueur, :classement, :id_tournoi)');
                 $rq1->execute(array(
                 'id_joueur' => $id_joueur,
                 'classement' => $classement,
                 'id_tournoi' => $id_tournoi));


            echo "<div class='alert alert-success' role='alert'>Vous avez bien été ajouté au tournoi</div>";
         }

         }
        }
        }

    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="content">
        <h2>Tournoi disponible</h2>
        <table class="table table-striped">
            <?php
            $reponse = $bdd->query('SELECT * FROM tournoi');

                while ($donnees = $reponse->fetch()){

                     echo "<tr><td>".$donnees['nom_tournoi'].'<br>';
                     echo $donnees['date_debut'].'  ';
                     echo $donnees['date_fin'].'';
                     ?>
                     <form action="tournoi.php" method="post">
                      <input type="hidden" name="id_tournoi" value="<?php echo $donnees['id_tournoi'] ?>">
                      <input type="hidden" name="id_joueur" value="<?php echo $_SESSION['id'] ?>">
                      <input type="hidden" name="classement" value="<?php echo $_SESSION['classement'] ?>">
                      <input type="submit" value="Participer"/></form>
                     <?php
                }
            ?>

            </table>
            <h2>Tournoi Inscrit</h2>


        </div>
    </body>
    <?php } ?>
</html>