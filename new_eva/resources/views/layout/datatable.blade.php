@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
  
    <section class="content-header">
      <h1>
        Base de datos 
        <small>Equipos industriales</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Equipos Industriales</h3>
              <div class="alert alert-success" style="display: none;">
    
              </div>
        
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <button type="button" id= "btn_add"class="btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#formulario_add"style="width:60px; height: 50px; margin-top:5px; margin-left: 10px; margin-bottom: 10px;"></button>
              <table id="tablaequipos" class="table table-bordered table-striped" style="width: 980px;">
                <thead>
                <tr>
                  <th>Equipo</th>
                  <th>Datos</th>
                  <th>Servicio</th>
                  <th>Ejecucion plan</th>
                  <th>Editar</th>
                </tr>
                </thead>

               <tbody>

       <!-- <?php foreach ($datos as $dato){?>
                <tr>
                   <td>{{ $dato->rownum }}</</td>
                  <td><img src="{{ url('/') }}/style/imagenes_equipos_industriales/<?php echo $dato->imagen ?>" style="width:100px;height:100px;"> </td>
                  <td>{{ $dato->nombre }}</</td>
                  <td>{{ $dato->marca }}</</td>
                  <td>{{ $dato->serial }}</td>
                  <td>{{ $dato->name }}</td>
                  <td>{{ $dato->namem }}</td>

                </tr>
             <?php }  ?>
-->
                </tbody>

                <tfoot>
                <tr>
                  <th>Equipo</th>
                  <th>Datos</th>
                  <th>Servicio</th>
                  <th>Ejecucion plan</th>
                  <th>Editar</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    </div>
    <!--conten wrapper -->
@push('scripts')
<script>

  var base_url = "{{ url('/'); }}";
  var rol_id="{{ session('rol_id'); }}";

</script>
@endpush

@endsection