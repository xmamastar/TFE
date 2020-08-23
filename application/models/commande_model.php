<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class commande_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="commande";
	}


		public function get_by_bon_com($id){
			$commande = $this->db->select('*')->from('commande')->where('bon_com', $id)->get();
             return $commande->result();

		}
        public function ajouter_commande($bon_commande,$id_item,$qte_item,$prix_item)
        	{


        		//	Ces données seront automatiquement échappées
        				$data=array(
        					"bon_com"=>$bon_commande,
        					"id_item"=>$id_item,
        					"qte_item"=>$qte_item,
        					"prix_item"=>$prix_item,

        				);



                		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
                		$this->db->insert($this->table,$data);
                		if($this->db->affected_rows()>0){
                			return true;
                		}
                		else{
                			return false;
                		}
        	}




}
