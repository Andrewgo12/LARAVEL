<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mclientes;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ClientesController extends Controller
{
    private $permisos;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->permisos = app('backend_lib')->control();
    }
    
    public function index(): View
    {
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'clientes.list')
            ->nest('modal_add', 'clientes.modal_add')
            ->nest('modal_edit', 'clientes.modal_edit')
            ->nest('modal_show', 'clientes.modal_show')
            ->nest('footer', 'layouts.footer');
    }
    
    public function get_server_side(Request $request): JsonResponse
    {
        $vector = app(Mclientes::class)->get_server_side($request->all());
        
        $respuesta = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $vector['num_filas_limit'],
            'recordsFiltered' => $vector['num_filas'],
            'data' => $vector['datos']
        ];
        
        return response()->json($respuesta);
    }
    
    public function add(Request $request): JsonResponse
    {
        app(Mclientes::class)->add($request->all());
        return response()->json(['success' => true]);
    }
    
    public function update(Request $request): JsonResponse
    {
        app(Mclientes::class)->update($request->all());
        return response()->json(['success' => true]);
    }
    
    public function delete(Request $request): JsonResponse
    {
        $array = ['estado' => 0];
        app(Mclientes::class)->delete($request->all(), $array);
        return response()->json(['success' => true]);
    }
    
    public function show(Request $request): View
    {
        $result = app(Mclientes::class)->getOne($request->input('id'));
        $param = [
            'cliente' => $result
        ];
        
        return view('clientes.detail', $param);
    }
}