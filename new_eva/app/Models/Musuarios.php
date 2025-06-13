<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Musuarios extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	/* Refactoring */
	public function getOneUser($id)
	{
		$this->db->select("usuarios.*");
		$this->db->from("usuarios");
		$this->db->join("roles", "usuarios.rol_id=roles.id", 'left');
		$this->db->where("usuarios.estado=1");
		$this->db->where('usuarios.id', $id);
		$this->db->order_by("name", "asc");
		return $this->db->get()->row();
	}
	public function getAllUsers()
	{
		$this->db->select("usuarios.*");
		$this->db->from("usuarios");
		$this->db->join("roles", "usuarios.rol_id=roles.id", 'left');
		$this->db->where("usuarios.estado=1");
		$this->db->order_by("name", "asc");
		return $this->db->get()->result();
	}





	public function get()
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		return ($this->db->get());
	}
	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		return $this->db->get()->result();
	}
	public function getUsuarios_zonas()
	{
		$query = "

			SELECT
				usuarios_zonas.*,
			    usuarios.nombre AS usuario,
			    usuarios.email AS email,
			    zonas.name AS zona
			FROM
			    usuarios_zonas
			LEFT JOIN usuarios ON usuarios.id = usuarios_zonas.usuario_id
			LEFT JOIN zonas ON zonas.id = usuarios_zonas.zona_id
			ORDER BY zonas.name asc, usuarios.nombre asc
		";
		return $this->db->query($query)->result();
	}
	public function delete_usuario_zona($param)
	{
		$this->db->where("id", $param["id"]);
		$this->db->delete("usuarios_zonas");
	}
	public function login($param)
	{
		$this->db->where('username', $param['username']);
		$this->db->where('password', sha1(md5($param['password'])));
		$this->db->where('estado', 1);
		//$this->db->where('active', "true");
		$resultado = $this->db->get('usuarios');
		if ($resultado->num_rows() > 0) {
			return $resultado->row();
		} else {
			return false;
		}
	}
	public function get_server_side($param)
	{
		if ($param['length'] < 0) {
			$param['length'] = 999999999;
		}
		$this->db->select('usuarios.*,roles.nombre as rol, centros.name as centro');
		$this->db->from('usuarios');
		$this->db->join('roles', 'roles.id=usuarios.rol_id', 'left');
		$this->db->join('centros', 'centros.id=usuarios.centro_id', 'left');
		$this->db->where('usuarios.estado !=0 and(			
			usuarios.username like"%' . $param['search']['value'] . '%" or
			usuarios.nombre like"%' . $param['search']['value'] . '%")');
		$this->db->limit($param['length'], $param['start']);
		$result = $this->db->get(); // Estructura de datos

		$num_filas_limit = $result->num_rows();
		$datos = $result->result();

		$this->db->select('usuarios.*,roles.nombre as rol, centros.name as centro');
		$this->db->from('usuarios');
		$this->db->join('roles', 'roles.id=usuarios.rol_id', 'left');
		$this->db->join('centros', 'centros.id=usuarios.centro_id', 'left');
		$this->db->where('usuarios.estado !=0 and(			
			usuarios.username like"%' . $param['search']['value'] . '%" or
			usuarios.nombre like"%' . $param['search']['value'] . '%")');
		$num_filas = $this->db->get()->num_rows();

		$vector = array(

			'datos' => $datos,
			'num_filas_limit' => $num_filas_limit,
			'num_filas' => $num_filas

		);

		return $vector;
	}
	public function getRoles()
	{
		return $this->db->get("roles")->result();
	}

	public function getUsuariosFromEmpresa($param)
	{
		$this->db->where("id_empresa", $param["empresa_id"]);
		return $this->db->get("usuarios")->result();
	}

	public function add($param)
	{
		$this->db->insert('usuarios', $param);
		return $this->db->insert_id();
	}

	public function update($param)
	{
		$this->db->where('id', $param['id']);
		unset($param['id']);
		$this->db->update('usuarios', $param);
	}
	public function delete($param, $array)
	{
		$this->db->where('id', $param['id']);
		$this->db->update('usuarios', $array);
	}
	public function getOne($param)
	{
		$this->db->select('usuarios.*,roles.nombre as rol, centros.name as centro, empresas.name as empresa, sedes.name as sede');
		$this->db->from('usuarios');
		$this->db->join('roles', "roles.id=usuarios.rol_id", "left");
		$this->db->join('centros', "centros.id=usuarios.centro_id", "left");
		$this->db->join('empresas', "empresas.id=usuarios.id_empresa", "left");
		$this->db->join('sedes', "sedes.id=usuarios.sede_id", "left");
		$this->db->where('usuarios.id', $param);
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	public function activate($data, $id)
	{
		$this->db->where('usuarios.id', $id);
		return $this->db->update('usuarios', $data);
	}
	public function CambiarSede($param)
	{
		if ($param["caso"] == 1) {
			$query = "UPDATE usuarios set sede_id=2 where id=" . $param["id"];
		} else {

			$query = "UPDATE usuarios set sede_id=1 where id=" . $param["id"];
		}
		$this->db->query($query);
	}
	public function CambiarAnio($param)
	{
		$query = "UPDATE usuarios set anio_plan = " . $param["anio_plan"] . " WHERE id=" . $param["id"];
		return $this->db->query($query);
	}
}
