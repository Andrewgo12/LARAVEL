<?php

$correctivos = $correctivos[0] ?? null;
$correctivos_generales = $correctivos_generales[0] ?? null;
$preventivos = $preventivos[0] ?? null;
$calibraciones = $calibraciones[0] ?? null;
$repuestos = $repuestos[0] ?? null;
$especificaciones = $especificaciones[0] ?? null;
$contactos = $contactos[0] ?? null;
$fabricante = $fabricante[0] ?? null;
$proveedor = $proveedor[0] ?? null;
$representante = $representante[0] ?? null;
$tension = $tension[0] ?? null;
$potencia = $potencia[0] ?? null;
$presion = $presion[0] ?? null;
$temperatura = $temperatura[0] ?? null;
$corriente = $corriente[0] ?? null;
$frecuencia = $frecuencia[0] ?? null;
$velocidad = $velocidad[0] ?? null;
$humedad = $humedad[0] ?? null;
$peso = $peso[0] ?? null;
?>

<?php
if (!empty($cambios_hdv)) {
?>
  <a onclick="show_cambios_hdv(<?php echo $equipo->id; ?>)" title="Historial de cambios" href="#" data-toggle="modal" data-target="#modal_show_cambios_hdv" class="fa fa-caret-square-o-right btn btn-success">Historial</a>
<?php
}
?>
<div id="contenedor_detalle_equipo" x:publishsource="Excel" class="impresion">
  <table cellpadding=0 cellspacing=0 width=832 class="tabla_detalles" style='border-collapse:
			collapse;table-layout:fixed;width:100%'>
    <col width=35 style='width:26pt'>
    <col width=47 style='width:35pt'>
    <col width=19 style='width:14pt'>
    <col width=5 style='width:4pt'>
    <col width=55 style='width:41pt'>
    <col width=0 style='display:none'>
    <col width=2 style='width:2pt'>
    <col width=6 style='width:5pt'>
    <col width=2 style='width:2pt'>
    <col width=0 style='display:none'>
    <col width=2 style='width:2pt'>
    <col width=6 style='width:5pt'>
    <col width=5 style='width:4pt'>
    <col width=9 style='width:7pt'>
    <col width=14 style='width:11pt'>
    <col width=8 style='width:6pt'>
    <col width=9 style='width:7pt'>
    <col width=7 style='width:5pt'>
    <col width=10 style='width:8pt'>
    <col width=18 style='width:14pt'>
    <col width=6 style='width:5pt'>
    <col width=8 style='width:6pt'>
    <col width=10 style='width:8pt'>
    <col width=5 style='width:4pt'>
    <col width=10 style='width:8pt'>
    <col width=15 style='width:11pt'>
    <col width=8 style='width:6pt'>
    <col width=20 style='width:15pt'>
    <col width=11 style='width:8pt'>
    <col width=12 style='width:9pt'>
    <col width=7 style='width:5pt'>
    <col width=8 style='width:6pt'>
    <col width=10 style='width:8pt'>
    <col width=4 style='width:3pt'>
    <col width=6 style='width:5pt'>
    <col width=5 style='width:4pt'>
    <col width=39 style='width:29pt'>
    <col width=11 span=2 style='width:8pt'>
    <col width=10 style='width:8pt'>
    <col width=21 style='width:16pt'>
    <col width=17 span=2 style='width:13pt'>
    <col width=26 style='width:20pt'>
    <col width=11 style='width:8pt'>
    <col width=14 style='width:11pt'>
    <col width=23 style='width:17pt'>
    <col width=18 style='width:14pt'>
    <col width=12 style='width:9pt'>
    <col width=21 style='width:16pt'>
    <col width=17 style='width:13pt'>
    <col width=5 style='width:4pt'>
    <col width=32 style='width:24pt'>
    <col width=43 style='width:32pt'>
    <col width=80 style='width:60pt'>
    <tr height=61 style='height:45.75pt'>
      <td colspan=49 height=61 class=xl9426419 width=634 style='height:45.75pt;
				width:483pt'><a name="RANGE!A1:BB54">FORMATO DE INVENTARIO TÉCNICO FUNCIONAL
          PARA EQUIPOS BIOMÉDICOS HOSPITAL UNIVERSITARIO DEL VALLE “EVARISTO
          GARCÍA”<span> </span></a></td>
      <td colspan=5 class=xl9426419 width=118 style='width:89pt'>&nbsp;<img src="<?= base_url(); ?>assets/template/logo_hospital.jpg" width="170px;" height="100px;"></td>
      <td class=xl20226419 width=80 style='width:0pt'>&nbsp;</td>
    </tr>
    <tr height=31 style='height:23.25pt'>
      <td colspan=30 height=31 class=xl16426419 width=364 style='height:23.25pt;
					width:278pt'>1. IDENTIFICACIÓN DEL EQUIPO</td>
      <td class=xl16626419 width=7 style='width:5pt'>&nbsp;</td>
      <td class=xl16626419 width=8 style='width:6pt'>&nbsp;</td>
      <td colspan=4 class=xl16726419 width=25 style='width:20pt'>ID:<span> </span></td>
      <td class=xl6426419 width=39 style='width:29pt'>&nbsp;<?php echo $equipo->id; ?></td>
      <td class=xl6426419 width=11 style='width:8pt'>&nbsp;</td>
      <td class=xl6426419 width=11 style='width:8pt'>&nbsp;</td>
      <td class=xl6426419 width=10 style='width:8pt'>&nbsp;</td>
      <td class=xl6426419 width=21 style='width:16pt'>&nbsp;</td>
      <td class=xl6426419 width=17 style='width:13pt'>&nbsp;</td>
      <td class=xl6426419 width=17 style='width:13pt'>&nbsp;</td>
      <td class=xl6426419 width=26 style='width:20pt'>&nbsp;</td>
      <td class=xl6426419 width=11 style='width:8pt'>&nbsp;</td>
      <td class=xl6426419 width=14 style='width:11pt'>&nbsp;</td>
      <td class=xl6426419 width=23 style='width:17pt'>&nbsp;</td>
      <td class=xl6426419 width=18 style='width:14pt'>&nbsp;</td>
      <td class=xl6426419 width=12 style='width:9pt'>&nbsp;</td>
      <td class=xl6426419 width=21 style='width:16pt'>&nbsp;</td>
      <td class=xl6426419 width=17 style='width:13pt'>&nbsp;</td>
      <td class=xl6426419 width=5 style='width:4pt'>&nbsp;</td>
      <td class=xl6426419 width=32 style='width:24pt'>&nbsp;</td>
      <td class=xl6526419 width=43 style='width:32pt'>&nbsp;</td>
      <td class=xl1526419></td>
    </tr>
    <tr height=24 style='height:18.0pt'>
      <td colspan=6 height=24 class=xl10826419 width=161 style='border-right:1.0pt solid black;
						height:18.0pt;width:120pt'>1.1 Nombre del equipo:</td>
      <td colspan=31 class=xl10826419 width=282 style='border-right:1.0pt solid black;
						border-left:none;width:218pt'>
        &nbsp;<?php echo $equipo->name; ?>
        <?php echo ($equipo->descripcion != "") ? "(" . $equipo->descripcion . ")" : ""; ?>
      </td>
      <td colspan=17 rowspan=12 class=xl9626419 width=309 style='border-right:1.0pt solid black;
						border-bottom:1.0pt solid black;width:234pt'>&nbsp;<img class="" width="350px" height="280px" src="{{ asset('') }}assets/upload_imagenes/<?php echo $equipo->image; ?>" alt=""></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=4 height=21 class=xl7526419 width=106 style='border-right:1.0pt solid black;
						height:15.75pt;width:79pt'>1.2 Serie:</td>
      <td colspan=33 class=xl10526419 width=337 style='border-right:1.0pt solid black;
						border-left:none;width:259pt'>&nbsp;<?php echo $equipo->serial != '' ? $equipo->serial : 'No registra'; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=22 style='height:16.5pt'>
      <td colspan=4 height=22 class=xl7526419 width=106 style='border-right:1.0pt solid black;
						height:16.5pt;width:79pt'>1.3 INV/Activo </td>
      <td colspan=6 class=xl7526419 width=65 style='border-right:1.0pt solid black;
						border-left:none;width:50pt'>Antiguo:</td>
      <td colspan=13 class=xl7526419 width=112 style='border-right:1.0pt solid black;
						border-left:none;width:88pt'>&nbsp;<?php echo $equipo->codigo_antiguo; ?></td>
      <td colspan=7 class=xl7526419 width=81 style='border-right:1.0pt solid black;
						border-left:none;width:61pt'>Nuevo:</td>
      <td colspan=7 class=xl7526419 width=79 style='border-right:1.0pt solid black;
						border-left:none;width:60pt'>&nbsp;<?php echo $equipo->code; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=2 height=21 class=xl7526419 width=82 style='border-right:1.0pt solid black;
						height:15.75pt;width:61pt'>1.4 Marca:</td>
      <td colspan=35 class=xl7526419 width=361 style='border-right:1.0pt solid black;
						border-left:none;width:277pt'>&nbsp;<?php echo $equipo->marca; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=2 height=21 class=xl7526419 width=82 style='border-right:1.0pt solid black;
						height:15.75pt;width:61pt'>1.5 Modelo:</td>
      <td colspan=35 class=xl6626419 width=361 style='border-right:1.0pt solid black;
						border-left:none;width:277pt'>&nbsp;<?php echo $equipo->modelo; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=2 height=21 class=xl7526419 width=82 style='border-right:1.0pt solid black;
						height:15.75pt;width:61pt'>1.6 R. Invima:</td>
      <td colspan=35 class=xl13626419 width=361 style='border-right:1.0pt solid black;
						border-left:none;width:277pt'>&nbsp;
        @if($equipo->registro_sanitario != null)
          <span title="<?php echo $equipo->registro_sanitario_descripcion; ?>">
            <?php echo $equipo->registro_sanitario; ?>
          </span>
          <a target="__blank" class="glyphicon glyphicon-file esconder" href="{{ asset('') }}assets/upload_registros_sanitarios/<?php echo $equipo->file_registro_sanitario; ?>"></a>
        @else
          <?php echo $equipo->invima; ?>
          @if($equipo->archivo_invima != null)
            <a target="__blank" class="glyphicon glyphicon-file esconder" href="{{ asset('') }}assets/upload_invimas/<?php echo $equipo->archivo_invima; ?>"></a>
          <?php endif ?>
        <?php endif ?>
      </td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=2 height=21 class=xl7526419 width=82 style='border-right:1.0pt solid black;
						height:15.75pt;width:61pt'>1.7 Ubicación:</td>
      <td colspan=35 class=xl6926419 width=361 style='border-right:1.0pt solid black;
						border-left:none;width:277pt'>

        <strong>Servicio:</strong>&nbsp;<?php echo $equipo->servicios; ?><br>
        @if($equipo->area != "" && $equipo->area != null)
          <strong>Area:</strong>
          &nbsp;<small class="text-muted"><?php echo $equipo->area; ?></small>
        <?php endif ?>
      </td>
      <td class=xl1526419></td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td colspan=2 height=20 class=xl7526419 width=82 style='height:15.0pt;
						width:61pt'>1.8 Piso:</td>
      <td colspan=15 class=xl8926419 width=142 style='border-right:1.0pt solid black;
						width:110pt'>&nbsp;<?php echo ($equipo->pisos_areas == "" || $equipo->pisos_areas == "NULL" || $equipo->pisos_areas == "null") ? $equipo->pisos : $equipo->pisos_areas; ?></td>
      <td colspan=13 class=xl8226419 width=140 style='border-right:1.0pt solid black;
						border-left:none;width:107pt'>1.9 Centro de costo:</td>
      <td colspan=7 class=xl6926419 width=79 style='border-right:1.0pt solid black;
						border-left:none;width:60pt'>&nbsp;<?php echo $equipo->centro; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td colspan=2 height=20 class=xl7726419 width=82 style='border-right:1.0pt solid black;
						height:15.0pt;width:61pt'>1.10 Equipo:</td>
      <td colspan=15 class=xl7926419 width=142 style='border-right:1.0pt solid black;
						border-left:none;width:110pt'>&nbsp;<?php echo $equipo->movilidad; ?></td>
      <td colspan=13 class=xl8226419 width=140 style='border-right:1.0pt solid black;
						border-left:none;width:107pt'>1.11 País de origen:</td>
      <td colspan=7 class=xl8526419 width=79 style='border-right:1.0pt solid black;
						border-left:none;width:60pt'>&nbsp;</td>
      <td class=xl1526419></td>
    </tr>
    <tr height=17 style='height:12.75pt'>
      <td colspan=37 height=17 class=xl7226419 width=443 style='border-right:1.0pt solid black;
						height:12.75pt;width:338pt'>2. REGISTRO HISTORICO</td>
      <td class=xl1526419></td>
    </tr>
    <tr height=22 style='height:16.5pt'>
      <td colspan=9 height=22 class=xl11126419 width=171 style='border-right:1.0pt solid black;
						height:16.5pt;width:129pt'>2.1 Forma de adquisición:</td>
      <td colspan=28 class=xl11726419 width=272 style='border-right:1.0pt solid black;
						border-left:none;width:209pt'>&nbsp;<?php echo $equipo->adquisiciones; ?>
        @if($equipo->orden_compra_id != "" && $equipo->orden_compra_id != null)
          ||
          @if($equipo->tipo_compra_id == 1)
            <strong>Orden de compra asociada:</strong>&nbsp;
          <?php elseif ($equipo->tipo_compra_id == 2) : ?>
            <strong>Numero de contrato:</strong>&nbsp;
          <?php elseif ($equipo->tipo_compra_id == 3) : ?>
            <strong>Cruce de cuentas:</strong>&nbsp;
          <?php endif ?>
          <?php echo $equipo->orden_compra; ?>
          @if($equipo->file_orden_compra != null && $equipo->file_orden_compra != "")
            <a class="glyphicon glyphicon-file esconder" href="{{ asset('') }}assets/upload_ordenes_compra/<?php echo $equipo->file_orden_compra; ?>" target="__blank"></a>
          <?php endif ?>
        <?php endif ?>

      </td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=9 height=21 class=xl8226419 width=171 style='border-right:1.0pt solid black;
						height:15.75pt;width:129pt'>Activo comodato:</td>
      <td colspan=28 class=xl11726419 width=272 style='border-right:1.0pt solid black;
						border-left:none;width:209pt'>&nbsp;<?php echo $equipo->activo_comodato; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=11 height=21 class=xl7526419 width=173 style='border-right:1.0pt solid black;
						height:15.75pt;width:131pt'>2.2 Fecha de adquisición:</td>
      <td colspan=15 class=xl11826419 width=140 style='border-right:1.0pt solid black;
						border-left:none;width:109pt'>&nbsp;<?php echo ($equipo->fecha_ad == "0000-00-00" || $equipo->fecha_ad == "" || $equipo->fecha_ad == null) ? "SIN INFORMACIÓN" : $equipo->fecha_ad; ?></td>
      <td colspan=20 class=xl7526419 width=268 style='border-right:1.0pt solid black;
						border-left:none;width:203pt'>2.3 Fecha acta de recibo:</td>
      <td colspan=8 class=xl11826419 width=171 style='border-right:1.0pt solid black;
						border-left:none;width:129pt'>&nbsp;<?php echo ($equipo->fecha_acta_recibo == "0000-00-00" || $equipo->fecha_acta_recibo == "" || $equipo->fecha_acta_recibo == null) ? "SIN INFORMACIÓN" : $equipo->fecha_acta_recibo; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=11 height=21 class=xl7526419 width=173 style='border-right:1.0pt solid black;
						height:15.75pt;width:131pt'>2.4 Fecha de instalación:</td>
      <td colspan=15 class=xl11826419 width=140 style='border-right:1.0pt solid black;
						border-left:none;width:109pt'>&nbsp;<?php echo ($equipo->fecha_instalacion == "0000-00-00" || $equipo->fecha_instalacion == "" || $equipo->fecha_instalacion == null) ? "SIN INFORMACIÓN" : $equipo->fecha_instalacion; ?></td>
      <td colspan=20 class=xl7526419 width=268 style='border-right:1.0pt solid black;
						border-left:none;width:203pt'>2.5 Fecha de inicio de operación:</td>
      <td colspan=8 class=xl11826419 width=171 style='border-right:1.0pt solid black;
						border-left:none;width:129pt'>&nbsp;<?php echo ($equipo->fecha_inicio_operacion == "0000-00-00" || $equipo->fecha_inicio_operacion == "" || $equipo->fecha_inicio_operacion == null) ? "SIN INFORMACIÓN" : $equipo->fecha_inicio_operacion; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=11 height=21 class=xl7526419 width=173 style='border-right:1.0pt solid black;
						height:15.75pt;width:131pt'>2.6 Fecha<span> 
        </span>ven. garantía:</td>
      <td colspan=15 class=xl11826419 width=140 style='border-right:1.0pt solid black;
						border-left:none;width:109pt'>&nbsp;<?php echo ($equipo->fecha_vencimiento_garantia == "0000-00-00" || $equipo->fecha_vencimiento_garantia == "" || $equipo->fecha_vencimiento_garantia == null) ? "SIN INFORMACIÓN" : $equipo->fecha_vencimiento_garantia; ?></td>
      <td colspan=20 class=xl7526419 width=268 style='border-right:1.0pt solid black;
						border-left:none;width:203pt'>2.7 Fecha de fabricación:</td>
      <td colspan=8 class=xl11826419 width=171 style='border-right:1.0pt solid black;
						border-left:none;width:129pt'>&nbsp;<?php echo ($equipo->fecha_fabricacion == "0000-00-00" || $equipo->fecha_fabricacion == "" || $equipo->fecha_fabricacion == null) ? "SIN INFORMACIÓN" : $equipo->fecha_fabricacion; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=11 height=21 class=xl7526419 width=173 style='border-right:1.0pt solid black;
						height:15.75pt;width:131pt'>2.8 Fecha rep. Almacen</td>
      <td colspan=43 class=xl11826419 width=579 style='border-right:1.0pt solid black;
						border-left:none;width:441pt'>&nbsp;<?php echo ($equipo->fecha_recepcion_almacen == "0000-00-00" || $equipo->fecha_recepcion_almacen == "" || $equipo->fecha_recepcion_almacen == null) ? "SIN INFORMACIÓN" : $equipo->fecha_recepcion_almacen; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=3 height=21 class=xl15026419 width=101 style='border-right:1.0pt solid black;
						height:15.75pt;width:75pt'>2.9 Costo:</td>
      <td colspan=37 class=xl15326419 width=374 style='border-right:1.0pt solid black;
						border-left:none;width:287pt'>&nbsp;<strong></strong>
        <span class="clase_costo"><?php echo $equipo->costo; ?></span>
      </td>
      <td colspan=6 class=xl7526419 width=106 style='border-right:1.0pt solid black;
						border-left:none;width:81pt'>2.9.2 Vida útil:</td>
      <td colspan=8 class=xl12326419 width=171 style='border-right:1.0pt solid black;
						border-left:none;width:129pt'>&nbsp;<?php echo $equipo->vida_util; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=27 height=21 class=xl7526419 width=321 style='border-right:1.0pt solid black;
						height:15.75pt;width:246pt'>PROVEEDOR:&nbsp;<?php echo (isset($proveedor->contacto) ? $proveedor->contacto : ""); ?><span>  </span></td>
      <td colspan=15 class=xl14126419 width=192 style='border-right:1.0pt solid black;
						border-left:none;width:145pt'>TEL:<?php echo (isset($proveedor->telefono) ? $proveedor->telefono : ""); ?></td>
      <td colspan=12 class=xl14726419 width=239 style='border-right:1.0pt solid black;
						border-left:none;width:181pt'>EMAIL:<?php echo (isset($proveedor->email) ? $proveedor->email : ""); ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=27 height=21 class=xl8226419 width=321 style='border-right:1.0pt solid black;
						height:15.75pt;width:246pt'>REPRESENTANTE:&nbsp;<?php echo (isset($representante->contacto) ? $representante->contacto : ""); ?><span> </span></td>
      <td colspan=15 class=xl6926419 width=192 style='border-right:1.0pt solid black;
						border-left:none;width:145pt'>TEL:<?php echo (isset($representante->telefono) ? $representante->telefono : ""); ?></td>
      <td colspan=12 class=xl8226419 width=239 style='border-right:1.0pt solid black;
						border-left:none;width:181pt'>EMAIL:<?php echo (isset($representante->email) ? $representante->email : ""); ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=27 height=21 class=xl8526419 width=321 style='border-right:1.0pt solid black;
						height:15.75pt;width:246pt'>FABRICANTE:&nbsp;<?php echo (isset($fabricante->contacto) ? $fabricante->contacto : ""); ?><span> </span></td>
      <td colspan=15 class=xl14426419 width=192 style='border-right:1.0pt solid black;
						border-left:none;width:145pt'>TEL:<?php echo (isset($fabricante->telefono) ? $fabricante->telefono : ""); ?></td>
      <td colspan=12 class=xl8526419 width=239 style='border-right:1.0pt solid black;
						border-left:none;width:181pt'>EMAIL:<?php echo (isset($fabricante->email) ? $fabricante->email : ""); ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=23 style='height:17.25pt'>
      <td colspan=54 height=23 class=xl7226419 width=752 style='border-right:1.0pt solid black;
						height:17.25pt;width:572pt'>3. REGISTRO TÉCNICO DE INSTALACIÓN Y
        FUNCIONAMIENTO</td>
      <td class=xl1526419></td>
    </tr>
    <tr height=27 style='height:20.25pt'>
      <td colspan=12 height=27 class=xl11126419 width=179 style='border-right:1.0pt solid black;
					height:20.25pt;width:136pt'>3.1 Fuente de alimentación:</td>
      <td colspan=42 class=xl11426419 width=573 style='border-right:1.0pt solid black;
					border-left:none;width:436pt'>&nbsp;<?php echo $equipo->fuentes; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=24 style='height:18.0pt'>
      <td colspan=12 height=24 class=xl8226419 width=179 style='border-right:1.0pt solid black;
					height:18.0pt;width:136pt'>3.2 Tecno. Predominante:</td>
      <td colspan=42 class=xl11826419 width=573 style='border-right:1.0pt solid black;
					border-left:none;width:436pt'>&nbsp;<?php echo $equipo->tecnologias; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=24 style='height:18.0pt'>
      <td colspan=12 height=24 class=xl8226419 width=179 style='border-right:1.0pt solid black;
					height:18.0pt;width:136pt'>3.3 Rango de tension [V]:</td>
      <td colspan=42 class=xl11826419 width=573 style='border-right:1.0pt solid black;
					border-left:none;width:436pt'>&nbsp;<?php echo (isset($tension->valor) ? $tension->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=24 style='height:18.0pt'>
      <td colspan=12 height=24 class=xl8226419 width=179 style='border-right:1.0pt solid black;
					height:18.0pt;width:136pt'>3.4 Rango de Temperatura [oC]:</td>
      <td colspan=42 class=xl11826419 width=573 style='border-right:1.0pt solid black;
					border-left:none;width:436pt'>&nbsp;<?php echo (isset($temperatura->valor) ? $temperatura->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=24 style='height:18.0pt'>
      <td colspan=12 height=24 class=xl8226419 width=179 style='border-right:1.0pt solid black;
					height:18.0pt;width:136pt'>3.5 Rango de Humedad [%]:</td>
      <td colspan=42 class=xl11826419 width=573 style='border-right:1.0pt solid black;
					border-left:none;width:436pt'>&nbsp;<?php echo (isset($humedad->valor) ? $humedad->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=24 style='height:18.0pt'>
      <td colspan=12 height=24 class=xl8226419 width=179 style='border-right:1.0pt solid black;
					height:18.0pt;width:136pt'>3.6 Rango de Frecuencia [Hz]:</td>
      <td colspan=42 class=xl11826419 width=573 style='border-right:1.0pt solid black;
					border-left:none;width:436pt'>&nbsp;<?php echo (isset($frecuencia->valor) ? $frecuencia->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr>
    <!-- <tr height=21 style='height:15.75pt'>
      <td colspan=7 height=21 class=xl8226419 width=163 style='border-right:1.0pt solid black;
					height:15.75pt;width:122pt'>3.3 Rango de tensión<span>  </span>[V]</td>
      <td colspan=22 class=xl8226419 width=189 style='border-right:1.0pt solid black;
					border-left:none;width:147pt'>&nbsp;<?php echo (isset($tension->valor) ? $tension->valor : " NO APLICA"); ?></td>
      <td colspan=14 class=xl8226419 width=178 style='border-right:1.0pt solid black;
					border-left:none;width:135pt'>3.4 Rango de corriente [A]</td>
      <td colspan=11 class=xl8226419 width=222 style='border-right:1.0pt solid black;
					border-left:none;width:168pt'>&nbsp;<?php echo (isset($corriente->valor) ? $corriente->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr> -->
    <!-- <tr height=21 style='height:15.75pt'>
      <td colspan=7 height=21 class=xl8226419 width=163 style='border-right:1.0pt solid black;
					height:15.75pt;width:122pt'>3.5 Rango de potencia [W]</td>
      <td colspan=22 class=xl8226419 width=189 style='border-right:1.0pt solid black;
					border-left:none;width:147pt'>&nbsp;<?php echo (isset($potencia->valor) ? $potencia->valor : " NO APLICA"); ?></td>
      <td colspan=14 class=xl8226419 width=178 style='border-right:1.0pt solid black;
					border-left:none;width:135pt'>3.6 Rango de frecuencia [Hz]</td>
      <td colspan=11 class=xl8226419 width=222 style='border-right:1.0pt solid black;
					border-left:none;width:168pt'>&nbsp;<?php echo (isset($frecuencia->valor) ? $frecuencia->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr> -->
    <!-- <tr height=21 style='height:15.75pt'>
      <td colspan=7 height=21 class=xl8226419 width=163 style='border-right:1.0pt solid black;
					height:15.75pt;width:122pt'>3.8 Rango de presión [Pa]</td>
      <td colspan=22 class=xl8226419 width=189 style='border-right:1.0pt solid black;
					border-left:none;width:147pt'>&nbsp;<?php echo (isset($presion->valor) ? $presion->valor : " NO APLICA"); ?></td>
      <td colspan=14 class=xl8226419 width=178 style='border-right:1.0pt solid black;
					border-left:none;width:135pt'>3.9 Rango de velocidad [m/s]</td>
      <td colspan=11 class=xl8226419 width=222 style='border-right:1.0pt solid black;
					border-left:none;width:168pt'>&nbsp;<?php echo (isset($velocidad->valor) ? $velocidad->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr> -->
    <!-- <tr height=21 style='height:15.75pt'>
      <td colspan=14 height=21 class=xl8226419 width=193 style='border-right:1.0pt solid black;
					height:15.75pt;width:147pt'>3.10 Rango de temperatura [°C]</td>
      <td colspan=15 class=xl8226419 width=159 style='border-right:1.0pt solid black;
					border-left:none;width:122pt'>&nbsp;<?php echo (isset($temperatura->valor) ? $temperatura->valor : " NO APLICA"); ?></td>
      <td colspan=14 class=xl8226419 width=178 style='border-right:1.0pt solid black;
					border-left:none;width:135pt'>3.11 Rango de humedad %</td>
      <td colspan=11 class=xl8226419 width=222 style='border-right:1.0pt solid black;
					border-left:none;width:168pt'>&nbsp;<?php echo (isset($humedad->valor) ? $humedad->valor : " NO APLICA"); ?></td>
      <td class=xl1526419></td>
    </tr> -->
    <tr height=21 style='height:15.75pt'>
      <td colspan=54 height=21 class=xl13026419 width=752 style='border-right:1.0pt solid black;
					height:15.75pt;width:572pt'>3.7 OTROS:
        <?php if (isset($otro)) : ?>
          <ul>
            @foreach($otro as $otro_row)
              <li><?php echo $otro_row->valor; ?></li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
        
        <?php if (isset($archivo)) : ?>
          <ul>
            @foreach($archivo as $archivo_row)
              <li>Archivo: <?php echo $archivo_row->file; ?> <a style="color: #222d32;font-size:15px;font-weight:900;" href="{{ asset('') }}assets/upload_archivos/<?php echo $archivo_row->file; ?>" onclick="window.open(this.href, 'mywin',
					'left=20,top=20,width=600,height=600,toolbar=1,resizable=0'); return false;" class="fa fa-paperclip esconder"></a></li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      </td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=14 height=21 class=xl16826419 style='height:15.75pt'>Evaluacion
        de desempeño:<span> </span></td>
      <td colspan=6 class=xl17226419 width=66 style='border-right:1.0pt solid black;
							width:51pt'>&nbsp;<?php echo $equipo->evaluacion_desempenio; ?></td>
      <td colspan=11 class=xl13926419 width=112 style='border-right:1.0pt solid black;
							border-bottom:1.0pt solid black;border-left:none;width:85pt'>Calibración:</td>
      <td colspan=6 class=xl11826419 width=72 style='border-right:1.0pt solid black;
							border-left:none;width:55pt'>&nbsp;<?php echo $equipo->calibracion; ?></td>
      <td colspan=6 class=xl13326419 width=87 style='border-right:1.0pt solid black;
							border-left:none;width:66pt'>Periodicidad:</td>
      <td colspan=11 class=xl13326419 width=222 style='border-right:1.0pt solid black;
							border-left:none;width:168pt'>&nbsp;<?php
                                                  if ($equipo->calibracion == "SI")
                                                    echo $equipo->periodicidad;
                                                  else
                                                    echo "NO APLICA";
                                                  ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=22 style='height:16.5pt'>
      <td colspan=14 height=22 class=xl17026419 width=193 style='height:16.5pt;
							width:147pt'>Frecuencia de mantenimiento:</td>
      <td colspan=13 class=xl17526419 width=128 style='width:99pt'>&nbsp;{{ $frecuency_computed }}</td>
      <td colspan=11 class=xl13326419 width=133 style='border-right:1.0pt solid black;
							width:100pt'>Meses programados</td>
      <td colspan=6 class=xl17826419 width=102 style='border-left:none;width:78pt'>M1:&nbsp;<?php echo $equipo->preventivo_mes1; ?></td>
      <td colspan=6 class=xl17826419 width=99 style='border-left:none;width:75pt'>M2:&nbsp;<?php echo $equipo->preventivo_mes2; ?></td>
      <td colspan=4 class=xl6626419 width=97 style='border-right:1.0pt solid black;
							border-left:none;width:73pt'>M3:&nbsp;<?php echo $equipo->preventivo_mes3; ?></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=22 style='height:16.5pt'>
      <td colspan=54 height=22 class=xl15726419 width=752 style='border-right:1.0pt solid black;
							height:16.5pt;width:572pt'>4. REGISTRO DE APOYO TÉCNICO</td>
      <td class=xl1526419></td>
    </tr>
    <tr height=27 style='height:20.25pt'>
      <td colspan=2 height=27 class=xl18926419 width=82 style='height:20.25pt;
							width:61pt'>MANUALES:</td>
      <td colspan=26 class=xl20126419 width=259 style='border-right:.5pt solid black;
							width:200pt'>
        @if($equipo->manual_id != 0)
          <strong>Url:</strong> &nbsp;
          <a target="__blank" href="<?php echo $equipo->manual_url; ?>"><?php echo $equipo->manual_url; ?></a>
          <br>
          <strong>Descripción:</strong> &nbsp;
          <?php echo $equipo->manual_descripcion; ?>
        <?php endif ?>
        &nbsp; <?php
                if (($equipo->manual != null) && ($equipo->manual != "N;")) : ?>
          <?php
                  $manuales = unserialize($equipo->manual);
                  echo "<ul>";
                  foreach ($manuales as $manual) {
                    echo "<li>" . $manual . "</li>";
                  }
                  echo "</ul>";
          ?>
        <?php endif ?>
      </td>
      <td colspan=8 class=xl18526419 width=63 style='width:48pt'>PLANOS:</td>
      <td colspan=18 class=xl20126419 width=348 style='border-right:.5pt solid black;
							width:263pt'>&nbsp; <?php
                                  if (($equipo->plano != null) && ($equipo->plano != "N;")) : ?>
          <?php
                                    $planos = unserialize($equipo->plano);
                                    echo "<ul>";
                                    foreach ($planos as $plano) {
                                      echo "<li>" . $plano . "</li>";
                                    }
                                    echo "</ul>";
          ?>
        <?php endif ?></td>
      <td class=xl1526419></td>
    </tr>
    @if($equipo->tipo_id == 1)
      <tr height=23 style='height:17.25pt'>
        <td colspan=13 rowspan=2 height=44 class=xl19026419 width=184 style='border-bottom:.5pt solid black;height:33.0pt;width:140pt'>CLASIFICACIÓN
          BIOMÉDICA:<span> </span></td>
        <td colspan=19 rowspan=2 class=xl19326419 width=195 style='border-right:.5pt solid black;
							border-bottom:.5pt solid black;width:149pt'>&nbsp;<?php echo $equipo->clasificaciones; ?></td>
        <td colspan=15 rowspan=2 class=xl19026419 width=225 style='border-bottom:
							.5pt solid black;width:171pt'>CLASIFICACION DE ACUERDO AL RIESGO:</td>
        <td colspan=7 rowspan=2 class=xl19026419 width=148 style='border-right:.5pt solid black;
							border-bottom:.5pt solid black;width:112pt'>&nbsp;<?php echo $equipo->criesgos; ?></td>
        <td class=xl1526419></td>
      </tr>
      <tr height=21 style='height:15.75pt'>
        <td height=21 class=xl1526419 style='height:15.75pt'></td>
      </tr>
    <?php endif ?>
    <tr height=22 style='height:16.5pt'>
      <td colspan=54 height=22 class=xl12626419 width=752 style='border-right:1.0pt solid black;
							height:16.5pt;width:572pt'>5. COMPONENTES</td>
      <td class=xl1526419></td>
    </tr>
    <tr height=23 style='height:17.25pt'>
      <td colspan=54 height=23 class=xl12726419 width=752 style='border-right:1.0pt solid black;
							height:17.25pt;width:572pt'>&nbsp;

        @if($equipo->accesorios != null && $equipo->accesorios != "")
          <?php echo nl2br($equipo->accesorios); ?>
        @else
        <?php endif ?>
      </td>
      <td class=xl1526419></td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=54 height=21 class=xl7226419 width=752 style='border-right:1.0pt solid black;
							height:15.75pt;width:572pt'><b>PROPIETARIO</b></td>
      <td class=xl1526419>&nbsp;</td>
    </tr>
    <tr height=21 style='height:15.75pt'>
      <td colspan=54 height=21 class=xl12726419 width=752 style='border-right:1.0pt solid black;
							height:15.75pt;width:572pt'>&nbsp;
        <div class="row row-owner">
          <div class="col-sm-4">
            <?php echo $equipo->propietario; ?>
          </div>
          <div class="col-sm-4">
            <img class="img-responsive" src="{{ asset('') }}assets/upload_imagenes/<?php echo $equipo->propietario_logo; ?>" alt="Logo del propietario">
          </div>
          @if($equipo->baja_id != 0)
            <div class="col-sm-4">
              <h5><u>Este equipo ha sido relacionado a inventaio para su correspondiente disposición final</u></h4>
                <small class="text-muted"><?php echo $equipo->baja_fecha; ?></small>
                <strong>Descripcion del documento de disposición final:</strong><br>
                <?php echo $equipo->baja; ?>
                <a class="fa fa-paperclip" target="__blank" href="{{ asset('') }}assets/upload_bajas/<?php echo $equipo->baja_documento; ?>"></a>
            </div>
          <?php endif ?>
        </div>
      </td>
      <td class=xl1526419></td>
    </tr>
    <?php if (!empty($archivos)) : ?>
      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl7226419 width=752 style='border-right:1.0pt solid black;
							height:16.5pt;width:572pt'>ARCHIVOS ASOCIADOS</td>
        <td class=xl1526419></td>
      </tr>
      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl12726419 width=752 style='border-right:1.0pt solid black;
							height:16.5pt;width:572pt'>&nbsp;
          <ul>
            @foreach($archivos as $archivo_singular)
              <li>
                <?php echo $archivo_singular->archivo; ?>(<?php echo $archivo_singular->otro; ?>)<a target="__blank" class="glyphicon glyphicon-file esconder" href="<?= base_url(); ?>assets/upload_equipo_archivos/<?php echo $archivo_singular->vinculo; ?>"></a>
              </li>
            <?php endforeach ?>
          </ul>
        </td>
        <td class=xl1526419></td>
      </tr>
    <?php endif ?>
    <?php if (!empty($correctivos)) : ?>
      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl16026419 width=752 style='border-right:1.0pt solid black;
						height:16.5pt;width:572pt'>CORRECTIVOS TICKETS</td>
        <td class=xl1526419></td>
      </tr>
      <tbody class="apendice_tickets">
        <tr height="27" style="height:20.25pt">
          <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
							width:61pt">ID Orden</td>
          <td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;
							width:200pt">Descripción </td>
          <td colspan="13" class="xl18526419" width="63" style="width:48pt">Estado</td>
          <td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;
							width:263pt">Archivo relacionado </td>
          <td class="xl1526419"></td>
        </tr>
      </tbody>
    <?php endif ?>
    <?php if (!empty($correctivos_generales)) : ?>

      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl16026419 width=752 style='border-right:1.0pt solid black;
						height:16.5pt;width:572pt'>CORRECTIVOS GENERALES</td>
        <td class=xl1526419></td>
      </tr>
      <tbody class="apendice_correctivo_general">
        <tr height="27" style="height:20.25pt">
          <td colspan="18.17" height="27" class="xl18926419" width="82" style="border-right:.5pt solid black;height:20.25pt;
							width:61pt">Orden de trabajo</td>
          <td colspan="18.17" class="xl18526419" width="63" style="width:48pt">Cierre</td>
          <td colspan="18.17" class="xl20126419" width="348" style="border-right:.5pt solid black;
							width:263pt">Archivos </td>
          <td class="xl1526419"></td>
        </tr>
      </tbody>
    <?php endif ?>
    <?php if (!empty($preventivos)) : ?>
      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl16026419 width=752 style='border-right:1.0pt solid black;
						height:16.5pt;width:572pt'>PREVENTIVOS</td>
        <td class=xl1526419></td>
      </tr>
      <tbody class="apendice_preventivo">
        <tr height="27" style="height:20.25pt">
          <td colspan="18.17" height="27" class="xl18926419" width="82" style="border-right:.5pt solid black;height:20.25pt;
							width:61pt">ID preventivo</td>
          <td colspan="18.17" class="xl18526419" width="63" style="width:48pt">Fecha ejecución</td>
          <td colspan="18.17" class="xl20126419" width="348" style="border-right:.5pt solid black;
							width:263pt">Archivo relacionado</td>
          <td class="xl1526419"></td>
        </tr>
      </tbody>
    <?php endif ?>
    <?php if (!empty($calibraciones)) : ?>
      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl16026419 width=752 style='border-right:1.0pt solid black;
						height:16.5pt;width:572pt'>CALIBRACIONES</td>
        <td class=xl1526419></td>
      </tr>
      <tbody class="apendice_calibracion">
        <tr height="27" style="height:20.25pt">
          <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
							width:61pt">ID calibración</td>
          <td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;
							width:200pt">Fecha ejecución </td>
          <td colspan="13" class="xl18526419" width="63" style="width:48pt">Fecha programada</td>
          <td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;
							width:263pt">Archivo relacionado </td>
          <td class="xl1526419"></td>
        </tr>
      </tbody>
    <?php endif ?>
    <?php if (!empty($contingencias)) : ?>

      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl16026419 width=752 style='border-right:1.0pt solid black;
						height:16.5pt;width:572pt'>CONTINGENCIAS</td>
        <td class=xl1526419></td>
      </tr>
      <tbody class="apendice_contingencia">
        <tr height="27" style="height:20.25pt">
          <th colspan="18.17" height="27" class="xl18926419" width="82" style="border-right:.5pt solid black;height:20.25pt;
							width:61pt">Observaciones</th>
          <th colspan="18.17" class="xl18526419" width="63" style="width:48pt">Fecha</th>
          <th colspan="18.17" class="xl20126419" width="348" style="border-right:.5pt solid black;
							width:263pt">Archivo relacionado</th>
          <th class="xl1526419"></th>
        </tr>
      </tbody>
    <?php endif ?>
    <?php if (!empty($repuestos)) : ?>

      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl16026419 width=752 style='border-right:1.0pt solid black;
						height:16.5pt;width:572pt'>REPUESTOS</td>
        <td class=xl1526419></td>
      </tr>
      <tbody class="apendice_equipo_repuesto">
        <tr height="27" style="height:20.25pt">
          <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
							width:61pt">Cantidad entregada</td>
          <td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;
							width:200pt">Fecha instalacion </td>
          <td colspan="13" class="xl18526419" width="63" style="width:48pt">Nombre</td>
          <td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;
							width:263pt">Archivo relacionado </td>
          <td class="xl1526419"></td>
        </tr>
      </tbody>
    <?php endif ?>
    <?php if (($equipo->observacion != null && $equipo->observacion != "") || ((isset($observaciones)) && (!empty($observaciones)))) : ?>
      <tr height=21 style='height:15.75pt'>
        <td colspan=54 height=21 class=xl7226419 width=752 style='border-right:1.0pt solid black;
					height:15.75pt;width:572pt'>OBSERVACIONES</td>
        <td class=xl1526419></td>
      </tr>
      <tr height=22 style='height:16.5pt'>
        <td colspan=54 height=22 class=xl12726419 width=752 style='border-right:1.0pt solid black;
					height:16.5pt;width:572pt'>&nbsp;
          @if($equipo->observacion != null && $equipo->observacion != "")
            <p>
              <?php echo nl2br($equipo->observacion); ?>
            @else
              <br>
            </p>
          <?php endif ?>
          <?php if (isset($observaciones)) : ?>

            @foreach($observaciones as $observacion_row)
              <?php if ($this->session->Userdata("rol_id") > 2 && $observacion_row->id == 557) : ?>
              @else
                <p> <strong><?php echo $observacion_row->created_at; ?></strong>
                  @if($observacion_row->file != null && $observacion_row->file != "")
                    <a href="<?= base_url(); ?>assets/upload_observaciones/<?php echo $observacion_row->file; ?>" target="__blank" class="glyphicon glyphicon-file"></a>
                  <?php endif ?>
                  <br>
                  Usuario: <?php echo ($observacion_row->usuario != null && $observacion_row->usuario != "") ? $observacion_row->usuario : "No registra"; ?>
                  <br>
                  <?php echo $observacion_row->description; ?>
                </p>
                <span class="glyphicon glyphicon-wrench text-danger" title="Repuesto pendiente"><?php echo $observacion_row->repuesto_id; ?></span>
                @if($observacion_row->repuesto_id != null && $observacion_row->repuesto_id != NULL && $observacion_row->repuesto_id != "" && $observacion_row->repuesto_pendiente == "si")
                  <span class="glyphicon glyphicon-wrench text-danger" title="Repuesto pendiente"><?php echo $observacion_row->repuesto_id; ?></span>
                <?php endif ?>
                <p></p>
              <?php endif ?>
            <?php endforeach ?>
          <?php endif ?>
        </td>
        <td class=xl1526419></td>
      </tr>
    <?php endif ?>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl15626419 width=35 style='height:15.0pt;width:26pt'></td>
      <td class=xl15626419 width=47 style='width:35pt'></td>
      <td class=xl15626419 width=19 style='width:14pt'></td>
      <td class=xl15626419 width=5 style='width:4pt'></td>
      <td class=xl15626419 width=55 style='width:41pt'></td>
      <td class=xl15626419 width=0></td>
      <td class=xl15626419 width=2 style='width:2pt'></td>
      <td class=xl15626419 width=6 style='width:5pt'></td>
      <td class=xl15626419 width=2 style='width:2pt'></td>
      <td class=xl15626419 width=0></td>
      <td class=xl15626419 width=2 style='width:2pt'></td>
      <td class=xl15626419 width=6 style='width:5pt'></td>
      <td class=xl15626419 width=5 style='width:4pt'></td>
      <td class=xl15626419 width=9 style='width:7pt'></td>
      <td class=xl15626419 width=14 style='width:11pt'></td>
      <td class=xl15626419 width=8 style='width:6pt'></td>
      <td class=xl15626419 width=9 style='width:7pt'></td>
      <td class=xl15626419 width=7 style='width:5pt'></td>
      <td class=xl15626419 width=10 style='width:8pt'></td>
      <td class=xl15626419 width=18 style='width:14pt'></td>
      <td class=xl15626419 width=6 style='width:5pt'></td>
      <td class=xl15626419 width=8 style='width:6pt'></td>
      <td class=xl15626419 width=10 style='width:8pt'></td>
      <td class=xl15626419 width=5 style='width:4pt'></td>
      <td class=xl15626419 width=10 style='width:8pt'></td>
      <td class=xl15626419 width=15 style='width:11pt'></td>
      <td class=xl15626419 width=8 style='width:6pt'></td>
      <td class=xl15626419 width=20 style='width:15pt'></td>
      <td class=xl15626419 width=11 style='width:8pt'></td>
      <td class=xl15626419 width=12 style='width:9pt'></td>
      <td class=xl15626419 width=7 style='width:5pt'></td>
      <td class=xl15626419 width=8 style='width:6pt'></td>
      <td class=xl15626419 width=10 style='width:8pt'></td>
      <td class=xl15626419 width=4 style='width:3pt'></td>
      <td class=xl15626419 width=6 style='width:5pt'></td>
      <td class=xl15626419 width=5 style='width:4pt'></td>
      <td class=xl15626419 width=39 style='width:29pt'></td>
      <td class=xl15626419 width=11 style='width:8pt'></td>
      <td class=xl15626419 width=11 style='width:8pt'></td>
      <td class=xl15626419 width=10 style='width:8pt'></td>
      <td class=xl15626419 width=21 style='width:16pt'></td>
      <td class=xl15626419 width=17 style='width:13pt'></td>
      <td class=xl15626419 width=17 style='width:13pt'></td>
      <td class=xl15626419 width=26 style='width:20pt'></td>
      <td class=xl15626419 width=11 style='width:8pt'></td>
      <td class=xl15626419 width=14 style='width:11pt'></td>
      <td class=xl15626419 width=23 style='width:17pt'></td>
      <td class=xl15626419 width=18 style='width:14pt'></td>
      <td class=xl15626419 width=12 style='width:9pt'></td>
      <td class=xl15626419 width=21 style='width:16pt'></td>
      <td class=xl15626419 width=17 style='width:13pt'></td>
      <td class=xl15626419 width=5 style='width:4pt'></td>
      <td class=xl15626419 width=32 style='width:24pt'></td>
      <td class=xl15626419 width=43 style='width:32pt'></td>
      <td class=xl1526419></td>
    </tr>
    <tr height=20 style='height:15.0pt'>
      <td height=20 class=xl1526419 colspan=5 style='height:15.0pt'>Código:
        REG-TEC-009</td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
      <td class=xl1526419 colspan=4>Versión: 0</td>
      <td class=xl1526419></td>
      <td class=xl1526419></td>
    </tr>
    <![if supportMisalignedColumns]>
    <tr height=0 style='display:none'>
      <td width=35 style='width:26pt'></td>
      <td width=47 style='width:35pt'></td>
      <td width=19 style='width:14pt'></td>
      <td width=5 style='width:4pt'></td>
      <td width=55 style='width:41pt'></td>
      <td width=0></td>
      <td width=2 style='width:2pt'></td>
      <td width=6 style='width:5pt'></td>
      <td width=2 style='width:2pt'></td>
      <td width=0></td>
      <td width=2 style='width:2pt'></td>
      <td width=6 style='width:5pt'></td>
      <td width=5 style='width:4pt'></td>
      <td width=9 style='width:7pt'></td>
      <td width=14 style='width:11pt'></td>
      <td width=8 style='width:6pt'></td>
      <td width=9 style='width:7pt'></td>
      <td width=7 style='width:5pt'></td>
      <td width=10 style='width:8pt'></td>
      <td width=18 style='width:14pt'></td>
      <td width=6 style='width:5pt'></td>
      <td width=8 style='width:6pt'></td>
      <td width=10 style='width:8pt'></td>
      <td width=5 style='width:4pt'></td>
      <td width=10 style='width:8pt'></td>
      <td width=15 style='width:11pt'></td>
      <td width=8 style='width:6pt'></td>
      <td width=20 style='width:15pt'></td>
      <td width=11 style='width:8pt'></td>
      <td width=12 style='width:9pt'></td>
      <td width=7 style='width:5pt'></td>
      <td width=8 style='width:6pt'></td>
      <td width=10 style='width:8pt'></td>
      <td width=4 style='width:3pt'></td>
      <td width=6 style='width:5pt'></td>
      <td width=5 style='width:4pt'></td>
      <td width=39 style='width:29pt'></td>
      <td width=11 style='width:8pt'></td>
      <td width=11 style='width:8pt'></td>
      <td width=10 style='width:8pt'></td>
      <td width=21 style='width:16pt'></td>
      <td width=17 style='width:13pt'></td>
      <td width=17 style='width:13pt'></td>
      <td width=26 style='width:20pt'></td>
      <td width=11 style='width:8pt'></td>
      <td width=14 style='width:11pt'></td>
      <td width=23 style='width:17pt'></td>
      <td width=18 style='width:14pt'></td>
      <td width=12 style='width:9pt'></td>
      <td width=21 style='width:16pt'></td>
      <td width=17 style='width:13pt'></td>
      <td width=5 style='width:4pt'></td>
      <td width=32 style='width:24pt'></td>
      <td width=43 style='width:32pt'></td>
      <td width=80 style='width:60pt'></td>
    </tr>
    <![endif]>
  </table>
</div>