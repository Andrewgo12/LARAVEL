<?php

namespace App\Http\Controllers\correctivo_general;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Models\Mequipos;
use App\Models\Mcorrectivos_generales;
use App\Models\Mcorrectivos_generales_archivos;
use App\Models\Mordenes;
use App\Models\Mpreventivos;
use App\Models\Mavances_correctivos;
use App\Models\Mservicios;
use App\Models\Mzonas;
use App\Models\Mequipo_repuestos;
use App\Models\Mcambios_hdv;
use App\Models\Mrepuestos_ti;
use App\Models\Mrepuestos_pendientes;
use Illuminate\Http\JsonResponse;

class Ccorrectivos_generales extends Controller
{
    private $Mequipos;
    private $Mcorrectivos_generales;
    private $Mcorrectivos_generales_archivos;
    private $Mordenes;
    private $Mpreventivos;
    private $Mavances_correctivos;
    private $Mservicios;
    private $Mzonas;
    private $Mequipo_repuestos;
    private $Mcambios_hdv;
    private $Mrepuestos_ti;
    private $Mrepuestos_pendientes;
    
    public function __construct()
    {
        $this->Mequipos = new Mequipos();
        $this->Mcorrectivos_generales = new Mcorrectivos_generales();
        $this->Mcorrectivos_generales_archivos = new Mcorrectivos_generales_archivos();
        $this->Mordenes = new Mordenes();
        $this->Mpreventivos = new Mpreventivos();
        $this->Mavances_correctivos = new Mavances_correctivos();
        $this->Mservicios = new Mservicios();
        $this->Mzonas = new Mzonas();
        $this->Mequipo_repuestos = new Mequipo_repuestos();
        $this->Mcambios_hdv = new Mcambios_hdv();
        $this->Mrepuestos_ti = new Mrepuestos_ti();
        $this->Mrepuestos_pendientes = new Mrepuestos_pendientes();
    }
    
    public function index()
    {
        // Implementar según necesidad
    }
    
    public function get(Request $request): JsonResponse
    {
        return response()->json($this->Mcorrectivos_generales->get($request->all()));
    }
    
    public function getAll()
    {
        // Implementar según necesidad
    }
    
    public function getOne(Request $request): JsonResponse
    {
        return response()->json($this->Mcorrectivos_generales->getOne($request->all()));
    }
    
    public function add(Request $request): JsonResponse
    {
        $data = $request->all();
        $lista_repuestos_pendientes = null;
        
        if (isset($data["lista_repuestos_pendientes"])) {
            $lista_repuestos_pendientes = $data["lista_repuestos_pendientes"];
            unset($data["lista_repuestos_pendientes"]);
        }

        // Subida de archivo de repuesto instalado
        if ($request->hasFile('file_repuesto_instalado')) {
            $file = $request->file('file_repuesto_instalado');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_equipo_repuestos'), $fileName);
            $data["file_repuesto_instalado"] = $fileName;
        } else {
            $data["file_repuesto_instalado"] = null;
        }
        
        if ($data["repuesto_id_instalado"] != "" && $data["repuesto_id_instalado"] != null) {
            $vector_repuesto_instalado = [
                "repuesto_id" => $data["repuesto_id_instalado"],
                "equipo_id" => $data["equipo_id"],
                "cantidad_entregada" => $data["cantidad_entregada"],
                "fecha" => $data["fecha"],
                "file" => $data["file_repuesto_instalado"],
                "observacion" => $data["observacion"],
                "usuario_id" => Session::get("id")
            ];
            $this->Mequipo_repuestos->add($vector_repuesto_instalado);
        }
        
        // Limpieza de datos
        unset($data["repuesto_id_instalado"]);
        unset($data["cantidad_entregada"]);
        unset($data["fecha"]);
        unset($data["observacion"]);
        unset($data["file_repuesto_instalado"]);
        
        // Subida de archivo de correctivo general
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_correctivos_generales'), $fileName);
            $data["file"] = $fileName;
        }
        
