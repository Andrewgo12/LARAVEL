<?php
defined('BASEPATH') or exit('El acceso directo no esta permitido');
/**
 *
 */
class Ctrabajos extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mtrabajos");
  }
  public function getAll()
  {
    echo json_encode($this->Mtrabajos->getAll());
  }
}
