<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 * 
 */
class Mrepuestos_pendientes extends CI_Model
{
    function __construct()
    {
        defined('BASEPATH') or exit('El acceso directo no esta permitido');
        parent::__construct();
    }
    public function getOne($param)
    {
        $this->db->where("id", $param["repuesto_pendiente_id"]);
        return $this->db->get("repuestos_pendientes")->row();
    }
    public function getAll($param)
    {
        $this->db->where("correctivo_general_id", $param["correctivo_general_id"]);
        $this->db->order_by("created_at", "asc");
        return $this->db->get("repuestos_pendientes")->result();
    }

    public function add($param)
    {
        $this->db->insert("repuestos_pendientes", $param);
    }
    public function update($param)
    {
    }
    public function delete($param)
    {
    }
    public function toggle_state_repuesto_pendiente($param)
    {
        $query = "UPDATE repuestos_pendientes SET status = status ^ 1 WHERE id = " . $param["repuesto_pendiente_id"];
        return $this->db->query($query);
    }
}
