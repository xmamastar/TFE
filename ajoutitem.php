<html>
    <?php

    include 'menu.php';
    if ($_SESSION["admin"]!=1){

        header ("location: index.php");
        echo "vous n'etes pas Administrateur";

    }

    else{
        require('connexionbdd.php');



        if (isset($_POST['nom_item'])||isset($_POST["cat_item"])||isset($_POST["descri_item"])||isset($_POST["prix_item"])||isset($target_file)||isset($img_item))
        {
            $nom_item=htmlspecialchars($_POST["nom_item"]);
            $cat_item=htmlspecialchars($_POST["cat_item"]);
            $descri_item=htmlspecialchars($_POST["descri_item"]);
            $prix_item=$_POST["prix_item"];
            $target_dir = "images/items/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $img_item = basename($_FILES["fileToUpload"]["name"]);
            if ($_POST['nom_item']!="" && $_POST['cat_item']!=""&& $_POST["descri_item"]!="" && $_POST["prix_item"]!="")
            {
                if(preg_match("#^[a-zA-Z0-9]{2,30}$#", $nom_item))
                {
                    if(preg_match("#^[a-zA-Z0-9]{2,30}$#", $cat_item))
                    {
                        if(preg_match("#^[a-zA-Z0-9\'\.\,\,\;\-\_\+\!\?\&\é\@\"\#\è\à\ç\€\$\ù\%\:\)\(\* ]{1,1000}$#", $descri_item))
                        {
                            if(preg_match("#^[0-9]{1,30}$#", $prix_item))
                            {
                                $rq1= $bdd->prepare('SELECT * FROM shop WHERE nom_item= :nom_item');
                                $rq1->execute(array(
                                    'nom_item' => $nom_item));
                                $resultat1 =$rq1->fetch();
                                if ($resultat1['nom_item']==$nom_item)
                                {
                                    echo "L'objet que vous essayez de créer existe déjà";
                                }
                                else
                                {

                                if(isset($_POST["submit"])) {
                                  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                  if($check !== false) {
                                    echo "File is an image - " . $check["mime"] . ".";
                                    $uploadOk = 1;
                                  } else {
                                    echo "File is not an image.";
                                    $uploadOk = 0;
                                  }
                                }
                                if (file_exists($target_file)) {
                                  echo "Sorry, file already exists.";
                                  $uploadOk = 0;
                                }
                                if ($_FILES["fileToUpload"]["size"] > 500000) {
                                  echo "Sorry, your file is too large.";
                                  $uploadOk = 0;
                                }
                                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                && $imageFileType != "gif" ) {
                                  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                  $uploadOk = 0;
                                }
                                if ($uploadOk == 0) {
                                  echo "Sorry, your file was not uploaded.";
                                } else {
                                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                    echo "Votre compte a été correctement ajouté";
                                  $rq1=$bdd->prepare('INSERT INTO shop(nom_item, cat_item, descri_item, prix_item, img_item) VALUES(:nom_item, :cat_item, :descri_item, :prix_item, :img_item)');
                                  $rq1->execute(array(
                                  'nom_item' => $nom_item,
                                  'cat_item' => $cat_item,
                                  'descri_item' => $descri_item,
                                  'prix_item' => $prix_item,
                                  'img_item' => $img_item));

                                  $nom_item ="";
                                  $cat_item="";
                                  $descri_item="";
                                  $prix_item="";
                                  } else {
                                    echo "Sorry, there was an error uploading your file.";
                                  }
                                }

                                }


                            }
                            else
                            {
                                echo "Complètez un prix valide";
                            }

                        }
                        else
                        {
                            echo "Complètez la description avec des caractères valides";
                        }
                    }

                }
                else
                {
                    echo "Le nom doit contenir entre 2 et 30 caractères";
                }

            }
            else
            {
                echo "Veillez remplir tout les champs.";
            }

        }


    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="container2">
        <form action="ajoutitem.php" method="POST" enctype="multipart/form-data">
                <h1>Ajouter un nouvel objet à la boutique</h1>

                <label><b>Nom</b></label>
                <input type="text" name="nom_item">
                <label><b>Catégorie</b></label>
                <select type="text" name="cat_item">
                 <option value="raquette">Raquette de Tennis</option>
                 <option value="vetement">Vêtement de Tennis</option>
                 <option value="chaussure">Chaussures de Tennis</option>
                 <option value="sac">Sac de Tennis</option>
                 <option value="balle">Balles de Tennis</option>
                 <option value="autre">Autres</option>
                </select>
                <label><b>Description</b></label>
                <input type="textarea" name="descri_item">
                <label><b>Prix</b></label>
                <input type="number" name="prix_item">
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer l image :</label>
                <input type="file" name="fileToUpload" id="fileToUpload">



                <input type="submit" id='submit' name='submit' value="Ajouter à la boutique" >

            </form>


        </div>
    </body>
    <?php } ?>
</html>