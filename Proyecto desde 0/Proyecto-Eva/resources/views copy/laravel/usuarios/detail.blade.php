<strong>Nombre: </strong> {{ $usuario->nombre }}<br>
<strong>apellido: </strong> {{ $usuario->apellido }}<br>
<strong>telefono: </strong> {{ $usuario->telefono }}<br>
<strong>email: </strong> {{ $usuario->email }}<br>
<strong>username: </strong> {{ $usuario->username }}<br>
<strong>rol: </strong> {{ $usuario->rol }}<br>
@if($usuario->id_empresa!=null&&$usuario->id_empresa!=0&&$usuario->id_empresa!="")
	<strong>Empresa del usuario: </strong> {{ $usuario->empresa }}<br>
<?php endif ?>