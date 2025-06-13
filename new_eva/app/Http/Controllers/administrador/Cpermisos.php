<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mpermisos;
use App\Models\Musuarios;
use Illuminate\Support\Facades\Session;

class Cpermisos extends Controller
{
  private $permisos;
  private Mpermisos $Mpermisos;
  private Musuarios $Musuarios;
  
  public function __construct()
  {
    $this->Mpermisos = new Mpermisos();
    $this->Musuarios = new Musuarios();
    // Asumiendo que backend_lib se ha migrado a un servicio de Laravel
    // $this->permisos = app('backend_lib')->control();
  }
  
  public function index()
  {
    if (!Session::has('login')) {
      return redirect('Cauth');
    }
    
    $permisos = $this->Mpermisos->get();
    $param = [
      'permisos_listado' => $permisos
    ];
    
    return view('permisos.list', $param);
  }
  
  public function add()
  { // Este add no almacena directamente, lo que hace es llamar un formulario
    $param = [
      'roles' => $this->Musuarios->getRoles(),
      'menus' => $this->Mpermisos->getMenus()
    ];

    return view('permisos.add', $param);
  }
  
  public function save(Request $request)
  {
    if ($this->Mpermisos->save($request->all())) {
      return redirect()->to("administrador/Cpermisos/add");
    } else {
      Session::flash("error", "No se pudo guardar la información");
      return redirect()->to("administrador/Cpermisos");
    }
  }
  
  public function edit($param)
  {
    $param = [
      'roles' => $this->Musuarios->getRoles(),
      'menus' => $this->Mpermisos->getMenus(),
      'permiso' => $this->Mpermisos->getOne($param)
    ];

    return view('permisos.edit', $param);
  }
  
  public function update(Request $request)
  {
    $data = $request->except(['menu_id', 'rol_id']);
    
    if ($this->Mpermisos->update($data)) {
      return redirect()->to("administrador/Cpermisos/add");
    } else {
      Session::flash("error", "No se pudo guardar la información");
      return redirect()->to("administrador/Cpermisos");
    }
  }
  
  public function delete($param)
  {
    if (!$this->Mpermisos->delete($param)) {
      return redirect()->to("administrador/Cpermisos");
    }
    
    return redirect()->to("administrador/Cpermisos");
  }
}

