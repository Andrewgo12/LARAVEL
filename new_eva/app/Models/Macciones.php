<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Macciones extends CI_Model
{

	function __construct()
	{
		defined('BASEPATH') or exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function getAll()
	{
		$this->db->order_by("name", "asc");
		return $this->db->get("centros")->result();
	}
	public function getOne($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->get("acciones")->row();
	}
	public function getByUser($param)
	{
		$this->db->select("acciones.*,modulos.name as modulo");
		$this->db->from("acciones");
		$this->db->join("modulos", "modulos.id=acciones.modulo_id", "left");
		$this->db->where("acciones.usuario_id", $param);
		$this->db->order_by("modulos.id", "asc");
		// $this->db->order_by("modulos.name","asc");
		return $this->db->get()->result();
	}
	public function edit($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$this->db->update("acciones", $param);
	}
	public function add($usuario_id, $modulo_id, $leer, $insertar, $editar, $eliminar)
	{
		$query = "INSERT INTO acciones(

	      usuario_id,
		    modulo_id,
		    leer,
		    insertar,
		    editar,
		    eliminar
	)
		VALUES(
		    " . $usuario_id . ",
		    " . $modulo_id . ",
		    " . $leer . ",
		    " . $insertar . ",
		    " . $editar . ",
		    " . $eliminar . "
		)
	";
		return ($this->db->query($query));
	}

	public function setear_acciones($param)
	{ // Si no se tenia el modulo relacionado en las acciones se relaciona, y si ya estaba no se toca
		$query = "
			INSERT INTO acciones(
             usuario_id,
             modulo_id,
             leer,
             insertar,
             editar,
             eliminar
			)
			SELECT
			u.id,
			" . $param["modulo_id"] . ",
			(
				SELECT CASE  
				WHEN u.rol_id = 1 THEN 1 
				WHEN u.rol_id >1 THEN 0
				END
			),
			(
				SELECT CASE  
				WHEN u.rol_id = 1 THEN 1 
				WHEN u.rol_id >1 THEN 0
				END
			),
			(
				SELECT CASE  
				WHEN u.rol_id = 1 THEN 1 
				WHEN u.rol_id >1 THEN 0
				END
			),
			(
				SELECT CASE  
				WHEN u.rol_id = 1 THEN 1 
				WHEN u.rol_id >1 THEN 0
				END
			)									

			FROM usuarios u
			WHERE (SELECT COUNT(*) from acciones WHERE modulo_id=" . $param["modulo_id"] . ")=0

		";
		$this->db->query($query);
	}


	// 	INSERT INTO acciones(
	//     usuario_id,
	//     modulo_id,
	//     leer,
	//     insertar,
	//     editar,
	//     eliminar
	// )
	// SELECT
	//     usuarios.id,
	//     20,
	//     0,
	//     0,
	//     0,
	//     0
	// FROM
	//     usuarios

}
