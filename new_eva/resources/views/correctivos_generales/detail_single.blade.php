<!-- <div class="container table-responsive"> -->
<div class="">

	<div class="panel panel-primary">
		<div class="panel-heading">
			Archivos Vinculados al correctivo
		</div>
		<div class="panel-body">
			@foreach($archivos as $archivo)
				<ul>
					<li>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-4">
										<strong>Titulo:</strong>
										<span class="text-muted">
											{{ $archivo->titulo }}
										</span><br>
										<strong>Archivo:</strong>
										<span class="text-muted">
											<a target="__blank" href="{{ url('/') }}assets/upload_correctivos_generales/{{ $archivo->file ?>"><?php echo $archivo->file }}</a>
										</span><br>
									</div>
									<div class="col-sm-4">
									</div>
									<div class="col-sm-4" style="font-size: 13px;">
										<strong>Fecha de ingreso del archivo:</strong>
										<span class="text-muted">{{ $archivo->created_at }}</span>
									</div>
								</div>

							</div>
						</div>
					</li>
				</ul>
			<?php endforeach ?>
		</div>
	</div>
	<div class="panel panel-danger">
		<div class="panel-heading">
			Información de la orden de trabajo
		</div>
		<div class="panel-body">
			<blockquote class="blockquote">
				<ul class="list-inline">
					<li class="list-inline-item">
						<strong>Codigo de la orden:</strong><small class="text-muted">{{ $correctivo->code_orden }}</small>
					</li>
					<li class="list-inline-item">
					</li>
					<li class="list-inline-item">
						<span class="badge">Fecha:</span>
						<footer class="blockquote-footer"><cite title="Fecha">{{ $correctivo->fecha_inicio }}</cite></footer>
					</li>
				</ul>
				<p>
					<strong>Descripción de la orden de trabajo:</strong><br>
					<span class="text-muted" style="font-size: 13px;">
						{{ $correctivo->orden }}
					</span>
				</p>
			</blockquote>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			Notas de avance
		</div>
		<div class="panel-body">
			<ul class="list-group">
				@foreach($avances as $avance)
					<li class="list-group-item">
						<div class="row">
							<div class="col-sm-8">
								<h5>
									<span class="glyphicon glyphicon-user"></span>
									{{ $avance->usuario }}<br>
								</h5>
								<strong>Titulo:</strong>{{ $avance->title }}
								<p style="font-size: 10px;">{{ $avance->description }}</p>
							</div>
							<div class="col-sm-1">
								@if($avance->file != null && $avance->file != "")
									<span class=""><a href="{{ url('/') ?>assets/upload_correctivos_generales/<?php echo $avance->file }}" target="__blank" class="btn btn-dark glyphicon glyphicon-file"></a></span>
								<?php endif ?>
							</div>
							<div class="col-sm-3">
								<span class="badge">Fecha:</span>
								<footer class="blockquote-footer"><cite>{{ $avance->date }}</cite></footer>
							</div>
						</div>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<div class="panel panel-success">
		<div class="panel-heading">
			Información de cierre
		</div>
		<div class="panel-body">
			<blockquote class="blockquote">
				<ul class="list-inline">
					<li class="list-inline-item">
						<strong>Retro:</strong><small class="text-muted">{{ $correctivo->code }}</small>
					</li>
					<li class="list-inline-item">
					</li>
					<li class="list-inline-item">
						<span class="badge">Fecha:</span>
						<footer class="blockquote-footer"><cite title="Fecha">{{ $correctivo->fecha_mantenimiento }}</cite></footer>
					</li>
					<li class="list-inline-item">
						<strong>Codigo de cierre:</strong>
						<span class="badge">{{ $correctivo->codigo_cierre }}</span><br>
						<span style="font-size: 10px;">{{ $correctivo->significado_codigo }}</span>
					</li>
					<li class="list-inline-item">
						<strong>Tipo de falla:</strong>
						<span>{{ $correctivo->tipo_falla }}</span><br>
					</li>
				</ul>
				<p>
					<strong>Descripción del trabajo realizado:</strong><br>
					<span class="text-muted" style="font-size: 13px;">
						{{ $correctivo->description }}
					</span>
				</p>
			</blockquote>
		</div>
	</div>
</div>