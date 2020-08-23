<?php
session_start();
class Inscription extends CI_Controller
{

	public function form_inscription()
    	{

    		$this->load->view('inscription_view');
    	}



    public function test_inscription(){
		$this->load->model('utilisateurs_model', 'user');

						$nom="";
						$prenom="";
						$mail="";
						$data=array();
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
                                 $data=["nom"=>$nom,"prenom"=>$prenom,"mail"=>$mail,"classement"=>$_POST['classement']];
                                 if ($_POST['nom']!="" && $_POST['prenom']!=""&& $_POST["password"]!="" && $_POST["password2"]!="" && $_POST["mail"]!=""){

                                     if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $nom)){
                                         if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $prenom)){
                                             if($mdp==$confMdp){
                                                 if(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
                                                 	 $rq=$this->user->get_by_mail($mail);

													 if ($rq==null){

														echo "Votre compte a été correctement ajouté";
														 $resultat = $this->user->ajouter_user(
															 $nom,
															 $prenom,
															 $mail,
															 $_POST["classement"],
															 0,
															 $mdp
															 );


														 $resultat2=$this->user->get_by_mail($mail);
														 if ($resultat2->id==null){
															 echo "Nous n'avons pas de correspondance pour cet email";
														 }

														 else{
														 $_SESSION['id']=$resultat2->id;
														 $_SESSION['mail']=$resultat2->mail;
														 $_SESSION['nom']=$resultat2->nom;
														 $_SESSION['prenom']=$resultat2->prenom;
														 $_SESSION['classement']=$resultat2->classement;
														 $_SESSION["admin"]=$resultat2->statut;
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
														 $this->load->model('inscription_en_attente_model', 'inscription');
														 $this->inscription->ajouter_inscription(

														 $_SESSION['nom'],
														 $_SESSION['prenom'],
														 $_SESSION['mail'],
														 $_SESSION['id']

													 	);
														 }


                                                     }
                                                     else{
														 $this->load->view('inscription_view',$data);
                                                         echo "L'email que vous avez renseigné est déjà utilisé ! Essayer de vous connecter";
                                                     }
                                                 }
                                                 else{
                                                 	$this->load->view('inscription_view',$data);
                                                     echo "votre adresse mail est incorrecte, Veuillez vérifier";
                                                 }
                                             }
                                             else{
                                             $this->load->view('inscription_view',$data);
                                                 echo "Il y a une erreur dans votre mot de passe, veuillez taper au minimum 4 caractere";
                                             }
                                         }
                                         else{
                                         $this->load->view('inscription_view',$data);
                                             echo "Votre prenom doit contenir au moins 2 caracteres et il ne peut contenir que des lettres ";
                                         }
                                     }
                                     else{
                                     $this->load->view('inscription_view',$data);
                                             echo "Votre nom doit contenir au moins 2 caracteres et il ne peut contenir que des lettres";
                                         }
                                 }
                                 else {
                                 $this->load->view('inscription_view',$data);
                                     echo "remplissez tous les champs!!";
                                 }
                             }
                         }


    	echo "coucou";
    }

}
