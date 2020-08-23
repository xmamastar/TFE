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

                        <div id="container2">
                            <!-- zone de connexion -->

                            <form action="verif_cordage" method="POST">
                            <a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/liste_cordage";?> >retour </a>
                            <?php
                            	if(isset($msg)){
                            		echo $msg;
                            	}?>
                                <h1>Ajout raquette cordage</h1>
                                <label><b>Type de cordage:</b></label>
                                <select name="type_cordage">
                                    <?php
                                    $nom_cordage=array();
                                    foreach($cordages as $donnees){
                                    	array_push($nom_cordage,$donnees->type_cordage);


                                    }
                                    asort($nom_cordage);
                                    foreach ($nom_cordage as $n){
                                    	echo "<option value=".$n.">".$n.'</option>';

                                    }


									?>
                                    </select>
                                <br><label><b>Tension:</b></label>
                                <input type="number" min="10" max="30" step="0.5" placeholder="" name="tension" required value =<?php if (isset($tension)){echo $tension;}?>>
                                <label><b>Email du joueur:</b></label>
                                <input type="email" placeholder="" name="mail" required value =<?php if (isset($mail)){echo $mail;}?>>




                                <input type="submit" id='submit' value="Ajouter" >

                            </form>



    </body>
    <?php } ?>
</html>
