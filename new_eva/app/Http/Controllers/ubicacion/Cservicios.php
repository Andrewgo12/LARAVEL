<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mservicios;
use App\Models\Mpisos;
use App\Models\Mzonas;
use App\Models\Mcentros;
use App\Services\BackendLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiciosController extends Controller
{
    private $servicios;
    private Mservicios $Mservicios;
    private Mpisos $Mpisos;
    private Mzonas $Mzonas;
    private Mcentros $Mcentros;
    private $permisos;
    
    public function __construct(BackendLibrary $backendLib)
    {
        $this->middleware('auth');
        $this->Mservicios = new Mservicios();
        $this->Mpisos = new Mpisos();
        $this->Mzonas = new Mzonas();
        $this->Mcentros = new Mcentros();
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
            if ($accion->modulo == "servicios") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'servicios.list')
            ->nest('modal_add', 'servicios.modal_add')
            ->nest('modal_edit', 'servicios.modal_edit')
            ->nest('footer', 'layouts.footer');
    }
    
    /* Refactoring */
    public function ServiceGetAll(): JsonResponse
    {
        return response()->json($this->Mservicios->getAllServices());
    }
    
    public function ServiceGetOne($id): JsonResponse
    {
        return response()->json($this->Mservicios->getOneService($id));
    }
    
    public function ServiceGetBySede($id): JsonResponse
    {
        return response()->json($this->Mservicios->getBySede($id));
    }
    
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|unique:servicios,name'
        ]);
        
        if ($validator->passes()) {
            if ($result = $this->Mservicios->add($request->all())) {
                return response()->json(['result' => $result]);
            }
        } else {
            return response()->json(['error' => $validator->errors()->first()]);
        }
    }
    
    public function delete($id)
    {
        return $this->Mservicios->delete(['id' => $id]);
    }
    
    public function get_datatable(): JsonResponse
    {
        return response()->json($this->Mservicios->get_datatable());
    }
    
    public function get(): JsonResponse
    {
        return response()->json($this->Mservicios->get());
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mservicios->getOne($request->all()));
    }
    
    public function getUbicacion(Request $request): JsonResponse
    {
        return response()->json($this->Mservicios->getUbicacion($request->all()));
    }
    
    public function update(Request $request): JsonResponse
    {
        $servicio = $this->Mservicios->getOne($request->all());
        
        $rules = [];
        if ($servicio->name == $request->name) {
            $rules['name'] = 'required|min:3';
        } else {
            $rules['name'] = 'required|min:3|unique:servicios,name';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->passes()) {
            $this->Mservicios->update($request->all());
            return response()->json([
                'respuesta' => 1
            ]);
        } else {
            return response()->json([
                'caso' => 2,
                'informacion_error' => $validator->errors()->first()
            ]);
        }
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
    
    public function getFromSede(Request $request): JsonResponse
    {
        return response()->json($this->Mservicios->getFromSede($request->all()));
    }
}