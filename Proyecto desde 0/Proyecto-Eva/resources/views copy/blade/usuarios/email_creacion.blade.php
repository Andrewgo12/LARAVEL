<h2>Usuario Nro: {{ $usuario->id }}</h2>

<p><h3>Eva Gestiona la tecnología</h3></p>

<h4>Asunto:&nbsp;</h4>Creación de Cuenta exitosa

<blockquote>
  <h4>Información del usuario registrado</h4>
  <div style="font-size: 5px;">
    Tenga en cuenta que si el email ingresado no es válido la cuenta será eliminada en un periodo de 1 a 2 días
  </div>

  <ul>
    <li style="font-size: 9px"><strong>Nombre del usuario</strong>: {{ $usuario->nombre }}</li>
    <li style="font-size: 9px"><strong>Apellido del usuario</strong>: {{ $usuario->apellido }}</li>
    <li style="font-size: 9px"><strong>Teléfono</strong>: {{ $usuario->telefono }}</li>
    <li style="font-size: 9px"><strong>Email</strong>: {{ $usuario->email }}</li>
    <li style="font-size: 9px"><strong>Nombre de usuario</strong>: {{ $usuario->username }}</li>
    <li style="font-size: 9px"><strong>Contraseña</strong>: {{ $usuario->password }}</li>
  </ul>

  <footer style="font-size: 5px;">Eva te da la bienvenida</footer>
</blockquote>
