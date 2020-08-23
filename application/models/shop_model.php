<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class shop_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="shop";
	}

	/**
	 *	Ajoute un utilisateur
	 */

	public function select_all(){
		$result = $this->db->select('*')->from('shop')->get();

		return $result->result();

	}
	public function get_by_cat($cat){

			$result = $this->db->select('*')->from('shop')->where('cat_item',$cat)->get();

    		return $result->result();

    	}

	public function get_by_nom($nom){

    		$article = $this->db->select('*')->where('nom_item', $nom)->get('shop')->row();
    		return $article;

    	}
	public function get_by_id($id){

    		$item = $this->db->select('*')->where('id_item', $id)->get('shop')->row();
    		return $item;

    	}
    public function insert_article($nom_item, $cat_item, $descri_item,$prix_item, $img_item,$qte_item){
        	 	$data = array(
                        'nom_item' => $nom_item,
                        'cat_item' => $cat_item,
                        'qte_item' => $qte_item,
                        'descri_item' => $descri_item,
                        'prix_item' => $prix_item,
                        'img_item' => $img_item

                );
                 $this->db->insert('shop', $data);

    }
	 public function delete_article($id){


     		$this->db->delete('shop', array('id_item' => $id));

     	 }
	 public function update_qte_item($id,$nom,$qte,$cat,$descri,$prix,$img){


				$data = array(
						'nom_item' => $nom,
						'qte_item' => $qte,
						'cat_item'=>$cat,
						'descri_item'=>$descri,
						'prix_item'=>$prix,
						'img_item'=>$img

				);
				$this->db->update('shop', $data, "id_item =".$id);

			}

}


/* End of file news_model.php */
/* Location: ./application/models/news_model.php */
