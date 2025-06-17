<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Usuarios
      <small>Listado</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <a href="#" data-toggle="modal" data-target="#modal_add_usuario" class="btn btn-lg btn-primary fa fa-plus btn-flat">Nuevo usuario</a>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <table style="text-transform: lowercase;" class="table table-condensed table-sm table-bordered" id="tblUsuarios">
              <thead>
                <tr>
                  <th>Nombres y Apellidos</th>
                  <th>Centro de Costo</th>
                  <th>Login</th>
                  <th>Rol</th>
                  <th style="width: 20%;">Opciones</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Relación zonas - usuarios -->
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <h3>Relación Zonas - Usuarios</h3>
        <blockquote>
          <a onclick="funcion_modal_add_usuario_zona(event)" data-toggle="modal" data-target="#modal_add_usuario_zona" href="#" class="glyphicon glyphicon-plus"></a>
          Agregar Nueva Relación
        </blockquote>
        <div class="row">
          <div class="table-responsive col-md-12 tblusuarioszonas">
            <table style="text-transform: lowercase;" class="table table-sm table-condensed table-bordered">
              <thead>
                <tr>
                  <th>Nombre de la Zona</th>
                  <th>Nombre del Usuario</th>
                  <th>Correo Electrónico</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="4">Cargando...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Relación empresas - usuarios -->
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <h3>Relación Empresas - Usuarios</h3>
        <div class="row">
          <div class="table-responsive col-md-12">
            <div class="contenedor-tblEmpresas">
              <!-- Aquí va el contenido dinámico -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Módulos -->
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <h3>Módulos</h3>
        <table class="table table-bordered table-condensed table-hover tblModulos">
          <thead>
            <tr>
              <th>#</th>
              <th>Módulo</th>
              <th># Cuentas Afectadas</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($modulos as $modulo)
              <tr>
                <td>{{ $modulo->id }}</td>
                <td>{{ $modulo->name }}</td>
                <td>{{ $modulo->cantidad }}</td>
                <td>
                  <a onclick="restablecer({{ $modulo->id }}, event)" title="Restablecer permisos" href="#">
                    <i class="fa fa-repeat"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<script>
  var base_url = "{{ url('/') }}";
  var controlador = "{{ session('controlador') }}";
</script>
