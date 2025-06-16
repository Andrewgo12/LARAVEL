<?php

namespace App\Http\Controllers\repuesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Mrepuestos;
use App\Models\Mequipo_repuestos;
use App\Models\Mmovimientos;

class CrepuestosController extends Controller
{
    private $repuestos;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (!Session::get('login')) {
            return redirect()->route('auth.login');
        }

        $acciones = Session::get("acciones");
        Session::put('controlador', 'repuestos');

        if ($acciones) {
            foreach ($acciones as $accion) {
                if ($accion->modulo == "repuestos") {
                    if ($accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }
        }

        $mequipo_repuestos = app(Mequipo_repuestos::class);

        $repuestos_instalados = $mequipo_repuestos->getAll();
        $repuestos_pendientes_por_correctivos = $mequipo_repuestos->getPendientesPorCorrectivos();
        $repuestos_pendientes_por_preventivos = $mequipo_repuestos->getPendientesPorPreventivos();
        $repuestos_pendientes_por_observaciones = $mequipo_repuestos->getPendientesPorObservaciones();
        $consolidado_anio_mes = $mequipo_repuestos->getCOnsolidadoAnioMes();
        $consolidado_anio_mes_general = $mequipo_repuestos->getCOnsolidadoAnioMesGeneral();

        $vector_repuestos = [
            "repuestos_instalados" => $repuestos_instalados,
            "repuestos_pendientes_por_correctivos" => $repuestos_pendientes_por_correctivos,
            "repuestos_pendientes_por_preventivos" => $repuestos_pendientes_por_preventivos,
            "repuestos_pendientes_por_observaciones" => $repuestos_pendientes_por_observaciones,
            "consolidado_anio_mes" => $consolidado_anio_mes,
            "consolidado_anio_mes_general" => $consolidado_anio_mes_general
        ];

        return view("repuestos.list", $vector_repuestos);
    }

    public function excel_repuestos_pendientes(Request $request)
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);

