<div class="" style="overflow-x: auto;">
    <!-- <div class="" style="overflow-x: auto;"> -->
    <a class="btn btn-info" href="{{ asset('') }}correctivo_general/Ccorrectivos_generales/ExportarExcel" target="_blank">Exportar Consolidado</a><br><br>
    <table border="1" style="font-size: 12px;" class="datatable-correctivos table table-condensed">
        <thead>
            <th>Fecha de creación de la orden</th>
            <th>Codigo de orden de trabajo</th>
            <th>Descripcion de la orden</th>
            <th>Codificación de cierre</th>
            <th>Equipo</th>
            <th>Codigo Equipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Ubicacion</th>
            <th>Archivo</th>
            <th>Codigo de Retro</th>
            <th>Descripcion de Cierre</th>
            <th>Fecha de Cierre</th>
        </thead>
        <tbody>
            @foreach($correctivos as $correctivo)
                <tr>
                    <td>{{ $correctivo->fecha_inicio }}</td>
                    <td>{{ $correctivo->code_orden }}</td>
                    <td><span class="limitado">{{ $correctivo->orden }}</span></td>
                    <td>
                        @if($correctivo->code_orden != "" && $correctivo->code_orden != null)
                            @if(($correctivo->descripcion == "" || $correctivo->descripcion == null) && ($correctivo->codigo_correctivo == "" || $correctivo->codigo_correctivo == null))
                                <span style="color: red;font-size: 15px;font-weight: 700;">---Orden abierta---</span>
                            @else
                                {{ $correctivo->codificacion }}
                                <hr>
                                {{ $correctivo->descripcion_codificacion }}
                            @endif
                        @else
                            <span>Sin Info de orden de trabajo</span>
                        @endif
                    </td>
                    <td>{{ $correctivo->equipo }}</td>
                    <td>{{ $correctivo->code }}</td>
                    <td>{{ $correctivo->marca }}</td>
                    <td>{{ $correctivo->modelo }}</td>
                    <td>{{ $correctivo->serial }}</td>
                    <td>{{ $correctivo->ubicacion }}</td>
                    @if($correctivo->archivo != "" && $correctivo->archivo != null)
                        <td><a target="__blank" class="glyphicon glyphicon-file" href="{{ url('/') }}/assets/upload_correctivos_generales/{{ $correctivo->archivo }}"></a></td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $correctivo->codigo_correctivo }}</td>
                    <td class="limitado">{{ $correctivo->descripcion }}</td>
                    <td>{{ $correctivo->fecha_ejecucion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
