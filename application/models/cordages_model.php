<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cordages_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="cordage";
	}
	public function select_all(){
    		$result = $this->db->select('*')->from('cordage')->get();

    		return $result->result();

    	}
	public function get_by_type($type){
		$date_result = $this->db->select('*')->from('cordage')->where('type_cordage',$type)->get();
        return $date_result->result();

	}




}


/* End of file news_model.php */
/* Location: ./application/models/news_model.php */
