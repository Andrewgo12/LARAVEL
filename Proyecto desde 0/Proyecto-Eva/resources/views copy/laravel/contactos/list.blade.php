<div class="content-wrapper">
  <section class="content-header">
    <h3>Contacts & Providers</h3> <small>List</small>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 table-responsive">
            <table class="table table-stripped table-info container-table" id="tblContactos">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Telefono</th>
                  <th>Correo electronico</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 table-responsive editarContacto">
            <form action="{{ asset('') }}ubicacion/Ccontactos/update" id="form_contacto" name="form_contacto" enctype="multipart/form-data" method="post">
      @csrf
              <input type="hidden" id="id" name="id" class="form-control">
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Nombre:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="text" class="form-control" placeholder="Nombre del contacto" name="name" id="name">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="email" class="">Email:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="text" class="form-control" placeholder="Correo electronico" name="email" id="email">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="telefono" class="">Telefono:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="text" class="form-control" placeholder="Numero telefonico" name="telefono" id="telefono">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Tipo de contacto:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <select required="" name="tcontacto_id" id="tcontacto_id" class="form-control"></select>
                </div>
              </div>
              <br>
              <div class="box-footer">
                <button class="btn btn-primary" id="btn_update_contacto" onclick="aplicar_condicion(1)" disabled="">Actualizar</button>
                <button class="btn btn-info fa fa-plus btn-flat" id="btn_add_contacto" onclick="aplicar_condicion(2)">Agregar</button>
              </div>
              <div class="errores"></div>
              <input type="hidden" id="condicion">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  var base_url = "<?= base_url(); ?>";
  var controlador = "<?php echo session('controlador'); ?>";
</script>