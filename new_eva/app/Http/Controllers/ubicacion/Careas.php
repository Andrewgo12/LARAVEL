<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mareas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreasController extends Controller
{
    private $servicios;
    private Mareas $Mareas;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->Mareas = new Mareas();
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }

        $acciones = session('acciones');
        session(['controlador' => request()->segment(2)]);

        foreach ($acciones as $accion) {
            if ($accion->modulo == "contactos") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }

        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'areas.list')
            ->nest('modal_add', 'areas.modal_add')
            ->nest('modal_edit', 'areas.modal_edit')
            ->nest('footer', 'layouts.footer');
    }

    // Refactoring
    public function serviceGetAll(): JsonResponse
    {
        return response()->json($this->Mareas->getAllAreas());
    }
    
    public function serviceGetOne($id): JsonResponse
    {
        return response()->json($this->Mareas->getOneArea($id));
    }
    
    public function serviceGetByService($id): JsonResponse
    {
        return response()->json($this->Mareas->getByService($id));
    }
    
    public function delete($id)
    {
        return $this->Mareas->delete(['id' => $id]);
    }

    public function getAll(): JsonResponse
    {
        return response()->json($this->Mareas->getAll());
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mareas->getOne($request->all()));
    }
    
    public function getAreaByservicio(Request $request): JsonResponse
    {
        return response()->json($this->Mareas->getAreaByservicio($request->all()));
    }
    
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|unique:areas,name'
        ]);

        if ($validator->passes()) {
            $result = $this->Mareas->add($request->all());
            return response()->json(['result' => $result]);
        } else {
            return response()->json(['error' => $validator->errors()->first()]);
        }
    }
    
    public function update(Request $request): JsonResponse
    {
        $area = $this->Mareas->getOne($request->all());
        
        $rules = [];
        if ($area->name == $request->name) {
            $rules['name'] = 'required|min:4';
        } else {
            $rules['name'] = 'required|min:4|unique:areas,name';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $this->Mareas->update($request->all());
            return response()->json([
                'caso' => 1
            ]);
        } else {
            return response()->json([
                'caso' => 2,
                'informacion_error' => $validator->errors()->first()
            ]);
        }
    }
}