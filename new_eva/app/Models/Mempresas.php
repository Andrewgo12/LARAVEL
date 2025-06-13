<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Mempresas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function getAll(){
		$this->db->select("empresas.*");
		$this->db->from("empresas");
		return $this->db->get()->result();

	}
	public function add($param){
	}

	public function update($param){

	}
	public function delete($param,$array){
	}
	
	public function getOne($param){

		$query="SELECT * from empresas WHERE id=".$param["id"];
		return $this->db->query($query)->result();
		
	}	
	public function getEmailUsuariosEmpresa($param)
	{
		$this->db->select("usuarios.email as email");
		$this->db->from("usuarios");
		$this->db->where("usuarios.id_empresa",$param["id_empresa"]);
		$resultado=$this->db->get();
		$vector=array(
			"correos_empresa"=>$resultado->result(),
			"cantidad"=>$resultado->num_rows()
		);
		return $vector;
	}		
	
}

 ?>