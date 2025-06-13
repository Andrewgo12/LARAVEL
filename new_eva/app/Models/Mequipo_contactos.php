<?php 
/**
* 
*/
class Mequipo_contactos extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function get($param){
		$this->db->select("
			equipo_contacto.*,
			contacto.name as contacto,
			contacto.email as email,
			contacto.telefono as telefono,
			tcontacto.description as tcontacto
			");
		$this->db->from("equipo_contacto");
		$this->db->join("contacto","contacto.id=equipo_contacto.contacto_id");
		$this->db->join("tcontacto","tcontacto.id=contacto.tcontacto_id");
		$this->db->where("equipo_contacto.equipo_id=".$param['equipo_id']);
		return $this->db->get()->result();
	}
	public function get_fabricante($param){
		$this->db->select("
			equipo_contacto.*,
			contacto.name as contacto,
			contacto.email as email,
			contacto.telefono as telefono,
			tcontacto.description as tcontacto
			");
		$this->db->from("equipo_contacto");
		$this->db->join("contacto","contacto.id=equipo_contacto.contacto_id");
		$this->db->join("tcontacto","tcontacto.id=contacto.tcontacto_id");
		$this->db->where("equipo_contacto.equipo_id=".$param['equipo_id']);
		$this->db->where("tcontacto.description='FABRICANTE'");
		$this->db->order_by("equipo_contacto.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}
	public function get_proveedor($param){
		$this->db->select("
			equipo_contacto.*,
			contacto.name as contacto,
			contacto.email as email,
			contacto.telefono as telefono,
			tcontacto.description as tcontacto
			");
		$this->db->from("equipo_contacto");
		$this->db->join("contacto","contacto.id=equipo_contacto.contacto_id");
		$this->db->join("tcontacto","tcontacto.id=contacto.tcontacto_id");
		$this->db->where("equipo_contacto.equipo_id=".$param['equipo_id']);
		$this->db->where("tcontacto.description='PROVEEDOR'");
		$this->db->order_by("equipo_contacto.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}
	public function get_representante($param){
		$this->db->select("
			equipo_contacto.*,
			contacto.name as contacto,
			contacto.email as email,
			contacto.telefono as telefono,
			tcontacto.description as tcontacto
			");
		$this->db->from("equipo_contacto");
		$this->db->join("contacto","contacto.id=equipo_contacto.contacto_id");
		$this->db->join("tcontacto","tcontacto.id=contacto.tcontacto_id");
		$this->db->where("equipo_contacto.equipo_id=".$param['equipo_id']);
		$this->db->where("tcontacto.description='REPRESENTANTE'");
		$this->db->order_by("equipo_contacto.id","desc");
		$this->db->limit(1);
		return $this->db->get()->result();
	}		
	public function add($param){
		$this->db->insert("equipo_contacto",$param);
	}
	public function copy_contactos($param){
		$query="

			INSERT INTO equipo_contacto(
			    equipo_id,
			    contacto_id
			    
			)
			SELECT
			    ".$param["equipo_id_destino"].",
			    contacto_id
			    
			FROM
			    equipo_contacto
			WHERE
			    equipo_id = ".$param["equipo_id_origen"]."

		";
		$this->db->query($query);
	}

	public function delete($param){
		$this->db->where("id",$param["id"]);
		$this->db->delete("equipo_contacto");

	}

}

 ?>