<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
                                        <h2><strong>Ticket Nro {{ $orden->id }}</strong></h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <h3>Eva Gestiona la tecnología</h3>
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
                                                <li><strong>ID del equipo</strong>: {{ $equipo->id }}</li>
                                                <li><strong>Nombre</strong>: {{ $equipo->name }}</li>
                                                <li><strong>Marca</strong>: {{ $equipo->marca }}</li>
                                                <li><strong>Modelo</strong>: {{ $equipo->modelo }}</li>
                                                <li><strong>Activo fijo</strong>: {{ $equipo->code }}</li>
                                                <li><strong>Serie</strong>: {{ $equipo->serial }}</li>
                                                <li><strong>Prioridad</strong>: {{ $orden->prioridad }}</li>
                                            </ul>
                                        @else
                                            <ul>
                                                <li><strong>Nombre</strong>: {{ $orden->nombre_equipo }}</li>
                                                <li><strong>Marca</strong>: {{ $orden->marca_equipo }}</li>
                                                <li><strong>Modelo</strong>: {{ $orden->modelo_equipo }}</li>
                                                <li><strong>Activo fijo</strong>: {{ $orden->codigo_equipo }}</li>
                                                <li><strong>Serie</strong>: {{ $orden->serie_equipo }}</li>
                                                <li><strong>Prioridad</strong>: {{ $orden->prioridad }}</li>
                                            </ul>
                                        @endif

                                        @if(!empty($orden->nombre_reportante))
                                            <blockquote><h4>Usuario administrador que registra la orden</h4></blockquote>
                                            <ul>
                                                <li><strong>Nombre</strong>: {{ session('nombre') }}</li>
                                                <li><strong>Apellido</strong>: {{ session('apellido') }}</li>
                                                <li><strong>Teléfono</strong>: {{ session('telefono') }}</li>
                                                <li><strong>Email</strong>: {{ session('email') }}</li>
                                            </ul>

                                            <blockquote><h4>Información del solicitante</h4></blockquote>
                                            <ul>
                                                <li><strong>Nombre</strong>: {{ $orden->nombre_reportante }}</li>
                                                <li><strong>Centro de costo</strong>: {{ $orden->centro_costo_reportante }}</li>
                                            </ul>
                                        @else
                                            <h4>Información del Solicitante:</h4>
                                            <ul>
                                                <li><strong>Nombre</strong>: {{ session('nombre') }}</li>
                                                <li><strong>Apellido</strong>: {{ session('apellido') }}</li>
                                                <li><strong>Teléfono</strong>: {{ session('telefono') }}</li>
                                                <li><strong>Email</strong>: {{ session('email') }}</li>
                                            </ul>
                                        @endif

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ee4c50" style="padding: 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                            &reg; Electromedicina, 2019<br/>
                            Hospital Universitario del Valle
                        </td>
                        <td align="right" width="25%">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <a href="http://www.twitter.com/">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" border="0" />
                                        </a>
                                    </td>
                                    <td style="width: 20px;"></td>
                                    <td>
                                        <a href="http://www.fb.com/">
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" border="0" />
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
