<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mcontactos;
use App\Models\Mcentros;
use App\Models\Mpisos;
use App\Models\Mzonas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactosController extends Controller
{
    private $servicios;
    private Mcontactos $Mcontactos;
    private Mcentros $Mcentros;
    private Mpisos $Mpisos;
    private Mzonas $Mzonas;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->Mcontactos = new Mcontactos();
        $this->Mcentros = new Mcentros();
        $this->Mpisos = new Mpisos();
        $this->Mzonas = new Mzonas();
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }
        
        $acciones = session('acciones');
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "tickets propios") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'contactos.list')
            ->nest('footer', 'layouts.footer');
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
    
    public function getTcontactos(Request $request): JsonResponse
    {
        return response()->json($this->Mcontactos->getTcontactos($request->all()));
    }

    public function update(Request $request): JsonResponse
    {
        $servicio = $this->Mcontactos->getOne($request->all());
        
        $rules = [];
        if ($servicio->name == $request->name) {
            $rules['name'] = 'required|min:3';
        } else {
            $rules['name'] = 'required|min:3|unique:servicios,name';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $this->Mcontactos->update($request->all());
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
            'name' => 'required|min:3|unique:contacto,name',
            'tcontacto_id' => 'required'
        ]);

        if ($validator->passes()) {
            $this->Mcontactos->add($request->all());
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
        $this->Mcontactos->delete($request->all());
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
}