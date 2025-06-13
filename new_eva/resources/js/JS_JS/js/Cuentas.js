function update_pwd(id, e) {
	e.preventDefault();
	if (
		$('#password').val() == '' ||
		$('#password').val() == null ||
		$('#password').val() == 'undefined'
	) {
		alert('No ha ingresado una nueva contraseña no se realizaran cambios');
	} else if ($('#password').val().length < 4) {
		alert('La contraseña debe tener por lo menos 4 caracteres de longitud');
	} else {
		var confirmar = confirm('Esta seguro de actualizar la contraseña?');
		if (confirmar) {
			$.ajax({
				url: base_url + 'administrador/Ccuentas/update_pwd',
				type: 'post',
				data: {
					password: $('#password').val(),
					id: id,
				},
			}).done(function (data) {
				alert('se ha actualizado la contraseña');
			});
		} else {
			alert('No se han realizado cambios');
		}
	}
}

function cambiar_sede($usuario_id, e) {
	e.preventDefault();
	$.ajax({
		url: base_url + 'administrador/Cusuarios/CambiarSede',
		type: 'post',
		data: { id: $usuario_id },
	}).done(function (data) {
		var respuesta = JSON.parse(data);

		$('.contenedor-cuenta .seleccion-sede').html(respuesta);
	});
}

select_seleccion_anio();
function select_seleccion_anio() {
	$.ajax({
		url: base_url + 'mantenimiento/Cplanes/getAnios',
		type: 'post',
		data: {},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		var tmp = `<option value="">---seleccione---</option>`;
		$.each(respuesta, function (i, item) {
			if (item.anio == anio_plan) {
				tmp +=
					`<option value="` +
					item.anio +
					`" selected>` +
					item.anio +
					`</option>`;
			} else {
				tmp += `<option value="` + item.anio + `">` + item.anio + `</option>`;
			}
		});
		$('.seleccion-anio-mantenimiento').html(tmp);
	});
}

$('.seleccion-anio-mantenimiento').on('change', function (e) {
	e.preventDefault();

	$.ajax({
		url: base_url + 'administrador/Cusuarios/CambiarAnio',
		type: 'post',
		data: {
			id: usuario_id,
			anio: this.value,
		},
	}).done(function (data) {
		var respuesta = JSON.parse(data);
		$('.contenedor-cuenta .anio_seleccionado_plan').html(respuesta);
	});
});

$('.cambio_sede_general').on('change', function () {
	$.ajax({
		url: base_url + 'administrador/Cusuarios/cambiar_sede_general',
		type: 'post',
		data: {
			sede_id: this.value,
			usuario_id: usuario_id,
		},
	}).done(function (data) {
		alert('la sede se ha cambiado exitosamente');
	});
});
