<div class="contenedor_creado"></div>
<input type="hidden" name="equipo_archivo_origen_id" id="equipo_archivo_origen_id" value="{{ $equipo_archivo_origen_id }}">
<input onclick="seleccionar_todos()" type="checkbox" class="total_box" label="check all" />Seleccionar todos
<input type="text" id="control" name="control" class="control" value="0">
<table style="font-size: 12px;" class="table table-condensed table-sm table-hover tbl-listado-equipos">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Codigo</th>
            <th>Serie</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Sede</th>
            <th>Servicio</th>
            <th>Area</th>
            <th>Soporte de adquisicion</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($equipos as $equipo)
        <tr>
            <td>{{ $equipo->name }}</td>
            <td>{{ $equipo->code }}</td>
            <td>{{ $equipo->serial }}</td>
            <td>{{ $equipo->marca }}</td>
            <td>{{ $equipo->modelo }}</td>
            <td>{{ $equipo->sede }}</td>
            <td>{{ $equipo->servicio }}</td>
            <td>{{ $equipo->area }}</td>
            <td>{{ $equipo->soporte_compra."(".$equipo->proveedor.")" }}</td>
            <td><input class="registro_{{ $equipo->id }} total_box1" onclick="funcion_creacion_input_archivos({{ $equipo->id }})" type="checkbox" name="seleccion[]" value="{{ $equipo->id }}"></td>
        </tr>
        @endforeach
    </tbody>
</table>

<button type="button" class="btn btn-primary">Compartir</button>
