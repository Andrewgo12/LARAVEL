<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Musuarios;
use App\Models\Musuarios_zonas;
use App\Models\Mcentros;
use App\Models\Macciones;
use App\Models\Mmodulos;

/**
 * Controlador de Usuarios - Migrado completamente a Laravel 11
 * Sistema HUV - Hospital Universitario del Valle
 *
 * Gestiona todos los aspectos relacionados con usuarios:
 * - CRUD completo de usuarios
 * - Sistema de permisos y roles
 * - Gestión de zonas y sedes
 * - Cambio de configuraciones de usuario
 */
class CusuariosController extends Controller
{
    protected Musuarios $musuarios;
    protected Musuarios_zonas $musuarios_zonas;
    protected Mcentros $mcentros;
    protected Macciones $macciones;
    protected Mmodulos $mmodulos;

    public function __construct()
    {
        $this->musuarios = new Musuarios();
        $this->musuarios_zonas = new Musuarios_zonas();
        $this->mcentros = new Mcentros();
        $this->macciones = new Macciones();
        $this->mmodulos = new Mmodulos();
    }
  
    /**
     * Mostrar la lista principal de usuarios
     */
    public function index(): View|RedirectResponse
    {
        // Verificar autenticación
        if (!Session::has('login')) {
            return redirect()->route('huv.login');
        }

        // Establecer controlador actual en sesión
        Session::put('controlador', request()->segment(2));

        try {
            $data = [
                'modulos' => $this->mmodulos->getWithAccount(),
                'user' => $this->getCurrentUser(),
                'permisos' => Session::get('acciones', [])
            ];

            return view('usuarios.list', $data);

        } catch (\Exception $e) {
            Log::error('Error en index de usuarios: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar la lista de usuarios']);
        }
    }
  
    /**
     * Servicio para obtener todos los usuarios
     */
    public function serviceGetAll(): JsonResponse
    {
        try {
            $usuarios = $this->musuarios->getAllUsers();
            return response()->json([
                'success' => true,
                'data' => $usuarios,
                'count' => count($usuarios)
            ]);
        } catch (\Exception $e) {
            Log::error('Error en serviceGetAll: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Servicio para obtener un usuario específico
     */
    public function serviceGetOne($id): JsonResponse
    {
        try {
            $usuario = $this->musuarios->getOneUser($id);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $usuario
            ]);
        } catch (\Exception $e) {
            Log::error('Error en serviceGetOne: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todos los usuarios (método legacy)
     */
    public function getAll(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->musuarios->getAll()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getAll: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios'
            ], 500);
        }
    }
  
    /**
     * Obtener datos para DataTables server-side processing
     */
    public function getServerSide(Request $request): JsonResponse
    {
        try {
            $vector = $this->musuarios->get_server_side($request->all());

            $respuesta = [
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => $vector['num_filas_limit'] ?? 0,
                'recordsFiltered' => $vector['num_filas'] ?? 0,
                'data' => $vector['datos'] ?? []
            ];

            return response()->json($respuesta);

        } catch (\Exception $e) {
            Log::error('Error en getServerSide: ' . $e->getMessage());
            return response()->json([
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Error al procesar datos'
            ], 500);
        }
    }
  
    /**
     * Obtener todos los roles disponibles
     */
    public function getRoles(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->musuarios->getRoles()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getRoles: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener roles'
            ], 500);
        }
    }

    /**
     * Crear un nuevo usuario
     */
    public function add(Request $request): JsonResponse
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:100',
            'apellido' => 'required|string|min:2|max:100',
            'username' => 'required|string|min:3|max:50|unique:usuarios,username',
            'email' => 'required|email|max:100|unique:usuarios,email',
            'password' => 'required|string|min:4|max:50',
            'telefono' => 'nullable|string|max:20',
            'rol_id' => 'required|integer|exists:roles,id',
            'sede_id' => 'required|integer|exists:sedes,id',
            'centro_id' => 'nullable|integer|exists:centros,id',
            'zona_id' => 'nullable|integer|exists:zonas,id',
            'servicio_id' => 'nullable|integer|exists:servicios,id',
            'id_empresa' => 'nullable|integer|exists:empresas,id'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.unique' => 'El nombre de usuario ya existe',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'El email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres',
            'rol_id.required' => 'El rol es obligatorio',
            'sede_id.required' => 'La sede es obligatoria'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Encriptar contraseña (manteniendo compatibilidad con sistema original)
            $data['password'] = sha1(md5($data['password']));
            $data['estado'] = 1; // Usuario activo por defecto
            $data['active'] = 'true'; // Activado por defecto
            $data['created_at'] = now();
            $data['updated_at'] = now();

            $userId = $this->musuarios->add($data);

            DB::commit();

            Log::info('Usuario creado exitosamente', [
                'user_id' => $userId,
                'username' => $data['username'],
                'created_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear usuario: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
  
    /**
     * Actualizar un usuario existente
     */
    public function update(Request $request): JsonResponse
    {
        $userId = $request->input('id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de usuario requerido'
            ], 400);
        }

        try {
            $usuarioActual = $this->musuarios->getOne($userId);

            if (!$usuarioActual) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Reglas de validación
            $rules = [
                'nombre' => 'required|string|min:2|max:100',
                'apellido' => 'required|string|min:2|max:100',
                'username' => [
                    'required',
                    'string',
                    'min:3',
                    'max:50',
                    Rule::unique('usuarios')->ignore($userId)
                ],
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    Rule::unique('usuarios')->ignore($userId)
                ],
                'telefono' => 'nullable|string|max:20',
                'rol_id' => 'required|integer|exists:roles,id',
                'sede_id' => 'required|integer|exists:sedes,id',
                'centro_id' => 'nullable|integer|exists:centros,id',
                'zona_id' => 'nullable|integer|exists:zonas,id',
                'servicio_id' => 'nullable|integer|exists:servicios,id',
                'id_empresa' => 'nullable|integer|exists:empresas,id',
                'estado' => 'required|integer|in:0,1'
            ];

            // Solo validar contraseña si se proporciona
            if ($request->filled('password')) {
                $rules['password'] = 'string|min:4|max:50';
            }

            $validator = Validator::make($request->all(), $rules, [
                'nombre.required' => 'El nombre es obligatorio',
                'apellido.required' => 'El apellido es obligatorio',
                'username.required' => 'El nombre de usuario es obligatorio',
                'username.unique' => 'El nombre de usuario ya existe',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe ser válido',
                'email.unique' => 'El email ya está registrado',
                'password.min' => 'La contraseña debe tener al menos 4 caracteres',
                'rol_id.required' => 'El rol es obligatorio',
                'sede_id.required' => 'La sede es obligatoria'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $data = $request->all();
            $data['updated_at'] = now();

            // Encriptar contraseña solo si se proporciona
            if ($request->filled('password')) {
                $data['password'] = sha1(md5($data['password']));
            } else {
                unset($data['password']);
            }

            $this->musuarios->update($data);

            DB::commit();

            Log::info('Usuario actualizado exitosamente', [
                'user_id' => $userId,
                'username' => $data['username'],
                'updated_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar usuario: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
  
    /**
     * Eliminar un usuario (cambiar estado a inactivo)
     */
    public function delete(Request $request): JsonResponse
    {
        $userId = $request->input('id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de usuario requerido'
            ], 400);
        }

        try {
            $usuario = $this->musuarios->getOne($userId);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Verificar que no sea el usuario actual
            if ($userId == Session::get('id')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes desactivar tu propio usuario'
                ], 403);
            }

            DB::beginTransaction();

            // Cambiar estado a inactivo en lugar de eliminar
            $array = ['estado' => 0, 'updated_at' => now()];
            $this->musuarios->delete($request->all(), $array);

            DB::commit();

            Log::info('Usuario desactivado exitosamente', [
                'user_id' => $userId,
                'deactivated_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario desactivado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al desactivar usuario: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalles de un usuario
     */
    public function show(Request $request): View|RedirectResponse
    {
        $userId = $request->input('id');

        if (!$userId) {
            return redirect()->back()->withErrors(['error' => 'ID de usuario requerido']);
        }

        try {
            $usuario = $this->musuarios->getOne($userId);

            if (!$usuario) {
                return redirect()->back()->withErrors(['error' => 'Usuario no encontrado']);
            }

            $data = [
                'usuario' => $usuario,
                'user' => $this->getCurrentUser(),
                'permisos' => Session::get('acciones', [])
            ];

            return view('usuarios.detail', $data);

        } catch (\Exception $e) {
            Log::error('Error en show usuario: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al cargar usuario']);
        }
    }

    /**
     * Obtener un usuario específico
     */
    public function getOne(Request $request): JsonResponse
    {
        $userId = $request->input('id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de usuario requerido'
            ], 400);
        }

        try {
            $usuario = $this->musuarios->getOne($userId);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $usuario
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOne: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuario'
            ], 500);
        }
    }
  
    /**
     * Obtener usuario con sus acciones/permisos
     */
    public function getOneWithActions(Request $request): JsonResponse
    {
        $userId = $request->input('id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de usuario requerido'
            ], 400);
        }

        try {
            $usuario = $this->musuarios->getOne($userId);
            $acciones = $this->macciones->getByUser($userId);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'usuario' => $usuario,
                    'acciones' => $acciones
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getOneWithActions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuario con acciones'
            ], 500);
        }
    }

    /**
     * Obtener todos los centros
     */
    public function getCentros(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->mcentros->get()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getCentros: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener centros'
            ], 500);
        }
    }

    /**
     * Cambiar sede del usuario (toggle entre sede 1 y otra)
     */
    public function cambiarSede(Request $request): JsonResponse
    {
        $userId = $request->input('id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de usuario requerido'
            ], 400);
        }

        try {
            $usuario = $this->musuarios->getOne($userId);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            DB::beginTransaction();

            // Determinar el caso según la sede actual
            $param = [
                'id' => $userId,
                'caso' => ($usuario->sede_id == 1) ? 1 : 2
            ];

            $this->musuarios->CambiarSede($param);

            // Obtener usuario actualizado
            $usuarioActualizado = $this->musuarios->getOne($userId);

            // Actualizar sesión si es el usuario actual
            if ($userId == Session::get('id')) {
                Session::put('sede_id', $usuarioActualizado->sede_id);
            }

            DB::commit();

            Log::info('Sede cambiada exitosamente', [
                'user_id' => $userId,
                'new_sede_id' => $usuarioActualizado->sede_id,
                'changed_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sede cambiada exitosamente',
                'sede' => $usuarioActualizado->sede ?? null
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar sede: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar sede'
            ], 500);
        }
    }

    /**
     * Cambiar sede general del usuario
     */
    public function cambiarSedeGeneral(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer|exists:usuarios,id',
            'sede_id' => 'required|integer|exists:sedes,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $usuarioId = $request->input('usuario_id');
            $sedeId = $request->input('sede_id');

            DB::beginTransaction();

            $this->musuarios->update([
                'id' => $usuarioId,
                'sede_id' => $sedeId,
                'updated_at' => now()
            ]);

            // Actualizar sesión si es el usuario actual
            if ($usuarioId == Session::get('id')) {
                Session::put('sede_id', $sedeId);
            }

            DB::commit();

            Log::info('Sede general cambiada', [
                'user_id' => $usuarioId,
                'new_sede_id' => $sedeId,
                'changed_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sede actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar sede general: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar sede'
            ], 500);
        }
    }

    /**
     * Obtener usuarios por zonas
     */
    public function getUsuariosZonas(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->musuarios->getUsuarios_zonas()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getUsuariosZonas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios por zonas'
            ], 500);
        }
    }

    /**
     * Eliminar relación usuario-zona
     */
    public function deleteUsuarioZona(Request $request): JsonResponse
    {
        try {
            $result = $this->musuarios->delete_usuario_zona($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Relación usuario-zona eliminada',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Error en deleteUsuarioZona: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar relación usuario-zona'
            ], 500);
        }
    }

    /**
     * Agregar relación usuario-zona
     */
    public function addUsuarioZona(Request $request): JsonResponse
    {
        try {
            $result = $this->musuarios_zonas->add($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Relación usuario-zona agregada',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Error en addUsuarioZona: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar relación usuario-zona'
            ], 500);
        }
    }

    /**
     * Obtener usuarios de una empresa específica
     */
    public function getUsuariosFromEmpresa(Request $request): JsonResponse
    {
        try {
            $usuarios = $this->musuarios->getUsuariosFromEmpresa($request->all());

            return response()->json([
                'success' => true,
                'data' => $usuarios
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getUsuariosFromEmpresa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios de la empresa'
            ], 500);
        }
    }
  
    /**
     * Cambiar año del plan del usuario
     */
    public function cambiarAnio(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:usuarios,id',
            'anio' => 'required|integer|min:2020|max:2030'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $usuarioId = $request->input('id');
            $anio = $request->input('anio');

            $usuario = $this->musuarios->getOne($usuarioId);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            DB::beginTransaction();

            $this->musuarios->CambiarAnio([
                'id' => $usuario->id,
                'anio_plan' => $anio
            ]);

            // Actualizar sesión si es el usuario actual
            if ($usuarioId == Session::get('id')) {
                Session::put('anio_plan', $anio);
            }

            DB::commit();

            Log::info('Año del plan cambiado', [
                'user_id' => $usuarioId,
                'new_year' => $anio,
                'changed_by' => Session::get('id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Año del plan actualizado',
                'anio_plan' => $anio
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar año: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar año del plan'
            ], 500);
        }
    }

    /**
     * Obtener información del usuario actual
     */
    private function getCurrentUser(): array
    {
        return [
            'id' => Session::get('id'),
            'nombre' => Session::get('nombre'),
            'apellido' => Session::get('apellido'),
            'email' => Session::get('email'),
            'rol_id' => Session::get('rol_id'),
            'rol_nombre' => Session::get('rol_nombre'),
            'sede_id' => Session::get('sede_id'),
            'sede_nombre' => Session::get('sede_nombre')
        ];
    }

    /**
     * Verificar permisos del usuario
     */
    private function hasPermission(string $permission): bool
    {
        $acciones = Session::get('acciones', []);
        return in_array($permission, $acciones);
    }

    /**
     * Obtener todas las zonas
     */
    public function getZonas(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->musuarios_zonas->getAll()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getZonas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener zonas'
            ], 500);
        }
    }

    /**
     * Obtener todas las acciones
     */
    public function getAcciones(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->macciones->getAll()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getAcciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener acciones'
            ], 500);
        }
    }

    /**
     * Obtener todos los módulos
     */
    public function getModulos(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $this->mmodulos->getAll()
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getModulos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener módulos'
            ], 500);
        }
    }
}

