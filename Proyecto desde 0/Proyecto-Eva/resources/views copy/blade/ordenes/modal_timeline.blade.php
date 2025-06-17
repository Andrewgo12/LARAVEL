<div id="modal_timeline_orden" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 85%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actualizar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Orden</h3>
                            </div>
                            <div class="box-body form-horizontal" style="overflow-x: auto;">
                                <div id="print_modal_active" class="contenido-modal-timeline">
                                    {{-- Aquí se mostrará el timeline dinámicamente --}}
                                </div>
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="imprimir-ticket" type="button" class="btn btn-primary imprimir-ticket">
                        <span class="fa fa-print"></span> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
