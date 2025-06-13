

        <div id="formulario_add" class="modal fade" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Equipos industriales</h4>
              </div>
              <div class="modal-body">
                <section class="content" style="width: 500px;">
      <div class="row">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Formulario </h3>
              <div class="alert alert-error" style="display: none;">
    
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="form_add" enctype="multipart/form-data"  method="POST" role="form" >
              <div class="box-body">
                <div class="form-group">
                  <label for="nombre">Nombre equipo industrial</label>
                  <input type="text" class="form-control"  name="nombre" id="nombre" placeholder="Agrege nombre del equipo">
                </div>
                <div class="form-group">
                  <label for="marca">Marca</label>
                  <input type="text" class="form-control" name="marca" id="marca"  placeholder="Agrege Marca del equipo">
                </div>
                <div class="form-group">
                  <label for="serial">Serial</label>
                  <input type="text" class="form-control"  name="serial" id="serial"  placeholder="Agrege serial del equipo">
                </div>
                <div class="form-group">
                  <label for="modelo">Modelo</label>
                  <input type="text" class="form-control"  name="modelo" id="modelo" placeholder="Agrege modelo del equipo">
                </div>
                <div class="form-group">
                  <label for="codigo_inventario">Codigo de Inventario</label>
                  <input type="text" class="form-control" name="codigo_inventario"  id="codigo_inventario" placeholder="Agrege codigo de Inventario del equipo">
                </div>
             
                 <div class="form-group">
                  <label for="fecha_mantenimiento">Fecha mantenimiento</label>
                  <input type="date" class="form-control" name="fecha_mantenimiento"  id="fecha_mantenimiento" placeholder="Agrege fecha de preventivo del equipo">
                </div>
                 <div class="form-group">
                  <label for="servicio_id">Servicio</label>
                  <select class="js-data-example-ajax1" name="servicio_id" id="servicio_idd" style="width: 480px;">
                    <option value='0'>-- Buscar servicios --</option>
                  </select>
               </div>
                
                <div class="form-group">
                  <label for="periodicidad_id">Periodicidad de mantenimiento</label>
                  <select class="js-data-example-ajax2" name="periodicidad_id" id="periodicidad_idd" style="width: 480px;">
                  <option value='0'>-- Buscar Periodicidad de mantenimiento --</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="piso_id">Piso</label>
                  <select class="js-data-example-ajax" name="piso_id" id="piso_id" style="width: 480px;">
                     <option value='0'>-- Buscar Pisos --</option>
                  </select>
               </div>

                <div class="form-group">
                  <label for="imagen" style="margin-top: 5px;">Imagen del equipo</label>
                  <input type="file" name="imagen" id="imagen" style="margin-top: 5px;" class="form-control">
                </div>
                 
                 <div class="form-group" >
                       <label for="archivo" style="margin-top: 18px;">Hoja de vida</label>
                       <input type="file" name="archivo" id="archivo" class="form-control" style="margin-top:3px">
                     </div>
                  
            </form>
            <div class="box-footer">
                <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
              </div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
