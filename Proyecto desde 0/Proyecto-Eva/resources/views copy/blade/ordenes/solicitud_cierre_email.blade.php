<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="http://asamblea.valledelcauca.gov.co/info/asamblea/media/pub43460.jpg" width="300" height="230" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>
                                            <h2>Ticket Nro {{ $orden->id }}</h2>
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>
                                            <h3>Eva Gestiona la tecnología</h3>
                                        </p>
                                        <h4>Asunto:&nbsp;</h4>{{ $orden->asunto }}
                                        <blockquote>
                                            <h4>Descripción</h4>
                                            <p>{{ $orden->descripcion }}</p>
                                            <footer style="font-size: 10px;"><strong>Fecha de registro</strong>: {{ $orden->fecha_inicio }}</footer>
                                        </blockquote>
                                        <blockquote>
                                            <h4>Ubicación de referencia</h4>
                                            <p>{{ $orden->servicio }}</p>
                                            @if(!empty($orden->area) && $orden->area != "null")
                                                <footer style="font-size: 10px;"><strong>Área</strong>: {{ $orden->area }}</footer>
                                            @endif
                                        </blockquote>
                                        <blockquote>
                                            <h4>Información del equipo</h4>
                                        </blockquote>
                                        @if(isset($equipo))
                                            <ul>
                                                <li style="font-size: 15px"><strong>Id del equipo en el sistema </strong>: {{ $equipo->id }}</li>
                                                <li style="font-size: 15px"><strong>Nombre del equipo </strong>: {{ $equipo->name }}</li>
                                                <li style="font-size: 15px"><strong>Marca del equipo </strong>: {{ $equipo->marca }}</li>
                                                <li style="font-size: 15px"><strong>Modelo del equipo </strong>: {{ $equipo->modelo }}</li>
                                                <li style="font-size: 15px"><strong>Activo fijo del equipo </strong>: {{ $equipo->code }}</li>
                                                <li style="font-size: 15px"><strong>Serie del equipo </strong>: {{ $equipo->serial }}</li>
                                                <li style="font-size: 15px"><strong>Prioridad </strong>: {{ $orden->prioridad }}</li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li style="font-size: 15px"><strong>Nombre del equipo </strong>: {{ $orden->nombre_equipo }}</li>
                                                <li style="font-size: 15px"><strong>Marca del equipo </strong>: {{ $orden->marca_equipo }}</li>
                                                <li style="font-size: 15px"><strong>Modelo del equipo </strong>: {{ $orden->modelo_equipo }}</li>
                                                <li style="font-size: 15px"><strong>Activo fijo del equipo </strong>: {{ $orden->codigo_equipo }}</li>
                                                <li style="font-size: 15px"><strong>Serie del equipo </strong>: {{ $orden->serie_equipo }}</li>
                                                <li style="font-size: 15px"><strong>Prioridad </strong>: {{ $orden->prioridad }}</li>
                                            </ul>
                                        @endif

                                        <h4>Información del Solicitante :</h4>
                                        <ul>
                                            <li><strong>Nombre</strong>: {{ $reportante->nombre }} </li>
                                            <li><strong>Apellido</strong>: {{ $reportante->apellido }}</li>
                                            <li><strong>Teléfono</strong>: {{ $reportante->telefono }}</li>
                                        </ul>
                                        <h4>Asignado a la empresa:</h4>{{ $empresa[0]->name }}

                                        @if(!empty($orden->asignado_id))
                                            <h4>Información del usuario asignado:</h4>
                                            <ul>
                                                <li><strong>Nombre</strong>: {{ $asignado->nombre }} </li>
                                                <li><strong>Apellido</strong>: {{ $asignado->apellido }}</li>
                                                <li><strong>Teléfono</strong>: {{ $asignado->telefono }}</li>
                                            </ul>
                                        @endif

                                        <blockquote>
                                            <h4>Información del diagnóstico</h4>
                                            <h4>Diagnóstico:</h4>
                                            <p>{{ $orden->diagnostico }}</p>
                                            <footer style="font-size: 12px;"><strong>Fecha de diagnóstico</strong>: {{ $orden->fecha_diagnostico }}</footer>
                                            <h4>Codificación del Diagnóstico: {{ $orden->codigo_diagnostico }}</h4>
                                            {{ $orden->descripcion_diagnostico }}
                                        </blockquote>

                                        <blockquote>
                                            @if(!empty($orden->tecnico_diagnostico_text))
                                                <h4>Usuario quien realiza el diagnóstico</h4>
                                                {{ $orden->tecnico_diagnostico_text }}
                                            @else
                                                <h4>Usuario quien registra el diagnóstico</h4>
                                                {{ $usuario_diagnostico->nombre ?? '' }} {{ $usuario_diagnostico->apellido ?? '' }}
                                                <h5>
                                                    <p>Email cuenta: {{ $usuario_diagnostico->email ?? '' }}</p>
                                                </h5>
                                            @endif
                                        </blockquote>

                                        <blockquote>
                                            <h4>Información del procedimiento correctivo</h4>
                                            <h4>Trabajo realizado:</h4>
                                            <p>{{ $orden->reparacion }}</p>
                                            <footer style="font-size: 12px;"><strong>Fecha del procedimiento correctivo</strong>: {{ $orden->fecha_asignacion_cierre }}</footer>
                                            <h4>Codificación del procedimiento correctivo: {{ $orden->codigo_cierre }}</h4>
                                            {{ $orden->descripcion_cierre }}
                                        </blockquote>
                                        <blockquote>
                                            @if(!empty($orden->tecnico_cierre_text))
                                                <h4>Usuario quien realiza el procedimiento correctivo</h4>
                                                {{ $orden->tecnico_cierre_text }}
                                            @else
                                                <h4>Usuario quien registra el procedimiento correctivo</h4>
                                                {{ $usuario_actual->nombre ?? '' }} {{ $usuario_actual->apellido ?? '' }}
                                                <h5>
                                                    <p>Email cuenta: {{ $usuario_actual->email ?? '' }}</p>
                                                </h5>
                                            @endif
                                        </blockquote>
                                        <p>
                                            La orden está pendiente por cerrarse, por favor cierre la orden desde el aplicativo EVA.
                                            Para hacerlo diríjase al apartado de Mis Tickets y en el ticket correspondiente presione Cerrar.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                            &reg; Electromedicina, 2019<br />
                            <a href="#" style="color: #ffffff;">
                                <font color="#ffffff"></font>
                            </a>Hospital Universitario del Valle
                        </td>
                        <td align="right" width="25%">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                        <a href="http://www.twitter.com/" style="color: #ffffff;">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                        </a>
                                    </td>
                                    <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                        <a href="http://www.fb.com/" style="color: #ffffff;">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
