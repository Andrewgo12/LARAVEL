<?php

namespace App\Http\Controllers\propietario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Mpropietarios;

class CpropietariosController extends Controller
{
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
        Session::put('controlador', 'propietarios');

        if ($acciones) {
            foreach ($acciones as $accion) {
                if ($accion->modulo == "propietarios") {
                    if ($accion->leer != 1) {
                        return redirect()->route('forbidden');
                    }
                }
            }
        }

        $mpropietarios = app(Mpropietarios::class);

        $data = [
            "propietarios" => $mpropietarios->getAll()
        ];

        return view("propietarios.list", $data);
    }
    public function getAll(): JsonResponse
    {
        $mpropietarios = app(Mpropietarios::class);
        return response()->json($mpropietarios->getAll());
    }

    public function getOne(Request $request): JsonResponse
    {
        $mpropietarios = app(Mpropietarios::class);
        return response()->json($mpropietarios->getOne($request->all()));
    }
    public function add(Request $request): JsonResponse
    {
        $data = $request->all();

        $rules = [
            'nombre' => 'required|min:4|unique:propietarios,nombre'
        ];

        $validator = Validator::make($data, $rules, [
            'nombre.required' => 'El nombre del propietario es requerido',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
            'nombre.unique' => 'Ya existe un propietario con este nombre'
        ]);

        if ($validator->passes()) {
            $mpropietarios = app(Mpropietarios::class);

            // Manejo de archivo de logo
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');

                // Validar que sea imagen
                if (in_array($file->getClientOriginalExtension(), ['gif', 'jpg', 'jpeg', 'png'])) {
                    $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/upload_imagenes'), $filename);
                    $data["logo"] = $filename;
                } else {
                    return response()->json([
                        "caso" => 2,
                        "informacion_error" => "Solo se permiten archivos de imagen (gif, jpg, png)"
                    ]);
                }
            }

            if ($mpropietarios->add($data)) {
                $vector_respuesta = [
                    "caso" => 1,
                    "mensaje" => "Propietario agregado correctamente"
                ];
            } else {
                // Si falla la inserción, eliminar el archivo subido
                if (isset($data["logo"])) {
                    if (file_exists(public_path("assets/upload_imagenes/" . $data["logo"]))) {
                        unlink(public_path("assets/upload_imagenes/" . $data["logo"]));
                    }
                }
                $vector_respuesta = [
                    "caso" => 2,
                    "informacion_error" => "Error al guardar el propietario"
                ];
            }
        } else {
            $vector_respuesta = [
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ];
        }

        return response()->json($vector_respuesta);
    }
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        $mpropietarios = app(Mpropietarios::class);

        // Verificar si el nombre cambió para aplicar validación de unicidad
        $propietario_actual = $mpropietarios->getOne($data);

        if ($propietario_actual->nombre == $data["nombre"]) {
            $rules = [
                'nombre' => 'required|min:4'
            ];
        } else {
            $rules = [
                'nombre' => 'required|min:4|unique:propietarios,nombre'
            ];
        }

        $validator = Validator::make($data, $rules, [
            'nombre.required' => 'El nombre del propietario es requerido',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres',
            'nombre.unique' => 'Ya existe un propietario con este nombre'
        ]);

        if ($validator->passes()) {
            // Manejo de archivo de logo
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');

                // Validar que sea imagen
                if (in_array($file->getClientOriginalExtension(), ['gif', 'jpg', 'jpeg', 'png'])) {
                    $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/upload_imagenes'), $filename);
                    $data["logo"] = $filename;
                } else {
                    return response()->json([
                        "caso" => 2,
                        "informacion_error" => "Solo se permiten archivos de imagen (gif, jpg, png)"
                    ]);
                }
            }

            if ($mpropietarios->update($data)) {
                $vector_respuesta = [
                    "caso" => 1,
                    "mensaje" => "Propietario actualizado correctamente"
                ];
            } else {
                // Si falla la actualización, eliminar el archivo subido
                if (isset($data["logo"])) {
                    if (file_exists(public_path("assets/upload_imagenes/" . $data["logo"]))) {
                        unlink(public_path("assets/upload_imagenes/" . $data["logo"]));
                    }
                }
                $vector_respuesta = [
                    "caso" => 2,
                    "informacion_error" => "Error al actualizar el propietario"
                ];
            }
        } else {
            $vector_respuesta = [
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ];
        }

        return response()->json($vector_respuesta);
    }
    public function delete(Request $request): JsonResponse
    {
        $data = $request->all();
        $mpropietarios = app(Mpropietarios::class);

        if ($mpropietarios->delete($data)) {
            return response()->json([
                'success' => true,
                'message' => 'Propietario eliminado correctamente'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el propietario'
            ]);
        }
    }

    public function activate(Request $request): JsonResponse
    {
        $data = $request->all();
        $mpropietarios = app(Mpropietarios::class);

        if ($mpropietarios->activate($data)) {
            return response()->json([
                'success' => true,
                'message' => 'Propietario activado correctamente'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al activar el propietario'
            ]);
        }
    }
}
