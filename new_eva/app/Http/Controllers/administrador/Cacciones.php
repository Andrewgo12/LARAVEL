<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Macciones;

class Cacciones extends Controller
{
  private $permisos;
  
  function __construct()
  {
    $this->Macciones = new Macciones();
  }

  public function getAll()
  {
  }
  
  public function getByUser()
  {
  }
  
  public function edit(Request $request)
  {
    $registro_acciones = $this->Macciones->getOne($request->all());

    if ($request["accion"] == 1) {
      if ($registro_acciones->leer == 1) {
        $request["leer"] = 0;
      } else {
        $request["leer"] = 1;
      }
    } else if ($request["accion"] == 2) {
      if ($registro_acciones->insertar == 1) {
        $request["insertar"] = 0;
      } else {
        $request["insertar"] = 1;
      }
    } else if ($request["accion"] == 3) {
      if ($registro_acciones->editar == 1) {
        $request["editar"] = 0;
      } else {
        $request["editar"] = 1;
      }
    } else if ($request["accion"] == 4) {
      if ($registro_acciones->eliminar == 1) {
        $request["eliminar"] = 0;
      } else {
        $request["eliminar"] = 1;
      }
    }
    
    $data = $request->except('accion');
    $this->Macciones->edit($data);
    return response()->json($this->Macciones->getByUser($registro_acciones->usuario_id));
  }
  /*
  public function add(){// Este add no almacena directamente, lo que hace es llamar un formulario
    $param=array(
      'roles' => $this->Musuarios->getRoles(),
      'menus' => $this->Mpermisos->getMenus()
      
      );

    return view('layouts.app', [
      'content' => view('permisos.add', $param)->render()
    ]);
  }
  
  public function delete($param){
    if(!$this->Mpermisos->delete($param)){
      return redirect()->to("administrador/Cpermisos");
    }
  }
  */
}

