<?php
session_start();
class Tournoi extends CI_Controller
{
	public function __construct()
				{

					parent::__construct();



			}
	private function get_tournoi_a_venir(){
		$tournoi_a_venir=array();
		$this->load->model('tournoi_model', 'tournoi');
		$this->load->model('joueur_tournoi_model', 'joueur_tournoi');
		$all_tournoi=$this->tournoi->select_all();
		$today=date("Y-m-d");
		$today=new DateTime($today);
		foreach($all_tournoi as $t){
			$tournoi=array();
			$debut=new DateTime($t->date_debut);
			$fin=new DateTime($t->date_fin);
			if($debut>$today){
				$count_inscription=0;
				$tournoi['id_tournoi']=$t->id_tournoi;
				$tournoi['debut']=$t->date_debut;
				$tournoi['fin']=$t->date_fin;
				$inscrits=$this->joueur_tournoi->get_inscrit_tournoi($t->id_tournoi);
				foreach($inscrits as $i){
					$count_inscription+=1;
				}
				$tournoi['nb_inscrit']=$count_inscription;
				array_push($tournoi_a_venir,$tournoi);

			}




		}
		return $tournoi_a_venir;


	}
	private function get_tournoi_en_cours(){
		$tournoi_en_cours=array();
		$this->load->model('tournoi_model', 'tournoi');
		$all_tournoi=$this->tournoi->select_all();
		$today=date("Y-m-d");
		$today=new DateTime($today);
		foreach($all_tournoi as $t){
			$debut=new DateTime($t->date_debut);
			$fin=new DateTime($t->date_fin);
			$tournoi=array();
			if($debut<=$today&&$fin>=$today){
				$tournoi['id_tournoi']=$t->id_tournoi;
				$tournoi['debut']=$t->date_debut;
				$tournoi['fin']=$t->date_fin;
				array_push($tournoi_en_cours,$tournoi);

			}




		}
		return $tournoi_en_cours;


	}
	public function accueil($msg=null)
    	{
    		if(isset($_GET['cat_tournoi'])){
    			$data['cat_tournoi']=$_GET['cat_tournoi'];
    			
    		}

			$tournoi_a_venir=$this->get_tournoi_a_venir();
			$tournoi_en_cours=$this->get_tournoi_en_cours();
			$data["tournoi_a_venir"]=$tournoi_a_venir;
			$data["tournoi_en_cours"]=$tournoi_en_cours;
			$data["msg"]=$msg;
    		$this->load->view('tournoi_view',$data);
    	}
	public function s_inscrire(){

		if(isset($_GET['id'])){
			$this->load->model('joueur_tournoi_model', 'joueur_tournoi');
			$inscrits=$this->joueur_tournoi->get_inscrit_tournoi($_GET['id']);
			$is_in_tournoi=false;
			$nb_inscrit=0;
			foreach($inscrits as $i){
				if ($i->id_joueur==$_SESSION['id']){

					$is_in_tournoi=true;


				}
				$nb_inscrit+=1;

			}
			if($is_in_tournoi==true){
				$msg="<div class='alert alert-danger'>Vous etes déjà inscrit</div>";
				$this->accueil($msg);
				return;
			}
			if($nb_inscrit>=8){
				$msg="<div class='alert alert-danger'>Le tournoi est complet</div>";
				$is_in_tournoi=true;
				$this->accueil($msg);
				return;

			}
			if ($is_in_tournoi==false&&$nb_inscrit<8){
				$this->joueur_tournoi->insert($_SESSION['id'],$_SESSION['classement'],$_GET['id']);
				$msg="<div class='alert alert-success'>Votre inscription est acceptée</div>";
				$this->accueil($msg);
				return;

			}



		}

	}
	public function tableau(){
		$liste_classements=["NC","C30.6","C30.5","C30.4","C30.3","C30.2","C30.1","C30.0","C15.5","C15.4","C15.3","C15.2","C15.1","C15","B4/6","B2/6","B0","B-2/6","B-4/6","B-15","B-15.1","B-15.2","B-15.4","A Nat","A int"];
		$liste_classement_indice=array();
		$count=0;
		$joueur_tete1=null;
		$joueur_tete2=null;
		$tete_de_serie1_indice=0;
		$tete_de_serie2_indice=0;
		$this->load->model('match_tournoi_model', 'match');
		foreach($liste_classements as $c){
			$liste_classement_indice[$c]=$count;
			$count+=1;
		}
		if (isset($_GET['id'])){
			$this->load->model('joueur_tournoi_model', 'joueur_tournoi');
			$this->load->model('utilisateurs_model', 'utilisateurs');
			$liste_id=array();
			$liste_joueurs=array();
			$inscrits=$this->joueur_tournoi->get_inscrit_tournoi($_GET['id']);
			foreach($inscrits as $i){
				array_push($liste_id,$i->id_joueur);

			}
			foreach($liste_id as $j){
				$donnees_joueur=$this->utilisateurs->get_by_id($j);
				array_push($liste_joueurs,$donnees_joueur);

			}
			shuffle($liste_joueurs);
			foreach($liste_joueurs as $joueur){
				if ($liste_classement_indice[$joueur->classement]>$tete_de_serie1_indice){
					$tete_de_serie2_indice=$tete_de_serie1_indice;
					$tete_de_serie1_indice=$liste_classement_indice[$joueur->classement];
					$joueur_tete2=$joueur_tete1;
					$joueur_tete1=$joueur;

				}
				else if($liste_classement_indice[$joueur->classement]>$tete_de_serie2_indice){

					$tete_de_serie2_indice=$liste_classement_indice[$joueur->classement];
					$joueur_tete2=$joueur;
				}
			}
			unset($liste_joueurs[array_search($joueur_tete2, $liste_joueurs)]);
			unset($liste_joueurs[array_search($joueur_tete1, $liste_joueurs)]);
			array_unshift($liste_joueurs, $joueur_tete1);
			array_push($liste_joueurs,$joueur_tete2);
			$compteur=1;
			for ($i=0;$i<count($liste_joueurs);$i+=2){
				$this->match->insert($liste_joueurs[$i]->id,$liste_joueurs[$i+1]->id,$_GET['id'],"Quart/".$compteur);
				$compteur+=1;
			}
			var_dump($liste_joueurs);
			var_dump(count($liste_joueurs));





		}


	}
	public function create_tableau(){
		$liste_match=array();
    		 if (isset($_GET['id'])){
    			$this->load->model('match_tournoi_model', 'match');
    			$this->load->model('utilisateurs_model', 'utilisateurs');
    			$matchs=$this->match->get_match_tournoi($_GET['id']);
    			foreach ($matchs as $m){
    				$joueur1=$this->utilisateurs->get_by_id($m->id_joueur1);
    				$joueur2=$this->utilisateurs->get_by_id($m->id_joueur2);
    				$match[0]=$joueur1;
    				$match[1]=$joueur2;
    				$match[2]=$m->vainqueur;
    				$match[3]=$m->id;
    				$match[4]=$m->statut;
    				array_push($liste_match,$match);

    			}


    		}

		$data['liste_match']=$liste_match;
		$this->load->view("tableau_view2",$data);
    	}
    	public function encoder_match(){
    		$liste_donnees_joueur=array();
    		if(isset($_GET['id'])){
    			$data['id']=$_GET['id'];
    			$this->load->model('match_tournoi_model', 'match');
    			$match=$this->match->get_match($_GET['id']);
    			$nom_joueur1="";
    			$nom_joueur2="";
    			$id_joueur1="";
    			$id_joueur2="";
    			$this->load->model('utilisateurs_model', 'utilisateurs');
    			foreach($match as $m){

					$data['statut']=$m->statut;
					if (isset($m->id_joueur1)){
						$joueur1=$this->utilisateurs->get_by_id($m->id_joueur1);
						$nom_joueur1=$joueur1->nom;
					}

					//var_dump($joueur1);

					$data['id_tournoi']=$m->id_tournoi;
					$data['id_match']=$m->id;
					if (isset($m->id_joueur2)){
                    	$joueur2=$this->utilisateurs->get_by_id($m->id_joueur2);
                    	$nom_joueur2=$joueur2->nom;
                    }


					$id_joueur1=$m->id_joueur1;
					$id_joueur2=$m->id_joueur2;

    			}
    			$data['joueur1']=$nom_joueur1;
    			$data['joueur2']=$nom_joueur2;
    			$data['id_joueur1']=$id_joueur1;
    			$data['id_joueur2']=$id_joueur2;

    			$this->load->view('encoder_match_view',$data);

    		}


    	}

