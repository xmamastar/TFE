<?php
	session_start();
	if (isset($_POST['nom'])||isset($_POST["Prenom"])||isset($_POST["mail"])||isset($_POST["password"])){


		$nom=htmlspecialchars($_POST["nom"]);
		$prenom=htmlspecialchars($_POST["Prenom"]);
		$mail=$_POST["mail"];

		try{

			$bdd=new PDO('mysql:host=localhost;dbname=TFE;charset=utf8','root','');

		}
		catch(Exception $e){

			die("Erreur: ".$e->getMessage());
		}

		if ($_POST['nom']!=""){

			if(preg_match("#^[a-zA-Z0-9éèçàùê-]{2,30}$#", $nom)){

				$rq=$bdd->prepare('UPDATE Utilisateurs SET Nom= :nom WHERE id=:Id');
            				$rq->execute(array(
                			'nom' => $nom,
                			'Id'=>$_SESSION["id"]));
            	$_SESSION["nom"]=$nom;
			}
			else{

					echo "Votre nom doit contenir au moins 2 caracteres ";
				}
		}
		if ($_POST['Prenom']!=""){

			if(preg_match("#^[a-zA-Z0-9éèçàùê-]{2,30}$#", $nom)){

				$rq=$bdd->prepare('UPDATE Utilisateurs SET Prenom= :prenom WHERE id=:Id');
            			$rq->execute(array(
				                'prenom' => $prenom,
				            	'Id'=>$_SESSION["id"]));
            	$_SESSION["prenom"]=$prenom;
			}
			else{

					echo "Votre prenom doit contenir au moins 2 caracteres ";
				}
		}
		if ($_POST['mail']!=""){

			if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){

					$rq=$bdd->prepare('UPDATE Utilisateurs SET Mail= :mail WHERE id=:Id');
            			$rq->execute(array(
				                'mail' => $mail,
				            	'Id'=>$_SESSION["id"]));
				 $_SESSION["mail"]=$mail;
			}
			else{

					echo "Votre adresse mail n'est pas valide";
				}
		}
		$nom="";
		$prenom="";
		$mdp="";
		$mail="";$confMdp="";
		header('location: profil.php');



	}


?>