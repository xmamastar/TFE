<html>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>

    <body>
        <?php
           include 'menu.php';

require('connexionbdd.php');
?>
<?php
if (isset($_POST["mail"])||isset($_POST["mdp"]))
        {
            $mail=htmlspecialchars($_POST["mail"]);
            $mdp=sha1($_POST["mdp"]);

            $rq= $bdd->prepare('SELECT * FROM Utilisateurs WHERE Mail= :mail AND Mdp= :mdp');
            $rq->execute(array(
                'mail' => $mail,
                'mdp' => $mdp));
            $resultat =$rq->fetch();
            if (!$resultat){

                echo "email ou mot de passe incorrect";


            }
            else{


                $today=date('Y-m-d');
                $_SESSION['id']=$resultat['id'];
                $_SESSION['mail']=$resultat['mail'];
                $_SESSION['nom']=$resultat['nom'];
                $_SESSION['prenom']=$resultat['prenom'];
                $_SESSION['classement']=$resultat['classement'];
                $_SESSION["admin"]=$resultat['statut'];
                $_SESSION["statut"]=1;
                //$_SESSION['affiliation']=$resultat['N°Affiliation'];
                $_SESSION["jour"]=$today;
                $_SESSION['panier']=array();




                header('location: index.php');
                //echo "Vous etes connecté";
            }

        }
?>
        <div id="container2">
            <!-- zone de connexion -->

            <form action="connexion.php" method="POST">
                <h1>Connexion</h1>

                <label><b>adresse mail</b></label>
                <input type="email" placeholder="Entrer votre adresse mail" value="<?php if (isset($mail)){ echo $mail;}else{echo'';}?>"name="mail" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="mdp" required>

                <input type="submit" id='submit' value='LOGIN' >

            </form>
        </div>
    </body>
</html>