        $repuestos_pendientes_por_correctivos = $mequipo_repuestos->getPendientesPorCorrectivos();
        $repuestos_pendientes_por_preventivos = $mequipo_repuestos->getPendientesPorPreventivos();
        $repuestos_pendientes_por_observaciones = $mequipo_repuestos->getPendientesPorObservaciones();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=RepuestosPendientes.xls',
        ];

        // Generar HTML directamente
        $content = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $content .= '<table border="1">';
        $content .= '<thead><tr>';
        $content .= '<th>Origen</th><th>Id</th><th>Equipo</th><th>A.Fijo</th><th>Sn</th>';
        $content .= '<th>Marca</th><th>Modelo</th><th>Sede</th><th>Servicio</th>';
        $content .= '<th>Codigo cierre del preventivo - correctivo</th><th>Repuesto</th>';
        $content .= '<th>Fecha del reporte</th><th>Proveedor</th><th>Zona</th>';
        $content .= '</tr></thead><tbody>';

        // Correctivos
        if (!empty($repuestos_pendientes_por_correctivos)) {
            foreach ($repuestos_pendientes_por_correctivos as $repuesto) {
                $content .= '<tr>';
                $content .= '<td>Correctivos</td>';
                $content .= '<td>' . $repuesto->id . '</td>';
                $content .= '<td>' . $repuesto->equipo . '</td>';
                $content .= '<td>' . $repuesto->codigo . '</td>';
                $content .= '<td>sn: ' . $repuesto->serie . '</td>';
                $content .= '<td>' . $repuesto->marca . '</td>';
                $content .= '<td>' . $repuesto->modelo . '</td>';
                $content .= '<td>' . $repuesto->sede . '</td>';
                $content .= '<td>' . $repuesto->servicio . '</td>';
                $content .= '<td>' . $repuesto->codigo_cierre_correctivo . '</td>';
                $content .= '<td>' . $repuesto->repuesto_por_correctivo . '</td>';
                $content .= '<td>' . $repuesto->fecha_mantenimiento . '</td>';
                $content .= '<td>' . $repuesto->proveedor_mantenimiento . '</td>';
                $content .= '<td>' . $repuesto->zona . '</td>';
                $content .= '</tr>';
            }
        }

        // Preventivos
        if (!empty($repuestos_pendientes_por_preventivos)) {
            foreach ($repuestos_pendientes_por_preventivos as $repuesto) {
                $content .= '<tr>';
                $content .= '<td>Preventivos</td>';
                $content .= '<td>' . $repuesto->id . '</td>';
                $content .= '<td>' . $repuesto->equipo . '</td>';
                $content .= '<td>' . $repuesto->codigo . '</td>';
                $content .= '<td>sn: ' . $repuesto->serie . '</td>';
                $content .= '<td>' . $repuesto->marca . '</td>';
                $content .= '<td>' . $repuesto->modelo . '</td>';
                $content .= '<td>' . $repuesto->sede . '</td>';
                $content .= '<td>' . $repuesto->servicio . '</td>';
                $content .= '<td>' . $repuesto->codigo_cierre_preventivo . '</td>';
                $content .= '<td>' . $repuesto->repuesto_por_preventivo . '</td>';
                $content .= '<td>' . $repuesto->fecha_mantenimiento . '</td>';
                $content .= '<td>' . $repuesto->proveedor_mantenimiento . '</td>';
                $content .= '<td>' . $repuesto->zona . '</td>';
                $content .= '</tr>';
            }
        }

        // Observaciones
        if (!empty($repuestos_pendientes_por_observaciones)) {
            foreach ($repuestos_pendientes_por_observaciones as $repuesto) {
                $content .= '<tr>';
                $content .= '<td>Observaciones</td>';
                $content .= '<td>' . $repuesto->id . '</td>';
                $content .= '<td>' . $repuesto->equipo . '</td>';
                $content .= '<td>' . $repuesto->codigo . '</td>';
                $content .= '<td>sn: ' . $repuesto->serie . '</td>';
                $content .= '<td>' . $repuesto->marca . '</td>';
                $content .= '<td>' . $repuesto->modelo . '</td>';
                $content .= '<td>' . $repuesto->sede . '</td>';
                $content .= '<td>' . $repuesto->servicio . '</td>';
                $content .= '<td></td>';
                $content .= '<td>' . $repuesto->repuesto_por_observacion . '</td>';
                $content .= '<td>' . $repuesto->created_at . '</td>';
                $content .= '<td>' . $repuesto->proveedor_mantenimiento . '</td>';
                $content .= '<td>' . $repuesto->zona . '</td>';
                $content .= '</tr>';
            }
        }

        $content .= '</tbody></table>';

        return Response::make($content, 200, $headers);
    }


    public function excel_repuestos_instalados()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        $repuestos_instalados = $mequipo_repuestos->getAll();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=ConsolidadoRepuestosInstalados.xls',
        ];

        // Generar HTML directamente
        $content = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $content .= '<table border="1">';
        $content .= '<thead><tr style="font-weight: bold;">';
        $content .= '<th>Fecha</th><th>Repuesto</th><th>Cantidad entregada</th><th>Id equipo</th>';
        $content .= '<th>Nombre equipo</th><th>Serie equipo</th><th>Codigo equipo</th><th>Marca</th>';
        $content .= '<th>Modelo</th><th>Servicio</th><th>Observación</th><th>Precio</th>';
        $content .= '<th>Precio total</th><th>Codigo del repuesto</th>';
        $content .= '</tr></thead><tbody>';

        foreach ($repuestos_instalados as $repuesto_instalado) {
            $content .= '<tr>';
            $content .= '<td>' . $repuesto_instalado->fecha . '</td>';
            $content .= '<td>' . $repuesto_instalado->repuesto . '</td>';
            $content .= '<td>' . $repuesto_instalado->cantidad_entregada . '</td>';
            $content .= '<td>' . $repuesto_instalado->equipo_id . '</td>';
            $content .= '<td>' . $repuesto_instalado->equipo_nombre . '</td>';
            $content .= '<td>sn:' . $repuesto_instalado->equipo_serie . '</td>';
            $content .= '<td>' . $repuesto_instalado->equipo_codigo . '</td>';
            $content .= '<td>' . $repuesto_instalado->marca . '</td>';
            $content .= '<td>' . $repuesto_instalado->modelo . '</td>';
            $content .= '<td>' . $repuesto_instalado->servicio . '</td>';
            $content .= '<td>' . $repuesto_instalado->observacion . '</td>';
            $content .= '<td>' . $repuesto_instalado->precio . '</td>';
            $content .= '<td>' . $repuesto_instalado->precio_global . '</td>';
            $content .= '<td>' . $repuesto_instalado->codigo_repuesto . '</td>';
            $content .= '</tr>';
        }

        $content .= '</tbody></table>';

        return Response::make($content, 200, $headers);
    }
    public function excel_repuestos_pendientes_por_correctivos()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        $repuestos_pendientes_por_correctivos = $mequipo_repuestos->getPendientesPorCorrectivos();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=ConsolidadoRepuestosPendientesEnCorrectivos.xls',
        ];

        // Generar HTML directamente
        $content = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $content .= '<table border="1">';
        $content .= '<thead><tr style="font-weight: bold;">';
        $content .= '<th>Id equipo</th><th>Equipo</th><th>Codigo equipo</th><th>Serie equipo</th>';
        $content .= '<th>Marca</th><th>Modelo</th><th>Servicio</th><th>Codigo Reporte</th>';
        $content .= '<th>Repuesto pendiente</th><th>Fecha del Reporte</th>';
        $content .= '</tr></thead><tbody>';

        foreach ($repuestos_pendientes_por_correctivos as $repuesto) {
            $content .= '<tr>';
            $content .= '<td>' . $repuesto->id . '</td>';
            $content .= '<td>' . $repuesto->equipo . '</td>';
            $content .= '<td>' . $repuesto->codigo . '</td>';
            $content .= '<td>sn:' . $repuesto->serie . '</td>';
            $content .= '<td>' . $repuesto->marca . '</td>';
            $content .= '<td>' . $repuesto->modelo . '</td>';
            $content .= '<td>' . $repuesto->servicio . '</td>';
            $content .= '<td>' . $repuesto->codigo_cierre_correctivo . '</td>';
            $content .= '<td>' . $repuesto->repuesto_por_correctivo . '</td>';
            $content .= '<td>' . $repuesto->fecha_mantenimiento . '</td>';
            $content .= '</tr>';
        }

        $content .= '</tbody></table>';

        return Response::make($content, 200, $headers);
    }
    public function excel_repuestos_pendientes_por_preventivos()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        $repuestos_pendientes_por_preventivos = $mequipo_repuestos->getPendientesPorPreventivos();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=ConsolidadoRepuestosPendientesEnPreventivos.xls',
        ];

        // Generar HTML directamente
        $content = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $content .= '<table border="1">';
        $content .= '<thead><tr style="font-weight: bold;">';
        $content .= '<th>Id equipo</th><th>Equipo</th><th>Codigo equipo</th><th>Serie equipo</th>';
        $content .= '<th>Marca</th><th>Modelo</th><th>Servicio</th><th>Codigo del preventivo</th>';
        $content .= '<th>Repuesto pendiente</th><th>Fecha del preventivo</th>';
        $content .= '</tr></thead><tbody>';

        foreach ($repuestos_pendientes_por_preventivos as $repuesto) {
            $content .= '<tr>';
            $content .= '<td>' . $repuesto->id . '</td>';
            $content .= '<td>' . $repuesto->equipo . '</td>';
            $content .= '<td>' . $repuesto->codigo . '</td>';
            $content .= '<td>sn:' . $repuesto->serie . '</td>';
            $content .= '<td>' . $repuesto->marca . '</td>';
            $content .= '<td>' . $repuesto->modelo . '</td>';
            $content .= '<td>' . $repuesto->servicio . '</td>';
            $content .= '<td>' . $repuesto->codigo_cierre_preventivo . '</td>';
            $content .= '<td>' . $repuesto->repuesto_por_preventivo . '</td>';
            $content .= '<td>' . $repuesto->fecha_mantenimiento . '</td>';
            $content .= '</tr>';
        }

        $content .= '</tbody></table>';

        return Response::make($content, 200, $headers);
    }
    public function get_datatable(): JsonResponse
    {
        $mrepuestos = app(Mrepuestos::class);
        return response()->json($mrepuestos->get_datatable());
    }

    public function get(): JsonResponse
    {
        $mrepuestos = app(Mrepuestos::class);
        return response()->json($mrepuestos->get());
    }

    public function getOne(Request $request): JsonResponse
    {
        $mrepuestos = app(Mrepuestos::class);
        return response()->json($mrepuestos->getOne($request->all()));
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        $mrepuestos = app(Mrepuestos::class);

        $repuesto = $mrepuestos->getOne($data);

        if ($repuesto->name == $data["name"]) {
            $rules = ['name' => 'required|min:3'];
        } else {
            $rules = ['name' => 'required|min:3|unique:repuestos,name'];
        }

        $validator = Validator::make($data, $rules, [
            'name.required' => 'El nombre del repuesto es requerido',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'name.unique' => 'Ya existe un repuesto con este nombre'
        ]);

        if ($validator->passes()) {
            $mrepuestos->update($data);
            $vector = [
                'respuesta' => 1,
                'informacion' => "Repuesto actualizado correctamente"
            ];
        } else {
            $vector = [
                'respuesta' => 2,
                'informacion' => $validator->errors()->all()
            ];
        }

        return response()->json($vector);
    }
    public function add_repuesto_from_equipos(Request $request): JsonResponse
    {
        $data = $request->all();

        $rules = [
            'name' => 'required|unique:repuestos,name',
            'code' => 'required|min:3|unique:repuestos,code'
        ];

        $validator = Validator::make($data, $rules, [
            'name.required' => 'El nombre del repuesto es requerido',
            'name.unique' => 'Ya existe un repuesto con este nombre',
            'code.required' => 'El código del repuesto es requerido',
            'code.min' => 'El código debe tener al menos 3 caracteres',
            'code.unique' => 'Ya existe un repuesto con este código'
        ]);

        if ($validator->passes()) {
            $mrepuestos = app(Mrepuestos::class);
            $mrepuestos->add($data);

            $vector = [
                "respuesta" => 1,
                "informacion" => "Repuesto agregado correctamente"
            ];
        } else {
            $vector = [
                "respuesta" => 2,
                "informacion" => $validator->errors()->all()
            ];
        }

        return response()->json($vector);
    }
    public function add(Request $request): JsonResponse
    {
        $data = $request->all();

        if (isset($data["id"])) {
            unset($data["id"]);
        }

        $rules = [
            'name' => 'required|min:3|unique:repuestos,name',
            'code' => 'required|min:3|unique:repuestos,code'
        ];

        $validator = Validator::make($data, $rules, [
            'name.required' => 'El nombre del repuesto es requerido',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'name.unique' => 'Ya existe un repuesto con este nombre',
            'code.required' => 'El código del repuesto es requerido',
            'code.min' => 'El código debe tener al menos 3 caracteres',
            'code.unique' => 'Ya existe un repuesto con este código'
        ]);

        if ($validator->passes()) {
            $mrepuestos = app(Mrepuestos::class);
            $mrepuestos->add($data);

            $vector = [
                'respuesta' => 1,
                'informacion' => "Repuesto agregado correctamente"
            ];
        } else {
            $vector = [
                'respuesta' => 2,
                'informacion' => $validator->errors()->all()
            ];
        }

        return response()->json($vector);
    }
    public function delete(Request $request): JsonResponse
    {
        $data = $request->all();
        $data["status"] = 2;

        $mrepuestos = app(Mrepuestos::class);
        $mrepuestos->delete($data);

        return response()->json(['success' => true, 'message' => 'Repuesto eliminado correctamente']);
    }
    public function sumar(Request $request): JsonResponse
    {
        $data = $request->all();
        $razon = $data["razon"];
        $repuesto_id = $data["id"];
        unset($data["razon"]);
        $sumado = $data["cantidad"];
        $data["cantidad"] = $data["stock"] + $data["cantidad"];
        unset($data["stock"]);

        $mrepuestos = app(Mrepuestos::class);
        $mmovimientos = app(Mmovimientos::class);

        $vector = ['id' => $data["id"]];
        $mrepuestos->sumar($data);
        $repuesto = $mrepuestos->getOne($vector);

        $movimiento = [
            "repuesto_id" => $repuesto_id,
            "accion" => "sumar",
            "description" => "El usuario " . Session::get('nombre') . " agrego " . $sumado . " unidades del repuesto, el saldo resultante es de: " . $repuesto->cantidad,
            "cantidad" => $sumado,
            "usuario_id" => Session::get("id"),
            "razon" => $razon
        ];
        $mmovimientos->add($movimiento);

        return response()->json($repuesto->cantidad);
    }
    public function restar(Request $request): JsonResponse
    {
        $data = $request->all();
        $razon = $data["razon"];
        $repuesto_id = $data["id"];
        unset($data["razon"]);
        $restado = $data["cantidad"];
        $data["cantidad"] = $data["stock"] - $data["cantidad"];
        unset($data["stock"]);

        $mrepuestos = app(Mrepuestos::class);
        $mmovimientos = app(Mmovimientos::class);

        $vector = ['id' => $data["id"]];
        $mrepuestos->restar($data);
        $repuesto = $mrepuestos->getOne($vector);

        $movimiento = [
            "repuesto_id" => $repuesto_id,
            "accion" => "restar",
            "description" => "El usuario " . Session::get('nombre') . " retiro " . $restado . " unidades del repuesto, el saldo resultante es de: " . $repuesto->cantidad,
            "cantidad" => $restado,
            "usuario_id" => Session::get("id"),
            "razon" => $razon
        ];
        $mmovimientos->add($movimiento);

        return response()->json($repuesto->cantidad);
    }
    public function show(Request $request)
    {
        $mmovimientos = app(Mmovimientos::class);
        $movimientos = $mmovimientos->get($request->all());

        $vector = [
            'movimientos' => $movimientos
        ];

        return view("repuestos.detail", $vector);
    }

    public function getDistribucionRepuestos(): JsonResponse
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        return response()->json($mequipo_repuestos->getDistribucionRepuestos());
    }

    public function show_repuestos_instalados()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        return view("repuestos.modal_detail_repuestos_instalados", [
            "repuestos_instalados" => $mequipo_repuestos->getAll()
        ]);
    }

    public function show_repuestos_pendientes()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);

        $repuestos_pendientes_por_correctivos = $mequipo_repuestos->getPendientesPorCorrectivos();
        $repuestos_pendientes_por_preventivos = $mequipo_repuestos->getPendientesPorPreventivos();
        $repuestos_pendientes_por_observaciones = $mequipo_repuestos->getPendientesPorObservaciones();

        $vector_repuestos = [
            "repuestos_pendientes_por_correctivos" => $repuestos_pendientes_por_correctivos,
            "repuestos_pendientes_por_preventivos" => $repuestos_pendientes_por_preventivos,
            "repuestos_pendientes_por_observaciones" => $repuestos_pendientes_por_observaciones
        ];

        return view("repuestos.modal_detail_repuestos_pendientes", $vector_repuestos);
    }

    public function show_resumen_por_repuesto()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        return view("repuestos.modal_detail_resumen_por_repuesto", [
            "consolidado_anio_mes" => $mequipo_repuestos->getCOnsolidadoAnioMes()
        ]);
    }

    public function show_resumen_general()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        return view("repuestos.modal_detail_resumen_general", [
            "consolidado_anio_mes_general" => $mequipo_repuestos->getCOnsolidadoAnioMesGeneral()
        ]);
    }

    public function show_resumen_inversion_repuestos_equipo()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        return view("repuestos.modal_detail_resumen_inversion_repuestos_equipo", [
            "inversion_repuestos_equipo" => $mequipo_repuestos->getInversionRepuestosequipo()
        ]);
    }

    public function show_resumen_inversion_repuestos_servicio()
    {
        $mequipo_repuestos = app(Mequipo_repuestos::class);
        return view("repuestos.modal_detail_resumen_inversion_repuestos_servicio", [
            "inversion_repuestos_servicio" => $mequipo_repuestos->getInversionRepuestosServicio()
        ]);
    }
}