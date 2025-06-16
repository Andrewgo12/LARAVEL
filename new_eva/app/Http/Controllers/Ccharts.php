<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use App\Models\Mordenes;
use App\Models\Mcorrectivos_generales;
use App\Models\Mplanes;
use App\Models\Mpreventivos;
use App\Models\Mcbiomedicas;
use App\Models\Mcriesgos;
use App\Models\Mequipos;
use App\Models\Mestadoequipos;

class CchartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Session::get('id')) {
                return redirect()->route('auth.login');
            }
            return $next($request);
        });
    }
    public function index()
    {
        return view('admin.charts');
    }
    /*----------------Pagina 1 Estados---------------------*/
    public function getGeneratedByDate(Request $request): JsonResponse
    {
        $mordenes = app(Mordenes::class);
        return response()->json($mordenes->getGeneratedByDate($request->all()));
    }

    public function getClosedByDate(Request $request): JsonResponse
    {
        $mordenes = app(Mordenes::class);
        return response()->json($mordenes->getClosedByDate($request->all()));
    }

    public function getByStatus(Request $request): JsonResponse
    {
        $mordenes = app(Mordenes::class);
        return response()->json($mordenes->getByStatus($request->all()));
    }
    /*----------------Pagina 1 Correctivos generales---------------------*/

    public function getCorrectivosGeneralesGeneratedByDate(Request $request): JsonResponse
    {
        $mcorrectivos_generales = app(Mcorrectivos_generales::class);
        return response()->json($mcorrectivos_generales->getCorrectivosGeneralesGeneratedByDate($request->all()));
    }

    public function getCorrectivosGeneralesClosedByDate(Request $request): JsonResponse
    {
        $mcorrectivos_generales = app(Mcorrectivos_generales::class);
        return response()->json($mcorrectivos_generales->getCorrectivosGeneralesClosedByDate($request->all()));
    }

    public function getCorrectivosGeneralesByStatus(Request $request): JsonResponse
    {
        $mcorrectivos_generales = app(Mcorrectivos_generales::class);
        return response()->json($mcorrectivos_generales->getCorrectivosGeneralesByStatus($request->all()));
    }
    /*----------------Pagina 1 Tickets---------------------*/

    public function getTicketsIndicador(Request $request): JsonResponse
    {
        $mordenes = app(Mordenes::class);
        return response()->json($mordenes->getTicketsIndicador($request->all()));
    }

    public function getCorrectivosGeneralesIndicador(Request $request): JsonResponse
    {
        $mcorrectivos_generales = app(Mcorrectivos_generales::class);
        return response()->json($mcorrectivos_generales->getCorrectivosGeneralesIndicador($request->all()));
    }

    /*-----------------Pagina 2--------------------*/

    public function getPreventivosProgramados(Request $request): JsonResponse
    {
        $mplanes = app(Mplanes::class);
        return response()->json($mplanes->getPreventivosProgramados($request->all()));
    }

    public function getPreventivosEjecutados(Request $request): JsonResponse
    {
        $mpreventivos = app(Mpreventivos::class);
        return response()->json($mpreventivos->getPreventivosEjecutados($request->all()));
    }

    public function getPreventivosIndicador(Request $request): JsonResponse
    {
        $mpreventivos = app(Mpreventivos::class);
        return response()->json($mpreventivos->getPreventivosIndicador($request->all()));
    }
    /*-----------------Pagina 3--------------------*/

    public function getDistributionCbiomedicaOnDevices(Request $request): JsonResponse
    {
        $mcbiomedicas = app(Mcbiomedicas::class);
        return response()->json($mcbiomedicas->getDistributionCbiomedicaOnDevices($request->all()));
    }

    public function getDistributionCriesgoOnDevices(Request $request): JsonResponse
    {
        $mcriesgos = app(Mcriesgos::class);
        return response()->json($mcriesgos->getDistributionCriesgoOnDevices($request->all()));
    }

    public function getDistributionEstadosByDevice(Request $request): JsonResponse
    {
        $mestadoequipos = app(Mestadoequipos::class);
        return response()->json($mestadoequipos->getDistributionEstadosByDevice($request->all()));
    }

    public function getEquiposAdquisiciones(Request $request): JsonResponse
    {
        $mequipos = app(Mequipos::class);
        return response()->json($mequipos->getEquiposAdquisiciones($request->all()));
    }

    public function getEquiposInstalaciones(Request $request): JsonResponse
    {
        $mequipos = app(Mequipos::class);
        return response()->json($mequipos->getEquiposInstalaciones($request->all()));
    }

    public function getEquipoInstalacionAdquisicionIndicador(Request $request): JsonResponse
    {
        $mequipos = app(Mequipos::class);
        return response()->json($mequipos->getEquipoInstalacionAdquisicionIndicador($request->all()));
    }
}
