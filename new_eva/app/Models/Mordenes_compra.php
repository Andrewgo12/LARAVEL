<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mordenes_compra extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAll()
	{
		$this->db->select("ordenes_compra.*,tipos_compra.tipo_compra as tipo_compra");
		$this->db->from("ordenes_compra");
		$this->db->join("tipos_compra", "tipos_compra.id=ordenes_compra.tipo_compra_id", "left");
		$this->db->order_by("ordenes_compra.fecha", "desc");
		return $this->db->get()->result();
	}
	public function add($param)
	{
		return ($this->db->insert("ordenes_compra", $param));
	}

	public function getOne($param)
	{
		$this->db->where("id", $param["id"]);
		return $this->db->get("ordenes_compra")->row();
	}
	public function update($param)
	{
		$this->db->where("id", $param["id"]);
		unset($param["id"]);
		return ($this->db->update("ordenes_compra", $param));
	}
	public function getActive()
	{
		$this->db->select("ordenes_compra.*,contacto.name as proveedor");
		$this->db->from("ordenes_compra");
		$this->db->join("contacto", "contacto.id=ordenes_compra.proveedor_id", "left");
		$this->db->where("ordenes_compra.status", 1);
		$this->db->order_by("orden", 'asc');
		return $this->db->get()->result();
	}
	public function getOrdenesCompra()
	{
		$this->db->select("ordenes_compra.*,contacto.name as proveedor");
		$this->db->from("ordenes_compra");
		$this->db->join("contacto", "contacto.id=ordenes_compra.proveedor_id", "left");
		$this->db->where("ordenes_compra.status", 1);
		$this->db->where("ordenes_compra.tipo_compra_id", 1);
		$this->db->order_by("orden", 'asc');
		return $this->db->get()->result();
	}
	public function getContratos()
	{
		$this->db->select("ordenes_compra.*,contacto.name as proveedor");
		$this->db->from("ordenes_compra");
		$this->db->join("contacto", "contacto.id=ordenes_compra.proveedor_id", "left");
		$this->db->where("ordenes_compra.tipo_compra_id", 2);
		$this->db->order_by("orden", 'asc');
		return $this->db->get()->result();
	}
	public function getCrucesCuentas()
	{
		$this->db->select("ordenes_compra.*,contacto.name as proveedor");
		$this->db->from("ordenes_compra");
		$this->db->join("contacto", "contacto.id=ordenes_compra.proveedor_id", "left");
		$this->db->where("ordenes_compra.tipo_compra_id", 3);
		$this->db->order_by("orden", 'asc');
		return $this->db->get()->result();
	}
	public function getComodatos()
	{
		$this->db->select("ordenes_compra.*,contacto.name as proveedor");
		$this->db->from("ordenes_compra");
		$this->db->join("contacto", "contacto.id=ordenes_compra.proveedor_id", "left");
		$this->db->where("ordenes_compra.tipo_compra_id", 4);
		$this->db->order_by("orden", 'asc');
		return $this->db->get()->result();
	}
	public function getWithNumberDevices()
	{
		$query = "
		SELECT
		ordenes_compra.*,contacto.name as proveedor,
		(
		SELECT COUNT(*)
		FROM
		equipos
		WHERE
		equipos.orden_compra_id = ordenes_compra.id
		)as cuenta,
		tipos_compra.tipo_compra as tipo_compra

		FROM
		ordenes_compra 
		LEFT JOIN equipos on equipos.orden_compra_id=ordenes_compra.id
		LEFT JOIN tipos_compra on tipos_compra.id=ordenes_compra.tipo_compra_id
		LEFT JOIN contacto on contacto.id=ordenes_compra.proveedor_id
		WHERE contacto.name IS NOT NULL
		GROUP BY ordenes_compra.orden
		ORDER BY ordenes_compra.fecha desc
		
		";
		return $this->db->query($query)->result();
	}
	/*
	public function get(){
		$this->db->select("*");
		$this->db->from("invimas");
		$this->db->where("status",1);
		$this->db->order_by("invima",'asc');
		return $this->db->get()->result();
	}
	public function getdescriptionlike($param){
		$query="select invima from invimas where description like '%".$param["consulta"]."%'";
		return $this->db->query($query)->result();
	}
	public function delete($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$param["status"]=0;
		$this->db->update("invimas",$param);
	}	
	public function activate($param){
		$this->db->where("id",$param["id"]);
		unset($param["id"]);
		$param["status"]=1;
		$this->db->update("invimas",$param);
	}	
	// public function delete($param){
	// 	$this->db->where("id",$param["id"]);
	// 	$this->db->delete("invimas");
	// }	
	*/
}
