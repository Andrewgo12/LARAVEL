<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    function __construct()
    {
      parent::__construct();
      $this->load->model('Mmanuales');
    }
    public function index()
    {
    }
    public function get_manuals(){
      $manuales = $this->Mmanuales->getAll();
      echo json_encode($manuales);
      $this->output->set_status_header(200);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($manuales));
    }
    public function get_manual($id){
      $manual = $this->Mmanuales->getOne($id);
      if ($manual){
        $this->output->set_status_header(200);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($manual));
      }
      else{
        $this->output->set_status_header(404);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('error' => 'No se encontró el manual')));
      }
    }
}
