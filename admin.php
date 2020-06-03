<html>
    <?php

    include 'menu.php';
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
                <li><a href="admicom.php" >Adminiatration Commande</a></li>
                <li><a href="admitournoi.php" >Adminiatration Tournoi</a></li>
                <li><a href="annonce.php" >Ajouter une annonce au site</a></li>


            </ul>

        </div>
    </body>
    <?php } ?>
</html>