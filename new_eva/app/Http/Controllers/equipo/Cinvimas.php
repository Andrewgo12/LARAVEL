<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use App\Models\Mequipos;
use App\Models\Minvimas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Cinvimas extends Controller
{
    protected $mequipos;
    protected $minvimas;

    public function __construct(Mequipos $mequipos, Minvimas $minvimas)
    {
        $this->mequipos = $mequipos;
        $this->minvimas = $minvimas;
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $acciones = session('acciones');
        session(['controlador' => request()->segment(2)]);

        foreach ($acciones as $accion) {
            if ($accion->modulo == "invimas") {
                if ($accion->leer != 1) {
                    return redirect()->route('forbidden');
                }
            }
        }

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
    }

    public function get(): JsonResponse
    {
        return response()->json($this->minvimas->get());
    }

    public function getAll(): JsonResponse
    {
        return response()->json($this->minvimas->getAll());
    }

    public function getWithNumberDevices(): JsonResponse
    {
        return response()->json($this->minvimas->getWithNumberDevices());
    }

    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->minvimas->getOne($request->all()));
    }

    public function getdescriptionlike(Request $request): JsonResponse
    {
        return response()->json($this->minvimas->getdescriptionlike($request->all()));
    }

    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'invima' => 'required|min:4|unique:invimas,invima',
        ]);

        if ($validator->passes()) {
            $data = $request->all();
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/upload_registros_sanitarios'), $fileName);
                $data['file'] = $fileName;
            }

            if ($this->minvimas->add($data)) {
                return response()->json([
                    "caso" => 1
                ]);
            } else {
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_registros_sanitarios/' . $data['file']));
                }
                return response()->json([
                    "caso" => 2,
                    "informacion_error" => "Error al agregar el registro"
                ]);
            }
        } else {
            return response()->json([
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ]);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        $currentInvima = $this->minvimas->getOne($data);

        $rules = [
            'invima' => 'required|min:4',
        ];

        if ($currentInvima->invima != $data['invima']) {
            $rules['invima'] = 'required|min:4|unique:invimas,invima';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/upload_registros_sanitarios'), $fileName);
                $data['file'] = $fileName;
            }

            if ($this->minvimas->update($data)) {
                return response()->json([
                    "caso" => 1
                ]);
            } else {
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_archivos/' . $data['file']));
                }
                return response()->json([
                    "caso" => 2,
                    "informacion_error" => "Error al actualizar el registro"
                ]);
            }
        } else {
            return response()->json([
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ]);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        $this->minvimas->delete($request->all());
        return response()->json(['success' => true]);
    }

    public function activate(Request $request): JsonResponse
    {
        $this->minvimas->activate($request->all());
        return response()->json(['success' => true]);
    }

    public function show()
    {
        $invimas_activos = $this->minvimas->getAll();
        $data = [
            "invimas" => $invimas_activos
        ];
        
        return view('invimas.detalle_consulta', $data);
    }
}

