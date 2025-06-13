<?php
$estado_id = $orden->estado_id;
$estados = [
  1 => ['class' => 'btn-danger', 'text' => 'Abierta'],
  2 => ['class' => 'btn-warning', 'text' => 'Asignada'],
  3 => ['class' => 'btn-info', 'text' => 'Diagnosticada'],
  4 => ['class' => 'btn-success', 'text' => 'Cerrada'],
  5 => ['class' => 'btn-primary', 'text' => 'Esperando cierre'],
];
if (isset($estados[$estado_id])) {
  $class = $estados[$estado_id]['class'];
  $text = $estados[$estado_id]['text'];
  $html = "<span class='to-hide btn $class'>$text</span>";
  if ($estado_id == 5 && session('id') == $orden->reportante_id && session('rol_id') == 4) {
    $html .= "<li class='list-inline-item'><a onclick='cerrar_ticket(event)' href='' class='btn btn-default'><span style='color: #638d70;font-size: 20px;' class='fa fa-archive'></span>Cerrar</a></li>";
  }
  echo "<br><br><br>" . $html;
}
?>
@if(session('editar_orden') == "si")
  @if(session('rol_id') <= 3)

    @if($orden->subproceso_id <= 2 && $orden->equipo_id == 0)<!--Logica para asociar un ID-->
      <div class="row">
        <div class="col-md-3">Asignar Id</div>
        <div class="col-md-3">
          <a href="" class="glyphicon glyphicon-search" onclick="">Consultar</a>
          <a href="" class="glyphicon glyphicon-tags" onclick="asignar_equipo_id(event,{{ $orden->id }})">Asignar</a>
        </div>
        <div class="col-md-6">
          <input type="number" min="1" minlength="1" name="equipo_id" id="equipo_id" class="equipo_id">
        </div>
      </div>
    <?php endif ?>

    <ul class="list-inline to-hide">
      <li class="list-inline-item">
        <a onclick="funcion_recobrar_id_orden(event)" data-toggle="modal" data-target="#modal_add_avance_correctivo" href="" class="btn btn-default"><span style="color: #2b71f2;font-size: 20px;" class="fa fa-line-chart"></span>Agregar avance</a>
      </li>
      @if($orden->repuesto_pendiente_condicion == "si")
        <li class="list-inline-item">
          <a onclick="desvincluar_repuesto_pendiente(event)" href="" class="btn btn-default"><span style="color: #4f3874;font-size: 20px;" class="glyphicon glyphicon-briefcase"></span>Repuesto no pendiente</a>
          <span onclick="addInstallation()"> Add </span>
        </li>
      <?php endif ?>
      @if(($orden->repuesto_pendiente_condicion == "no" || $orden->repuesto_pendiente_condicion == "") && strlen($orden->repuesto_pendiente) == 0)
        <li class="list-inline-item">
          <a onclick="" data-toggle="modal" data-target="#modal_add_repuesto_pendiente_ticket" href="" class="btn btn-default"><span style="color: #ff8000;font-size: 20px;" class="glyphicon glyphicon-briefcase"></span>Asociar repuesto pendiente</a>
        </li>
      <?php endif ?>

      @if($orden->estado_id == 1)<!--Abierto-->
        @if(session('rol_id') <= 2)
          @if($orden->subproceso_id == 1)
            <li class="list-inline-item"><a onclick="asignar({{ $orden->id }})" data-toggle="modal" data-target="#modal_asignar_orden" href="" class="btn btn-default"><span style="color: #dda70f;font-size: 20px;" class="fa fa-user"></span>Asignar responsable</a></li>
          @else
            <li class="list-inline-item"><a onclick="asignar_otro({{ $orden->id }})" data-toggle="modal" data-target="#modal_asignar_orden_otro" href="" class="btn btn-default"><span style="color: #dda70f;font-size: 20px;" class="fa fa-user"></span>Asociar tipo de trabajo y responsable</a></li>

          <?php endif ?>
        <?php endif ?>
      <?php endif ?>

      @if($orden->estado_id == 2)<!--Asignado-->
        <li class="list-inline-item"><a data-toggle="modal" data-target="#modal_add_diagnostico_from_timeline" href="" class="btn btn-default"><span style="color: #52d209;font-size: 20px;" class="fa fa-stethoscope"></span>Agregar diagnostico</a></li>
        <li class="list-inline-item"><a data-toggle="modal" data-target="#modal_add_solicitud_cierre_from_timeline" href="" class="btn btn-default"><span style="color: #160c4e;font-size: 20px;" class="fa fa-telegram"></span>Enviar a Cierre</a></li>
      <?php endif ?>

      @if($orden->estado_id == 3)<!--Diagnosticado-->
        <li class="list-inline-item"><a data-toggle="modal" data-target="#modal_add_solicitud_cierre_from_timeline" href="" class="btn btn-default"><span style="color: #160c4e;font-size: 20px;" class="fa fa-telegram"></span>Enviar a Cierre</a></li>
      <?php endif ?>
      @if($orden->estado_id == 5)<!--Esperando cierre-->
        @if(session('rol_id') <= 2)
          <li class="list-inline-item"><a onclick="cerrar_ticket(event)" href="" class="btn btn-default"><span style="color: #638d70;font-size: 20px;" class="fa fa-archive"></span>Cerrar</a></li>
        <?php endif ?>
      <?php endif ?>
    </ul>
  <?php endif ?>
