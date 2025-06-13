<?php

/**
 * Backend_lib Class
 */
class Backend_lib
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function control()
    {
        if (!$this->CI->session->userdata("login")) {
            redirect(base_url());
        } else {
            if ($this->CI->uri->segment(2)) {
                $url = $this->CI->uri->segment(1) . '/' . $this->CI->uri->segment(2);
            }

            if ($this->CI->uri->segment(3) == "list_active") {
                $url = $this->CI->uri->segment(1) . '/' . $this->CI->uri->segment(2) . '/' . $this->CI->uri->segment(3);
            }

            $infomenu = $this->CI->Backend_model->getID($url);
            $permisos = $this->CI->Backend_model->getPermisos($infomenu->id, $this->CI->session->userdata('rol_id'));

            if ($permisos->read == 0) {
                redirect(base_url()."Dashboard");
            } else {
                return $permisos;
            }
        }
    }
}
