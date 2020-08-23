<?php
session_start();
class Admin extends CI_Controller
{

	public function __construct()
    	{

    		parent::__construct();



    }
	private function count_inscription(){
		$this->load->model('inscription_en_attente_model', 'inscription');
            	$count=0;
        		$inscription_en_attente=$this->inscription->select_all();
        		foreach($inscription_en_attente as $i){
        			$count+=1;
        		}
        		return $count;
	}
	private function count_commandes(){
		$count=0;
		$this->load->model('commande_admin_model', 'commande');
		$commandes_en_attente=$this->commande->select_all();
		foreach($commandes_en_attente as $c){
			$count+=1;

		}
		return $count;

	}
    public function admin_view(){

		$data['count']=$this->count_inscription();
		$data['abonnement_en_attente']=$this->count_commandes();
		$this->load->view('admin_view',$data);
    }
	public function admicom(){


	}
	public function admitournoi(){


	}
	public function annonce(){
		if ($_SESSION["admin"]!=1){
                header ("location: index.php");
                echo "vous n'etes pas Administrateur";
        }
            else{

            if (isset($_POST['titre'])||isset($_POST["texte"])||isset($target_file)||isset($img_item))
                {
                	var_dump($_POST['titre']);
                	var_dump($_POST["texte"]);
                    $titre=htmlspecialchars($_POST["titre"]);
                    $texte=htmlspecialchars($_POST["texte"]);
                    $date=date("Y-m-d g:i");
                    var_dump($date);
                    $target_dir ="./css/images/annonces/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $img_item = basename($_FILES["fileToUpload"]["name"]);
                    if ($_POST['titre']!="" && $_POST['texte']!="")
                    {
                        if(preg_match("#^[a-zA-Z0-9- \'\.\,\,\;\-\_\+\!\?\&\é\@\"\#\è\à\ç\€\$\ù\%\:\)\(\* ]{2,30}$#", $titre))
                        {
                                if(preg_match("#^[a-zA-Z0-9- \'\.\,\,\;\-\_\+\!\?\&\é\@\"\#\è\à\ç\€\$\ù\%\:\)\(\* ]{1,1000}$#", $texte))
                                {
										$this->load->model('annonce_model', 'annonce');
										$annonces=$this->annonce->get_by_titre($titre);
										if($annonces!=null){
											echo "<div class='alert alert-danger' role='alert'> Une annonce avec le même titre existe déjà</div>";
										}


                                        else
                                        {

                                         if(isset($_FILES['fileToUpload'])){


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
                                            }
                                            else {
                                              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                                //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                                //echo "Votre compte a été correctement ajouté";

                                              $this->annonce->insert_annonce($titre,$texte,$img_item,$date);


                                              echo "<div class='alert alert-success' role='alert'>Annonce créée</div>";

                                              } else {
                                                echo "<div class='alert alert-danger' role='alert'>Il y a eu une erreur lors du chargement de votre fichier</div>";
                                              }
                                            }
                                          }
									  else{
										  $this->annonce->insert_annonce_without_img($titre,$texte,$date);

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
                    //redirect(base_url()."index/accueil");

                }
		}

	}
	public function annonce_view(){

		$this->load->view('creation_annonce_view');

	}

	public function recherche_joueur(){
		$this->load->model('utilisateurs_model', 'user');
        $joueurs=$this->user->select_all();
        $liste_user=array();
        foreach($joueurs as $j){
        	if (strpos($j->mail,$_POST['recherche'])!==False){
        		array_push($liste_user,$j);

        	}

        }
        $data['count']=$this->count_inscription();
        $data['abonnement_en_attente']=$this->count_commandes();
        $data['liste_user']=$liste_user;
        $this->load->view('admin_view',$data);


	}
	public function list_users(){

		$this->load->model('utilisateurs_model', 'user');
		$joueurs=$this->user->select_all();
		$liste=$joueurs;
		$data['liste_user']=$liste;
		$data['count']=$this->count_inscription();
		$data['count']=$this->count_inscription();
        $data['abonnement_en_attente']=$this->count_commandes();
		$this->load->view('admin_view',$data);

	}
	public function modification_user(){
		if ($_GET['id']!=null){
			$this->load->model('utilisateurs_model', 'user');
			$this->load->model('abonnement_model', 'abonnement');
			$abonnements=$this->abonnement->select_all();
			$liste_abo=array();
			foreach($abonnements as $abo){
				$liste=array(
				'nom'=>$abo->nom,
				'id'=>$abo->id,
				'heure_max'=>$abo->heure_max
				);
				array_push($liste_abo,$liste);
			}
			$joueur=$this->user->get_by_id($_GET['id']);
			$data=array();
			$donnee_joueur=$joueur;
			$data["joueur"]=$donnee_joueur;
			$data['abonnements']=$liste_abo;
			$data['count']=$this->count_inscription();
            $data['abonnement_en_attente']=$this->count_commandes();
			$this->load->view('user_modif_view',$data);


		}
	}
	public function list_abonnements(){
		$this->load->model('abonnement_model', 'abonnement');
		$abonnement=$this->abonnement->select_all();
		$data["abonnement"]=$abonnement;
		$data['count']=$this->count_inscription();
        $data['abonnement_en_attente']=$this->count_commandes();
		$this->load->view('admin_view',$data);

	}
	public function modifier_user(){

		$this->load->model('utilisateurs_model', 'user');
		$get_by_mail=$this->user->get_by_mail($_POST['mail_joueur']);
		$_POST['statut_joueur']=intval($_POST['statut_joueur']);
		var_dump($_POST["abonnement_joueur"]);

		if ($get_by_mail==null){


				$this->user->update_user($_POST['id_joueur'],$_POST['nom_joueur'],$_POST['prenom_joueur'],$_POST['mail_joueur'],$_POST['classement_joueur'],$_POST['statut_joueur'],$_POST["mdp_joueur"],$_POST["abonnement_joueur"]);

                redirect(base_url()."admin/modification_user?id=".$_POST['id_joueur']);

		}

		else{
			if($get_by_mail->mail==$_POST['mail_joueur']){
				$this->user->update_user($_POST['id_joueur'],$_POST['nom_joueur'],$_POST['prenom_joueur'],$_POST['mail_joueur'],$_POST['classement_joueur'],$_POST['statut_joueur'],$_POST["mdp_joueur"],$_POST["abonnement_joueur"]);

                                redirect(base_url()."admin/modification_user?id=".$_POST['id_joueur']);

			}
			else{

				echo "L'email est déjà attribuer à un autre utilisateur";
                redirect(base_url()."admin/modification_user?id=".$_POST['id_joueur']);
			}



		}


	}
	public function supprimer_user(){
			if ($_GET['id']!=null){
            			$this->load->model('utilisateurs_model', 'user');
            			$joueur=$this->user->delete_element($_GET['id']);
            			redirect(base_url()."admin/list_users");


            		}


	}
	public function inscription_en_attente(){
		$this->load->model('inscription_en_attente_model', 'inscription');

		$liste=array();
		$result=$this->inscription->select_all();
		if ($result !=null){

			foreach($result as $r)
			{
				array_push($liste,$r);

			}

		}
		$data['liste']=$liste;
		$data['count']=$this->count_inscription();
        $data['abonnement_en_attente']=$this->count_commandes();
		$this->load->view('admin_view',$data);

	}
	public function suppression_inscription(){
		if (isset($_GET['id'])&&isset($_GET["id_joueur"])){
        			$id=$_GET['id'];
        			$id_joueur=$_GET['id_joueur'];
        			$this->load->model('inscription_en_attente_model', 'inscription');
        			$this->delete_inscription($id_joueur);
        			$this->inscription->delete_inscription_en_attente($id);
        			redirect(base_url()."admin/inscription_en_attente");

        		}

	}
	public function delete_inscription($id){
		$this->load->model('utilisateurs_model', 'user');
		$this->user->delete_element($id);

	}
	public function update($id_joueur,$abonnement){
		$this->load->model('utilisateurs_model', 'user');
		$joueur=$this->user->get_by_id($id_joueur);
		$this->user->update_user($id_joueur,$joueur->nom,$joueur->prenom,$joueur->mail,$joueur->classement,$joueur->statut,$joueur->mdp,$abonnement);


	}
	public function validation_inscription(){
		if (isset($_GET['id'])&&isset($_GET["id_joueur"])){
			$id=$_GET['id'];
			$id_joueur=$_GET['id_joueur'];
			$this->load->model('inscription_en_attente_model', 'inscription');
			$this->update($id_joueur,1);
			$this->inscription->delete_inscription_en_attente($id);
			redirect(base_url()."admin/inscription_en_attente");

		}

	}
	public function ajouter_abonnement(){
		$this->load->view('ajout_abonnement_view');
	}
	public function ajout_abonnement(){
		$this->load->model('abonnement_model', 'abonnement');
		if(isset($_POST["nom_abonnement"])&&isset($_POST["heure_max"])){
			$this->abonnement->ajouter_abonnement($_POST["nom_abonnement"],$_POST["heure_max"]);

		}
		redirect(base_url()."admin/list_abonnements");

	}
	public function modifier_abonnement_existant(){

		if (isset($_GET["id"])){
			$this->load->model('abonnement_model', 'abonnement');
			$abo=$this->abonnement->get_by_id($_GET["id"]);
			$this->abonnement->modifier_abonnement($abo->id,$abo->nom,$abo->heure_max);


		}
		redirect(base_url()."admin/list_abonnements");

	}
	public function modifier_abonnement_existant_view(){
		$data= array();
		$this->load->model('abonnement_model', 'abonnement');
        $abo=$this->abonnement->get_by_id($_GET["id"]);
        var_dump($abo);
        foreach($abo as $a){
        	$data['nom']=$a->nom;
            $data['heure_max']=$a->heure_max;
            $data['id']=$a->id;
        }
		$data['count']=$this->count_inscription();
        $data['abonnement_en_attente']=$this->count_commandes();
		$this->load->view('modification_abonnement_view',$data);
	}
	public function supprimer_abonnement(){

		if (isset($_GET['id'])){
			$this->load->model('abonnement_model', 'abonnement');
                    $abo=$this->abonnement->delete_by_id($_GET["id"]);


		}
		redirect(base_url()."admin/list_abonnements");

	}
	public function admin_com(){

		$this->load->model('commande_admin_model', 'commandeadmin');
		$commandes=$this->commandeadmin->select_all();
		$liste=array();
		foreach($commandes as $c){

			array_push($liste,$c);
		}
		$data['commandes']=$liste;
		$data['count']=$this->count_inscription();
        $data['abonnement_en_attente']=$this->count_commandes();
		$this->load->view('admin_view',$data);
	}
	public function commande_prete(){
		if (isset($_GET['id'])){
			$this->load->model('commande_admin_model', 'commandeadmin');
			$commande=$this->commandeadmin->get_by_id($_GET['id']);
			foreach($commande as $c){
				$this->commandeadmin->modif_commande($_GET['id'],$c->id_client,$c->nom_client,$c->date_com,$c->prix,$c->recu,1);

			}

		}
		redirect(base_url()."admin/admin_com");



	}
	public function commande_recue(){
		if(isset($_GET['val'])){
			$this->load->model('commande_admin_model', 'commandeadmin');
			$this->commandeadmin->delete($_GET['val']);
			/*$commande=$this->commandeadmin->get_by_id($_GET['val']);
			foreach($commande as $c){
				$this->commandeadmin->modif_commande($_GET['val'],$c->id_client,$c->nom_client,$c->date_com,$c->prix,1,$c->prete);

			}*/
		}

	redirect(base_url()."admin/admin_com");

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

			$this->load->view("commande_detail_view",$data);



		}

	}
	public function admin_tournoi(){

		$this->load->model('tournoi_model', 'tournois');
		$data['tournois']=$this->tournois->select_all();
		$this->load->view("admin_view",$data);

	}

	public function supprimer_tournoi(){

		$this->load->model('tournoi_model', 'tournois');
		$this->tournois->delete($_POST['id_tournoi']);
		$this->admin_tournoi();
	}
	public function creer_tournoi(){

		$this->load->view("creation_tournoi_view");

	}
	public function verif_tournoi(){
	if (isset($_POST['nom_tournoi'])||isset($_POST["date_debut"])||isset($_POST["date_fin"])){
		$nom_tournoi=htmlspecialchars($_POST["nom_tournoi"]);
		$date_debut=date($_POST["date_debut"]);
		$date_fin=date($_POST["date_fin"]);
		if ($_POST['nom_tournoi']!="" && $_POST['date_debut']!=""&& $_POST["date_fin"]!=""){
			if(preg_match("#^[1-9a-zA-Zéèçàùê-]{2,60}$#", $nom_tournoi)){
				if($_POST['date_debut']!=""&& $_POST["date_fin"]!=""){
				$this->load->model('tournoi_model', 'tournois');
				$this->tournois->insert($nom_tournoi,$date_debut,$date_fin);
					echo "<div class='alert alert-success' role='alert'>Tournoi crée</div>";
				}
				else{
					echo "<div class='alert alert-danger' role='alert'>Entrez des dates valides</div>";
				}

			}
			else{
				echo "<div class='alert alert-danger' role='alert'>Entrez un nom valide</div>";
			}

		}
		else{
			echo "<div class='alert alert-danger' role='alert'>Remplissez tout les champs</div>";
			}
	}
	$this->admin_tournoi();


	}
	public function liste_cordage(){

		$this->load->model('cordage_admin_model', 'cordage');
		$cordages=$this->cordage->select_all();
		$data['cordages']=$cordages;
		$this->load->view("admin_view",$data);

	}
	public function ajouter_cordage(){
		$this->load->model('cordages_model', 'cordage');
        $this->load->model('utilisateurs_model', 'utilisateurs');
		$data['cordages']=$this->cordage->select_all();
		//asort($data['cordages']);
        $data['users']=$this->utilisateurs->select_all();
        $this->load->view("ajout_cordage_view",$data);
	}
	public function verif_cordage(){
		$this->load->model('utilisateurs_model', 'utilisateurs');
		$this->load->model('cordages_model', 'cordage');
		$this->load->model('cordage_admin_model', 'cordages');
		$nom_joueur="";
		if(isset($_POST['tension'])){
        	$data=array();
        	$prix_cordage=0;
        	if(isset($_POST['mail'])){

        		$resultat=$this->utilisateurs->get_by_mail($_POST['mail']);
        		if($resultat!=null){
        			$id_client = $resultat->id;
        			$nom_joueur=$resultat->nom;
					$com= date('ymdHis');
					$bon_cordage = $id_client.$com;
					$type_cordage = $_POST['type_cordage'];


					$types=$this->cordage->get_by_type($type_cordage);
					foreach ($types as $t){
						$data['prix']=$t->prix_cordage;
						$prix_cordage=$t->prix_cordage;

					}
					$tension = $_POST['tension'];
					$this->cordages->insert($bon_cordage,$type_cordage,$prix_cordage,$tension,$id_client,$nom_joueur);
					$data['msg']="<div class='alert alert-success' role='alert'>Vous avez bien ajouté un cordage</div>";
					$data['cordages']=$this->cordage->select_all();
					//$data['users']=$this->utilisateurs->select_all();
					$this->load->view("ajout_cordage_view",$data);

        		}
        		else{
        			$data['msg']="<div class='alert alert-danger' role='alert'>Le joueur que vous avez mentionné n'existe pas</div>";
        			$data['cordages']=$this->cordage->select_all();
        			$data['tension']=$_POST['tension'];
        			$data['mail']=$_POST['mail'];
        			$this->load->view("ajout_cordage_view",$data);

        		}

        	}


        }

	}
	public function cordage_pret(){
		if (isset($_GET['id'])){
			$this->load->model('cordage_admin_model', 'cordages');
			$this->cordages->update_pret($_GET['id']);
			redirect(base_url()."admin/liste_cordage");


		}

	}
	public function cordage_recup(){
    		if (isset($_GET['id'])){
    			$this->load->model('cordage_admin_model', 'cordages');
    			$this->cordages->update_recup($_GET['id']);
    			redirect(base_url()."admin/liste_cordage");


    		}

    	}

}
