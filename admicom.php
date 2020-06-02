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
        <div id="content"><table class="table table-striped">
        <?php
        $reponse = $bdd->query('SELECT * FROM commandeadmin');

            while ($donnees = $reponse->fetch()){

            if($donnees['recu'] == 0){
                 echo "<tr><td>".$donnees['bon_com'].'<a href="recu.php?val='.$donnees['bon_com'].'">La commande a bien été recu par le client ? Si oui clicquez ici</a><br>';
                 echo $donnees['id_client'].'<br>';
                 echo $donnees['nom_client'].'<br>';
                 echo $donnees['date_com'].'<br>';
                 echo $donnees['prix']."€".'</td></tr>';
            }


            }
        ?>

        </table></div>

    </body>
    <?php } ?>
</html>