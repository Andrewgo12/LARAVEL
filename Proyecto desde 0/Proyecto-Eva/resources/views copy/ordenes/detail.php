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
					<strong>Nombre:</strong> <?=$orden->nombre;?><br>
					<strong>Apellido:</strong> <?=$orden->apellido;?><br>
					<strong>Telefono:</strong> <?=$orden->telefono;?><br>
					<strong>Correo electronico:</strong> <?=$orden->email;?><br>
					<strong>Centro de costo:</strong> <?=$orden->centro;?><br>

					<?php if ($orden->nombre_reportante!="" && $orden->nombre_reportante!=null): ?>
						<br>
						<label style="font-size: 15px;" for="">Se relaciona la información del siguiente reportante:</label><br>
					<strong>Nombre:</strong> <?=$orden->nombre_reportante;?><br>
					<strong>centro de Costo:</strong> <?=$orden->centro_costo_reportante;?><br>

					<?php endif ?>
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
					<strong>Ubicación:</strong> <?=$orden->servicio;?><br>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<?php if ($orden->subproceso_id==1): ?>
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
							<tr><th>Nombre del equipo:</th><td><?=$orden->nombre_equipo;?></td></tr>
							<tr><th>Modelo:</th><td><?=$orden->modelo_equipo;?></td></tr>
							<tr><th>Serie:</th><td><?=$orden->serie_equipo;?></td></tr>
							<tr><th>Codigo:</th><td><?=$orden->codigo_equipo;?></td></tr>
							<tr><th>Marca:</th><td><?=$orden->marca_equipo;?></td></tr>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		<?php endif ?>
		<?php if ($orden->subproceso_id==2): ?>
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
						<strong>subproceso:</strong> Mantenimiento industrial<br>

					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		<?php endif ?>
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Descripcion del ticket Nro <?= $orden->id;?></h3>
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
							<label >Asunto</label><br>
							<?php echo $orden->asunto; ?>
						</div>
						<div class="col-sm-2"></div>
						<div class="col-sm-5">
							<label >Fecha de creación: <?= $orden->fecha_inicio;?></label>
						</div>
					</div><br>

					<div class="row">
						<div class="col-sm-5">
							<strong>estado actual </strong><br>
							<?php if ($orden->estado_id==1): ?>	Creado
							<?php elseif($orden->estado_id==2): ?> Asignado
							<?php elseif($orden->estado_id==3): ?> Diagnosticado
							<?php elseif($orden->estado_id==4): ?> Cerrado
							<?php else: ?>Cerrado
						<?php endif; ?>
					</div>
					<div class="col-sm-3">
						<label for="">Prioridad</label><br>
						<?php echo $orden->prioridad; ?>
					</div>
				</div>
				<br>
				<?php if ($orden->image!=null): ?>
					<div class="row">
						<div class="col-sm-12">
							<label for="">Descripción <a class="esconder" href="<?php echo base_url();?>assets/upload_correctivos/<?php echo $orden->image;?>" target="__blank" class="glyphicon glyphicon-file lg" style="font-size: 10px;">Archivo de reporte</a></label><br>
							<?=$orden->descripcion;?>								
						</div>
					</div>
					<?php else: ?>
						<div class="row">
							<div class="col-sm-12">
								<label for="">Descripción</label><br>
								<?=$orden->descripcion;?>								
							</div>
						</div>
					<?php endif ?>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<?php if (($orden->estado_id>=2)&&($orden->estado_id!=null)&&($orden->estado_id!="")): ?><!-- Si esta asignado o se ha hecho gestion -->
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
							<span style="font-size: 15px;font-family: 'New Century '"><?=$orden->asignado;?></span>
						</div>
					</div><br>
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<label for="">Fecha de asignacion</label><br>
							<?=$orden->fecha_asignacion_usuario;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>

	<?php if ($orden->estado_id==3): ?>

		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Gestion</h3>
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
							<label for="diagnostico">DIAGNOSTICO</label>&nbsp;
							<?php if (($orden->file_diagnostico!=null)&&($orden->file_diagnostico!="")): ?>
							<a target="__blank" href="<?=base_url();?>assets/upload_correctivos/<?=$orden->file_diagnostico;?>">Archivo diagnostico</a>
						<?php endif ?>
						<br>
						<strong>Fecha: </strong><?=$orden->fecha_diagnostico?><p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label for="">Descripción del diagnostico</label><br>
							<?=$orden->diagnostico;?>
						</div>
						<div class="col-sm-6">
							<label for="">Conclusion del diagnostico</label><br>	
							<?=$orden->descripcion_diagnostico;?>

						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		<?php endif ?>
		<?php if ($orden->estado_id==4): ?>

			<div class="col-md-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">

						<h3 class="box-title">Gestion</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse">
							</button>
						</div>
						<!-- /.box-tools -->
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<?php if ($orden->asignado!=null): ?>
							<label for="">ASIGNACION</label><br>
							<label for="">Usuario Asignado:</label> <?=$orden->asignado;?><br>
							<label for="">Fecha de asignación:</label>&nbsp;(<?=$orden->fecha_asignacion_usuario;?>)<br>
						<?php endif ?>
						<label for="">DIAGNOSTICO</label>&nbsp;
						<?php if (($orden->file_diagnostico!=null)&&($orden->file_diagnostico!="")): ?>
						<a target="__blank" href="<?=base_url();?>assets/upload_correctivos/<?=$orden->file_diagnostico;?>">Archivo diagnostico</a>
						<?php endif ?><br>
						<strong>Fecha: </strong><?=$orden->fecha_diagnostico?><br>
						<?=$orden->diagnostico;?><br><p></p>
						<label for="">CORRECTIVO</label>&nbsp;
						<?php if (($orden->file_cierre!=null)&&($orden->file_cierre!="")): ?>
						<a target="__blank" href="<?=base_url();?>assets/upload_correctivos/<?=$orden->file_cierre;?>">Archivo cierre</a>
						<?php endif ?><br>
						<strong>Fecha: </strong><?=$orden->fecha_fin?><br>
						<?=$orden->reparacion;?>
						<br>
						<?php if (sizeof($repuestos_relacionados)!=""): ?>
							<div class="table-responsive"><table>
								<tr>
									<th>Repuesto solicitado</th>
									<th>Fecha de solicitud</th>
									<th>Repuesto usado</th>
									<th>Fecha de recepcion</th>
								</tr>
								<?php foreach ($repuestos_relacionados as $repuesto_relacionado): ?>
									<tr>
										<td><?php echo $repuesto_relacionado->name; ?></td>
										<td><?php echo $repuesto_relacionado->fecha_solicitud_repuesto; ?></td>
										<td><?php echo $repuesto_relacionado->fecha_recepcion; ?></td>
										<td><?php echo $repuesto_relacionado->used; ?></td>
									</tr>
								<?php endforeach ?>
							</table></div>
						<?php endif ?>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		<?php endif ?>

