<div id="modal_show_cambios_ubicaciones" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info" style="overflow-x: auto;">
                            <div class="box-header with-border">
                                <h3 class="box-title">Movimiento de equipos</h3>
                            </div>

                            <div class="box-body form-horizontal">
                                <table class="tblCambiosEquipos table table-condensed table-bordered table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Servicio origen</th>
                                            <th>Servicio destino</th>
                                            <th>Área origen</th>
                                            <th>Área destino</th>
                                            <th>Sede origen</th>
                                            <th>Sede destino</th>
                                            <th>Responsable</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-transform: lowercase;">
                                        @foreach ($cambios_ubicaciones as $cambio)
                                        <tr>
                                            <td>{{ $cambio->fecha }}</td>
                                            <td>{{ $cambio->servicio_origen }}</td>
                                            <td>{{ $cambio->servicio_destino }}</td>
                                            <td>{{ $cambio->area_origen }}</td>
                                            <td>{{ $cambio->area_destino }}</td>
                                            <td>{{ $cambio->sede_origen }}</td>
                                            <td>{{ $cambio->sede_destino }}</td>
                                            <td>{{ $cambio->usuario }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
