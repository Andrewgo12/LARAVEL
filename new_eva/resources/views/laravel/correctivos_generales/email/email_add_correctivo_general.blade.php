
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
										<b> <h2>Correctivo general Nro {{ $correctivo_general->id }}</h2> </b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">


										<p><h3>Eva Gestiona la tecnologia</h3></p>
										<h4>Codigo de orden de trabajo:&nbsp;</h4>{{ $correctivo_general->code_orden }}
										<blockquote>
											<h4>Descripcion</h4>
											<p>{{ $correctivo_general->orden }}</p>
											<footer style="font-size: 10px;"><strong>Fecha de registro</strong>: {{ $correctivo_general->fecha_inicio }}</footer>
										</blockquote>
										<blockquote>
											<h4>Ubicación de referencia</h4>
											<p>{{ $equipo->servicios }}</p>
											@if($equipo->area!=""&&$equipo->area!="null")
												<footer style="font-size: 10px;"><strong>Area</strong>: {{ $equipo->area }}</footer>
											<?php endif ?>
										</blockquote>

										<blockquote>
											<h4>Informacion del equipo</h4>
										</blockquote>
											
										<?php if (isset($equipo)): ?>
											<ul>
												<li style="font-size: 15px"><strong>Id del equipo en el sistema </strong>: {{ $equipo->id }}</li>
												<li style="font-size: 15px"><strong>Nombre del equipo </strong>: {{ $equipo->name }}</li>
												<li style="font-size: 15px"><strong>Marca del equipo </strong>: {{ $equipo->marca }}</li>
												<li style="font-size: 15px"><strong>Modelo del equipo </strong>: {{ $equipo->modelo }}</li>
												<li style="font-size: 15px"><strong>Activo fijo del equipo </strong>: {{ $equipo->code }}</li>
												<li style="font-size: 15px"><strong>Serie del equipo </strong>: {{ $equipo->serial }}</li>
											</ul>
											@else

											<?php endif ?>

											<blockquote>
												<h4>Repuesto faltante: </h4>
											</blockquote>	

											<ul class="list-inline">
												<li class="list-inline-item">
													{{ $correctivo_general->repuesto_id }}
												</li>
											</ul>

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
