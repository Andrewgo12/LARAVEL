<?php
// defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
 * 
 */
require APPPATH . 'libraries/REST_Controller.php';

class Requipos extends REST_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mequipos');
  }

  public function comunicacion_get($id = 0)
  {
    header('Access-Control-Allow-Origin: *');
    /*   
        if($id!=0){
            $data = $this->db->get_where("equipos", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("equipos")->result();
        }
        */
    $query = "
        SELECT
            e.name AS nombre,
            e.marca AS marca,
            e.modelo AS modelo,
            e.code AS codigo,
            e.serial AS serie,
            s.name AS servicio,
            sed.name AS sede,
            a.name AS area
        FROM
            equipos e
        LEFT JOIN servicios s ON
            s.id = e.servicio_id
        LEFT JOIN sedes sed ON
            sed.id = s.sede_id
        LEFT JOIN areas a ON
            e.area_id = a.id
        WHERE
            e.tipo_id = 1
    ";
    $datos = $this->db->query($query)->result();

    $this->response($datos, REST_Controller::HTTP_OK);
    //$this->response($data, REST_Controller::HTTP_OK);
  }
  public function comunicacion_post()
  {
    $input = $this->input->post();
    $this->db->insert('equipos', $input);

    $this->response(['Pais insertado exitosamente.'], REST_Controller::HTTP_OK);
  }
  public function comunicacion_put($id)
  {
    $input = $this->put();
    $this->db->update('equipos', $input, array('id' => $id));

    $this->response(['Pais actualizado exitosamente.'], REST_Controller::HTTP_OK);
  }
  public function comunicacion_delete($id)
  {
    $this->db->delete('equipos', array('id' => $id));

    $this->response(['pais eliminado exitosamente.'], REST_Controller::HTTP_OK);
  }
}
