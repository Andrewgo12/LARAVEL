<?php

namespace App\Http\Controllers\calibracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mequipos;
use App\Models\Mcalibraciones;
use App\Models\Mcambios_hdv;
use App\Models\Mpreventivos;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Ccalibraciones extends Controller
{
    private Mequipos $Mequipos;
    private Mcalibraciones $Mcalibraciones;
    private Mcambios_hdv $Mcambios_hdv;
    private Mpreventivos $Mpreventivos;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mcalibraciones = new Mcalibraciones();
        $this->Mcambios_hdv = new Mcambios_hdv();
        $this->Mpreventivos = new Mpreventivos();
    }
    
    public function index()
    {
    }
    
    public function get(Request $request): JsonResponse
    {
        return response()->json($this->Mcalibraciones->get($request->all()));
    }
    
    public function getAll()
    {
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mcalibraciones->getOne($request->all()));
    }
    
    public function getLast(Request $request): JsonResponse
    {
        return response()->json($this->Mpreventivos->getLast($request->all()));
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_calibraciones'), $fileName);
            $data['file'] = $fileName;
        }
        
        $ultimo_id = $this->Mcalibraciones->add($data);
        
        // Se inserta el registro de cambio de HDV
        $descripcion_historial = "Se agrega calibracion con codigo = " . $this->Mcalibraciones->getOne(["id" => $ultimo_id])->description;
        $vector_cambios_hdv = [
            "descripcion" => $descripcion_historial,
            "usuario_id" => Auth::id(),
            "equipo_id" => $data["equipo_id"]
        ];
        $this->Mcambios_hdv->add($vector_cambios_hdv);
        
        return response()->json($data["equipo_id"]);
    }
    
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if (isset($data['id'])) {
            $calibracion = $this->Mcalibraciones->getOne($data);
            $file_anterior = $calibracion->file;
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/upload_calibraciones'), $fileName);
                $data['file'] = $fileName;
            }
            
            if ($this->Mcalibraciones->update($data)) {
                // Se inserta el registro de cambio de HDV
                $descripcion_historial = "Se actualiza calibracion con codigo = " . $calibracion->description;
                $vector_cambios_hdv = [
                    "descripcion" => $descripcion_historial,
                    "usuario_id" => Auth::id(),
                    "equipo_id" => $calibracion->equipo_id
                ];
                $this->Mcambios_hdv->add($vector_cambios_hdv);
                
                if (isset($data["file"]) && $data["file"] != $file_anterior && !empty($file_anterior)) {
                    File::delete(public_path('assets/upload_calibraciones/' . $file_anterior));
                }
                
                return response()->json($data["equipo_id"]);
            } else {
                if (isset($data["file"])) {
                    File::delete(public_path('assets/upload_calibraciones/' . $data["file"]));
                }
                
                return response()->json(['error' => 'No se pudo actualizar'], 500);
            }
        }
        
        return response()->json(['error' => 'ID no proporcionado'], 400);
    }

    public function delete(Request $request): JsonResponse
    {
        $vector = [
            "id" => $request->input("id")
        ];
        
        $calibracion = $this->Mcalibraciones->getOne($vector);
        $file = $calibracion->file;
        
        if ($this->Mcalibraciones->delete($request->all())) {
            // Se inserta el registro de cambio de HDV
            $descripcion_historial = "Se elimina calibracion con codigo = " . $calibracion->description;
            $vector_cambios_hdv = [
                "descripcion" => $descripcion_historial,
                "usuario_id" => Auth::id(),
                "equipo_id" => $calibracion->equipo_id
            ];
            $this->Mcambios_hdv->add($vector_cambios_hdv);
            
            if ($file != "" && $file != null) {
                File::delete(public_path('assets/upload_calibraciones/' . $file));
            }
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'No se pudo eliminar'], 500);
    }

    public function show(): View
    {
        $vector = [
            'calibraciones' => $this->Mcalibraciones->getCalibracionesModal()
        ];
        
        return view("calibraciones.detail", $vector);
    }

    public function ExportarExcel(): StreamedResponse
    {
        $calibraciones = $this->Mcalibraciones->getCalibracionesAll();
        
        return response()->stream(function() use ($calibraciones) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Codigo calibracion</th>';
            echo '<th>Fecha de ejecucion</th>';
            echo '<th>Marca</th>';
            echo '<th>Codigo</th>';
            echo '<th>Serie</th>';
            echo '<th>Nombre equipo</th>';
            echo '<th>Id equipo</th>';
            echo '<th>Archivo</th>';
            echo '<th>Ubicación</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($calibraciones as $calibracion) {
                echo '<tr>';
                echo '<td>' . $calibracion->codigo . '</td>';
                echo '<td>' . $calibracion->fecha_ejecucion . '</td>';
                echo '<td>' . $calibracion->marca . '</td>';
                echo '<td>' . $calibracion->code . '</td>';
                echo '<td>SN:&nbsp;' . $calibracion->serial . '</td>';
                echo '<td>' . $calibracion->name . '</td>';
                echo '<td>' . $calibracion->id . '</td>';
                echo '<td>' . $calibracion->archivocalibracion . '</td>';
                echo '<td>' . $calibracion->ubicacion . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        }, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=iso-8859-1',
            'Content-Disposition' => 'attachment; filename=CalibracionesEB.xls',
        ]);
    }
}

