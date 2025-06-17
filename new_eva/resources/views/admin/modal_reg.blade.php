<div id="modal_reg_usuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Registrarse</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Información de usuario
                                </h3>
                            </div>
                            <form id="form_register" method="post" action="{{ url('Cauth/reg') }}">
                                @csrf
                                <div class="box-body form-horizontal">
                                    @if(isset($centros))
                                        <div class="form-group">
                                            <label for="centro_id" class="col-sm-2 control-label">Seleccione su centro de costo</label>
                                            <div class="col-sm-10">
                                                <select class="form-control " style="width: 100%;" name="centro_id" id="centro_id" required="">
                                                    <option value="">--Seleccione--</option>
                                                    @foreach($centros as $centro)
                                                        <option value={{ $centro->id }}>{{ $centro->code . "-" . $centro->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="nombre" class="col-sm-2 control-label">Nombres</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required name="nombre" id="nombre" placeholder="Nombres">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido" class="col-sm-2 control-label">Apellidos</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="apellido" placeholder="Apellidos" id="apellido">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono" class="col-sm-2 control-label">Telefono</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="telefono" placeholder="Telefono" id="telefono">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Correo electronico</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" placeholder="email" id="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="col-sm-2 control-label">Nombre de usuario</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="username" placeholder="Nombre de usuario" id="username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">Contraseña</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password1" placeholder="password1" id="password1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password2" class="col-sm-2 control-label">Confirmar contraseña</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password2" placeholder="password2" id="password2">
                                        </div>
                                    </div>
                                    <h1>
                                        <div id="mensaje"></div>
                                    </h1>
                                </div>
                                <div class="box-footer">
                                    <button class="btn btn-primary" id="btn_reg_usuario">Ingresar</button>
                                </div>
                            </form>
                            <br>
                            <span class="errores"></span>
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
<script>
    var base_url = "{{ url('/') }}/";
</script>