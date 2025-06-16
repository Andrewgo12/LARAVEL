<?php

namespace App\Http\Controllers\tecnico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use App\Models\Mtecnicos;

class CtecnicosController extends Controller
{
    private $permisos;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Session::get('login')) {
            return redirect()->route('auth.login');
        }

        $mtecnicos = app(Mtecnicos::class);

        $data = [
            "tecnicos" => $mtecnicos->get()
        ];

        return view("tecnicos.list", $data);
    }

    public function get(): JsonResponse
    {
        $mtecnicos = app(Mtecnicos::class);
        return response()->json($mtecnicos->get());
    }

    public function getFromTrabajos(Request $request): JsonResponse
    {
        $mtecnicos = app(Mtecnicos::class);
        return response()->json($mtecnicos->getFromTrabajos($request->all()));
    }

    public function show(Request $request)
    {
        $mtecnicos = app(Mtecnicos::class);
        $result = $mtecnicos->getOne($request->input('id'));

        $param = [
            'categoria' => $result
        ];

        return view('categorias.detail', $param);
    }
}
