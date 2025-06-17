		<p></p>

		@php
		if (!empty($correctivos)) {
			$correctivos = $correctivos[0];
		}
		if (!empty($correctivos_generales)) {
			$correctivos_generales = $correctivos_generales[0];
		}
		if (!empty($preventivos)) {
			$preventivos = $preventivos[0];
		}
		if (!empty($calibraciones)) {
			$calibraciones = $calibraciones[0];
		}
		if (!empty($especificaciones)) {
			$especificaciones = $especificaciones[0];
		}
		if (!empty($contactos)) {
			$contactos = $contactos[0];
		}
		@endphp

		<div class="table-responsive impresion" id="contenedor_detalle_equipo">

			<div class="tg-wrap"><table class="tg">
				<tr><th class="text-center"><div class="logo-hospital"> <img src="{{ asset('assets/template/logo_hospital.jpg') }}" width="100px;" height="100px;"></div></th>
					<th class="tg-5xx9" colspan="10">FORMATO DE HOJA DE VIDA PARA EQUIPOS BIOMÉDICOS HOSPITAL UNIVERSITARIO DEL VALLE “EVARISTO GARCÍA”</th>
				</tr>
				<tr>
					<td class="tg-d4yz" colspan="10">IDENTIFICACIÓN DEL EQUIPO/ ID:{{ $equipo->id }}</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Nombre del equipo:</td>
					<td class="tg-0pky text-center" colspan="4">{{ $equipo->name }}</td>
					<td class="tg-dxek" colspan="5">IMAGEN RELACIONADA DEL EQUIPO</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Serie:</td>
					<td class="tg-0pky text-center" colspan="4">{{ $equipo->serial }}</td>
					<td class="tg-ng7p" colspan="5" rowspan="9">
						<img class="" width="350px" height="280px" src="{{ asset('assets/upload_imagenes/' . $equipo->image) }}" alt="">
					</td>
				</tr>
				<tr>
					<td class="tg-g8x9">INV/Activo:</td>
					<td class="tg-fymr">Antiguo:</td>
					<td class="tg-0pky">{{ $equipo->codigo_antiguo }}</td>
					<td class="tg-fymr">Nuevo:</td>
					<td class="tg-0pky">{{ $equipo->code }}</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Marca:</td>
					<td class="tg-0pky" colspan="4">{{ $equipo->marca }}</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Modelo:</td>
					<td class="tg-0pky" colspan="4">{{ $equipo->modelo }}</td>
				</tr>
				<tr>
					<td class="tg-g8x9">R.Invima:</td>
					<td class="tg-0pky" colspan="4">{{ $equipo->invima }}
					@if($equipo->archivo_invima != null)
						<a target="__blank" class="glyphicon glyphicon-file esconder" href="{{ asset('assets/upload_invimas/' . $equipo->archivo_invima) }}"></a>
					@endif
					</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Ubicación:</td>
					<td class="tg-0pky" colspan="4">{{ $equipo->servicios }}</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Piso:</td>
					<td class="tg-0pky" colspan="2">{{ $equipo->pisos }}</td>
					<td class="tg-0pky"><span style="font-weight:700">Centro de costo:</span></td>
					<td class="tg-0pky">{{ $equipo->centro }}</td>
				</tr>
				<tr>
					<td class="tg-g8x9">Equipo (Movil/fijo):</td>
					<td class="tg-0pky" colspan="2">{{ $equipo->movilidad }}</td>
					<td class="tg-0pky"><span style="font-weight:700">Pais de origen:</span></td>
					<td class="tg-0pky"></td>
				</tr>
				<tr>
					<td class="tg-d4yz" colspan="5">REGISTRO HISTORICO</td>
				</tr>
				<tr>
					<td class="tg-0akb">Forma de adquisición:</td>
					<td class="tg-0pky" colspan="3">{{ $equipo->adquisiciones }}</td>
					<td class="tg-0pky"><span style="font-weight:700">Garantia:</span></td>
					<td class="tg-0akb" colspan="5">{{ $equipo->garantias }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Activo comodato:</td>
					<td class="tg-0pky" colspan="9">{{ $equipo->activo_comodato }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Fecha de adquisición:</td>
					<td class="tg-0pky" colspan="2">{{ ($equipo->fecha_ad == "0000-00-00" || $equipo->fecha_ad == "" || $equipo->fecha_ad == null) ? "aaaa-mm-dd" : $equipo->fecha_ad }}</td>
					<td class="tg-pwly"><span style="font-weight:700">Fecha acta de recibo:</span></td>
					<td class="tg-0pky" colspan="6">{{ ($equipo->fecha_acta_recibo == "0000-00-00" || $equipo->fecha_acta_recibo == "" || $equipo->fecha_acta_recibo == null) ? "aaaa-mm-dd" : $equipo->fecha_acta_recibo }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Fecha de instalación:</td>
					<td class="tg-0pky" colspan="2">{{ ($equipo->fecha_instalacion == "0000-00-00" || $equipo->fecha_instalacion == "" || $equipo->fecha_instalacion == null) ? "aaaa-mm-dd" : $equipo->fecha_instalacion }}</td>
					<td class="tg-pwly"><span style="font-weight:700">Fecha de inicio operación:</span></td>
					<td class="tg-0pky" colspan="6">{{ ($equipo->fecha_inicio_operacion == "0000-00-00" || $equipo->fecha_inicio_operacion == "" || $equipo->fecha_inicio_operacion == null) ? "aaaa-mm-dd" : $equipo->fecha_inicio_operacion }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Fecha de vencimiento garantia:</td>
					<td class="tg-0pky" colspan="2">{{ ($equipo->fecha_vencimiento_garantia == "0000-00-00" || $equipo->fecha_vencimiento_garantia == "" || $equipo->fecha_vencimiento_garantia == null) ? "aaaa-mm-dd" : $equipo->fecha_vencimiento_garantia }}</td>
					<td class="tg-pwly"><span style="font-weight:700">Fecha de fabricación:</span></td>
					<td class="tg-0pky" colspan="6">{{ ($equipo->fecha_fabricacion == "0000-00-00" || $equipo->fecha_fabricacion == "" || $equipo->fecha_fabricacion == null) ? "aaaa-mm-dd" : $equipo->fecha_fabricacion }}</td>
				</tr>
				<tr>
					<td class="tg-0lax"><span style="font-weight:700">Fecha recepción almacen:</span></td>
					<td class="tg-0lax" colspan="9">{{ ($equipo->fecha_recepcion_almacen == "0000-00-00" || $equipo->fecha_recepcion_almacen == "" || $equipo->fecha_recepcion_almacen == null) ? "aaaa-mm-dd" : $equipo->fecha_recepcion_almacen }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Costo:</td>
					<td class="tg-0pky" colspan="2">{{ ($equipo->costo) == 0 ? "" : $equipo->costo }}</td>
					<td class="tg-0akb">Vida util:</td>
					<td class="tg-0pky" colspan="6">{{ $equipo->vida_util }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Información de Fabricantes/<br>Proveedores/<br>Distribuidores</td>
					<td class="tg-0pky" colspan="9">
						@if(!empty($contactos))
							<div class="col-sm-12 col-md-12 col-lg-12 {{ empty($contactos) ? 'esconder' : '' }}">
								<table class="table table-bordered tblEquipo_contactos">
									<thead>
										<tr>
											<!-- <th>ID</th> -->
											<th>Nombre</th>
											<th>Email</th>
											<th>Telefono</th>
											<th>Tipo</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						@endif
					</td>
				</tr>
				<tr>
					<td class="tg-anza" colspan="10"><span style="font-weight:bold">REGISTRO TECNICO DE INSTALACIÓN Y FUNCIONAMIENTO</span></td>
				</tr>
				<tr>
					<td class="tg-0akb" colspan="2">Fuente de alimentación:</td>
					<td class="tg-0pky" colspan="8">{{ $equipo->fuentes }}</td>
				</tr>
				<tr>
					<td class="tg-0akb" colspan="2">Tecnologia predominante:</td>
					<td class="tg-0pky" colspan="8">{{ $equipo->tecnologias }}</td>
				</tr>
				<tr>
					<td class="tg-46fy" rowspan="3">Especificaciones Tecnicas:</td>
					<td class="tg-0pky" colspan="9" rowspan="3">
						@if(!empty($especificaciones))
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 {{ empty($especificaciones) ? 'esconder' : '' }}">
									<table id="tabla_especificacion_detail" class="table table-bordered tblEquipo_especificaciones">
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						@endif
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
					<td class="tg-0akb">Evaluación de desempeño:</td>
					<td class="tg-0pky">{{ $equipo->evaluacion_desempenio }}</td>
					<td class="tg-0akb">Se realiza calibración ?</td>
					<td class="tg-0pky">{{ $equipo->calibracion }}</td>
					<td class="tg-0akb">Periodicidad</td>
					<td class="tg-0pky" colspan="5">{{ $equipo->periodicidad }}</td>
				</tr>
				<tr>
					<td class="tg-0akb">Frecuencia de mantenimiento:</td>
					<td class="tg-0pky" colspan="9">{{ $equipo->frecuencias }}</td>
				</tr>
				<tr class="esconder">
					<td class="tg-0akb" colspan="3">Fecha Programada de mantenimiento:</td>
					<td class="tg-0pky">{{ ($equipo->fecha_mantenimiento == "0000-00-00" || $equipo->fecha_mantenimiento == "" || $equipo->fecha_mantenimiento == null) ? "" : $equipo->fecha_mantenimiento }}</td>
					<td class="tg-0akb">Estado actual del equipo:</td>
					<td class="tg-0pky" colspan="5">{{ $equipo->estadoequipos }}</td>
				</tr>
				<tr>
					<td class="tg-quvk">Mes programado 1:</td>
					<td class="tg-0pky">{{ $equipo->v1 }}</td>
					<td class="tg-0pky"><span style="font-weight:700">Mes programado 2:</span></td>
					<td class="tg-quvk">{{ $equipo->v2 }}</td>
					<td class="tg-0pky"><span style="font-weight:700">Mes programado 3:</span></td>
					<td class="tg-quvk" colspan="5">{{ $equipo->v3 }}</td>
				</tr>
				<tr>
					<td class="tg-x39a" colspan="10">REGISTRO DE APOYO TÉCNICO</td>
				</tr>
				<tr>
					<td class="tg-ql13" colspan="3">Manuales:</td>
					<td class="tg-ql13" colspan="7">Planos:</td>
				</tr>
				<tr>
					<td class="tg-0pky" colspan="3" rowspan="3">
						@if($equipo->manual != null && $equipo->manual != "N;")
							@php
								$manuales = unserialize($equipo->manual);
								echo "<ul>";
								foreach ($manuales as $manual) {
									echo "<li>".$manual."</li>";
								}
								echo "</ul>";
							@endphp
						@endif
					</td>
					<td class="tg-0pky" colspan="7" rowspan="3">
						@if($equipo->plano != null && $equipo->plano != "N;")
							@php
								$planos = unserialize($equipo->plano);
								echo "<ul>";
								foreach ($planos as $plano) {
									echo "<li>".$plano."</li>";
								}
								echo "</ul>";
							@endphp
						@endif
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
					<td class="tg-46fy" colspan="2">Clasificación biomedica:</td>
					<td class="tg-0pky" colspan="2">{{ $equipo->clasificaciones }}</td>
					<td class="tg-0pky"><span style="font-weight:700">Clasificación de acuerdo al riesgo:</span></td>
					<td class="tg-0pky" colspan="5">{{ $equipo->criesgos }}</td>
				</tr>
				<tr>
					<td class="tg-hk8r" colspan="10">COMPONENTES</td>
				</tr>
				<tr>
					<td class="tg-0pky" colspan="10" rowspan="3">
						<div class="col-sm-3 col-md-3">
							@if($equipo->accesorios != null && $equipo->accesorios != "")
								{!! nl2br($equipo->accesorios) !!}
							@else
								<br><p></p><p></p>
							@endif
						</div>
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
					<td class="tg-x39a" colspan="10">SEGUIMIENTO</td>
				</tr>
				<tr>
					<td class="tg-0akb" colspan="2">Pertenencia:</td>
					<td class="tg-0pky" colspan="2">{{ $equipo->propiedad }}</td>
					<td class="tg-0akb">Otros:</td>
					<td class="tg-0pky" colspan="5">{{ $equipo->otros }}</td>
				</tr>
				<tr>
					<td class="tg-gj0n" colspan="10">OBSERVACIONES</td>
				</tr>
				<tr>
					<td class="tg-0lax" colspan="10">
						@if($equipo->observacion != null && $equipo->observacion != "")
							{!! nl2br($equipo->observacion) !!}
						@else
							<br><p></p>
						@endif
					</td>
				</tr>
				@if(!empty($correctivos))
					<tr>
						<td class="tg-gj0n" colspan="10">CORRECTIVOS TICKETS</td>
					</tr>
					<tr>
						<td class="tg-0lax" colspan="10">
							<table class="table table-bordered tblCorrectivos">
								<thead>
									<tr>
										<!-- <th>ID</th> -->
										<th>Id Orden</th>
										<th>Descripcion</th>
										<th>Estado</th>
										<th class="esconder">ARCHIVO RELACIONADO</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
				@endif
				@if(!empty($correctivos_generales))
					<tr>
						<td class="tg-gj0n" colspan="10">OTROS CORRECTIVOS</td>
					</tr>
					<tr>
						<td class="tg-0lax" colspan="10">
							<table class="table table-bordered tblCorrectivosGenerales">
								<thead>
									<tr>
										<!-- <th>ID</th> -->
										<th>Numero de correctivo</th>
										<th>Descripcion</th>
										<th>Fecha de correctivo</th>
										<th class="esconder">ARCHIVO RELACIONADO</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
				@endif
				@if(!empty($preventivos))
					<tr>
						<td class="tg-gj0n" colspan="10">PREVENTIVOS</td>
					</tr>
					<tr>
						<td class="tg-0lax" colspan="10">
							<table class="table table-bordered tblPreventivos">
								<thead>
									<tr>
										<!-- <th>ID</th> -->
										<th>NRO MANTENIMIENTO</th>
										<th>FECHA DE EJECUCION</th>
										<th>FECHA PROGRAMADA</th>
										<th class="esconder">ARCHIVO RELACIONADO</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
				@endif

				@if(!empty($calibraciones))
					<tr>
						<td class="tg-gj0n" colspan="10">CALIBRACIONES</td>
					</tr>
					<tr>
						<td class="tg-0lax" colspan="10">
							<table class="table table-bordered tblCalibraciones">
								<thead>
									<tr>
										<!-- <th>ID</th> -->
										<th>NRO CALIBRACION</th>
										<th>FECHA DE EJECUCION</th>
										<th>FECHA PROGRAMADA</th>
										<th class="esconder">ARCHIVO RELACIONADO</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</td>
					</tr>
				@endif
				@if(!empty($archivos))
					<tr>
						<td class="tg-gj0n" colspan="10">ARCHIVOS ASOCIADOS</td>
					</tr>
					<tr>
						<td class="tg-0lax" colspan="10">
							<div class="text-center">
								<ul>
									@foreach($archivos as $archivo_singular)
										<li >
											<?php echo $archivo_singular->archivo; ?><a target="__blank" class="glyphicon glyphicon-file esconder" href="<?=base_url();?>assets/upload_equipo_archivos/<?php echo $archivo_singular->vinculo;?>"></a>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
						</td>
					</tr>
				@endif
			</table></div>
		</div>

