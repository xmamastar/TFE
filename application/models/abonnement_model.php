<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class abonnement_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="abonnement";
	}


    	public function get_by_id($id){

        		$abonnement = $this->db->select('*')->from('abonnement')->where('id', $id)->get();
        		return $abonnement->result();

        	}
        public function select_all(){
        		$result = $this->db->select('*')->from('abonnement')->get();

        		return $result->result();}
        public function ajouter_abonnement($nom,$heure_max)
        	{


        		//	Ces données seront automatiquement échappées
        				$data=array(
        					"nom"=>$nom,
        					"heure_max"=>$heure_max

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
        	public function modifier_abonnement($id,$nom,$heure_max){



                    	$data = array(

                                'nom' => $nom,
                                'heure_max' => $heure_max

                        );
                		$this->db->update('abonnement', $data, "id =".$id);

        	}
        	 public function delete_by_id($id){


                 		$this->db->delete('abonnement', array('id' => $id));

                 	 }



}
