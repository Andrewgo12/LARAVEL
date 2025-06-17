<div class="container table-responsive">
    <a class="btn btn-info" href="{{ asset('') }}equipo/Cequipos/ConsolidadoCalibraciones" target="_blank">Exportar Consolidado</a><br><br>
    <table class="datatable-calibraciones table">
        <thead>
            <th>codigo</th>
            <th>fecha ejecución</th>
            <th>Equipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Codigo</th>
            <th>Ubicacion</th>
            <th>Archivo</th>
        </thead>
        <tbody>
            @foreach($calibraciones as $calibracion)
                <tr>
                    <td>{{ $calibracion->codigo }}</td>
                    <td>{{ $calibracion->fecha_ejecucion }}</td>
                    <td>{{ $calibracion->equipo }}</td>
                    <td>{{ $calibracion->marca }}</td>
                    <td>{{ $calibracion->modelo }}</td>
                    <td>{{ $calibracion->serial }}</td>
                    <td>{{ $calibracion->code }}</td>
                    <td>{{ $calibracion->ubicacion }}</td>
                    @if($calibracion->archivo != "" && $calibracion->archivo != null)
                        <td><a target="__blank" class="glyphicon glyphicon-file" href="{{ asset('assets/upload_calibraciones/') }}/{{ $calibracion->archivo }}"></a></td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
