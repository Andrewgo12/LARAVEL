<strong>Nombre:</strong> {{ $usuario->nombre }}<br>
<strong>Apellido:</strong> {{ $usuario->apellido }}<br>
<strong>Teléfono:</strong> {{ $usuario->telefono }}<br>
<strong>Email:</strong> {{ $usuario->email }}<br>
<strong>Username:</strong> {{ $usuario->username }}<br>
<strong>Rol:</strong> {{ $usuario->rol }}<br>

@if (!is_null($usuario->id_empresa) && $usuario->id_empresa != 0 && $usuario->id_empresa != "")
  <strong>Empresa del usuario:</strong> {{ $usuario->empresa }}<br>
@endif
