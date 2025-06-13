<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcambios_hdv extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function add($param){
		$this->db->insert("cambios_hdv",$param);		
	}
	public function get_from_device($param){
		$this->db->select("chdv.*,u.nombre as nombre,u.apellido as apellido,u.username as username");
		$this->db->from("cambios_hdv chdv");
		$this->db->join("usuarios u","u.id=chdv.usuario_id","left");
		$this->db->join("equipos e","e.id=chdv.equipo_id","left");
		$this->db->where("chdv.equipo_id",$param["equipo_id"]);
		$this->db->order_by("chdv.created_at","desc");
		return $this->db->get()->result();
	}
	public function depurarCodigo(){
		$query="UPDATE cambios_hdv SET descripcion=REPLACE(descripcion,'Se cambio disponibilidad del equipo de  a ','')";
		$this->db->query($query);
		$query2="DELETE FROM cambios_hdv WHERE descripcion like '%Se cambio disponibilidad del equipo de  a%' AND LENGTH(descripcion)=43";
		$this->db->query($query2);		
	}

}

?>