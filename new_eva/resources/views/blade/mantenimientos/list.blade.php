<div class="content-wrapper">
  <section class="content-header">
    <h3>Schedule</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <hr>
        <div class="panel panel-primary">
          <div class="panel-heading">
            Ingresar Plan de mantenimiento preventivo
          </div>
          <div class="panel-body">
            <form enctype="multipart/form-data" method="post" action="{{ route('mantenimiento.planes.import') }}" name="formulario_plan_preventivo" id="formulario_plan_preventivo" class="formulario_plan_preventivo">
              @csrf
              <ul class="list-inline">
                <li class="list-inline-item">
                  <label for="anio_cronograma">Año del cronograma</label>
                  <select required name="anio_cronograma" id="anio_cronograma" class="form-control">
                    <option value="">--------</option>
                    @for ($year = 2019; $year <= date('Y') + 1; $year++)
                      <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                  </select>
                </li>
                <li class="list-inline-item">
                  <label for="reemplazar">¿Desea reemplazar la información subida previamente?</label>
                  <select required name="reemplazar" id="reemplazar" class="form-control reemplazar">
                    <option value="">--------</option>
                    <option value="si">Sí</option>
                    <option value="no">No</option>
                  </select>
                </li>
              </ul>
              <div class="form-group">
                <label for="file">Archivo</label>
                <input required type="file" id="file" name="file" class="file form-control-file" data-browse-on-zone-click="true">
              </div>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            <div class="consultar_contenedor">
              <span class="fa fa-question-circle" style="font-size:50px;"></span>
              <div class="consultar_contenido">
                <div class="row">
                  <div class="col-sm-6">
                    <h4 style="opacity: 0.5">Así debe ser la información del archivo de Excel ingresada:</h4>
                    <div class="table-responsive">
                      <table class="table table-info container-table">
                        <thead>
                          <tr>
                            <th>Id equipo</th>
                            <th>Mes1</th>
                            <th>Mes2</th>
                            <th>Mes3</th>
                            <th>Responsable</th>
                            <th>Frecuencia de mantenimiento</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>200</td>
                            <td>1</td>
                            <td>7</td>
                            <td></td>
                            <td>SYSMED</td>
                            <td>ANUAL</td>
                          </tr>
                          <tr>
                            <td>320</td>
                            <td>2</td>
                            <td>8</td>
                            <td></td>
                            <td>SYSMED</td>
                            <td>SEMESTRAL</td>
                          </tr>
                          <tr>
                            <td colspan="6" class="text-center">...</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <h3>OBSERVACIONES</h3>
                    <p>
                      Para ingresar un registro en el plan de mantenimiento debe ingresarse en el formulario un archivo de Excel plano con una sola hoja y teniendo en cuenta las siguientes instrucciones:
                    </p>
                    <blockquote>
                      <ul style="font-size: 13px;">
                        <li>La opción "reemplazar información subida previamente" reemplazará un registro del plan según el año seleccionado. Es equivalente a actualizar el registro, con la diferencia de que al subirse un archivo con varios registros, aquellos que no estaban previamente se agregarán como nuevos. En caso de que se seleccione "no", los registros que estaban previamente permanecen intactos y solo se agregan los nuevos.</li>
                        <li>Los campos meses deben ser valores numéricos y deben ser agregados de forma lógica, es decir, en orden ascendente correspondiente al mes.</li>
                        <li>El ID del equipo es aquel que identifica inequívocamente al equipo en la base de datos, es decir, es el que está asignado en el aplicativo.</li>
                        <li>El responsable es el responsable del mantenimiento. Verificar que no sea ingresado el mismo responsable con variación en el nombre o de lo contrario se identificarán como responsables diferentes.</li>
                        <li>En la tabla del lado izquierdo se muestra en la primera fila los nombres o títulos, esto es solo informativo, ya que cuando se vaya a subir el archivo, este debe ser subido <strong>sin los títulos</strong>!</li>
                      </ul>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <select class="form-control seleccion_anio" id="seleccion_anio">
                    @for ($year = 2019; $year <= date('Y'); $year++)
                      <option value="{{ $year }}" {{ $year == 2022 ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                  </select>
                </li>
                <li class="list-inline-item">
                  <a href="{{ route('mantenimiento.planes.exportar') }}" target="_blank" class="btn btn-success">
                    <span class="glyphicon glyphicon-file"></span> Exportar Consolidado
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="{{ asset('assets/Plantilla importacion cronograma.xlsx') }}" target="_blank" class="btn btn-success">
                    <span class="glyphicon glyphicon-file"></span> Exportar Plantilla
                  </a>
                </li>
              </ul>
              <table class="table table-info container-table tabla_planes">
                <thead>
                  <tr>
                    <th></th>
                    <th>Id equipo</th>
                    <th>Equipo</th>
                    <th>Código</th>
                    <th>Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Responsable</th>
                    <th>Rango programado 1</th>
                    <th>Rango programado 2</th>
                    <th>Rango programado 3</th>
                    <th>Cantidad de preventivos ejecutados</th>
                    <th>Cantidad de preventivos programados</th>
                    <th>Cumplimiento global</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Datos cargados dinámicamente -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@push('scripts')
<script>
  var base_url = "{{ url('/') }}/";
</script>
@endpush
