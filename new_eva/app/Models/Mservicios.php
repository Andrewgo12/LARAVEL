<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mservicios extends CI_Model
{

	function __construct()
	{
		defined('BASEPATH') or exit('El acceso directo no esta permitido');
		parent::__construct();
	}

	/* Refactoring */
	public function getOneService($id)
	{
		$this->db->select('servicios.*');
		$this->db->from('servicios');
		$this->db->where('servicios.id', $id);
		return $this->db->get()->row();
	}
	public function getAllServices()
	{
		$this->db->select(
			"
		servicios.*,
		pisos.name as piso,
		zonas.name as zona,
		centros.name as centro,
		sedes.name as sede,
		(select count(*) from areas where areas.servicio_id=servicios.id)as cantidad_areas,
		(select count(*) from equipos where equipos.servicio_id=servicios.id)as cantidad_equipos"
		);
		$this->db->from("servicios");
		$this->db->join("pisos", "pisos.id=servicios.piso_id", 'left');
		$this->db->join("zonas", "servicios.zona_id=zonas.id", 'left');
		$this->db->join("centros", "servicios.centro_id=centros.id", 'left');
		$this->db->join("sedes", "servicios.sede_id=sedes.id", 'left');
		$this->db->where("servicios.status=1");
		$this->db->order_by("name", "asc");
		return $this->db->get()->result();
	}
	public function getBySede($id)
	{
		$this->db->select(
			"
		servicios.*,
		pisos.name as piso,
		zonas.name as zona,
		centros.name as centro,
		sedes.name as sede,
		(select count(*) from areas where areas.servicio_id=servicios.id)as cantidad_areas,
		(select count(*) from equipos where equipos.servicio_id=servicios.id)as cantidad_equipos"
		);
		$this->db->from("servicios");
		$this->db->join("pisos", "pisos.id=servicios.piso_id", 'left');
		$this->db->join("zonas", "servicios.zona_id=zonas.id", 'left');
		$this->db->join("centros", "servicios.centro_id=centros.id", 'left');
		$this->db->join("sedes", "servicios.sede_id=sedes.id", 'left');
		$this->db->where("servicios.status=1");
		$this->db->where('servicios.sede_id', $id);
		$this->db->order_by("servicios.name", "asc");
		return $this->db->get()->result();
	}
	public function add($param)
	{
		return ($this->db->insert("servicios", $param));
	}
	public function update($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$this->db->update("servicios", $param);
	}
	public function delete($param)
	{
		$this->db->where('id', $param['id']);
		$this->db->delete('servicios');
	}





	public function get_datatable()
	{
		$this->db->select("servicios.*,
		pisos.name as piso,
		zonas.name as zona,
		centros.name as centro,
		sedes.name as sede,
		(select count(*) from equipos where equipos.servicio_id=servicios.id)as cantidad_equipos");
		$this->db->from("servicios");
		$this->db->join("pisos", "pisos.id=servicios.piso_id", 'left');
		$this->db->join("zonas", "servicios.zona_id=zonas.id", 'left');
		$this->db->join("centros", "servicios.centro_id=centros.id", 'left');
		$this->db->join("sedes", "servicios.sede_id=sedes.id", 'left');
		$this->db->where("servicios.status=1");
		$this->db->order_by("name", "asc");
		return $this->db->get()->result();
	}
	public function get()
	{
		$this->db->where("servicios.status=1");
		$this->db->order_by("name", "asc");
		return $this->db->get("servicios")->result();
	}
	public function getOne($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->get("servicios")->row();
	}
	public function getUbicacion($param)
	{
		$this->db->select("servicios.*,pisos.name as piso,centros.name as centro,sedes.name as sede,centros.code as codigo_centro");
		$this->db->from("servicios");
		$this->db->join("pisos", "pisos.id=servicios.piso_id", 'left');
		$this->db->join("centros", "servicios.centro_id=centros.id", 'left');
		$this->db->join("sedes", "servicios.sede_id=sedes.id", 'left');
		$this->db->where("servicios.status=1 and servicios.id=" . $param["id"]);
		return $this->db->get()->row();
	}


	/* 	public function delete($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$this->db->update("servicios", $param);
	} */
	public function getFromSede($param)
	{

		if ($param["sede_id"] != "") { // Se indica cual es la sede
			if ($param["sede_id"] == 3) {
				$param["sede_id"] = "";
			}
			$this->db->where("servicios.sede_id LIKE '%" . $param["sede_id"] . "%' and servicios.status=1 order by servicios.name asc");
		} else { // No se indica cual es la sede (caso de equipos)
			$this->db->where("servicios.sede_id LIKE '%" . $this->session->userdata("sede_id") . "%' and servicios.status=1");
		}
		return $this->db->get("servicios")->result();
	}
}
