@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h3>Closed</h3> <small>List</small>
    <input class="rol" type="hidden" value="{{ session('rol_id') }}">
    <input class="usuario_id" type="hidden" value="{{ session('id') }}">
  </section>

  <section class="content">
    <div class="box box-solid orden_cerrada">
      <div class="box-body">
        <div class="row"></div>

        <hr>

        <div class="row">
          <div class="col-md-12 table-responsive">
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label>Sede</label>
                  <select class="form-control select2 sede_id" style="width: 100%;">
                    <option value="0">--------</option>
                    <option value="1">Principal</option>
                    <option value="2">Norte</option>
                  </select>
                </div>
              </div>
            </div>

            <table class="table table-info container-table" id="tblOrdenes">
              <thead>
                <tr>
                  <th></th>
                  <th>#</th>
                  <th>Reporte</th>
                  <th>Cierre</th>
                  <th>Tiempo de cierre</th>
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

<script>
  const base_url = "{{ url('/') }}";
  const controlador = "{{ session('controlador') }}";
</script>
@endsection

