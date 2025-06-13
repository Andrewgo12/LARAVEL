@extends('layouts.app')

@section('content')

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tecnicos 
      <small >Listado</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body">

      <hr>
      <div class="row">
        <div class="col-md-12 table-responsive">
          <input type="text" id="Snombre" class="form-control" style="width: 20%" placeholder="Nombre" onkeyup="Snombre();"><br><br>
          <?php print_r($tecnicos); ?>
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

@push('scripts')
<script>

  var base_url="{{ url('/'); }}";

</script>
@endpush

@endsection