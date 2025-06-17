<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Mplanes;
use App\Models\Mequipos;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

/**
 * Controlador de Planes de Mantenimiento - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de planes de mantenimiento:
 * - Listado y consulta de planes de mantenimiento
 * - Importación masiva desde archivos Excel
 * - Actualización de planes con control de cambios
 * - Exportación de cronogramas a Excel
 * - Gestión de responsables y años de vigencia
 * - Control de cambios y auditoría
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cplanes extends Controller
{
    protected Mplanes $mplanes;
    protected Mequipos $mequipos;

    /**
     * Constructor - Inicializar dependencias con tipado fuerte
     */
    public function __construct()
    {
        $this->mplanes = new Mplanes();
        $this->mequipos = new Mequipos();
    }

    /**
     * Mostrar listado principal de planes de mantenimiento
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Verificar autenticación
        if (!Session::has('login')) {
            return redirect('Cauth');
        }

        // Verificar permisos de acceso
        $acciones = Session::get('acciones', []);
        foreach ($acciones as $accion) {
            if ($accion->modulo == "planes mantenimiento") {
                if ($accion->leer != 1) {
                    return redirect('Home');
                }
            }
        }

        try {
            $data = $this->mplanes->getAll();
            $planes = [
                "planes" => $data,
            ];

            return view('layouts.header')
                ->nest('aside', 'layouts.aside')
                ->nest('content', 'mantenimientos.list', $planes)
                ->nest('modal_edit', 'mantenimientos.modal_edit')
                ->nest('modal_cambios', 'mantenimientos.modal_cambios')
                ->nest('footer', 'layouts.footer');

        } catch (\Exception $e) {
            return redirect('Home')->with('error', 'Error al cargar planes de mantenimiento: ' . $e->getMessage());
        }
    }

    /**
     * Obtener un plan de mantenimiento específico
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:planes_mantenimientos,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de plan de mantenimiento inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $plan = $this->mplanes->getOne($request->all());
            return response()->json($plan);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el plan de mantenimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener planes de mantenimiento para DataTable con paginación
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get_server_side(Request $request): JsonResponse
    {
        try {
            // Validar parámetros de DataTable
            $validator = Validator::make($request->all(), [
                'start' => 'required|integer|min:0',
                'length' => 'nullable|integer|min:1|max:1000',
                'draw' => 'required|integer|min:1',
                'search.value' => 'nullable|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parámetros de consulta inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $vector = $this->mplanes->get_server_side($request->all());
            $respuesta = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $vector['num_filas_limit'],
                'recordsFiltered' => $vector['num_filas'],
                'data' => $vector['datos']
            ];

            return response()->json($respuesta);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la consulta: ' . $e->getMessage(),
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ], 500);
        }
    }

    /**
     * Obtener años disponibles para planes de mantenimiento
     *
     * @return JsonResponse
     */
    public function getAnios(): JsonResponse
    {
        try {
            $anios = $this->mplanes->getAnios();
            return response()->json($anios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener años disponibles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importar planes de mantenimiento desde archivo Excel
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ImportFromExcel(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB max
                'anio_cronograma' => 'required|integer|min:2020|max:2050',
                'reemplazar' => 'required|in:si,no'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $file = $request->file('file');
            $anio = $request->input('anio_cronograma');
            $reemplazar = $request->input('reemplazar');

            // Verificar que el archivo sea válido
            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo subido no es válido'
                ], 400);
            }

            // Leer archivo Excel
            $excelReader = IOFactory::createReaderForFile($file->getPathname());
            $excelObj = $excelReader->load($file->getPathname());
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();

            // Validar que el archivo tenga datos
            if ($lastRow < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo Excel no contiene datos válidos'
                ], 400);
            }

            // Si se debe reemplazar, eliminar datos del año
            if ($reemplazar == "si") {
                $this->mplanes->deleteYear($anio);
            }

            $usuario_id = Session::get('id');
            $registrosProcesados = 0;
            $errores = [];

            // Procesar cada fila del Excel
            for ($i = 2; $i <= $lastRow; $i++) {
                try {
                    $equipo_id = $worksheet->getCell('A' . $i)->getValue();

                    // Validar que el equipo_id sea válido
                    if (empty($equipo_id) || !is_numeric($equipo_id)) {
                        $errores[] = "Fila $i: ID de equipo inválido";
                        continue;
                    }

                    // Eliminar plan anterior si existe
                    $this->mplanes->deleteAnterior([
                        "equipo_id" => $equipo_id,
                        "anio" => $anio
                    ]);

                    // Preparar datos para insertar
                    $vector_insertar = [
                        "equipo_id" => $equipo_id,
                        "anio" => $anio,
                        "mes1" => $worksheet->getCell('B' . $i)->getValue() ?? null,
                        "mes2" => $worksheet->getCell('C' . $i)->getValue() ?? null,
                        "mes3" => $worksheet->getCell('D' . $i)->getValue() ?? null,
                        "responsable" => $worksheet->getCell('E' . $i)->getValue() ?? '',
                        "frecuencia_id" => $worksheet->getCell('F' . $i)->getValue() ?? null,
                        "usuario_id" => $usuario_id,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];

                    $this->mplanes->add($vector_insertar);
                    $registrosProcesados++;

                } catch (\Exception $e) {
                    $errores[] = "Fila $i: " . $e->getMessage();
                }
            }

            // Actualizar estados automáticamente
            $this->mequipos->updateEstadomAutomatico();

            $response = [
                'success' => true,
                'message' => "Importación completada. $registrosProcesados registros procesados.",
                'registros_procesados' => $registrosProcesados
            ];

            if (!empty($errores)) {
                $response['errores'] = $errores;
                $response['message'] .= ' Con ' . count($errores) . ' errores.';
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar plan de mantenimiento con control de cambios
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:planes_mantenimientos,id',
                'mes1' => 'nullable|integer|min:1|max:12',
                'mes2' => 'nullable|integer|min:1|max:12',
                'mes3' => 'nullable|integer|min:1|max:12',
                'responsable' => 'nullable|string|max:255',
                'frecuencia_id' => 'nullable|integer|exists:frecuencias,id',
                'anio' => 'nullable|integer|min:2020|max:2050'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Obtener datos anteriores para control de cambios
            $planAnterior = $this->mplanes->getOne($request->all());

            if (empty($planAnterior)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan de mantenimiento no encontrado'
                ], 404);
            }

            $anterior = $planAnterior[0];
            $contador = 0;
            $cambios = [];

            // Detectar cambios en mes1
            if ($anterior->mes1 != $request->input('mes1')) {
                $contador++;
                $cambios[] = "mes 1: " . ($anterior->mes1 ?? 'null') . " → " . ($request->input('mes1') ?? 'null');
            }

            // Detectar cambios en mes2
            if ($anterior->mes2 != $request->input('mes2')) {
                $contador++;
                $cambios[] = "mes 2: " . ($anterior->mes2 ?? 'null') . " → " . ($request->input('mes2') ?? 'null');
            }

            // Detectar cambios en mes3
            if ($anterior->mes3 != $request->input('mes3')) {
                $contador++;
                $cambios[] = "mes 3: " . ($anterior->mes3 ?? 'null') . " → " . ($request->input('mes3') ?? 'null');
            }

            // Detectar cambios en responsable
            if ($anterior->responsable != $request->input('responsable')) {
                $contador++;
                $cambios[] = "Responsable: " . ($anterior->responsable ?? 'null') . " → " . ($request->input('responsable') ?? 'null');
            }

            // Registrar control de cambios si hay modificaciones
            if ($contador > 0) {
                $cambioTexto = "(" . implode("), (", $cambios) . ")";

                $this->mplanes->addControlCambio([
                    "planes_mantenimientos_id" => $anterior->id,
                    "cambio" => $cambioTexto,
                    "usuario_id" => Session::get('id'),
                    "fecha_cambio" => Carbon::now()
                ]);
            }

            // Actualizar el plan
            $datosActualizacion = $request->all();
            $datosActualizacion['updated_at'] = Carbon::now();

            $this->mplanes->update($datosActualizacion);

            return response()->json([
                'success' => true,
                'message' => 'Plan de mantenimiento actualizado exitosamente',
                'cambios_registrados' => $contador
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener historial de cambios de un plan de mantenimiento
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCambios(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'planes_mantenimientos_id' => 'required|integer|exists:planes_mantenimientos,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de plan de mantenimiento inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $cambios = $this->mplanes->getCambios($request->all());
            return response()->json($cambios);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener historial de cambios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exportar cronograma de mantenimiento a Excel
     *
     * @return StreamedResponse|JsonResponse
     */
    public function ExportarExcel()
    {
        try {
            $planes_mantenimientos = $this->mplanes->getAll();

            return new StreamedResponse(function() use ($planes_mantenimientos) {
                // Configurar encoding para caracteres especiales
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo '<table class="table table-bordered" border="1">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Fecha de creación del registro</th>';
                echo '<th>Usuario responsable</th>';
                echo '<th>Fecha de la última actualización</th>';
                echo '<th>Última edición realizada</th>';
                echo '<th>Responsable de la edición</th>';
                echo '<th>Equipo ID</th>';
                echo '<th>Nombre</th>';
                echo '<th>Marca</th>';
                echo '<th>Modelo</th>';
                echo '<th>Serie</th>';
                echo '<th>Código</th>';
                echo '<th>Servicio</th>';
                echo '<th>Área</th>';
                echo '<th>Sede</th>';
                echo '<th>Propiedad</th>';
                echo '<th>Año vigencia mantenimiento</th>';
                echo '<th>Frecuencia de mantenimiento</th>';
                echo '<th>Mes 1</th>';
                echo '<th>Mes 2</th>';
                echo '<th>Mes 3</th>';
                echo '<th>Responsable del mantenimiento</th>';
                echo '<th>Cantidad de preventivos realizados en el año</th>';
                echo '<th>Soporte primer visita</th>';
                echo '<th>Fecha primer visita</th>';
                echo '<th>Soporte segunda visita</th>';
                echo '<th>Fecha segunda visita</th>';
                echo '<th>Soporte tercer visita</th>';
                echo '<th>Fecha tercer visita</th>';
                echo '<th>Soporte cuarta visita</th>';
                echo '<th>Fecha cuarta visita</th>';
                echo '<th>Estado del equipo</th>';
                echo '<th>Estado del mantenimiento</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($planes_mantenimientos as $plan_mantenimiento) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->created_at ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->usuario ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->fecha_actualizacion ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->cambio ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->usuario_editor ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->equipo_id ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->name ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->marca ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->modelo ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . (!empty($plan_mantenimiento->serial) ? 'sn: ' . htmlspecialchars($plan_mantenimiento->serial, ENT_QUOTES, 'UTF-8') : '') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->code ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->servicio ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->area ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->sede ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->propiedad ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->anio ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->frecuencia ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->mes1 ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->mes2 ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->mes3 ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->responsable ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->realizados ?? '0', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars(($plan_mantenimiento->primer_visita ?? '') . ' - ' . ($plan_mantenimiento->proveedor_primer_visita ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->fecha_primer_visita ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars(($plan_mantenimiento->segunda_visita ?? '') . ' - ' . ($plan_mantenimiento->proveedor_segunda_visita ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->fecha_segunda_visita ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars(($plan_mantenimiento->tercer_visita ?? '') . ' - ' . ($plan_mantenimiento->proveedor_tercer_visita ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->fecha_tercer_visita ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars(($plan_mantenimiento->cuarta_visita ?? '') . ' - ' . ($plan_mantenimiento->proveedor_cuarta_visita ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->fecha_cuarta_visita ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->estadoequipo ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($plan_mantenimiento->estado_mantenimiento ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            }, 200, [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename=Cronograma_mantenimiento_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xls',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);

        } catch (\Exception $e) {
            // En caso de error, retornar respuesta JSON con error
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar cronograma: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener listado de responsables de mantenimiento
     *
     * @return JsonResponse
     */
    public function getListadoResponsables(): JsonResponse
    {
        try {
            $responsables = $this->mplanes->getListadoResponsables();
            return response()->json($responsables);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener listado de responsables: ' . $e->getMessage()
            ], 500);
        }
    }
}