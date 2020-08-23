<?php

class Test extends CI_Controller
{
	public function accueil()
    	{
    		$this->load->view('accueil');
    	}

    public function connexion()
    {
    	//	Chargement de la bibliothèque
    	$this->load->library('form_validation');

    	$this->form_validation->set_rules('pseudo', '"Nom d\'utilisateur"', 'required');
    	$this->form_validation->set_rules('mdp',    '"Mot de passe"',       'required');

    	if($this->form_validation->run())
    	{
    		//	Le formulaire est valide
    		$pseudo = $this->input->post('pseudo');
            $mdp = $this->input->post('mdp');
            $data=array();
            $data["pseudo"]=$pseudo;
            $data["mdp"]=$mdp;

    		$this->load->view('connexion_reussi',$data);
    	}
    	else
    	{
    		//	Le formulaire est invalide ou vide
    		$this->load->view('accueil');
    	}
    }


}
