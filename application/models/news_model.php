<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_Model
{

	public $table;
	public function __construct(){
		parent::__construct();
		$this->table="news";
	}

	/**
	 *	Ajoute une news
	 */
	public function ajouter_news($auteur,$titre,$contenu)
	{

				$date = new DateTime();
				$date=$date->format('Y-m-d H:i:s');
		//	Ces données seront automatiquement échappées
				$data=array(
					"auteur"=>$auteur,
					"titre"=>$titre,
					"contenu"=>$contenu,
					"date_ajout"=>$date,
					"date_modif"=>$date
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

	/**
	 *	Édite une news déjà existante
	 */
	public function editer_news()
	{

	}

	/**
	 *	Supprime une news
	 */
	public function supprimer_news()
	{

	}

	/**
	 *	Retourne le nombre de news
	 */
	public function count()
	{

	}

	/**
	 *	Retourne une liste de news
	 */
	public function liste_news()
	{

	}
}


/* End of file news_model.php */
/* Location: ./application/models/news_model.php */
