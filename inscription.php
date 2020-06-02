<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>

    <?php

        include 'menu.php';
        require('connexionbdd.php');
    ?>
            <?php

                if (isset($_POST['nom'])||isset($_POST["prenom"])||isset($_POST["mail"])||isset($_POST["password"])){
                    $mdp=$_POST["password"];
                    if($mdp!=""&&strlen($mdp)<4){

                        echo "le mot de passe n'est pas valide, il doit contenir au moins 4 caractères";
                    }
                    else{
                        $nom=htmlspecialchars($_POST["nom"]);
                        $prenom=htmlspecialchars($_POST["prenom"]);
                        $mdp=sha1($_POST["password"]);
                        $confMdp=sha1($_POST["password2"]);
                        $mail=$_POST["mail"];
                        $classement=$_POST["classement"];
                        if ($_POST['nom']!="" && $_POST['prenom']!=""&& $_POST["password"]!="" && $_POST["password2"]!="" && $_POST["mail"]!=""){
                            if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $nom)){
                                if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $prenom)){
                                    if($mdp==$confMdp){
                                        if(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
                                            $rq1= $bdd->prepare('SELECT * FROM Utilisateurs WHERE Mail= :mail');
                                            $rq1->execute(array(
                                                'mail' => $mail));
                                            $resultat1 =$rq1->fetch();
                                            if ($resultat1['mail']==$mail){

                                                echo "L'email que vous avez renseigné est déjà utilisé ! Essayer de vous connecter";
                                            }
                                            else{
                                                echo "Votre compte a été correctement ajouté";

                                     $rq1=$bdd->prepare('INSERT INTO Utilisateurs(Nom, Prenom, Mail, Mdp, classement) VALUES(:nom, :prenom, :mail, :mdp, :classement)');
                                                                                     $rq1->execute(array(
                                                                                     'nom' => $nom,
                                                                                     'prenom' => $prenom,
                                                                                     'mail' => $mail,
                                                                                     'mdp' => $mdp,
                                                                                     'classement' => $classement));           $rq= $bdd->prepare('SELECT * FROM Utilisateurs WHERE Mail= :mail AND Mdp= :mdp');
                                                $rq->execute(array(
                                                'mail' => $mail,
                                                'mdp' => $mdp));
                                                $resultat =$rq->fetch();
                                                if (!$resultat){
                                                    echo "Nous n'avons pas de correspondance pour cet email";
                                                }
                                                else{
                                                $_SESSION['id']=$resultat['id'];
                                                $_SESSION['mail']=$resultat['mail'];
                                                $_SESSION['nom']=$resultat['nom'];
                                                $_SESSION['prenom']=$resultat['prenom'];
                                                $_SESSION['classement']=$resultat['classement'];
                                                $_SESSION["admin"]=$resultat['statut'];
                                                $_SESSION["statut"]=1;
                                                #$_SESSION['affiliation']=$resultat['N°Affiliation'];
                                                $_SESSION["terrain1"]=null;
                                                $_SESSION["terrain2"]=null;
                                                $_SESSION["terrain3"]=null;
                                                $_SESSION["terrain4"]=null;
                                                $today=date('Y-m-d');
                                                $_SESSION["jour"]=$today;
                                                $nom="";
                                                $prenom="";
                                                $mdp="";
                                                $mail="";$confMdp="";
                                                echo $_SESSION['nom'];
                                                echo "Vous etes connecté";
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
                                    echo "Votre prenom doit contenir au moins 2 caracteres et il ne peut contenir que des lettres ";
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
                }
            ?>
                    <div id="container2">
                        <!-- zone de connexion -->
                        <form action="inscription.php" method="POST">
                            <h1>Inscription</h1>
                            <label><b>Nom:</b></label>
                            <input type="text" placeholder="Entrer votre nom" name="nom" value="<?php if(isset($nom)){echo $nom;}else{echo '';} ?>" required>
                            <label><b>Prenom:</b></label>
                            <input type="text" placeholder="Entrer votre Prénom" name="prenom" value="<?php if(isset($prenom)){echo $prenom;}else{echo '';} ?>"required>
                            <label><b>Adresse Mail:</b></label>
                            <input type="email" placeholder="Entrer votre adresse mail" name="mail" value="<?php if(isset($mail)){echo $mail;}else{echo '';} ?>" required>
                            <label><b>Mot de passe:</b></label>
                            <input type="password" placeholder="Entrer le mot de passe" name="password" required>
                            <label><b>Confirmation Mot de passe:</b></label>
                            <input type="password" placeholder="Entrer le mot de passe" name="password2" required>
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
                            <input type="submit" id='submit' value="S'inscrire" >

                        </form>

                </body>
</html>
