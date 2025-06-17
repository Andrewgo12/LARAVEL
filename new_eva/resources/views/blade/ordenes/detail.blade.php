		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Información de usuario</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
						</button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<strong>Nombre:</strong> {{ $orden->nombre }}<br>
					<strong>Apellido:</strong> {{ $orden->apellido }}<br>
					<strong>Teléfono:</strong> {{ $orden->telefono }}<br>
					<strong>Correo electrónico:</strong> {{ $orden->email }}<br>
					<strong>Centro de costo:</strong> {{ $orden->centro }}<br>

					@if($orden->nombre_reportante!="" && $orden->nombre_reportante!=null)
						<br>
						<label style="font-size: 15px;" for="">Se relaciona la información del siguiente reportante:</label><br>
					<strong>Nombre:</strong> {{ $orden->nombre_reportante }}<br>
					<strong>Centro de Costo:</strong> {{ $orden->centro_costo_reportante }}<br>
					@endif
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Ubicación de referencia</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
						</button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<strong>Ubicación:</strong> {{ $orden->servicio }}<br>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		@if($orden->subproceso_id==1)
			<div class="col-md-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Información del equipo</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table class="table">
							<tr><th>Nombre del equipo:</th><td>{{ $orden->nombre_equipo }}</td></tr>
							<tr><th>Modelo:</th><td>{{ $orden->modelo_equipo }}</td></tr>
							<tr><th>Serie:</th><td>{{ $orden->serie_equipo }}</td></tr>
							<tr><th>Código:</th><td>{{ $orden->codigo_equipo }}</td></tr>
							<tr><th>Marca:</th><td>{{ $orden->marca_equipo }}</td></tr>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		@endif
		@if($orden->subproceso_id==2)
			<div class="col-md-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Mantenimiento</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<strong>Subproceso:</strong> Mantenimiento industrial<br>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		@endif
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Descripción del ticket Nro {{ $orden->id }}</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
						</button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-sm-3">
							<label>Asunto</label><br>
							{{ $orden->asunto }}
						</div>
						<div class="col-sm-2"></div>
						<div class="col-sm-5">
							<label>Fecha de creación: {{ $orden->fecha_inicio }}</label>
						</div>
					</div><br>

					<div class="row">
						<div class="col-sm-5">
							<strong>Estado actual</strong><br>
							@if($orden->estado_id==1)	Creado
							@elseif($orden->estado_id==2) Asignado
							@elseif($orden->estado_id==3) Diagnosticado
							@elseif($orden->estado_id==4) Cerrado
							@else Cerrado
							@endif
						</div>
						<div class="col-sm-3">
							<label for="">Prioridad</label><br>
							{{ $orden->prioridad }}
						</div>
					</div>
					<br>
					@if($orden->image!=null)
						<div class="row">
							<div class="col-sm-12">
								<label for="">Descripción <a class="esconder" href="{{ asset('') }}assets/upload_correctivos/{{ $orden->image }}" target="__blank" class="glyphicon glyphicon-file lg" style="font-size: 10px;">Archivo de reporte</a></label><br>
								{{ $orden->descripcion }}
							</div>
						</div>
					@else
						<div class="row">
							<div class="col-sm-12">
								<label for="">Descripción</label><br>
								{{ $orden->descripcion }}
							</div>
						</div>
					@endif
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		@if(($orden->estado_id>=2)&&($orden->estado_id!=null)&&($orden->estado_id!=""))
			<div class="col-md-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Responsable asignado</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
							</button>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<label for="">Nombre de usuario:</label><br>
								<span style="font-size: 15px;font-family: 'New Century '">{{ $orden->asignado }}</span>
							</div>
						</div><br>
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<label for="">Fecha de asignación</label><br>
								{{ $orden->fecha_asignacion_usuario }}
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif

		@if($orden->estado_id==3)
			<div class="col-md-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Gestión</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-sm-6">
								<label for="diagnostico">DIAGNÓSTICO</label>&nbsp;
								@if(($orden->file_diagnostico!=null)&&($orden->file_diagnostico!=""))
									<a target="__blank" href="{{ base_url() }}assets/upload_correctivos/{{ $orden->file_diagnostico }}">Archivo diagnóstico</a>
								@endif
								<br>
								<strong>Fecha: </strong>{{ $orden->fecha_diagnostico }}<p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<label for="">Descripción del diagnóstico</label><br>
								{{ $orden->diagnostico }}
							</div>
							<div class="col-sm-6">
								<label for="">Conclusión del diagnóstico</label><br>
								{{ $orden->descripcion_diagnostico }}
							</div>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>
		@endif
		@if($orden->estado_id==4)
			<div class="col-md-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Gestión</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						@if($orden->asignado!=null)
							<label for="">ASIGNACIÓN</label><br>
							<label for="">Usuario Asignado:</label> {{ $orden->asignado }}<br>
							<label for="">Fecha de asignación:</label>&nbsp;({{ $orden->fecha_asignacion_usuario }})<br>
						@endif
						<label for="">DIAGNÓSTICO</label>&nbsp;
						@if(($orden->file_diagnostico!=null)&&($orden->file_diagnostico!=""))
							<a target="__blank" href="{{ base_url() }}assets/upload_correctivos/{{ $orden->file_diagnostico }}">Archivo diagnóstico</a>
						@endif<br>
						<strong>Fecha: </strong>{{ $orden->fecha_diagnostico }}<br>
						{{ $orden->diagnostico }}<br><p></p>
						<label for="">CORRECTIVO</label>&nbsp;
						@if(($orden->file_cierre!=null)&&($orden->file_cierre!=""))
							<a target="__blank" href="{{ base_url() }}assets/upload_correctivos/{{ $orden->file_cierre }}">Archivo cierre</a>
						@endif<br>
						<strong>Fecha: </strong>{{ $orden->fecha_fin }}<br>
						{{ $orden->reparacion }}
						<br>
						@if(sizeof($repuestos_relacionados)!="")
							<div class="table-responsive">
								<table>
									<tr>
										<th>Repuesto solicitado</th>
										<th>Fecha de solicitud</th>
										<th>Repuesto usado</th>
										<th>Fecha de recepción</th>
									</tr>
									@foreach($repuestos_relacionados as $repuesto_relacionado)
										<tr>
											<td>{{ $repuesto_relacionado->name }}</td>
											<td>{{ $repuesto_relacionado->fecha_solicitud_repuesto }}</td>
											<td>{{ $repuesto_relacionado->fecha_recepcion }}</td>
											<td>{{ $repuesto_relacionado->used }}</td>
										</tr>
									@endforeach
								</table>
							</div>
						@endif
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		@endif

