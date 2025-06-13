function funcion_show_cambios_ubicaciones(equipo_id) {
	$.ajax({
		url: `${base_url}ubicacion/Ccambios_ubicaciones/show_cambios_ubicaciones`,
		type: 'post',
		data: { equipo_id: equipo_id },
	}).done(function (data) {
		$('#modal_show_cambios_ubicaciones .box-body').html(data);
	});
}
