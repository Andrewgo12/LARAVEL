@extends('layouts.app') {{-- Asegúrate de que tu layout base se llama app.blade.php --}}

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h3>Gestión de Tickets <small>List</small></h3>
    <input class="rol" type="hidden" value="{{ session('rol_id') }}">
    <input class="usuario_id" type="hidden" value="{{ session('id') }}">
  </section>

  <section class="content">
    @if(session()->has('message'))
      <div class="alert alert-info text-center">
        {{ session('message') }}
      </div>
    @endif

    <div class="box box-solid orden_activa">
      <div class="box-body">
        <hr>
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <div class="row">
              <div class="col-xs-4">
                <div class="form-group">
                  <label>Estado orden</label>
                  <select class="form-control select2 estado_id" style="width: 100%;">
                    <option value="">--------</option>
                    {{-- Opciones dinámicas opcionalmente pueden ir aquí --}}
                  </select>
                </div>
              </div>

              <div class="col-xs-4">
                <div class="form-group">
                  <label>Sede</label>
                  <select class="form-control select2 sede_id">
                    <option value="0">--------</option>
                    <option value="1">Principal</option>
                    <option value="2">Norte</option>
                  </select>
                </div>
              </div>

              <div class="col-xs-4">
                <div class="form-group">
                  <label>Fecha creación de ticket</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right rango-fechas">
                  </div>
                  <label class="checkbox-inline">
                    <input type="checkbox" class="condicion"> Aplicar filtro
                  </label>
                </div>
              </div>
            </div>

            {{-- Botón invisible que abre modal --}}
            <a href="#" data-toggle="modal" data-target="#modal_edit_orden" class="abrir_modal_edit_orden"></a>

            {{-- Tabla de tickets --}}
            <table class="table container-table table-info" id="tblOrdenes">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Descripción</th>
                  <th>Fecha de creación</th>
                  <th>Estado</th>
                  <th></th>
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

{{-- Variables de entorno para JS --}}
<script>
  const base_url = "{{ url('/') }}";
  const rol = "{{ session('rol_id') }}";
  const id_propio = "{{ session('id') }}";
  const controlador = "{{ session('controlador') }}";
  const insertar_observacion = "{{ session('acciones')[17]->insertar ?? '' }}";
  const eliminar_observacion = "{{ session('acciones')[17]->eliminar ?? '' }}";
  const editar_observacion = "{{ session('acciones')[17]->editar ?? '' }}";
</script>
@endsection
