function show_cambios_hdv(equipo_id) {
	$.ajax({
		url: base_url + 'equipo/Ccambios_hdv/get_from_device',
		type: 'post',
		data: { equipo_id: equipo_id },
	}).done(function (data) {
		$('#modal_show_cambios_hdv .box-body').html(data);
	});
}
