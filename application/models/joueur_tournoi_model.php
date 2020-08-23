<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class joueur_tournoi_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="joueur_tournoi";
	}

	public function select_all(){
		$result = $this->db->select('*')->from('tournoi')->get();

		return $result->result();
	}
	public function get_inscrit_tournoi($id){

		$date_result = $this->db->select('*')->from('joueur_tournoi')->where('id_tournoi',$id)->get();
                    return $date_result->result();
	}
	public function delete($id){


		$this->db->delete('tournoi', array('id_tournoi' => $id));

	 }
	 public function insert($id_joueur,$classement,$id_tournoi){

	 	//var_dump($id_client);
            		$data = array(
            				'id_joueur' => $id_joueur,
            				'classement' => $classement,
            				'id_tournoi'=>$id_tournoi


            		);

            		$this->db->insert('joueur_tournoi', $data);





	 }
}




