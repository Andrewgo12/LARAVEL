<?php

defined('BASEPATH') or exit('El acceso directo no esta permitido');

/**
 * 
 */
class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if (!$this->session->userdata('id')) {
      redirect('Cauth');
    }
  }
  public function index()
  {

    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view('admin/dashboard');
    $this->load->view('layouts/footer');
  }
}
