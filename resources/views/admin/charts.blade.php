<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Charts 
      <small>Información dinamica</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box box-solid">
      <div class="box-body" style="overflow-x: auto;">
        <div class="row">
          <div class="col-sm-2">        
            <h4 style="opacity: 50%;">Seleccionar tipo</h4>
            <select name="" id="" class="seleccion_subproceso form-control">
              <option value="">-------</option>
              <option value="1">Equipos biomedicos</option>
              <option value="2">Equipos Industriales</option>
              <option value="3">Otros</option>
            </select>
            <br>
          </div>
          <div class="col-sm-2">
            <h4 style="opacity: 50%;">Seleccionar Sede</h4>
            <select name="" id="" class="sede_id form-control">
              <option value="">-----</option>
              <option value="1">Principal</option>
              <option value="2">Norte</option>
            </select>
          </div>
          <div class="col-sm-4">
            <h4 style="opacity: 50%;">Seleccionar Tipo de adquisicion</h4>
            <select style="width: 100%;" data-placeholder="Adquisicion" name="tadquisicion_id" id="tadquisicion_id" class="select2 tadquisicion_id form-control" heigh="30" multiple></select> 
          </div>
          <div class="col-sm-4">
            <h4 style="opacity: 50%;">Seleccionar Estado actual de los equipos</h4>
            <select style="width: 100%;" data-placeholder="Estado" name="estadoequipo_id" id="estadoequipo_id" class="select2 estadoequipo_id form-control" heigh="30" multiple></select> 
          </div>
        </div>

        <h2>PANEL DE CONTROL</h2>
        <p>Seleccione la opción que desea consultar.</p>
        <ul class="nav nav-tabs">
          <li class="active"><a href="#home">Home</a></li>
          <li><a href="#menu">Correctivos</a></li>
          <li><a href="#menu1">Preventivos</a></li>
          <li><a href="#menu2">Equipos</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">

          </div>
          <div id="menu" class="tab-pane fade">
            <h3>CORRECTIVOS</h3>

            <div class="row">
              <div class="col-sm-4" style="overflow-x: auto;"><div id="creados"></div></div>
              <div class="col-sm-4" style="overflow-x: auto;"><div class="" id="cerrados"></div></div>
              <div class="col-sm-4" style="overflow-x: auto;"><div id="estados"></div></div>
            </div>

            <div class="row">
              <div class="col-sm-4" style="overflow-x: auto;"><div id="correctivos_generales_creados"></div></div>
              <div class="col-sm-4" style="overflow-x: auto;"><div class="" id="correctivos_generales_cerrados"></div></div>
              <div class="col-sm-4" style="overflow-x: auto;"><div id="correctivos_generales_estados"></div></div>
            </div>
            <div class="row">
              <div class="col-sm-6"><div id="tickets_indicador"></div></div>
              <div class="col-sm-6"><div class="" id="correctivos_generales_indicador"></div></div>
            </div>             

          </div>

          <div id="menu1" class="tab-pane fade">
            <h3>PREVENTIVOS</h3>
            <div class="row">
              <div class="col-sm-3">
                <select style="width: 100%;" name="responsable_mantenimiento" id="responsable_mantenimiento" class="responsable_mantenimiento select2 form-control"></select>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12"><div id="preventivos_programados_indicador"></div></div>
              <div class="col-sm-12"><div id="preventivos_ejecutados_indicador"></div></div>
              <div class="col-sm-12"><div id="preventivos_indicador_ejecucion"></div></div>
            </div>  

          </div>

          <div id="menu2" class="tab-pane fade">
            <h3>EQUIPOS</h3>

            <p>Informacion general de los equipos.</p>
            <div class="row">
              <div class="col-sm-4"><div id="DistributionCbiomedica"></div></div>
              <div class="col-sm-4"><div id="DistributionRiesgo"></div></div>
              <div class="col-sm-4"><div id="DistributionEstado"></div></div>
            </div>
            <div class="row">
              <div class="col-sm-12"> <div id="DistribucionAdquisicion"></div> </div>
            </div>
            <div class="row">
              <div class="col-sm-12"> <div id="DistribucionInstalacion"></div> </div>
            </div>
            <div class="row">
              <div class="col-sm-12"> <div id="InstalacionAdquisicionIndicador"></div> </div>
            </div>
          </div>

        </div>

        <hr>
        <p class="act"><b>Pestaña activa</b>: <span>Home</span></p>
        <p class="prev"><b>Pestaña anterior</b>: <span></span></p>

      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var base_url="{{ url('/') }}/";
</script>