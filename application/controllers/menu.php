<?php
class Menu extends CI_Controller
{
	public function accueil()
    {

    	$this->load->view('accueil_view');
    }
    public function reservation()
	{

		$this->load->view('reservation_view');
	}
	public function shop()
	{

		$this->load->view('shop_view');
	}
	public function inscription(){

		$this->load->view('inscription_view');
	}
	public function connexion(){
		$this->load->view('connexion_view');
	}

}
?>
