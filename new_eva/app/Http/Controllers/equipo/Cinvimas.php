<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use App\Models\Mequipos;
use App\Models\Minvimas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/**
 * Controlador de Registros INVIMA - Laravel 11
 * Hospital Universitario del Valle - Gestión de Tecnología Biomédica
 *
 * Maneja la gestión completa de registros sanitarios INVIMA:
 * - Listado y consulta de registros INVIMA
 * - Creación y edición de registros
 * - Manejo de archivos de registros sanitarios
 * - Activación/desactivación de registros
 * - Asociación con equipos médicos
 *
 * Migrado completamente a Laravel 11 con mejoras de rendimiento y seguridad
 */
class Cinvimas extends Controller
{
    protected Mequipos $mequipos;
    protected Minvimas $minvimas;

    /**
     * Constructor - Inyección de dependencias con tipado fuerte
     *
     * @param Mequipos $mequipos
     * @param Minvimas $minvimas
     */
    public function __construct(Mequipos $mequipos, Minvimas $minvimas)
    {
        $this->mequipos = $mequipos;
        $this->minvimas = $minvimas;
    }

    /**
     * Mostrar listado principal de registros INVIMA
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Verificar autenticación (mantener consistencia con el sistema)
        if (!Session::has('login')) {
            return redirect('Cauth');
        }

        // Configurar controlador actual en sesión
        Session::put('controlador', request()->segment(2));
        $acciones = Session::get('acciones');

        // Verificar permisos de lectura
        foreach ($acciones as $accion) {
            if ($accion->modulo == "invimas") {
                if ($accion->leer != 1) {
                    return redirect('Home');
                }
            }
        }

        try {
            $data = [
                "invimas" => $this->minvimas->getAll()
            ];

            return view('invimas.list', $data)
                ->with('header', view('layouts.header'))
                ->with('aside', view('layouts.aside'))
                ->with('modal_edit', view('invimas.modal_edit'))
                ->with('modal_add', view('invimas.modal_add'))
                ->with('modal_asociacion_invima', view('equipos.modal_asociacion_invima'))
                ->with('modal_asociacion_invima_especifico', view('equipos.modal_asociacion_invima_especifico'))
                ->with('footer', view('layouts.footer'));

        } catch (\Exception $e) {
            return redirect('Home')->with('error', 'Error al cargar registros INVIMA: ' . $e->getMessage());
        }
    }

    /**
     * Obtener registros INVIMA con filtros
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        try {
            $invimas = $this->minvimas->get();
            return response()->json($invimas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener registros INVIMA: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los registros INVIMA
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $invimas = $this->minvimas->getAll();
            return response()->json($invimas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener todos los registros INVIMA: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener registros INVIMA con número de dispositivos asociados
     *
     * @return JsonResponse
     */
    public function getWithNumberDevices(): JsonResponse
    {
        try {
            $invimas = $this->minvimas->getWithNumberDevices();
            return response()->json($invimas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener registros con dispositivos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un registro INVIMA específico
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): JsonResponse
    {
        try {
            // Validar entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:invimas,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de registro INVIMA inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $invima = $this->minvimas->getOne($request->all());
            return response()->json($invima);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el registro INVIMA: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar registros INVIMA por descripción similar
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getdescriptionlike(Request $request): JsonResponse
    {
        try {
            // Validar entrada
            $validator = Validator::make($request->all(), [
                'description' => 'required|string|min:3'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Descripción de búsqueda inválida',
                    'errors' => $validator->errors()
                ], 422);
            }

            $invimas = $this->minvimas->getdescriptionlike($request->all());
            return response()->json($invimas);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear nuevo registro INVIMA
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'invima' => 'required|string|min:4|unique:invimas,invima',
                'description' => 'nullable|string|max:500',
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
                $uploadPath = public_path('assets/upload_registros_sanitarios');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $data['file'] = $fileName;
            }

            // Agregar timestamp de creación
            $data['created_at'] = Carbon::now();

            if ($this->minvimas->add($data)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registro INVIMA creado exitosamente'
                ]);
            } else {
                // Limpiar archivo si falló la inserción
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_registros_sanitarios/' . $data['file']));
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el registro INVIMA'
                ], 500);
            }

        } catch (\Exception $e) {
            // Limpiar archivo en caso de error
            if (isset($data['file'])) {
                File::delete(public_path('assets/upload_registros_sanitarios/' . $data['file']));
            }

            return response()->json([
                'success' => false,
                'message' => 'Error del sistema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar registro INVIMA existente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Validar que existe el ID
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:invimas,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de registro INVIMA inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $currentInvima = $this->minvimas->getOne($data);

            // Reglas de validación dinámicas
            $rules = [
                'invima' => 'required|string|min:4',
                'description' => 'nullable|string|max:500',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            ];

            // Si cambió el número INVIMA, validar unicidad
            if ($currentInvima->invima != $data['invima']) {
                $rules['invima'] = 'required|string|min:4|unique:invimas,invima';
            }

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de validación incorrectos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Manejar archivo adjunto si existe
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                // Crear directorio si no existe
                $uploadPath = public_path('assets/upload_registros_sanitarios');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $data['file'] = $fileName;
            }

            // Agregar timestamp de actualización
            $data['updated_at'] = Carbon::now();

            if ($this->minvimas->update($data)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registro INVIMA actualizado exitosamente'
                ]);
            } else {
                // Limpiar archivo si falló la actualización (corregir ruta)
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_registros_sanitarios/' . $data['file']));
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el registro INVIMA'
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
     * Eliminar (desactivar) registro INVIMA
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:invimas,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de registro INVIMA inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $this->minvimas->delete($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Registro INVIMA desactivado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activar registro INVIMA
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function activate(Request $request): JsonResponse
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:invimas,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de registro INVIMA inválido',
                    'errors' => $validator->errors()
                ], 422);
            }

            $this->minvimas->activate($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Registro INVIMA activado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al activar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar vista de detalle de consulta de registros INVIMA
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show()
    {
        try {
            $invimas_activos = $this->minvimas->getAll();
            $data = [
                "invimas" => $invimas_activos
            ];

            return view('invimas.detalle_consulta', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el detalle: ' . $e->getMessage());
        }
    }
}

