<strong>Nombre: </strong> <?php echo $usuario->nombre; ?><br>
<strong>apellido: </strong> <?php echo $usuario->apellido; ?><br>
<strong>telefono: </strong> <?php echo $usuario->telefono; ?><br>
<strong>email: </strong> <?php echo $usuario->email; ?><br>
<strong>username: </strong> <?php echo $usuario->username; ?><br>
<strong>rol: </strong> <?php echo $usuario->rol; ?><br>
@if($usuario->id_empresa!=null&&$usuario->id_empresa!=0&&$usuario->id_empresa!="")
	<strong>Empresa del usuario: </strong> <?php echo $usuario->empresa; ?><br>
<?php endif ?>