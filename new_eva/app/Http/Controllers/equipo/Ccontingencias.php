<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Mequipos;
use App\Models\Mcontingencias;
use App\Models\Mbajas;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

/**
 * Controlador de Contingencias - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de contingencias de equipos:
 * - Listado y consulta de contingencias
 * - Creación y edición de contingencias
 * - Manejo de archivos adjuntos
 * - Cierre de contingencias
 * - Exportación de datos
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Ccontingencias extends Controller
{
    protected Mequipos $mequipos;
    protected Mcontingencias $mcontingencias;
    protected Mbajas $mbajas;

    /**
     * Constructor - Inicializar dependencias con tipado fuerte
     */
    public function __construct()
    {
        $this->mequipos = new Mequipos();
        $this->mcontingencias = new Mcontingencias();
        $this->mbajas = new Mbajas();
    }
    
    /**
     * Mostrar listado principal de contingencias
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Verificar autenticación
        if (!Session::has('login')) {
            return redirect('Cauth');
        }

        // Configurar controlador actual en sesión
        Session::put('controlador', request()->segment(2));
        $acciones = Session::get('acciones');

        // Verificar permisos de lectura
        foreach ($acciones as $accion) {
            if ($accion->modulo == "contingencias") {
                if ($accion->leer != 1) {
                    return redirect('Home');
                }
            }
        }

        try {
            $data = [
                "contingencias" => $this->mcontingencias->getAll()
            ];

            return view('layouts.app')
                ->with('header', view('layouts.header'))
                ->with('aside', view('layouts.aside'))
                ->with('content', view('contingencias.list', $data))
                ->with('modal_add', view('contingencias.modal_add'))
                ->with('modal_edit', view('contingencias.modal_edit'))
                ->with('footer', view('layouts.footer'));

        } catch (\Exception $e) {
            return redirect('Home')->with('error', 'Error al cargar contingencias: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener contingencias con filtros
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        try {
            $contingencias = $this->mcontingencias->get($request->all());
            return response()->json($contingencias);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener contingencias: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Obtener todas las contingencias
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $contingencias = $this->mcontingencias->getAll();
            return response()->json($contingencias);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener todas las contingencias: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Obtener una contingencia específica
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            $contingencia = $this->mcontingencias->getOne($request->all());
            return response()->json($contingencia);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la contingencia: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Crear nueva contingencia
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'observacion' => 'required|string|max:1000',
                'fecha' => 'nullable|date',
                'equipo_id' => 'required|integer|exists:equipos,id',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            // Manejar archivo adjunto si existe
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                // Crear directorio si no existe
                $uploadPath = public_path('assets/upload_contingencias');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $data['file'] = $fileName;
            }

            // Agregar usuario actual
            $data['usuario_id'] = Session::get('id');
            $data['fecha'] = $data['fecha'] ?: Carbon::now()->format('Y-m-d');

            if ($this->mcontingencias->add($data)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Contingencia creada exitosamente'
                ]);
            } else {
                // Limpiar archivo si falló la inserción
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_contingencias/' . $data['file']));
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la contingencia'
                ], 500);
            }

        } catch (\Exception $e) {
            // Limpiar archivo en caso de error
            if (isset($data['file'])) {
                File::delete(public_path('assets/upload_contingencias/' . $data['file']));
            }

            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalle de contingencia (vista de bajas)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        try {
            $bajas = $this->mbajas->getAll();
            $data = [
                "bajas" => $bajas,
                "equipo_id" => $request->input('equipo_id')
            ];

            return view("bajas.detalle_consulta", $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el detalle: ' . $e->getMessage());
        }
    }

    /**
     * Cerrar contingencia
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function close(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:contingencias,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de contingencia inválido'
                ], 422);
            }

            $data = $request->all();
            $data["estado_id"] = 4; // Estado cerrado
            $data["fecha_cierre"] = Carbon::now()->format('Y-m-d');

            $this->mcontingencias->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Contingencia cerrada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la contingencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar contingencia existente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:contingencias,id',
                'observacion' => 'required|string|max:1000',
                'fecha' => 'nullable|date',
                'fecha_cierre' => 'nullable|date',
                'equipo_id' => 'required|integer|exists:equipos,id',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            // Manejar archivo adjunto si existe
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                // Crear directorio si no existe
                $uploadPath = public_path('assets/upload_contingencias');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $data['file'] = $fileName;
            }

            // Limpiar fechas vacías
            if (empty($data["fecha_cierre"])) {
                $data["fecha_cierre"] = null;
            }

            if (empty($data["fecha"])) {
                $data["fecha"] = null;
            }

            $this->mcontingencias->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Contingencia actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la contingencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar contingencia
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:contingencias,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de contingencia inválido'
                ], 422);
            }

            $vector = [
                "id" => $request->input('id')
            ];

            // Obtener información de la contingencia antes de eliminar
            $contingencia = $this->mcontingencias->getOne($vector);
            $file = $contingencia->file ?? null;

            // Eliminar contingencia
            if ($this->mcontingencias->delete($request->all())) {
                // Eliminar archivo asociado si existe
                if (!empty($file)) {
                    $filePath = public_path('assets/upload_contingencias/' . $file);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Contingencia eliminada exitosamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la contingencia'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Exportar contingencias a Excel
     *
     * @return StreamedResponse
     */
    public function exportar(): StreamedResponse
    {
        try {
            $contingencias = $this->mcontingencias->getAll();

            return new StreamedResponse(function() use ($contingencias) {
                // Configurar encoding para caracteres especiales
                echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                echo '<table border="1" class="table-hover table-bordered table-condensed">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Observaciones</th>';
                echo '<th>Fecha</th>';
                echo '<th>Fecha cierre</th>';
                echo '<th>Usuario quien la ingresa</th>';
                echo '<th>Nombre equipo</th>';
                echo '<th>Marca equipo</th>';
                echo '<th>Modelo equipo</th>';
                echo '<th>Código equipo</th>';
                echo '<th>Serie equipo</th>';
                echo '<th>Origen de la contingencia</th>';
                echo '<th>Estado</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($contingencias as $contingencia) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($contingencia->observacion ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->fecha ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->fecha_cierre ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->usuario ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->name ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->marca ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->modelo ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->codigo ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>';
                    if (!empty($contingencia->serial)) {
                        echo "sn: " . htmlspecialchars($contingencia->serial, ENT_QUOTES, 'UTF-8');
                    }
                    echo '</td>';
                    echo '<td>';
                    if (empty($contingencia->tipo)) {
                        echo "Otras contingencias";
                    } else {
                        echo htmlspecialchars($contingencia->tipo, ENT_QUOTES, 'UTF-8');
                    }
                    echo '</td>';
                    echo '<td>' . htmlspecialchars($contingencia->estado ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            }, 200, [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => 'attachment; filename=Contingencias_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xls',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);

        } catch (\Exception $e) {
            // En caso de error, retornar respuesta JSON con error
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar contingencias: ' . $e->getMessage()
            ], 500);
        }
    }
}

