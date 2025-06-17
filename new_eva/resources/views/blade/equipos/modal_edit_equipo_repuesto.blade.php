<div id="modal_update_equipo_repuesto" class="modal fade" role="dialog">
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
                                <h3 class="box-title">Repuesto</h3>
                            </div>

                            <div class="box-body form-horizontal">
                                <form action="{{ asset('') }}equipos/Cequipos/updateEquipoRepuesto" id="form_update_equipo_repuesto" name="form_update_equipo_repuesto" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <br>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="equipo_id" id="equipo_id">

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="observacion">Observación</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea name="observacion" id="observacion" class="form-control" placeholder="Observación relacionada" required></textarea>
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="cantidad_entregada">Cantidad</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="cantidad_entregada" value="1" id="cantidad_entregada" class="form-control" placeholder="Cantidad entregada" required>
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="repuesto_id">Repuesto</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select style="width: 80%;" class="form-control repuesto_id select_especial" id="repuesto_id" name="repuesto_id" required></select>
                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="fecha">Fecha de instalación</label>
                                        </div>
                                        @php
                                            $fecha_superior = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 day"));
                                        @endphp
                                        <div class="col-sm-4">
                                            <input type="date" name="fecha" id="fecha" required min="2015-01-01" max="{{ $fecha_superior }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="file" class="badge">Archivo asociado</label>
                                            <input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" id="btn_update_equipo_repuesto">Actualizar</button>
                                    </div>
                                    <div class="errores"></div>
                                </form>
                            </div>
                            <br>
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
