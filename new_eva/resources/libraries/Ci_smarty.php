<?php

require_once(APPPATH . 'third_party/smarty/vendor/smarty/smarty/libs/Smarty.class.php');

class Ci_Smarty extends Smarty
{
    function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(APPPATH . 'views');
        $this->setCompileDir(APPPATH . 'views/compiled');
        $this->setCacheDir(APPPATH . 'third_party/smarty/cache');
        $ci = &get_instance();
        $this->assignByRef('ci', $ci);
    }
}
