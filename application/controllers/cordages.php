<?php
session_start();
class Cordages extends CI_Controller
{
	public function accueil(){
		$this->load->model('cordages_model', 'cordages');
		$c=$this->cordages->select_all();
		$data['cordages']=$c;
		$this->load->view("cordage_view",$data);

	}

}
