<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcierres extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get(){
		$this->db->where('status',1);
		$this->db->order_by("code","asc");
		$resultado = $this->db->get("codificacion_cierres");
		return $resultado->result();
	}

	public function getUsed(){

		$query="
			SELECT
			    *
			FROM
			    codificacion_cierres cc
			WHERE
			    (
			    SELECT
			        COUNT(*)
			    FROM
			        correctivos_generales cg
			    LEFT JOIN equipos e ON e.id=cg.equipo_id    
			    WHERE
			        cg.cierre_id = cc.id AND
			        e.tipo_id=".$this->session->userdata("tipo_id")."
			)>0
		";
		return $this->db->query($query)->result();
	}
}

?>