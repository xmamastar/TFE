<?php
session_start();
class test_book extends CI_Controller
{

	public function book(){
		$this->load->model('reservation_model', 'reservation');
		$this->load->view('test_view');
	}





}
