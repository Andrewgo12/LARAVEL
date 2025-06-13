<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mcambios_ubicaciones extends CI_Model
{
	
	function __construct()
	{
		defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function getAllByDevice($param){
		$query='
			SELECT
			    servicios_origen.name AS servicio_origen,
			    servicios_destino.name AS servicio_destino,
			    areas_origen.name AS area_origen,
			    areas_destino.name AS area_destino,
			    sedes_origen.name AS sede_origen,
			    sedes_destino.name AS sede_destino,
			    cambios_ubicaciones.created_at AS fecha,

			    CONCAT(
			        usuarios.nombre,
			        " ",
			        usuarios.apellido,
			        "|",
			        usuarios.username
			    ) AS usuario
			FROM
			    cambios_ubicaciones
			LEFT JOIN servicios AS servicios_origen
			ON
			    servicios_origen.id = cambios_ubicaciones.servicio_origen_id
			LEFT JOIN servicios AS servicios_destino
			ON
			    servicios_destino.id = cambios_ubicaciones.servicio_destino_id
			LEFT JOIN areas AS areas_origen
			ON
			    areas_origen.id = cambios_ubicaciones.area_origen_id
			LEFT JOIN areas AS areas_destino
			ON
			    areas_destino.id = cambios_ubicaciones.area_destino_id
			LEFT JOIN sedes AS sedes_origen
			ON
				sedes_origen.id = cambios_ubicaciones.sede_origen_id
			LEFT JOIN sedes AS sedes_destino
			ON
				sedes_destino.id = cambios_ubicaciones.sede_destino_id


			LEFT JOIN usuarios ON cambios_ubicaciones.usuario_id = usuarios.id


			WHERE cambios_ubicaciones.equipo_id='.$param["equipo_id"].'
		';
		return $this->db->query($query)->result();
	}
	public function getOne($param){
	}
	public function add($param){
		$this->db->insert("cambios_ubicaciones",$param);
	}
	public function update($param){
	}
	public function delete($param){
	}	


}
?>