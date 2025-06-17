<div id="modal_add_contingencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- Encabezado --}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar</h4>
            </div>

            {{-- Cuerpo --}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contingencia</h3>
                            </div>

                            <div class="box-body form-horizontal">
                                <form
                                    action="{{ route('contingencias.store') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="form_add_contingencia">
                                    @csrf

                                    <input type="hidden" name="equipo_id" id="equipo_id" class="equipo_id">

                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="fecha" class="badge">Fecha</label>
                                            <input
                                                required
                                                id="fecha"
                                                name="fecha"
                                                class="form-control"
                                                type="date"
                                                value="{{ date('Y-m-d') }}">
                                        </div>

                                        <div class="col-md-8">
                                            <label for="observacion" class="badge">Observación</label>
                                            <textarea
                                                required
                                                class="form-control"
                                                name="observacion"
                                                id="observacion"
                                                cols="30"
                                                rows="5"
                                                placeholder="Ingrese información detallada de la contingencia"></textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="badge">Archivo asociado</label>
                                            <input
                                                type="file"
                                                class="file form-control"
                                                id="file"
                                                name="file"
                                                style="height: 50%;">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Insertar</button>
                                    </div>
                                </form>
                            </div>

                            <br>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pie del modal --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
