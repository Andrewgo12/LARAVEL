<div id="modal_update_baja" class="modal fade" role="dialog">
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
                                <h3 class="box-title">Documento soporte de disposicion final de equipos biomedicos
                                </h3>
                            </div>

                            <div class="box-body form-horizontal">

                                <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                                <form action="{{ asset('') }}equipo/Cbajas/update" name="form_update_baja" class="form_update_baja" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <br>
                                    <input type="hidden" name="id" id="id">

                                    <div class="box-body form-horizontal">

                                        <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                                        <div class="form-group">

                                            <label for="fecha_baja" class="col-sm-2 control-label">Fecha de la baja</label>
                                            <div class="col-sm-10">
                                                <input required="" type="date" class="form-control" name="fecha_baja" id="fecha_baja">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripcion del documento"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="archivo" class="col-sm-2 control-label">Archivo</label>

                                            <div class="col-sm-10">
                                                <input type="file" class="file" id="archivo" name="archivo" data-browse-on-zone-click="true">
                                            </div>
                                        </div>


                                        <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                                    </div>

                                    <div class="box-footer">
                                        <button class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>



                                <!--  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
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