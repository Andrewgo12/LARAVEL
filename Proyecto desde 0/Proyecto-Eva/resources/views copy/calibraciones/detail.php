<div style="overflow-x: auto;">
    <a class="btn btn-info" href="{{ url('calibracion/Ccalibraciones/ExportarExcel') }}" target="_blank">
        Exportar Consolidado
    </a>
    <br><br>

    <table border="1" class="datatable-calibraciones table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha Ejecución</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Código Interno</th>
                <th>Ubicación</th>
                <th>Archivo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calibraciones as $calibracion)
            <tr>
                <td>{{ $calibracion->codigo }}</td>
                <td>{{ $calibracion->fecha_ejecucion }}</td>
                <td>{{ $calibracion->equipo }}</td>
                <td>{{ $calibracion->marca }}</td>
                <td>{{ $calibracion->modelo }}</td>
                <td>{{ $calibracion->serial }}</td>
                <td>{{ $calibracion->code }}</td>
                <td>{{ $calibracion->ubicacion }}</td>
                <td>
                    @if (!empty($calibracion->archivo))
                    <a target="_blank" class="glyphicon glyphicon-file"
                        href="{{ asset('assets/upload_calibraciones/' . $calibracion->archivo) }}"></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
