<?php

namespace App\Http\Controllers\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Mpisos;
use Illuminate\Http\JsonResponse;

class PisosController extends Controller
{
    private $pisos;
    private Mpisos $Mpisos;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->Mpisos = new Mpisos();
    }
    
    public function index()
    {
        /* if (!session('login')) {
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
            ->nest('footer', 'layouts.footer'); */
    }
    
    public function ServiceGetAll(): JsonResponse
    {
        return response()->json($this->Mpisos->getAllPisos());
    }
}