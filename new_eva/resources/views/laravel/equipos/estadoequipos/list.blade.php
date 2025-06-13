
<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Estados equipo
      <small >Listado</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body">
        <div class="row">
         <div class="col-md-12">
        </div>          
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 table-responsive">
          <table class="table table-stripped" id="tblEstadoequipos">
           <thead>
             <tr>
               <th>Nombre</th>
               <th></th>
             </tr>
           </thead>
           <tbody></tbody>
         </table>    
       </div>
       <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 table-responsive editarServicio">
        <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        <form action="{{ asset('') }}ubicacion/Cestadoequipos/update" id="form_estadoequipo" name="form_estadoequipo" enctype="multipart/form-data" method="post">
      @csrf
          <input type="hidden" id="id" name="id" class="form-control">
          <br>
          <div class="row">
            <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
              <label for="code" class="">Nombre:</label>
            </div>
            <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
              <input type="text" class="form-control" placeholder="Nombre del estado" name="name" id="name">
            </div>
          </div>
<br>
          <div class="box-footer">
            <button class="btn btn-primary" id="btn_update_estado_equipo" onclick="aplicar_condicion(1)" disabled="">Actualizar</button>
            <button class="btn btn-info fa fa-plus btn-flat" id="btn_add_estado_equipo" onclick="aplicar_condicion(2)" >Agregar</button>
          </div>
          <div class="errores"></div>
          <input type="hidden" id="condicion">
        </form>


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
</script>
