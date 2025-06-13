
<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Permisos 
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
            <a href="{{ asset('') }}administrador/Cpermisos/add" class="btn btn-lg btn-primary fa fa-plus btn-flat">Nuevo permiso</a> 
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <?php if (!empty($permisos_listado)): ?>                    
              <table class="table " id="tblPermisos">
               <thead>
                 <tr>
                   <th>ID</th>
                   <th>Menu</th>
                   <th>Rol</th>
                   <th>Leer</th>
                   <th>Insertar</th>
                   <th>Actualizar</th>
                   <th>Eliminar</th>
                   <th>Asignar</th>
                   <th style="width: 20%;">Opciones</th>
                 </tr>
               </thead>
               <tbody>
                 @foreach($permisos_listado as $permiso)
                  <tr>
                    <td><?php echo $permiso->id; ?></td>
                    <td><?php echo $permiso->menu; ?></td>
                    <td><?php echo $permiso->rol; ?></td>
                    @if($permiso->read==0)
                      <td><span class="fa fa-times"></span></td>
                    @else
                      <td><span class="fa fa-check"></span></td>
                    @endif
                    @if($permiso->insert==0)
                      <td><span class="fa fa-times"></span></td>
                    @else
                      <td><span class="fa fa-check"></span></td>
                    @endif
                    @if($permiso->update==0)
                      <td><span class="fa fa-times"></span></td>
                    @else
                      <td><span class="fa fa-check"></span></td>
                    @endif
                    @if($permiso->delete==0)
                      <td><span class="fa fa-times"></span></td>
                    @else
                      <td><span class="fa fa-check"></span></td>
                    @endif
                    @if($permiso->asignar==0)
                      <td><span class="fa fa-times"></span></td>
                    @else
                      <td><span class="fa fa-check"></span></td>
                    @endif

                    <td>
                      <div class="btn-group">
                        <a href="{{ asset('') }}administrador/Cpermisos/edit/<?= $permiso->id;?>" class="fa fa-pencil echo btn btn-danger"></a>
                        <a href="{{ asset('') }}administrador/Cpermisos/delete/<?= $permiso->id;?>" class="fa fa-remove btn btn-warning"></a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>   
          <?php endif ?>

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
  var base_url="<?=base_url();?>"
</script>
