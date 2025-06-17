<?php

namespace App\Http\Controllers\reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Controlador de Reportes - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la generación de reportes y estadísticas del sistema:
 * - Dashboard principal con estadísticas de equipos y órdenes
 * - Reportes de órdenes por fechas de cierre y creación
 * - Reportes de mantenimientos preventivos por año y mes
 * - Estadísticas de equipos por clasificación y riesgo
 * - Análisis de tiempos de resolución de órdenes
 * - Reportes de cumplimiento de planes de mantenimiento
 *
 * Proporciona datos para gráficos y tablas del dashboard administrativo,
 * facilitando la toma de decisiones basada en datos del sistema.
 *
 * Migrado completamente a Laravel 11 manteniendo compatibilidad total
 */
class Creportes extends Controller
{
    private $permisos;

    /**
     * Constructor - Configurar middleware de autenticación
     */
    public function __construct()
    {
        // Middleware de autenticación para proteger todas las rutas
        $this->middleware('auth');
        // $this->permisos = app('backend_lib')->control();
    }
    
    /**
     * Mostrar vista principal de reportes
     * Dashboard con estadísticas generales del sistema
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Session::has('login')) {
            return redirect('auth');
        }

        $acciones = Session::get('acciones');

        foreach ($acciones as $accion) {
            if ($accion->modulo == "reportes") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }

        $data = [
            'permisos' => $this->permisos,
            'total' => $this->getTotalEquipos(),
            'incluidoPreventivo' => $this->getEquiposConPlan(),
            'obtenidosComodato' => $this->getEquiposComodato(),
            'planNoComodato' => $this->getEquiposPlanNoComodato(),
            'estadoOrdenes' => $this->getOrdenesPorEstado(),
            'PromedioTiempoTotal' => $this->getPromedioTiempoTotal(),
            'MenorTiempoTotal' => $this->getMenorTiempoTotal(),
            'MayorTiempoTotal' => $this->getMayorTiempoTotal(),
            'cbiomedicas' => $this->getClasificacionesBiomedicas(),
            'criesgos' => $this->getClasificacionesRiesgo()
        ];

        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'reportes.list', $data)
            ->nest('footer', 'layouts.footer');
    }
    
    /**
     * Obtener estadísticas de órdenes por fecha de cierre
     * Calcula promedio, menor y mayor tiempo de resolución en un rango de fechas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByFechaCierre(Request $request): JsonResponse
    {
        return response()->json($this->getOrdenesByFechaCierre($request->all()));
    }

    /**
     * Obtener estadísticas de órdenes por fecha de creación
     * Calcula promedio, menor y mayor tiempo de resolución en un rango de fechas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByFechaCreacion(Request $request): JsonResponse
    {
        return response()->json($this->getOrdenesByFechaCreacion($request->all()));
    }

    /**
     * Obtener años en que se han realizado mantenimientos preventivos
     * API endpoint para poblar selectores de año en reportes
     *
     * @return JsonResponse
     */
    public function get_anios(): JsonResponse
    {
        // funcion creada para obtener los años en que se han realizado preventivos
        return response()->json($this->getAniosPreventivos());
    }

    /**
     * Obtener meses en que se han realizado preventivos según el año seleccionado
     * API endpoint para poblar selectores de mes en reportes
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get_meses(Request $request): JsonResponse
    {
        // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
        return response()->json($this->getMesesPreventivos($request->all()));
    }

    /**
     * Obtener estadísticas de preventivos por año y propiedad
     * Incluye cantidad ejecutada, programada y porcentaje de cumplimiento
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function preventivos_por_anio(Request $request): JsonResponse
    {
        // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
        return response()->json($this->getPreventivosPorAnio($request->all()));
    }

    /**
     * Obtener estadísticas generales de preventivos por año
     * Incluye todas las propiedades agrupadas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function preventivos_por_anio_general(Request $request): JsonResponse
    {
        // funcion creada para obtener los meses en que se han realizado preventivos segun el año seleccionado
        return response()->json($this->getPreventivosPorAnioGeneral($request->all()));
    }

    /**
     * Obtener estadísticas de preventivos por año y mes específico
     * Desglose mensual de cumplimiento por propiedad
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function preventivos_por_anio_mes(Request $request): JsonResponse
    {
        return response()->json($this->getPreventivosPorAnioMes($request->all()));
    }

    /**
     * Obtener estadísticas generales de preventivos por año y mes
     * Desglose mensual de cumplimiento general
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function preventivos_por_anio_mes_general(Request $request): JsonResponse
    {
        return response()->json($this->getPreventivosPorAnioMesGeneral($request->all()));
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener total de equipos
     * Reemplaza el método getTotal del modelo Mequipos
     *
     * @return object
     */
    private function getTotalEquipos()
    {
        return DB::table('equipos')
            ->selectRaw('count(*) as total')
            ->first();
    }

