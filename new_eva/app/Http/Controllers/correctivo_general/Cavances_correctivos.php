<?php 
defined ('BASEPATH') OR exit('El acceso directo no esta permitido');
/**
*
*/
class Cavances_correctivos extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mavances_correctivos');
		$this->load->model('Mcorrectivos_generales');
	}
	public function get(){
	}
	public function getAll(){
	}
	public function getOne(){
	}
	public function GetByDevice(){

		echo json_encode($this->Mavances_correctivos->GetByDevice($_POST));
	}
	public function GetByOrden(){

		echo json_encode($this->Mavances_correctivos->GetByOrden($_POST));
	}
	public function add(){
		$_POST["usuario_id"]=$this->session->userdata("id");
		unset($_POST["origen"]);

			$config['upload_path']="./assets/upload_correctivos_generales";//Evaluacion del archivo
			$config['allowed_types']='*';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload',$config,'uploadFile');
			$this->uploadFile->initialize($config);

		if (!empty($_FILES["file"]["name"])) {
	        $this->uploadFile->do_upload("file");//Esto sube el excel en la carpeta
	        $data="";$data=$this->uploadFile->data();
	        $_POST["file"]=$data["file_name"];
	    }

	    if ($this->Mavances_correctivos->add($_POST)) {
	    	echo json_encode(1);
	    }else{
	    	if (isset($_POST["file"])) {
	    		$this->load->helper("file");
	    		unlink("./assets/upload_correctivos_generales/".$_POST["file"]);
	    	}       	
	    	echo json_encode(0);
	    }
	}
	public function update(){
	}
	public function delete(){
		
		$this->Mavances_correctivos->delete($_POST);
	}
	public function show(){
		$vector=array(
			'correctivos' => $this->Mcorrectivos_generales->getCorrectivosModal()
		);
		$this->load->view("correctivos_generales/detail",$vector);
	}


}

?>