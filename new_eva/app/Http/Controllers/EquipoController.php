<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // For transactions or complex queries if needed
use Illuminate\Support\Facades\Auth; // For authentication
use App\Models\Equipo; // Assuming an Eloquent model named Equipo
use App\Models\Adquisicion; // Assuming App\Models\Adquisicion
use App\Models\Fuente; // Assuming App\Models\Fuente
use App\Models\Tecnologia; // Assuming App\Models\Tecnologia
use App\Models\Cbiomedica; // Assuming App\Models\Cbiomedica
use App\Models\Criesgo; // Assuming App\Models\Criesgo
use App\Models\Frecuencia; // Assuming App\Models\Frecuencia
use App\Models\Zona; // Assuming App\Models\Zona
use App\Models\Preventivo; // Assuming App\Models\Preventivo
use App\Models\Calibracion; // Assuming App\Models\Calibracion
use App\Models\Especificacion; // Assuming App\Models\Especificacion
use App\Models\EquipoEspecificacion; // Assuming App\Models\EquipoEspecificacion
use App\Models\EquipoRepuesto; // Assuming App\Models\EquipoRepuesto
use App\Models\Contacto; // Assuming App\Models\Contacto
use App\Models\EquipoContacto; // Assuming App\Models\EquipoContacto
use App\Models\Orden; // Assuming App\Models\Orden
use App\Models\CorrectivoGeneral; // Assuming App\Models\CorrectivoGeneral
use App\Models\CorrectivoGeneralArchivo; // Assuming App\Models\CorrectivoGeneralArchivo
use App\Models\Observacion; // Assuming App\Models\Observacion
use App\Models\EquipoArchivo; // Assuming App\Models\EquipoArchivo
use App\Models\Archivo; // Assuming App\Models\Archivo
// use App\Models\Upload; // Likely not needed, use Storage facade
use App\Models\PeriodoGarantia; // Assuming App\Models\PeriodoGarantia
use App\Models\Baja; // Assuming App\Models\Baja
use App\Models\CambioUbicacion; // Assuming App\Models\CambioUbicacion
use App\Models\Servicio; // Assuming App\Models\Servicio
use App\Models\Contingencia; // Assuming App\Models\Contingencia
use App\Models\CambioHdv; // Assuming App\Models\CambioHdv
use App\Models\Invima; // Assuming App\Models\Invima
use App\Models\Guia; // Assuming App\Models\Guia
use App\Models\Estadoequipo; // Assuming App\Models\Estadoequipo
use App\Models\OrdenCompra; // Assuming App\Models\OrdenCompra
use App\Models\Propietario; // Assuming App\Models\Propietario
use Carbon\Carbon; // For date manipulation

class EquipoController extends Controller
{
    public function __construct()
    {
        // Apply middleware for authentication and authorization
        // Example: $this->middleware('auth');
        // Example: $this->middleware('can:viewAny, App\Models\Equipo')->only('index');
        // Example: $this->middleware('can:create, App\Models\Equipo')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Authorization check (example, replace with your logic)
        // if (Auth::user()->cannot('viewAny', Equipo::class)) {
        //     abort(403, 'Forbidden');
        // }

        // Data for the main list view
        // $garantia_casi_vencida = Equipo::where('garantia_estado', 'casi_vencida')->count(); // Example query
        // $garantia_vencida = Equipo::where('garantia_estado', 'vencida')->count(); // Example query
        // $equipos_baja = Equipo::where('estadoequipo_id', Estadoequipo::BAJA)->count(); // Assuming BAJA constant or ID
        // $equipos_pendientes_baja = Equipo::where('estadoequipo_id', Estadoequipo::PENDIENTE_BAJA)->count(); // Example

        // In Laravel, you typically pass data to one main view.
        // Modals are often handled by frontend components or loaded via AJAX.
        // For simplicity, we'll pass some data.
        // You'll need to define corresponding Blade views.

        // $acciones = Auth::user()->getPermissionsForModule('equipos'); // Example of getting permissions

        return view('equipos.list', [
            // 'permisos' => $this->permisos, // This would be handled by Laravel's authorization
            // 'garantia_casi_vencida' => $garantia_casi_vencida,
            // 'garantia_vencida' => $garantia_vencida,
            // 'equipos_baja' => $equipos_baja,
            // 'equipos_pendientes_baja' => $equipos_pendientes_baja,
            // 'acciones' => $acciones,
            'tipo_id' => 1 // If still needed
        ]);
        // The multiple $this->load->view() calls for modals would be refactored.
        // e.g., <x-modal-add-equipo />, or JS fetching modal content.
    }

