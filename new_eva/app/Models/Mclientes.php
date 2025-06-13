<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
* 
*/
class Mclientes extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_server_side($param){
		if ($param['length']<0) {
			$param['length']=999999999;
		}
		$this->db->select('*');	
		$this->db->from('clientes');
		$this->db->where('estado !=0 and(
			nombre like"%'.$param['search']['value'].'%" or
			telefono like"%'.$param['search']['value'].'%" or
			apellido like"%'.$param['search']['value'].'%")');
		$this->db->limit($param['length'],$param['start']);
		$result = $this->db->get();// Estructura de datos
 
		$num_filas_limit=$result->num_rows();
        $datos = $result->result();

		$this->db->select('*');	
		$this->db->from('clientes');
		$this->db->where('estado !=0 and(
			nombre like"%'.$param['search']['value'].'%" or
			telefono like"%'.$param['search']['value'].'%" or
			apellido like"%'.$param['search']['value'].'%")');		
		$num_filas = $this->db->get()->num_rows();

		$vector = array(

			'datos'=>$datos,
			'num_filas_limit'=>$num_filas_limit,
			'num_filas'=>$num_filas

			);

		return $vector;

	}

	public function add($param){
		$this->db->insert('clientes',$param);
	}

	public function update($param){

		$this->db->where('id',$param['id']);
		 unset($param['id']);
		$this->db->update('clientes',$param);
	}
	public function delete($param,$array){
        $this->db->where('id',$param['id']);
        $this->db->update('clientes',$array);
	}
	public function getOne($param){
		$this->db->where('id',$param);
		return $this->db->get('clientes')->row();

	}	
	
}

 ?>