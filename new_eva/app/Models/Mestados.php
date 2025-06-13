<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mestados extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function getAll(){
		$this->db->order_by("descripcion","asc");
		return $this->db->get("estados")->result();
	}
	public function getUsed(){
		$query="
			SELECT
			    *
			FROM
			    `estados`
			WHERE
			    (
			    SELECT
			        COUNT(*)
			    FROM
			        ordenes o
			    LEFT JOIN equipos e ON e.id=o.equipo_id   
			    WHERE
			        o.estado_id = estados.id 
			)
		";
		return $this->db->query($query)->result();
	}
}

?>