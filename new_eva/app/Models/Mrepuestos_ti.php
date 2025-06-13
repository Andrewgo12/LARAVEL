<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mrepuestos_ti extends CI_Model
{
	function __construct()
	{
		defined('BASEPATH') or exit('El acceso directo no esta permitido');
		parent::__construct();
	}
	public function get($param)
	{
		$this->db->where("orden_id", $param["id"]);
		$this->db->order_by("name", "asc");
		return $this->db->get("repuestos_ti")->result();
	}
	public function add($param)
	{
		$this->db->insert("repuestos_ti", $param);
	}
	public function update($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$this->db->update("repuestos_ti", $param);
	}
	public function delete($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		$this->db->update("repuestos_ti", $param);
	}
	public function addList($param)
	{
		foreach ($param as $element) {
			$this->db->insert("repuestos_pendientes", $element);
		}
	}
}
