<div class="content-wrapper">
    <section class="content-header">
        <h3>Trainings</h3> <small>List</small>
    </section>

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#nav-cantidad-capacitaciones">#capacitaciones por mes</a></li>
                    <li><a data-toggle="tab" href="#nav-cantidad-equipos-cubiertos">Cobertura de equipos</a></li>
                    <li><a data-toggle="tab" href="#nav-informacion-por-registro">Información por registro</a></li>
                </ul>

                <div class="tab-content">
                    <!-- TAB 1 -->
                    <div id="nav-cantidad-capacitaciones" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-hover datatable-columna0-desc">
                                    <thead>
                                        <tr>
                                            <th>Mes</th>
                                            <th>Equipo</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($capacitaciones_equipo as $registro)
                                        <tr>
                                            <td>{{ $registro->mes }}</td>
                                            <td>{{ $registro->equipo }}</td>
                                            <td>{{ $registro->cantidad }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-bordered table-hover datatable-columna0-desc">
                                    <thead>
                                        <tr>
                                            <th>Mes</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($capacitaciones_mes as $registro)
                                        <tr>
                                            <td>{{ $registro->mes }}</td>
                                            <td>{{ $registro->cantidad }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2 -->
                    <div id="nav-cantidad-equipos-cubiertos" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover datatable-general" id="tblCapacitaciones">
                                <thead>
                                    <tr>
                                        <th>Equipo</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Servicio</th>
                                        <th>Cantidad cubierta</th>
                                        <th>Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($capacitaciones_realizadas as $cap)
                                    <tr>
                                        <td>{{ $cap->equipo }}</td>
                                        <td>{{ $cap->marca }}</td>
                                        <td>{{ $cap->modelo }}</td>
                                        <td>{{ $cap->servicio }}</td>
                                        <td>{{ $cap->cantidad }}</td>
                                        <td>
                                            <a href="{{ asset('assets/upload_equipo_archivos/'.$cap->vinculo) }}" target="_blank" class="glyphicon glyphicon-file"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 3 -->
                    <div id="nav-informacion-por-registro" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover datatable-general" id="tblCapacitaciones2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Vínculo</th>
                                        <th>Fecha de registro</th>
                                        <th>Equipo</th>
                                        <th>Marca</th>
                                        <th>Servicio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($capacitaciones_archivo as $archivo)
                                    <tr>
                                        <td>{{ $archivo->id }}</td>
                                        <td>
                                            <a href="{{ asset('assets/upload_equipo_archivos/'.$archivo->vinculo) }}" target="_blank" class="glyphicon glyphicon-file"></a>
                                        </td>
                                        <td>{{ $archivo->fecha_ingreso }}</td>
                                        <td>{{ $archivo->equipo }}</td>
                                        <td>{{ $archivo->marca }}</td>
                                        <td>{{ $archivo->servicio }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
            </div>
        </div>
    </section>
</div>

<script>
    var base_url = "{{ url('/') }}";
</script>
