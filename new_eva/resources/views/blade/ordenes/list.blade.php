@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <img id="eva-tickets" src="{{ asset('assets/template/eva_modificada.jpg') }}" />
  </section>

  <section class="content">
    <div class="box box-solid orden_creada">
      <div class="box-body">

        {{-- Botones de creación de órdenes --}}
        <div class="row">
          <div class="col-md-12">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a data-toggle="modal" onclick="inicio_modal()" data-target="#modal_add_biomedicos"
                   title="Generar orden de trabajo para equipos biomédicos"
                   class="btn btn-lg btn-primary abrir_modal_add_orden_biomedico">
                  <span class="fa fa-ticket"> Equipos biomédicos</span>
                </a>
              </li>
              <li class="list-inline-item">
                <a data-toggle="modal" onclick="inicio_modal()" data-target="#modal_add_industriales"
                   title="Generar orden de trabajo para equipos industriales"
                   class="btn btn-lg btn-primary abrir_modal_add_orden_industrial">
                  <span class="fa fa-ticket"> Equipos industriales</span>
                </a>
              </li>
              <li class="list-inline-item">
                <a data-toggle="modal" onclick="inicio_modal()" data-target="#modal_add_otros"
                   title="Generar orden de trabajo para infraestructura y mobiliario"
                   class="btn btn-lg btn-primary abrir_modal_add_orden_otros">
                  <span class="fa fa-ticket"> Infraestructura y mobiliario</span>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <hr>

        {{-- Filtro por origen --}}
        <div class="row">
          <div class="col-md-12 table-responsive">
            <a href="#" class="abrir_modal_add_orden" data-toggle="modal" data-target="#modal_add_orden"></a>
            <a style="display: none;" href="#" class="abrir_modal_timeline" data-toggle="modal" data-target="#modal_timeline_orden"></a>

            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Origen</label>
                  <select class="form-control select2 subproceso_id" style="width: 100%;">
                    <option value="0">--------</option>
                    <option value="1">Equipos biomédicos</option>
                    <option value="2">Equipos industriales</option>
                    <option value="3">Infraestructura y mobiliario</option>
                  </select>
                </div>
              </div>
            </div>

            {{-- Tabla de órdenes --}}
            <table class="table container-table table-info" id="tblOrdenes">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Descripción</th>
                  <th>Fecha de creación</th>
                  <th>Estado</th>
                  <th style="width: 20%;"></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

{{-- Pasar variables de Blade a JavaScript --}}
<script>
  const base_url = "{{ url('/') }}";
  const id = "{{ session('id') }}";
  const controlador = "{{ session('controlador') }}";
  const anio_plan = "{{ session('anio_plan') }}";

  // Acciones para el módulo de áreas (índice 18 del arreglo de acciones)
  const insertar_area = "{{ session('acciones')[18]->insertar ?? 0 }}";
  const editar_area   = "{{ session('acciones')[18]->editar ?? 0 }}";
  const eliminar_area = "{{ session('acciones')[18]->eliminar ?? 0 }}";
</script>
@endsection
