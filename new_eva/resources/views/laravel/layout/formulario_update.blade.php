

<div id="formulario_update" class="modal fade" >
          <div class="modal-dialog">
            <div class="modal-content"style="width: 750px; height: auto;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Actualizar Equipos industriales</h4>
              </div>
              <div class="modal-body"style="width: 700px; height: auto;">
                <section class="content" style="width: 600px; height: auto;">
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
            <form id="form_update" enctype="multipart/form-data"  method="post" role="form" >
      @csrf
              <div class="box-body"style="width: 600px; height: auto;">
                <div class="form-group">
                  <input type="hidden" class="form-control"  name="id_equipos" id="id_equipos">
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre equipo industrial</label>
                  <input type="text" class="form-control"  name="nombre" id="nombre"placeholder="Agrege nombre del equipo">
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
                  <select class="js-data-example-ajax1" name="servicio_id" id="servicio_id" style="width: 580px;">    
                  </select>
               </div>                
                <div class="form-group">
                  <label for="periodicidad_id">Periodicidad de mantenimiento</label>
                  <select class="js-data-example-ajax2" name="periodicidad_id" id="periodicidad_id" style="width: 580px;">
                 
                  </select>
               </div>
                <div class="form-group">
                  <label for="piso_id">Piso</label>
                  <select class="js-data-example-ajax2" name="piso_id" id="piso_id" style="width: 580px;">
                 
                  </select>
               </div>

               <div>
                <div class="form-group">
                  <label for="imagen_add" >Imagen del equipo</label>
                  <input type="file" name="imagen" id="imagen" class="form-control">
                  <p class="help-block" id="texto"></p>
               </div>
               
               <div>
                    <table>
                      <thead>
                        <th></th> 
                        <th><center>Esp. Tecnicas</center></th>
                      </thead>
                      <tbody>
                        <td><figure id="showimagen"></figure></td> 
                        <td>
                            <label for="Corriente"  style="margin-left: 100px;">Corriente</label>
                            <input type="text" class="form-control" name="Corriente" id="Corriente"     placeholder="Agrege Corriente"  style="width: 200px;margin-left: 100px;">

                            <label for="Tension"    style="margin-left: 100px;">Tension</label>
                            <input type="text" class="form-control"  name="Tension" id="Tension"        placeholder="Agrege Tension"    style="width: 200px;margin-left: 100px;">

                            <label for="Potencia"   style="margin-left: 100px;">Potencia</label>
                            <input type="text" class="form-control"  name="Potencia" id="Potencia"      placeholder="Agrege Potencia"   style="width: 200px;margin-left: 100px;">

                            <label for="Temperatura"style="margin-left: 100px;">Temperatura</label>
                            <input type="text" class="form-control"  name="Temperatura"id="Temperatura" placeholder="Agrege Temperatura" style="width: 200px;margin-left: 100px;">
                       </td>
                      </tbody>
                    </table>            
                
                </div>
                
              
                    <div>

                      <div class="form-group" style="margin-left: 10px">
                       <label for="archivo">Hoja de vida</label>
                       <input type="file" name="archivo" id="archivo" class="form-control">
                     </div>

                <table>
                  <tbody>
                    <td>
                      <p class="help-block" id="text"style="margin-left: 10px"></p>
                    </td>
                    <td>
                      <div id="link"></div> 
                    </td>
                  </tbody>
                </table>

                 <div class="form-group"style="margin-left: 60px">
                  <label for="archivo_ca" style="margin-top: 0px;">Calibraciones</label>
                   <button type="button"id= "btn_add_ca"class="btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_calibracion" style="margin-top: 1px;"></button> 
              </div> 
              <p class="help-block" id="text_ca"style="margin-left: 10px"></p>
              <table id="tbcalibraciones"style="margin-left: 10px">
                      <thead class="apendice_calibracion">
                     <tr height="27" style="mso-height-source:userset;height:20.25pt" >
                      <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
                      width:61pt">ID calibración</td>
                    
                      <td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;
                      width:200pt">Fecha ejecución   </td>
                      <td colspan="13" class="xl18526419" width="63" style="width:48pt">Fecha programada</td>
                      <td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;
                      width:263pt">Archivo relacionado </td>
                      <td class="xl1526419"></td>
                     </tr>
                     </thead><tbody></tbody>
                </table>
              </div>
         

     
              <div style="margin-left: 10px;">
                  <div class="form-group" style="margin-top: 9px; margin-left: 70px">
                     <label for="archivo_p" >Preventivo</label>
                       <button type="button"id= "btn_add_p"class="btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_preventivo_ind" style="margin-top: 1px;"></button>                 
                   </div>   
                   <p class="help-block" id="text_p"style="margin-left: 10px"></p>
                   <table id="tbpreventivo">
                     <thead class="apendice_preventivo">
                     <tr height="27" style="mso-height-source:userset;height:20.25pt" >
                      <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
                      width:61pt">ID preventivo</td>
                      <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
                      width:61pt">Descripcion</td>
                      <td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;
                      width:200pt">Fecha ejecución   </td>
                      <td colspan="13" class="xl18526419" width="63" style="width:48pt">Fecha programada</td>
                      <td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;
                      width:263pt">Archivo relacionado     </td>
                      <td class="xl1526419"></td>
                     </tr>
                     </thead><tbody></tbody>
                </table>

                 <div class="form-group"style="margin-top: 10px; margin-left: 70px">
                  <label for="archivo_co" style="margin-top: 0px;">Correctivo</label>
                    <button type="button"id= "btn_add_co"class="btn btn-info glyphicon glyphicon-plus" data-toggle="modal" data-target="#modal_add_correctivo_general" style="margin-top: 1px;"></button>
              </div> 
              <p class="help-block" id="text_co"style="margin-left: 10px"></p>
              <table id="tbcorrectivo" style="margin-top: 1px">
                    <thead class="apendice_tickets">
                     <tr height="27" style="mso-height-source:userset;height:20.25pt" >
                      <td colspan="13.5" height="27" class="xl18926419" width="82" style="height:20.25pt;
                      width:61pt">ID Orden</td>
                      <td colspan="18" class="xl20126419" width="259" style="border-right:.5pt solid black;
                      width:200pt">Descripción   </td>
                      <td colspan="13" class="xl18526419" width="63" style="width:48pt">Estado</td>
                      <td colspan="10" class="xl20126419" width="348" style="border-right:.5pt solid black;
                      width:263pt">Archivo relacionado     </td>
                      <td class="xl1526419"></td>
                     </tr>
                     </thead><tbody></tbody>

                </table>
              </div> 
            
                                                                        
              <!-- /.box-body -->            
            </form>
            <div class="box-footer">
                <button type="submit" id="actualizar" class="btn btn-primary" >Actualizar</button>
              </div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="margin-top: 1px;">Cerrar</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
