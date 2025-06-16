<?php

namespace App\Http\Controllers\capacitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mcapacitaciones;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class Ccapacitaciones extends Controller
{
    private Mcapacitaciones $Mcapacitaciones;
    
    public function __construct()
    {
        $this->Mcapacitaciones = new Mcapacitaciones();
    }
    
    public function index(): View
    {
        if (!Session::has('login')) {
            return redirect('Cauth');
        }
        
        $acciones = Session::get('acciones');
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "capacitaciones") {
                if ($accion->leer != 1) {
                    return redirect('Forbidden');
                }
            }
        }
        
        $capacitaciones_realizadas = $this->Mcapacitaciones->getAll();
        $capacitaciones_archivo = $this->Mcapacitaciones->getCapacitacionesArchivo();
        $capacitaciones_equipo = $this->Mcapacitaciones->getCapacitacionesEquipo();
        $capacitaciones_mes = $this->Mcapacitaciones->getCapacitacionesMes();
        
        $vector_capacitaciones = [
            "capacitaciones_realizadas" => $capacitaciones_realizadas,
            "capacitaciones_archivo" => $capacitaciones_archivo,
            "capacitaciones_equipo" => $capacitaciones_equipo,
            "capacitaciones_mes" => $capacitaciones_mes
        ];
        
        return view('capacitaciones.list', $vector_capacitaciones)
            ->with('header', view('layouts.header'))
            ->with('aside', view('layouts.aside'))
            ->with('footer', view('layouts.footer'));
    }
}

