<div id="modal_add_calibracion" class="modal fade" role="dialog">
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
                                <h3 class="box-title">Calibración</h3>
                            </div>

                            <div class="box-body form-horizontal">
                                <!-- Formulario de calibración -->
                                <form action="{{ url('equipo/Cequipos/addCalibracion') }}"
                                    id="form_calibracion"
                                    name="form_calibracion"
                                    method="POST"
                                    enctype="multipart/form-data">

                                    @csrf

                                    @php
                                    $fecha_superior = \Carbon\Carbon::now()->addDay()->format('Y-m-d');
                                    @endphp

                                    <input type="hidden" name="equipo_id" id="equipo_id">

                                    <br>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="description">Código calibración</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="description" id="description"
                                                class="form-control"
                                                placeholder="Código" required>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="fecha_calibracion">Fecha ejecución</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" name="fecha_calibracion" id="fecha_calibracion"
                                                required min="2015-01-01"
                                                max="{{ $fecha_superior }}"
                                                onblur="set_fecha_programada_add_calibracion()"
                                                onchange="set_fecha_programada_add_calibracion()">
                                        </div>

                                        <div class="col-sm-2">
                                            <label for="fecha_programada">Fecha programada</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" name="fecha_programada" id="fecha_programada" required>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="badge">Archivo asociado</label>
                                            <input type="file"
                                                class="file"
                                                style="height: 50%;"
                                                data-browse-on-zone-click="true"
                                                name="file"
                                                id="file">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" id="btn_add_calibracion">
                                            Ingresar
                                        </button>
                                    </div>

                                    <div class="errores"></div>
                                    <div class="mensaje"></div>
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
