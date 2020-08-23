<?php

class Forum extends CI_Controller
{
	private $titre_defaut;

	public function __construct()
	{
		//	Obligatoire
		parent::__construct();

		//	Maintenant, ce code sera exécuté chaque fois que ce contrôleur sera appelé.
		//$this->titre_defaut = 'Mon super site';
		//echo 'Bonjour !';
	}

	public function index()
	{
		$this->load->view('test_view');
	}

	public function accueil()
	{
		var_dump($this->titre_defaut);
	}
}


?>
