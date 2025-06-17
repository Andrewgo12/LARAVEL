<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <small>Información de perfil</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body">
        <hr>
        <div class="row contenedor-cuenta">
          <div class="col-md-12 table-responsive">
            <div class="box-body form-horizontal">

              <span class="errores"></span>
              <ul>
                <li>
                  <strong>Selección de sede</strong>:
                  <select class="cambio_sede_general">
                    @if ($usuario->sede_id == 1)
                      <option value="">Todo</option>
                      <option value="1" selected>Sede principal</option>
                      <option value="2">Sede norte</option>
                    @elseif ($usuario->sede_id == 2)
                      <option value="">Todo</option>
                      <option value="1">Sede principal</option>
                      <option value="2" selected>Sede norte</option>
                    @else
                      <option value="" selected>Todo</option>
                      <option value="1">Sede principal</option>
                      <option value="2">Sede norte</option>
                    @endif
                  </select>
                </li>
              </ul>

              <div class="form-group">
                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                  <input readonly value="{{ $usuario->nombre }}" type="text" class="form-control" name="nombre" id="add_nombre_usuario" placeholder="Nombre">
                </div>
              </div>

              <div class="form-group">
                <label for="apellido" class="col-sm-2 control-label">Apellidos</label>
                <div class="col-sm-10">
                  <input readonly value="{{ $usuario->apellido }}" type="text" class="form-control" name="apellido" id="add_apellido_usuario" placeholder="Apellido">
                </div>
              </div>

              <div class="form-group">
                <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
                <div class="col-sm-10">
                  <input readonly value="{{ $usuario->telefono }}" type="number" class="form-control" name="telefono" id="add_telefono_usuario" placeholder="Teléfono">
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input readonly value="{{ $usuario->email }}" type="email" class="form-control" name="email" id="add_email_usuario" placeholder="Email">
                </div>
              </div>

              <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input readonly value="{{ $usuario->username }}" type="text" class="form-control" name="username" id="add_username_usuario" placeholder="Username">
                </div>
              </div>

              <div class="form-group">
                <label for="rol" class="col-sm-2 control-label">Rol</label>
                <div class="col-sm-10">
                  <input readonly class="form-control" type="text" value="{{ $usuario->rol }}">
                </div>
              </div>

              <div class="form-group">
                <label for="centro" class="col-sm-2 control-label">Centro de costo</label>
                <div class="col-sm-10">
                  <input readonly class="form-control" type="text" value="{{ $usuario->centro }}">
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Contraseña</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
                  <a href="#" onclick="update_pwd({{ $usuario->id }}, event)" class="btn btn-xs btn-primary mt-2">Actualizar contraseña</a>
                </div>
              </div>

            </div> <!-- .box-body -->
          </div>
        </div>
      </div> <!-- /.box-body -->
    </div> <!-- /.box -->
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script>
  const base_url = "{{ url('/') }}";
  const anio_plan = "{{ session('anio_plan') }}";
  const usuario_id = "{{ session('id') }}";
</script>
