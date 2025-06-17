<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/></head>
<body style="margin: 0; padding: 0;">    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">                    <tr>
                        <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">                            <img src="http://asamblea.valledelcauca.gov.co/info/asamblea/media/pub43460.jpg" width="300" height="230" style="display: block;" />
                        </td>                    </tr>
                    <tr>                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">                                        <b><h2>Actualización del Ticket Nro {{ $orden->id }}</h2></b>
                                    </td>                                </tr>
                                <tr>                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p><h3>Eva Gestiona la tecnología</h3></p>                                        <h4>Asunto:&nbsp;</h4>{{ $orden->asunto }}
                                                                                <blockquote>
                                            <h4>Estado actual del ticket</h4>                                            <p>
                                                @if($orden->estado_id == 1)                                                    <strong>Estado:</strong> Creado
                                                @elseif($orden->estado_id == 2)                                                    <strong>Estado:</strong> Asignado
                                                @elseif($orden->estado_id == 3)                                                    <strong>Estado:</strong> Diagnosticado
                                                @elseif($orden->estado_id == 4)                                                    <strong>Estado:</strong> Cerrado
                                                @else                                                    <strong>Estado:</strong> Cerrado
                                                @endif                                            </p>
                                            <footer style="font-size: 10px;"><strong>Fecha de actualización:</strong> {{ date('Y-m-d H:i:s') }}</footer>                                        </blockquote>
                                        <blockquote>
                                            <h4>Descripción original</h4>                                            <p>{{ $orden->descripcion }}</p>
                                            <footer style="font-size: 10px;"><strong>Fecha de registro:</strong> {{ $orden->fecha_inicio }}</footer>                                        </blockquote>
                                        <blockquote>
                                            <h4>Ubicación de referencia</h4>                                            <p>{{ $orden->servicio }}</p>
                                            @if($orden->area != "" && $orden->area != "null")                                                <footer style="font-size: 10px;"><strong>Área:</strong> {{ $orden->area }}</footer>
                                            @endif                                        </blockquote>
                                        @if($orden->estado_id >= 2)
                                            <blockquote>                                                <h4>Información de asignación</h4>
                                                <p><strong>Asignado a la empresa:</strong>                                                     @if(isset($empresa) && count($empresa) > 0)
                                                        {{ $empresa[0]->name }}                                                    @endif
                                                </p>
                                                @if($orden->asignado_id != NULL && $orden->asignado_id != "" && $orden->asignado_id != 0)                                                    @if(isset($asignado))
                                                        <p><strong>Técnico asignado:</strong> {{ $asignado->nombre }} {{ $asignado->apellido }}</p>                                                        <p><strong>Teléfono:</strong> {{ $asignado->telefono }}</p>
                                                    @endif                                                @endif
                                                                                                <footer style="font-size: 10px;"><strong>Fecha de asignación:</strong> {{ $orden->fecha_asignacion ?? 'No disponible' }}</footer>
                                            </blockquote>                                        @endif
                                        @if($orden->estado_id >= 3)
                                            <blockquote>                                                <h4>Información del diagnóstico</h4>
                                                <p>{{ $orden->diagnostico }}</p>
                                                @if($orden->codigo_diagnostico)                                                    <p><strong>Codificación del Diagnóstico:</strong> {{ $orden->codigo_diagnostico }}</p>
                                                    <p>{{ $orden->descripcion_diagnostico }}</p>                                                @endif
                                                                                                @if(isset($repuestos) && count($repuestos) > 0)
                                                    <h4>Repuestos necesarios:</h4>                                                    <ul>
                                                        @foreach($repuestos as $repuesto)                                                            <li>{{ $repuesto->name }}</li>
                                                        @endforeach                                                    </ul>
                                                @endif
                                                <footer style="font-size: 12px;"><strong>Fecha de diagnóstico:</strong> {{ $orden->fecha_diagnostico }}</footer>                                            </blockquote>
                                        @endif
                                        @if($orden->estado_id == 4)                                            <blockquote>
                                                <h4>Información de cierre</h4>                                                <p><strong>Solución aplicada:</strong></p>
                                                <p>{{ $orden->reparacion }}</p>
                                                <footer style="font-size: 12px;"><strong>Fecha de cierre:</strong> {{ $orden->fecha_fin }}</footer>                                            </blockquote>
                                        @endif
                                        <p>Para más información, por favor ingrese al sistema o contacte al departamento de soporte técnico.</p>                                    </td>
                                </tr>                            </table>
                        </td>                    </tr>
                </table>            </td>
        </tr>        <tr>
            <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                            &reg; Electromedicina, {{ date('Y') }}<br/>                            <a href="#" style="color: #ffffff;"><font color="#ffffff"></font></a>Hospital Universitario del Valle
                        </td>                        <td align="right" width="25%">
                            <table border="0" cellpadding="0" cellspacing="0">                                <tr>
                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">                                        <a href="http://www.twitter.com/" style="color: #ffffff;">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />                                        </a>
                                    </td>                                    <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">                                        <a href="http://www.fb.com/" style="color: #ffffff;">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />                                        </a>
                                    </td>                                </tr>
                            </table>                        </td>
                    </tr>                </table>
            </td>        </tr>
    </table>
</body>












































































<?php print_r($orden); ?>
