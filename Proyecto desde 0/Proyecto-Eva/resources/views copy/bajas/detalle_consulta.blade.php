<table class="datatable-bajas table table-bordered table-condensed" border="1">
    <thead>
        <tr>
            <th></th>
            <th>Fecha</th>
            <th>Descripcion</th>
            <th>Archivo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bajas as $baja)
        <tr>
            <td>
                <span style="font-size: 8px;" class="btn btn-info" onclick="asociar_baja({{ $baja->id }},{{ $equipo_id }})">Seleccionar</span>
            </td>
            <td>{{ $baja->fecha_baja }}</td>
            <td>{{ $baja->descripcion }}</td>
            <td>
                @if($baja->archivo!=""&&$baja->archivo!=null)
                <a target="__blank" class="glyphicon glyphicon-file" href="{{ asset('') }}assets/upload_bajas/{{ $baja->archivo }}"></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
