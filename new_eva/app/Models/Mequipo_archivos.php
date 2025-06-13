<?php 
/**
* 
*/
class Mequipo_archivos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function get($param){
		$this->db->select("equipo_archivo.*,archivos.name as archivo");
		$this->db->from("equipo_archivo");
		$this->db->join("archivos","archivos.id=equipo_archivo.archivo_id");
		$this->db->where("equipo_archivo.equipo_id=".$param['id']." AND equipo_archivo.archivo_id!=9");
		return $this->db->get()->result();
	}
	public function get_capacitaciones($param){
		$this->db->select("equipo_archivo.*,archivos.name as archivo");
		$this->db->from("equipo_archivo");
		$this->db->join("archivos","archivos.id=equipo_archivo.archivo_id");
		$this->db->where("equipo_archivo.equipo_id=".$param['id']." AND equipo_archivo.archivo_id=9");
		$this->db->order_by("equipo_archivo.created_at","DESC");
		return $this->db->get()->result();
	}
	public function add($param){
		$this->db->insert("equipo_archivo",$param);
	}
	public function add_capacitaciones($param){

			$query="
			INSERT INTO equipo_archivo(equipo_id, archivo_id, vinculo,created_at)
			SELECT
			    eq.id,
			    9,
			    '".$param["vinculo"]."',
			    '".$param["created_at"]."'
			FROM
			    equipos eq
				    
			WHERE
			    eq.name LIKE '%".$param["name"]."%' AND eq.marca LIKE '%".$param["marca"]."%' AND eq.modelo LIKE '%".$param["modelo"]."%' AND
			    eq.estadoequipo_id NOT IN(5,6,9) AND
			    (
			    	eq.servicio_id IN(".$param["servicios"].") OR eq.area_id IN(".$param["areas"].")
			    )
			";
			$this->db->query($query);
		}


	public function delete($param){
		$this->db->where("id",$param["id"]);
		$this->db->delete("equipo_archivo");

	}	

	public function update_archivos($param){
   	$query="

		INSERT INTO equipo_archivo(equipo_id, archivo_id, vinculo,otro,created_at)
		SELECT
		    ".$param["equipo_objetivo_id"].",
		    archivo_id,
		    vinculo,
		    otro,
		    created_at
		    FROM equipo_archivo
			WHERE
    		equipo_archivo.id= ".$param["equipo_archivo_origen_id"];;

		     $this->db->query($query);
	}	

}

 ?>