    	public function encoder_match_verif(){
    	$score="";
    	$joueur="";
    	$num_joueur=0;
    	$id_vainqueur;
    	$statut="";
    	$id_match=$_POST["id_match"];
    	$vainqueur=$_POST["vainqueur"];
    	if($_POST["score2_set3"]==0&&$_POST["score1_set3"]==0){

			if($_POST['vainqueur']==1){
				$joueur=$_POST["joueur1"];
				$id_vainqueur=$_POST['id_joueur1'];
				$score=$_POST["score1_set1"]."/".$_POST["score2_set1"].' '.$_POST["score1_set2"].'/'.$_POST["score2_set2"];
			}
			else{
				$joueur=$_POST["joueur2"];
                $id_vainqueur=$_POST['id_joueur2'];
				$score=$_POST["score2_set1"]."/".$_POST["score1_set1"].' '.$_POST["score2_set2"].'/'.$_POST["score1_set2"];
			}


    	}
    	else{
			if($_POST['vainqueur']==1){
				$joueur=$_POST["joueur1"];
                $id_vainqueur=$_POST['id_joueur1'];
				$score=$_POST["score1_set1"]."/".$_POST["score2_set1"].' '.$_POST["score1_set2"].'/'.$_POST["score2_set2"].' '.$_POST["score1_set3"].'/'.$_POST["score2_set3"];
			}
			else{
				$joueur=$_POST["joueur2"];
                $id_vainqueur=$_POST['id_joueur2'];
				$score=$_POST["score2_set1"]."/".$_POST["score1_set1"].' '.$_POST["score2_set2"].'/'.$_POST["score1_set2"].' '.$_POST["score2_set3"].'/'.$_POST["score1_set3"];
			}



    	}
    	$liste_statut=explode('/',$_POST['statut']);
    	if($liste_statut[0]=="Quart"){
    		if(intval($liste_statut[1])==1||intval($liste_statut[1])==2){
				if(intval($liste_statut[1])==1){
					$num_joueur=1;
				}
				if(intval($liste_statut[1])==2){
					$num_joueur=2;
				}
    			$statut="Demi/1";

    		}
    		else{
    			if(intval($liste_statut[1])==3){
					$num_joueur=1;
				}
				if(intval($liste_statut[1])==4){
					$num_joueur=2;
				}
    			$statut="Demi/2";
    		}
    	if($liste_statut[0]=="Demi")
    		$statut="Final/1";

    	}
    	$this->load->model('match_tournoi_model', 'match');
    	$match_suivant=$this->match->get_match_by_statut($statut,$_POST['id_tournoi']);
    	if($match_suivant==null){
			if($num_joueur==1){
				$this->match->insert($id_vainqueur,null,$_POST['id_tournoi'],$statut,null,null,0);
			}
			else{
				//$this->match->insert(null,$id_vainqueur,null,null,0,$_POST['id_tournoi'],$statut);
				$this->match->insert(null,$id_vainqueur,$_POST['id_tournoi'],$statut,null,null,0);
			}

    	}
    	else{
    		foreach($match_suivant as $match){
    			if($num_joueur==1){

				$this->match->update_joueur1($match->id,$id_vainqueur);
			}
			else{
				$this->match->update_joueur2($match->id,$id_vainqueur);
			}

    		}


    	}
    	//$match=$this->match->get_match($_post['id_match']);

    	//$this->match->update_score($score,$id_match,$vainqueur);
    	//$this->match->insert()

    }








}
