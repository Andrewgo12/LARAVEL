<div id="modal_add_correctivo_general" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 75%;">
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
                                <h3 class="box-title">Correctivo</h3>
                            </div>
                            <div class="box-body form-horizontal">
                                <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                                <form action="{{ asset('') }}equipo/Cequipos/addCorrectivoGeneral" id="form_correctivo_general" name="form_correctivo_general" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <br>
                                    <input type="hidden" name="equipo_id" id="equipo_id">

                                    <div class="panel panel-danger">
                                        <div class="panel-heading">Orden de trabajo</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="code_orden">Codigo de la orden</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="code_orden" id="code_orden" class="form-control" placeholder="Codigo de orden">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="orden">Descripción de la orden de trabajo</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="orden" id="orden" rows="5" placeholder="Ingrese la informacion de la orden"></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="fecha_inicio">Fecha en que se hace la orden</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input min="2015-01-01" type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="time" name="hora_orden" id="hora_orden" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Avance</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <textarea class="form-control descripcion_avance" name="descripcion_avance" id="descripcion_avance" rows="2" placeholder="Diligenciar este campo si desea agregar un avance"></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="fecha_avance">Fecha del avance</label>
                                                    <input type="date" class="form-control fecha_avance" value="{{ date('Y-m-d') }}" id="fecha_avance" name="fecha_avance">
                                                </div>
                                                <div class="col-sm-8">
                                                    <label for="titulo_avance">Titulo del avance</label>
                                                    <input placeholder="Titulo del avance" type="text" class="form-control titulo_avance" id="titulo_avance" name="titulo_avance">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Archivo asociado</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="titulo">Titulo del archivo</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="En caso de agregar archivo, ingrese un titulo de referencia">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="file" class="badge">Archivo asociado</label>
                                                    <input style="height: 20%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-success">
                                        <div class="panel-heading">Cierre</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="code">Codigo/retro</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="code" id="code" class="form-control" placeholder="Codigo">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="description">Descripcion del trabajo realizado</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Ingrese informacion descriptiva de la gestion realizada"></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="fecha_mantenimiento">Fecha del retro</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input min="2015-01-01" type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="time" name="hora_mantenimiento" id="hora_mantenimiento" class="form-control">
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="cierre_id">Codigo de Cierre</label>
                                                    <select id="cierre_id" name="cierre_id" class="cierre_id form-control"></select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="tipo_falla_id">Tipo de falla</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <select required name="tipo_falla_id" id="tipo_falla_id" class="form-control tipo_falla_id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Repuesto instalado</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="observacion">Observación</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <textarea name="observacion" id="observacion" class="form-control" placeholder="Observacion relacionada"></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="cantidad_entregada">Cantidad</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="number" name="cantidad_entregada" value="1" id="cantidad_entregada" class="form-control" placeholder="Cantidad entregada">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="repuesto_id_instalado">Repuesto</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select class="form-control repuesto_id select_especial" id="repuesto_id_instalado" name="repuesto_id_instalado" style="width: 100%;"></select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="fecha">Fecha de instalacion</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="date" name="fecha" id="fecha" min="2015-01-01" max="{{ date('Y-m-d', strtotime(date('Y-m-d') . '+ 1 day')) }}" class="form-control">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="file_repuesto_instalado" class="badge">Archivo asociado</label>
                                                    <input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file_repuesto_instalado" name="file_repuesto_instalado">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">Repuesto pendiente</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-3">
                                                        <label for="" class="badge">Repuesto pendiente</label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="button" class="btn btn-info glyphicon glyphicon-plus btn-xs add_new_rep"></button>
                                                    </div>
                                                    <div class="containerrep_table"></div>
                                                    <div class="containerrep"></div>
                                                    <p></p>
                                                    <strong>Relacionar repuesto pendiente</strong>
                                                    <input type="text" name="repuesto_id" id="repuesto_id" class="form-control" placeholder="Indicar cual es el repuesto pendiente segun el correctivo, si aplica.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" id="btn_add_correctivo_general">Ingresar</button>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
