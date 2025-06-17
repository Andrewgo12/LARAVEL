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
                                <form action="{{ asset('') }}equipo/Cequipos/addCorrectivoGeneral" id="form_correctivo_general" name="form_correctivo_general" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <br>
                                    <input type="hidden" name="equipo_id" id="equipo_id">

                                    <div class="panel panel-danger">
                                        <div class="panel-heading">Orden de trabajo</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="code_orden">Código de la orden</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="code_orden" id="code_orden" class="form-control" placeholder="Código de orden">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="orden">Descripción de la orden de trabajo</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="orden" id="orden" rows="10" placeholder="Ingrese la información de la orden"></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="fecha_inicio">Fecha en que se hace el reporte</label>
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

                                    <div class="panel panel-success">
                                        <div class="panel-heading">Cierre</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="code">Código/retro</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="code" id="code" class="form-control" placeholder="Código">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="description">Descripción del trabajo realizado</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="description" id="description" rows="10" placeholder="Ingrese información descriptiva de la gestión realizada"></textarea>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="fecha_mantenimiento">Fecha del retro</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input min="2015-01-01" type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="time" name="hora_mantenimiento" id="hora_mantenimiento" class="form-control">
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="cierre_id">Código de Cierre</label>
                                                    <select required disabled id="cierre_id" name="cierre_id" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">Archivo asociado</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="titulo">Título del archivo</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="En caso de agregar archivo, ingrese un título de referencia">
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="file" class="badge">Archivo asociado</label>
                                                    <input style="height: 50%;" type="file" class="file" data-browse-on-zone-click="true" id="file" name="file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Repuesto instalado</div>
                                        <div class="panel-body">
                                            <select name="repuesto_instalado" id="repuesto_instalado" class="form-control"></select>
                                        </div>
                                    </div>

                                    <div class="panel panel-warning">
                                        <div class="panel-heading">Repuesto pendiente</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="repuesto_id" class="badge">Repuesto pendiente</label>
                                                    <input type="text" name="repuesto_id" id="repuesto_id" class="form-control" placeholder="Indicar cuál es el repuesto pendiente según el correctivo, si aplica.">
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
