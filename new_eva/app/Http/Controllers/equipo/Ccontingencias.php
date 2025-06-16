<?php

namespace App\Http\Controllers\equipo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\Mequipos;
use App\Models\Mcontingencias;
use App\Models\Mbajas;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Ccontingencias extends Controller
{
    protected $Mequipos;
    protected $Mcontingencias;
    protected $Mbajas;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mcontingencias = new Mcontingencias();
        $this->Mbajas = new Mbajas();
    }
    
    public function index()
    {
        if (!Session::has('login')) {
            return redirect('Cauth');
        }
        
        Session::put('controlador', request()->segment(2));
        $acciones = Session::get('acciones');
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "contingencias") {
                if ($accion->leer != 1) {
                    return redirect('Home');
                }
            }
        }

        $data = [
            "contingencias" => $this->Mcontingencias->getAll()
        ];
        
        return view('layouts.app')
            ->with('header', view('layouts.header'))
            ->with('aside', view('layouts.aside'))
            ->with('content', view('contingencias.list', $data))
            ->with('modal_add', view('contingencias.modal_add'))
            ->with('modal_edit', view('contingencias.modal_edit'))
            ->with('footer', view('layouts.footer'));
    }
    
    public function get(Request $request): JsonResponse
    {
        return response()->json($this->Mcontingencias->get($request->all()));
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json($this->Mcontingencias->getAll());
    }

    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mcontingencias->getOne($request->all()));
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_contingencias'), $fileName);
            $data['file'] = $fileName;
        }
        
        $data['usuario_id'] = Session::get('id');

        if ($this->Mcontingencias->add($data)) {
            return response()->json(1);
        } else {
            if (isset($data['file'])) {
                File::delete(public_path('assets/upload_contingencias/' . $data['file']));
            }
            return response()->json(2);
        }
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
    
    public function close(Request $request): JsonResponse
    {
        $data = $request->all();
        $data["estado_id"] = 4;
        $data["fecha_cierre"] = date("Y-m-d");
        $this->Mcontingencias->update($data);
        
        return response()->json(1);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_contingencias'), $fileName);
            $data['file'] = $fileName;
        }
        
        if ($data["fecha_cierre"] == "") {
            $data["fecha_cierre"] = null;
        }
        
        if ($data["fecha"] == "") {
            $data["fecha"] = null;
        }

        $this->Mcontingencias->update($data);
        
        return response()->json(['success' => true]);
    }

    public function delete(Request $request): JsonResponse
    {
        $vector = [
            "id" => $request->input('id')
        ];
        
        $contingencia = $this->Mcontingencias->getOne($vector);
        $file = $contingencia->file;
        
        if ($this->Mcontingencias->delete($request->all())) {
            if ($file != "" && $file != null) {
                File::delete(public_path('assets/upload_contingencias/' . $file));
            }
        }
        
        return response()->json(1);
    }
    
    public function exportar(): StreamedResponse
    {
        $contingencias = $this->Mcontingencias->getAll();
        
        return new StreamedResponse(function() use ($contingencias) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            echo '<table border="1">';
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
            echo '<th>Codigo equipo</th>';
            echo '<th>Serie equipo</th>';
            echo '<th>Origen de la contingencia</th>';
            echo '<th>Estado</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($contingencias as $contingencia) {
                echo '<tr>';
                echo '<td>' . $contingencia->observacion . '</td>';
                echo '<td>' . $contingencia->fecha . '</td>';
                echo '<td>' . $contingencia->fecha_cierre . '</td>';
                echo '<td>' . $contingencia->usuario . '</td>';
                echo '<td>' . $contingencia->name . '</td>';
                echo '<td>' . $contingencia->marca . '</td>';
                echo '<td>' . $contingencia->modelo . '</td>';
                echo '<td>' . $contingencia->codigo . '</td>';
                echo '<td>';
                if ($contingencia->serial != "") {
                    echo "sn: " . $contingencia->serial;
                }
                echo '</td>';
                echo '<td>';
                if ($contingencia->tipo == "") {
                    echo "Otras contingencias";
                } else {
                    echo $contingencia->tipo;
                }
                echo '</td>';
                echo '<td>' . $contingencia->estado . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        }, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=Contingencias.xls',
        ]);
    }
}
  ?>

