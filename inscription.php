<?php
session_start();
if(isset($_SESSION['pseudo'])){ echo "Vous êtes déjà connecté !"; }
else{
    ?>
<?php include("menu.php"); ?>
<!doctype html>
<html>
	<head>

		<meta charset="UTF-8">

		<link rel="stylesheet" href="style.css" />

	</head>
	<body>

		<div id="content">
      <h2>Inscription</h2>

			<?php
if(isset($_POST['pseudo'])|| isset($_POST['motdepasse'])|| isset($_POST['confmdp'])|| isset($_POST['mail']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $motdepasse = sha1($_POST['motdepasse']);
        $confmdp = sha1($_POST['confmdp']);
if($_POST['pseudo'] != "" && $_POST['motdepasse'] != "" && $_POST['confmdp'] != "" && $_POST['mail'] != "")
    {
        if (preg_match("#^[a-zA-Z0-9\'\.\,\;\-\_\+\-\!\?\&\é\@\"\'\#\è\à\ç\€\$\ù\%\:\)\(\* ]{4,20}$#", $pseudo ))
        {
            if($motdepasse == $confmdp )
            {
                if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail))
                {
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;...', 'root', '');
                    }
                    catch (Exception $e)
                    {
                        die('Erreur : ' . $e->getMessage());
                    }
                    $verif = $bdd->prepare("SELECT * FROM profil WHERE pseudo = '$pseudo'");
                    $verif->execute(array($pseudo));
                    $pseudoexi =$verif->rowcount();
                    if($pseudoexi == 0){
                    	// Pseudo libre
                        echo "Votre compte a été correctement ajouté !";
                        $rq = $bdd->prepare('INSERT INTO `profil` (`pseudo`, `mail`, `motdepasse`) VALUES (?,?,?)');
                        $rq->bindParam(1, $pseudo, PDO::PARAM_STR);
                        $rq->bindParam(2, $mail, PDO::PARAM_STR);
                        $rq->bindParam(3, $motdepasse, PDO::PARAM_STR);
                        $rq->execute();

                        $pseudo = "";
                        $mail = "";
                        $motdepasse = "";
                        $confmdp = "";

                       }else{
                       	// Pseudo déjà utilisé
                       echo 'Ce pseudo est déjà utilisé';

                        }

                }
                else{
                    echo "Votre adresse mail est incorrect, veuillez vérifier.";
                }
            }
            else{
                echo "Il y a une erreur dans votre mot de passe, veuillez taper aun minimum 4 lettres.";
            }
        }
        else{
            echo "Votre pseudo doit contenir 4 à 20 lettres ou chiffres.";
        }


    }
    else {  echo "Remplissez tous les champs." ; }

    }
    ?>

		<form action="inscription.php" method="post">
		<table class = "table">
		   <tr>
		       <td>Pseudo :</td>
		       <td><input type="text" name="pseudo"  value="<?php if(isset($pseudo)){echo $pseudo;} else {echo "";}?>" /></td>
		   </tr>
		   <tr>
		       <td>Mot de passe :</td>
		       <td><input type="password" name="motdepasse" /></td>
		   </tr>
		   <tr>
		       <td>Confirmation du mot de passe :</td>
		       <td><input type="password" name="confmdp" /></td>
		   </tr>
		   <tr>
		       <td>Adresse mail :</td>
		       <td><input type="text" name="mail" size=30 value="<?php if(isset($mail)){echo $mail;} else {echo "";}?>" /></td>
		   </tr>

		   <tr>
		       <td></td>
		       <td><input type="submit" value="S'inscrire" /></td>
		    </tr>
		</table>
		</form>

		<?php } ?>



		</div>
	</body>
</html>
