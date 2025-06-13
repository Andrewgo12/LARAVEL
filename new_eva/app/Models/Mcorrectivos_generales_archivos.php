<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcorrectivos_generales_archivos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

		
	}
	public function get($param){// obtiene todos los archivos que pertenecen a un correctivo dado
		$this->db->select("correctivos_generales_archivos.*,concat('.tmp_',correctivos_generales_archivos.correctivo_general_id) as id_personalizado");
		$this->db->from("correctivos_generales_archivos");
		$this->db->where("correctivos_generales_archivos.correctivo_general_id",$param['correctivo_general_id']);
		$this->db->order_by("correctivos_generales_archivos.created_at","desc");
		return $this->db->get()->result();
	}
	public function get_ind($param){// obtiene todos los archivos que pertenecen a un correctivo dado
		$this->db->select("correctivos_generales_archivos_ind.*,concat('.tmp_',correctivos_generales_archivos_ind.correctivo_general_id) as id_personalizado");
		$this->db->from("correctivos_generales_archivos_ind");
		$this->db->where("correctivos_generales_archivos_ind.correctivo_general_ind_id",$param['correctivo_general_id']);
		$this->db->order_by("correctivos_generales_archivos_ind.created_at","desc");
		return $this->db->get()->result();
	}
	public function add($param){
		$this->db->insert("correctivos_generales_archivos",$param);
	}
	public function add_ind($param){
		$this->db->insert("correctivos_generales_archivos_ind",$param);
	}
	public function getOne($param){// obtiene el registro especifico de archivo
		$this->db->select("*");
		$this->db->from("correctivos_generales_archivos");
		$this->db->where("id",$param["id"]);
		return $this->db->get()->row();

	}
	public function update($param){

	}
	public function delete($param){
		return $this->db->query("delete from correctivos_generales_archivos where id=".$param);
	}
	public function getAll($param){
		$this->db->select("correctivos_generales_archivos.*");
		$this->db->from("correctivos_generales_archivos");
		$this->db->where("correctivo_general_id",$param["id"]);
		return $this->db->get()->result();

	}
public function delete_ind($param){
		return $this->db->query("delete from correctivos_generales_archivos_ind where id=".$param);
	}
	public function getAll_ind($param){
		$this->db->select("correctivos_generales_archivos_ind.*");
		$this->db->from("correctivos_generales_archivos_ind");
		$this->db->where("correctivo_general_id",$param["id"]);
		return $this->db->get()->result();

	}
}
?>