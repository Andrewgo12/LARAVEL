		<div class="">
			<p></p>

			<?php 
			if (!empty($correctivos)) {
				$correctivos_original=$correctivos; 
				$correctivos=$correctivos[0]; 
			}
			if (!empty($correctivos_generales)) {
				$correctivos_generales_original=$correctivos_generales; 
				$correctivos_generales=$correctivos_generales[0]; 
			}
			if (!empty($preventivos)) {
				$preventivos_original=$preventivos;
				$preventivos=$preventivos[0]; 
			}
			if (!empty($calibraciones)) {
				$calibraciones_original=$calibraciones; 
				$calibraciones=$calibraciones[0]; 

			}
			if (!empty($especificaciones)) {
				$especificaciones_original=$especificaciones; 
				$especificaciones=$especificaciones[0]; 
			}
			if (!empty($contactos)) {
				$contactos_original=$contactos; 
				$contactos=$contactos[0]; 
			}



			?>


			<div class="table-responsive" id="contenedor_detalle_equipo">

				<div class="tg-wrap"><table class="tg">
					<tr><th class="text-center"><div class="logo-hospital"> <img src="<?=base_url();?>assets/template/logo_hospital.jpg" width="100px;" height="100px;"></div></th>
						<th class="tg-5xx9" colspan="10">FORMATO DE HOJA DE VIDA PARA EQUIPOS BIOMÉDICOS HOSPITAL UNIVERSITARIO DEL VALLE “EVARISTO GARCÍA”</th>
					</tr>
					<tr>
						<td class="tg-d4yz" colspan="10">IDENTIFICACIÓN DEL EQUIPO</td>
					</tr>
					<tr>
						<td class="tg-g8x9">Nombre del equipo:</td>
						<td class="tg-0pky text-center" colspan="4"><?php echo $equipo->name; ?></td>
						<td class="tg-dxek" colspan="5">IMAGEN RELACIONADA DEL EQUIPO</td>
					</tr>
					<tr>
						<td class="tg-g8x9">Serie:</td>
						<td class="tg-0pky text-center" colspan="4"><?php echo $equipo->serial; ?></td>
						<td class="tg-ng7p" colspan="5" rowspan="9">
							<img  class="" width="350px" height="280px" src="{{ asset('') }}assets/upload_imagenes/<?php echo $equipo->image;?>" alt="">
						</td>
					</tr>
					<tr>
						<td class="tg-g8x9">INV/Activo:</td>
						<td class="tg-fymr">Antiguo:</td>
						<td class="tg-0pky"><?php echo $equipo->codigo_antiguo; ?></td>
						<td class="tg-fymr">Nuevo:</td>
						<td class="tg-0pky"><?php echo $equipo->code; ?></td>
					</tr>
					<tr>
						<td class="tg-g8x9">Marca:</td>
						<td class="tg-0pky" colspan="4"><?php echo $equipo->marca; ?></td>
					</tr>
					<tr>
						<td class="tg-g8x9">Modelo:</td>
						<td class="tg-0pky" colspan="4"><?php echo $equipo->modelo; ?></td>
					</tr>
					<tr>
						<td class="tg-g8x9">R.Invima:</td>
						<td class="tg-0pky" colspan="4"><?php echo $equipo->invima; ?>
							@if($equipo->archivo_invima!=null)
								<a target="__blank" class="glyphicon glyphicon-file esconder" href="{{ asset('') }}assets/upload_invimas/<?php echo $equipo->archivo_invima;?>"></a>

							<?php endif ?>

						</td>
					</tr>
					<tr>
						<td class="tg-g8x9">Ubicación:</td>
						<td class="tg-0pky" colspan="4"><?php echo $equipo->servicios; ?></td>
					</tr>
					<tr>
						<td class="tg-g8x9">Piso:</td>
						<td class="tg-0pky" colspan="2"><?php echo $equipo->pisos; ?></td>
						<td class="tg-0pky"><span style="font-weight:700">Centro de costo:</span></td>
						<td class="tg-0pky"><?php echo $equipo->centro; ?></td>
					</tr>
					<tr>
						<td class="tg-g8x9">Equipo (Movil/fijo):</td>
						<td class="tg-0pky" colspan="2"><?php echo $equipo->movilidad; ?></td>
						<td class="tg-0pky"><span style="font-weight:700">Pais de origen:</span></td>
						<td class="tg-0pky"></td>
					</tr>
					<tr>
						<td class="tg-d4yz" colspan="5">REGISTRO HISTORICO</td>
					</tr>
					<tr>
						<td class="tg-0akb">Forma de adquisición:</td>
						<td class="tg-0pky" colspan="3"><?php echo $equipo->adquisiciones; ?></td>
						<td class="tg-0pky"><span style="font-weight:700">Garantia:</span></td>
						<td class="tg-0akb" colspan="5"><?php echo $equipo->garantia; ?></td>
					</tr>
					<tr>
						<td class="tg-0akb">Activo comodato:</td>
						<td class="tg-0pky" colspan="9"><?php echo $equipo->activo_comodato; ?></td>
					</tr>
					<tr>
						<td class="tg-0akb">Fecha de adquisición:</td>
						<td class="tg-0pky" colspan="2"><?php echo ($equipo->fecha_ad=="0000-00-00"||$equipo->fecha_ad==""||$equipo->fecha_ad==null)?"aaaa-mm-dd":$equipo->fecha_ad; ?></td>
						<td class="tg-pwly"><span style="font-weight:700">Fecha acta de recibo:</span></td>
						<td class="tg-0pky" colspan="6"><?php echo ($equipo->fecha_acta_recibo=="0000-00-00"||$equipo->fecha_acta_recibo==""||$equipo->fecha_acta_recibo==null)?"aaaa-mm-dd":$equipo->fecha_acta_recibo; ?></td>
					</tr>
					<tr>
						<td class="tg-0akb">Fecha de instalación:</td>
						<td class="tg-0pky" colspan="2"><?php echo ($equipo->fecha_instalacion=="0000-00-00"||$equipo->fecha_instalacion==""||$equipo->fecha_instalacion==null)?"aaaa-mm-dd":$equipo->fecha_instalacion; ?></td>
						<td class="tg-pwly"><span style="font-weight:700">Fecha de inicio operación:</span></td>
						<td class="tg-0pky" colspan="6"><?php echo ($equipo->fecha_inicio_operacion=="0000-00-00"||$equipo->fecha_inicio_operacion==""||$equipo->fecha_inicio_operacion==null)?"aaaa-mm-dd":$equipo->fecha_inicio_operacion; ?></td>
					</tr>
					<tr>
						<td class="tg-0akb">Fecha de vencimiento garantia:</td>
						<td class="tg-0pky" colspan="2"><?php echo ($equipo->fecha_vencimiento_garantia=="0000-00-00"||$equipo->fecha_vencimiento_garantia==""||$equipo->fecha_vencimiento_garantia==null)?"aaaa-mm-dd":$equipo->fecha_vencimiento_garantia; ?></td>
						<td class="tg-pwly"><span style="font-weight:700">Fecha de fabricación:</span></td>
						<td class="tg-0pky" colspan="6"><?php echo ($equipo->fecha_fabricacion=="0000-00-00"||$equipo->fecha_fabricacion==""||$equipo->fecha_fabricacion==null)?"aaaa-mm-dd":$equipo->fecha_fabricacion; ?></td>
					</tr>
					<tr>
						<td class="tg-0lax"><span style="font-weight:700">Fecha recepción almacen:</span></td>
						<td class="tg-0lax" colspan="9"><?php echo ($equipo->fecha_recepcion_almacen=="0000-00-00"||$equipo->fecha_recepcion_almacen==""||$equipo->fecha_recepcion_almacen==null)?"aaaa-mm-dd":$equipo->fecha_recepcion_almacen; ?></td>
					</tr>
					<tr>
						<td class="tg-0akb">Costo:</td>
						<td class="tg-0pky" colspan="2"><?php echo ($equipo->costo)==0?"":$equipo->costo; ?></td>
						<td class="tg-0akb">Vida util:</td>
						<td class="tg-0pky" colspan="6"><?php echo $equipo->vida_util; ?></td>
					</tr>
					<tr>
						<td class="tg-0akb">Información de Fabricantes/<br>Proveedores/<br>Distribuidores</td>
						<td class="tg-0pky" colspan="9">
							<?php if (!empty($contactos)): ?>
								<div class="col-sm-12 col-md-12 col-lg-12 <?php if (empty($contactos)): ?>
									esconder
								<?php endif ?>">
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
						</div>

					<?php endif ?>

				</td>
			</tr>
			<tr>
				<td class="tg-anza" colspan="10"><span style="font-weight:bold">REGISTRO TECNICO DE INSTALACIÓN Y FUNCIONAMIENTO</span></td>
			</tr>
			<tr>
				<td class="tg-0akb" colspan="2">Fuente de alimentación:</td>
				<td class="tg-0pky" colspan="8"><?php echo $equipo->fuentes; ?></td>
			</tr>
			<tr>
				<td class="tg-0akb" colspan="2">Tecnologia predominante:</td>
				<td class="tg-0pky" colspan="8"><?php echo $equipo->tecnologias; ?></td>
			</tr>
			<tr>
				<td class="tg-46fy" rowspan="3">Especificaciones Tecnicas:</td>
				<td class="tg-0pky" colspan="9" rowspan="3">
					<?php if (!empty($especificaciones)): ?>
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 <?php if (empty($especificaciones)): ?>
								esconder
							<?php endif ?>">
							<table id="tabla_especificacion_detail" class="table table-bordered tblEquipo_especificaciones" >
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				<?php endif ?>	
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
		</tr>
		<tr>
			<td class="tg-0akb">Evaluación de desempeño:</td>
			<td class="tg-0pky"><?php echo $equipo->evaluacion_desempenio; ?></td>
			<td class="tg-0akb">Se realiza calibración ?</td>
			<td class="tg-0pky"><?php echo $equipo->calibracion; ?></td>
			<td class="tg-0akb">Periodicidad</td>
			<td class="tg-0pky" colspan="5"><?php echo $equipo->periodicidad; ?></td>
		</tr>
		<tr>
			<td class="tg-0akb">Frecuencia de mantenimiento:</td>
			<td class="tg-0pky" colspan="9"><?php echo $equipo->frecuencias; ?></td>
		</tr>
		<tr class="esconder">
			<td class="tg-0akb" colspan="3">Fecha Programada de mantenimiento:</td>
			<td class="tg-0pky"><?php echo ($equipo->fecha_mantenimiento=="0000-00-00"||$equipo->fecha_mantenimiento==""||$equipo->fecha_mantenimiento==null)?"":$equipo->fecha_mantenimiento; ?></td></td>

			<td class="tg-0akb">Estado actual del equipo:</td>
			<td class="tg-0pky" colspan="5"><?php echo $equipo->estadoequipos; ?>
			</tr>
			<tr>
				<td class="tg-quvk">Mes programado 1:</td>
				<td class="tg-0pky"><?php echo $equipo->v1; ?></td>
				<td class="tg-0pky"><span style="font-weight:700">Mes programado 2:</span></td>
				<td class="tg-quvk"><?php echo $equipo->v2; ?></td>
				<td class="tg-0pky"><span style="font-weight:700">Mes programado 3:</span></td>
				<td class="tg-quvk" colspan="5"><?php echo $equipo->v3; ?></td>
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
					<?php 
					if (($equipo->manual!=null)&&($equipo->manual!="N;")): ?>
					<?php 
					$manuales=unserialize($equipo->manual);
					echo "<ul>";
					foreach ($manuales as $manual) {
						echo "<li>".$manual."</li>";

						// echo "<input type='checkbox' name='manual[]' id='manual' value='".$manual."'>".$manual."<br>";
					}
					echo "</ul>";
					?>
				<?php endif ?></td>
				<td class="tg-0pky" colspan="7" rowspan="3">
					<?php 
					if (($equipo->plano!=null)&&($equipo->plano!="N;")): ?>
					<?php 
					$planos=unserialize($equipo->plano);
					echo "<ul>";
					foreach ($planos as $plano) {
						echo "<li>".$plano."</li>";

						// echo "<input type='checkbox' name='manual[]' id='manual' value='".$manual."'>".$manual."<br>";
					}
					echo "</ul>";
					?>
				<?php endif ?>							
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
		</tr>
		<tr>
			<td class="tg-46fy" colspan="2">Clasificación biomedica:</td>
			<td class="tg-0pky" colspan="2"><?php echo $equipo->clasificaciones; ?></td>
			<td class="tg-0pky"><span style="font-weight:700">Clasificación de acuerdo al riesgo:</span></td>
			<td class="tg-0pky" colspan="5"><?php echo $equipo->criesgos ?></td>
		</tr>
		<tr>
			<td class="tg-hk8r" colspan="10">COMPONENTES</td>
		</tr>
		<tr>
			<td class="tg-0pky" colspan="10" rowspan="3">
				<div class="col-sm-3 col-md-3">
					@if($equipo->accesorios!=null&&$equipo->accesorios!="")
						<?php echo nl2br($equipo->accesorios); ?>
					@else
						<br><p></p><p></p>
					<?php endif ?>
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
			<td class="tg-0pky" colspan="2"><?php echo $equipo->propiedad; ?></td>
			<td class="tg-0akb">Otros:</td>
			<td class="tg-0pky" colspan="5"><?php echo $equipo->otros; ?></td>
		</tr>
		<tr>
			<td class="tg-gj0n" colspan="10">OBSERVACIONES</td>
		</tr>
		<tr>
			<td class="tg-0lax" colspan="10">
				@if($equipo->observacion!=null&&$equipo->observacion!="")
					<?php echo nl2br($equipo->observacion); ?>
				@else
					<br><p></p>
				<?php endif ?>
			</td>
		</tr>												
		<?php if (!empty($correctivos)): ?>
			<tr>
				<td class="tg-gj0n" colspan="10">CORRECTIVOS TICKETS</td>
			</tr>
			<tr>
				<td class="tg-0lax" colspan="10">
					<table class="table table-bordered tblCorrectivos" >
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
							@foreach($correctivos_original as $correctivo)
								<tr>
									<td><?php echo $correctivo->id; ?></td>
									<td><?php echo $correctivo->descripcion; ?></td>
									<td><?php echo $correctivo->estado; ?></td>
									<td>
										@if($correctivo->image!=""&&$correctivo->image!=null)

											<a  target='_blank' href='{{ asset('') }}assets/upload_correctivos/<?= $correctivo->image;?>' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span><br>

											<?php endif ?>
											@if($correctivo->file_diagnostico!=""&&$correctivo->file_diagnostico!=null)

												<a  target='_blank' href='{{ asset('') }}assets/upload_correctivos/<?= $correctivo->file_diagnostico;?>' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span><br>
												<?php endif ?>

												@if($correctivo->file_cierre!=""&&$correctivo->file_cierre!=null)

													<a  target='_blank' href='{{ asset('') }}assets/upload_correctivos/<?= $correctivo->file_cierre;?>' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span><br>

													<?php endif ?>


												</td>
											</tr>

										<?php endforeach ?>							
									</tbody>
								</table>
							</td>
						</tr>
					<?php endif ?>
					<?php if (!empty($correctivos_generales)): ?>
						<tr>
							<td class="tg-gj0n" colspan="10">OTROS CORRECTIVOS</td>
						</tr>
						<tr>
							<td class="tg-0lax" colspan="10">
								<table class="table table-bordered tblCorrectivosGenerales" >
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
										@foreach($correctivos_generales_original as $correctivo_general)
											<tr>
												<td><?php echo $correctivo_general->code; ?></td>
												<td><?php echo $correctivo_general->description; ?></td>
												<td><?php echo $correctivo_general->fecha_mantenimiento; ?></td>
												@if($correctivo_general->file!=""&&$correctivo_general->file!=null)

													<td><a  target='_blank' href='{{ asset('') }}assets/upload_correctivos_generales/<?= $correctivo_general->file;?>' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></td>
												<?php endif ?>
											</tr>

										<?php endforeach ?>									
									</tbody>
								</table>
							</td>
						</tr>
					<?php endif ?>
					<?php if (!empty($preventivos)): ?>
						<tr>
							<td class="tg-gj0n" colspan="10">PREVENTIVOS</td>
						</tr>
						<tr>
							<td class="tg-0lax" colspan="10">
								<table class="table table-bordered tblPreventivos" >
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
										@foreach($preventivos_original as $preventivo)
											<tr>
												<td><?php echo $preventivo->description; ?></td>
												<td><?php echo $preventivo->fecha_mantenimiento; ?></td>
												<td><?php echo $preventivo->fecha_programada; ?></td>
												@if($preventivo->file!=""&&$preventivo->file!=null)

													<td><a  target='_blank' href='{{ asset('') }}assets/upload_preventivos/<?= $preventivo->file;?>' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></td>
												<?php endif ?>
											</tr>

										<?php endforeach ?>
									</tbody>
								</table>
							</td>
						</tr>
					<?php endif ?>	

					<?php if (!empty($calibraciones)): ?>
						<tr>
							<td class="tg-gj0n" colspan="10">CALIBRACIONES</td>
						</tr>
						<tr>
							<td class="tg-0lax" colspan="10">
								<table class="table table-bordered tblCalibraciones" >
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
										@foreach($calibraciones_original as $calibracion)
											<tr>
												<td><?php echo $calibracion->description; ?></td>
												<td><?php echo $calibracion->fecha_calibracion; ?></td>
												<td><?php echo $calibracion->fecha_programada; ?></td>
												@if($calibracion->file!=""&&$calibracion->file!=null)

													<td><a  target='_blank' href='{{ asset('') }}assets/upload_calibraciones/<?= $calibracion->file;?>' class='btn bnt-info'><span class='glyphicon glyphicon-file'></span></td>
												<?php endif ?>
											</tr>

										<?php endforeach ?>						
									</tbody>
								</table>
							</td>
						</tr>
					<?php endif ?>
					<?php if (!empty($archivos)): ?>
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
					<?php endif ?>
				</table></div>
			</div>

		</div>