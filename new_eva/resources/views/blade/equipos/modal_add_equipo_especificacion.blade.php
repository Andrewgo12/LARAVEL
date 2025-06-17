<div id="modal_add_equipo_especificacion" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Especificación técnica</h3>
                            </div>

                            <div class="box-body form-horizontal">
                                <form action="{{ asset('') }}equipo/Cequipos/addEquipoEspecificacion" id="form_equipo_especificacion" name="form_equipo_especificacion" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <br>
                                    <input type="hidden" name="equipo_id" id="equipo_id">
                                    <div class="contenedor_valor">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label for="valor">Valor</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <textarea name="valor" id="valor" class="form-control textarea-personalizado" placeholder="Ingrese el valor"></textarea>
                                            </div>
                                        </div><br>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="especificacion_id">Especificación Técnica</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select required class="form-control select_especial" name="especificacion_id" id="especificacion_id"></select>
                                        </div>
                                    </div><br>
                                    <div class="contenedor_archivo">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label for="file" class="badge">Archivo asociado</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <input disabled data-browse-on-zone-click="true" type="file" class="file" id="file" name="file">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" id="btn_add_equipo_especificacion">Ingresar</button>
                                    </div>
                                    <div class="mensaje"></div>
                                    <div class="errores"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
