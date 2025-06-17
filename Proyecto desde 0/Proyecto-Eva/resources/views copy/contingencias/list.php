@extends('layouts.main_template')

@section('title', 'Contingency List')

@section('body')
<div class="content-wrapper">
    <section class="content-header">
        <h3>Contingency</h3> <small>List</small>
    </section>

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <ul class="list-inline custom-row">
                    <a title="Exportar excel" target="_blank" class="custom-btn-figure" href="{{ url('equipo/contingencias/exportar') }}">
                        <li class="fa fa-file-excel-o"></li>
                    </a>

                    @php
                    $acciones = session('acciones');
                    @endphp

                    @foreach ($acciones as $accion)
                    @if ($accion->modulo === 'contingencias' && $accion->insertar == 1)
                    <a href="#" class="custom-btn-figure" title="Ingresar contingencia" data-toggle="modal" data-target="#modal_add_contingencia">
                        <li class="glyphicon glyphicon-plus"></li>
                    </a>
                    @endif
                    @endforeach
                </ul>

                <div class="table-responsive contenedor-contingencias">
                    <table class="tblContingencias table table-info container-header" id="tblContingencias" name="tblContingencias">
                        <thead>
                            <tr>
                                <th>Observaciones</th>
                                <th>Fecha</th>
                                <th>Fecha cierre</th>
                                <th>Archivo</th>
                                <th>Usuario quien la ingresa</th>
                                <th>Información del equipo</th>
                                <th>Estado</th>
                                <th>Origen de la contingencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="apendice-contingencia">
                            {{-- Los datos se insertarán dinámicamente vía JS/AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const base_url = "{{ url('/') }}";
    const eliminar_contingencia = "{{ session('acciones')[20]->eliminar ?? 0 }}";
    const editar_contingencia = "{{ session('acciones')[20]->editar ?? 0 }}";
    const controlador = "{{ session('controlador') }}";
</script>
@endsection