<?php endif ?>





<div id="Formato ticket_4158" align=center x:publishsource="Excel" class="impresion-ticket">

  <table border=0 cellpadding=0 cellspacing=0 width=1196 style='border-collapse:
	collapse;table-layout:fixed;width:898pt'>
    <col class=xl154158 width=46 style='mso-width-source:userset;mso-width-alt:
	1682;width:35pt'>
    <col width=118 style='mso-width-source:userset;mso-width-alt:4315;width:89pt'>
    <col width=145 style='mso-width-source:userset;mso-width-alt:5302;width:109pt'>
    <col class=xl154158 width=106 style='mso-width-source:userset;mso-width-alt:
	3876;width:80pt'>
    <col width=120 style='mso-width-source:userset;mso-width-alt:4388;width:90pt'>
    <col width=119 style='mso-width-source:userset;mso-width-alt:4352;width:89pt'>
    <col class=xl154158 width=119 span=2 style='mso-width-source:userset;
	mso-width-alt:4352;width:89pt'>
    <col width=72 style='mso-width-source:userset;mso-width-alt:2633;width:54pt'>
    <col width=96 style='mso-width-source:userset;mso-width-alt:3510;width:72pt'>
    <col width=103 style='mso-width-source:userset;mso-width-alt:3766;width:77pt'>
    <col width=33 style='mso-width-source:userset;mso-width-alt:1206;width:25pt'>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl864158 width=46 style='height:15.0pt;width:35pt'><a name="RANGE!A1:L48">&nbsp;</a></td>
      <td class=xl724158 width=118 style='width:89pt'>&nbsp;</td>
      <td class=xl724158 width=145 style='width:109pt'>&nbsp;</td>
      <td class=xl724158 width=106 style='width:80pt'>&nbsp;</td>
      <td class=xl724158 width=120 style='width:90pt'>&nbsp;</td>
      <td class=xl724158 width=119 style='width:89pt'>&nbsp;</td>
      <td class=xl724158 width=119 style='width:89pt'>&nbsp;</td>
      <td class=xl724158 width=119 style='width:89pt'>&nbsp;</td>
      <td class=xl724158 width=72 style='width:54pt'>&nbsp;</td>
      <td class=xl724158 width=96 style='width:72pt'>&nbsp;</td>
      <td class=xl724158 width=103 style='width:77pt'>&nbsp;</td>
      <td class=xl874158 width=33 style='width:25pt'>&nbsp;</td>
    </tr>
    <tr height=58 style='mso-height-source:userset;height:43.5pt'>
      <td height=58 class=xl764158 style='height:43.5pt'>&nbsp;</td>
      <td align=left valign=top>



        <span style='mso-ignore:vglayout;
				position:absolute;z-index:1;margin-left:10px;margin-top:7px;width:82px;
				height:59px'><img width=82 height=59 src="<?php echo url('/') ?>assets/template/logo_hospital.jpg"></span>
      </td>
      <td class=xl814158 colspan=5>Hospital Universitario del Valle Evaristo Garcia</td>
      <td class=xl964158 colspan=4>ORDEN DE TRABAJO</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=22 style='height:16.5pt'>
      <td height=22 class=xl764158 style='height:16.5pt'>&nbsp;</td>
      <td class=xl744158>Sede</td>
      <td colspan=2 class=xl1174158>&nbsp;{{ $orden->sede }}</td>
      <td class=xl664158>Centro de costo</td>
      <td class=xl1204158>&nbsp;{{ $orden->centro_costo_reportante }}</td>
      <td class=xl664158>Servicio</td>
      <td class=xl1204158>&nbsp;{{ $orden->servicio }}</td>
      <td class=xl154158></td>
      <td class=xl734158>O.T. # :</td>
      <td class=xl1004158>&nbsp;{{ $orden->id }}</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=22 style='height:16.5pt'>
      <td height=22 class=xl764158 style='height:16.5pt'>&nbsp;</td>
      <td class=xl744158>Area</td>
      <td colspan=2 class=xl1144158>&nbsp;{{ $orden->area }}</td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl734158>O.T : Fecha</td>
      <td class=xl1214158 style='border-top:none'>
        <div class="ajustar-texto">&nbsp;{{ $orden->fecha_inicio }}</div>
      </td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=22 style='height:16.5pt'>
      <td height=22 class=xl764158 style='height:16.5pt'>&nbsp;</td>
      <td class=xl744158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl734158></td>
      <td class=xl1014158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl744158>Equipo</td>
      <td colspan=2 class=xl1204158>&nbsp;<?php echo ($orden->equipo_id != 0) ? $orden->nombre_equipo_db : $orden->nombre_equipo ?></td>
      <td class=xl664158>Serie</td>
      <td class=xl1204158>&nbsp;<?php echo ($orden->equipo_id != 0) ? $orden->serie_equipo_db : $orden->serie_equipo ?></td>
      <td class=xl744158>No. Inventario</td>
      <td class=xl1204158>&nbsp;<?php echo ($orden->equipo_id != 0) ? $orden->codigo_equipo_db : $orden->codigo_equipo ?></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl744158>Modelo</td>
      <td colspan=2 class=xl1204158>&nbsp;<?php echo ($orden->equipo_id != 0) ? $orden->modelo_equipo_db : $orden->modelo_equipo ?></td>
      <td class=xl664158>Marca</td>
      <td class=xl1144158 style='border-top:none'>&nbsp;<?php echo ($orden->equipo_id != 0) ? $orden->marca_equipo_db : $orden->marca_equipo ?></td>
      <td class=xl154158></td>
      <td class=xl664158>Solicitado por</td>
      <td class=xl1044158></td>
      <td colspan=2 class=xl1184158>&nbsp;<?php echo ($orden->nombre_reportante != "") ? $orden->nombre_reportante : $orden->nombre . " " . $orden->apellido ?></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl744158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl664158>Correo electronico</td>
      <td class=xl664158></td>
      <td colspan=2 class=xl1194158>&nbsp;<?php echo ($orden->nombre_reportante != "") ? "No aplica" : $orden->email ?></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td height=21 class=xl764158 style='height:15.75pt'>&nbsp;</td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl694158></td>
      <td class=xl694158></td>
      <td class=xl694158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=21 style='height:15.75pt'>
      <td height=21 class=xl764158 style='height:15.75pt'>&nbsp;</td>
      @if($orden->trabajo_id != 0)
        <td class=xl844158>
          <strong>TIPO DE ARREGLO</strong>:
        </td>
        <td class=xl844158>
          {{ $orden->trabajo }}
        </td>
      @else
        <td class=xl844158></td>
        <td class=xl664158></td>
      <?php endif ?>
      @if($orden->listado_industrial_id != 0)
        <td class=xl664158><strong>TIPO DE EQUIPO</strong></td>
        <td class=xl664158>{{ $orden->tipo_industrial }}</td>
      <?php endif ?>
      <td class=xl664158></td>
      <td class=xl664158></td>
      <td class=xl664158></td>
      <td class=xl664158></td>
      <td class=xl664158></td>
      <td class=xl664158></td>
      <td class=xl664158></td>
      <td class=xl664158></td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl854158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=4 class=xl924158>Descripcion del problema presentado</td>
      <td colspan=4 class=xl944158>Empresa Asignada</td>
      <td colspan=2 class=xl944158 style='border-right:.5pt solid black'>Asignación especifica</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=4 rowspan=5 class=xl1064158 width=489 style='border-bottom:.5pt solid black;
					width:368pt'>&nbsp;{{ $orden->descripcion }}</td>
      <td colspan=4 rowspan=5 class=xl1054158>&nbsp;

        {{ ($orden->subproceso_id != 1) ? "Hospital Universitario del Valle" : $orden->empresa }}
        @if($orden->username_usuario_asignador != "")

          <br>Asignado por: {{ $orden->username_usuario_asignador . "<br>(" . $orden->nombre_usuario_asignador . " " . $orden->apellido_usuario_asignador . ")" }}
        <?php endif ?>

      </td>
      <td colspan=2 rowspan=2 class=xl984158>&nbsp;
        {{ ($orden->tecnico_id != 0) ? $orden->tecnico : $orden->asignado }}
        {{ $orden->tecnico_otros }}

      </td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=2 class=xl994158 style='border-left:none'>Fecha de asignación</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=2 rowspan=2 class=xl984158>&nbsp;<div class="ajustar-texto">{{ $orden->fecha_asignacion }}</div>
      </td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl714158 width=118 style='width:89pt'></td>
      <td class=xl714158 width=145 style='width:109pt'></td>
      <td class=xl714158 width=106 style='width:80pt'></td>
      <td class=xl714158 width=120 style='width:90pt'></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=4 class=xl924158>Diagnostico</td>
      <td colspan=2 class=xl1034158>Responsable del diagnostico</td>
      <td colspan=2 class=xl1034158>Repuestos necesarios</td>
      <td colspan=2 class=xl944158 style='border-right:.5pt solid black'>Tiempo de
        ejecución</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=4 rowspan=4 class=xl1124158 width=489 style='width:368pt'>&nbsp;

        <div class="row">
          <div class="col-sm-2">
            @if($orden->file_diagnostico != "" && $orden->file_diagnostico != NULL && $orden->file_diagnostico != null)
              <a style="color: #1c1f23;font-size: 18px;" href="{{ url('/') }}assets/upload_correctivos_generales/{{ $orden->file_diagnostico }}" target="__blank" class="fa fa-paperclip"></a>
            <?php endif ?>
          </div>
          <div class="col-sm-10">
            @if($orden->diagnostico != "" && $orden->diagnostico != NULL && $orden->diagnostico != null)
              <span style="font-weight: 800;">Retro diagnostico:</span>{{ $orden->retro_diagnostico }}<p></p>{{ $orden->diagnostico }}
            <?php endif ?>
          </div>
        </div>

      </td>
      <td colspan=2 rowspan=4 class=xl1054158>&nbsp;<?php echo ($orden->tecnico_diagnostico_text != "" && $orden->tecnico_diagnostico_text != NULL && $orden->tecnico_diagnostico_text != null) ? $orden->tecnico_diagnostico_text : $orden->nombre_tecnico_diagnostico . " " . $orden->apellido_tecnico_diagnostico ?></td>
      <td colspan=2 rowspan=4 class="xl1054158 ">&nbsp;<div class="ajustar-texto">{{ ($orden->repuesto_pendiente_condicion != "") ? "<strong>Repuesto pendiente?</strong>" : "" ?>&nbsp;<?php echo $orden->repuesto_pendiente_condicion }}<br><br>{{ $orden->repuesto_pendiente }}
        </div>
      </td>
      <td rowspan=2 class=xl974158 width=96 style='width:72pt'>Fecha Inicio</td>
      <td rowspan=2 class=xl984158>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td rowspan=2 class=xl974158 width=96 style='border-top:none;width:72pt'>Fecha
        de finalización</td>
      <td rowspan=2 class=xl984158 style='border-top:none'>&nbsp;<div class="ajustar-texto">{{ $orden->fecha_diagnostico }}</div>
      </td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl714158 width=118 style='width:89pt'></td>
      <td class=xl714158 width=145 style='width:109pt'></td>
      <td class=xl714158 width=106 style='width:80pt'></td>
      <td class=xl714158 width=120 style='width:90pt'></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=4 class=xl924158>Tipo y descripción del trabajo realizado</td>
      <td colspan=2 class=xl1034158>Responsable de la reparación</td>
      <td colspan=2 class=xl1034158>Repuestos instalados</td>
      <td colspan=2 class=xl944158 style='border-right:.5pt solid black'>Tiempo de
        ejecución</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=4 rowspan=4 class=xl1064158 width=489 style='border-bottom:.5pt solid black;
		width:368pt'>&nbsp;

        <div class="row">
          <div class="ajustar-texto">
            <div class="col-sm-2">
              @if($orden->file_cierre != "" && $orden->file_cierre != NULL && $orden->file_cierre != null)
                <a href="{{ url('/') }}assets/upload_correctivos_generales/{{ $orden->file_cierre }}" target="__blank" class="fa fa-paperclip" style="color:#1c1f23;font-size: 18px;"></a>
              <?php endif ?>
            </div>
            <div class="col-sm-8">
              @if($orden->retro_cierre != "" && $orden->retro_cierre != null && $orden->retro_cierre != NULL)
                <span style="font-weight: 800;">Codigo del retro de cierre:</span>
                {{ $orden->retro_cierre }} <br>
              <?php endif ?>
              {{ $orden->reparacion }}
            </div>
          </div>
        </div>
      </td>
      @if($orden->subproceso_id != 1)
        <td colspan=2 rowspan=4 class=xl1054158>&nbsp;{{ ($orden->fecha_asignacion_cierre != null && $orden->fecha_asignacion_cierre != "" && $orden->fecha_asignacion_cierre != "0000-00-00") ? $orden->tecnico : "" }}</td>
      @else
        <td colspan=2 rowspan=4 class=xl1054158>&nbsp;<?php echo ($orden->tecnico_cierre_text != "" && $orden->tecnico_cierre_text != NULL && $orden->tecnico_cierre_text != null) ? $orden->tecnico_cierre_text : $orden->nombre_tecnico_cierre . " " . $orden->apellido_tecnico_cierre ?></td>
      <?php endif ?>
      <td colspan=2 rowspan=4 class=xl1054158>&nbsp;</td>
      <td rowspan=2 class=xl974158 width=96 style='width:72pt'>Fecha Inicio</td>
      <td rowspan=2 class=xl984158>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td rowspan=2 class=xl974158 width=96 style='border-top:none;width:72pt'>Fecha
        de finalización</td>
      <td rowspan=2 class=xl984158 style='border-top:none'>&nbsp;<div class="ajustar-texto">{{ $orden->fecha_asignacion_cierre }}</div>
      </td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr class=xl154158 height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl714158 width=118 style='width:89pt'></td>
      <td class=xl714158 width=145 style='width:109pt'></td>
      <td class=xl714158 width=106 style='width:80pt'></td>
      <td class=xl714158 width=120 style='width:90pt'></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl704158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl154158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1024158>Avances</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tbody class="listado-avances-ordenes">
      @if(!empty($avances))

        @foreach($avances as $avance)
          <tr height=20 style='mso-height-source:userset;height:15.0pt'>
            <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
            <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;
              <div class="ajustar-texto">
                <div class="row">
                  <div class="col-sm-7">
                    <div class="ajustar-texto">{{ $avance->description }}</div>
                  </div>
                  <div class="col-sm-1">
                  </div>
                  <div class="col-sm-4">
                    <div class="ajustar-texto">
                      <span style="font-size: 10px;" class="text-muted">[{{ $avance->date }}]</span>
                      <span class="fa fa-user">{{ $avance->usuario }}</span>
                      @if($avance->file != "" && $avance->file != NULL && $avance->file != null)
                        <a href="{{ url('/') }}assets/upload_correctivos_generales/{{ $avance->file }}" target="__blank" class="btn btn-dark fa fa-paperclip"></a>
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              </div>


            </td>
            <td class=xl674158></td>
            <td class=xl754158>&nbsp;</td>
          </tr>
        <?php endforeach ?>
    </tbody>
  @else
    <tr height=20 style='mso-height-source:userset;height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
      <td colspan=9 class=xl1134158 style='border-right:.5pt solid black'>&nbsp;</td>
      <td class=xl674158></td>
      <td class=xl754158>&nbsp;</td>
    </tr>

  <?php endif ?>
  <tr height=20 style='height:15.0pt'>
    <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=20 style='height:15.0pt'>
    <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=20 style='height:15.0pt'>
    <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
    <td class=xl774158></td>
    <td class=xl644158>&nbsp;</td>
    <td class=xl644158>&nbsp;</td>
    <td class=xl644158>&nbsp;</td>
    <td class=xl644158>&nbsp;</td>
    <td class=xl644158>&nbsp;</td>
    <td class=xl644158>&nbsp;</td>
    <td class=xl654158>&nbsp;</td>
    <td class=xl654158>&nbsp;</td>
    <td class=xl154158></td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=20 style='height:15.0pt'>
    <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
    <td class=xl154158></td>
    <td colspan=8 class=xl914158>Estoy de acuerdo en que todo el trabajo se ha
      realizado satisfactoriamente.</td>
    <td class=xl784158></td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=34 style='mso-height-source:userset;height:25.5pt'>
    <td height=34 class=xl764158 style='height:25.5pt'>&nbsp;</td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl664158>Fecha de solicitud de cierre:</td>
    <td class=xl664158></td>
    <td colspan=2 class=xl1174158>&nbsp;{{ $orden->fecha_asignacion_cierre }}</td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=34 style='mso-height-source:userset;height:25.5pt'>
    <td height=34 class=xl764158 style='height:25.5pt'>&nbsp;</td>
    <td class=xl794158 width=118 style='width:89pt'>Firma de quien cierra la orden:</td>
    <td colspan=4 class=xl1164158 width=490 style='width:368pt'>&nbsp;<div class="ajustar-texto">{{ ($orden->usuario_final_id != 0) ? $orden->nombre_usuario_final . " " . $orden->apellido_usuario_final . " (" . $orden->email_usuario_final . ")" : "" }}</div>
    </td>
    <td class=xl684158 width=119 style='width:89pt'></td>
    <td class=xl664158>Fecha de cierre:</td>
    <td class=xl664158></td>
    <td colspan=2 class=xl1174158>&nbsp;<div class="ajustar-texto">{{ $orden->fecha_fin }}</div>
    </td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=20 style='height:15.0pt'>
    <td height=20 class=xl764158 style='height:15.0pt'>&nbsp;</td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl154158></td>
    <td class=xl754158>&nbsp;</td>
  </tr>
  <tr height=24 style='height:18.0pt'>
    <td height=24 class=xl884158 style='height:18.0pt'>&nbsp;</td>
    <td colspan=10 class=xl904158>¡Eva Tickets!</td>
    <td class=xl894158>&nbsp;</td>
  </tr>
  <![if supportMisalignedColumns]>
  <tr height=0 style='display:none'>
    <td width=46 style='width:35pt'></td>
    <td width=118 style='width:89pt'></td>
    <td width=145 style='width:109pt'></td>
    <td width=106 style='width:80pt'></td>
    <td width=120 style='width:90pt'></td>
    <td width=119 style='width:89pt'></td>
    <td width=119 style='width:89pt'></td>
    <td width=119 style='width:89pt'></td>
    <td width=72 style='width:54pt'></td>
    <td width=96 style='width:72pt'></td>
    <td width=103 style='width:77pt'></td>
    <td width=33 style='width:25pt'></td>
  </tr>
  <![endif]>
  </table>

</div>