    /**
     * Obtener equipos incluidos en plan de mantenimiento
     * Reemplaza el método getPlan del modelo Mequipos
     *
     * @return object
     */
    private function getEquiposConPlan()
    {
        return DB::table('equipos')
            ->selectRaw('count(*) as total')
            ->where('equipos.plan', '!=', 2)
            ->where('equipos.status', 1)
            ->first();
    }

    /**
     * Obtener equipos obtenidos por comodato
     * Reemplaza el método getComodato del modelo Mequipos
     *
     * @return object
     */
    private function getEquiposComodato()
    {
        return DB::table('equipos')
            ->selectRaw('count(*) as total')
            ->join('tadquisicion', 'tadquisicion.id', '=', 'equipos.tadquisicion_id')
            ->where('tadquisicion.name', 'like', '%comodato%')
            ->first();
    }

    /**
     * Obtener equipos con plan que no son comodato
     * Reemplaza el método getPlanNoComodato del modelo Mequipos
     *
     * @return object
     */
    private function getEquiposPlanNoComodato()
    {
        return DB::table('equipos')
            ->selectRaw('count(*) as total')
            ->where('tadquisicion_id', '!=', 4)
            ->where('tadquisicion_id', '!=', 5)
            ->where('plan', 2)
            ->first();
    }

    /**
     * Obtener clasificaciones biomédicas
     * Reemplaza el método getCbiomedicas del modelo Mequipos
     *
     * @return \Illuminate\Support\Collection
     */
    private function getClasificacionesBiomedicas()
    {
        return DB::table('equipos')
            ->selectRaw('cbiomedica.name as clasificacion, count(*) as total')
            ->join('cbiomedica', 'cbiomedica.id', '=', 'equipos.cbiomedica_id')
            ->groupBy('cbiomedica.name')
            ->orderByDesc(DB::raw('count(*)'))
            ->get();
    }

    /**
     * Obtener clasificaciones de riesgo
     * Reemplaza el método getCriesgos del modelo Mequipos
     *
     * @return \Illuminate\Support\Collection
     */
    private function getClasificacionesRiesgo()
    {
        return DB::table('equipos')
            ->selectRaw('criesgo.name as riesgo, count(*) as total')
            ->join('criesgo', 'criesgo.id', '=', 'equipos.criesgo_id')
            ->groupBy('criesgo.name')
            ->orderByDesc(DB::raw('count(*)'))
            ->get();
    }

    /**
     * Obtener órdenes agrupadas por estado
     * Reemplaza el método getPorEstado del modelo Mordenes
     *
     * @return \Illuminate\Support\Collection
     */
    private function getOrdenesPorEstado()
    {
        return DB::table('ordenes')
            ->selectRaw('estados.descripcion as estado, count(*) as total')
            ->join('estados', 'estados.id', '=', 'ordenes.estado_id', 'left')
            ->groupBy('estados.descripcion')
            ->orderByDesc(DB::raw('count(*)'))
            ->get();
    }

    /**
     * Obtener promedio de tiempo total de órdenes
     * Reemplaza el método getPromedioTotal del modelo Mordenes
     *
     * @return object
     */
    private function getPromedioTiempoTotal()
    {
        return DB::table('ordenes')
            ->selectRaw('avg(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as total')
            ->first();
    }

