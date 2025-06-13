<?php
// defined ('BASEPATH') OR exit('El acceso directo no esta permitido');

/**
 * 
 */
require APPPATH . 'libraries/REST_Controller.php';

class Rpaises extends REST_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Mpaises');
  }

  public function comunicacion_get($id = 0)
  {
    if ($id != 0) {
      $data = $this->db->get_where("paises", ['id' => $id])->row_array();
    } else {
      $data = $this->db->get("paises")->result();
    }

    $this->response($data, REST_Controller::HTTP_OK);
  }
  public function comunicacion_post()
  {
    $input = $this->input->post();
    $this->db->insert('paises', $input);

    $this->response(['Pais insertado exitosamente.'], REST_Controller::HTTP_OK);
  }
  public function comunicacion_put($id)
  {
    $input = $this->put();
    $this->db->update('paises', $input, array('id' => $id));

    $this->response(['Pais actualizado exitosamente.'], REST_Controller::HTTP_OK);
  }
  public function comunicacion_delete($id)
  {
    $this->db->delete('paises', array('id' => $id));

    $this->response(['pais eliminado exitosamente.'], REST_Controller::HTTP_OK);
  }
}
