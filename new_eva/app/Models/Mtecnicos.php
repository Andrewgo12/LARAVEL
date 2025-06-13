<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mtecnicos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->select('*');	
		$this->db->from('tecnicos');
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function add($param){
		$this->db->insert('categorias',$param);
	}
	public function update($param){

		$this->db->where('id',$param['id']);
		 unset($param['id']);
		$this->db->update('categorias',$param);
	}
	public function delete($param,$array){
        $this->db->where('id',$param['id']);
        $this->db->update('categorias',$array);
	}
	public function getOne($param){
		$this->db->where('id',$param["id"]);
		return $this->db->get('tecnicos')->result();

	}
	public function getFromTrabajos($param){
		$this->db->select("*");
		$this->db->from("tecnicos");
		$this->db->where("trabajo_id",$param["trabajo_id"]);
		$this->db->order_by("name","asc");
		return $this->db->get()->result();
	}
}

?>