    /**
     * Fetch devices with pagination (API endpoint example).
     */
    public function get_devices(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $devices = Equipo::paginate($limit, ['*'], 'page', $page);

        if ($devices->isNotEmpty()) {
            return response()->json($devices);
        } else {
            return response()->json(['error' => 'No se encontraron equipos'], 404);
        }
    }

    /**
     * Fetch a single device by ID (API endpoint example).
     */
    public function get_device(Equipo $equipo) // Using Route Model Binding
    {
        // The Equipo model instance is automatically injected if found, or 404s.
        return response()->json($equipo);
    }

    /**
     * Get all devices (potentially for select lists or simple fetches).
     */
    public function getAll()
    {
        return response()->json(Equipo::all());
    }

    /**
     * Server-side processing for DataTables.
     */
    public function get_server_side(Request $request)
    {
        // This requires a more complex query builder setup or a package like yajra/laravel-datatables.
        // For a basic idea:
        $query = Equipo::query();

        // Apply searching
        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhere('code', 'like', '%' . $searchValue . '%')
                  ->orWhere('serial', 'like', '%' . $searchValue . '%');
                // Add other searchable columns
            });
        }

        // Apply ordering
        if ($request->filled('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');
            $columnName = $request->input('columns.' . $orderColumnIndex . '.data');
            if ($columnName) {
                 $query->orderBy($columnName, $orderDir);
            }
        }

        $totalRecords = Equipo::count();
        $recordsFiltered = $query->count(); // Count after filtering (if search is applied)

        $data = $query->skip($request->input('start', 0))
                      ->take($request->input('length', 10))
                      ->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered, // More accurate count needed if complex filters
            'data' => $data,
        ]);
    }
    
    // Similar refactoring for get_server_side_baxter, get_server_side_filtros

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Renamed from 'add' to follow RESTful conventions
    {
        // Authorization check
        // if (Auth::user()->cannot('create', Equipo::class)) {
        //     abort(403);
        // }

        $validatedData = $request->validate([
            'code' => 'nullable|unique:equipos,code',
            'serial' => 'nullable|unique:equipos,serial',
            'name' => 'required|min:3',
            'codigo_antiguo' => 'nullable|unique:equipos,codigo_antiguo',
            'servicio_id' => 'nullable|integer|exists:servicios,id', // Assuming 'servicios' table
            'area_id' => 'nullable|integer|exists:areas,id', // Assuming 'areas' table
            'image' => 'nullable|image|mimes:gif,jpg,png|max:2048', // Max 2MB example
            'file' => 'nullable|file|mimes:xlsx,xls|max:5120', // Max 5MB example
            'fecha_instalacion' => 'nullable|date',
            'fecha_mantenimiento' => 'nullable|date',
            // Add other validation rules based on your form_validation->set_rules()
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'vida_util' => 'nullable|integer',
            'costo' => 'nullable|numeric',
            'tadquisicion_id' => 'required|integer|exists:tadquisiciones,id',
            'frecuencia_id' => 'required|integer|exists:frecuencias,id',
            'propietario_id' => 'nullable|integer|exists:propietarios,id',
            'orden_compra_id' => 'nullable|integer|exists:ordenes_compra,id',
            'guia_id' => 'nullable|integer|exists:guias,id',
            'invima_id' => 'nullable|integer|exists:invimas,id',
            'estadoequipo_id' => 'required|integer|exists:estadoequipos,id',
            'disponibilidad_id' => 'required|integer|exists:disponibilidades,id', // Assuming 'disponibilidades' table
            // ... other fields
        ]);

        $dataToStore = $validatedData;
        $dataToStore['created_at'] = Carbon::now();
        $dataToStore['plan'] = 2; // As in original

        if ($request->hasFile('image')) {
            $dataToStore['image'] = $request->file('image')->store('upload_imagenes', 'public');
        }

        if ($request->hasFile('file')) {
            $dataToStore['file'] = $request->file('file')->store('upload_archivos', 'public');
        }
        
        // Handle manual and plano serialization if still needed
        if ($request->has('manual')) {
            $dataToStore['manual'] = serialize($request->input('manual'));
        }
        if ($request->has('plano')) {
            $dataToStore['plano'] = serialize($request->input('plano'));
        }


        try {
            $equipo = Equipo::create($dataToStore);
            return response()->json(['message' => 'Equipo agregado exitosamente', 'id' => $equipo->id], 201);
        } catch (\Exception $e) {
            // Rollback file uploads if creation fails
            if (isset($dataToStore['image']) && Storage::disk('public')->exists($dataToStore['image'])) {
                Storage::disk('public')->delete($dataToStore['image']);
            }
            if (isset($dataToStore['file']) && Storage::disk('public')->exists($dataToStore['file'])) {
                Storage::disk('public')->delete($dataToStore['file']);
            }
            return response()->json(['error' => 'No se a podido ingresar el equipo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Equipo $equipo) // Using Route Model Binding
    {
        // Authorization check
        // if (Auth::user()->cannot('view', $equipo)) {
        //     abort(403);
        // }
        
        // Load relations if needed, e.g., $equipo->load('servicio', 'area', 'preventivos');
        // The original 'show' method loads a lot of related data.
        // This should be done via Eloquent relationships.

        // Example:
        // $equipo->load([
        //     'preventivos', 'calibraciones', 'repuestos', 'especificaciones',
        //     'contactos', 'ordenes', 'correctivosGenerales', 'observaciones',
        //     'archivos', 'bajas', 'contingencias', 'cambiosHdv',
        //     'servicio', 'area', 'estadoEquipo', 'disponibilidad', 'adquisicion',
        //     'frecuenciaMantenimiento', 'propietario', 'ordenCompra', 'guia', 'invimaRegistro'
        // ]);
        
        // $frecuency_computed = $this->compute_frecuency_logic($equipo->mes_programado1, $equipo->mes_programado2);

        // In Laravel, you'd typically return a view or JSON.
        // If returning a view:
        // return view('equipos.detail', [
        //     'equipo' => $equipo,
        //     'preventivos' => $equipo->preventivos,
        //     'calibraciones' => $equipo->calibraciones,
        //     // ... and so on for all related data
        //     'frecuency_computed' => $frecuency_computed,
        // ]);

        // If it's an API endpoint:
        return response()->json($equipo->load([/* necessary relations */]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipo $equipo) // Using Route Model Binding
    {
        // Authorization check
        // if (Auth::user()->cannot('update', $equipo)) {
        //     abort(403);
        // }

        $validatedData = $request->validate([
            'code' => 'nullable|unique:equipos,code,' . $equipo->id,
            'serial' => 'nullable|unique:equipos,serial,' . $equipo->id,
            'name' => 'required|min:3',
            'codigo_antiguo' => 'nullable|unique:equipos,codigo_antiguo,' . $equipo->id,
            'servicio_id' => 'nullable|integer|exists:servicios,id',
            'area_id' => 'nullable|integer|exists:areas,id',
            'image1' => 'nullable|image|mimes:gif,jpg,png|max:2048', // Note: 'image1' from original
            'file1' => 'nullable|file|mimes:xlsx,xls|max:5120', // Note: 'file1' from original
            'archivo_invima1' => 'nullable|file|mimes:pdf|max:2048', // Note: 'archivo_invima1'
            'fecha_instalacion' => 'nullable|date',
            // ... add all other validation rules from original controller's update method
        ]);

        $dataToUpdate = $request->except(['_token', '_method', 'image1', 'file1', 'archivo_invima1', 'consulta_invima', 'sede_id', 'observacion']); // sede_id was unset

        // Store original values for history if needed
        $originalEquipoData = $equipo->toArray();
        $originalServicio = $equipo->servicio; // Assuming 'servicio' relationship

        // Handle file uploads
        if ($request->hasFile('image1')) {
            if ($equipo->image && Storage::disk('public')->exists($equipo->image)) {
                Storage::disk('public')->delete($equipo->image);
            }
            $dataToUpdate['image'] = $request->file('image1')->store('upload_imagenes', 'public');
        }

        if ($request->hasFile('file1')) {
            if ($equipo->file && Storage::disk('public')->exists($equipo->file)) {
                Storage::disk('public')->delete($equipo->file);
            }
            $dataToUpdate['file'] = $request->file('file1')->store('upload_archivos', 'public');
        }
        
        if ($request->hasFile('archivo_invima1')) {
            if ($equipo->archivo_invima && Storage::disk('public')->exists($equipo->archivo_invima)) { // Assuming 'archivo_invima' field
                Storage::disk('public')->delete($equipo->archivo_invima);
            }
            $dataToUpdate['archivo_invima'] = $request->file('archivo_invima1')->store('upload_invimas', 'public');
        }

        // Handle manual and plano serialization
        $dataToUpdate['manual'] = $request->has('manual') ? serialize($request->input('manual')) : 'N;';
        $dataToUpdate['plano'] = $request->has('plano') ? serialize($request->input('plano')) : 'N;';
        
        // Handle specific field logic from original
        if ($request->input('estadoequipo_id') != 6) { // Assuming 6 is 'Baja' or similar
            $dataToUpdate['baja_id'] = null;
        }
        if ($request->filled('observacion')) {
             $dataToUpdate['observacion'] = Carbon::now()->toDateTimeString() . "\n" . $request->input('observacion') . "\n" . $equipo->observacion;
        }
        if ($request->input('invima_id') == 1) { // Special case from original
            $dataToUpdate['invima_id'] = null;
        }
        
        // Start transaction
        DB::beginTransaction();
        try {
            // Logic for Mcambios_ubicaciones
            $newServicioId = $request->input('servicio_id', $equipo->servicio_id);
            $newAreaId = $request->input('area_id', $equipo->area_id);

            if ($originalEquipoData['servicio_id'] != $newServicioId || $originalEquipoData['area_id'] != $newAreaId) {
                $servicioNuevo = Servicio::find($newServicioId); // Fetch new service for sede_id
                CambioUbicacion::create([
                    'servicio_origen_id' => $originalEquipoData['servicio_id'],
                    'servicio_destino_id' => $newServicioId,
                    'area_origen_id' => $originalEquipoData['area_id'],
                    'area_destino_id' => $newAreaId,
                    'equipo_id' => $equipo->id,
                    'usuario_id' => Auth::id(),
                    'sede_origen_id' => $originalServicio ? $originalServicio->sede_id : null, // Need to ensure originalServicio is loaded
                    'sede_destino_id' => $servicioNuevo ? $servicioNuevo->sede_id : null,
                    'created_at' => Carbon::now(), // Laravel handles timestamps by default if $timestamps=true
                ]);
            }

            // Logic for Mcambios_hdv (History of changes)
            $descripcion_historial = $this->buildChangeHistory($originalEquipoData, $request->all(), $equipo);
            if (!empty($descripcion_historial)) {
                CambioHdv::create([
                    'descripcion' => $descripcion_historial,
                    'usuario_id' => Auth::id(),
                    'equipo_id' => $equipo->id,
                    'created_at' => Carbon::now(),
                ]);
            }

            $equipo->update($dataToUpdate);
            // $this->Mequipos->depurarCodigo(); // This logic needs to be translated, perhaps a static method on Equipo model or a service
            // Equipo::depurarCodigo(); // Example

            DB::commit();
            return response()->json(['message' => 'Equipo actualizado exitosamente', 'equipo_id' => $equipo->id]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            // Rollback file uploads if update fails
            if (isset($dataToUpdate['image']) && $dataToUpdate['image'] !== $originalEquipoData['image'] && Storage::disk('public')->exists($dataToUpdate['image'])) {
                Storage::disk('public')->delete($dataToUpdate['image']);
            }
            // ... similar rollback for other files
            return response()->json(['error' => 'No se pudo actualizar el equipo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Helper function to build change history string.
     * This is a simplified version and needs to be expanded based on all fields from the original.
     */
    private function buildChangeHistory(array $originalData, array $newData, Equipo $equipo): string
    {
        $descripcion_historial = '';
        $fieldsToTrack = [
            'name' => 'nombre', 'marca' => 'marca', 'modelo' => 'modelo', 'code' => 'Codigo',
            'serial' => 'Serie', 'fecha_ad' => 'Fecha adquisicion', /* ... add all fields ... */
            'estadoequipo_id' => 'estado funcional del equipo',
            'servicio_id' => 'servicio',
            // ... etc.
        ];

        foreach ($fieldsToTrack as $field => $label) {
            $originalValue = $originalData[$field] ?? null;
            $newValue = $newData[$field] ?? null;

            if ($originalValue != $newValue) {
                // For foreign keys, you might want to fetch the related model's name
                if ($field === 'estadoequipo_id') {
                    $oldName = Estadoequipo::find($originalValue)->name ?? 'N/A';
                    $newName = Estadoequipo::find($newValue)->name ?? 'N/A';
                    $descripcion_historial .= "Se cambio {$label} de {$oldName} a {$newName}\n";
                } elseif ($field === 'servicio_id') {
                    $oldName = Servicio::find($originalValue)->nombre ?? 'N/A'; // Assuming 'nombre' field
                    $newName = Servicio::find($newValue)->nombre ?? 'N/A';
                    $descripcion_historial .= "Se cambio {$label} de {$oldName} a {$newName}\n";
                } else {
                    $descripcion_historial .= "Se cambio {$label} de '{$originalValue}' a '{$newValue}'\n";
                }
            }
        }
        return $descripcion_historial;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        // Authorization check
        // if (Auth::user()->cannot('delete', $equipo)) {
        //     abort(403);
        // }

        // Consider soft deletes if your Equipo model uses them.
        // Handle related data deletion or unlinking if necessary.
        // Handle file deletions from storage.

        DB::beginTransaction();
        try {
            // Example: Delete related files
            if ($equipo->image && Storage::disk('public')->exists($equipo->image)) {
                Storage::disk('public')->delete($equipo->image);
            }
            if ($equipo->file && Storage::disk('public')->exists($equipo->file)) {
                Storage::disk('public')->delete($equipo->file);
            }
            // ... delete other associated files

            // Delete related records (example, adjust based on your relationships and cascade rules)
            // $equipo->observaciones()->delete();
            // $equipo->correctivosGenerales()->delete();
            // ...

            $equipo->delete();
            DB::commit();
            return response()->json(['message' => 'Equipo eliminado exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'No se pudo eliminar el equipo: ' . $e->getMessage()], 500);
        }
    }

    // ... Other methods like copy, getTadquisiciones, getFuentes, etc., need similar refactoring ...
    // For example, getTadquisiciones:
    public function getTadquisiciones()
    {
        return response()->json(Adquisicion::all()); // Assuming Adquisicion model
    }

    // Methods for CRUD operations on related entities (Observaciones, EquipoRepuestos, etc.)
    // should ideally be in their own controllers (e.g., EquipoObservacionController)
    // and follow RESTful patterns. For example:
    // POST /equipos/{equipo}/observaciones - to add an observation to an equipo

    public function addObservacion(Request $request, Equipo $equipo)
    {
        $validatedData = $request->validate([
            'descripcion' => 'required|string',
            'file' => 'nullable|file|max:10000', // Max 10MB example
            'created_at_custom' => 'nullable|date_format:Y-m-d', // Renamed from 'created_at' to avoid conflict
            'hora_observacion' => 'nullable|date_format:H:i:s',
            'repuesto_id' => 'nullable|integer|exists:repuestos,id', // Assuming 'repuestos' table
        ]);

        $dataToStore = [
            'equipo_id' => $equipo->id,
            'usuario_id' => Auth::id(), // Assuming user is logged in
            'descripcion' => $validatedData['descripcion'],
            // ... other fields
        ];

        if ($request->filled('created_at_custom') && $request->filled('hora_observacion')) {
            $dataToStore['created_at'] = Carbon::parse($validatedData['created_at_custom'] . ' ' . $validatedData['hora_observacion']);
        } else {
            $dataToStore['created_at'] = Carbon::now();
        }

        if ($request->hasFile('file')) {
            $dataToStore['file'] = $request->file('file')->store('upload_observaciones', 'public');
        }

        DB::beginTransaction();
        try {
            if ($request->filled('repuesto_id')) {
                $dataToStore['repuesto_pendiente'] = 'si';
                $equipo->update(['repuesto_pendiente' => 'si']);
            }

            $observacion = Observacion::create($dataToStore);
            DB::commit();

            $responseData = [
                'message' => 'Observación agregada',
                'observacion_id' => $observacion->id,
                'equipo_id' => $equipo->id,
            ];
            if ($request->filled('repuesto_id')) {
                $responseData['repuesto_id'] = $request->input('repuesto_id');
            }
            return response()->json($responseData, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($dataToStore['file']) && Storage::disk('public')->exists($dataToStore['file'])) {
                Storage::disk('public')->delete($dataToStore['file']);
            }
            return response()->json(['error' => 'No se pudo agregar la observación: ' . $e->getMessage()], 500);
        }
    }
    
    // You would continue this pattern for all methods:
    // - getOneObservacion -> show method in ObservacionController or EquipoObservacionController
    // - updateObservacion -> update method
    // - deleteObservacion -> destroy method
    // - addEquipoRepuesto, etc.

    // The 'copy' method would involve fetching an existing Equipo,
    // modifying its unique fields (code, serial), and creating a new record.
    // Then copying related records like especificaciones and contactos.
    public function copy(Request $request, Equipo $equipoOrigen) // Route: POST /equipos/{equipoOrigen}/copy
    {
        // Authorization
        // if (Auth::user()->cannot('create', Equipo::class)) { abort(403); }

        $validatedData = $request->validate([
            'code' => 'required|unique:equipos,code',
            'serial' => 'required|unique:equipos,serial',
            'name' => 'required|min:3',
            'codigo_antiguo' => 'nullable|unique:equipos,codigo_antiguo',
            'servicio_id' => 'nullable|integer|exists:servicios,id',
            'area_id' => 'nullable|integer|exists:areas,id',
            // ... other fields that can be overridden for the copy
        ]);

        DB::beginTransaction();
        try {
            $equipoDestinoData = $equipoOrigen->toArray();
            unset($equipoDestinoData['id'], $equipoDestinoData['created_at'], $equipoDestinoData['updated_at']); // Remove primary key and timestamps

            // Override with validated data
            $equipoDestinoData = array_merge($equipoDestinoData, $validatedData);
            $equipoDestinoData['created_at'] = Carbon::now();
            $equipoDestinoData['plan'] = 2; // As in original

            // Handle file if it's part of the copy request and different from original
            if ($request->hasFile('file')) { // Assuming 'file' can be provided for the copy
                 if ($equipoOrigen->file && $equipoOrigen->file !== $request->file('file')->getClientOriginalName()) { // Basic check
                    // Potentially delete old file if it's not shared and this is a new upload for copy
                 }
                $equipoDestinoData['file'] = $request->file('file')->store('upload_archivos', 'public');
            } else {
                // Decide how to handle the original file: copy it, link it, or ignore it
                // For simplicity, let's assume we might copy the file if it exists
                if ($equipoOrigen->file && Storage::disk('public')->exists($equipoOrigen->file)) {
                    $newFilePath = 'upload_archivos/' . uniqid() . '_' . basename($equipoOrigen->file);
                    Storage::disk('public')->copy($equipoOrigen->file, $newFilePath);
                    $equipoDestinoData['file'] = $newFilePath;
                } else {
                    $equipoDestinoData['file'] = null;
                }
            }
            // Similar logic for 'image' if it can be copied/changed

            $equipoDestino = Equipo::create($equipoDestinoData);

            // Copy related data (Mequipo_especificaciones, Mequipo_contactos)
            foreach ($equipoOrigen->especificaciones as $especificacion) { // Assuming 'especificaciones' relationship
                $newEspecificacionData = $especificacion->toArray();
                unset($newEspecificacionData['id'], $newEspecificacionData['equipo_id']);
                $equipoDestino->especificaciones()->create($newEspecificacionData);
            }
            foreach ($equipoOrigen->contactos as $contacto) { // Assuming 'contactos' relationship
                $newContactoData = $contacto->toArray();
                unset($newContactoData['id'], $newContactoData['equipo_id']);
                $equipoDestino->contactos()->create($newContactoData);
            }

            DB::commit();
            return response()->json(['message' => 'Equipo copiado exitosamente', 'id' => $equipoDestino->id], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'No se pudo copiar el equipo: ' . $e->getMessage()], 500);
        }
    }
}
