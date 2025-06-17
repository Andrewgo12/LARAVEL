<div id="modal_update_area" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Area
                                </h3>
                            </div>
                            <div class="box-body form-horizontal">
                                <form action="" name="form_update_area" class="form_update_area" enctype="multipart/form-data" method="post" onsubmit="(new areaObj).HandleSubmitUpdate(event)">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <div class="form-group">
                                        <label for="name">Nombre del area</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese area" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="servicio_id">Servicio al que pertenece</label>
                                        <select style="width: 100%;" class="form-control servicio_id" id="servicio_id" name="servicio_id" required="">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="piso_id">Piso</label>
                                        <select style="width: 100%;" class="form-control piso_id" id="piso_id" name="piso_id" required="">
                                        </select>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-primary btn_update_area">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>