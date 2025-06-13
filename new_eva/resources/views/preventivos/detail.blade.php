<div class="" style="overflow-x: auto;">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#listado">Listado Preventivos</a></li>
		<li><a href="#exportar">Exportar archivos</a></li>
	</ul>
	<div class="tab-content">
		<div id="listado" class="tab-pane fade in active">

			<a class="btn btn-info" href="{{ url('/') }}preventivo/Cpreventivos/ExportarExcel" target="_blank">Exportar listado</a><br><br>
			<div class="row">
				<div class="col-sm-12">
					<table style="font-size: 12px;" border="1" class="datatable-preventivos table table-condensed">
						<thead>

							<th>fecha ejecución</th>
							<th>codigo</th>
							<th>Equipo</th>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Serie</th>
							<th>Codigo</th>
							<th>Ubicacion</th>
							<th>Archivo</th>
							<th>Observaciones</th>
						</thead>
						<tbody>
							@foreach($preventivos as $preventivo)
								<tr>
									<td>{{ $preventivo->fecha_ejecucion }}</td>
									<td>{{ $preventivo->codigo }}</td>
									<td>{{ $preventivo->equipo }}</td>
									<td>{{ $preventivo->marca }}</td>
									<td>{{ $preventivo->modelo }}</td>
									<td>{{ $preventivo->serial }}</td>
									<td>{{ $preventivo->code }}</td>
									<td>{{ $preventivo->ubicacion }}</td>
									@if($preventivo->archivo!=""&&$preventivo->archivo!=null)
										<td>{{ "<a target='__blank' class='glyphicon glyphicon-file' href='".url('/')."assets/upload_preventivos/".$preventivo->archivo."'></a>" }}</td>
										@else
											<td></td>
										<?php endif ?>
										<td>{{ $preventivo->observacion }}</td>

									</tr>
								<?php endforeach ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>	
			<div id="exportar" class="tab-pane fade">
				<div class="row">
					<div class="col-sm-4">
						<label for="fecha_preventivos">Seleccione la fecha de los archivos a exportar</label>

						<form action="<?php echo url('/') ?>Zip/files" target="__blank" method="post" enctype="multipart/form-data">
							<button class="btn btn-success">Exportar</button>
							<br><br>
							<select required="" class="form-control fecha_preventivos" name="fecha_preventivos" id="fecha_preventivos">
							</select>
						</form>

					</div>
				</div>
				<p></p>
				<p></p>
			</div>	
		</div>
	</div>
