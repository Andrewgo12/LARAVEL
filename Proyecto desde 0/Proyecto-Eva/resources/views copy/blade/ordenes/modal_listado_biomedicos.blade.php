<div class="table table-responsive">
    <blockquote>
        <p>
            Haz click en <span class="btn btn-sm btn-success fa fa-check"></span> para seleccionar el equipo correspondiente
        </p>
    </blockquote>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="sede_id_auxliar">Sede:</label>
                    <select name="sede_id_auxliar" id="sede_id_auxliar" class="form-control sede_id_auxliar" onchange="funcion_seleccion_servicio_auxiliar_from_add_orden(this.value)">
                        {{-- Opciones de sede aquí --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="servicio_id_auxiliar">Servicio:</label>
                    <select name="servicio_id_auxiliar" id="servicio_id_auxiliar" class="form-control servicio_id_auxiliar" onchange="funcion_seleccion_area_auxiliar()">
                        {{-- Opciones de servicio aquí --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="area_id_auxiliar">Área:</label>
                    <select style="width: 100%" name="area_id_auxiliar" id="area_id_auxiliar" class="form-control area_id_auxiliar" onchange="cambio_area_server_side()">
                        {{-- Opciones de área aquí --}}
                    </select>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="tipo_id">
    <table style="font-size: 10px;" class="table table-sm table-hover table-condensed datatable-general tbl-listado-equipos">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Código</th>
                <th>Servicio</th>
                <th>Área</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            {{-- Aquí se insertarán las filas dinámicamente --}}
        </tbody>
    </table>
</div>
