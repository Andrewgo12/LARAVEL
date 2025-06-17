<div class="container table-responsive">
    <a class="btn btn-info" href="{{ asset('') }}equipo/Cequipos/ConsolidadoCorrectivosGenerales" target="_blank">Exportar Consolidado</a><br><br>
    <table class="datatable-correctivos table">
        <thead>
            <th>codigo Correctivo</th>
            <th>fecha ejecución</th>
            <th>Equipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Codigo Equipo</th>
            <th>Ubicacion</th>
            <th>Archivo</th>
        </thead>
        <tbody>
            @foreach($correctivos as $correctivo)
                <tr>
                    <td>{{ $correctivo->codigo_correctivo }}</td>
                    <td>{{ $correctivo->fecha_ejecucion }}</td>
                    <td>{{ $correctivo->equipo }}</td>
                    <td>{{ $correctivo->marca }}</td>
                    <td>{{ $correctivo->modelo }}</td>
                    <td>{{ $correctivo->serial }}</td>
                    <td>{{ $correctivo->code }}</td>
                    <td>{{ $correctivo->ubicacion }}</td>
                    @if($correctivo->archivo != "" && $correctivo->archivo != null)
                        <td><a target="__blank" class="glyphicon glyphicon-file" href="{{ asset('assets/upload_correctivos_generales/') }}/{{ $correctivo->archivo }}"></a></td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
