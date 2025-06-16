<?php

namespace App\Http\Controllers\manual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mmanuales;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ManualesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }
        
        $acciones = session('acciones');
        session(['controlador' => request()->segment(2)]);
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "manuales") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }

        $data = [
            "manuales" => app(Mmanuales::class)->getAll()
        ];
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'manuales.list', $data)
            ->nest('modal_edit', 'manuales.modal_edit')
            ->nest('modal_add', 'manuales.modal_add')
            ->nest('modal_consulta', 'manuales.modal_consulta')
            ->nest('detalle_consulta', 'manuales.detalle_consulta')
            ->nest('footer', 'layouts.footer');
    }

    // Refactoring
    public function ServiceGetAll(): JsonResponse
    {
        return response()->json(app(Mmanuales::class)->getAllManuals());
    }
    
    public function ServiceGetOne($id): JsonResponse
    {
        return response()->json(app(Mmanuales::class)->getOneManual($id));
    }
    
    public function delete($id): JsonResponse
    {
        app(Mmanuales::class)->delete(['id' => $id]);
        return response()->json(['success' => true]);
    }

    public function getAll(): JsonResponse
    {
        return response()->json(app(Mmanuales::class)->getAll());
    }
    
    public function getOne(Request $request, $id = ''): JsonResponse
    {
        $data = $request->all();
        if ($id != '') {
            $data['id'] = $id;
        }
        return response()->json(app(Mmanuales::class)->getOne($data));
    }
    
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|min:4|unique:manuales,descripcion',
            'url' => 'required|min:4|unique:manuales,url',
        ]);

        if (!$validator->fails()) {
            if ($result = app(Mmanuales::class)->add($request->all())) {
                return response()->json(['result' => $result]);
            }
        } else {
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }
    
    public function update(Request $request): JsonResponse
    {
        $manual = app(Mmanuales::class)->getOne($request->all());
        
        $rules = [
            'descripcion' => 'required|min:4',
        ];
        
        if ($manual->url == $request->input('url')) {
            $rules['url'] = 'required|min:4';
        } else {
            $rules['url'] = 'required|min:4|unique:manuales,url';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if (!$validator->fails()) {
            app(Mmanuales::class)->update($request->all());
            return response()->json([
                "caso" => 1
            ]);
        } else {
            return response()->json([
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ]);
        }
    }

    public function activate(Request $request): JsonResponse
    {
        // app(Mmanuales::class)->activate($request->all());
        return response()->json(['success' => true]);
    }
    
    public function show()
    {
        $manuales_activos = app(Mmanuales::class)->get();
        return view('manuales.detalle_consulta', ['manuales_activos' => $manuales_activos]);
    }
}