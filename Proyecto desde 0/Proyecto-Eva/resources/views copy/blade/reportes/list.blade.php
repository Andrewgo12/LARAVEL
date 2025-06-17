{{-- resources/views/blade/reportes/list.blade.php --}}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tablero de indicadores y control
      <small>Listado</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    {{-- Row 1: Key Metrics Small Boxes --}}
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $total->total ?? 0 }}</h3> {{-- Added null coalescing operator for safety --}}
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
            <h3>{{ $incluidoPreventivo->total ?? 0 }}<sup style="font-size: 20px"></sup></h3> {{-- Added null coalescing operator --}}
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
            <h3>{{ $obtenidosComodato->total ?? 0 }}</h3> {{-- Added null coalescing operator --}}
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
            <h3>{{ $planNoComodato->total ?? 0 }}</h3> {{-- Added null coalescing operator --}}
            <p>Total no incluidos en el plan</p>
          </div>
          <div class="icon">
            <i class="fa fa-exclamation"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>

    {{-- Row 2: Corrective Maintenance, Time Metrics, and Date Filters --}}
    <div class="row">
      {{-- Corrective Maintenance Summary --}}
      <div class="col-sm-3 col-md-3 col-lg-3">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Seguimiento a correctivos</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
                      <td>{{ $resumen->estado ?? '' }}</td> {{-- Added null coalescing operator --}}
                      <td>{{ $resumen->total ?? 0 }}</td> {{-- Added null coalescing operator --}}
                    </tr>
                  @endforeach
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

      {{-- Corrective Maintenance Time Metrics --}}
      <div class="col-md-3">
        <!-- Info Boxes Style 2 -->
        <div class="info-box bg-yellow">
          <span class="info-box-icon"><i class="glyphicon glyphicon-option-horizontal"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tiempo promedio de Cierre</span>
            <span class="info-box-number" id="tiempo_promedio">{{ $PromedioTiempoTotal->total ?? 0 }} </span>(h) {{-- Added null coalescing operator --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-green">
          <span class="info-box-icon"><i class="glyphicon glyphicon-thumbs-up"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Menor Tiempo de Cierre</span>
            <span class="info-box-number" id="tiempo_menor">{{ $MenorTiempoTotal->total ?? 0 }} </span>(h) {{-- Added null coalescing operator --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box bg-red">
          <span class="info-box-icon"><i class="glyphicon glyphicon-thumbs-down"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Mayor Tiempo de Cierre</span>
            <span class="info-box-number" id="tiempo_mayor">{{ $MayorTiempoTotal->total ?? 0 }} </span>(h) {{-- Added null coalescing operator --}}
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>

      {{-- Date Filters --}}
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
            <input class="form-control" type="date" id="fecha_cierre_inicio" name="fecha_cierre_inicio" value="{{ date('Y-m-d', strtotime('-360 day')) }}">
          </div>
          <div class="col-sm-2 col-md-2 col-lg-2">
            <label for="fecha_cierre_fin">Fecha final</label>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4">
            <input class="form-control" type="date" id="fecha_cierre_fin" name="fecha_cierre_fin" value="{{ date('Y-m-d', strtotime('+360 day')) }}">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            {{-- Button for applying closure date filter --}}
            <a href="#" class="btn btn-info fa fa-caret-square-o-right" id="aplicar_cierre"> Aplicar</a> {{-- Added text for clarity --}}
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
            <input class="form-control" type="date" id="fecha_creacion_inicio" name="fecha_creacion_inicio" value="{{ date('Y-m-d', strtotime('-360 day')) }}">
          </div>
          <div class="col-sm-2 col-md-2 col-lg-2">
            <label for="fecha_creacion_fin">Fecha final</label>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4">
            <input class="form-control" type="date" id="fecha_creacion_fin" name="fecha_creacion_fin" value="{{ date('Y-m-d', strtotime('+360 day')) }}">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            {{-- Button for applying creation date filter --}}
            <a href="#" class="btn btn-info fa fa-caret-square-o-right" id="aplicar_creacion"> Aplicar</a> {{-- Added text for clarity --}}
          </div>
        </div>
      </div>
    </div>

    {{-- Row 3: Export, Equipment Count, Biomedical Classification, and Risk --}}
    <div class="row">
      {{-- Export Links --}}
      <div class="col-sm-3">
        <div class="box-body"> {{-- This box-body seems misplaced, usually inside a .box --}}
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Exportar consolidados</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="lista_consolidados list-group">
                <li class="list-group-item"><a href="{{ url('equipo/Cequipos/ConsolidadoCorrectivos') }}" target="_blank">Correctivos Tickets</a></li>
                <li class="list-group-item"><a href="{{ url('equipo/Cequipos/ConsolidadoCorrectivosGenerales') }}" target="_blank">Otros correctivos</a></li>
                <li class="list-group-item"><a href="{{ url('equipo/Cequipos/ConsolidadoPreventivos') }}" target="_blank">Preventivos</a></li>
                <li class="list-group-item"><a href="{{ url('equipo/Cequipos/ConsolidadoCalibraciones') }}" target="_blank">Calibraciones</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              Files.xlsx
            </div>
            <!-- /.box-footer -->
          </div>
        </div> {{-- Closing the potentially misplaced box-body --}}
      </div>

      {{-- Equipment Count by Name (Populated by JS) --}}
      <div class="col-sm-5 col-md-5 col-lg-5">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Cantidad por equipos</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
                  {{-- Content likely populated by JavaScript --}}
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
        </div>
      </div>

      {{-- Biomedical Classification --}}
      <div class="col-sm-2 col-md-2 col-lg-2">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Clasificación biomedica</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
                      <td>{{ $cbiomedica->cbiomedica ?? '' }} <label class="badge">{{ $cbiomedica->total ?? 0 }}</label></td> {{-- Added null coalescing operator --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
        </div>
      </div>

      {{-- Risk Classification --}}
      <div class="col-sm-2 col-md-2 col-lg-2">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Riesgo</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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
                      <td class="text-center">{{ $criesgo->criesgo ?? '' }} <label class="badge">{{ $criesgo->total ?? 0 }}</label></td> {{-- Added null coalescing operator --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
        </div>
      </div>
    </div>

    {{-- Row 4: Preventive Maintenance Filters and Results by Year/Month (Sede Filtered) --}}
    <div class="row">
      {{-- Preventive Maintenance Filters --}}
      <div class="col-sm-2 col-md-2 col-lg-2">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Seguimiento a preventivos</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <label for="seleccion_anio">Selección de año</label> {{-- Added for attribute --}}
            <select required name="seleccion_anio" id="seleccion_anio" class="seleccion_anio form-control"></select><br> {{-- Added name attribute --}}
            <label for="seleccion_mes">Selección de mes</label> {{-- Added for attribute --}}
            <select required name="seleccion_mes" id="seleccion_mes" class="seleccion_mes form-control"></select><br> {{-- Added name attribute --}}
            <label for="seleccion_sede">Selección de Sede</label> {{-- Added for attribute --}}
            <select required name="seleccion_sede" id="seleccion_sede" class="seleccion_sede form-control"> {{-- Added name attribute --}}
              <option selected value="1">Sur</option>
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

      {{-- Preventive Maintenance Results by Year (Sede Filtered) --}}
      <div class="col-sm-5 col-md-5 col-lg-5" style="overflow-x: auto;"> {{-- Corrected style attribute --}}
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Resultados globales por año (Sede)</h3> {{-- Added (Sede) for clarity --}}
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="tbl-cantidad-anio table table-bordered">
              <thead>
                <tr> {{-- Added tr --}}
                  <th>Año</th>
                  <th>Propiedad</th>
                  <th>Cantidad preventivos programados</th>
                  <th>Cantidad preventivos ejecutados</th>
                  <th>Porcentaje de ejecucion</th>
                </tr> {{-- Added tr --}}
              </thead>
              <tbody>
                {{-- Content likely populated by JavaScript --}}
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

      {{-- Preventive Maintenance Results by Year and Month (Sede Filtered) --}}
      <div class="col-sm-5 col-md-5 col-lg-5" style="overflow-x: auto;">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Resultados globales por año y mes (Sede)</h3> {{-- Added (Sede) for clarity --}}
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="tbl-cantidad-anio-mes table table-bordered">
              <thead>
                <tr> {{-- Added tr --}}
                  <th>Propiedad</th>
                  <th>Año</th>
                  <th>Mes</th>
                  <th>Cantidad preventivos programados</th>
                  <th>Cantidad preventivos ejecutados</th>
                  <th>Porcentaje de ejecucion</th>
                </tr> {{-- Added tr --}}
              </thead>
              <tbody>
                {{-- Content likely populated by JavaScript --}}
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

    {{-- Row 5: General Preventive Maintenance Results by Year/Month --}}
    <div class="row">
      {{-- General Preventive Maintenance Results by Year --}}
      <div class="col-sm-6 col-md-6 col-lg-6" style="overflow-x: auto;"> {{-- Corrected style attribute --}}
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Resultados globales por año (General)</h3> {{-- Added (General) for clarity --}}
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="tbl-cantidad-anio-general table table-bordered">
              <thead>
                <tr> {{-- Added tr --}}
                  <th>Año</th>
                  <th>Cantidad preventivos programados</th>
                  <th>Cantidad preventivos ejecutados</th>
                  <th>Porcentaje de ejecucion</th>
                </tr> {{-- Added tr --}}
              </thead>
              <tbody>
                {{-- Content likely populated by JavaScript --}}
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

      {{-- General Preventive Maintenance Results by Year and Month --}}
      <div class="col-sm-6 col-md-6 col-lg-6" style="overflow-x: auto;">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Resultados globales por año y mes (General)</h3> {{-- Added (General) for clarity --}}
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="tbl-cantidad-anio-mes-general table table-bordered">
              <thead>
                <tr> {{-- Added tr --}}
                  <th>Año</th>
                  <th>Mes</th>
                  <th>Cantidad preventivos programados</th>
                  <th>Cantidad preventivos ejecutados</th>
                  <th>Porcentaje de ejecucion</th>
                </tr> {{-- Added tr --}}
              </thead>
              <tbody>
                {{-- Content likely populated by JavaScript --}}
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

{{--
  Note: It's generally recommended to move script tags to your main layout file
  and use Blade's @push or @stack directives to include scripts from individual views.
  For example, in your layout file:
  <head>
    ...
    @stack('styles')
  </head>
  <body>
    ...
    @stack('scripts')
  </body>

  And in this file:
  @push('scripts')
  <script>
    var base_url = "{{ url('/') }}";
    // Your other JavaScript code here
  </script>
  @endpush
--}}
<script>
  var base_url = "{{ url('/') }}";
  // Add your JavaScript logic here to populate tables and handle filters
  // Example: Fetch data based on selected year, month, sede, or date ranges
  // and update the tbody of the respective tables (e.g., .lista_nombres, .tbl-cantidad-anio, etc.)

  // Example of how you might handle filter clicks (requires jQuery or similar library used in AdminLTE)
  $(document).ready(function() {
    $('#aplicar_cierre').on('click', function(e) {
      e.preventDefault(); // Prevent default link behavior
      var fechaInicio = $('#fecha_cierre_inicio').val();
      var fechaFin = $('#fecha_cierre_fin').val();
      console.log('Aplicar filtro por fecha de cierre:', fechaInicio, 'a', fechaFin);
      // TODO: Add AJAX call or JavaScript logic to filter data based on these dates
    });

    $('#aplicar_creacion').on('click', function(e) {
      e.preventDefault(); // Prevent default link behavior
      var fechaInicio = $('#fecha_creacion_inicio').val();
      var fechaFin = $('#fecha_creacion_fin').val();
      console.log('Aplicar filtro por fecha de creación:', fechaInicio, 'a', fechaFin);
      // TODO: Add AJAX call or JavaScript logic to filter data based on these dates
    });

    // TODO: Add logic to populate year/month/sede selects and handle their change events
    // TODO: Add logic to fetch and populate the tables (.lista_nombres, .tbl-cantidad-anio, etc.)
    // based on initial load or filter changes.
  });
</script>
