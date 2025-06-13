<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Musuarios;
use App\Models\Mcentros;
use Illuminate\Support\Facades\Session;

class Ccuentas extends Controller
{
    private $permisos;
    private Musuarios $Musuarios;
    private Mcentros $Mcentros;
    
    public function __construct()
    {
        $this->Musuarios = new Musuarios();
        $this->Mcentros = new Mcentros();
        // Asumiendo que backend_lib se ha migrado a un servicio de Laravel
        // $this->permisos = app('backend_lib')->control();
    }
    
    public function index()
    {
        if (!Session::has('login')) {
            return redirect('Cauth');
        }
        
        $data = [
            "permisos" => $this->permisos
        ];
        
        $data = $this->Musuarios->getOne(Session::get("id"));
        $vector = [
            "usuario" => $data
        ];
        
        return view('usuarios.cuenta', $vector);
    }
    
    public function update_pwd(Request $request)
    {
        $data = $request->all();
        $data["password"] = sha1(md5($data["password"]));
        $this->Musuarios->update($data);
        
        return response()->json(['success' => true]);
    }
}