        // Formateo de fechas
        if (isset($data["fecha_inicio"])) {
            $data["fecha_inicio"] = $data["fecha_inicio"] . " " . $data["hora_orden"];
            unset($data["hora_orden"]);
        }
        
        if (isset($data["fecha_diagnostico"])) {
            $data["fecha_diagnostico"] = $data["fecha_diagnostico"] . " " . $data["hora_diagnostico"];
            unset($data["hora_diagnostico"]);
        }
        
        if (isset($data["fecha_mantenimiento"])) {
            $data["fecha_mantenimiento"] = $data["fecha_mantenimiento"] . " " . $data["hora_mantenimiento"];
            unset($data["hora_mantenimiento"]);
        }
        
        $titulo = $data["titulo"];
        unset($data["titulo"]);
        
        // Manejo de repuesto pendiente
        if ($data["repuesto_id"] != "" && $data["repuesto_id"] != null) {
            $data["repuesto_pendiente"] = "si";
            $vector_actualizacion_equipo = [
                "id" => $data["equipo_id"],
                "repuesto_pendiente" => "si"
            ];
            $this->Mequipos->update($vector_actualizacion_equipo);
        } else {
            unset($data["repuesto_id"]);
        }
        
        // Lógica para ingresar avance
        $existe_descripcion = "";
        $vector_avance_correctivo = null;
        
        if (isset($data["descripcion_avance"]) && ($data["descripcion_avance"] != "")) {
            $existe_descripcion = "si";
            $vector_avance_correctivo = [
                "description" => $data["descripcion_avance"],
                "date" => $data["fecha_avance"],
                "title" => $data["titulo_avance"],
                "usuario_id" => Session::get("id")
            ];
            
            if (isset($data["file"])) {
                $vector_avance_correctivo["file"] = $data["file"];
            } else {
                $vector_avance_correctivo["file"] = "";
            }
            
            unset($data["descripcion_avance"]);
        }
        
        unset($data["fecha_avance"]);
        unset($data["titulo_avance"]);
        unset($data["descripcion_avance"]);
        
        // Agregar correctivo y obtener ID
        $ultimo_id = $this->Mcorrectivos_generales->add($data);
        
        // Agregar repuestos pendientes
        if ($lista_repuestos_pendientes) {
            foreach ($lista_repuestos_pendientes as $repuesto_pendiente) {
                $this->Mrepuestos_pendientes->add([
                    "correctivo_general_id" => $ultimo_id,
                    "name" => $repuesto_pendiente
                ]);
            }
        }
        
        // Agregar avance si existe
        if ($existe_descripcion == "si") {
            $vector_avance_correctivo["correctivo_general_id"] = $ultimo_id;
            $this->Mavances_correctivos->add($vector_avance_correctivo);
        }
        
        // Registrar en historial
        $descripcion_historial = "Se agrega correctivo general con ID = " . $this->Mcorrectivos_generales->getOne(["id" => $ultimo_id])->id;
        $vector_cambios_hdv = [
            "descripcion" => $descripcion_historial,
            "usuario_id" => Session::get("id"),
            "equipo_id" => $this->Mcorrectivos_generales->getOne(["id" => $ultimo_id])->equipo_id
        ];
        $this->Mcambios_hdv->add($vector_cambios_hdv);
        
        // Agregar archivo si existe
        if (isset($data["file"])) {
            $vector = [
                "file" => $data["file"],
                "correctivo_general_id" => $ultimo_id,
                "titulo" => $titulo
            ];
            $this->Mcorrectivos_generales_archivos->add($vector);
        }
        
        // Preparar respuesta
        $vector_respuesta = [
            "correctivo_general_id" => $ultimo_id,
            "equipo_id" => $data["equipo_id"]
        ];
        
        if (isset($vector_actualizacion_equipo)) {
            $vector_respuesta["repuesto_pendiente"] = $data["repuesto_id"];
        }
        
