<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Mequipos;
use App\Models\Mbajas;
use Illuminate\Http\JsonResponse;

class Cbajas extends Controller
{
    private $Mequipos;
    private $Mbajas;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mbajas = new Mbajas();
    }
    
    public function index()
    {
        if (!Session::has('login')) {
            return redirect()->route('auth.login');
        }
        
        $acciones = Session::get('acciones');
        Session::put('controlador', request()->segment(2));
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "bajas biomedicos") {
                if ($accion->leer != 1) {
                    return redirect()->route('home');
                }
            }
        }

        $data = [
            "bajas" => $this->Mbajas->get()
        ];
        
        return view('layouts.app', [
            'content' => view('bajas.list', $data)
                ->with('modal_add', view('bajas.modal_add'))
                ->with('modal_edit', view('bajas.modal_edit'))
                ->with('modal_asociacion_baja', view('bajas.modal_asociacion_baja'))
                ->with('modal_asociacion_baja_especifico', view('bajas.modal_asociacion_baja_especifico'))
        ]);
    }
    
    public function get(): JsonResponse
    {
        return response()->json($this->Mbajas->get());
    }
    
    public function getWithNumberDevices(): JsonResponse
    {
        return response()->json($this->Mbajas->getWithNumberDevices());
    }

    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mbajas->getOne($request->all()));
    }

    public function get_equipos_bajas(): JsonResponse
    {
        return response()->json($this->Mbajas->get_equipos_bajas());
    }
    
    public function add(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_bajas'), $fileName);
            $data['archivo'] = $fileName;
        }

        if ($this->Mbajas->add($data)) {
            return response()->json(1);
        } else {
            if (isset($data['archivo'])) {
                File::delete(public_path('assets/upload_bajas/' . $data['archivo']));
            }
            return response()->json(2);
        }
    }
    
    public function add_equipo_baja(Request $request)
    {
        $data = $request->all();
        
        if (!empty($data)) {
            $vector = [
                "equipo_id" => $data["equipo_id"],
                "estadoequipo_id" => 6
            ];
        }
        
        if ($this->Mbajas->add_equipo_bajas($data)) {
            $this->Mequipos->cambiar_dado_baja($vector);
        }
    }
    
    public function delete_equipo_baja(Request $request)
    {
        $this->Mbajas->delete_equipo_baja($request->all());
    }
    
    public function show(Request $request)
    {
        $bajas = $this->Mbajas->getAll();
        $vector = [
            "bajas" => $bajas,
            "equipo_id" => $request->input('equipo_id')
        ];
        
        return view("bajas.detalle_consulta", $vector);
    }
    
    public function asociar_baja(Request $request)
    {
        $data = $request->all();
        $data["estadoequipo_id"] = 6;
        $this->Mequipos->asociar_baja($data);
    }
    
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        
        $validator = Validator::make($data, [
            'descripcion' => 'required|min:4',
        ]);
        
        // Verificar si la descripción ya existe pero no es la misma que la actual
        $baja = $this->Mbajas->getOne($data);
        if ($baja->descripcion != $data["descripcion"]) {
            $validator = Validator::make($data, [
                'descripcion' => 'required|min:4|unique:bajas,descripcion',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                "caso" => 2,
                "informacion_error" => $validator->errors()->first()
            ]);
        }
        
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_bajas'), $fileName);
            $data['archivo'] = $fileName;
        }
        
        if ($this->Mbajas->update($data)) {
            return response()->json([
                "caso" => 1
            ]);
        } else {
            if (isset($data['archivo'])) {
                File::delete(public_path('assets/upload_archivos/' . $data['archivo']));
            }
            return response()->json([
                "caso" => 2,
                "informacion_error" => "Error al actualizar el registro"
            ]);
        }
    }

    public function show_baja_asociaciones(Request $request)
    {
        $equipos_a_asociar = $this->Mequipos->get();
        $vector = [
            "equipos" => $equipos_a_asociar,
            "baja_id" => $request->input('baja_id')
        ];
        
        return view("bajas.modal_asociacion_baja_detail", $vector);
    }
    
    public function update_multiples_bajas(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if (isset($data["seleccion"])) {
            $equipos_seleccionados = $data["seleccion"];
            foreach ($equipos_seleccionados as $equipo_id) {
                $this->Mequipos->update_multiples_bajas($equipo_id, $data["baja_id"]);
            }
            return response()->json("El registro de disposición final fue asociado exitosamente a los equipos seleccionados");
        } else {
            return response()->json("No se seleccionaron equipos");
        }
    }
    
    public function update_multiples_bajas_eliminar(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if (isset($data["seleccion"])) {
            $equipos_seleccionados = $data["seleccion"];
            foreach ($equipos_seleccionados as $equipo_id) {
                $this->Mequipos->update_multiples_bajas_eliminar($equipo_id, $data["baja_id"]);
            }
            return response()->json("Los equipos seleccionados vinculados al documento de disposicion final fueron desvinculados");
        } else {
            return response()->json("No se seleccionaron equipos");
        }
    }

    public function show_equipos_en_baja(Request $request)
    {
        $equipos = $this->Mequipos->getEquiposEnBaja($request->all());
        $vector = [
            "equipos" => $equipos,
            "baja_id" => $request->input('baja_id')
        ];
        
        return view("bajas.modal_asociacion_baja_detail_especifico", $vector);
    }
}

