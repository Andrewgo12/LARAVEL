
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="http://asamblea.valledelcauca.gov.co/info/asamblea/media/pub43460.jpg" width="300" height="230" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b> <h2>Ticket Nro <?php echo $orden->id; ?></h2> </b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0;color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">


										<p><h3>Eva Gestiona la tecnologia</h3></p>
										<h4>Asunto:&nbsp;</h4><?php echo $orden->asunto; ?>
										<blockquote>
											<h4>Descripcion</h4>
											<p><?php echo $orden->descripcion; ?></p>
											<footer style="font-size: 10px;"><strong>Fecha de diagnostico</strong>: <?php echo $orden->fecha_diagnostico; ?></footer>
											<h4>Diagnostico</h4>    <p><?php echo $orden->diagnostico; ?></p>

											@if($orden->tecnico_diagnostico_text!=null)
												<h4>Tecnico Diagnostico:</h4><p>
													<?php echo $orden->tecnico_diagnostico_text; ?>
												</p> 
											<?php endif ?>
											@if($orden->tecnico_diagnostico_text==null)
												<h4>Usuario que registra el diagnostico:</h4><p>
													<?php  echo $usuario_diagnostico->nombre." "; echo $usuario_diagnostico->apellido." ";?>
													<h4><p><?php echo "Email empresa: ".$usuario_diagnostico->email_empresa; ?></p></h4>
												<?php endif ?>
													<h4>Codificación del Diagnostico: <?php echo $orden->codigo_diagnostico; ?></h4>
													<?php echo $orden->descripcion_diagnostico; ?>

											<h4>Informe cierre</h4> <p><?php echo $orden->reparacion; ?></p>	
												@if($orden->tecnico_cierre_text!=null)
													<h4>Tecnico Cierre:</h4><p>
														<?php echo $orden->tecnico_cierre_text; ?>
													</p> 
													
												<?php endif ?>
												@if($orden->tecnico_cierre_text==null)
													<h4>Usuario que registra el cierre:</h4><p>
														<?php  echo $usuario->nombre." "; echo $usuario->apellido." ";?>
														<h4><p><?php echo "Email empresa: ".$usuario->email_empresa; ?></p></h4>
													<?php endif ?>												

													<h4>Codificación del Cierre: <?php echo $orden->codigo_cierre; ?></h4>
													<?php echo $orden->descripcion_cierre; ?>

													
													<h4>Fecha en que se envia a cierre la orden:</h4> <p><?php echo $orden->fecha_asignacion_cierre; ?></p>
													
													<h4></p>
												</blockquote>
												<ul>
													<li style="font-size: 15px"><strong>Nombre del equipo </strong>: <?php echo  $orden->nombre_equipo; ?></li>
													<li style="font-size: 15px"><strong>Marca del equipo </strong>: <?php echo  $orden->marca_equipo; ?></li>
													<li style="font-size: 15px"><strong>Modelo del equipo </strong>: <?php echo  $orden->modelo_equipo; ?></li>
													<li style="font-size: 15px"><strong>Activo fijo del equipo </strong>: <?php echo  $orden->codigo_equipo; ?></li>
													<li style="font-size: 15px"><strong>Serie del equipo </strong>: <?php echo  $orden->serie_equipo; ?></li>
													<li style="font-size: 15px"><strong>Prioridad </strong>: <?php echo  $orden->prioridad; ?></li>
												</ul>
												<h4>Asignado a la empresa:</h4><?php echo $empresa[0]->name; ?>
												<h3>Enlace para confirmar cierre de orden: </h3>
												<a href='{{ asset('') }}orden/Cordenes/activate/<?php echo $orden->id ?>/<?php echo $orden->code ?>'>Cerrar Orden</a>

											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
									&reg; Electromedicina,  2019<br/>
									<a href="#" style="color: #ffffff;"><font color="#ffffff"></font></a>Hospital Universitario del valle
								</td>
								<td align="right" width="25%">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
												<a href="http://www.twitter.com/" style="color: #ffffff;">
													<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
												</a>
											</td>
											<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
											<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
												<a href="http://www.fb.com/" style="color: #ffffff;">
													<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
												</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
