<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mpermisos;
use App\Models\Musuarios;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class Cpermisos extends Controller
{
    protected Mpermisos $Mpermisos;
    protected Musuarios $Musuarios;

    public function __construct()
    {
        $this->Mpermisos = new Mpermisos();
        $this->Musuarios = new Musuarios();
        // Eliminado vestigio de CodeIgniter: backend_lib/control()
    }

    public function index()
    {
        if (!Session::has('login')) {
            return redirect()->route('Cauth');
        }

        $permisos = $this->Mpermisos->get();

        return view('permisos.list', [
            'permisos_listado' => $permisos
        ]);
    }

    public function add()
    {
        return view('permisos.add', [
            'roles' => $this->Musuarios->getRoles(),
            'menus' => $this->Mpermisos->getMenus()
        ]);
    }

    public function save(Request $request)
    {
        $saved = $this->Mpermisos->save($request->all());

        if ($saved) {
            return redirect()->to('administrador/Cpermisos/add');
        } else {
            Session::flash('error', 'No se pudo guardar la información');
            return redirect()->to('administrador/Cpermisos');
        }
    }

    public function edit($id)
    {
        return view('permisos.edit', [
            'roles' => $this->Musuarios->getRoles(),
            'menus' => $this->Mpermisos->getMenus(),
            'permiso' => $this->Mpermisos->getOne($id)
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['menu_id', 'rol_id']);

        if ($this->Mpermisos->update($data)) {
            return redirect()->to('administrador/Cpermisos/add');
        } else {
            Session::flash('error', 'No se pudo guardar la información');
            return redirect()->to('administrador/Cpermisos');
        }
    }

    public function delete($id)
    {
        $this->Mpermisos->delete($id);

        return redirect()->to('administrador/Cpermisos');
    }
}
