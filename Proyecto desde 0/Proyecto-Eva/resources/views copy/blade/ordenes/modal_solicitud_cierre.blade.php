<div id="modal_solcitud_cierre_orden" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Trabajo realizado</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"></h3>
                            </div>
                            <div class="box-body form-horizontal">
                                {{-- Formulario para solicitar cierre de orden --}}
                                <form action="{{ url('orden/Cordenes/update_solicitar_cierre_orden') }}" id="form_solicitar_cierre_orden" name="form_solicitar_cierre_orden" class="form_solicitar_cierre_orden" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="id" class="id">

                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h3>Asunto</h3>
                                            <h4><span class="asunto"></span></h4>
                                        </li>
                                        <li class="list-inline-item">
                                            <h3>Descripción</h3>
                                            <h4><span class="descripcion"></span></h4>
                                        </li>
                                        <li class="list-inline-item">
                                            <h3>Prioridad</h3>
                                            <h4><span style="text-transform: uppercase;" class="prioridad"></span></h4>
                                        </li>
                                        <span class="contenido_ubicacion"></span>
                                    </ul>
                                    <span class="contenido_equipo"></span>

                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h3>Retro diagnóstico</h3>
                                            <h4><span class="retro_diagnostico"></span></h4>
                                        </li>
                                        <li class="list-inline-item">
                                            <h3>Diagnóstico</h3>
                                            <p class="diagnostico"></p>
                                        </li>
                                        <li class="list-inline-item">
                                            <h3>Codificación de diagnóstico</h3>
                                            <h4><span class="contenedor_codigo_diagnostico"></span></h4>
                                        </li>
                                        <li class="list-inline-item">
                                            <h3>Fecha de diagnóstico</h3>
                                            <h4><span class="fecha_diagnostico"></span></h4>
                                        </li>
                                    </ul>

                                    <span class="contenedor_repuestos_necesarios"></span>

                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h4>Retro cierre</h4>
                                            <h5>
                                                <input required type="text" class="form-control" id="retro_cierre" name="retro_cierre" placeholder="Ingrese retro cierre">
                                            </h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <h4>Trabajo realizado</h4>
                                            <h5>
                                                <textarea required name="reparacion" id="reparacion" cols="50" rows="5" placeholder="Indique cuál fue la intervención realizada"></textarea>
                                            </h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <h4>Codificación de cierre</h4>
                                            <h5>
                                                <select required class="form-control cierre_id" name="cierre_id" id="cierre_id"></select>
                                            </h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="contenendor_file" style="display: none;">
                                                <h4>Archivo de retro cierre</h4>
                                                <input disabled class="file" data-browse-on-zone-click="true" type="file" name="file_cierre" id="file_cierre">
                                            </div>
                                        </li>
                                    </ul>

                                    <span class="contenido_administrador"></span>

                                    <div class="box-footer">
                                        <button class="btn btn-primary" id="btn_update" type="submit">Actualizar</button>
                                        <h1><div id="mensaje"></div></h1>
                                    </div>
                                </form>
                                {{-- Fin del formulario --}}
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
