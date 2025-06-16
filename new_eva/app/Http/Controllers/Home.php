<?php

namespace App\Http\Controllers;

use App\Models\Mequipos;
use App\Models\Mguias;
use App\Models\Mcambios_hdv;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private Mequipos $Mequipos;
    private Mguias $Mguias;
    private Mcambios_hdv $Mcambios_hdv;
    
    public function __construct()
    {
        $this->middleware('auth');
        
        if (!Session::has('id')) {
            redirect('auth');
        }
        
        $this->Mequipos = new Mequipos();
        $this->Mguias = new Mguias();
        $this->Mcambios_hdv = new Mcambios_hdv();
    }
    
    public function index()
    {
        // $this->Mequipos->updateEstadomAutomatico();
        $this->Mequipos->depurarCodigo();
        $this->Mcambios_hdv->depurarCodigo();
        
        $fecha_actual = date("Y-m-d");
        $vector = [
            "estado_mantenimiento" => 2
        ];
        
        $this->Mequipos->UpdateEstadom($fecha_actual, $vector);
        
        $vector = [
            "plan" => 3
        ];
        
        $this->Mequipos->UpdatePlan($vector);
        
        $guias_rapidas = $this->Mguias->getWithQuery();
        $vector_guias = [
            "guias" => $guias_rapidas
        ];
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'admin.home', $vector_guias)
            ->nest('modal', 'guias.modal_show_relacionar_guia')
            ->nest('footer', 'layouts.footer');
    }
    
    public function relacionar_con_equipos(Request $request): JsonResponse
    {
        return response()->json($request->all());
    }
}