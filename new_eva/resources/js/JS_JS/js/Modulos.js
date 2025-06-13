function restablecer(modulo_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'Cmodulos/setear_acciones',
		type: 'post',
		data: { modulo_id: modulo_id },
	}).done(function (data) {
		tabla_modulos();
	});
}

function tabla_modulos() {
	$.ajax({
		url: base_url + 'Cmodulos/getWithAccount',
		type: 'post',
		data: {},
	}).done(function (data) {
		var modulos = JSON.parse(data);
		var tmp = '';
		$.each(modulos, function (i, modulo) {
			tmp +=
				`
				<tr>
					<td>` +
				modulo.id +
				`</td>
					<td>` +
				modulo.name +
				`</td>
					<td>` +
				modulo.cantidad +
				`</td>
					<td><a onclick="restablecer(` +
				modulo.id +
				`,event)" title="Restablecer permisos" href=""><i class="fa fa-repeat"></i></a></td>
				</tr>
			`;
		});
		$('.tblModulos tbody').html(tmp);
	});
}
