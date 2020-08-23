<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inscription_en_attente_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="inscription_en_attente";
	}

	public function select_all(){
    			$result = $this->db->select('*')->from('inscription_en_attente')->get();

        		return $result->result();

        	}
    public function ajouter_inscription($nom,$prenom,$mail,$id)
    	{


    		//	Ces données seront automatiquement échappées
				$data=array(
					"nom"=>$nom,
					"prenom"=>$prenom,
					"mail"=>$mail,
					"id_joueur"=>$id

				);
				$this->db->insert($this->table,$data);
								if($this->db->affected_rows()>0){
									return true;
								}
								else{
									return false;
								}
	}
	public function delete_inscription_en_attente($id){


                     		$this->db->delete('inscription_en_attente', array('id' => $id));

                     	 }
}
