<div class="table table-responsive">
	<blockquote>
		<p>
		Click en <span class="btn btn-sm btn-success fa fa-check"></span> para Seleccionar el equipo correspondiente
	</p>
	</blockquote>
<div class="panel-default">
	<div class="panel-body">
	<div class="row">
		<div class="col-md-4">
			<label for="">Sede:</label>
			<select name="sede_id_auxliar" id="sede_id_auxliar" class="form-control sede_id_auxliar" onchange="funcion_seleccion_servicio_auxiliar_from_add_orden(value)"></select>
		</div>
		<div class="col-md-4">
			<label for="">Servicio:</label>
			<select name="servicio_id_auxiliar" id="servicio_id_auxiliar" class="form-control servicio_id_auxiliar" onchange="funcion_seleccion_area_auxiliar()"></select>
		</div>
		<div class="col-md-4">
			<label for="area_id_auxiliar">Area:</label>
			<select style="width: 100%" name="area_id_auxiliar" id="area_id_auxiliar" class="form-control area_id_auxiliar" onchange="cambio_area_server_side()"></select>
		</div>
	</div>		
	</div>
</div>
	<input type="hidden" class="tipo_id">
	<table style="font-size: 10px;" class="table table-sm table-hover table-condensed datatable-general tbl-listado-equipos">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Serie</th>
				<th>Codigo</th>
				<th>Servicio</th>
				<th>Area</th>
				<th></th>
			</tr>
		</thead>
		<tbody>



		</tbody>
	</table>
</div>