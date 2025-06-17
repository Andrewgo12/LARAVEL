<div class="content-wrapper">
  <section class="content-header">
    <h3>Medical devices</h3> <small>List</small>
  </section>
  <section class="content data-table-content">
    <div class="box box-solid">
      <div class="box-body">
        <?php
        $rol = session('rol_id');
        $sede_id = session('sede_id');
        ?>
        <section class="container">
          <div class="custom-row">
            <a href="#" data-toggle="modal" data-target="#modal_filter_equipo" class="custom-btn-figure"><i class=" glyphicon glyphicon-filter"></i></a>
            <?php
            foreach ($acciones as $accion) {
              if ($accion->modulo == "equipos") {
                if ($accion->insertar == 1) {
            ?>
                  <a href="#" data-toggle="modal" data-target="#modal_add_equipo" class="custom-btn-figure"><i class="fa fa-plus"></i></a>
            <?php
                }
              }
            }
            ?>
            @if($rol <= 2)
              <a href="#" data-toggle="modal" data-target="#modal_filter_equipo" class="custom-btn-figure"><i class="fa fa-random"></i></a>
            <?php endif ?>
            @if($rol == 1)
              <a data-toggle='modal' href="#" onclick="detail_depurar_nombres()" data-target='#modal_depurar_nombres'><i class="fa fa-warning"></i>Depurar Nombres</a>
            <?php endif ?>
          </div>
        </section>
        <div class="row">
          <div class="">
            <div class="panel panel-default">
              <div class="panel-body">
                <ul class="list-inline section-filter-navbar">
                  <li class="list-inline-item custom-btn"><button onclick="funcion_modal_preventivos(event)" type="button" class="btn btn-default" data-toggle='modal' data-target='#modal_preventivos'>Preventivos</button></li>
                  <li class="list-inline-item custom-btn"><button onclick="funcion_modal_calibraciones(event)" type="button" class="btn btn-default" data-toggle='modal' data-target='#modal_calibraciones'>Calibraciones</button></li>
                  <li class="list-inline-item custom-btn"><button onclick="funcion_modal_correctivos(event)" type="button" class="btn btn-default" data-toggle='modal' data-target='#modal_correctivos'>Correctivos</button>
                  </li>
                  <li class="list-inline-item custom-btn"><a class="btn btn-default" href="{{ asset('') }}equipo/Cequipos/Exportar_cantidades" target="_blank">Month</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
                <span class="text-muted">Borrar filtro:</span><a onclick="borrar_filtro_servicio_area_especial(event)" href="" class="borrar_filtro fa fa-eraser" style="font-size: 30px; color: #222d32;"></a>
              </div>
              <div class="col-md-2">
                <label for="sede_id">Sede</label>
                <select onchange="selectServicesBySede();" style="width: 100%;font-size: 18px;" class='form-control control_sede sede_id_auxiliar'>
                  @if($sede_id == 1)
                    <option selected="" value="1">Sede principal</option>
                    <option value="2">Sede Norte</option>
                    <option value="">Todos</option>
                  <?php endif ?>
                  @if($sede_id == 2)
                    <option value="1">Sede principal</option>
                    <option selected="" value="2">Sede Norte</option>
                    <option value="">Todos</option>
                  <?php endif ?>
                  @if($sede_id == "")
                    <option value="1">Sede principal</option>
                    <option value="2">Sede Norte</option>
                    <option selected="" value="">Todos</option>
                  <?php endif ?>
                </select>
              </div>
              <div class="col-md-3">
                <ul class="list-inline">
                  <li class="list-inline-item"><label for="">Consultar ID</label></li>
                  <li class="list-inline-item"><input type="number" class="form-control consulta_id" placeholder="Id a consultar">
                    <span class="alert-danger mensaje-consulta-id"></span>
                  </li>
                  <li class="list-inline-item"><span onclick="consultarExistenciaId()" class="glyphicon glyphicon-search"></span></li>
                </ul>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right rango-fechas" id="">
                </div>
              </div>
              <div class="col-md-3">
                <ul>
                  <li>
                    <a href="" onclick="mostrar_adquisicion_equipos(event,1)" class="">Consultar adquisiciones</a>
                    <a href="" data-toggle="modal" data-target="#modal_show_adquisicion" class="auxiliar_adquisicion"></a>
                    <br><span class="alert-danger mensaje-adquisicion"></span>
                  </li>
                  <li>
                    <a href="" onclick="mostrar_instalacion_equipos(event,1)" class="">consultar instalaciones de equipos</a>
                    <a href="" data-toggle="modal" data-target="#modal_show_instalacion" class="auxiliar_instalacion"></a>
                  </li>
                </ul>
              </div>
            </div>
            <a href="#" class="abrir_modal_update_equipo" data-toggle="modal" data-target="#modal_update_equipo"></a>
            <a href="#" class="abrir_modal_add_equipo" data-toggle="modal" data-target="#modal_add_equipo"></a>
            <a href="#" class="abrir_modal_copy_equipo" data-toggle="modal" data-target="#modal_copy"></a>
            <div class="panel-default logica-control-ubicacion">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Servicio:</label>
                    <select name="servicio_id_auxiliar" id="servicio_id_auxiliar" class="form-control servicio_id_auxiliar" onchange="funcion_seleccion_area_desde_equipos()"></select>
                  </div>
                  <div class="col-md-3">
                    <label for="area_id">Area:</label>
                    <select style="width: 100%" name="area_id_auxiliar" id="area_id_auxiliar" class="form-control area_id_auxiliar"></select>
                  </div>
                  <div class="col-sm-3 contenedor_estados_from_equipos">
                    <label for="estado_id">Estado de Tickets</label>
                    <select name="estado_id" id="estado_id" class="form-control estado_id"></select>
                  </div>
                  <div class="col-sm-3 contenedor_estados_from_equipos">
                    <label for="estado_id">Estado de Correctivos generales</label>
                    <select name="estado_id_cg" id="estado_id_cg" class="form-control estado_id_cg"></select>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" class="tipo_id" value="1">
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table container-table" id="tblEquipos">
                <thead>
                  <tr class="table-info">
                    <!-- <th></th> -->
                    <th>Equipo</th>
                    <th>Data</th>
                    <th>Ubicación</th>
                    <th>Ejecución plan</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody data-table="eva-table"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "{{ asset('') }}";
  var controlador = "<?php echo session('controlador'); ?>";
  var rol_id = "<?php echo session('rol_id'); ?>";
  var sede_id = "<?php echo session('sede_id'); ?>";


  var insertar_equipo = "<?php print_r(session('acciones')[0]->insertar); ?>"; //equipos
  var editar_equipo = "<?php print_r(session('acciones')[0]->editar); ?>"; //equipos

  var insertar_equipo_archivo = "<?php print_r(session('acciones')[13]->insertar); ?>"; //equipo archivos
  var leer_equipo_archivo = "<?php print_r(session('acciones')[13]->leer); ?>"; //equipo archivos

  var insertar_baja = "<?php print_r(session('acciones')[4]->insertar); ?>"; //bajas

  var insertar_observacion = "<?php print_r(session('acciones')[17]->insertar); ?>"; //observaciones
  var eliminar_observacion = "<?php print_r(session('acciones')[17]->eliminar); ?>"; //observaciones
  var editar_observacion = "<?php print_r(session('acciones')[17]->editar); ?>"; //observaciones


  var insertar_servicio = "<?php print_r(session('acciones')[2]->insertar); ?>"; //servicios

  var insertar_area = "<?php print_r(session('acciones')[19]->insertar); ?>"; //areas
  var editar_area = "<?php print_r(session('acciones')[19]->editar); ?>"; //areas
  var eliminar_area = "<?php print_r(session('acciones')[19]->eliminar); ?>"; //areas

  var insertar_contingencia = "<?php print_r(session('acciones')[20]->insertar); ?>"; //contingencias
  var eliminar_contingencia = "<?php print_r(session('acciones')[20]->eliminar); ?>"; //contingencias
  var editar_contingencia = "<?php print_r(session('acciones')[20]->editar); ?>"; //contingencias

  var insertar_soporte_compra = "<?php print_r(session('acciones')[6]->insertar); ?>"; //soportes compra
  //var sede_id="<?php print_r(session('sede_id')); ?>";
  var anio_plan = "<?php print_r(session('anio_plan')); ?>";

  var tipo_id = 1;
</script>