<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mmanuales extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	// Refactoring
	public function getOneManual($id)
	{
		$this->db->select('manuales.*');
		$this->db->from('manuales');
		$this->db->where('manuales.id', $id);
		return $this->db->get()->row();
	}
	public function getAllManuals()
	{
		$this->db->select("manuales.*");
		$this->db->from("manuales");
		$this->db->where("manuales.id != ", 0);
		$this->db->order_by("manuales.descripcion", "asc");
		return $this->db->get()->result();
	}
	public function delete($param)
	{
		$this->db->where('id', $param['id']);
		$this->db->delete('manuales');
	}

	public function get()
	{
		$this->db->select("*");
		$this->db->from("manuales");
		$this->db->where("status", 1);
		$this->db->order_by("descripcion", 'asc');
		return $this->db->get()->result();
	}
	public function getAll()
	{
		$this->db->select("*");
		$this->db->from("manuales");
		$this->db->order_by("descripcion", 'asc');
		return $this->db->get()->result();
	}
	public function getWithNumberDevices()
	{
		$query = "
		SELECT
		invimas.*,
		(
		SELECT COUNT(*)
		FROM
		equipos
		WHERE
		equipos.invima_id = invimas.id  


		)as cuenta

		FROM
		invimas LEFT JOIN equipos on equipos.invima_id=invimas.id
		WHERE invimas.id!=1
		GROUP BY invimas.invima
		";
		return $this->db->query($query)->result();
	}
	public function getOne($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->get("manuales")->row();
	}
	public function getdescriptionlike($param)
	{
		$query = "select invima from invimas where description like '%" . $param["consulta"] . "%'";
		return $this->db->query($query)->result();
	}
	public function add($param)
	{
		return ($this->db->insert("manuales", $param));
	}
	public function update($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		return ($this->db->update("manuales", $param));
	}

	public function activate($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$param["status"] = 1;
		$this->db->update("invimas", $param);
	}
	// public function delete($param){
	// 	$this->db->where("id",$param["id"]);
	// 	$this->db->delete("invimas");
	// }	
}
