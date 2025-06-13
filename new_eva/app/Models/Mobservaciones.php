<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mobservaciones extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

		
	}
	public function get($param){
		$this->db->select("observaciones.*,usuarios.nombre as usuario");
		$this->db->from("observaciones");
		$this->db->join("usuarios","usuarios.id=observaciones.usuario_id","left");
		$this->db->where("observaciones.equipo_id",$param['equipo_id']);
		$this->db->order_by("observaciones.created_at","asc");
		return $this->db->get()->result();
	}
	public function add($param){
		$this->db->insert("observaciones",$param);
		return $this->db->insert_id();
	}
	public function addFile($param){
		$this->db->insert("observaciones_archivos",$param);
		return $this->db->insert_id();
	}


	public function getOne($param){
		$this->db->where("id",$param["id"]);
		return $this->db->get("observaciones")->row();

	}
	public function getArchivosObservacion($param){
		$query="SELECT observaciones_archivos.*,concat('.tmpa_',observaciones_archivos.observacion_id) AS personalizado FROM observaciones_archivos  WHERE observacion_id=".$param["observacion_id"];
		return $this->db->query($query)->result();
	}
	public function update($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		return $this->db->update("observaciones",$param);
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		return $this->db->delete("observaciones");

	}
	public function getAll(){
		$this->db->select("observaciones.*,equipos.name as nombre_equipo,equipos.code as codigo_equipo, equipos.serial as serie_equipo, equipos.marca as marca_equipo, equipos.modelo as modelo_equipo, servicios.name as ubicacion, equipos.id as equipo_id");
		$this->db->from("observaciones");
		$this->db->join("equipos","equipos.id=observaciones.equipo_id");
		$this->db->join("servicios","equipos.servicio_id=servicios.id");
		return $this->db->get()->result();
	}

	public function repuesto_pendiente_true($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		unset($param["equipo_id"]);
		$param["repuesto_pendiente"]="si";
		return $this->db->update("observaciones",$param);
	}
	public function repuesto_pendiente_false($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		unset($param["equipo_id"]);
		$param["repuesto_pendiente"]="no";
		return $this->db->update("observaciones",$param);
	}
	public function cuenta_registros_repuestos_pendientes($param){
		$query="
		SELECT
		COUNT(*) AS total
		FROM
		observaciones
		WHERE
		observaciones.equipo_id = ".$param."
		and repuesto_pendiente='si'		
		";
		return $this->db->query($query)->row();
	}	

	public function get_notas_from_preventivo($param){
		$this->db->select("observaciones.*,usuarios.nombre as nombre_usuario,usuarios.username as alias,
			(select count(*) from observaciones o where o.preventivo_id= ".$param["preventivo_id"].")as nro_notas
			");
		$this->db->from("observaciones");
		$this->db->join("usuarios","usuarios.id=observaciones.usuario_id","left");
		$this->db->where("preventivo_id",$param["preventivo_id"]);
		return $this->db->get()->result();
	}

}
?>