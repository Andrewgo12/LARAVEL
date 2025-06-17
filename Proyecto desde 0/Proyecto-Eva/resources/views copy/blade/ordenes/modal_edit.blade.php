<div id="modal_edit_orden" class="modal fade" role="dialog">
    <div class="modal-dialog">
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
                            <div class="box-body form-horizontal">
                                <!-- Diagnóstico en caso que se haya realizado -->
                                <input type="hidden" id="diagnostico_db" name="diagnostico_db">

                                <form action="{{ url('orden/Cordenes/update') }}" id="form_orden" name="form_orden" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <!-- id de la orden para actualizar -->
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" name="tecnico_cierre" id="tecnico_cierre" value="{{ session('id') }}">
                                    <input type="hidden" name="tecnico_diagnostico" id="tecnico_diagnostico" value="{{ session('id') }}">

                                    <div class="subproceso_0">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label for="prioridad">Prioridad</label><br>
                                                <select class="form-control" name="prioridad" id="prioridad">
                                                    <option value="baja">Baja</option>
                                                    <option value="media">Media</option>
                                                    <option value="alta">Alta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- Más contenido aquí si es necesario -->
                                    </div>
                                    <br>

                                    <div class="subproceso_1">
                                        @if(session('rol_id') <= 2)
                                            <!-- super admin o admin -->
                                            <table class="table table-bordered">
                                                <!-- Contenido de la tabla aquí -->
                                            </table>
                                        @endif
                                    </div>

                                    <div class="subproceso_2">
                                        @if(session('rol_id') <= 2)
                                            <!-- super admin o admin -->
                                            <table class="table table-bordered">
                                                <!-- Contenido de la tabla aquí -->
                                            </table>
                                        @endif
                                    </div>

                                    <div class="contenedor_input_diagnostico" style="display: none;">
                                        @if(session('rol_id') <= 2)
                                            <!-- Puede ingresar fecha de diagnóstico -->
                                            <!-- Contenido de diagnóstico aquí -->
                                        @endif
                                        <!-- Más contenido de diagnóstico aquí -->
                                    </div>

                                    <div class="contenedor_input_cierre" style="display: none;">
                                        @if(session('rol_id') <= 2)
                                            <!-- Puede ingresar fecha de cierre -->
                                            <!-- Contenido de cierre aquí -->
                                        @endif
                                        <!-- Más contenido de cierre aquí -->
                                    </div>

                                    <div class="box-footer">
                                        <button class="btn btn-primary" id="btn_update" type="submit">Actualizar</button>
                                        <h1><div id="mensaje"></div></h1>
                                    </div>
                                </form>
                                <div id="errores"></div>
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
