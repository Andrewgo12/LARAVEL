<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
  public function index()
  {
    $data = array(
      'id' => 1,
      'name' => "Juan Sebastian",
      'email' => "test@example.com",
    );
    $this->session->set_userdata($data);
    $this->ci_smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
    $this->ci_smarty->assign('data', $data)->display('index.tpl');
  }
  public function test()
  {
    $this->ci_smarty->display('manuales/list.tpl');
  }
  public function test2()
  {
    $this->ci_smarty->display(' list2.tpl');
  }
}
