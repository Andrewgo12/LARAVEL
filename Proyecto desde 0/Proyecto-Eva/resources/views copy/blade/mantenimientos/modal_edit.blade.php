<div id="modal_update_plan_mantenimiento" class="modal fade" role="dialog" aria-labelledby="modalUpdatePlanTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
				<h4 class="modal-title" id="modalUpdatePlanTitle">Editar Plan de Mantenimiento</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Registro de plan de mantenimiento</h3>
							</div>

							<div class="box-body">
								<form action="{{ route('mantenimiento.planes.update') }}" name="form_update_plan_mantenimiento" class="form_update_plan_mantenimiento" enctype="multipart/form-data" method="post">
									@csrf
									<input type="hidden" id="id" name="id" class="id">

									<div class="form-group">
										<div class="row">
											@php
											$meses = [
												'' => '-------',
												'1' => 'Enero',
												'2' => 'Febrero',
												'3' => 'Marzo',
												'4' => 'Abril',
												'5' => 'Mayo',
												'6' => 'Junio',
												'7' => 'Julio',
												'8' => 'Agosto',
												'9' => 'Septiembre',
												'10' => 'Octubre',
												'11' => 'Noviembre',
												'12' => 'Diciembre'
											];
											@endphp

											@for ($i = 1; $i <= 3; $i++)
											<div class="col-md-4">
												<label for="mes{{ $i }}">Mes {{ $i }}</label>
												<select name="mes{{ $i }}" id="mes{{ $i }}" class="mes{{ $i }} form-control">
													@foreach ($meses as $value => $label)
														<option value="{{ $value }}">{{ $label }}</option>
													@endforeach
												</select>
											</div>
											@endfor
										</div>
									</div>

									<div class="form-group">
										<label for="responsable">Responsable</label>
										<input autocomplete="off" list="responsables" type="text" class="form-control responsable" id="responsable" name="responsable" placeholder="Quien realiza el mantenimiento" required>
										<datalist id="responsables" class="responsables">
											<!-- Opciones cargadas dinámicamente -->
										</datalist>
									</div>

									<div class="form-group text-right">
										<button type="submit" class="btn btn-primary btn_update_plan_mantenimiento">Actualizar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

