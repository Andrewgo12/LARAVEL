<!-- Modal Editar Categoría -->
<div id="modal_update_categoria" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar Categoría</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos de la Categoría</h3>
                            </div>

                            <div class="box-body form-horizontal">

                                <!-- Muestra errores -->
                                <span class="errores text-danger"></span>

                                <!-- Campo oculto: ID -->
                                <input type="hidden" id="update_id_categoria">

                                <!-- Campo: Nombre -->
                                <div class="form-group">
                                    <label for="update_nombre_categoria" class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nombre" id="update_nombre_categoria" placeholder="Nombre">
                                    </div>
                                </div>

                                <!-- Campo: Descripción -->
                                <div class="form-group">
                                    <label for="update_descripcion_categoria" class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="descripcion" id="update_descripcion_categoria" placeholder="Descripción">
                                    </div>
                                </div>
                            </div>

                            <!-- Botón actualizar -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-primary" id="btn_update_categoria">Actualizar</button>
                            </div>
                            <br>

                        </div>
                    </div>
                </div>

                <!-- Footer modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>
