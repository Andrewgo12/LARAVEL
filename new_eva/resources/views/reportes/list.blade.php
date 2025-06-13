@extends('layouts.app')

@section('content')

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tablero de indicadores y control

<!--       <input type="hidden" id="permiso_update" value={{ $permisos->update; }}>
      <input type="hidden" id="permiso_delete" value={{ $permisos->delete; }}>
    -->      <small >Listado</small>

  </h1>
</section>
<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $total->total }}</h3>
          <p>Total de equipos Registrados</p>
        </div>
        <div class="icon">
          <i class="fa fa-object-group"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $incluidoPreventivo->total }}<sup style="font-size: 20px"></sup></h3>

          <p>Incluidos en el plan de Mantenimiento preventivo</p>
        </div>
        <div class="icon">
          <i class="fa fa-medkit"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $obtenidosComodato->total }}</h3>

          <p>Total de equipos en comodato</p>
        </div>
        <div class="icon">
          <i class="fa fa-star-o"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $planNoComodato->total }}</h3>

          <p>Total no incluidos en el plan </p>
        </div>
        <div class="icon">
          <i class="fa  fa-exclamation"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <div class="row">
    <div class="col-sm-3 col-md-3 col-lg-3">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Seguimiento a correctivos</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th>ESTADO</th>
                  <th>NUMERO DE ORDENES</th>
                </tr>
              </thead>
              <tbody>
                @foreach($estadoOrdenes as $resumen)
                  <tr>
                    <td>{{ $resumen->estado }}</td>
                    <td>{{ $resumen->total }}</td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          Resumen
        </div>
        <!-- /.box-footer -->
      </div>
    </div>
    <div class="col-md-3">
      <!-- Info Boxes Style 2 -->
      <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="glyphicon glyphicon-option-horizontal"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Tiempo promedio de Cierre</span>
          <span class="info-box-number" id="tiempo_promedio">{{ $PromedioTiempoTotal->total }} </span>(h)
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box bg-green">
        <span class="info-box-icon"><i class="glyphicon glyphicon-thumbs-up"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Menor Tiempo de Cierre</span>
          <span class="info-box-number" id="tiempo_menor">{{ $MenorTiempoTotal->total }} </span>(h)
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box bg-red">
        <span class="info-box-icon"><i class="glyphicon glyphicon-thumbs-down"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Mayor Tiempo de Cierre</span>
          <span class="info-box-number" id="tiempo_mayor">{{ $MayorTiempoTotal->total }} </span>(h)
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6">
      <div class="row">
        <div class="col-sm-12 text-center">
          <h3>Filtrar por fecha de Cierre</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">
          <label for="fecha_cierre_inicio">Fecha inicial</label>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
          <input class="form-control" type="date" id="fecha_cierre_inicio" name="fecha_cierre_inicio" value="{{ date("Y-m-d",strtotime('-360 day')) }}">
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
          <label for="fecha_cierre_fin">Fecha final</label>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
          <input class="form-control" type="date" id="fecha_cierre_fin" name="fecha_cierre_fin" value="{{ date("Y-m-d",strtotime('+360 day')) }}">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <a href="#" class="btn btn-info fa fa-caret-square-o-right" id="aplicar_cierre"></a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <h3>Filtrar por fecha de Creación</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">
          <label for="fecha_creacion_inicio">Fecha inicial</label>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
          <input class="form-control" type="date" id="fecha_creacion_inicio" name="fecha_creacion_inicio" value="{{ date("Y-m-d",strtotime('-360 day')) }}">
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
          <label for="fecha_creacion_fin">Fecha final</label>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
          <input class="form-control" type="date" id="fecha_creacion_fin" name="fecha_creacion_fin" value="{{ date("Y-m-d",strtotime('+360 day')) }}">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <a href="#" class="btn btn-info fa fa-caret-square-o-right" id="aplicar_creacion"></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-3">
      <div class="box-body">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Exportar consolidados</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <ul class="lista_consolidados list-group">  
              <li class="list-group-item"><a href="{{ url('/') }}equipo/Cequipos/ConsolidadoCorrectivos" target="_blank">Correctivos Tickets</a></li>          
              <li class="list-group-item"><a href="{{ url('/') }}equipo/Cequipos/ConsolidadoCorrectivosGenerales" target="_blank">Otros correctivos</a></li>          
              <li class="list-group-item"><a href="{{ url('/') }}equipo/Cequipos/ConsolidadoPreventivos" target="_blank">Preventivos</a></li>          
              <li class="list-group-item"><a href="{{ url('/') }}equipo/Cequipos/ConsolidadoCalibraciones" target="_blank">Calibraciones</a></li>          
            </ul>
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            Files.xlsx
          </div>
          <!-- /.box-footer -->
        </div>

      </div>
    </div>
    <div class="col-sm-5 col-md-5 col-lg-5">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Cantidad por equipos</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin table-bordered lista_nombres">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
      </div>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Clasificación biomedica</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <tbody>
                @foreach($cbiomedicas as $cbiomedica)
                  <tr>
                    <td>{{ $cbiomedica->cbiomedica }} <label class="badge"><?php echo $cbiomedica->total ?></label></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
      </div>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Riesgo</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin table-bordered">
              <tbody>
                @foreach($criesgos as $criesgo)
                  <tr>
                    <td class="text-center">{{ $criesgo->criesgo }} <label class="badge"><?php echo $criesgo->total ?></label></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2 col-md-2 col-lg-2">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Seguimiento a preventivos</h3>


          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <label for="">Selección de año</label>
          <select required="" name="" id="" class="seleccion_anio form-control"></select><br>
        <label for="">Selección de mes</label>
          <select required="" name="" id="" class="seleccion_mes form-control"></select><br>
        <label for="">Selección de Sede</label>
          <select required="" name="" id="" class="seleccion_sede form-control">
            <option selected="" value="1">Sur</option>
            <option value="2">Norte</option>
          </select>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          Resumen
        </div>
        <!-- /.box-footer -->
      </div>
    </div>
    <div class="col-sm-5 col-md-5 col-lg-5" style=>

      <div class="box box-info" style="overflow-x: auto;">
        <div class="box-header with-border">
          <h3 class="box-title">Resultados globales por año</h3>


          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
  
            <table class="tbl-cantidad-anio table table-bordered">
              <thead>
                <th>Año</th>
                <th>Propiedad</th>
                <th>Cantidad preventivos programados</th>
                <th>Cantidad preventivos ejecutados</th>
                <th>Porcentaje de ejecucion</th>
              </thead>
              <tbody>
                
              </tbody>
            </table>


        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          Resultados
        </div>
        <!-- /.box-footer -->
      </div>
    </div>
    <div class="col-sm-5 col-md-5 col-lg-5" >

      <div class="box box-info" style="overflow-x: auto;">
        <div class="box-header with-border">
          <h3 class="box-title">Resultados globales por año y mes</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
  
            <table class="tbl-cantidad-anio-mes table table-bordered">
              <thead>
                <th>Propiedad</th>
                <th>Año</th>
                <th>Mes</th>
                <th>Cantidad preventivos programados</th>
                <th>Cantidad preventivos ejecutados</th>
                <th>Porcentaje de ejecucion</th>
              </thead>
              <tbody>
                
              </tbody>
            </table>


        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          Resultados
        </div>
        <!-- /.box-footer -->
      </div>
    </div>    
  </div>

