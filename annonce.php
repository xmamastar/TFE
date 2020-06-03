<html>
    <?php

    include 'menu.php';
    require('connexionbdd.php');
    if ($_SESSION["admin"]!=1){
        header ("location: index.php");
        echo "vous n'etes pas Administrateur";
    }
    else{

    if (isset($_POST['titre'])||isset($_POST["texte"])||isset($target_file)||isset($img_item))
        {
            $titre=htmlspecialchars($_POST["titre"]);
            $texte=htmlspecialchars($_POST["texte"]);
            $target_dir = "images/annonces/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $img_item = basename($_FILES["fileToUpload"]["name"]);
            if ($_POST['titre']!="" && $_POST['texte']!="")
            {
                if(preg_match("#^[a-zA-Z0-9]{2,30}$#", $titre))
                {
                        if(preg_match("#^[a-zA-Z0-9\'\.\,\,\;\-\_\+\!\?\&\é\@\"\#\è\à\ç\€\$\ù\%\:\)\(\* ]{1,1000}$#", $texte))
                        {

                                $rq1= $bdd->prepare('SELECT * FROM annonce WHERE titre= :titre');
                                $rq1->execute(array(
                                    'titre' => $titre));
                                $resultat1 =$rq1->fetch();
                                if ($resultat1['titre']==$titre)
                                {
                                    echo "L'annonce que vous essayez de créer existe déjà";
                                }
                                else
                                {

                                 if(isset($_FILES['fileToUpload'])){

                                    echo "coucou";
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
                                    /*if (file_exists($target_file)) {
                                      echo "<div class='alert alert-danger' role='alert'>L'image que vous voulez ajouter existe déjà, changez d'image ou modifiez son nom</div>";
                                      $uploadOk = 0;
                                    }*/
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
                                        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                        //echo "Votre compte a été correctement ajouté";
                                      $rq1=$bdd->prepare('INSERT INTO annonce(titre, texte, img_item) VALUES(:titre, :texte, :img_item)');
                                      $rq1->execute(array(
                                      'titre' => $titre,
                                      'texte' => $texte,
                                      'img_item' => $img_item));

                                      echo "<div class='alert alert-success' role='alert'>Annonce créée</div>";

                                      } else {
                                        echo "Sorry, there was an error uploading your file.";
                                      }
                                    }
                                  }
                                  else{
                                      $rq1=$bdd->prepare('INSERT INTO annonce(titre, texte) VALUES(:titre, :texte)');
                                        $rq1->execute(array(
                                        'titre' => $titre,
                                        'texte' => $texte));

                                        echo "<div class='alert alert-success' role='alert'>Annonce créée</div>";

                                   }
                                }


                        }
                        else
                        {
                            echo "Complètez le texte avec des caractères valides";
                        }


                }
                else
                {
                    echo "Le titre doit contenir entre 2 et 200 caractères";
                }

            }
            else
            {
                echo "Veillez remplir tout les champs.";
            }

        }
    ?>

    <div id="container2">
        <!-- zone de connexion -->
        <form action="annonce.php" method="POST" enctype="multipart/form-data">
            <h1>Ecrire une petite annonce</h1>
            <label><b>Titre:</b></label>
            <input type="text" placeholder="" name="titre" value="" required>
            <label><b>Texte:</b></label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="texte" rows="6" required></textarea>
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !"><b>Ajoutez une image à votre annonce:</b></label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" id='submit' name='submit' value="Publier" >

        </form>


    <?php } ?>
</html>