<?php
session_start();
class User extends CI_Controller
{

	public function __construct()
        	{

        		parent::__construct();



        }
    public function mon_espace()
    {
		$this->load->model('reservation_model', 'reservation');
		$reservations=$this->reservation->get_element_by_id_client($_SESSION['id']);
		$reservations_liste=array();
		$today=date('Y-m-d');
		$today=new DateTime($today);


		foreach ($reservations as $r){
			$equals=false;
			//var_dump($r);
			$date_reservation=$r->date;
			$date_reservation= new DateTime($date_reservation);

			if($date_reservation>=$today){

				$timeslot=$r->timeslot;
				$timeslot=explode("-",$timeslot);
				//var_dump($timeslot);
				$heure_debut=$timeslot[0];
				$heure_fin=$timeslot[1];
				foreach($reservations_liste as $reservation){
					if($reservation['numero_reservation']==$r->numero_reservation){
						$timeslot_reserv=$reservation['timeslot'];
						$timeslot_reserv_heure_debut=explode('-',$timeslot_reserv);
						$ts_debut=$timeslot_reserv_heure_debut[0];
						$timeslot_reserv_heure_fin=explode('-',$r->timeslot);
						$timeslot_reserv_heure_fin=$timeslot_reserv_heure_fin[1];
						$timeslot_reserv[1]=$timeslot_reserv_heure_fin;
						$reservations_liste[$r->numero_reservation]['timeslot']=$ts_debut.'-'.$timeslot_reserv_heure_fin;
						$equals=true;

					}
				}

			}
			if($equals==false){
				$reservation= array(
				'date'=>$r->date,
				'timeslot'=>$r->timeslot,
				'terrain'=>$r->terrain,
				'numero_reservation'=>$r->numero_reservation

			);
			$reservations_liste[$r->numero_reservation]=$reservation;

			}

		}
		$data['liste_reservation']=$reservations_liste;
		$this->load->view("mon_espace_view",$data);

    }
	public function profil_view(){
		$data["donnees"]=1;
		$this->load->view('mon_espace_view',$data);

	}
	public function mes_reservations(){

		$this->mon_espace();

	}
	public function supprimer(){

		if(isset($_GET['numero'])){
			$this->load->model('reservation_model', 'reservation');
			$this->reservation->delete_booking_numeroReservation($_GET['numero']);
			$this->mon_espace();

		}
	}

    public function verif_modif(){
    		$this->load->model('utilisateurs_model', 'user');

			$nom="";
			$prenom="";
			$mail="";
			$classement=$_POST['classement_joueur'];
			$data=array();
			 if (isset($_POST['nom'])||isset($_POST["prenom"])||isset($_POST["mail"])){
					 $nom=htmlspecialchars($_POST["nom"]);
					 $prenom=htmlspecialchars($_POST["prenom"]);
					 $mail=$_POST["mail"];
					 $data=["nom"=>$nom,"prenom"=>$prenom,"mail"=>$_SESSION['mail'],"classement"=>$_POST['classement_joueur']];
					 if ($_POST['nom']!="" && $_POST['prenom']!=""){

						 if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $nom)){
							 if(preg_match("#^[a-zA-Zéèçàùê-]{2,30}$#", $prenom)){

										 $rq=$this->user->get_by_mail($_SESSION['mail']);
											echo "Votre compte a été correctement modifié";
											 $this->user->update_user(
												 $rq->id,
												 $nom,
												 $prenom,
												 $rq->mail,
												 $classement,
												 $rq->statut,
												 $rq->mdp,
												 $rq->abonnement
												 );
												 $_SESSION['nom']=$nom;
												 $_SESSION['prenom']=$prenom;
												 $_SESSION['classement']=$classement;
												 $this->load->view('profil_view',$data);

							 }

						 }
						 else{
							$this->load->view('profil_view',$data);
							echo "Votre prenom doit contenir au moins 2 caracteres et il ne peut contenir que des lettres ";
						 }
					 }
					 else{
						$this->load->view('profil_view',$data);
						echo "Votre nom doit contenir au moins 2 caracteres et il ne peut contenir que des lettres";
					}
				}
				 else {
					$this->load->view('profil_view',$data);
					echo "remplissez tous les champs!!";
				 }

			 }
	public function modifier_mot_de_passe(){

		$data['modification_view']=1;
		$this->load->view("mon_espace_view",$data);
	}
	public function verif_modification_mot_de_passe(){
		$this->load->model('utilisateurs_model', 'user');
		$joueur=$this->user->get_by_id($_SESSION['id']);
		$old_mdp=sha1($_POST['old_password']);
		$new_mdp1=$_POST['new_password1'];
		$new_mdp2=$_POST['new_password2'];

		if($old_mdp==$joueur->mdp){

			if($new_mdp1!=""&&strlen($new_mdp1)>=4&&$new_mdp2!=""&&strlen($new_mdp2)>=4){

				if($new_mdp1==$new_mdp2){

					$new_mdp1=sha1($_POST['new_password1']);
                    $this->user->update_user($joueur->id,$joueur->nom,$joueur->prenom,$joueur->mail,$joueur->classement,$joueur->statut,$new_mdp1,$joueur->abonnement);
                    echo "<div class='alert alert-success'>Mot de passe modifié</div>";
                    $this->load->view('profil_view');
				}
				else{

					echo "<div class='alert alert-danger'>la confirmation du nouveau mot de passe n'est pas correcte</div>";

                    		 		$this->load->view("modifier_mot_de_passe_view");
				}


		 	}
		 	else{
		 		echo "<div class='alert alert-danger'>le nouveau mot de passe n'est pas valide, il doit contenir au moins 4 caractères</div>";

		 		$this->load->view("modifier_mot_de_passe_view");
		 	}


        }
        else{
			echo "<div class='alert alert-danger'>l'ancien mot de passe est incorrecte</div>";
        	$this->load->view("modifier_mot_de_passe_view");

        }
	}
	public function mes_commandes(){

		$this->load->model('commande_admin_model', 'commandeadmin');
		$this->load->model('commande_model', 'commande');
		$this->load->model('shop_model', 'shop');
		$mes_commandes=$this->commandeadmin->get_by_id_client($_SESSION['id']);
		$liste=array();
		foreach($mes_commandes as $c){

			array_push($liste,$c);
		}
		$data['mes_commandes']=$liste;
		$this->load->view('mon_espace_view',$data);


	}
	public function commande_detail(){

		if (isset($_GET['id'])){
			$this->load->model('commande_admin_model', 'commandeadmin');
			$this->load->model('commande_model', 'commande');
			$this->load->model('shop_model', 'shop');
			$liste=array();
			$data=array();
			$articles=$this->commande->get_by_bon_com($_GET['id']);
			foreach($articles as $a){
				$donnees=array();
				$donnee_article=$this->shop->get_by_id($a->id_item);
				array_push($donnees,$a->bon_com);
				$data['bon_com']=$a->bon_com;
				array_push($donnees,$donnee_article->nom_item);
				array_push($donnees,$donnee_article->img_item);
				array_push($donnees,$a->qte_item);
				array_push($donnees,$a->prix_item);

				array_push($liste,$donnees);

			}
			$data["articles_commande"]=$liste;

			$this->load->view("user_commande_detail_view",$data);



		}

	}
	public function mes_cordages(){
		$this->load->model('cordage_admin_model', 'cordage');
		$mes_cordages=$this->cordage->get_by_id_client($_SESSION['id']);
		$liste=array();
		foreach($mes_cordages as $c){

			array_push($liste,$c);
		}
		$data['mes_cordages']=$liste;
		$this->load->view('mon_espace_view',$data);

	}

}

