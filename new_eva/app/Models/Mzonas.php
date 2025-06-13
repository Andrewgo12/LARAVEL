<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mzonas extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	// Refactoring
	public function getAllZones()
	{
		$this->db->where('status !=', 0);
		$this->db->order_by("name", "asc");
		return $this->db->get("zonas")->result();
	}

	public function get()
	{
		// $this->db->select('categorias.id as id, categorias.nombre as nombre, categorias.descripcion as descripcion');	
		$this->db->where('status !=', 0);
		$this->db->order_by("name", "asc");
		return $this->db->get("zonas")->result();
	}
	public function getAll()
	{
		$this->db->where('status !=', 0);
		$this->db->order_by("name", "asc");
		return $this->db->get("zonas")->result();
	}
	public function get_emails_with_service($param)
	{
		$query = "

			SELECT DISTINCT

			    usuarios.email AS correo_usuario
			FROM
			    `servicios`
			LEFT JOIN zonas ON zonas.id = servicios.zona_id
			LEFT JOIN usuarios_zonas ON zonas.id = usuarios_zonas.zona_id
			LEFT JOIN usuarios ON usuarios.id = usuarios_zonas.usuario_id
			WHERE
			    usuarios.email IS NOT NULL AND servicios.id = " . $param["servicio_id"] . "
			GROUP BY
			    usuarios.email
		";
		$resultado = $this->db->query($query);
		$vector = array(
			"correos" => $resultado->result(),
			"cantidad" => $resultado->num_rows()
		);
		return $vector;
	}
}
