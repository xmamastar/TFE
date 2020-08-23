<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class annonce_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="annonce";
	}

	public function select_all(){

    		$id = $this->db->select('*')->from('annonce')->get();
    		return $id->result();

    	}

    public function get_by_titre($titre){
    	$annonce = $this->db->select('*')->from('annonce')->where('titre', $titre)->get();
		return $annonce->result();

    }
    public function get_by_id($id){
        	$annonce = $this->db->select('*')->from('annonce')->where('id_annonce', $id)->get();
    		return $annonce->result();

        }
    public function insert_annonce($titre,$texte,$item,$date){

		$duration=120;
		$interval=new DateInterval("PT".$duration."M");
		$date=new DateTime($date);
		$date->add($interval);
		$date=$date->format('Y-m-d h:i:s');
		var_dump($date);
		$data = array(
				'titre' => $titre,
				'texte' => $texte,
				'img_item' => $item,
				'date_ajout'=>$date

		);

		$this->db->insert('annonce', $data);




    }
    public function insert_annonce_without_img($titre,$texte,$date){




    		//var_dump($id_client);
    		$data = array(
    				'titre' => $titre,
    				'texte' => $texte,
    				'date_ajout'=>$date


    		);

    		$this->db->insert('annonce', $data);




        }
        public function delete_annonce_by_titre($titre){


			$this->db->delete('annonce', array('titre' => $titre));

		 }
		  public function delete_annonce_by_id($id){


         			$this->db->delete('annonce', array('id_annonce' => $id));

         		 }
        public function update_annonce($id,$titre,$texte,$img_item,$date_ajout){

			$duration=120;
			$interval=new DateInterval("PT".$duration."M");
			$date=new DateTime($date_ajout);
			$date->add($interval);
			$date=$date->format('Y-m-d h:i:s');

			$data = array(
					'titre'=>$titre,
					'texte' => $texte,
					'img_item' => $img_item,
					'date_ajout'=>$date

			);
			$this->db->update('annonce', $data, "id_annonce =".$id);

		}

}
