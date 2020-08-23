<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tournoi_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="tournoi";
	}

	public function select_all(){
		$result = $this->db->select('*')->from('tournoi')->get();

		return $result->result();
	}
	public function delete($id){


		$this->db->delete('tournoi', array('id_tournoi' => $id));

	 }
	 public function insert($nom,$date_debut,$date_fin){

	 	//var_dump($id_client);
            		$data = array(
            				'nom_tournoi' => $nom,
            				'date_debut' => $date_debut,
            				'date_fin'=>$date_fin


            		);

            		$this->db->insert('tournoi', $data);





	 }
}




