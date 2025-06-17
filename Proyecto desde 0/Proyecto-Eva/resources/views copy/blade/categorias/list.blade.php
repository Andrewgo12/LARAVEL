<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Categorias
      <input type="hidden" id="permiso_update" value="{{ $permisos->update }}">
      <input type="hidden" id="permiso_delete" value="{{ $permisos->delete }}">
      <small>Listado</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body">
        <div class="row">
          @if($permisos->insert==1)
           <div class="col-md-12">
            <a href="#" data-toggle="modal" data-target="#modal_add_categoria" class="btn btn-lg btn-primary fa fa-plus btn-flat">Nueva categoria</a>
          </div>
          @endif
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <input type="text" id="Snombre" class="form-control" style="width: 20%" placeholder="Nombre" onkeyup="Snombre();"><br><br>
            <table class="table table-hover" id="tblCategorias">
             <thead>
               <tr>
                 <th>#</th>
                 <th>Nombre</th>
                 <th>Descripcion</th>
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url="{{ url('/') }}/";
</script>
