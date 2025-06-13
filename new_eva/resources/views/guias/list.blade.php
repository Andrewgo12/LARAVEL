@extends('layouts.app')

@section('content')

  <section class="content-header">
    <h3>Guides</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        @foreach($acciones as $accion)
          @if($accion->modulo == "guias rapidas" && $accion->insertar == 1)
            <div class="custom-row"><a class="custom-btn-figure" href="" data-toggle="modal" data-target="#modal_add"><i class="fa fa-plus"></i></a></div>
          <?php endif ?>
        <?php endforeach ?>
        <div class="row">
          <div class="col-md-12">
            <span class="mensaje-guia-exito"></span>
            <span class="mensaje-guia-error"></span>
          </div>
        </div>
        <ul class="nav nav-tabs">
          <li class="active"><a href="#guias">Guias rapidas</a></li>
          <li><a href="#nombres">Indicador por grupo</a></li>
          <li><a href="#detallados">Detalle por grupo</a></li>
          <li><a href="#inclusionesexclusiones">Inclusiones/Exclusiones</a></li>
        </ul>
        <div class="tab-content">
          <div id="guias" class="tab-pane fade in active">
            @if(!empty($guias))
              <div class="row">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <input id="controlador" type="hidden" value="{{ session('controlador') }}">
                    <p class="cobertura_biomedicos">
                      COBERTURA DE GUIAS RAPIDAS EQUIPOS BIOMEDICOS:
                      <strong style="font-size: 20px;">{{ $cobertura_biomedicos->cobertura }}
                      </strong>
                      &nbsp; Cumplen criterios : {{ $cantidad_cumple_criterios->cantidad }}
                      &nbsp; Cumplen criterios con guia : {{ $cantidad_cumple_criterios_con_guia->cantidad }}
                    </p>
                    <a href="{{ url('/') }}guia/Cguias/exportarPriorizados" class="btn btn-success fa fa-file">Exportar Priorizados</a>
                    <a href="{{ url('/') }}guia/Cguias/exportarPriorizadosGuia" class="btn btn-success fa fa-file">Exportar Priorizados con guia rapida</a>
                    <a href="{{ url('/') }}guia/Cguias/exportPrioritizedWithoutGuide" class="btn btn-success fa fa-file">Exportar Priorizados sin guia rapida</a>
                    <a href="{{ url('/') }}guia/Cguias/exportarPriorizadosGrupo" class="btn btn-success fa fa-file">Exportar Priorizados por grupo</a>
                    <!--<p class="cobertura_industriales">COBERTURA DE GUIAS RAPIDAS EQUIPOS INDUSTRIALES: <strong style="font-size: 20px;">{{ $cobertura_industriales->cobertura }}</strong></p>-->
                    <table class="table table-info container-table tblguias">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre de la guia</th>
                          <th>#Equipos</th>
                          <th>Estado</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            @else
              <span style="font-size: 50px;">No existen registros!</span>
            <?php endif ?>
          </div>
          <div id="nombres" class="tab-pane fade">
            <div class="row">
              <div class="col-sm-3">
                <input type="text" class="form-control filtro_grupos">
              </div>
            </div>
            <table class="tbl-indicador-por-guia table table-condensed">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Cantidad cubierta</th>
                  <th>Cantidad total</th>
                  <th>%</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>

          </div>
          <div id="detallados" class="tab-pane fade">
            <table border="1" class="tbl-detallados">
              <thead>
                <tr>
                  <td>Nombre</td>
                  <td>Marca</td>
                  <td>Modelo</td>
                  <td>Cantidad Total</td>
                  <td>Cantidad con guia</td>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div id="inclusionesexclusiones" class="tab-pane fade">
            <h4 style="opacity: 50%;">Filtros</h4>
            <div class="row">
              <div class="col-md-6">
                <table border="1" class="table table-bordered table-condensed tbl-riesgos-incluidos">
                  <thead>
                    <tr>
                      <th>RIESGOS INCLUIDOS</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table border="1" class="table table-bordered table-condensed tbl-estados-excluidos">
                  <thead>
                    <tr>
                      <th>ESTADOS EXCLUIDOS</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
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

@push('scripts')
<script>

  var base_url = "{{ url('/'); }}";
  var controlador = "{{ session('controlador') }}";



  var editar_equipo = "<?php print_r(session('acciones')[0]->editar); ?>"; //equipos


  var insertar_guia = "<?php print_r(session('acciones')[21]->insertar); ?>";
  var editar_guia = "<?php print_r(session('acciones')[21]->editar); ?>";
  var eliminar_guia1 = "<?php print_r(session('acciones')[21]->eliminar); ?>";

</script>
@endpush
@endsection