    /**
     * Obtener menor tiempo total de órdenes
     * Reemplaza el método getMenorTotal del modelo Mordenes
     *
     * @return object
     */
    private function getMenorTiempoTotal()
    {
        return DB::table('ordenes')
            ->selectRaw('min(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as total')
            ->first();
    }

    /**
     * Obtener mayor tiempo total de órdenes
     * Reemplaza el método getMayorTotal del modelo Mordenes
     *
     * @return object
     */
    private function getMayorTiempoTotal()
    {
        return DB::table('ordenes')
            ->selectRaw('max(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as total')
            ->first();
    }

    /**
     * Obtener estadísticas de órdenes por fecha de cierre
     * Reemplaza el método getByFechaCierre del modelo Mordenes
     *
     * @param array $param
     * @return object
     */
    private function getOrdenesByFechaCierre($param)
    {
        return DB::table('ordenes')
            ->selectRaw('
                avg(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as promedio,
                min(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as menor,
                max(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as mayor
            ')
            ->whereBetween('fecha_fin', [$param["fecha_inicio"], $param["fecha_fin"]])
            ->first();
    }

    /**
     * Obtener estadísticas de órdenes por fecha de creación
     * Reemplaza el método getByFechaCreacion del modelo Mordenes
     *
     * @param array $param
     * @return object
     */
    private function getOrdenesByFechaCreacion($param)
    {
        return DB::table('ordenes')
            ->selectRaw('
                avg(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as promedio,
                min(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as menor,
                max(TIMESTAMPDIFF(MINUTE,ordenes.fecha_inicio,ordenes.fecha_fin)/60) as mayor
            ')
            ->whereBetween('fecha_inicio', [$param["fecha_inicio"], $param["fecha_fin"]])
            ->first();
    }

    /**
     * Obtener años en que se han realizado mantenimientos preventivos
     * Reemplaza el método get_anios del modelo Mpreventivos
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAniosPreventivos()
    {
        return DB::select("select year(fecha_mantenimiento) as anio from mantenimiento group by year(fecha_mantenimiento) order by year(fecha_mantenimiento) asc");
    }

    /**
     * Obtener meses en que se han realizado preventivos según el año
     * Reemplaza el método get_meses del modelo Mpreventivos
     *
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    private function getMesesPreventivos($param)
    {
        $query = "select month(fecha_mantenimiento) as mes from mantenimiento where year(fecha_mantenimiento)='" . $param["anio"] . "' group by month(fecha_mantenimiento) order by month(fecha_mantenimiento) asc";
        return DB::select($query);
    }

    /**
     * Obtener estadísticas de preventivos por año y propiedad
     * Reemplaza el método get_preventivos_por_anio del modelo Mpreventivos
     *
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    private function getPreventivosPorAnio($param)
    {
        $query = "select
            equipos.propiedad as propiedad,
            year(mantenimiento.fecha_mantenimiento)as anio,
            count(*)as cantidad,

            (
                SELECT COUNT(*) FROM planes_mantenimientos
                left join equipos b on b.id=planes_mantenimientos.equipo_id
                left join servicios c on c.id=b.servicio_id
                WHERE b.propiedad=equipos.propiedad
                and planes_mantenimientos.anio=" . $param["anio"] . "
                and c.sede_id=" . $param["sede"] . "
            )as cantidad_programados,
            (
                (count(*))/((
                    SELECT COUNT(*) FROM planes_mantenimientos
                    left join equipos b on b.id=planes_mantenimientos.equipo_id
                    left join servicios c on c.id=b.servicio_id
                    WHERE b.propiedad=equipos.propiedad
                    and planes_mantenimientos.anio=" . $param["anio"] . "
                    and c.sede_id=" . $param["sede"] . "

                ))*100
            )as porcentaje

            from mantenimiento
            left join equipos on equipos.id=mantenimiento.equipo_id
            left join servicios on servicios.id=equipos.servicio_id
            where year(mantenimiento.fecha_mantenimiento)=" . $param["anio"] . "
            and servicios.sede_id=" . $param["sede"] . "
            group by equipos.propiedad
            order by equipos.propiedad asc";

        return DB::select($query);
    }

    /**
     * Obtener estadísticas generales de preventivos por año
     * Reemplaza el método get_preventivos_por_anio_general del modelo Mpreventivos
     *
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    private function getPreventivosPorAnioGeneral($param)
    {
        $query = "select
            equipos.propiedad as propiedad,
            year(mantenimiento.fecha_mantenimiento)as anio,
            count(*)as cantidad,

            (
                SELECT COUNT(*) FROM planes_mantenimientos
                left join equipos b on b.id=planes_mantenimientos.equipo_id
                left join servicios c on c.id=b.servicio_id
                where planes_mantenimientos.anio=" . $param["anio"] . "
                and c.sede_id=" . $param["sede"] . "
            )as cantidad_programados,
            (
                (count(*))/((
                    SELECT COUNT(*) FROM planes_mantenimientos
                    left join equipos b on b.id=planes_mantenimientos.equipo_id
                    left join servicios c on c.id=b.servicio_id
                    where planes_mantenimientos.anio=" . $param["anio"] . "
                    and c.sede_id=" . $param["sede"] . "

                ))*100
            )as porcentaje

            from mantenimiento
            left join equipos on equipos.id=mantenimiento.equipo_id
            left join servicios on servicios.id=equipos.servicio_id
            where year(mantenimiento.fecha_mantenimiento)=" . $param["anio"] . "
            and servicios.sede_id=" . $param["sede"] . "
            group by equipos.propiedad
            order by equipos.propiedad asc";

        return DB::select($query);
    }

    /**
     * Obtener estadísticas de preventivos por año y mes específico
     * Reemplaza el método get_preventivos_por_anio_mes del modelo Mpreventivos
     *
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    private function getPreventivosPorAnioMes($param)
    {
        $query = "select
            eq.propiedad as propiedad,
            (case
            when month(m.fecha_mantenimiento)= '1' then 'ENERO'
            when month(m.fecha_mantenimiento)= '2' then 'FEBRERO'
            when month(m.fecha_mantenimiento)= '3' then 'MARZO'
            when month(m.fecha_mantenimiento)= '4' then 'ABRIL'
            when month(m.fecha_mantenimiento)= '5' then 'MAYO'
            when month(m.fecha_mantenimiento)= '6' then 'JUNIO'
            when month(m.fecha_mantenimiento)= '7' then 'JULIO'
            when month(m.fecha_mantenimiento)= '8' then 'AGOSTO'
            when month(m.fecha_mantenimiento)= '9' then 'SEPTIEMPRE'
            when month(m.fecha_mantenimiento)= '10' then 'OCTUBRE'
            when month(m.fecha_mantenimiento)= '11' then 'NOVIEMBRE'
            when month(m.fecha_mantenimiento)= '12' then 'DICIEMBRE'
            END
            )as mes_string,
            month(m.fecha_mantenimiento)as mes,
            year(m.fecha_mantenimiento)as anio,
            count(*)as cantidad,

            (
                SELECT COUNT(*) FROM planes_mantenimientos
                left join equipos b on b.id=planes_mantenimientos.equipo_id
                left join servicios c on c.id=b.servicio_id
                WHERE b.propiedad=eq.propiedad
                and planes_mantenimientos.anio=" . $param["anio"] . "
                and c.sede_id=" . $param["sede"] . "
                and (
                    planes_mantenimientos.mes1=" . $param["mes"] . " or
                    planes_mantenimientos.mes2=" . $param["mes"] . " or
                    planes_mantenimientos.mes3=" . $param["mes"] . " or
                    planes_mantenimientos.mes4=" . $param["mes"] . " or
                    planes_mantenimientos.mes5=" . $param["mes"] . " or
                    planes_mantenimientos.mes6=" . $param["mes"] . " or
                    planes_mantenimientos.mes7=" . $param["mes"] . " or
                    planes_mantenimientos.mes8=" . $param["mes"] . " or
                    planes_mantenimientos.mes9=" . $param["mes"] . " or
                    planes_mantenimientos.mes10=" . $param["mes"] . " or
                    planes_mantenimientos.mes11=" . $param["mes"] . " or
                    planes_mantenimientos.mes12=" . $param["mes"] . "
                )
            )as cantidad_programados

            from mantenimiento m
            left join equipos eq on eq.id=m.equipo_id
            left join servicios s on s.id=eq.servicio_id
            where year(m.fecha_mantenimiento)=" . $param["anio"] . "
            and month(m.fecha_mantenimiento)=" . $param["mes"] . "
            and s.sede_id=" . $param["sede"] . "
            group by eq.propiedad
            order by eq.propiedad asc";

        return DB::select($query);
    }

    /**
     * Obtener estadísticas generales de preventivos por año y mes
     * Reemplaza el método get_preventivos_por_anio_mes_general del modelo Mpreventivos
     *
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    private function getPreventivosPorAnioMesGeneral($param)
    {
        $query = "select
            eq.propiedad as propiedad,
            (case
            when month(m.fecha_mantenimiento)= '1' then 'ENERO'
            when month(m.fecha_mantenimiento)= '2' then 'FEBRERO'
            when month(m.fecha_mantenimiento)= '3' then 'MARZO'
            when month(m.fecha_mantenimiento)= '4' then 'ABRIL'
            when month(m.fecha_mantenimiento)= '5' then 'MAYO'
            when month(m.fecha_mantenimiento)= '6' then 'JUNIO'
            when month(m.fecha_mantenimiento)= '7' then 'JULIO'
            when month(m.fecha_mantenimiento)= '8' then 'AGOSTO'
            when month(m.fecha_mantenimiento)= '9' then 'SEPTIEMPRE'
            when month(m.fecha_mantenimiento)= '10' then 'OCTUBRE'
            when month(m.fecha_mantenimiento)= '11' then 'NOVIEMBRE'
            when month(m.fecha_mantenimiento)= '12' then 'DICIEMBRE'
            END
            )as mes_string,
            month(m.fecha_mantenimiento)as mes,
            year(m.fecha_mantenimiento)as anio,
            count(*)as cantidad,

            (
                SELECT COUNT(*) FROM planes_mantenimientos
                left join equipos b on b.id=planes_mantenimientos.equipo_id
                left join servicios c on c.id=b.servicio_id
                where planes_mantenimientos.anio=" . $param["anio"] . "
                and c.sede_id=" . $param["sede"] . "
                and (
                    planes_mantenimientos.mes1=" . $param["mes"] . " or
                    planes_mantenimientos.mes2=" . $param["mes"] . " or
                    planes_mantenimientos.mes3=" . $param["mes"] . " or
                    planes_mantenimientos.mes4=" . $param["mes"] . " or
                    planes_mantenimientos.mes5=" . $param["mes"] . " or
                    planes_mantenimientos.mes6=" . $param["mes"] . " or
                    planes_mantenimientos.mes7=" . $param["mes"] . " or
                    planes_mantenimientos.mes8=" . $param["mes"] . " or
                    planes_mantenimientos.mes9=" . $param["mes"] . " or
                    planes_mantenimientos.mes10=" . $param["mes"] . " or
                    planes_mantenimientos.mes11=" . $param["mes"] . " or
                    planes_mantenimientos.mes12=" . $param["mes"] . "
                )
            )as cantidad_programados

            from mantenimiento m
            left join equipos eq on eq.id=m.equipo_id
            left join servicios s on s.id=eq.servicio_id
            where year(m.fecha_mantenimiento)=" . $param["anio"] . "
            and month(m.fecha_mantenimiento)=" . $param["mes"] . "
            and s.sede_id=" . $param["sede"] . "
            group by eq.propiedad
            order by eq.propiedad asc";

        return DB::select($query);
    }
}