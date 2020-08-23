<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cordage_admin_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="cordageadmin";
	}
	public function select_all(){
    		$result = $this->db->select('*')->from('cordageadmin')->get();

    		return $result->result();

    	}
    public function insert($bon_cordage,$type_cordage,$prix_cordage,$tension,$id_client,$nom){
	$data=array(
		"bon_cordage"=>$bon_cordage,
		"type_cordage"=>$type_cordage,
		"prix_cordage"=>$prix_cordage,
		"tension"=>$tension,
		"id_client"=>$id_client,
		"nom"=>$nom

		);
		$this->db->insert($this->table,$data);
						if($this->db->affected_rows()>0){
							return true;
						}
						else{
							return false;
						}

        }
        public function update_pret($bon_com){

				$data = array(
						'pret' => 1

				);
				$this->db->update('cordageadmin', $data, "bon_cordage =".$bon_com);



        }
        public function update_recup($bon_com){

        				$data = array(
        						'retirer' => 1

        				);
        				$this->db->update('cordageadmin', $data, "bon_cordage =".$bon_com);



                }
		public function get_by_id_client($id_client){

			$date_result = $this->db->select('*')->from('cordageadmin')->where('id_client',$id_client)->get();
            return $date_result->result();

		}




}
