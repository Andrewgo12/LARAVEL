<?php
// application/controllers/Zip.php
defined('BASEPATH') or exit('No direct script access allowed');

class Zip extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("Mpreventivos");
  }
  private function _load_zip_lib()
  {
    $this->load->library('zip');
  }

  private function _archieve_and_download($filename)
  {
    // create zip file on server
    $this->zip->archive(FCPATH . '/assets/zips/' . $filename);

    // prompt user to download the zip file
    $this->zip->download($filename);
  }

  public function data()
  {
    $this->_load_zip_lib();

    $this->zip->add_data('name.txt', 'Sajal Soni');
    $this->zip->add_data('profile.txt', 'Web Developer');

    $this->_archieve_and_download('my_info.zip');
  }

  public function data_array()
  {
    $this->_load_zip_lib();

    $files = array(
      'name.txt' => 'Sajal Soni',
      'profile.txt' => 'Web Developer'
    );

    $this->zip->add_data($files);

    $this->_archieve_and_download('my_info.zip');
  }

  public function data_with_subdirs()
  {
    $this->_load_zip_lib();

    $this->zip->add_data('info/name.txt', 'Sajal Soni');
    $this->zip->add_data('info/profile.txt', 'Web Developer');

    $this->_archieve_and_download('my_info.zip');
  }

  public function files()
  {
    if (isset($_POST)) {
      $vector = $this->Mpreventivos->DecodificarParaZip($_POST);

      // print_r($vector);

      $this->_load_zip_lib();
      foreach ($vector as $registro) {
        $this->zip->read_file(FCPATH . '/assets/upload_preventivos/' . $registro->codificado, FALSE, $registro->nuevo . ".pdf");
      }

      // pass second argument as TRUE if want to preserve dir structure
      // $this->zip->read_file(FCPATH.'/assets/upload_preventivos/00eef48dc0cceca26832811f3a1c2862.pdf',FALSE,"55764.pdf");
      // $this->zip->read_file(FCPATH.'/assets/upload_preventivos/0c7808a78a05da1053e024ac8413786a.pdf',FALSE,"59319.pdf");
      // $this->zip->read_file(FCPATH.'/assets/zips/2.jpg');

      $this->_archieve_and_download('archivos.zip'); // La carpeta donde guarda el zip
    }
  }

  public function dir()
  {
    $this->_load_zip_lib();

    // pass second argument as FALSE if want to ignore preceding directories
    $this->zip->read_dir(FCPATH . '/assets/zips/images/');

    $this->_archieve_and_download('dir_images.zip');
  }
}
