<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mcategorias;
use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
    private $permisos;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->permisos = app('backend_lib')->control();
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }
        
        $data = [
            'permisos' => $this->permisos
        ];
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'categorias.list', $data)
            ->nest('modal_add', 'categorias.modal_add')
            ->nest('modal_edit', 'categorias.modal_edit')
            ->nest('modal_show', 'categorias.modal_show')
            ->nest('footer', 'layouts.footer');
    }
    
    public function get()
    {
        return response()->json(app(Mcategorias::class)->get());
    }
    
    public function get_server_side(Request $request)
    {
        $vector = app(Mcategorias::class)->get_server_side($request->all());
        
        $respuesta = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $vector['num_filas_limit'],
            'recordsFiltered' => $vector['num_filas'],
            'data' => $vector['datos']
        ];
        
        return response()->json($respuesta);
    }
    
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:categorias,nombre',
            'descripcion' => 'required|unique:categorias,descripcion',
        ]);
        
        if (!$validator->fails()) {
            app(Mcategorias::class)->add($request->all());
            return response()->json(1);
        } else {
            $error = [
                'nombre' => $validator->errors()->first('nombre'),
                'descripcion' => $validator->errors()->first('descripcion'),
            ];
            
            return response()->json($error);
        }
    }
    
    public function update(Request $request)
    {
        $categoriaActual = app(Mcategorias::class)->getOne($request->input('id'));
        
        $rules = [
            'descripcion' => 'required',
        ];
        
        if ($request->input('nombre') == $categoriaActual->nombre) {
            $rules['nombre'] = 'required';
        } else {
            $rules['nombre'] = 'required|unique:categorias,nombre';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if (!$validator->fails()) {
            app(Mcategorias::class)->update($request->all());
            return response()->json(1);
        } else {
            $error = [
                'nombre' => $validator->errors()->first('nombre'),
                'descripcion' => $validator->errors()->first('descripcion')
            ];
            
            return response()->json($error);
        }
    }
    
    public function delete(Request $request)
    {
        $array = ['estado' => 0];
        app(Mcategorias::class)->delete($request->all(), $array);
        return response()->json(['success' => true]);
    }
    
    public function show(Request $request)
    {
        $result = app(Mcategorias::class)->getOne($request->input('id'));
        $param = [
            'categoria' => $result
        ];
        
        return view('categorias.detail', $param);
    }
}