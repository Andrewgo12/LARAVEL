<!-- Modal Agregar Categoría -->
<div id="modal_add_categoria" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar Categoría</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Nueva Categoría</h3>
                            </div>

                            <div class="box-body form-horizontal">
                                <!-- Errores -->
                                <span class="errores text-danger"></span>

                                <!-- Campo: Nombre -->
                                <div class="form-group">
                                    <label for="add_nombre_categoria" class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nombre" id="add_nombre_categoria" placeholder="Nombre">
                                    </div>
                                </div>

                                <!-- Campo: Descripción -->
                                <div class="form-group">
                                    <label for="add_descripcion_categoria" class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="descripcion" id="add_descripcion_categoria" placeholder="Descripción">
                                    </div>
                                </div>
                            </div>

                            <!-- Footer con botón -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-primary" id="btn_add_categoria">Ingresar</button>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>
