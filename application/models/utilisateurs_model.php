<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utilisateurs_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="utilisateurs";
	}

	/**
	 *	Ajoute un utilisateur
	 */
	public function ajouter_user($nom,$prenom,$mail,$classement,$statut=0,$mdp)
	{


		//	Ces données seront automatiquement échappées
				$data=array(
					"nom"=>$nom,
					"prenom"=>$prenom,
					"mail"=>$mail,
					"classement"=>$classement,
					"statut"=>$statut,
					"mdp"=>$mdp
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
	public function select_all(){
		$result = $this->db->select('*')->from('utilisateurs')->get();

		return $result->result();

	}
	public function get_by_mail($mail){

		$id = $this->db->select('*')->where('mail', $mail)-> limit(1)->get('utilisateurs')->row();
		return $id;

	}
	public function get_by_id($id){

    		$id = $this->db->select('*')->where('id', $id)->get('utilisateurs')->row();
    		return $id;

    	}
    	public function update_user($id,$nom,$prenom,$mail,$classement,$statut,$mdp,$abonnement){

    	$data = array(

                'nom' => $nom,
                'mail' => $mail,
                'classement' => $classement,
                'statut' => $statut,
                'mdp' => $mdp,
                'abonnement' => $abonnement,
        );
		$this->db->update('utilisateurs', $data, "id =".$id);}

	/**
	 *	Édite une news déjà existante
	 */
	 public function delete_element($id){


     		$this->db->delete('utilisateurs', array('id' => $id));

     	 }

}


/* End of file news_model.php */
/* Location: ./application/models/news_model.php */
