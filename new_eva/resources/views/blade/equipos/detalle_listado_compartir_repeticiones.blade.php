<div class="contenedor_creado"></div>
<input type="hidden" name="equipo_origen_id" id="equipo_origen_id" value="{{ $equipo_origen_id }}">
<table style="font-size: 12px;" class="table table-condensed table-sm table-hover tbl-listado-equipos">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Codigo</th>
            <th>Serie</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>#Espec.</th>
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
            <td>{{ $equipo->numero_especificaciones }}</td>
            <td><input class="registro_{{ $equipo->id }}" onclick="funcion_creacion_input_especificaciones_tecnicas({{ $equipo->id }})" type="checkbox" name="seleccion[]" value="{{ $equipo->id }}"></td>
        </tr>
        @endforeach
    </tbody>
</table>

<button type="button" class="btn btn-primary">Compartir</button>
