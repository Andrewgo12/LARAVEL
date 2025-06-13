select_empresas();

function select_empresas() {
	$.ajax({
		url: base_url + 'administrador/Cempresas/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var asignados = JSON.parse(data);
		var tmp = "<option value=''>--Seleccione Empresa--</option>";
		$.each(asignados, function (i, item) {
			tmp += '<option value=' + item.id + '> ' + item.name + '</option>';
		});
		$('.empresa_id').html(tmp);
	});
}

//TODO ->clean email send
function funcion_email_asignar_empresa(orden_id) {
	const url = `${base_url}Cemail/email_asignar_empresa`;
	try {
		$.ajax({
			url,
			type: 'post',
			data: { orden_id },
		}).done(function (data) {
			alert(
				'Se ha enviado un correo electronico con la información del Ticket'
			);
		});
	} catch (error) {
		console.log({ error });
	}
}

function funcion_email_asignar_trabajo(orden_id) {
	$.ajax({
		url: base_url + 'Cemail/email_asignar_trabajo',
		type: 'post',
		data: { orden_id: orden_id },
	}).done(function (data) {
		alert('Se ha enviado un correo electronico con la información del Ticket');
	});
}

if (controlador == 'Cusuarios') {
	tblEmpresas();
}
function tblEmpresas() {
	$.ajax({
		url: base_url + 'administrador/Cempresas/getAll',
		type: 'post',
		data: {},
	}).done(function (data) {
		var empresas = JSON.parse(data);
		$('.contenedor-tblEmpresas').html('');

		var tmp = '';
		tmp += `
			<table class="table table-codensed table-sm table-bordered">
				<tehead>
					<tr>
						<th>Empresa</th>
						<th>Usuarios pertenecientes</th>
					</tr>
				</tehead>
				<tbody>
				`;

		$.each(empresas, function (i, item) {
			tmp +=
				`
						<tr>
							<td>` +
				item.name +
				`</td>
							<td class="usuarios_` +
				item.id +
				`">`;

			$.ajax({
				url: base_url + 'administrador/Cusuarios/getUsuariosFromEmpresa',
				type: 'post',
				data: { empresa_id: item.id },
			}).done(function (data2) {
				var usuarios = JSON.parse(data2);
				var tmp2 = '';
				$.each(usuarios, function (j, item2) {
					tmp2 +=
						`
												<div class="badge">` +
						item2.nombre +
						`(` +
						item2.username +
						`)</div>
									`;
				});
				$('.usuarios_' + item.id).html('');
				if (usuarios != undefined) {
					$('.usuarios_' + item.id).html(tmp2);
				}
			});

			tmp += `</td>
						</tr>
					`;
		});

		tmp += `
				</tbody>
			</table>

		`;
		$('.contenedor-tblEmpresas').html(tmp);
	});
}
