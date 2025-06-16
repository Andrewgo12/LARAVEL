<?php

namespace App\Http\Controllers\contacto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mcontactos;
use App\Models\Mpisos;
use App\Models\Mzonas;
use App\Models\Mcentros;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class Ccontactos extends Controller
{
    private $Mcontactos;
    private $Mpisos;
    private $Mzonas;
    private $Mcentros;
    
    public function __construct()
    {
        $this->Mcontactos = new Mcontactos();
        $this->Mpisos = new Mpisos();
        $this->Mzonas = new Mzonas();
        $this->Mcentros = new Mcentros();
    }
    
    public function index(): View
    {
        if (!Session::has('login')) {
            return redirect('Cauth');
        }
        
        $acciones = Session::get('acciones');
        Session::put('controlador', request()->segment(2));
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "contactos") {
                if ($accion->leer != 1) {
                    return redirect('Forbidden');
                }
            }
        }
        
        return view('contactos.list')
            ->with('header', view('layouts.header'))
            ->with('aside', view('layouts.aside'))
            ->with('footer', view('layouts.footer'));
    }
    
    public function get_datatable(): JsonResponse
    {
        return response()->json($this->Mcontactos->get_datatable());
    }
    
    public function get(): JsonResponse
    {
        return response()->json($this->Mcontactos->get());
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mcontactos->getOne($request->all()));
    }
    
    public function getProveedores(): JsonResponse
    {
        return response()->json($this->Mcontactos->getProveedores());
    }
    
    public function getTcontactos(Request $request): JsonResponse
    {
        return response()->json($this->Mcontactos->getTcontactos($request->all()));
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        $servicio = $this->Mcontactos->getOne($data);
        
        $validator = Validator::make($data, [
            'name' => $servicio->name == $data['name'] 
                ? 'required|min:3' 
                : 'required|min:3|unique:servicios,name',
        ]);
        
        if ($validator->passes()) {
            $this->Mcontactos->update($data);
            return response()->json([
                'respuesta' => 1,
                'informacion' => ""
            ]);
        } else {
            return response()->json([
                'respuesta' => 2,
                'informacion' => $validator->errors()->all()
            ]);
        }
    }
    
    public function add(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if (isset($data["id"])) {
            unset($data["id"]);
        }
        
        $validator = Validator::make($data, [
            'name' => 'required|min:3|unique:contacto,name',
            'tcontacto_id' => 'required',
        ]);
        
        if ($validator->passes()) {
            $this->Mcontactos->add($data);
            return response()->json([
                'respuesta' => 1,
                'informacion' => ""
            ]);
        } else {
            return response()->json([
                'respuesta' => 2,
                'informacion' => $validator->errors()->all()
            ]);
        }
    }
    
    public function delete(Request $request): JsonResponse
    {
        $data = $request->all();
        $data["status"] = 2;
        $this->Mcontactos->delete($data);
        
        return response()->json(['success' => true]);
    }

    public function getPisos(): JsonResponse
    {
        return response()->json($this->Mpisos->get());
    }
    
    public function getZonas(): JsonResponse
    {
        return response()->json($this->Mzonas->get());
    }
    
    public function getCentros(): JsonResponse
    {
        return response()->json($this->Mcentros->get());
    }
    
    public function getProveedoresMantenimiento(): JsonResponse
    {
        return response()->json($this->Mcontactos->getProveedoresMantenimiento());
    }
}

