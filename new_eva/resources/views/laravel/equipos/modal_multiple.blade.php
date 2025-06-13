<div class="modal fade" id="modal_multiple">
  <div class="modal-dialog" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <div class="modal-title text-center" style="background-color: #888888;color: white;font-family: 'calibri';font-size: 30px;"></div>
        </div>
        <div class="modal-body"> 

          <ul class="nav nav-tabs">
            <li class="active"><a href="#nav_capacitaciones">Asociar capacitaciones</a></li>
            <li><a href="#nav_especificaciones">Asociar especificaciones Tecnicas</a></li>
            <li><a href="#nav_imagenes">Imagenes Equipos</a></li>
          </ul> 

          <div class="tab-content">
            <div id="nav_capacitaciones" class="tab-pane fade in active">
              <h3 style="opacity: 50%;">RELACIONAR CAPACITACIONES</h3>
              <form action="<?php echo base_url() ?>equipo/Cequipos/addMultipleCapacitaciones" id="multiple_capacitaciones" enctype="multipart/form-data" method="post">
                <h2>Capacitaciones</h2>
                <div class="panel panel-default">
                  <div class="panel-heading">Inserción de capacitaciones</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-3"><input required="" type="text" placeholder="Nombre del equipo" id="name" name="name" class="form-control"></div>
                      <div class="col-sm-3"><input type="text" placeholder="Marca" id="marca" name="marca" class="form-control"></div>
                      <div class="col-sm-3"><input type="text" placeholder="Modelo" id="modelo" name="modelo" class="form-control"></div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-sm-6">
                        <label for="servicio_id">Servicios</label><br>
                        <select multiple="" style="width: 100%;" name="servicio_id" id="servicio_id" class="form-control servicio_id"></select>
                      </div>
                      <div class="col-sm-6">
                        <label for="area_id">Areas</label><br>
                        <select multiple="" style="width: 100%;" name="area_id" id="area_id" class="form-control area_id"></select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-sm-3">
                        <input required="" min="2015-01-01" max="<?php echo date("Y-m-d"); ?>" type="date" name="fecha_capacitacion" id="fecha_capacitacion" value="<?php echo date("Y-m-d"); ?>"  class="form-control">
                      </div>
                      <div class="col-sm-2">
                        <input type="time" name="hora_capacitacion" id="hora_capacitacion" class="hora_capacitacion form-control">
                      </div>       
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <label for="vinculo">Archivo a subir</label>
                        <input required="" style="width: 100%;" class="file" type="file" name="file" id="file" data-browse-on-zone-click="true">
                      </div>
                    </div>                  
                    <div class="row">
                      <div class="col-sm-12">
                        <button id="btn_add_multiple_capacitacion" class="btn btn-primary">
                          Ingresar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div id="nav_especificaciones" class="tab-pane fade">
              <form action="<?php echo base_url() ?>equipo/Cequipos/addMultipleEspecificaciones" id="multiple_especificaciones" name="multiple_especificaciones" enctype="multipart/form-data" method="post">
                <h2 style="opacity: 50%;">Especificaciones Tecnicas</h2>
                <div class="panel panel-default">
                  <div class="panel-heading">Inserción de especificaciones</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-3">Especificación Tecnica<select required="" name="especificaciont" id="especificaciont" class="especificacion_id form-control"></select></div>
                      <div class="col-sm-3"><input required="" type="text" placeholder="Nombre del equipo" id="name" name="name" class="form-control"></div>
                      <div class="col-sm-3"><input type="text" placeholder="Marca" id="marca" name="marca" class="form-control"></div>
                      <div class="col-sm-3"><input type="text" placeholder="Modelo" id="modelo" name="modelo" class="form-control"></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                       <textarea required="" name="valor" id="valor" cols="30" rows="5" class="form-control" placeholder="Ingrese el valor de la especificacion Tecnica"></textarea>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-12">
                      <button id="btn_add_multiple_especificacion" class="btn btn-primary">
                        Ingresar especificacion Tecnica
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>  
          </div>
          <div id="nav_imagenes" class="tab-pane fade">
            <h3 style="opacity: 50%;">Imagenes</h3>
            <form action="<?php echo base_url() ?>equipo/Cequipos/addMultipleImagenes" id="multiple_imagenes" name="multiple_imagenes" enctype="multipart/form-data" method="post">
              <h2>Imagenes Equipos</h2>
              <div class="panel panel-default">
                <div class="panel-heading">Inserción de imagenes</div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-3"><input class="file" type="file" name="file" id="file" data-browse-on-zone-click="true"></div>
                    <div class="col-sm-3"><input required="" type="text" placeholder="Nombre del equipo" id="name" name="name" class="form-control">Desea reemplazar la imagenes ya ingresadas?<select name="clarear_imagen" id="clarear_imagen"><option value="no" selected="">No</option><option value="si">Si</option></select></div>
                    <div class="col-sm-3"><input type="text" placeholder="Marca" id="marca" name="marca" class="form-control"><button id="btn_add_multiple_imagenes" class="btn btn-primary">
                      Insertar/Actualizar imagenes
                    </button></div>
                    <div class="col-sm-3"><input type="text" placeholder="Modelo" id="modelo" name="modelo" class="form-control"></div>
                  </div>
                </div>
              </div>
            </form>          
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left close" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>