<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mequipo_especificaciones extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	public function get($param){
		$this->db->select("
			ee.id as id,
			ee.equipo_id as equipo_id,
			es.name as especificacion,
			ee.valor as valor,
			ee.especificacion_id as especificacion_id,
			ee.file as file
			");
		$this->db->from("equipo_especificacion ee");
		$this->db->join("especificacion es","es.id=ee.especificacion_id");
		$this->db->where("ee.equipo_id=".$param['equipo_id']);
		return $this->db->get()->result();
	}
	public function get_tension($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de tension%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_temperatura($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de temperatura%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_presion($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de presion%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_potencia($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de potencia%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_corriente($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de corriente%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_frecuencia($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de frecuencia%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_velocidad($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de velocidad%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_humedad($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%rango de humedad%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}	
	public function get_peso($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%peso%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}		
	public function get_otro($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%otros%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		return $this->db->get()->result();
	}
	public function get_archivo($param){
		$this->db->select("
			equipo_especificacion.id as id,
			equipo_especificacion.equipo_id as equipo_id,
			especificacion.name as especificacion,
			equipo_especificacion.valor as valor,
			equipo_especificacion.file as file
			");
		$this->db->from("equipo_especificacion");
		$this->db->join("especificacion","especificacion.id=equipo_especificacion.especificacion_id");
		$this->db->where("equipo_especificacion.equipo_id=".$param['equipo_id']);
		$this->db->where("especificacion.name like '%archivo%'");
		$this->db->order_by("equipo_especificacion.id","desc");
		return $this->db->get()->result();
	}	
	public function add($param){
		$this->db->insert("equipo_especificacion",$param);
	}

	public function copy_especificaciones($param){
		$query="

			INSERT INTO equipo_especificacion(
			    equipo_id,
			    especificacion_id,
			    valor
			)
			SELECT
			    ".$param["equipo_id_destino"].",
			    especificacion_id,
			    valor
			FROM
			    equipo_especificacion
			WHERE
			    equipo_id = ".$param["equipo_id_origen"]."

		";
		$this->db->query($query);
	}
	public function add_especificaciones($param){

		if ($param["especificaciont"]==2) { // Tension
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,2,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=2)<1
				");
		}elseif ($param["especificaciont"]==3) { //Potencia
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,3,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=3)<1
				");
		}elseif ($param["especificaciont"]==4) { //Presion
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,4,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=4)<1
				");
		}elseif ($param["especificaciont"]==5) { //Temperatura
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,5,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=5)<1
				");
		}elseif ($param["especificaciont"]==6) { //Corriente
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,6,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=6)<1
				");
		}elseif ($param["especificaciont"]==7) { //Frecuencia
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,7,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=7)<1
				");
		}elseif ($param["especificaciont"]==8) { //Velocidad
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,8,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=8)<1
				");
		}elseif ($param["especificaciont"]==9) { //Humedad
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,9,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=9)<1
				");
		}elseif ($param["especificaciont"]==11) { //Peso
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,11,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=11)<1
				");
		}elseif ($param["especificaciont"]==10) { //Otros
			$this->db->query("insert into equipo_especificacion (equipo_id,especificacion_id,valor)
				select equipos.id,10,'".$param["valor"]."' from equipos 
				where equipos.name like '%".$param["name"]."%' and 
				equipos.marca like '%".$param["marca"]."%' and
				equipos.modelo like '%".$param["modelo"]."%' and
				(select count(*) from equipo_especificacion where equipo_especificacion.equipo_id=equipos.id and equipo_especificacion.especificacion_id=10)<=8
				");
		}
		else{

		}
	}	
	public function delete($param){
		$this->db->where("id",$param["id"]);
		$this->db->delete("equipo_especificacion");

	}
	public function delete_multiple($param){
		$query="DELETE
		FROM
		    equipo_especificacion
		WHERE
		    equipo_id = ".$param["id"];

		$this->db->query($query);
	}

	public function update_especificaciones_tecnicas($param){
   	$query="

		INSERT INTO equipo_especificacion(
		    equipo_id,
		    especificacion_id,
		    valor,
		    file
		)
		SELECT
		    ".$param["equipo_objetivo_id"].",
		    especificacion_id,
		    valor,
		    file
		FROM
		    equipo_especificacion
		     WHERE
		     
		     equipo_especificacion.equipo_id = ".$param["equipo_origen_id"];

		     $this->db->query($query);
	}	


}

?>