<div id="modal_add_biomedicos" class="modal fade contenedor-orden" role="dialog">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">

      {{-- Header del Modal --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title lead">Nueva orden de trabajo - Equipos biomédicos</h4>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"></h3>
              </div>

              <div class="box-body form-horizontal">

                {{-- FORMULARIO PRINCIPAL --}}
                <form action="{{ url('orden/Cordenes/add') }}" id="form_orden_biomedicos" name="form_orden_biomedicos"
                      class="form_orden" enctype="multipart/form-data" method="post">
                  @csrf
                  <input type="hidden" value="3" name="empresa_id">

                  @if(session('rol_id') <= 2)
                    {{-- Panel: Selección del reportante (solo admin) --}}
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Reportante
                        <div class="small text-muted">(Sección visible para el administrador)</div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="panel panel-default">
                              <br>
                              <ul>
                                <li>
                                  <input class="seleccion_reportante_biomedicos" type="radio" name="seleccion_reportante" value="propio" checked>
                                  Propio
                                </li>
                                <li>
                                  <input class="seleccion_reportante_biomedicos" type="radio" name="seleccion_reportante" value="otro">
                                  Otro
                                </li>
                              </ul>
                              <br>
                            </div>

                            <div class="mensaje_aclaratorio">
                              <h3>!!
                                <small class="text-muted">
                                  Si se selecciona <strong>propio</strong>, el ticket será almacenado con la información del administrador como reportante.
                                </small>
                              </h3>
                            </div>
                            <div class="contenedor_seleccion_reportante"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif

                  <input type="hidden" id="subproceso_id" name="subproceso_id" class="subproceso_id" value="1">

                  {{-- Panel: Información del reporte --}}
                  <div class="panel panel-default">
                    <div class="panel-heading">Información del reporte</div>
                    <div class="panel-body">
                      <div class="col-sm-6">
                        <label for="asunto">Asunto</label>
                        <input required class="form-control" type="text" id="asunto" name="asunto" placeholder="Asunto">
                      </div>
                      <div class="col-sm-12">
                        <label for="descripcion">Descripción del problema</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" maxlength="450"
                                  placeholder="Describa detalladamente el problema presentado (mínimo 30 caracteres)">
                        </textarea>
                      </div>
                    </div>
                  </div>

                  {{-- Panel: Información del equipo --}}
                  <div class="panel panel-default">
                    <div class="panel-heading">Información del equipo</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-xs-5">
                          <a title="Seleccionar equipo" onclick="funcion_get_equipos_biomedicos(1)"
                             class="text-primary fa fa-search" data-toggle="modal" data-target="#modal_consulta_equipos_biomedicos"
                             style="color:#20123a;font-weight: 1000;font-size: 25px;">
                          </a>
                          <small class="text-muted">Buscar equipo en la base de datos</small>
                          <p><span class="resultado_seleccion_equipo"></span></p>
                        </div>
                        <div class="col-xs-4">
                          <a onclick="set_manual(event)" href="#" class="btn btn-light fa fa-pencil"></a>
                          <small class="text-muted">Ingresar de forma manual</small>
                        </div>
                        <input type="hidden" name="equipo_id" id="equipo_id" class="form-control equipo_id">
                      </div>
                    </div>
                  </div>

                  {{-- Panel: Ubicación actual del equipo --}}
                  <div class="panel panel-default panel-ubicacion">
                    <div class="panel-heading">Ubicación donde está actualmente el equipo</div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-sm-4">
                          <label for="sede_id">Sede:</label>
                          <select name="sede_id" class="form-control sede_id" required>
                            <option value="1">Principal</option>
                            <option value="2">Norte</option>
                          </select>
                        </div>
                        <div class="col-sm-4">
                          <label for="servicio_id">Servicio:</label>
                          <select name="servicio_id" class="form-control servicio_id select2" required>
                            <option value="">--------------</option>
                          </select>
                        </div>
                        <div class="col-sm-4">
                          <label for="area_id">Área:</label>
                          <select name="area_id" id="area_id" class="form-control area_id">
                            <option value="">-----</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- Panel: Adjuntar archivo --}}
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label for="image" class="badge">Archivo relacionado</label>
                      <input type="file" class="file" id="image" name="image" data-browse-on-zone-click="true">
                    </div>
                  </div>

                  {{-- Botón enviar --}}
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn_add_orden" id="btn_add_orden" disabled>
                      Ingresar
                    </button>
                  </div>
                </form>

                {{-- Sección mensajes y errores --}}
                <h1><div id="mensaje"></div></h1>
                <div id="errores"></div>

              </div>
              <br>
            </div>
          </div>
        </div>

        {{-- Footer del Modal --}}
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
    </div>
  </div>
</div>
