<?php

namespace App\Http\Controllers\ordenes_compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Controlador de Órdenes de Compra - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de órdenes de compra y soportes de adquisición:
 * - CRUD de órdenes de compra (órdenes, contratos, cruces de cuentas, comodatos)
 * - Gestión de archivos de soporte (PDF, documentos)
 * - Integración con API SECOP para consulta de procesos de contratación
 * - Asociación de equipos médicos con órdenes de compra
 * - Exportación de datos a Excel para reportes
 * - Clasificación por tipos de compra (orden, contrato, cruce, comodato)
 * - Consultas especializadas por estado y tipo
 *
 * Las órdenes de compra son documentos fundamentales que respaldan la adquisición
 * de equipos médicos, facilitando el control de inventario, trazabilidad y
 * cumplimiento de normativas de contratación pública.
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cordenes_compra extends Controller
{
    /**
     * Constructor - Configurar middleware de autenticación
     */
    public function __construct()
    {
        // Middleware de autenticación para proteger todas las rutas
        $this->middleware('auth');
    }
    
    /**
     * Consultar API SECOP para obtener procesos de contratación
     * Integra con la API de datos abiertos del gobierno para consultar
     * procesos de contratación del Hospital Universitario del Valle
     *
     * @return \Illuminate\View\View
     */
    public function consultar_secop()
    {
        try {
            $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?nombre_de_la_entidad=VALLE%20DEL%20CAUCA%20%20ESE%20HOSPITAL%20UNIVERSITARIO%20DEL%20VALLE%20EVARISTO%20GARC%C3%8DA&$limit=10000';

            // Usar Http facade de Laravel para mayor control
            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                $array = $response->json();
                $json = $response->body();

                return view("ordenes_compra.modal_api_detalle", [
                    "vector" => $array,
                    "content" => $json,
                    "success" => true,
                    "total_records" => count($array)
                ]);
            } else {
                return view("ordenes_compra.modal_api_detalle", [
                    "vector" => [],
                    "content" => '',
                    "success" => false,
                    "error" => 'Error al consultar la API SECOP'
                ]);
            }
        } catch (\Exception $e) {
            return view("ordenes_compra.modal_api_detalle", [
                "vector" => [],
                "content" => '',
                "success" => false,
                "error" => 'Error de conexión: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Mostrar vista principal de órdenes de compra
     * Configura el controlador actual en sesión y muestra la interfaz de gestión
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            // Verificar autenticación
            if (!Session::has('login')) {
                return redirect()->route('ci.login');
            }

            // Configurar controlador actual en sesión para navegación
            Session::put('controlador', request()->segment(2));

            // Obtener acciones del usuario desde la sesión
            $acciones = Session::get('acciones', []);

            // Verificar permisos de acceso al módulo de soportes compra
            foreach ($acciones as $accion) {
                if (is_object($accion) && isset($accion->modulo) && $accion->modulo == "soportes compra") {
                    if (isset($accion->leer) && $accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }

            // Obtener datos para la vista
            $data = [
                "ordenes_compra" => $this->getAllOrdenesCompraData(),
                "total_ordenes" => $this->getTotalOrdenesCompraCount(),
                "ordenes_activas" => $this->getActiveOrdenesCompraCount(),
                "tipos_compra" => $this->getTiposCompraData(),
                "acciones" => $acciones,
                "title" => "Gestión de Órdenes de Compra"
            ];

            return view('ordenes_compra.index', $data);

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al cargar órdenes de compra: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener todas las órdenes de compra
     * API endpoint que retorna la lista completa con información de tipos de compra
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $ordenes = $this->getAllOrdenesCompraData();
            return response()->json($ordenes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva orden de compra
     * Incluye validación de unicidad, manejo de archivos y campos requeridos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'orden' => 'required|min:4|max:255|unique:ordenes_compra,orden',
                'fecha' => 'required|date',
                'tipo_compra_id' => 'required|integer|exists:tipos_compra,id',
                'proveedor_id' => 'nullable|integer|exists:contacto,id',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
            ], [
                'orden.required' => 'El número de orden es requerido',
                'orden.min' => 'El número de orden debe tener al menos 4 caracteres',
                'orden.max' => 'El número de orden no puede exceder 255 caracteres',
                'orden.unique' => 'Ya existe una orden de compra con este número',
                'fecha.required' => 'La fecha es requerida',
                'fecha.date' => 'La fecha debe tener un formato válido',
                'tipo_compra_id.required' => 'El tipo de compra es requerido',
                'tipo_compra_id.exists' => 'El tipo de compra seleccionado no es válido',
                'proveedor_id.exists' => 'El proveedor seleccionado no es válido',
                'file.mimes' => 'Solo se permiten archivos PDF, DOC, DOCX, JPG, JPEG, PNG',
                'file.max' => 'El archivo no puede ser mayor a 10MB'
            ]);

            if (!$validator->fails()) {
                $data = $request->all();

                // Manejo de archivo de soporte
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                    $uploadPath = public_path('assets/upload_ordenes_compra');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $file->move($uploadPath, $filename);
                    $data['file'] = $filename;
                }

                $data['status'] = 1; // Estado activo por defecto
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();

                if ($this->addOrdenCompraData($data)) {
                    return response()->json([
                        "success" => true,
                        "caso" => 1,
                        "message" => "Orden de compra creada exitosamente"
                    ]);
                } else {
                    // Si falla la inserción, eliminar el archivo subido
                    if (isset($data['file'])) {
                        $filePath = public_path('assets/upload_ordenes_compra/' . $data['file']);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    return response()->json([
                        "success" => false,
                        "caso" => 2,
                        "informacion_error" => "Error al guardar en la base de datos"
                    ], 500);
                }
            } else {
                return response()->json([
                    "success" => false,
                    "caso" => 2,
                    "informacion_error" => $validator->errors()->first()
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "caso" => 2,
                "informacion_error" => "Error del sistema: " . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener una orden de compra específica por ID
     * Incluye validación de entrada y manejo de errores
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de orden de compra inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $orden = $this->getOneOrdenCompraData($request->all());

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de compra no encontrada'
                ], 404);
            }

            return response()->json($orden);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la orden de compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener órdenes de compra con número de equipos asociados
     * Incluye conteo de equipos vinculados a cada orden
     *
     * @return JsonResponse
     */
    public function getWithNumberDevices(): JsonResponse
    {
        try {
            $ordenes = $this->getWithNumberDevicesData();
            return response()->json($ordenes);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes con equipos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar una orden de compra existente
     * Incluye validación de unicidad, integración SECOP y manejo de archivos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar que el ID esté presente
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:ordenes_compra,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'caso' => 2,
                    'informacion_error' => 'ID de orden de compra inválido'
                ], 422);
            }

            $data = $request->all();

            // Integración con API SECOP si se proporciona secop_id
            if (isset($data['secop_id']) && ($data['secop_id'] != 0)) {
                try {
                    $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?$query=%20SELECT%20*%20WHERE%20uid=%27' . $data['secop_id'] . '%27';
                    $response = Http::timeout(15)->get($url);

                    if ($response->successful()) {
                        $array = $response->json();
                        if (!empty($array) && isset($array[0]['ruta_proceso_en_secop_i']['url'])) {
                            $data['url_secop'] = $array[0]['ruta_proceso_en_secop_i']['url'];
                        }
                    }
                } catch (\Exception $e) {
                    // Log error but continue with update
                    \Log::warning('Error al consultar SECOP: ' . $e->getMessage());
                }
            }

            $orden = $this->getOneOrdenCompraData($data);

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'caso' => 2,
                    'informacion_error' => 'Orden de compra no encontrada'
                ], 404);
            }

            // Configurar reglas de validación dinámicas
            $rules = [
                'fecha' => 'required|date',
                'tipo_compra_id' => 'required|integer|exists:tipos_compra,id',
                'proveedor_id' => 'nullable|integer|exists:contacto,id',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
            ];

            if ($orden->orden == $data['orden']) {
                $rules['orden'] = 'required|min:4|max:255';
            } else {
                $rules['orden'] = 'required|min:4|max:255|unique:ordenes_compra,orden';
            }

            $validator = Validator::make($data, $rules, [
                'orden.required' => 'El número de orden es requerido',
                'orden.min' => 'El número de orden debe tener al menos 4 caracteres',
                'orden.max' => 'El número de orden no puede exceder 255 caracteres',
                'orden.unique' => 'Ya existe una orden de compra con este número',
                'fecha.required' => 'La fecha es requerida',
                'fecha.date' => 'La fecha debe tener un formato válido',
                'tipo_compra_id.required' => 'El tipo de compra es requerido',
                'tipo_compra_id.exists' => 'El tipo de compra seleccionado no es válido',
                'proveedor_id.exists' => 'El proveedor seleccionado no es válido',
                'file.mimes' => 'Solo se permiten archivos PDF, DOC, DOCX, JPG, JPEG, PNG',
                'file.max' => 'El archivo no puede ser mayor a 10MB'
            ]);

            if (!$validator->fails()) {
                // Manejo de archivo de soporte
                if ($request->hasFile('file')) {
                    $file = $request->file('file');

                    // Eliminar archivo anterior si existe
                    if ($orden->file && file_exists(public_path('assets/upload_ordenes_compra/' . $orden->file))) {
                        unlink(public_path('assets/upload_ordenes_compra/' . $orden->file));
                    }

                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                    $uploadPath = public_path('assets/upload_ordenes_compra');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $file->move($uploadPath, $filename);
                    $data['file'] = $filename;
                }

                $data['updated_at'] = Carbon::now();

                if ($this->updateOrdenCompraData($data)) {
                    return response()->json([
                        "success" => true,
                        "caso" => 1,
                        "message" => "Orden de compra actualizada exitosamente"
                    ]);
                } else {
                    return response()->json([
                        "success" => false,
                        "caso" => 2,
                        "informacion_error" => "Error al actualizar en la base de datos"
                    ], 500);
                }
            } else {
                return response()->json([
                    "success" => false,
                    "caso" => 2,
                    "informacion_error" => $validator->errors()->first()
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "caso" => 2,
                "informacion_error" => "Error del sistema: " . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mostrar órdenes de compra activas
     * Vista de consulta para órdenes de compra con status activo
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        try {
            $ordenes_compra_activas = $this->getActiveOrdenesCompraData();
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => $ordenes_compra_activas,
                "tipo" => "activas",
                "title" => "Órdenes de Compra Activas"
            ]);
        } catch (\Exception $e) {
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => [],
                "error" => "Error al cargar órdenes activas: " . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar solo órdenes de compra (tipo_compra_id = 1)
     * Vista filtrada para documentos tipo "orden de compra"
     *
     * @return \Illuminate\View\View
     */
    public function show_ordenes_compra()
    {
        try {
            $ordenes = $this->getOrdenesCompraData();
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => $ordenes,
                "tipo" => "ordenes",
                "title" => "Órdenes de Compra"
            ]);
        } catch (\Exception $e) {
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => [],
                "error" => "Error al cargar órdenes de compra: " . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar contratos (tipo_compra_id = 2)
     * Vista filtrada para documentos tipo "contrato"
     *
     * @return \Illuminate\View\View
     */
    public function show_contratos()
    {
        try {
            $contratos = $this->getContratosData();
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => $contratos,
                "tipo" => "contratos",
                "title" => "Contratos"
            ]);
        } catch (\Exception $e) {
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => [],
                "error" => "Error al cargar contratos: " . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar cruces de cuentas (tipo_compra_id = 3)
     * Vista filtrada para documentos tipo "cruce de cuentas"
     *
     * @return \Illuminate\View\View
     */
    public function show_cruces_cuentas()
    {
        try {
            $cruces = $this->getCrucesCuentasData();
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => $cruces,
                "tipo" => "cruces",
                "title" => "Cruces de Cuentas"
            ]);
        } catch (\Exception $e) {
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => [],
                "error" => "Error al cargar cruces de cuentas: " . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar comodatos (tipo_compra_id = 4)
     * Vista filtrada para documentos tipo "comodato"
     *
     * @return \Illuminate\View\View
     */
    public function show_comodatos()
    {
        try {
            $comodatos = $this->getComodatosData();
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => $comodatos,
                "tipo" => "comodatos",
                "title" => "Comodatos"
            ]);
        } catch (\Exception $e) {
            return view("ordenes_compra.detalle_consulta", [
                "ordenes_compra" => [],
                "error" => "Error al cargar comodatos: " . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Exportar equipos de una orden de compra específica a Excel
     * Genera un archivo Excel con los equipos asociados a una orden de compra
     *
     * @param int $orden_compra_id
     * @return \Illuminate\Http\Response
     */
    public function ExportarExcel($orden_compra_id)
    {
        try {
            $equipos = $this->getEquiposEnOrdenCompraData(["orden_compra_id" => $orden_compra_id]);
            $orden_compra = $this->getOneOrdenCompraData(["id" => $orden_compra_id]);

            if (!$orden_compra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de compra no encontrada'
                ], 404);
            }

            $filename = 'SoporteCompra_' . $orden_compra->orden . '_' . date('Y-m-d') . '.xls';

            $headers = [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename=' . $filename,
                'Cache-Control' => 'max-age=0'
            ];

            $callback = function() use ($equipos, $orden_compra) {
                $file = fopen('php://output', 'w');

                // Escribir BOM para UTF-8
                fwrite($file, "\xEF\xBB\xBF");

                // Información de la orden
                fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
                fwrite($file, '<strong>Soporte de adquisición:</strong> ' . htmlspecialchars($orden_compra->orden) . '<br>');
                fwrite($file, '<strong>Fecha:</strong> ' . htmlspecialchars($orden_compra->fecha) . '<br><br>');

                // Tabla de equipos
                fwrite($file, '<table border="1">');
                fwrite($file, '<thead>');
                fwrite($file, '<tr>');
                fwrite($file, '<th>ID</th>');
                fwrite($file, '<th>Nombre</th>');
                fwrite($file, '<th>Código</th>');
                fwrite($file, '<th>Serie</th>');
                fwrite($file, '<th>Marca</th>');
                fwrite($file, '<th>Modelo</th>');
                fwrite($file, '<th>Servicio de instalación</th>');
                fwrite($file, '<th>Área de instalación</th>');
                fwrite($file, '<th>Fecha de instalación</th>');
                fwrite($file, '</tr>');
                fwrite($file, '</thead>');
                fwrite($file, '<tbody>');

                foreach ($equipos as $equipo) {
                    fwrite($file, '<tr>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->id ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->name ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->code ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->serial ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->marca ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->modelo ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->servicio ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->area ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($equipo->fecha_instalacion ?? '') . '</td>');
                    fwrite($file, '</tr>');
                }

                fwrite($file, '</tbody>');
                fwrite($file, '</table>');

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exportar todas las órdenes de compra con estadísticas a Excel
     * Genera un archivo Excel con resumen de todas las órdenes y equipos asociados
     *
     * @return \Illuminate\Http\Response
     */
    public function ExportExcelAll()
    {
        try {
            $ordenes_compra = $this->getWithNumberDevicesData();

            $filename = 'Adquisiciones_' . date('Y-m-d') . '.xls';

            $headers = [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename=' . $filename,
                'Cache-Control' => 'max-age=0'
            ];

            $callback = function() use ($ordenes_compra) {
                $file = fopen('php://output', 'w');

                // Escribir BOM para UTF-8
                fwrite($file, "\xEF\xBB\xBF");

                fwrite($file, '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
                fwrite($file, '<h2>Reporte de Adquisiciones - ' . date('Y-m-d') . '</h2>');
                fwrite($file, '<table border="1">');
                fwrite($file, '<thead>');
                fwrite($file, '<tr>');
                fwrite($file, '<th>Orden</th>');
                fwrite($file, '<th>Fecha</th>');
                fwrite($file, '<th>Tipo de Compra</th>');
                fwrite($file, '<th>Proveedor</th>');
                fwrite($file, '<th>Cantidad Equipos Asociados en EVA</th>');
                fwrite($file, '</tr>');
                fwrite($file, '</thead>');
                fwrite($file, '<tbody>');

                foreach ($ordenes_compra as $orden_compra) {
                    fwrite($file, '<tr>');
                    fwrite($file, '<td>' . htmlspecialchars($orden_compra->orden ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($orden_compra->fecha ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($orden_compra->tipo_compra ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($orden_compra->proveedor ?? '') . '</td>');
                    fwrite($file, '<td>' . htmlspecialchars($orden_compra->cuenta ?? '0') . '</td>');
                    fwrite($file, '</tr>');
                }

                fwrite($file, '</tbody>');
                fwrite($file, '</table>');

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de órdenes de compra
     * Proporciona información estadística sobre las órdenes de compra
     *
     * @return JsonResponse
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = [
                'total_ordenes' => $this->getTotalOrdenesCompraCount(),
                'ordenes_activas' => $this->getActiveOrdenesCompraCount(),
                'ordenes_por_tipo' => $this->getOrdenesPorTipoData(),
                'equipos_asociados' => $this->getTotalEquiposAsociadosCount(),
                'ordenes_con_archivo' => $this->getOrdenesConArchivoCount()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Estadísticas obtenidas exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    // Private methods for database operations (replacing model calls)

    /**
     * Obtener todas las órdenes de compra con información de tipos
     * Reemplaza el método getAll del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAllOrdenesCompraData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('tipos_compra', 'tipos_compra.id', '=', 'ordenes_compra.tipo_compra_id')
            ->select('ordenes_compra.*', 'tipos_compra.tipo_compra as tipo_compra')
            ->orderBy('ordenes_compra.fecha', 'desc')
            ->get();
    }

    /**
     * Obtener una orden de compra específica por ID
     * Reemplaza el método getOne del modelo CodeIgniter
     *
     * @param array $param
     * @return object|null
     */
    private function getOneOrdenCompraData($param)
    {
        return DB::table('ordenes_compra')
            ->where('id', $param['id'])
            ->first();
    }

    /**
     * Crear una nueva orden de compra
     * Reemplaza el método add del modelo CodeIgniter
     *
     * @param array $param
     * @return bool
     */
    private function addOrdenCompraData($param)
    {
        return DB::table('ordenes_compra')->insert($param);
    }

    /**
     * Actualizar una orden de compra existente
     * Reemplaza el método update del modelo CodeIgniter
     *
     * @param array $param
     * @return int
     */
    private function updateOrdenCompraData($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return DB::table('ordenes_compra')
            ->where('id', $id)
            ->update($param);
    }

    /**
     * Obtener órdenes de compra activas con información de proveedores
     * Reemplaza el método getActive del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getActiveOrdenesCompraData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('contacto', 'contacto.id', '=', 'ordenes_compra.proveedor_id')
            ->select('ordenes_compra.*', 'contacto.name as proveedor')
            ->where('ordenes_compra.status', 1)
            ->orderBy('orden', 'asc')
            ->get();
    }

    /**
     * Obtener solo órdenes de compra (tipo_compra_id = 1)
     * Reemplaza el método getOrdenesCompra del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getOrdenesCompraData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('contacto', 'contacto.id', '=', 'ordenes_compra.proveedor_id')
            ->select('ordenes_compra.*', 'contacto.name as proveedor')
            ->where('ordenes_compra.status', 1)
            ->where('ordenes_compra.tipo_compra_id', 1)
            ->orderBy('orden', 'asc')
            ->get();
    }

    /**
     * Obtener contratos (tipo_compra_id = 2)
     * Reemplaza el método getContratos del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getContratosData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('contacto', 'contacto.id', '=', 'ordenes_compra.proveedor_id')
            ->select('ordenes_compra.*', 'contacto.name as proveedor')
            ->where('ordenes_compra.tipo_compra_id', 2)
            ->orderBy('orden', 'asc')
            ->get();
    }

    /**
     * Obtener cruces de cuentas (tipo_compra_id = 3)
     * Reemplaza el método getCrucesCuentas del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCrucesCuentasData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('contacto', 'contacto.id', '=', 'ordenes_compra.proveedor_id')
            ->select('ordenes_compra.*', 'contacto.name as proveedor')
            ->where('ordenes_compra.tipo_compra_id', 3)
            ->orderBy('orden', 'asc')
            ->get();
    }

    /**
     * Obtener comodatos (tipo_compra_id = 4)
     * Reemplaza el método getComodatos del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getComodatosData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('contacto', 'contacto.id', '=', 'ordenes_compra.proveedor_id')
            ->select('ordenes_compra.*', 'contacto.name as proveedor')
            ->where('ordenes_compra.tipo_compra_id', 4)
            ->orderBy('orden', 'asc')
            ->get();
    }

    /**
     * Obtener órdenes de compra con número de equipos asociados
     * Reemplaza el método getWithNumberDevices del modelo CodeIgniter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getWithNumberDevicesData()
    {
        return DB::select("
            SELECT
                ordenes_compra.*,
                contacto.name as proveedor,
                (
                    SELECT COUNT(*)
                    FROM equipos
                    WHERE equipos.orden_compra_id = ordenes_compra.id
                ) as cuenta,
                tipos_compra.tipo_compra as tipo_compra
            FROM ordenes_compra
            LEFT JOIN equipos on equipos.orden_compra_id = ordenes_compra.id
            LEFT JOIN tipos_compra on tipos_compra.id = ordenes_compra.tipo_compra_id
            LEFT JOIN contacto on contacto.id = ordenes_compra.proveedor_id
            WHERE contacto.name IS NOT NULL
            GROUP BY ordenes_compra.orden
            ORDER BY ordenes_compra.fecha desc
        ");
    }

    /**
     * Obtener equipos asociados a una orden de compra específica
     * Reemplaza el método getEquiposEnOrdenCompra del modelo Mequipos
     *
     * @param array $param
     * @return \Illuminate\Support\Collection
     */
    private function getEquiposEnOrdenCompraData($param)
    {
        return DB::table('equipos')
            ->leftJoin('servicios', 'equipos.servicio_id', '=', 'servicios.id')
            ->leftJoin('areas', 'equipos.area_id', '=', 'areas.id')
            ->select('equipos.*', 'servicios.name as servicio', 'areas.name as area')
            ->where('orden_compra_id', $param['orden_compra_id'])
            ->get();
    }

    /**
     * Obtener todos los tipos de compra
     *
     * @return \Illuminate\Support\Collection
     */
    private function getTiposCompraData()
    {
        return DB::table('tipos_compra')
            ->orderBy('tipo_compra', 'asc')
            ->get();
    }

    /**
     * Contar total de órdenes de compra
     *
     * @return int
     */
    private function getTotalOrdenesCompraCount()
    {
        return DB::table('ordenes_compra')->count();
    }

    /**
     * Contar órdenes de compra activas
     *
     * @return int
     */
    private function getActiveOrdenesCompraCount()
    {
        return DB::table('ordenes_compra')
            ->where('status', 1)
            ->count();
    }

    /**
     * Obtener órdenes agrupadas por tipo
     *
     * @return \Illuminate\Support\Collection
     */
    private function getOrdenesPorTipoData()
    {
        return DB::table('ordenes_compra')
            ->leftJoin('tipos_compra', 'tipos_compra.id', '=', 'ordenes_compra.tipo_compra_id')
            ->select('tipos_compra.tipo_compra as tipo', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('tipos_compra.id', 'tipos_compra.tipo_compra')
            ->orderBy('cantidad', 'desc')
            ->get();
    }

    /**
     * Contar total de equipos asociados a órdenes de compra
     *
     * @return int
     */
    private function getTotalEquiposAsociadosCount()
    {
        return DB::table('equipos')
            ->whereNotNull('orden_compra_id')
            ->count();
    }

    /**
     * Contar órdenes que tienen archivo adjunto
     *
     * @return int
     */
    private function getOrdenesConArchivoCount()
    {
        return DB::table('ordenes_compra')
            ->whereNotNull('file')
            ->where('file', '!=', '')
            ->count();
    }
}