
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

              <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

              <span class="errores"></span>
              <ul class="">
                <li class="">
                  <strong>Selección de sede</strong>: 

                  <select class="cambio_sede_general">
                    <?php if ($usuario->sede_id==1): ?>
                    <option value="">Todo</option>
                    <option value="1" selected="">Sede principal</option>
                    <option value="2">Sede norte</option>
                    <?php endif ?>
                    <?php if ($usuario->sede_id==2): ?>
                    <option value="">Todo</option>
                    <option value="1">Sede principal</option>
                    <option value="2" selected="">Sede norte</option>
                    <?php endif ?>
                    <?php if ($usuario->sede_id==""): ?>
                    <option value="" selected="">Todo</option>
                    <option value="1">Sede principal</option>
                    <option value="2">Sede norte</option>
                    <?php endif ?>
                  </select>
                </li>
<!--                 <li class="">
                  <strong>Año seleccionado plan de mantenimiento: </strong><span class="anio_seleccionado_plan"><?php echo $this->session->userdata("anio_plan"); ?></span>
                  <strong>Cambiar selección: </strong>: <span style="font-weight: 700;font-size: 20px;color:#636363;" class="">
                    <select name="" id="" class="seleccion-anio-mantenimiento"></select>

                  </span>
                </li> -->
              </ul>

              <div class="form-group">
                <label for="nombre" class="col-sm-2 control-label">Nombre</label>

                <div class="col-sm-10">
                  <input readonly="" value='<?=$usuario->nombre;?>' type="text" class="form-control" required  name="nombre" id="add_nombre_usuario" placeholder="Nombre">
                </div>
              </div>
              <div class="form-group">
                <label for="apellido" class="col-sm-2 control-label">Apellidos</label>

                <div class="col-sm-10">
                  <input readonly="" value='<?=$usuario->apellido;?>' type="text" class="form-control"  name="apellido" placeholder="Apellido" id="add_apellido_usuario">
                </div>
              </div>
              <div class="form-group">
                <label for="telefono" class="col-sm-2 control-label">Telefono</label>

                <div class="col-sm-10">
                  <input readonly="" value='<?=$usuario->telefono;?>' type="number" class="form-control"  name="telefono" placeholder="Telefono" id="add_telefono_usuario">
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">email</label>

                <div class="col-sm-10">
                  <input readonly="" value='<?=$usuario->email;?>' type="email" class="form-control"  name="email" placeholder="email" id="add_email_usuario">
                </div>
              </div>
              <div class="form-group">
                <label for="username" class="col-sm-2 control-label">username</label>

                <div class="col-sm-10">
                  <input readonly="" value='<?=$usuario->username;?>' type="text" class="form-control"  name="username" placeholder="username" id="add_username_usuario">
                </div>
              </div>

              <div class="form-group">
                <label for="rol" class="col-sm-2 control-label">rol</label>

                <div class="col-sm-10">
                  <input readonly="" class="form-control" type="text" value="<?=$usuario->rol;?>">
                </div>
              </div>
              <div class="form-group">
                <label for="rol" class="col-sm-2 control-label">Centro de costo</label>

                <div class="col-sm-10">
                  <input readonly="" class="form-control" type="text" value="<?=$usuario->centro;?>">
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-2 control-label">password</label>

                <div class="col-sm-10">
                  <input value='' type="password" class="form-control"  name="password" placeholder="password" id="password">
                  <a href="#" onclick="update_pwd(<?=$usuario->id;?>,event)" class="btn btn-xs btn-primary">Actualizar contraseña</a>
                </div>
              </div>


              <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
            </div>

          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url="<?=base_url();?>";
  var anio_plan="<?php print_r($this->session->userdata('anio_plan')); ?>";
  var usuario_id="<?php print_r($this->session->userdata('id')); ?>";
  
</script>
