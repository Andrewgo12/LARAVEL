		<?php
    defined('BASEPATH') or exit('El acceso directo no esta permitido');
    class Cauth extends CI_Controller
    {

      function __construct()
      {
        parent::__construct();
        $this->load->model('Musuarios');
        $this->load->model('Mcentros');
        $this->load->model('Macciones');
        $this->load->library("email");
        $this->load->model("Mequipos");
        $this->load->model("Madquisiciones");
        $this->load->model("Mfuentes");
        $this->load->model("Mtecnologias");
        $this->load->model("Mcbiomedicas");
        $this->load->model("Mcriesgos");
        $this->load->model("Mfrecuencias");
        $this->load->model("Mzonas");
        $this->load->model("Mpreventivos");
        $this->load->model("Mcalibraciones");
        $this->load->model("Mespecificaciones");
        $this->load->model("Mequipo_especificaciones");
        $this->load->model("Mcontactos");
        $this->load->model("Mequipo_contactos");
        $this->load->model("Mordenes");
        $this->load->model("Mcorrectivos_generales");
        $this->load->model("Mequipo_archivos");
        $this->load->model("Marchivos");
        $this->load->model('Mupload');
      }
      public function index()
      {
        if (!isset($_GET["variable"])) {
          if ($this->session->userdata('login')) {
            redirect(base_url('Home'));
          } else {
            $param = array(
              'centros' => $this->Mcentros->getAllCentros()
            );
            $this->load->view('layouts/login_header');
            $this->load->view('layouts/login_body');
            $this->load->view('admin/modal_reg', $param);
            $this->load->view('layouts/login_footer');
          }
        } else {
          echo "existe";
        }
      }
      public function reg()
      {
        $control = array(
          "respuesta" => "",
          "valor" => ""
        );
        $param = $_POST;
        $this->form_validation->set_rules('nombre', 'Nombres', 'required|min_length[5]');
        $this->form_validation->set_rules('username', 'Nombre de usuario ' . $_POST['username'], 'required|is_unique[usuarios.username]');
        $this->form_validation->set_rules('email', 'Correo electronico', 'required|valid_email|is_unique[usuarios.email]');
        $this->form_validation->set_rules('password1', "constraseña", 'required|min_length[4]');
        $this->form_validation->set_rules('password2', "Confirmar contraseña", 'matches[password1]');

        $this->form_validation->set_message('required', '%s es obligatorio');
        $this->form_validation->set_message('is_unique', '%s ya se encuentra en la base de datos');

        if ($this->form_validation->run()) {
          $password = $param["password1"];
          $password_original = $param["password1"];
          $param['password'] = sha1(md5($param["password1"]));
          unset($param['password1']);
          unset($param['password2']);

          // generar código aleatorio simple
          $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $code = substr(str_shuffle($set), 0, 12);

          $param['code'] = $code;
          $param['active'] = "false";

          $id_ultimo_usuario = $this->Musuarios->add($param);

          $control["respuesta"] = 1;
          $control["valor"] = $id_ultimo_usuario;
          $control["password"] = $password_original;
          echo json_encode($control);
        } else {
          $control["respuesta"] = 0;
          $control["valor"] = validation_errors();
          echo json_encode($control);
        }
      }
      public function email_registro()
      {
        $password = $_POST["password"];

        unset($_POST["password"]);
        $usuario = $this->Musuarios->getOne($_POST["id"]);

        $vector_usuario = array(
          "usuario" => $usuario,
          "password" => $password
        );
        //configuracion para gmail
        $configGmail = array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.googlemail.com',
          'smtp_port' => 465,
          'smtp_user' => 'evagestionahuv@gmail.com',
          'smtp_pass' => 'ronrokgffjiurzio',
          'mailtype' => 'html',
          'charset' => 'utf-8',
          'newline' => "\r\n"
        );

        $this->email->initialize($configGmail);
        $this->email->from('evagestionahuv@gmail.com', "Electromedicina");
        $this->email->to($usuario->email, $usuario->nombre . ' ' . $usuario->apellido);
        $this->email->subject('Creación de cuenta exitosa');
        $msj = $this->load->view("usuarios/email_reg", $vector_usuario, TRUE);

        $this->email->message($msj);
        if ($this->email->send()) {
          // echo "Enviado by Electromedicina HUV";
        } else {
          show_error($this->email->print_debugger());
        }
      }

      public function login()
      {
        //echo json_encode($_POST);

        $control = array(

          "existe" => "si",
          "confirmo" => "si"
        );
        $usuario = $this->Musuarios->login($_POST);
        if ($usuario == false) {
          $control["existe"] = "no";
        } else {
          if ($usuario->active == "true") {

            $acciones = $this->Macciones->getByUser($usuario->id);


            $data = array(

              'id' => $usuario->id,
              'nombre' => $usuario->nombre,
              'apellido' => $usuario->apellido,
              'telefono' => $usuario->telefono,
              'email' => $usuario->email,
              'username' => $usuario->username,
              'rol_id' => $usuario->rol_id,
              'login' => TRUE,
              'sede_id' => $usuario->sede_id,
              'acciones' => $acciones,
              'anio_plan' => $usuario->anio_plan,
              'id_empresa' => $usuario->id_empresa
            );
            $this->session->set_userdata($data);
          } else {
            $control["confirmo"] = "no";
          }
        }

        echo json_encode($control);
      }
      public function logout()
      {
        $this->session->sess_destroy();
        redirect(base_url());
      }

      public function hoja_de_vida($var = "")
      {

        $vector = array(
          "id" => $var,
          "equipo_id" => $var
        );

        $equipo = $this->Mequipos->getOne($vector);
        unset($vector["id"]);
        $preventivos = $this->Mpreventivos->get($vector);
        $calibraciones = $this->Mcalibraciones->get($vector);
        $especificaciones = $this->Mequipo_especificaciones->get($vector);
        $contactos = $this->Mequipo_contactos->get($vector);
        $correctivos = $this->Mordenes->get($vector);
        $correctivos_generales = $this->Mcorrectivos_generales->get($vector);
        $vector["id"] = $vector["equipo_id"];
        $archivos = $this->Mequipo_archivos->get($vector);

        $param = array(
          'equipo' => $equipo,
          'preventivos' => $preventivos,
          'calibraciones' => $calibraciones,
          'especificaciones' => $especificaciones,
          'contactos' => $contactos,
          'correctivos' => $correctivos,
          'correctivos_generales' => $correctivos_generales,
          'archivos' => $archivos
        );


        $identificador = array(
          "identificador" => $var
        );
        $this->load->view("layouts/header_qr");
        $this->load->view("detalle/detalle", $param);
        $this->load->view("layouts/footer_qr");
      }

      public function activate()
      {

        $id =  $this->uri->segment(3);
        $code = $this->uri->segment(4);

        // obtener los detalles del usuario		        
        $usuario = $this->Musuarios->getOne($id);

        // si el código coincide
        if ($usuario->code == $code) {
          // actualizar el estado activo del usuario
          $data['active'] = "true";
          $query = $this->Musuarios->activate($data, $id);

          if ($query) {
            $this->session->set_flashdata('message', 'Cuenta activada exitosamente');
            $this->Macciones->add($id, 1, 1, 0, 0, 0); //equipos
            $this->Macciones->add($id, 2, 0, 0, 0, 0); //usuarios
            $this->Macciones->add($id, 3, 0, 0, 0, 0); //servicios
            $this->Macciones->add($id, 4, 1, 0, 0, 0); //equipos industriales
            $this->Macciones->add($id, 5, 0, 0, 0, 0); //bajas equipos biomedicos
            $this->Macciones->add($id, 6, 0, 0, 0, 0); //invimas
            $this->Macciones->add($id, 7, 0, 0, 0, 0); //soportes compra
            $this->Macciones->add($id, 8, 0, 0, 0, 0); //repuestos
            $this->Macciones->add($id, 9, 0, 0, 0, 0); //estado equipos
            $this->Macciones->add($id, 10, 0, 0, 0, 0); //contactos
            $this->Macciones->add($id, 11, 0, 0, 0, 0); //reportes
            $this->Macciones->add($id, 12, 0, 0, 0, 0); //planes mantenimiento
            $this->Macciones->add($id, 13, 0, 0, 0, 0); //capacitaciones
            $this->Macciones->add($id, 14, 0, 0, 0, 0); //equipo archivos
            $this->Macciones->add($id, 15, 1, 1, 0, 0); //tickets propios
            $this->Macciones->add($id, 16, 0, 0, 0, 0); //tickets activos
            $this->Macciones->add($id, 17, 0, 0, 0, 0); //tickets cerrados
            $this->Macciones->add($id, 18, 0, 0, 0, 0); //observaciones
            $this->Macciones->add($id, 20, 0, 0, 0, 0); //areas
            $this->Macciones->add($id, 21, 0, 0, 0, 0); //contingencias
            $this->Macciones->add($id, 22, 0, 0, 0, 0); //guias rapidas
          } else {
            $this->session->set_flashdata('message', 'Hubo un problema durante el proceso de activacion de la cuenta');
          }
        } else {
          $this->session->set_flashdata('message', 'No se pudo activar la cuenta. Codigo no coincide');
        }

        redirect('Cauth');
      }
    }
    ?>