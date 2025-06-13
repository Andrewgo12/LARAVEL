<ul class="list-inline">
	<li class="list-inline-item">
		<span style="text-transform: uppercase;font-weight: 900">Fecha incial:</span>
		<span style="color: red;font-weight: 800;">{{ $vector["inicial"] }}</span>
	</li>
	<li class="list-inline-item">
		<span style="text-transform: uppercase;font-weight: 900">Fecha final:</span>
		<span style="color: red;font-weight: 800;">{{ $vector["final"] }}</span>
	</li>
</ul>
<div class="row">
	<div class="col-md-3">
		<strong style="text-transform: uppercase;">Cantidad de registros encontrados:</strong>&nbsp;<span style="color: red;">{{ $cantidad }}</span>
	</div>
	<div class="col-md-3">
		<strong style="text-transform: uppercase;">Inversion:</strong>&nbsp;<span style="color: red;font-weight: 800;">{{ $inversion }}</span>
	</div>	
	<div class="col-md-6">
		@if(session('sede_id')==1)
			<strong style="text-transform: uppercase;">Sede:</strong>&nbsp;<span style="color: red;">PRINCIPAL</span>
		<?php endif ?>
		@if(session('sede_id')==2)
			<strong style="text-transform: uppercase;">Sede:</strong>&nbsp;<span style="color: red;">NORTE</span>
		<?php endif ?>
		@if(session('sede_id')=="")
			<strong style="text-transform: uppercase;">Sede:</strong>&nbsp;<span style="color: red;">TODAS</span>
		<?php endif ?>
	</div>
</div>
<br>
@if($cantidad>0)



	<ul class="nav nav-tabs">
		<li class="active"><a href="#nav_instalacion_equipos">Equipos instalados</a></li>
		<li><a href="#nav_instalacion_distribucion_nombres">Distribución por nombre</a></li>
		<li><a href="#nav_instalacion_distribucion_tipo_adquisicion">Distribución por nombre y tipo adquisicion</a></li>
		@if($vector["tipo"]==1)
			<li><a href="#nav_instalacion_distribucion_riesgo">Distribución por riesgo</a></li>
			<li><a href="#nav_instalacion_distribucion_clasificacion_biomedica">Distribución por clasificación biomedica</a></li>
		<?php endif ?>
		<li><a href="#nav_instalacion_distribucion_alimentación">Distribución por fuente de alimentación</a></li>
	</ul>

	<div class="tab-content">
		<div id="nav_instalacion_equipos" class="tab-pane fade in active">
			
			@if(!empty($equipos))
				<div class="table-responsive">
					<table class="table table-bordered table-stripped tblInstalacion">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Costo</th>
								<th>Forma de adquisicion</th>
								<th>Codigo</th>
								<th>Serie</th>
								<th>Marca</th>
								<th>Modelo</th>
								<th>Fecha</th>
								<th>Servicio</th>
								<th>Area</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($equipos as $equipo)
								<tr>
									<td>{{ $equipo->name }} (<strong>Estado:</strong> {{ $equipo->estado }})</td>
									<td><span class="costo-personalizado">{{ $equipo->costo }}</span></td>
									<td>{{ $equipo->tadquisicion }}</td>
									<td>{{ $equipo->code }}</td>
									<td>{{ $equipo->serial }}</td>
									<td>{{ $equipo->marca }}</td>
									<td>{{ $equipo->modelo }}</td>
									<td>{{ $equipo->fecha_instalacion }}</td>
									<td>{{ $equipo->servicio }}</td>
									<td>{{ $equipo->area }}</td>
									<td><a title="Visualizar hoja de vida" href="#" class="btn btn-info glyphicon glyphicon-search" data-toggle="modal" data-target="#modal_show_equipo" onclick="show_equipo({{ $equipo->id }},'{{ $equipo->fecha_mantenimiento }}','{{ $equipo->v1 }}','{{ $equipo->v2 }}','{{ $equipo->v3 }}','{{ $equipo->costo }}')">
									</a>
								</td>
							</tr>
						<?php endforeach ?>

					</tbody>
				</table>
			</div>
			@else
				<h2>No se encontraron registros</h2>

			<?php endif ?>		
		</div>
		<div id="nav_instalacion_distribucion_nombres" class="tab-pane fade">
			<div class="">
				<span style="color: #15c39a;"><strong style="text-transform: uppercase;">DISTRIBUCION POR NOMBRE</strong></span>
				<table border="0" class=" table">
					<thead>
					</thead>
					<tbody>
						@foreach($listado as $registro)
							<tr>
								<td>
									<div class="notification">
										<span>{{ $registro->nombre }}</span>
										<span class="badge">{{ $registro->cantidad }}</span>
									</div>							
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>		
		</div>
		<div id="nav_instalacion_distribucion_tipo_adquisicion" class="tab-pane fade">
			<div class="">
				<span style="color: #15c39a;"><strong style="text-transform: uppercase;">DISTRIBUCION POR NOMBRE Y TIPO ADQUISICION</strong></span>
				<table border="0" class=" table">
					<thead>
					</thead>
					<tbody>
						@foreach($tipos_adquisicion as $tipo_adquisicion)
							<tr>
								<td>
									<div class="notification">
										<span>{{ $tipo_adquisicion->nombre }}</span>
										<span class="badge">{{ $tipo_adquisicion->cantidad }}</span>
									</div>							
								</td>
								<td>{{ $tipo_adquisicion->tipoa }}</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>			
		</div>
		<div id="nav_instalacion_distribucion_riesgo" class="tab-pane fade">
			<div class="">
				<span style="color: #15c39a;"><strong style="text-transform: uppercase;">DISTRIBUCION POR RIESGO</strong></span>
				<table border="0" class=" table">
					<thead>
					</thead>
					<tbody>
						@foreach($riesgos as $riesgo)
							<tr>
								<td>
									<div class="notification">
										<span>{{ $riesgo->riesgo }}</span>
										<span class="badge">{{ $riesgo->cantidad }}</span>
									</div>							
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>		
		</div>
		<div id="nav_instalacion_distribucion_clasificacion_biomedica" class="tab-pane fade">
			<div class="">
				<span style="color: #15c39a;"><strong style="text-transform: uppercase;">DISTRIBUCION POR CLASIFICACION BIOMEDICA</strong></span>
				<table border="0" class=" table">
					<thead>
					</thead>
					<tbody>
						@foreach($clasificaciones as $clasificacion)
							<tr>
								<td>
									<div class="notification">
										<span>{{ $clasificacion->clasificacion }}</span>
										<span class="badge">{{ $clasificacion->cantidad }}</span>
									</div>							
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>		
		</div>
		<div id="nav_instalacion_distribucion_alimentación" class="tab-pane fade">
			<div class="">
				<span style="color: #15c39a;"><strong style="text-transform: uppercase;">DISTRIBUCION POR FUENTE DE ALIMENTACION</strong></span>
				<table border="0" class="table">
					<thead>
					</thead>
					<tbody>
						@foreach($fuentes as $fuente)
							<tr>
								<td>
									<div class="notification">
										<span>{{ $fuente->fuente }}</span>
										<span class="badge">{{ $clasificacion->cantidad }}</span>
									</div>							
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>			
		</div>
	</div>
<?php endif ?>



