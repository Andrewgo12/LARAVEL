<div class="text-center">
</div>
<table class="table table-stripped">
    <thead>
        <th>Tipo de archivo</th>
        @if($equipo_archivo[0]->archivo_id == 9)
            <th>Fecha de capacitación</th>
        @endif
        <th>Archivo</th>
        <th>Accion</th>
        <th></th>
    </thead>
    <tbody>
        @foreach($equipo_archivo as $equipo_a)
            <tr>
                <td>{{ $equipo_a->archivo }}</td>
                @if($equipo_a->archivo_id == 9)
                    <td>{{ $equipo_a->created_at }}</td>
                @endif
                <td>
                    <a href="{{ asset('assets/upload_equipo_archivos/' . $equipo_a->vinculo) }}" target="__blank" class="glyphicon glyphicon-file"></a>
                    @if($equipo_a->otro != "" && $equipo_a->otro != null)
                        ({{ $equipo_a->otro }})
                    @endif
                </td>
                <td>
                    <a href="" class="glyphicon glyphicon-remove btn btn-danger" onclick="delete_equipo_archivo({{ $equipo_a->id }}, event)"></a>
                </td>
                <td>
                    <a onclick="funcion_modal_compartir_archivos(event, {{ $equipo_a->id }}, {{ $equipo_a->equipo_id }})"
                       data-toggle="modal"
                       data-target="#modal_compartir_archivos"
                       href=""
                       style="color: blue; font-size: 13px; font-weight: 1200;"
                       title="Compartir archivos"
                       class="glyphicon glyphicon-share"></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
