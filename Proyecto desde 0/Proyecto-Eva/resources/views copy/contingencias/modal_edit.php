<div id="modal_update_contingencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- Encabezado --}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar</h4>
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
                                    action="{{ route('contingencias.update') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="form_update_contingencia">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id" id="update_id" class="id">

                                    <br>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="update_fecha" class="badge">Fecha</label>
                                            <input
                                                type="date"
                                                name="fecha"
                                                id="update_fecha"
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="update_fecha_cierre" class="badge">Fecha de cierre</label>
                                            <input
                                                type="date"
                                                name="fecha_cierre"
                                                id="update_fecha_cierre"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="update_observacion" class="badge">Observación</label>
                                            <textarea
                                                name="observacion"
                                                id="update_observacion"
                                                class="form-control"
                                                rows="5"></textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="update_equipo_id" class="badge">Equipo</label>
                                            <select
                                                class="form-control"
                                                name="equipo_id"
                                                id="update_equipo_id">
                                                {{-- Opciones deben ser generadas dinámicamente en JS o en Blade --}}
                                            </select>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="update_file" class="badge">Archivo asociado (opcional)</label>
                                            <input
                                                type="file"
                                                class="file form-control"
                                                name="file"
                                                id="update_file"
                                                data-browse-on-zone-click="true">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>
                            </div>

                            <br>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pie --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
