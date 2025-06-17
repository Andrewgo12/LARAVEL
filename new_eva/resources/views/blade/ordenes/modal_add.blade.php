<div id="modal_add_orden" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      {{-- Encabezado del modal --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title lead">Nueva orden de trabajo</h4>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de creación</h3>
              </div>

              <div class="box-body form-horizontal">

                <form action="{{ url('orden/Cordenes/add') }}" id="form_orden" name="form_orden" method="POST" enctype="multipart/form-data">
                  @csrf

                  <input type="hidden" name="seleccionado" id="seleccionado">

                  {{-- Proceso y Subproceso --}}
                  <div class="row">
                    <div class="col-sm-7">
                      <label for="proceso">Proceso al cual reportar</label>
                      <select required name="proceso" id="proceso" class="form-control">
                        <option value="">--Seleccione--</option>
                      </select>
                    </div>
                    <div class="col-sm-5">
                      <label for="subproceso">Área del proceso</label>
                      <select required name="subproceso_id" id="subproceso" class="form-control">
                        <option value="">--Seleccione--</option>
                      </select>
                    </div>
                  </div>
                  <br>

                  {{-- Condición para administradores --}}
                  @if(session('rol_id') <= 2)
                  <div class="row">
                    <div class="col-sm-12">
                      <label>Reportante Origen (visible para el administrador)</label><br>
                      <input type="radio" name="seleccion_reportante" value="propio" class="seleccion_reportante" checked> Propio
                      <input type="radio" name="seleccion_reportante" value="otro" class="seleccion_reportante"> Otro

                      <div class="mensaje_aclaratorio mt-2">
                        <h4><small class="text-muted">Si selecciona "Propio", el ticket se almacenará con la cuenta del administrador.</small></h4>
                      </div>

                      <div class="contenedor_seleccion_reportante mt-3" style="display: none;">
                        <div class="row">
                          <div class="col-sm-6">
                            <label for="nombre_reportante">Nombre del reportante</label>
                            <input type="text" class="form-control informacion_otro_reportante" name="nombre_reportante" id="nombre_reportante" placeholder="Nombre del reportante" disabled required>
                          </div>
                          <div class="col-sm-6">
                            <label for="centro_costo">Centro de costo del reportante</label>
                            <select class="form-control informacion_otro_reportante" name="centro_costo" id="centro_costo" style="width: 100%;" disabled required></select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  @endif

                  {{-- Ubicación --}}
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="servicio_id">Ubicación de referencia</label>
                      <select name="servicio_id" id="servicio_id" class="form-control" style="width:90%" required>
                        <option value="">--Seleccione--</option>
                      </select>
                      <a href="#" data-toggle="modal" data-target="#modal_add_servicio" class="fa fa-info btn btn-default"></a>
                    </div>
                  </div>

                  {{-- Información de equipos: subproceso_1 --}}
                  <div class="subproceso_1">
                    <input type="hidden" name="equipo_id" id="equipo_id">
                    @include('orden.partials.equipo_fields', ['sufijo' => ''])
                  </div>

                  {{-- Información de arreglo: subproceso_2 --}}
                  <div class="subproceso_2">
                    <input type="hidden" name="equipo_id" id="equipo_id_2">

                    <div class="form-group row">
                      <label class="col-sm-2 control-label">Tipo de arreglo</label>
                      <div class="col-sm-10">
                        <label><input type="checkbox" id="Locativo"> Locativo</label>
                        <label><input type="checkbox" id="Electrico"> Eléctrico</label>
                        <label><input type="checkbox" id="Mecanico"> Mecánico</label>
                      </div>
                    </div>

                    @include('orden.partials.equipo_fields', ['sufijo' => '_2'])
                  </div>

                  {{-- Asunto y prioridad --}}
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="asunto">Asunto del Ticket</label>
                      <input required type="text" class="form-control" name="asunto" id="asunto" placeholder="Asunto">
                    </div>
                    <div class="col-sm-6">
                      <label for="prioridad">Prioridad</label>
                      <select required class="form-control" name="prioridad" id="prioridad">
                        <option value="">---Seleccione---</option>
                        <option value="baja">Baja</option>
                        <option value="media">Media</option>
                        <option value="alta">Alta</option>
                      </select>
                    </div>
                  </div>
                  <br>

                  {{-- Descripción --}}
                  <div class="row">
                    <div class="col-sm-12">
                      <label for="descripcion">Descripción del problema</label>
                      <textarea class="form-control" id="descripcion" name="descripcion" maxlength="450" placeholder="Describa detalladamente el problema presentado (mínimo 30 caracteres)"></textarea>
                    </div>
                  </div>

                  {{-- Imagen --}}
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="image" class="badge">Imagen</label>
                      <input type="file" class="file" id="image" name="image" onchange="return validacionImagen()" data-browse-on-zone-click="true">
                    </div>
                  </div>

                  {{-- Botón --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_add_orden">Ingresar</button>
                  </div>
                </form>

                <h1><div id="mensaje"></div></h1>
                <div id="errores"></div>
              </div>
              <br>
            </div>
          </div>
        </div>
      </div>

      {{-- Footer --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
