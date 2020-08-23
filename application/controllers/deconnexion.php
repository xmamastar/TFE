<?php
session_start();
class Deconnexion extends CI_Controller
{
	public function deco(){
		session_unset();
        session_destroy();
		redirect(base_url()."connexion/form_connexion");

	}


}
