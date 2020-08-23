<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class match_tournoi_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="match_tournoi";
	}

	public function select_all(){
		$result = $this->db->select('*')->from('match_tournoi')->get();

		return $result->result();
	}
	public function get_match_tournoi($id_tournoi){

		$date_result = $this->db->select('*')->from('match_tournoi')->where('id_tournoi',$id_tournoi)->get();
                    return $date_result->result();
	}
	public function delete($id){


		$this->db->delete('match_tournoi', array('id_tournoi' => $id));

	 }
	 public function get_match($id_match){

	 	$date_result = $this->db->select('*')->from('match_tournoi')->where('id',$id_match)->get();
                            return $date_result->result();

	 }
	 public function insert($id_joueur1,$id_joueur2,$id_tournoi,$statut,$date=null,$score=null,$vainqueur=0){

	 	//var_dump($id_client);
            		$data = array(
            				'id_joueur1' => $id_joueur1,
            				'id_joueur2' => $id_joueur2,
            				'date' => $date,
            				'score'=>$score,
            				'vainqueur'=>$vainqueur,
            				'id_tournoi'=>$id_tournoi,
            				'statut'=>$statut


            		);

            		$this->db->insert('match_tournoi', $data);





	 }
	 public function update_score($score,$id_match,$vainqueur){



                         	$data = array(

                                     'score' => $score,
                                     'vainqueur' => $vainqueur

                             );
                     		$this->db->update('match_tournoi', $data, "id =".$id_match);

             	}
     public function get_match_by_statut($statut,$id_tournoi){
     		$data=array('statut'=>$statut,'id_tournoi'=>$id_tournoi);
     		$date_result = $this->db->select('*')->from('match_tournoi')->where($data)->get();

     		//$results = $sql->getResult();
     		return $date_result->result();



     }
     public function update_joueur1($id_match,$joueur){

     	$data = array(

			 'id_joueur1' => $joueur


	 );
	$this->db->update('match_tournoi', $data, "id =".$id_match);

     }
      public function update_joueur2($id_match,$joueur){

          	$data = array(

     			 'id_joueur2' => $joueur


     	 );
     	$this->db->update('match_tournoi', $data, "id =".$id_match);

          }
}