        return response()->json($vector_respuesta);
    }
    
    public function send_email_correctivo_general(Request $request)
    {
        $data = $request->all();
        $equipo = $this->Mequipos->getOne(["id" => $data["equipo_id"]]);
        $correctivo_general = $this->Mcorrectivos_generales->getOne(["id" => $data["correctivo_general_id"]]);
        $servicio = $this->Mservicios->getOne(["id" => $equipo->servicio_id]);
        $correos = $this->Mzonas->get_emails_with_service(["servicio_id" => $servicio->id]);

        $to = "";
        $contador = 0;
        $limite = $correos["cantidad"];
        $control = true;

        if ($limite == 1) {
            $to .= $correos["correos"][0]->correo_usuario;
        } elseif ($limite > 1) {
            foreach ($correos["correos"] as $correo) {
                $contador = $contador + 1;
                if ($contador != $limite) {
                    $to .= $correo->correo_usuario . ",";
                } else {
                    $to .= $correo->correo_usuario;
                }
            }
        } else {
            $control = false;
        }
        
        if ($control) {
            $vector_correo = [
                "equipo" => $equipo,
                "correctivo_general" => $correctivo_general,
                "correos" => $correos,
                "servicio" => $servicio
            ];
            
            $view = View::make("correctivos_generales.email.email_add_correctivo_general", $vector_correo)->render();
            
            Mail::send([], [], function ($message) use ($to, $correctivo_general, $view) {
                $message->to($to)
                    ->subject("Notificación de repuesto pendiente. ID orden:" . $correctivo_general->id)
                    ->from('evagestionahuv@gmail.com', "Repuesto pendiente")
                    ->setBody($view, 'text/html');
            });
        }
    }
    
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();
        
        // Manejo de repuestos pendientes
        if (isset($data["lista_repuestos_pendientes"])) {
            foreach ($data["lista_repuestos_pendientes"] as $repuesto_pendiente) {
                $this->Mrepuestos_pendientes->add([
                    "correctivo_general_id" => $data["id"],
                    "name" => $repuesto_pendiente
                ]);
            }
            unset($data["lista_repuestos_pendientes"]);
        }
        
        $correctivo_general_id = $data["id"];
        $correctivo_general_antiguo = $this->Mcorrectivos_generales->getOne(["id" => $correctivo_general_id]);
        $titulo = $data["titulo"];
        unset($data["titulo"]);
        
        // Formateo de fechas
        if (isset($data["fecha_inicio"])) {
            $data["fecha_inicio"] = $data["fecha_inicio"] . " " . $data["hora_orden"];
            unset($data["hora_orden"]);
        }
        
        if (isset($data["fecha_diagnostico"])) {
            $data["fecha_diagnostico"] = $data["fecha_diagnostico"] . " " . $data["hora_diagnostico"];
            unset($data["hora_diagnostico"]);
        }
        
        if (isset($data["fecha_mantenimiento"])) {
            $data["fecha_mantenimiento"] = $data["fecha_mantenimiento"] . " " . $data["hora_mantenimiento"];
            unset($data["hora_mantenimiento"]);
        }
        
        unset($data["repuesto_pendiente"]);
        
        // Verificar cambios en repuesto pendiente
        $cambio = "no";
        if ($data["repuesto_id"] != $correctivo_general_antiguo->repuesto_id) {
            $cambio = "si";
        }
        if ($data["repuesto_id"] == "" || $data["repuesto_id"] == null) {
            $cambio = "no";
        }
        
        $this->Mcorrectivos_generales->update($data);
        
        // Registrar en historial
        $descripcion_historial = "Se edita correctivo general con ID = " . $correctivo_general_id;
        $vector_cambios_hdv = [
            "descripcion" => $descripcion_historial,
            "usuario_id" => Session::get("id"),
            "equipo_id" => $data["equipo_id"]
        ];
        $this->Mcambios_hdv->add($vector_cambios_hdv);
        
        // Preparar respuesta
        $vector_respuesta = [
            "equipo_id" => $data["equipo_id"],
            "correctivo_general_id" => $correctivo_general_id,
            "cambio" => $cambio,
            "actual" => $data["repuesto_id"],
            "antiguo" => $correctivo_general_antiguo->repuesto_id
        ];
        
        // Subida de archivo
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_correctivos_generales'), $fileName);
            $data["file"] = $fileName;
            
            $vector = [
                "file" => $data["file"],
                "correctivo_general_id" => $correctivo_general_id,
                "titulo" => $titulo
            ];
            $this->Mcorrectivos_generales_archivos->add($vector);
        }
        
        return response()->json($vector_respuesta);
    }
    
    public function delete(Request $request)
    {
        $data = $request->all();
        $resultados = $this->Mcorrectivos_generales_archivos->getAll($data);
        
        foreach ($resultados as $resultado) {
            if ($this->Mcorrectivos_generales_archivos->delete($resultado->id)) {
                File::delete(public_path('assets/upload_correctivos_generales/' . $resultado->file));
            }
        }
        
        $correctivo_general = $this->Mcorrectivos_generales->getOne(["id" => $data["id"]]);
        $this->Mcorrectivos_generales->delete($data);
        
        // Registrar en historial
        $descripcion_historial = "Se elimina correctivo general con ID = " . $correctivo_general->id;
        $vector_cambios_hdv = [
            "descripcion" => $descripcion_historial,
            "usuario_id" => Session::get("id"),
            "equipo_id" => $correctivo_general->equipo_id
        ];
        $this->Mcambios_hdv->add($vector_cambios_hdv);
        
        // Actualizar estado de repuesto pendiente
        $equipo_id = $data["equipo_id"];
        $cantidad_correctivos_generales = $this->Mcorrectivos_generales->cuenta_registros_repuestos_pendientes($equipo_id)->total;
        $cantidad_preventivos = $this->Mpreventivos->cuenta_registros_repuestos_pendientes($equipo_id)->total;
        $suma = $cantidad_preventivos + $cantidad_correctivos_generales;
        
        if ($suma != 0) {
            $this->Mequipos->repuesto_pendiente_true($equipo_id);
        } else {
            $this->Mequipos->repuesto_pendiente_false($equipo_id);
        }
    }
    
    public function show()
    {
        $vector = [
            'correctivos' => $this->Mcorrectivos_generales->getCorrectivosModal()
        ];
        
        return view("correctivos_generales.detail", $vector);
    }
    
    public function show_one(Request $request)
    {
        $data = $request->all();
        $data["correctivo_general_id"] = $data["id"];
        
        $vector = [
            "correctivo" => $this->Mcorrectivos_generales->getOne($data),
            "avances" => $this->Mavances_correctivos->GetByDevice($data),
            "archivos" => $this->Mcorrectivos_generales_archivos->get($data)
        ];
        
        return view("correctivos_generales.detail_single", $vector);
    }
    
    public function show_correctivos_generales_abiertos()
    {
        return view("correctivos_generales.detalle.detalle_correctivos_generales_abiertos");
    }
    
    public function get_datatable_server_side_correctivos_generales_abiertos(Request $request): JsonResponse
    {
        $data = $request->all();
        
        if (isset($data['start'])) {
            $vector = $this->Mcorrectivos_generales->get_correctivos_generales_abiertos_server_side($data);
            $respuesta = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $vector['num_filas_limit'],
                'recordsFiltered' => $vector['num_filas'],
                'data' => $vector['datos']
            ];
            return response()->json($respuesta);
        }
    }
    public function get_repuestos_pendientes()
    {
        if (isset($_POST)) {
            $listado = $this->Mrepuestos_pendientes->getAll($_POST);
            echo json_encode($listado);
        }
    }
    public function toggle_state_repuesto_pendiente()
    {
        $this->Mrepuestos_pendientes->toggle_state_repuesto_pendiente($_POST);
        $repuesto_pendiente = $this->Mrepuestos_pendientes->getOne($_POST);
        echo json_encode($repuesto_pendiente);
    }
    public function ExportarExcel()
    {
        header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
        header('Content-Disposition: attachment;filename=CorrectivosEB.xls');
        $correctivos_generales = $this->Mcorrectivos_generales->getCorrectivosModal();
        $tickets = $this->Mordenes->getOrdenesForCorrectivos();
?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <table border="1">
            <thead>
                <tr>
                    <th>Fuente</th>
                    <th>Responsable del mantenimiento</th>
                    <th>Equipo Id</th>
                    <th>Fecha de creación de la orden</th>
                    <th>Codigo de orden de trabajo</th>
                    <th>Descripcion de la orden</th>
                    <th>Codificación de cierre</th>
                    <th>Equipo</th>
                    <th>Codigo Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Estado actual del equipo</th>
                    <th>Sede</th>
                    <th>Servicio</th>
                    <th>Area</th>
                    <th>Archivo</th>
                    <th>Fecha avance</th>
                    <th>Titulo/Retro Avance1</th>
                    <th>Descripcion avance</th>
                    <th>Fecha avance2</th>
                    <th>Titulo/Retro Avance2</th>
                    <th>Descripcion avance2</th>
                    <th>Fecha avance3</th>
                    <th>Titulo/Retro Avance3</th>
                    <th>Descripcion avance3</th>
                    <th>Retro de cierre</th>
                    <th>Descripcion de Cierre</th>
                    <th>Fecha de Cierre</th>
                    <th>Costo del equipo</th>
                    <th>Fecha fin</th>
                    <th>Repuesto instalado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($correctivos_generales as $correctivo) : ?>
                    <tr>
                        <td>Correctivos generales</td>
                        <td><?php echo $correctivo->responsable_mantenimiento; ?></td>
                        <td><?php echo $correctivo->equipo_id ?></td>
                        <td><?php echo $correctivo->fecha_inicio; ?></td>
                        <td><?php echo $correctivo->code_orden; ?></td>
                        <td><?php echo $correctivo->orden; ?></td>
                        <td>
                            <?php if ($correctivo->code_orden != "" && $correctivo->code_orden != null) : ?>

                                <!-- 								<?php if (($correctivo->descripcion == "" || $correctivo->descripcion == null) && ($correctivo->codigo_correctivo == "" || $correctivo->codigo_correctivo == null) && ($correctivo->fecha_ejecucion == '' || $correctivo->fecha_ejecucion == null)) : ?>
                                <?php else : ?>
                                        <?php echo $correctivo->codificacion; ?>
                                    <?php echo $correctivo->descripcion_codificacion; ?>
                                    <?php endif ?> -->
                                <?php echo $correctivo->descripcion_codificacion; ?>
                            <?php else : ?>
                                <span>Sin Info de orden de trabajo</span>
                            <?php endif ?>
                        </td>
                        <td><?php echo $correctivo->equipo; ?></td>
                        <td><?php echo $correctivo->code; ?></td>
                        <td><?php echo $correctivo->marca; ?></td>
                        <td><?php echo $correctivo->modelo; ?></td>
                        <td>SN:&nbsp; <?php echo $correctivo->serial; ?></td>
                        <?php if ($correctivo->estado_equipo != null) : ?>
                            <td><?php echo $correctivo->estado_equipo; ?></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif ?>
                        <td><?php echo $correctivo->sede; ?></td>
                        <td><?php echo $correctivo->ubicacion; ?></td>
                        <td><?php echo $correctivo->area; ?></td>
                        <?php if ($correctivo->archivo != "" && $correctivo->archivo != null) : ?>
                            <td><?php echo "<a target='__blank' class='glyphicon glyphicon-file' href='" . base_url() . "assets/upload_correctivos_generales/" . $correctivo->archivo . "'></a>"; ?></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif ?>
                        <td><?php echo $correctivo->avance_fecha; ?></td>
                        <td><?php echo $correctivo->avance_titulo ?></td>
                        <td><?php echo $correctivo->avance_descripcion; ?></td>
                        <td><?php echo $correctivo->avance_fecha2; ?></td>
                        <td><?php echo $correctivo->avance_titulo2 ?></td>
                        <td><?php echo $correctivo->avance_descripcion2; ?></td>
                        <td><?php echo $correctivo->avance_fecha3; ?></td>
                        <td><?php echo $correctivo->avance_titulo3 ?></td>
                        <td><?php echo $correctivo->avance_descripcion3; ?></td>
                        <td><?php echo $correctivo->codigo_correctivo; ?></td>
                        <td><?php echo $correctivo->descripcion; ?></td>
                        <td><?php echo $correctivo->fecha_ejecucion; ?></td>
                        <td><?php echo $correctivo->costo; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach ?>
                <?php foreach ($tickets as $ticket) : ?>
                    <tr>
                        <td>Tickets
                            <?php if ($ticket->equipo_id == "" || $ticket->equipo_id == NULL || $ticket->equipo_id == 0 || $ticket->equipo_id == null) : ?>
                                (Equipo ingresado de forma manual)
                            <?php endif ?>
                        </td>
                        <td><?php echo $ticket->responsable_mantenimiento; ?></td>
                        <td><?php echo $ticket->equipo_id; ?></td>
                        <td><?php echo $ticket->fecha_inicio; ?></td>
                        <td><?php echo $ticket->id; ?></td>
                        <td><?php echo $ticket->descripcion; ?></td>
                        <?php if ($ticket->codigo_cierre == null) : ?>
                            <td><?php echo $ticket->estado; ?> </td>
                        <?php else : ?>
                            <td>(<?php echo $ticket->codigo_cierre ?>) <?php echo $ticket->significado_cierre; ?></td>
                        <?php endif ?>

                        <?php if ($ticket->equipo_id == "" || $ticket->equipo_id == NULL || $ticket->equipo_id == 0 || $ticket->equipo_id == null) : ?>
                            <!--Sin equipo vinculado-->
                            <td><?php echo $ticket->nombre_equipo; ?></td>
                            <td><?php echo $ticket->codigo_equipo; ?></td>
                            <td><?php echo $ticket->marca_equipo; ?></td>
                            <td><?php echo $ticket->modelo_equipo; ?></td>
                            <td>SN:&nbsp; <?php echo $ticket->serie_equipo; ?></td>
                            <td>No vinculado</td>
                        <?php else : ?>
                            <!--con equipo vinculador-->
                            <td><?php echo $ticket->equipo; ?></td>
                            <td><?php echo $ticket->code; ?></td>
                            <td><?php echo $ticket->marca; ?></td>
                            <td><?php echo $ticket->modelo; ?></td>
                            <td>SN:&nbsp; <?php echo $ticket->serie; ?></td>
                            <?php if ($ticket->estado_equipo != null) : ?>
                                <td><?php echo $ticket->estado_equipo ?></td>
                            <?php else : ?>
                                <td></td>
                            <?php endif ?>
                        <?php endif ?>
                        <td><?php echo $ticket->sede; ?></td>
                        <td><?php echo $ticket->servicio; ?></td>
                        <td><?php echo $ticket->area; ?></td>
                        <td></td>
                        <!--avances-->
                        <td><?php echo $ticket->avance_fecha; ?></td>
                        <td><?php echo $ticket->avance_titulo ?></td>
                        <td><?php echo $ticket->avance_descripcion; ?></td>
                        <td><?php echo $ticket->avance_fecha2; ?></td>
                        <td><?php echo $ticket->avance_titulo2 ?></td>
                        <td><?php echo $ticket->avance_descripcion2; ?></td>
                        <td><?php echo $ticket->avance_fecha3; ?></td>
                        <td><?php echo $ticket->avance_titulo3 ?></td>
                        <td><?php echo $ticket->avance_descripcion3; ?></td>
                        <td><?php echo $ticket->retro_cierre . "\n"; ?>
                            <?php if ($ticket->retro_diagnostico != "" && $ticket->retro_diagnostico != NULL) : ?>
                                <!--||Retro diagnostico: <?php echo $ticket->retro_diagnostico; ?>-->
                            <?php endif ?>
                        </td>
                        <td><?php echo $ticket->reparacion; ?></td>
                        <td><?php echo $ticket->fecha_asignacion_cierre; ?></td>
                        <td><?php echo $ticket->costo; ?></td>
                        <td><?php echo $ticket->fecha_fin; ?></td>
                        <td><?php if($ticket->repuesto_pendiente_condicion == 'no') echo $ticket->repuesto_pendiente; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
<?php
    }
}
?>
