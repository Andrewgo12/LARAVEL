<?php

namespace App\Http\Controllers\ordenes_compra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mequipos;
use App\Models\Mordenes_compra;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OrdenesCompraController extends Controller
{
    private Mequipos $Mequipos;
    private Mordenes_compra $Mordenes_compra;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mordenes_compra = new Mordenes_compra();
    }
    
    public function consultar_secop()
    {
        $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?nombre_de_la_entidad=VALLE%20DEL%20CAUCA%20%20ESE%20HOSPITAL%20UNIVERSITARIO%20DEL%20VALLE%20EVARISTO%20GARC%C3%8DA&$limit=10000';
        $json = file_get_contents($url);
        $array = json_decode($json, true);
        
        return view("ordenes_compra.modal_api_detalle", [
            "vector" => $array,
            "content" => $json
        ]);
    }
    
    public function index()
    {
        if (!session('login')) {
            return redirect('auth');
        }
        
        $acciones = session('acciones');
        session(['controlador' => request()->segment(2)]);
        
        foreach ($acciones as $accion) {
            if ($accion->modulo == "soportes compra") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }
        
        $data = [
            "ordenes_compra" => $this->Mordenes_compra->getAll()
        ];
        
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'ordenes_compra.list', $data)
            ->nest('modal_add', 'ordenes_compra.modal_add')
            ->nest('modal_edit', 'ordenes_compra.modal_edit')
            ->nest('modal_api', 'ordenes_compra.modal_api')
            ->nest('modal_asociacion_orden_compra', 'equipos.modal_asociacion_orden_compra')
            ->nest('modal_asociacion_orden_compra_especifico', 'equipos.modal_asociacion_orden_compra_especifico')
            ->nest('footer', 'layouts.footer');
    }
    
    public function getAll(): JsonResponse
    {
        return response()->json($this->Mordenes_compra->getAll());
    }
    
    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|min:4|unique:ordenes_compra,orden',
        ]);
        
        if (!$validator->fails()) {
            $data = $request->all();
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/upload_ordenes_compra'), $filename);
                $data['file'] = $filename;
            }
            
            if ($this->Mordenes_compra->add($data)) {
                return response()->json([
                    "caso" => 1
                ]);
            } else {
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_ordenes_compra/' . $data['file']));
                }
                return response()->json([
                    "caso" => 2,
                    "informacion_error" => "Error al guardar en la base de datos"
                ]);
            }
        } else {
            return response()->json([
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ]);
        }
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mordenes_compra->getOne($request->all()));
    }
    
    public function getWithNumberDevices(): JsonResponse
    {
        return response()->json($this->Mordenes_compra->getWithNumberDevices());
    }
    
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if (isset($data['secop_id']) && ($data['secop_id'] != 0)) {
            $url = 'https://www.datos.gov.co/resource/xvdy-vvsk.json?$query=%20SELECT%20*%20WHERE%20uid=%27' . $data['secop_id'] . '%27';
            $json = file_get_contents($url);
            $array = json_decode($json, true);
            $data['url_secop'] = $array[0]['ruta_proceso_en_secop_i']['url'];
        }
        
        $orden = $this->Mordenes_compra->getOne($data);
        
        $rules = [];
        if ($orden->orden == $data['orden']) {
            $rules['orden'] = 'required|min:4';
        } else {
            $rules['orden'] = 'required|min:4|unique:ordenes_compra,orden';
        }
        
        $validator = Validator::make($data, $rules);
        
        if (!$validator->fails()) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/upload_ordenes_compra'), $filename);
                $data['file'] = $filename;
            }
            
            if ($this->Mordenes_compra->update($data)) {
                return response()->json([
                    "caso" => 1
                ]);
            } else {
                if (isset($data['file'])) {
                    File::delete(public_path('assets/upload_ordenes_compra/' . $data['file']));
                }
                return response()->json([
                    "caso" => 2,
                    "informacion_error" => "Error al actualizar en la base de datos"
                ]);
            }
        } else {
            return response()->json([
                "caso" => 2,
                "informacion_error" => $validator->errors()->all()
            ]);
        }
    }
    
    public function show()
    {
        $ordenes_compra_activas = $this->Mordenes_compra->getActive();
        return view("ordenes_compra.detalle_consulta", [
            "ordenes_compra" => $ordenes_compra_activas
        ]);
    }
    
    public function show_ordenes_compra()
    {
        $activas = $this->Mordenes_compra->getOrdenesCompra();
        return view("ordenes_compra.detalle_consulta", [
            "ordenes_compra" => $activas
        ]);
    }
    
    public function show_contratos()
    {
        $activas = $this->Mordenes_compra->getContratos();
        return view("ordenes_compra.detalle_consulta", [
            "ordenes_compra" => $activas
        ]);
    }
    
    public function show_cruces_cuentas()
    {
        $activas = $this->Mordenes_compra->getCrucesCuentas();
        return view("ordenes_compra.detalle_consulta", [
            "ordenes_compra" => $activas
        ]);
    }
    
    public function show_comodatos()
    {
        $activas = $this->Mordenes_compra->getComodatos();
        return view("ordenes_compra.detalle_consulta", [
            "ordenes_compra" => $activas
        ]);
    }
    
    public function ExportarExcel($orden_compra_id)
    {
        $equipos = $this->Mequipos->getEquiposEnOrdenCompra(["orden_compra_id" => $orden_compra_id]);
        $orden_compra = $this->Mordenes_compra->getOne(["id" => $orden_compra_id]);
        
        header('Content-Type:application/xls;charset=utf-8');
        header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
        header('Content-Disposition: attachment;filename=SoporteCompra.xls');
        
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<strong>Soporte de adquisicion:</strong> = ' . $orden_compra->orden . '<br>';
        echo '<strong>Fecha:</strong> = ' . $orden_compra->fecha;
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Codigo</th>';
        echo '<th>Serie</th>';
        echo '<th>Marca</th>';
        echo '<th>Modelo</th>';
        echo '<th>Servicio de instalación</th>';
        echo '<th>Area de instalación</th>';
        echo '<th>Fecha de instalación</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($equipos as $equipo) {
            echo '<tr>';
            echo '<td>' . $equipo->id . '</td>';
            echo '<td>' . $equipo->name . '</td>';
            echo '<td>' . $equipo->code . '</td>';
            echo '<td>' . $equipo->serial . '</td>';
            echo '<td>' . $equipo->marca . '</td>';
            echo '<td>' . $equipo->modelo . '</td>';
            echo '<td>' . $equipo->servicio . '</td>';
            echo '<td>' . $equipo->area . '</td>';
            echo '<td>' . $equipo->fecha_instalacion . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    }
    
    public function ExportExcelAll()
    {
        $ordenes_compra = $this->Mordenes_compra->getWithNumberDevices();
        
        header('Content-Type:application/xls;charset=utf-8');
        header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
        header('Content-Disposition: attachment;filename=Adquisiciones.xls');
        
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Orden</th>';
        echo '<th>Fecha</th>';
        echo '<th>Proveedor</th>';
        echo '<th>Cantidad Equipos Asociaos en EVA</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($ordenes_compra as $orden_compra) {
            echo '<tr>';
            echo '<td>' . $orden_compra->orden . '</td>';
            echo '<td>' . $orden_compra->fecha . '</td>';
            echo '<td>' . $orden_compra->proveedor . '</td>';
            echo '<td>' . $orden_compra->cuenta . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    }
}