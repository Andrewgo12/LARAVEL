<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Testing extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
  }
  public function index()
  {

    $this->load->view('layouts/adminlte3/header');
    $this->load->view('layouts/adminlte3/aside');
    $this->load->view('layouts/adminlte3/body');
    $this->load->view('layouts/adminlte3/footer');

    // $this->load->view('layouts/adminlte3/completo');
  }
}
