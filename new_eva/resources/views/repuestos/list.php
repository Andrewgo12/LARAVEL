<div class="content-wrapper">
  <section class="content-header">
    <h3>Spare parts</h3> <small>List</small>
  </section>
  <div class="container">
    <ul class="list-inline section-filter-navbar">
      <li class="list-inline-item custom-btn">
        <a class="btn btn-default" data-toggle="modal" data-target="#modal_show" onclick="show_repuestos_instalados()">Repuestos instalados</a>
      </li>
      <li class="list-inline-item custom-btn">
        <a class="btn btn-default" data-toggle="modal" data-target="#modal_show" onclick="show_repuestos_pendientes()">Repuestos pendientes</a>
      </li>
      <li class="list-inline-item custom-btn">
        <a class="btn btn-default" data-toggle="modal" data-target="#modal_show" onclick="show_resumen_por_repuesto()">Resumen por repuestos</a>
      </li>
      <li class="list-inline-item custom-btn">
        <a class="btn btn-default" data-toggle="modal" data-target="#modal_show" onclick="show_resumen_general()">Resumen general</a>
      </li>
      <li class="list-inline-item custom-btn">
        <a class="btn btn-default" data-toggle="modal" data-target="#modal_show" onclick="show_resumen_inversion_repuestos_equipo()">Inversion por equipo</a>
      </li>
      <li class="list-inline-item custom-btn">
        <a class="btn btn-default" data-toggle="modal" data-target="#modal_show" onclick="show_resumen_inversion_repuestos_servicio()">Inversion por servicio</a>
      </li>
    </ul>
  </div>


  <div class="row">
    <div class="col-sm-offset-1">
      <div class="col-sm-4">

        <div class="contenido" style="display: none;">
          <h3></h3>
          <form action="" enctype="multipart/form-data" method="post">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="stock" name="stock">
            <table class="table table-stripped">
              <tbody>
                <tr>
                  <td class="consulta"></td>
                  <td><input type="number" id="cantidad" name="cantidad" required=""></td>
                  <td><textarea name="razon" id="razon" cols="30" rows="5" placeholder="Razon del movimiento"></textarea></td>
                  <td><a href="#" onclick="sumar()" class="glyphicon glyphicon-plus btn btn-success"></a></td>
                  <td><a href="#" onclick="restar()" class="glyphicon glyphicon-minus btn btn-danger"></a></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
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
            <table class="table table-info container-table" id="tblRepuestos">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 table-responsive editarServicio">
            <form action="<?php echo base_url(); ?>ubicacion/Crepuestos/update" id="form_repuesto" name="form_repuesto" enctype="multipart/form-data" method="post">
              <input type="hidden" id="id" name="id" class="form-control">
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">Nombre:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="text" class="form-control" placeholder="Nombre del repuesto" name="name" id="name" required="">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="code" class="">codigo:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="text" class="form-control" placeholder="Codigo" name="code" id="code" required="">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="precio" class="">Precio con iva:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <input type="number" class="form-control" placeholder="Ingrese el valor del repuesto" name="precio" id="precio">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-3 col-sm-3 col-sm-3 col-sm-3 ">
                  <label for="grupo" class="">Grupo:</label>
                </div>
                <div class="col-sm-9 col-sm-9 col-sm-9 col-sm-9 ">
                  <select style="width: 100%;" class="form-control" name="grupo" id="grupo">
                    <option value="">------------------</option>
                    <option value="MT1">MT1</option>
                    <option value="DM1">DM1</option>
                    <option value="ET1">ET1</option>
                  </select>

                </div>
              </div>
              <br>
              <div class="box-footer">
                <button class="btn btn-primary" id="btn_update_equipo" onclick="aplicar_condicion(1)" disabled="">Actualizar</button>
                <button class="btn btn-info fa fa-plus btn-flat" id="btn_add_equipo" onclick="aplicar_condicion(2)">Agregar</button>
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
  var controlador = "<?php echo $this->session->userdata('controlador'); ?>";
</script>