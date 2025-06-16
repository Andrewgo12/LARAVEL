<?php

namespace App\Http\Controllers\reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mequipos;
use App\Models\Mordenes;
use App\Models\Mpreventivos;
use Illuminate\Http\JsonResponse;

class ReportesController extends Controller
{
    private $permisos;
    private Mequipos $Mequipos;
    private Mordenes $Mordenes;
    private Mpreventivos $Mpreventivos;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->Mequipos = new Mequipos();
        $this->Mordenes = new Mordenes();
        $this->Mpreventivos = new Mpreventivos();
        // $this->permisos = app('backend_lib')->control();
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }

        $acciones = session('acciones');

        foreach ($acciones as $accion) {
            if ($accion->modulo == "reportes") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }

        $data = [
            'permisos' => $this->permisos,
            'total' => $this->Mequipos->getTotal(),
            'incluidoPreventivo' => $this->Mequipos->getPlan(),
            'obtenidosComodato' => $this->Mequipos->getComodato(),
            'planNoComodato' => $this->Mequipos->getPlanNoComodato(),
            'estadoOrdenes' => $this->Mordenes->getPorEstado(),
            'PromedioTiempoTotal' => $this->Mordenes->getPromedioTotal(),
            'MenorTiempoTotal' => $this->Mordenes->getMenorTotal(),
            'MayorTiempoTotal' => $this->Mordenes->getMayorTotal(),
            'cbiomedicas' => $this->Mequipos->getCbiomedicas(),
            'criesgos' => $this->Mequipos->getCriesgos()
        ];
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'reportes.list', $data)
            ->nest('footer', 'layouts.footer');
    }
    
    public function getByFechaCierre(Request $request): JsonResponse
    {
        return response()->json($this->Mordenes->getByFechaCierre($request->all()));
    }
    
    public function getByFechaCreacion(Request $request): JsonResponse
    {
        return response()->json($this->Mordenes->getByFechaCreacion($request->all()));
    }
    
    public function get_anios(): JsonResponse
    {
        // funcion creada para obtener los años en que se han realizado preventivos
        return response()->json($this->Mpreventivos->get_anios());
    }
    
    public function get_meses(Request $request): JsonResponse
    {
        // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
        return response()->json($this->Mpreventivos->get_meses($request->all()));
    }
    
    public function preventivos_por_anio(Request $request): JsonResponse
    {
        // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
        return response()->json($this->Mpreventivos->get_preventivos_por_anio($request->all()));
    }
    
    public function preventivos_por_anio_general(Request $request): JsonResponse
    {
        // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
        return response()->json($this->Mpreventivos->get_preventivos_por_anio_general($request->all()));
    }
    
    public function preventivos_por_anio_mes(Request $request): JsonResponse
    {
        return response()->json($this->Mpreventivos->get_preventivos_por_anio_mes($request->all()));
    }
    
    public function preventivos_por_anio_mes_general(Request $request): JsonResponse
    {
        return response()->json($this->Mpreventivos->get_preventivos_por_anio_mes_general($request->all()));
    }
}