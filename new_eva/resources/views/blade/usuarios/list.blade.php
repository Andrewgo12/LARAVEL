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
    <!-- Default box -->
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
            <!-- <input type="text" id="Snombre" class="form-control" style="width: 20%" placeholder="Nombre" onkeyup="Snombre();"><br><br> -->
            <table style="text-transform: lowercase;" class="table table-condensed table-sm table-bordered" id="tblUsuarios">
              <thead>
                <tr>
                  <th>Nombres Y apellidos</th>
                  <th>Centro de costo</th>
                  <!-- <th>Telefono</th> -->
                  <!-- <th>Correo</th> -->
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
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <h3>Relación zonas - usuarios</h4>
          <h5>
            <p>
            <blockquote>
              <span>
                <a onclick="funcion_modal_add_usuario_zona(event)" data-toggle="modal" data-target="#modal_add_usuario_zona" href="" class="glyphicon glyphicon-plus"></a>
                Agregar Nueva relación
              </span>
            </blockquote>
            </p>
          </h5>
          <div class="row">
            <div class="table-responsive col-md-12 tblusuarioszonas">
              <table style="text-transform: lowercase;" class="table table-sm table-condensed table-bordered">
                <thead>
                  <tr>
                    <th>Nombre de la zona</th>
                    <th>Nombre del usuario</th>
                    <th>Correo electronico</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Cargando....</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <h3>Relación Empresas - usuarios</h3>
        <div class="row">
          <div class="table-responsive col-md-12">
            <div class="contenedor-tblEmpresas">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <h3>Modulos</h3>
        <table class="table table-bordered table-condensed table-hover tblModulos">
          <thead>
            <tr>
              <th>#</th>
              <th>Modulo</th>
              <th>#cuentas afectadas</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($modulos as $modulo)
              <tr>
                <td><?php echo $modulo->id; ?></td>
                <td><?php echo $modulo->name; ?></td>
                <td><?php echo $modulo->cantidad; ?></td>
                <td><a onclick="restablecer(<?php echo $modulo->id; ?>,event)" title="Restablecer permisos" href=""><i class="fa fa-repeat"></i></a></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php echo {{ session('controlador') }} ?>";
</script>