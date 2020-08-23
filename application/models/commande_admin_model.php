<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class commande_admin_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="commandeadmin";
	}

	public function select_all(){
		$result = $this->db->select('*')->from('commandeadmin')->get();

		return $result->result();}

	public function get_by_id_client($id){
    			$commande = $this->db->select('*')->from('commandeadmin')->where('id_client', $id)->get();
                 return $commande->result();

    		}
        public function ajouter_commande($bon_commande,$id_client,$nom_client,$date,$prix)
        	{


        		//	Ces données seront automatiquement échappées
        				$data=array(
        					"bon_com"=>$bon_commande,
        					"id_client"=>$id_client,
        					"nom_client"=>$nom_client,
        					"date_com"=>$date,
        					"prix"=>$prix

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
        public function get_by_id($id){

                		$commande = $this->db->select('*')->from('commandeadmin')->where('bon_com', $id)->get();
                		return $commande->result();

                	}
        public function modif_commande($id,$id_client,$nom_client,$date_com,$prix,$recu,$prete){



                            	$data = array(

                                        'id_client' => $id_client,
                                        'nom_client' => $nom_client,
                                        'date_com' => $date_com,
                                        'prix' => $prix,
                                        'recu' => $recu,
                                        'prete' => $prete,

                                );
                        		$this->db->update('commandeadmin', $data, "bon_com =".$id);

                	}
        public function delete($numero){


             		$this->db->delete('commandeadmin', array('bon_com' => $numero));

             	 }




}
