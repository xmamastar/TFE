<?php
session_start();
class Connexion extends CI_Controller
{
	public function form_connexion(){
		if(isset($_SESSION["statut"])){

			redirect(base_url()."index/accueil");

		}
		else{
			$this->load->view('connexion_view');
		}


	}
	public function test_connexion(){
		$this->load->model('utilisateurs_model', 'user');

		if (isset($_POST["mail"])||isset($_POST["mdp"]))
            {
                $mail=htmlspecialchars($_POST["mail"]);
                $mdp=sha1($_POST["mdp"]);
				$resultat=$this->user->get_by_mail($mail);
				if ($resultat->mail==$mail){
					if($resultat->mdp==$mdp){
						$today=date('Y-m-d');
						$_SESSION['id']=$resultat->id;
						$_SESSION['mail']=$resultat->mail;
						$_SESSION['nom']=$resultat->nom;
						$_SESSION['prenom']=$resultat->prenom;
						$_SESSION['classement']=$resultat->classement;
						$_SESSION["admin"]=$resultat->statut;
						$_SESSION["statut"]=1;
						$_SESSION['abonnement']=$resultat->abonnement;
						//$_SESSION['affiliation']=$resultat['N°Affiliation'];
						$_SESSION["jour"]=$today;
						$_SESSION['panier']=array();
						$_SESSION["ts"]="";
						$_SESSION['msg']="";
						redirect(base_url()."index/accueil");
						var_dump($resultat);
						var_dump($_SESSION['nom']);
						echo "vous etes connectés";

					}
					else{
						$this->load->view('connexion_view');
						echo "email ou mot de passe incorrect";

					}

				}
				else{
					$this->load->view('connexion_view');
					echo "email ou mot de passe incorrect";

				}


            }



	}

}
