<?php 

defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
* 
*/
class Mupload extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}
	function save_upload($archivo,$tipo=""){
		if ($tipo=="archivo") {
        $data = array(
                'file' => $archivo
            );  
		}elseif($tipo=="imagen"){
        $data = array(
                'image' => $archivo
            );  
		}
        $result= $this->db->insert('equipos',$data);
        return $result;
    }

}

?>