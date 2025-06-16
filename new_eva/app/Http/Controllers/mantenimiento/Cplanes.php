<?php

namespace App\Http\Controllers\mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mplanes;
use App\Models\Mequipos;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PlanesController extends Controller
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

        foreach ($acciones as $accion) {
            if ($accion->modulo == "planes mantenimiento") {
                if ($accion->leer != 1) {
                    return redirect('forbidden');
                }
            }
        }

        $data = app(Mplanes::class)->getAll();
        $planes = [
            "planes" => $data,
        ];

        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'mantenimientos.list', $planes)
            ->nest('modal_edit', 'mantenimientos.modal_edit')
            ->nest('modal_cambios', 'mantenimientos.modal_cambios')
            ->nest('footer', 'layouts.footer');
    }

    public function getOne(Request $request)
    {
        return response()->json(app(Mplanes::class)->getOne($request->all()));
    }

    public function get_server_side(Request $request)
    {
        if ($request->has('start')) {
            $vector = app(Mplanes::class)->get_server_side($request->all());
            $respuesta = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $vector['num_filas_limit'],
                'recordsFiltered' => $vector['num_filas'],
                'data' => $vector['datos']
            ];
            
            return response()->json($respuesta);
        }
        
        return response()->json(['error' => 'Invalid request']);
    }

    public function getAnios()
    {
        return response()->json(app(Mplanes::class)->getAnios());
    }

    public function ImportFromExcel(Request $request)
    {
        $file = $request->file('file');
        $anio = $request->input('anio_cronograma');
        $reemplazar = $request->input('reemplazar');
        
        $excelReader = IOFactory::createReaderForFile($file->getPathname());
        $excelObj = $excelReader->load($file->getPathname());
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();
        $temporal = "";
        
        if ($reemplazar == "si") {
            app(Mplanes::class)->deleteYear($anio);
        }
        
        $usuario_id = Auth::id();
        
        for ($i = 2; $i <= $lastRow; $i++) {
            app(Mplanes::class)->deleteAnterior([
                "equipo_id" => $worksheet->getCell('A' . $i)->getValue(), 
                "anio" => $anio
            ]);
            
            $vector_insertar = [
                "equipo_id" => $worksheet->getCell('A' . $i)->getValue(),
                "anio" => $anio,
                "mes1" => $worksheet->getCell('B' . $i)->getValue(),
                "mes2" => $worksheet->getCell('C' . $i)->getValue(),
                "mes3" => $worksheet->getCell('D' . $i)->getValue(),
                "responsable" => $worksheet->getCell('E' . $i)->getValue(),
                "frecuencia_id" => $worksheet->getCell('F' . $i)->getValue(),
                "usuario_id" => $usuario_id
            ];
            
            app(Mplanes::class)->add($vector_insertar);
        }
        
        app(Mequipos::class)->updateEstadomAutomatico();
        
        return response()->json($temporal);
    }

    public function update(Request $request)
    {
        $anterior = app(Mplanes::class)->getOne($request->all())[0];
        $contador = 0;
        $cambio = "";

        if ($anterior->mes1 != $request->input('mes1')) {
            $contador++;
            $cambio .= "(mes 1: " . $anterior->mes1 . "->" . $request->input('mes1') . ")";
        }
        
        if ($anterior->mes2 != $request->input('mes2')) {
            $contador++;
            $cambio .= "(mes 2: " . $anterior->mes2 . "->" . $request->input('mes2') . ")";
        }
        
        if ($anterior->mes3 != $request->input('mes3')) {
            $contador++;
            $cambio .= "(mes 3: " . $anterior->mes3 . "->" . $request->input('mes3') . ")";
        }
        
        if ($anterior->responsable != $request->input('responsable')) {
            $contador++;
            $cambio .= "(Responsable: " . $anterior->responsable . "->" . $request->input('responsable') . ")";
        }
        
        if ($contador > 0) {
            app(Mplanes::class)->addControlCambio([
                "planes_mantenimientos_id" => $anterior->id, 
                "cambio" => $cambio, 
                "usuario_id" => Auth::id()
            ]);
        }

        app(Mplanes::class)->update($request->all());
        
        return response()->json(['success' => true]);
    }

    public function getCambios(Request $request)
    {
        return response()->json(app(Mplanes::class)->getCambios($request->all()));
    }

    public function ExportarExcel()
    {
        $planes_mantenimientos = app(Mplanes::class)->getAll();
        
        return new StreamedResponse(function() use ($planes_mantenimientos) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            echo '<table class="table table-bordered" border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Fecha de creación del registro</th>';
            echo '<th>Usuario responsable</th>';
            echo '<th>Fecha de la ultima actualización</th>';
            echo '<th>Ultima edición realizada</th>';
            echo '<th>Responsable de la edición</th>';
            echo '<th>Equipo Id</th>';
            echo '<th>Nombre</th>';
            echo '<th>Marca</th>';
            echo '<th>Modelo</th>';
            echo '<th>Serie</th>';
            echo '<th>Codigo</th>';
            echo '<th>Servicio</th>';
            echo '<th>Area</th>';
            echo '<th>Sede</th>';
            echo '<th>Propiedad</th>';
            echo '<th>Año vigencia mantenimiento</th>';
            echo '<th>Frecuencia de mantenimiento</th>';
            echo '<th>Mes1</th>';
            echo '<th>Mes2</th>';
            echo '<th>Mes3</th>';
            echo '<th>Responsable del mantenimiento</th>';
            echo '<th>Cantidad de preventivos realizados en el año</th>';
            echo '<th>Soporte primer visita</th>';
            echo '<th>Fecha primer visita</th>';
            echo '<th>Soporte segunda visita</th>';
            echo '<th>Fecha segunda visita</th>';
            echo '<th>Soporte tercer visita</th>';
            echo '<th>Fecha tercer visita</th>';
            echo '<th>Soporte cuarta visita</th>';
            echo '<th>Fecha cuarta visita</th>';
            echo '<th>Estado del equipo</th>';
            echo '<th>Estado del mantenimiento</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($planes_mantenimientos as $plan_mantenimiento) {
                echo '<tr>';
                echo '<td>' . $plan_mantenimiento->created_at . '</td>';
                echo '<td>' . $plan_mantenimiento->usuario . '</td>';
                echo '<td>' . $plan_mantenimiento->fecha_actualizacion . '</td>';
                echo '<td>' . $plan_mantenimiento->cambio . '</td>';
                echo '<td>' . $plan_mantenimiento->usuario_editor . '</td>';
                echo '<td>' . $plan_mantenimiento->equipo_id . '</td>';
                echo '<td>' . $plan_mantenimiento->name . '</td>';
                echo '<td>' . $plan_mantenimiento->marca . '</td>';
                echo '<td>' . $plan_mantenimiento->modelo . '</td>';
                echo '<td>sn: ' . $plan_mantenimiento->serial . '</td>';
                echo '<td>' . $plan_mantenimiento->code . '</td>';
                echo '<td>' . $plan_mantenimiento->servicio . '</td>';
                echo '<td>' . $plan_mantenimiento->area . '</td>';
                echo '<td>' . $plan_mantenimiento->sede . '</td>';
                echo '<td>' . $plan_mantenimiento->propiedad . '</td>';
                echo '<td>' . $plan_mantenimiento->anio . '</td>';
                echo '<td>' . $plan_mantenimiento->frecuencia . '</td>';
                echo '<td>' . $plan_mantenimiento->mes1 . '</td>';
                echo '<td>' . $plan_mantenimiento->mes2 . '</td>';
                echo '<td>' . $plan_mantenimiento->mes3 . '</td>';
                echo '<td>' . $plan_mantenimiento->responsable . '</td>';
                echo '<td>' . $plan_mantenimiento->realizados . '</td>';
                echo '<td>' . $plan_mantenimiento->primer_visita . ' - ' . $plan_mantenimiento->proveedor_primer_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->fecha_primer_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->segunda_visita . ' - ' . $plan_mantenimiento->proveedor_segunda_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->fecha_segunda_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->tercer_visita . ' - ' . $plan_mantenimiento->proveedor_tercer_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->fecha_tercer_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->cuarta_visita . ' - ' . $plan_mantenimiento->proveedor_cuarta_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->fecha_cuarta_visita . '</td>';
                echo '<td>' . $plan_mantenimiento->estadoequipo . '</td>';
                echo '<td>' . $plan_mantenimiento->estado_mantenimiento . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        }, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=iso-8859-1',
            'Content-Disposition' => 'attachment; filename=Cronograma_mantenimiento.xls',
        ]);
    }

    public function getListadoResponsables()
    {
        return response()->json(app(Mplanes::class)->getListadoResponsables());
    }
}