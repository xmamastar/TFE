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
        <div id="container2">

        </div>
    </body>
    <?php } ?>
</html>