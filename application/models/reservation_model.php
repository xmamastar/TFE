<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="bookings";
	}

	/**
	 *	Ajoute une news
	 */
	 public function get_element_by_date($date){

			$date_result = $this->db->select('*')->from('bookings')->where('date',$date)->get();
            return $date_result->result();


	 }
	 public function delete_element($id){


		$this->db->delete('bookings', array('id' => $id));

	 }
	 public function get_element_by_mail($mail){

	 	$date_result = $this->db->select('*')->from('bookings')->where('email',$mail)->get();
        return $date_result->result();


	 }
	 public function get_element_by_id_client($id_client){

     	 	$date_result = $this->db->select('*')->from('bookings')->where('id_client',$id_client)->get();
             return $date_result->result();


     	 }
	 public function get_element_by_id($id){
	 	$date_result = $this->db->select('*')->from('bookings')->where('id',$id)->get();
         return $date_result->result();

	 }
	 public function get_element_by_date_timeslot_terrain($date,$timeslot,$terrain){
     		$data=array('date'=>$date,'timeslot'=>$timeslot,'terrain'=>$terrain);
     		$date_result = $this->db->select('*')->from('bookings')->where($data)->get();

             return $date_result->result();


     	 }
	 public function insert($name,$timeslot,$email,$date,$terrain,$id_client,$num_reservation){

		$id_client=intval($id_client);
		//var_dump($id_client);
	 	$data = array(
                'name' => $name,
                'timeslot' => $timeslot,
                'email' => $email,
                'date' => $date,
                'terrain' => $terrain,
                'id_client' => $id_client,
                'numero_reservation'=>$num_reservation
        );

        $this->db->insert('bookings', $data);

	 }
	 public function get_element_by_name_mail_timeslot($name,$timeslot,$email,$date,$terrain,$id_client){

		$data=array('name'=>$name,'timeslot'=>$timeslot,'email'=>$email,'date'=>$date,'terrain'=>$terrain,'id_client'=>$id_client);
		$date_result = $this->db->select('*')->from('bookings')->where($data)->get();

		//$results = $sql->getResult();
		return $date_result->result();
		/*$this->db->select('SELECT * FROM bookings WHERE name='.$name.' AND timeslot='.$timeslot.'AND email='.$email.'AND terrain= '.$terrain.'AND id_client='.$id_client);
        $query = $this->db->get('bookings');
        return $query*/

	 }
	 public function get_element_by_ts_date_terrain($timeslot,$date,$terrain){

	 	$data=array('timeslot'=>$timeslot,'date'=>$date,'terrain'=>$terrain);
		$date_result = $this->db->select('*')->from('bookings')->where($data)->get();
		return $date_result->result();
	 }
	 public function delete_booking_numeroReservation($numero){


     		$this->db->delete('bookings', array('numero_reservation' => $numero));

     	 }

}


/* End of file news_model.php */
/* Location: ./application/models/news_model.php */
