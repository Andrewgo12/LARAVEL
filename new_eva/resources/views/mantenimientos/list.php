<div class="content-wrapper">
  <section class="content-header">
    <h3>schedule</h3> <small>List</small>
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
            <form enctype="multipart/form-data" method="post" action="" name="formulario_plan_preventivo" id="formulario_plan_preventivo" class="formulario_plan_preventivo">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <label for="">Año del cronograma</label>
                  <select required="" name="anio_cronograma" id="anio_cronograma">
                    <option value="">--------</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                  </select>
                </li>
                <li class="list-inline-item">
                  <label for="reemplazar">Desea reemplazar la información subida Previamente?</label>
                  <select required="" name="reemplazar" id="reemplazar" class="reemplazar">
                    <option value="">--------</option>
                    <option value="si">si</option>
                    <option value="no">no</option>
                  </select>
                </li>
              </ul>
              Archivo
              <input required="" type="file" id="file" name="file" class="file" data-browse-on-zone-click="true">
              <button class="">Send</button>
            </form>
            <div class="consultar_contenedor">
              <span style="font-size:50px;" class="fa fa-question-circle"></span>
              <div class="consultar_contenido">
                <div class="row">
                  <div class="col-sm-6">
                    <h4 style="opacity: 50%">Asi debe ser la información del archivo de excel ingresada:</h4>
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
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                        </tr>
                        <tr>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                        </tr>
                        <tr>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                        </tr>
                        <tr>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                          <td>......</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-sm-6">
                    <h3>OBSERVACIONES</h3>
                    <p>
                      Para ingresar un registro en el plan de mantenimiento debe ingresarse en el fromulario un archivo de excel plano con una sola hoja y teniendo en cuenta las siguientes instrucciones:
                    </p>
                    <blockquote>
                      <ul style="font-size: 13px;">
                        <li>La opcion reemplazar información subida previamente reemplazara un registro del plan segun el año seleccionado, es equivalente a actualizar el registro, con la diferencia de que al subirse un archivo con varios registros, aquellos que no estaban previamente se agregaran como nuevos, en caso de que se seleccione no, los registros que estaban previmente permanecen intactos y solo se agregan los nuevos</li>
                        <li>Los campos meses deben ser valores numericos y deben ser agregados de forma logica es decir en orden ascendente correspondiente al mes</li>
                        <li>El Id del equipos es aquel que identifica inequivocamente al equipo en la base de datos, es decir es el que esta asignado en el aplicativo</li>
                        <li>El responsable es el responsable del mantenimiento, verificar que no sea ingresado el mismo responsable con variacion en el nombre o de lo contrario se identificaran como responsables diferentes</li>
                        <li>En la tabla del lado izquierdo se muestra en la primera fila los nombres o titulos, esto es solo informativo, ya que cuando se vaya a subir el archivo, este debe ser subido <strong> sin los titulos</strong>!!!!!!</li>
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
                  <select class="form-control seleccion_anio" name="" id="">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option selected="" value="2022">2022</option>
                  </select>
                </li>
                <li class="list-inline-item">
                  <a href="<?php echo base_url(); ?>mantenimiento/Cplanes/ExportarExcel" target="__blank" class="btn btn-success"><span class="glyphicon glyphicon-file"></span>Exportar Consolidado</a>
                </li>
                <li class="list-inline-item">
                  <a href="<?php echo base_url(); ?>assets/Plantilla importacion cronograma.xlsx" target="__blank" class="btn btn-success"><span class="glyphicon glyphicon-file"></span>Exportar Plantilla</a>
                </li>
              </ul>
              <table class="table table-info container-table tabla_planes">
                <thead>
                  <tr>
                    <th></th>
                    <th>Id equipo</th>
                    <th>Equipo</th>
                    <th>Codigo</th>
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

                </tbody>
              </table>
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
<!-- /.content-wrapper -->
<script>
  var base_url = "<?= base_url(); ?>";
</script>
