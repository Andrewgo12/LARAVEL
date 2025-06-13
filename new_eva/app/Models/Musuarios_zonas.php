<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Musuarios_zonas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
	}
	public function getOne($param){

	}
	public function add($param){
		$this->db->insert("usuarios_zonas",$param);
	}
	public function update($param){
	}
	public function delete($param){
	}	
}

?>