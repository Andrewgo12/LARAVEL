<?php

namespace App\Http\Controllers\equipos;

use App\Http\Controllers\Controller;
use App\Models\Mestadoequipos;
use App\Models\Mtipos_estados;
use App\Services\BackendLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadoEquiposController extends Controller
{
    private $permisos;
    private Mestadoequipos $Mestadoequipos;
    private Mtipos_estados $Mtipos_estados;
    
    public function __construct(BackendLibrary $backendLib)
    {
        $this->middleware('auth');
        $this->Mestadoequipos = new Mestadoequipos();
        $this->Mtipos_estados = new Mtipos_estados();
        $this->permisos = $backendLib->control();
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }
        
        $acciones = session('acciones');
        session(['controlador' => request()->segment(2)]);
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "estado equipos") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }
        
        $view = view('layouts.header');
        
        if (session('rol_id') == 1) {
            $view->nest('aside', 'layouts.aside');
        } elseif (session('rol_id') == 2) {
            $view->nest('aside', 'layouts.admin_aside');
        } elseif (session('rol_id') == 3) {
            $view->nest('aside', 'layouts.advance_aside');
        } else {
            $view->nest('aside', 'layouts.basic_aside');
        }
        
        return $view->nest('content', 'estadoequipos.list')
                   ->nest('footer', 'layouts.footer');
    }
    
    public function get_datatable(): JsonResponse
    {
        return response()->json($this->Mestadoequipos->get_datatable());
    }
    
    public function get(): JsonResponse
    {
        return response()->json($this->Mestadoequipos->get());
    }
    
    public function get_usados(): JsonResponse
    {
        return response()->json($this->Mestadoequipos->get_usados());
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mestadoequipos->getOne($request->all()));
    }
    
    public function update(Request $request): JsonResponse
    {
        $estado = $this->Mestadoequipos->getOne($request->all());
        
        $rules = [];
        if ($estado->name == $request->name) {
            $rules['name'] = 'required|min:3';
        } else {
            $rules['name'] = 'required|min:3|unique:estadoequipos,name';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->passes()) {
            $this->Mestadoequipos->update($request->all());
            return response()->json([
                'respuesta' => 1,
                'informacion' => ""
            ]);
        } else {
            return response()->json([
                'respuesta' => 2,
                'informacion' => $validator->errors()->first()
            ]);
        }
    }
    
    public function add(Request $request): JsonResponse
    {
        if ($request->has('id')) {
            $request->request->remove('id');
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:estadoequipos,name'
        ]);
        
        if ($validator->passes()) {
            $this->Mestadoequipos->add($request->all());
            return response()->json([
                'respuesta' => 1,
                'informacion' => ""
            ]);
        } else {
            return response()->json([
                'respuesta' => 2,
                'informacion' => $validator->errors()->first()
            ]);
        }
    }
    
    public function delete(Request $request)
    {
        $request->merge(['status' => 2]);
        $this->Mestadoequipos->delete($request->all());
    }
    
    public function active(Request $request)
    {
        $request->merge(['status' => 1]);
        $this->Mestadoequipos->active($request->all());
    }
    
    public function getFuncionalidad(): JsonResponse
    {
        return response()->json($this->Mestadoequipos->getFuncionalidad());
    }
    
    public function getDisponibilidad(): JsonResponse
    {
        return response()->json($this->Mestadoequipos->getDisponibilidad());
    }
    
    public function getTipoEstado(): JsonResponse
    {
        return response()->json($this->Mtipos_estados->get());
    }
}