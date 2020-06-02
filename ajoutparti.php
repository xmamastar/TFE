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

                    if (isset($_POST['nom'])||isset($_POST["prenom"])||isset($_POST["mail"])){

                            $nom=htmlspecialchars($_POST["nom"]);
                            $prenom=htmlspecialchars($_POST["prenom"]);
                            $mail=$_POST["mail"];
                            $classement=$_POST["classement"];
                            if ($_POST['nom']!="" && $_POST['prenom']!="" && $_POST["mail"]!=""){
                                if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $nom)){
                                    if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $prenom)){
                                            if(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
                                                $rq1= $bdd->prepare('SELECT * FROM Utilisateurs WHERE Mail= :mail');
                                                $rq1->execute(array(
                                                    'mail' => $mail));
                                                $resultat1 =$rq1->fetch();
                                                if ($resultat1['mail']==$mail){

                                                    echo "L'email que vous avez renseigné est déjà utilisé ! Essayer de vous connecter";
                                                }
                                                else{
                                                    //echo "Votre compte a été correctement ajouté";

                                         $rq1=$bdd->prepare('INSERT INTO Utilisateurs(Nom, Prenom, Mail, classement) VALUES(:nom, :prenom, :mail, :classement)');
                                                     $rq1->execute(array(
                                                     'nom' => $nom,
                                                     'prenom' => $prenom,
                                                     'mail' => $mail,
                                                     'classement' => $classement));

                                                $rq2= $bdd->prepare('SELECT * FROM Utilisateurs WHERE Mail= :mail');
                                                    $rq2->execute(array(
                                                        'mail' => $mail));
                                                    $resultat1 =$rq2->fetch();
                                                    if ($resultat1['mail']==$mail){

                                                        $id_joueur = $resultat1['id'];
                                                        $classement = $resultat1['classement'];
                                                        $id_tournoi = $_POST['id_tournoi'];

                                                        $rq1=$bdd->prepare('INSERT INTO joueur_tournoi (id_joueur, classement, id_tournoi) VALUES(:id_joueur, :classement, :id_tournoi)');
                                                             $rq1->execute(array(
                                                             'id_joueur' => $id_joueur,
                                                             'classement' => $classement,
                                                             'id_tournoi' => $id_tournoi));


                                                        echo "<div class='alert alert-success' role='alert'>Vous avez bien ajouté l'utilisateur et inscirt au tournoi</div>";
                                                    }


                                                }
                                            }
                                            else{
                                                echo "votre adresse mail est incorrecte, Veuillez vérifier";
                                            }
                                        }
                                        else{
                                            echo "Il y a une erreur dans votre mot de passe, veuillez taper au minimum 4 caractere";
                                        }

                                }
                                else{
                                        echo "Votre nom doit contenir au moins 2 caracteres et il ne peut contenir que des lettres";
                                    }
                            }
                            else {
                                echo "remplissez tous les champs!!";
                            }
                        }

                ?>
                        <div id="container2">
                            <!-- zone de connexion -->
                            <form action="ajoutparti.php" method="POST">
                                <h1>Inscription Manuelle au tournoi</h1>
                                <label><b>Nom:</b></label>
                                <input type="text" placeholder="" name="nom" value="<?php if(isset($nom)){echo $nom;}else{echo '';} ?>" required>
                                <label><b>Prenom:</b></label>
                                <input type="text" placeholder="" name="prenom" value="<?php if(isset($prenom)){echo $prenom;}else{echo '';} ?>"required>
                                <label><b>Adresse Mail:</b></label>
                                <input type="email" placeholder="" name="mail" value="<?php if(isset($mail)){echo $mail;}else{echo '';} ?>" required>
                                <label><b>Classement:</b></label>
                                <select id="classement" name="classement">
                                  <option value="NC">NC</option>
                                  <option value="C30.6">C30.6</option>
                                  <option value="C30.5">C30.5</option>
                                  <option value="C30.4">C30.4</option>
                                  <option value="C30.3">C30.3</option>
                                  <option value="C30.2">C30.2</option>
                                  <option value="C30.1">C30.1</option>
                                  <option value="C30.0">C30.0</option>
                                  <option value="C15.5">C15.5</option>
                                  <option value="C15.4">C15.4</option>
                                  <option value="C15.3">C15.3</option>
                                  <option value="C15.2">C15.2</option>
                                  <option value="C15.1">C15.1</option>
                                  <option value="C15">C15</option>
                                  <option value="B4/6">B4/6</option>
                                  <option value="B2/6">B2/6</option>
                                  <option value="B0">B0</option>
                                  <option value="B-2/6">B-2/6</option>
                                  <option value="B-4/6">B-4/6</option>
                                  <option value="B-15">B-15</option>
                                  <option value="B-15.1">B-15.1</option>
                                  <option value="B-15.2">B-15.2</option>
                                  <option value="B-15.4">B-15.4</option>
                                  <option value="A Nat">A Nat</option>
                                  <option value="A int">A int</option>


                                </select>
                                <label><b>Tournoi:</b></label>
                                <select id="id_tournoi" name="id_tournoi">
                                  <?php
                                  $reponse = $bdd->query('SELECT * FROM tournoi');

                                      while ($donnees = $reponse->fetch()){

                                           echo "<option value=".$donnees['id_tournoi'].">".$donnees['nom_tournoi'].'</option>';
                                           }
                                           ?>


                                </select>
                                <input type="submit" id='submit' value="Inscrire" >

                            </form>



    </body>
    <?php } ?>
</html>