<!-- ----------------->

  <div class="row">

    <div class="col-sm-6 col-md-6 col-lg-6" style=>

      <div class="box box-info" style="overflow-x: auto;">
        <div class="box-header with-border">
          <h3 class="box-title">Resultados globales por año</h3>


          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
  
            <table class="tbl-cantidad-anio-general table table-bordered">
              <thead>
                <th>Año</th>
                <th>Cantidad preventivos programados</th>
                <th>Cantidad preventivos ejecutados</th>
                <th>Porcentaje de ejecucion</th>
              </thead>
              <tbody>
                
              </tbody>
            </table>


        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          Resultados
        </div>
        <!-- /.box-footer -->
      </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6" >

      <div class="box box-info" style="overflow-x: auto;">
        <div class="box-header with-border">
          <h3 class="box-title">Resultados globales por año y mes</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
  
            <table class="tbl-cantidad-anio-mes-general table table-bordered">
              <thead>
                <th>Año</th>
                <th>Mes</th>
                <th>Cantidad preventivos programados</th>
                <th>Cantidad preventivos ejecutados</th>
                <th>Porcentaje de ejecucion</th>
              </thead>
              <tbody>
                
              </tbody>
            </table>


        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          Resultados
        </div>
        <!-- /.box-footer -->
      </div>
    </div>    
  </div>
</section>

</div>

@push('scripts')
<script>

  var base_url="{{ url('/'); }}";

</script>
@endpush

@endsection